<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
class PurchaseCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Purchase:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron is used to change csv_records status';

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
       // \Log::info("Purchase is working fine! " . Carbon::now());

        $results = DB::table('purchased_diamond')->get();
        foreach ($results as $result) {
          $stockNumber = $result->stock_number;
          $matchingRecord = DB::table('csv_records')->where('stock_number', $stockNumber)->first();
          if ($matchingRecord) {
            DB::table('csv_records')
              ->where('stock_number', $stockNumber)
              ->update(['purchased_diamonds' => 1]);
          }
        }


    }
}
