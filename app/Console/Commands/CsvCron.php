<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Csv;

class CsvCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Csv:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron is used to add cav records to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Csv is working fine! " . Carbon::now());

        $path = base_path() . "/csv"; // folder path
        $files = scandir($path, SCANDIR_SORT_DESCENDING);
        $check_file = $path . "/" . $files[0];
        if (date('Y-m-d')  === date('Y-m-d', filectime($check_file))) {
            Csv::query()->truncate();
            foreach ($files as $file) {
                $newest_file = $path . "/" . $file; // file path
                if (date('Y-m-d')  === date('Y-m-d', filectime($newest_file))) {  //get latest files
                    $row = 0;
                    $cols = [];
                    if (($handle = fopen($newest_file, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $row++;

                            if ($row == 1) {
                                foreach ($data as $value) {
                                    $value = str_replace("- ", "_", $value);
                                    $value = str_replace("-", "_", $value);
                                    $value = str_replace("/", "_", $value);
                                    $value = str_replace(" #", "", $value);
                                    $cols[] = strtolower(str_replace(" ", "_", $value));  // get titles
                                }
                                $cols[] = 'ratio';
                            } else {

                                $stock_number = array_search('stock_number', $cols);
                                $lab_key = array_search('lab_grown_natural', $cols);
                                $dimension_key = array_search('dimension', $cols);
                                $ratio_key = array_search('ratio', $cols);
                                $data[$ratio_key] = 0;
                                $lab_val = $data[$lab_key];
                                $ratio = 0;
                                $ratio_val = $data[$dimension_key];
                                $data[$stock_number] = str_replace(" ", "", $data[$stock_number]);

                                if (!empty($data[$dimension_key])) {
                                    $ratio_val = explode("|", $ratio_val);
                                    $data[$ratio_key] = $ratio_val[0] - $ratio_val[1];
                                    if ($data[$ratio_key] < 0) {
                                        $data[$ratio_key] = $ratio_val[1] - $ratio_val[0];
                                    }
                                }


                                if ($lab_val == "NATURAL") {
                                    $data[$lab_key] = 1;
                                } else {
                                    $data[$lab_key] = 0;
                                }

                                $existingRecord = Csv::where("stock_number", $data[$stock_number])->first();

                                if ($existingRecord) {

                                    foreach ($cols as $index => $val) {

                                        if (isset($data[$index])) {
                                            $existingRecord->$val = $data[$index];
                                        } else {
                                            die($val);
                                        }
                                    }
                                    $existingRecord->file_name = $file;
                                    $existingRecord->save();
                                } else {

                                    $csv = new Csv;
                                    foreach ($cols as $index => $val) {

                                        if (isset($data[$index])) {
                                            $csv->$val = $data[$index];
                                        } else {
                                            die($val);
                                        }
                                    }
                                    $csv->file_name = $file;
                                    $csv->save();
                                }


                                sleep(0.5);
                            }
                        }
                        fclose($handle);
                    }
                }
            }
        }
    }
}
