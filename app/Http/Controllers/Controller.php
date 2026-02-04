<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   
    public function shopify_api($shop,$type, $url, $query = '')
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

    public function graphql($shop,$graphqlQuery)
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

   public function metaobject($shop,$meta_id,$name){
      $Query = <<<QUERY
          {
            metaobject (id:"$meta_id") {
               id
               displayName
            }
          }
      QUERY;

        $meta = $this->graphql($shop,$Query);

        if(isset($meta['data']['metaobject'][$name])){
         return $meta['data']['metaobject'][$name];
        }
   }

}
