<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Contracts\Objects\Values\ShopDomain;
use App\Models\User;
use stdClass;
use Log;
use DB;

class OrdersCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
  
        $order = $this->data;
        $shop = $this->shopDomain;
        $getToken = User::where('name', $shop)->first();

        if(isset($order->line_items[0])){
            foreach ($order->line_items as $line_items) {
                $sku = $line_items->sku;
                $product_id = $line_items->product_id;
  
            if (!empty($getToken) && !empty($sku)) {

                $csv = DB::table('csv_records')->select("*")->where("stock_number",$sku)->get()->toArray();
               if(!empty($csv)){
                DB::table('csv_records')
                  ->where('stock_number', $sku)
                  ->update(['purchased_diamonds' => 1]);
                DB::table('purchased_diamond')->insert([
                  'stock_number' => $sku
                ]);
                $getToken->api()->rest('DELETE', '/admin/api/2023-07/products/'.$product_id.'.json');
               }
              }
            }
        }

        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
           
    }

   /**
     * Handle a job failure.
     *
     * @param  $message
     * @return void
     */
    public function failed($message)
    {
        Log::info('Test by Kaswebtech fail');
        Log::info($message);
        

       
    }

}
