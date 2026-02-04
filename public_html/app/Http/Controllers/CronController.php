<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronController extends Controller 
{
	public function delete_product()
   {

     $shop = $_REQUEST['shop'];
     $date = date('Y-m-d', strtotime("-6 day"));
      if(!empty($shop)){
   
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

         $meta = $this->graphql($shop,$Query);

         if(isset($meta['data']['products']['edges']))
         {
         	foreach ($meta['data']['products']['edges'] as $product) {
         	  $id = str_replace("gid://shopify/Product/", "",$product['node']['id']);
         	  if(!empty($id)){

         	  	$del = $this->shopify_api($shop,"DELETE", "/admin/api/2023-07/products/".$id.".json");
         	  	
         	  }
         	}	
         }
     }
   }

}