<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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




        \Log::info("Demo is working fine! " . Carbon::now());

        $shop = '949fa8-4.myshopify.com';
        $date = date('Y-m-d', strtotime("-6 day"));
        if (!empty($shop)) {

            $Query = <<<QUERY
                 {
                 products(first: 100, query: "tag:diamonds-product AND updated_at:<$date") {
                   edges {
                     node {
                       id
                     }
                   }
                 }
               }
               QUERY;

            $meta = $this->graphql($shop, $Query);

            if (isset($meta['data']['products']['edges'])) {
                foreach ($meta['data']['products']['edges'] as $product) {
                    $id = str_replace("gid://shopify/Product/", "", $product['node']['id']);
                    if (!empty($id)) {

                        $del = $this->shopify_api($shop, "DELETE", "/admin/api/2023-07/products/" . $id . ".json");
                    }
                }
            }
        }
    }

    private function shopify_api($shop, $type, $url, $query = '')
    {
        $store_detail = DB::table('users')
            ->select(\DB::raw('*'))
            ->where(['name' => $shop])
            ->get();
        $shopify_token = $store_detail[0]->password;
        $url = "https://" . $shop . "" . $url;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($type == "PUT" || $type == "DELETE") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
        }
        if ($type == "POST" || $type == "PUT") {
            if ($type == "POST") {
                curl_setopt($curl, CURLOPT_POST, true);
            }

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));
        }
        $headers = [
            "Content-Type: application/json",
            "X-Shopify-Access-Token: " . $shopify_token,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response = json_decode($response, true);
    }

    private function graphql($shop, $graphqlQuery)
    {

        $store_detail = DB::table('users')
            ->select(\DB::raw('*'))
            ->where(['name' => $shop])
            ->get();

        $shopify_token = $store_detail[0]->password;

        $url = "https://" . $shop . "/admin/api/2023-01/graphql.json";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $graphqlQuery);
        $headers = [
            "Content-Type: application/graphql",
            "X-Shopify-Access-Token: " . $shopify_token,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response = json_decode($response, true);
    }
}
