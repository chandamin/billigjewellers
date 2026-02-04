<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiamondTemplate;
use App\Models\ShapeSetup;
use DB;
use App\Models\Csv;

class FrontController extends Controller
{
  public $size = ["0.50" => "½ CT", "1.00" => "1 CT", "1.50" => "1 ½ CT", "2.00" => "2 CT", "2.50" => "2 ½ CT", "3.00" => "3 CT", "3.50" => "3 ½ CT", "4.00" => "4 CT"];

  public function search_records()
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $product_id = $data['product_id'];

    $product_setup = DB::table('product_setup')->select("*")->where(['product_id' => $product_id, 'enable' => 1])
      ->get()->toArray();

    $priceSetupData = DB::table('price_setup')
      ->select('lab_grown_price', 'mined_price')
      ->get()->toArray();

    if (isset($data['diamond_selected']) && !empty($data['diamond_selected'])) {
      $selected = $this->get_sku($data['diamond_selected']);
      $product_setup = (array) $product_setup[0];

    if (!empty($selected)) {
        if ($selected[0]->lab_grown_natural == '1') {
          $type = "mined";
        } else {
          $type = "lab_grown";
        }
        $templates[0][$type] = $selected;
        $shape_image = asset("public/custom/images/" . strtolower($selected[0]->shape) . ".webp");
        return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => $data['diamond_selected'], 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
      }
    }
    if (empty($data['weight'])) {
      return "<div class='not-found'>Please select desired carat weight to begin the diamond search.</div>";
    }
    $min_weight = $data['weight'];
    $max_weight = $min_weight + 0.25;

    $shape_image = '';
    $ratio = [];

    if (isset($product_setup[0]) && !empty($product_setup[0])) {
      $product_setup = (array) $product_setup[0];
      //$size_min_weight = $product_setup['min_weight'];
      //$size_max_weight = $product_setup['max_weight'];
      // if(!empty($product_setup['ratio'])){
      //   $ratio = array_keys(unserialize($product_setup['ratio']));
      // }
      if (isset($data['shape']) && !empty($data['shape'])) {
        $shape = $data['shape'];
        $type = unserialize($product_setup['type']);
        $matched_pair = $product_setup['pair'];

        $mined = $lab_grown = '';

        foreach ($type as $type) {

          if ($type == 'mined') {
            $mined = "lab_grown_natural = '1'";
          }
          if ($type == 'lab_grown') {
            $lab_grown = "lab_grown_natural = '0'";
          }
        }

        $shape = ucfirst($shape);

        if (file_exists(public_path("/custom/images/" . strtolower($shape) . ".webp"))) {
          $shape_image = asset("public/custom/images/" . strtolower($shape) . ".webp");
        }

        $shapeDetails = ShapeSetup::select('clarity','color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();

        $templates = [];

        $metafields = $this->shopify_api($shop, "GET", "/admin/api/2023-07/products/" . $product_id . "/metafields.json");

        foreach ($metafields['metafields'] as $value) {

          if ($value['key'] == 'collection') {
            $collection_id = str_replace("gid://shopify/Metaobject/", '', $value['value']);

            $template = DB::table('diamond_templates')->select("*")->where(['collection_id' => $collection_id, 'status' => 1])
              ->get();

            foreach ($template as $template) {
              $id = $template->id;
              $color_list = (array)unserialize($template->color);
              $clarity_list = (array)unserialize($template->clarity);
              $cut_grade = (array)unserialize($template->cut);
              $polish_list = (array)unserialize($template->polish);
              $symmetry_list = (array)unserialize($template->symmetry);

              $clarity = '';
              $cut = '';
              $polish = '';
              $symmetry = '';
              foreach ($color_list as $i => $color) {
                $filter = [];
                if (isset($clarity_list[$i])) {
                  $clarity = $clarity_list[$i];
                }
                if (isset($cut_grade[$i])) {
                  $cut = $cut_grade[$i];
                }
                if (isset($polish_list[$i])) {
                  $polish = $polish_list[$i];
                }
                if (isset($symmetry_list[$i])) {
                  $symmetry = $symmetry_list[$i];
                }

                $filter[] = "id != '0'";
                if (($shapeDetails[0]->color==1) && !empty($color)) {
                  $filter[] = "color = '" . $color . "'";
                }
                if (($shapeDetails[0]->clarity==1) && !empty($clarity)) {
                  $filter[] = "clarity = '" . $clarity . "'";
                }
                if (($shapeDetails[0]->cut==1) && !empty($cut)) {
                  $filter[] = "cut_grade = '" . $cut . "'";
                }
                if (($shapeDetails[0]->polish==1) && !empty($polish)) {
                  $filter[] = "polish = '" . $polish . "'";
                }
                if (($shapeDetails[0]->symmetry==1) && !empty($symmetry)) {
                  $filter[] = "symmetry = '" . $symmetry . "'";
                }

                $filters = implode(' AND ', $filter);

                $sql = "$filters AND shape = '$shape' AND matched_pair = '$matched_pair' AND weight >= '$min_weight' And weight <= '$max_weight'";
                if (!empty($mined)) {
                  $csv_mined = DB::table('csv_records')->select("*")
                    ->whereRaw("$sql AND $mined ")
                    ->where('purchased_diamonds', 0)
                    ->orderBy('total_price', 'ASC')->limit(1)->get()->toArray();

                  if (!empty($csv_mined)) {
                    if (isset($templates[$template->label]['mined'])) {
                    } else {
                      $templates[$template->label]['mined'][] = $csv_mined[0];
                    }
                  }
                }

                if (!empty($lab_grown)) {
                  $csv_lab_grown = DB::table('csv_records')->select("*")
                    ->whereRaw("$sql AND $lab_grown ")
                    ->where('purchased_diamonds', 0)
                    ->orderBy('total_price', 'ASC')->limit(1)->get()->toArray();
                  if (!empty($csv_lab_grown)) {
                    if (isset($templates[$template->label]['lab_grown'])) {
                    } else {
                      $templates[$template->label]['lab_grown'][] = $csv_lab_grown[0];
                    }
                  }
                }
              }
            }
          }
        }

        if (!empty($templates)) {

          return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => '', 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
        } else {
          return "<div class='not-found'>Please select a different carat weight.<br>This carat weight is not available in this shape.</div>";
        }
      } else {
        return "<div class='not-found'>Shape variant not found</div>";
      }
    }
  }


  public function search_records_bkp()
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $product_id = $data['product_id'];

    $product_setup = DB::table('product_setup')->select("*")->where(['product_id' => $product_id, 'enable' => 1])
        ->get()->toArray();

    $priceSetupData = DB::table('price_setup')
        ->select('lab_grown_price', 'mined_price')
        ->get()->toArray();

    if (isset($data['diamond_selected']) && !empty($data['diamond_selected'])) {
        $selected = $this->get_sku($data['diamond_selected']);
        $product_setup = (array) $product_setup[0];

        if (!empty($selected)) {
            if ($selected[0]->lab_grown_natural == '1') {
                $type = "mined";
            } else {
                $type = "lab_grown";
            }
            $templates[0][$type] = $selected;
            $shape_image = asset("public/custom/images/" . strtolower($selected[0]->shape) . ".webp");
            return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => $data['diamond_selected'], 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
        }
    }

    if (empty($data['weight'])) {
        return "<div class='not-found'>Please select desired carat weight to begin the diamond search.</div>";
    }

    $min_weight = $data['weight'];
    $max_weight = $min_weight + 0.25;

    $shape_image = '';
    $ratio = [];

    if (isset($product_setup[0]) && !empty($product_setup[0])) {
        $product_setup = (array) $product_setup[0];

        if (isset($data['shape']) && !empty($data['shape'])) {
            $shape = $data['shape'];
            $types = unserialize($product_setup['type']);
            $matched_pair = $product_setup['pair'];

            $shape_setup = DB::table('shape_setup')
                ->select('cut', 'polish', 'symmetry')
                ->where('shape', $shape)
                ->first();

            $shape = ucfirst($shape);

            if (file_exists(public_path("/custom/images/" . strtolower($shape) . ".webp"))) {
                $shape_image = asset("public/custom/images/" . strtolower($shape) . ".webp");
            }

            $templates = [];

            $metafields = $this->shopify_api($shop, "GET", "/admin/api/2023-07/products/" . $product_id . "/metafields.json");

            foreach ($metafields['metafields'] as $value) {
                if ($value['key'] == 'collection') {
                    $collection_id = str_replace("gid://shopify/Metaobject/", '', $value['value']);

                    $template = DB::table('diamond_templates')->select("*")->where(['collection_id' => $collection_id, 'status' => 1])
                        ->get();

                    $desired_grades = ["Ideal", "Excellent", "Very Good"];

                    foreach ($template as $template) {
                        $id = $template->id;
                        $color_list = unserialize($template->color);
                        $clarity_list = unserialize($template->clarity);
                        $cut_grade = unserialize($template->cut);

                        $csv_query = Csv::where('purchased_diamonds', 0)
                            ->where('shape', $shape)
                            ->whereIn('color', $color_list)
                            ->whereIn('clarity', $clarity_list);

                        // Add lab_grown_natural condition based on $types
                        $csv_query = $csv_query->where(function($query) use ($types) {
                            foreach ($types as $type) {
                                if ($type == 'mined') {
                                    $query->orWhere('lab_grown_natural', '1');
                                }
                                if ($type == 'lab_grown') {
                                    $query->orWhere('lab_grown_natural', '0');
                                }
                            }
                        });

                        if (count(array_intersect($desired_grades, $cut_grade)) === count($desired_grades)) {
                            $csv_query = $csv_query->where('cut_grade', '');
                        } else {
                            $csv_query = $csv_query->whereIn('cut_grade', $cut_grade)
                                ->orWhere('cut_grade', '');
                        }

                        // New condition for shape_setup filters
                        if ($shape_setup) {
                            if (!empty($shape_setup->cut)) {
                                $csv_query = $csv_query->where('cut_grade', $shape_setup->cut);
                            }
                            if (!empty($shape_setup->polish)) {
                                $csv_query = $csv_query->where('polish', $shape_setup->polish);
                            }
                            if (!empty($shape_setup->symmetry)) {
                                $csv_query = $csv_query->where('symmetry', $shape_setup->symmetry);
                            }
                        }

                        if ($min_weight !== null && $max_weight !== null) {
                            $csv_query = $csv_query->whereBetween('weight', [$min_weight, $max_weight]);
                        }

                        $csv_mined = $csv_query->orderBy('total_price', 'ASC')
                            ->limit(1)
                            ->get()
                            ->toArray();

                        if (!empty($csv_mined)) {
                            if (isset($templates[$template->label]['mined'])) {
                                // if lab_grown condition is not used, it means the mined template will be filled
                            } else {
                                $templates[$template->label]['mined'][] = $csv_mined[0];
                            }
                        }
                    }
                }
            }

            if (!empty($templates)) {
                return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => '', 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
            } else {
                return "<div class='not-found'>Please select a different carat weight.<br>This carat weight is not available in this shape.</div>";
            }
        } else {
            return "<div class='not-found'>Shape variant not found</div>";
        }
    }
}


  public function get_sku($sku)
  {

    $csv = DB::table('csv_records')->select("*")
      ->whereRaw("stock_number='$sku'")->where('purchased_diamonds', 0)->get()->toArray();

    if (!empty($csv)) {
      return $csv;
    }
  }

  public function search_product()
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $sku = $data['sku'];

    if (!empty($sku)) {
      $csv = DB::table('csv_records')->select("*")
        ->whereRaw("stock_number='$sku'")->where('purchased_diamonds', 0)->get()->toArray();

      if (!empty($csv)) {
        $shape = $csv[0]->shape;

        $Query = <<<QUERY
              {
              productVariants(first: 100, query: "option1:$shape") {
                edges {
                  node {
                    product {
                        id
                   }
                  }
                }
              }
            }
            QUERY;

        $meta = $this->graphql($shop, $Query);

        if (isset($meta['data']['productVariants']['edges']) && !empty($meta['data']['productVariants']['edges'])) {
          return true;
        }
      }
      return false;
    }
  }

  public function diamond_collection()
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $sku = $data['diamond_selected'];

    $product_variants = [];
    $csv = [];

    if (!empty($sku)) {
      $csv = DB::table('csv_records')->select("*")
        ->whereRaw("stock_number='$sku'")->where('purchased_diamonds', 0)->get()->toArray();

      if (!empty($csv)) {
        $shape = $csv[0]->shape;

        $Query = <<<QUERY
              {
              productVariants(first: 100, query: "option1:$shape AND product_status:active") {
                edges {
                  node {
                    product {
                        id
                        title
                        handle
                        featuredImage{
                            url
                          }
                       variants(first: 10) {
                      edges {
                        node {
                          id
                          price
                          image{  
                            url
                          }
                        }
                      }
                    }
                   }
                  }
                }
              }
            }
            QUERY;

        $meta = $this->graphql($shop, $Query);

        if (isset($meta['data']['productVariants']['edges']) && !empty($meta['data']['productVariants']['edges'])) {
          foreach ($meta['data']['productVariants']['edges'] as $products) {

            $product = $products['node']['product'];
            $product_id = $product['id'];
            $handle = $product['handle'];
            $title = $product['title'];
            $image = $product['featuredImage']['url'];
            $variants = $product['variants']['edges'];

            foreach ($variants as $variant) {
              if (!empty($variant['node']['image'])) {
                $image = $variant['node']['image']['url'];
              }
              $variant_id = str_replace("gid://shopify/ProductVariant/", "", $variant['node']['id']);
              $price = $variant['node']['price'];
            }

            $product_variants[$product_id] = ["id" => $variant_id, 'image' => $image, 'price' => $price, 'handle' => $handle, 'title' => $title];
          }
        }
      }
    }

    $priceSetupData = DB::table('price_setup')
      ->select('lab_grown_price', 'mined_price')
      ->get();


    return view("frontend/diamond_collection", ['csv' => $csv, 'shop' => $shop, 'product_variants' => $product_variants, 'priceSetupData' => $priceSetupData]);
  }

  public function get_templates()
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $product_id = $data['product_id'];
    $variant_id = $data['variant_id'];
    $diamond_selected = $data['diamond_selected'];
    $selected = '';
    $variant = $this->shopify_api($shop, "GET", "/admin/api/2023-07/variants/" . $variant_id . ".json");

    $price = $variant['variant']['price'];

    if (isset($diamond_selected) && !empty($diamond_selected)) {
      $selected = $this->get_sku($diamond_selected);
    }

    $product_setup = DB::table('product_setup')->select("*")->where(['product_id' => $product_id, 'enable' => 1])
      ->get()->toArray();

    $size_min_weight = '0.25';
    $size_max_weight = '0.25';

    if (isset($product_setup[0]) && !empty($product_setup[0])) {
      $product_setup = (array) $product_setup[0];
      $size_min_weight = $product_setup['min_weight'];
      $size_max_weight = $product_setup['max_weight'];
    }

    $metafields = $this->shopify_api($shop, "GET", "/admin/api/2023-07/products/" . $product_id . "/metafields.json");

    foreach ($metafields['metafields'] as $pvalue) {

      if ($pvalue['key'] == 'production_days') {
        $production_days = $pvalue['value'];
      }
    }

    return view("frontend/product_template", ['shop' => $shop, 'product_id' => $product_id, 'variant_id' => $variant_id, 'price' => $price, 'size' => $this->size, 'selected' => $selected, 'diamond_selected' => $diamond_selected, 'size_min_weight' => $size_min_weight, 'size_max_weight' => $size_max_weight, 'production_days' => $production_days]);
  }

  public function get_sidebar()
  {

    return view("frontend/includes/sidebar");
  }

  public function generate()
  {

    $shop = $_POST['shop'];
    $variantid = '';

    if (isset($_POST['variant_id']) && !empty($_POST['variant_id'])) {
      $variantid = $_POST['variant_id'];
    }
    $sku = $_POST['sku'];
    $name = ["Carat", "Color", "Clarity"];
    $output = [];
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
      $product_id = $_POST['product_id'];
      $product_setup = DB::table('product_setup')->select("*")->where(['product_id' => $product_id, 'enable' => 1])
        ->get()->toArray();
    }

    $priceSetupData = DB::table('price_setup')
      ->select('lab_grown_price', 'mined_price')
      ->get()->toArray();

    if (!empty($sku)) {
      $Query = <<<QUERY
  {
  productVariants(first: 1, query: "sku:$sku") {
    edges {
      node {
        product {
           variants(first: 10) {
          edges {
            node {
              id
              sku
            }
          }
        }
       }
      }
    }
  }
}
QUERY;

      $meta = $this->graphql($shop, $Query);
      $csv = DB::table('csv_records')->select("*")->where('purchased_diamonds', 0)->where(['stock_number' => $sku])->get();

      if (isset($csv[0]->id) && !empty($csv[0]->id)) {
        $template = $csv[0];
        $weight = $template->weight . " ct";
        $color = $template->color;
        $clarity = $template->clarity;
        $shape = $template->shape;
        $lab = $template->lab;
        $price = $template->total_price;
        $csv_type = $template->lab_grown_natural;

        if ($csv_type == '1') {
          $c_type = "Mined";
          $add_price = 'mined_price';
        }
        if ($csv_type == '0') {
          $c_type = "Lab Grown";
          $add_price = 'lab_grown_price';
        }

        $variant_title = $weight . " CT  " . $lab . " " . $shape . " " . $color . "/" . $clarity . " " . $c_type;

        //  if(isset($product_setup[0]->$add_price) && $product_setup[0]->$add_price > 0){
        //    $price = ( $price * $product_setup[0]->$add_price / 100 ); 
        //  }

        if (isset($priceSetupData[0]->$add_price) && $priceSetupData[0]->$add_price > 0) {
          $price = ($price * $priceSetupData[0]->$add_price / 100);
        }
      }
      if (isset($meta['data']['productVariants']['edges'][0]['node']['product']['variants']['edges'][0]['node']['id'])) {
        foreach ($meta['data']['productVariants']['edges'][0]['node']['product']['variants']['edges'] as $variant) {
          if ($variant['node']['sku'] == $sku) {

            $variant_id = str_replace("gid://shopify/ProductVariant/", "", $variant['node']['id']);

            $v = ['variant' => ['price' => $price]];

            $this->shopify_api($shop, "PUT", "/admin/api/2023-07/variants/" . $variant_id . ".json", $v);

            $output['items'][] = ["id" => $variant_id, 'quantity' => 1];
          }
        }
      } else {

        if (isset($csv[0]->id) && !empty($csv[0]->id)) {

          $src_shape = str_replace(" ", "_", strtolower($shape));

          $src = asset("public/custom/images/shape-" . $src_shape . ".svg");

          if (file_exists(public_path("/custom/images/" . $src_shape . ".webp"))) {
            $src = asset("public/custom/images/" . $src_shape . ".webp");
          }
          $description = '';
          if ($csv[0]->cert != '') {
            $description .= '<p>Certificate: ' . $csv[0]->lab . " " . $csv[0]->cert . "</p>";
          }

          if ($csv[0]->certificate_image != '') {
            $description .= '<p>Certificate URL: <a href=\"' . $csv[0]->certificate_image . '\" target=\"_blank\">Link</a></p>';
          }
          if ($csv[0]->external_url != '') {
            $description .= '<p>Media: <a href=\"' . $csv[0]->external_url . '\" target=\"_blank\">Media link</a></p>';
          }

          $names = implode('","', $name);

          $Query = <<<QUERY
                        mutation {
                          productCreate(input: {
                            title:"$variant_title",
                            descriptionHtml:"$description",
                            templateSuffix:"Base Diamond Product",
                            options: ["$names"],
                            published:true,
                            tags:"diamonds-product",
                            images:[{
                                src :"$src" 
                            }],
                            variants: [
                                { 
                                options: ["$weight","$color","$clarity"],
                                price:"$price",
                                sku:"$sku"
                              }
                            ]
                            }
                            ) {
                                userErrors {
                              field
                              message
                            }
                            product {
                                id
                                variants(first:1) {
                                edges {
                                  node {
                                    id
                                  }
                                }
                              }
                            }
                          }
                        }
                        QUERY;

          $vmeta = $this->graphql($shop, $Query);

          if (isset($vmeta['data']['productCreate']['product']['variants']['edges'][0]['node']['id'])) {
            $variant_id = str_replace("gid://shopify/ProductVariant/", "", $vmeta['data']['productCreate']['product']['variants']['edges'][0]['node']['id']);

            $inventory = ['variant' => ['inventory_policy' => "continue"]];

            $this->shopify_api($shop, "PUT", "/admin/api/2023-07/variants/" . $variant_id . ".json", $inventory);

            $output['items'][] = ["id" => $variant_id, 'quantity' => 1];
          } else {
            print_r($description);
            print_r($vmeta);
            die;
          }
        }
      }
    }
    if (!empty($variantid)) {
      if (isset($_POST['ring_size']) && !empty($_POST['ring_size'])) {
        $output['items'][] = ["id" => $variantid, 'quantity' => 1, 'properties' => ['Ring Size' => $_POST['ring_size']]];
      } else {
        $output['items'][] = ["id" => $variantid, 'quantity' => 1];
      }
    }
    return json_encode($output);
  }

  public function get_price()
  {

    $shop = $_POST['shop'];
    $variant_id = $_POST['variant_id'];

    $variant = $this->shopify_api($shop, "GET", "/admin/api/2023-07/variants/" . $variant_id . ".json");

    if (isset($variant['variant']['price'])) {
      return $variant['variant']['price'];
    }
  }


  public function diamondMinedLab(Request $request)
  {
    $input = $request->all();

    if (isset($input['shop']) &&  $input['shop'] != '') {

      if (isset($input['shape'])  &&  $input['shape'] != '') {
        $shape = $input['shape'];
      } else {
        $shape = 'Round';
      }
      $csv = Csv::where('shape', $shape)->where('purchased_diamonds', 0);

      if (isset($input['color'])  &&  $input['color'] != '') {
        $csv = $csv->whereIn("color", $input['color']);
      }

      if (isset($input['clarity'])  &&  $input['clarity'] != '') {
        $csv = $csv->whereIn("clarity", $input['clarity']);
      }

      if (isset($input['cut'])  &&  $input['cut'] != '') {
        $csv = $csv->whereIn("cut_grade", $input['cut']);
      }

      if (isset($input['certificate'])  &&  $input['certificate'] != '') {
        $csv = $csv->whereIn("lab", $input['certificate']);
      }

      if (isset($input['diamond'])  &&  $input['diamond'] != '') {
        $csv = $csv->where("lab_grown_natural", $input['diamond']);
      }


      if (isset($input['weight'])  &&  $input['weight'] != '') {
      
        $weigCur = explode("-",$input['weight']);
        $from = $weigCur[0];
        $to = $weigCur[1];
        $csv = $csv->whereBetween("weight", [$from, $to]);
      }
    

      $csv = $csv->paginate(20);


      $priceSetupData = DB::table('price_setup')
        ->select('lab_grown_price', 'mined_price')
        ->get();


      return view("frontend/includes/diamond-filter", ['csv' => $csv, 'priceSetupData' => $priceSetupData]);
    } else {
      echo "0";
      exit();
    }
  }


  public function diamondMinedLabSmartBackup24524(Request $request)
  {
      $input = $request->all();
  
      if (isset($input['shop']) && $input['shop'] != '') {
  
          if (isset($input['shape']) && $input['shape'] != '') {
              $shape = $input['shape'];
          } else {
              $shape = 'Round';
          }
  
          $goodQuality = Csv::where('shape', $shape)->where('purchased_diamonds', 0)->whereIn('cut_grade', ['Good', 'Ideal']);
          $betterQuality = Csv::where('shape', $shape)->where('purchased_diamonds', 0)->whereIn('cut_grade', ['Very good', 'Good', 'Excellent']);
          $bestQuality = Csv::where('shape', $shape)->where('purchased_diamonds', 0)->whereIn('cut_grade', ['Excellent']);
  
          if (isset($input['diamond']) && $input['diamond'] != '') {
              $goodQuality = $goodQuality->where("lab_grown_natural", $input['diamond']);
              $betterQuality = $betterQuality->where("lab_grown_natural", $input['diamond']);
              $bestQuality = $bestQuality->where("lab_grown_natural", $input['diamond']);
          }
  
          $weightRanges = [];
          if (isset($input['CartWeight']) && is_array($input['CartWeight'])) {
              foreach ($input['CartWeight'] as $cartWeight) {
                  $min_weight = $cartWeight;
                  $max_weight = $min_weight + 0.25;
                  $weightRanges[] = [$min_weight, $max_weight];
              }
          }
  
         
          // Apply weight filtering within the scope of the shape
          foreach ($weightRanges as $range) {
              $goodQuality = $goodQuality->whereBetween("weight", $range);
              $betterQuality = $betterQuality->whereBetween("weight", $range);
              $bestQuality = $bestQuality->whereBetween("weight", $range);
          }
  
          $goodQuality = $goodQuality->paginate(3);
          $betterQuality = $betterQuality->paginate(3);
          $bestQuality = $bestQuality->paginate(3);
  
          $priceSetupData = DB::table('price_setup')
              ->select('lab_grown_price', 'mined_price')
              ->get();
  
          return view("frontend/includes/diamond-filter-smart", [
              'goodQuality' => $goodQuality,
              'betterQuality' => $betterQuality,
              'bestQuality' => $bestQuality,
              'priceSetupData' => $priceSetupData
          ]);
      } else {
          echo "0";
          exit();
      }
  }
  

    public function diamondMinedLabSmart(Request $request)
    {
        ini_set('memory_limit', '256M'); 

        $input = $request->all();

        $shop = $input['shop'];
        $diamond = $input['diamond'];

        $min_weight = null;
        $max_weight = null;

        if (isset($input['CartWeight'])) {
            $min_weight = $input['CartWeight'][0]; 
            $max_weight = $min_weight + 0.25;
        }
        
        
        $templates = [];

        $priceSetupData = DB::table('price_setup')
          ->select('lab_grown_price', 'mined_price')
          ->get()->toArray();

        $product_setup = DB::table('product_setup')->select("*")->where(['enable' => 1])->get()->toArray();

        if (!empty($product_setup)) {
            foreach ($product_setup as $setup) {
                $type = unserialize($setup->type);
              // print_r($type);
            }
        } 
        if (isset($input['shop']) && $input['shop'] != '') {

            if (isset($input['shape']) && $input['shape'] != '') {
                $shape = $input['shape'];
            } 
            
            $mined = $lab_grown = '';
            
            foreach ($type as $type) {
                if ($type == 'mined') {
                  $mined = "lab_grown_natural = '1'";
                }
                if ($type == 'lab_grown') {
                  $lab_grown = "lab_grown_natural = '0'";
                }
            }

        //    $shape = isset($input['shape']) && $input['shape'] != '' ? $input['shape'] : '';
            $shapeDetails = ShapeSetup::select('clarity','color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();
       
            if (!$shapeDetails->isEmpty()) {
                  $template = DB::table('diamond_templates')->select("*")->where(['collection_id' => 24813961490, 'status' => 1])
                  ->get();
                  
                 $desired_grades = ["Ideal", "Excellent", "Very Good"];
                  
                  foreach ($template as $template) {
                    $id = $template->id;
                    $color_list = (array)unserialize($template->color);
                    $clarity_list = (array)unserialize($template->clarity);
                    $cut_grade = (array)unserialize($template->cut);
                    $polish_list = (array)unserialize($template->polish);
                    $symmetry_list = (array)unserialize($template->symmetry);
                    
                    $csv_mined = Csv::where('purchased_diamonds', 0);
                    $csv_mined=$csv_mined->where('lab_grown_natural', $diamond);
                    $csv_mined=$csv_mined->where('shape', $shape);
                    $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
                    // $csv_mined=$csv_mined->whereIn('color', $color_list);
                    // $csv_mined=$csv_mined->whereIn('clarity', $clarity_list);
                    // $csv_mined=$csv_mined->whereIn('polish', $polish_list);
                    // $csv_mined=$csv_mined->whereIn('symmetry', $symmetry_list);
                  
                    if($shapeDetails[0]->color==1){
                      $csv_mined=$csv_mined->whereIn('color', $color_list);
                    }
                    if($shapeDetails[0]->clarity==1){
                      $csv_mined=$csv_mined->whereIn('clarity', $clarity_list);
                    }
                    if($shapeDetails[0]->cut==1){

                      $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
                      // if (count(array_intersect($desired_grades, $cut_grade)) === count($desired_grades)) {
                      //   $csv_mined = $csv_mined->where('cut_grade', $cut_grade);
                      // } else {    
                      //   //$csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
                      //   $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
                      // }
                    }
                    if($shapeDetails[0]->polish==1){
                      $csv_mined=$csv_mined->whereIn('polish', $polish_list);
                    }
                    if($shapeDetails[0]->symmetry==1){
                      $csv_mined=$csv_mined->whereIn('symmetry', $symmetry_list);
                    }
                    if ($min_weight !== null && $max_weight !== null) {
                        $csv_mined = $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
                      
                    }

                    if ($diamond !== null) {
                      $csv_mined=$csv_mined->where('lab_grown_natural', $diamond);
                    }
                    
                      
                $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->limit(3)->get()->toArray();
              
                      //   $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->toSql();
                      // echo "<pre>"; print_r($csv_mined);
                        if (!empty($csv_mined)) {
                          if (isset($templates[$template->label])) {
                          } else {
                            foreach ($csv_mined as $csv_mined) {
                              $templates[$template->label][] = $csv_mined;
                            }
                            
                          }
                        }
                  
                    
                  }

            if (!empty($templates)) {
            return view("frontend/includes/diamond-filter-smart", ['shop' => $shop,'shape' =>$shape, 'templates' => $templates, 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
            }
            else {
              return "<div class='not-found'>Please select a different shape or carat weight.</div>";
            }

          }else{
            return "<div class='not-found'>Please choose a different shape, this shape does not exist in the global size setup.</div>";
          }
            

        } else {
            echo "0";
            exit();
        }
    }


      public function diamondMinedLabSmart__my(Request $request)
      {
          ini_set('memory_limit', '256M'); 

          $input = $request->all();

          $shop = $input['shop'];
          $diamond = $input['diamond'];

          $min_weight = null;
          $max_weight = null;

          if (isset($input['CartWeight'])) {
              $min_weight = $input['CartWeight'][0]; 
              $max_weight = $min_weight + 0.25;
          }
          
          
          $templates = [];

          $priceSetupData = DB::table('price_setup')
            ->select('lab_grown_price', 'mined_price')
            ->get()->toArray();

          $product_setup = DB::table('product_setup')->select("*")->where(['enable' => 1])->get()->toArray();

          if (!empty($product_setup)) {
              foreach ($product_setup as $setup) {
                  $type = unserialize($setup->type);
                // print_r($type);
              }
          } 
          if (isset($input['shop']) && $input['shop'] != '') {

              if (isset($input['shape']) && $input['shape'] != '') {
                  $shape = $input['shape'];
              } 
              // else {
              //     $shape = 'Round';
              // }
              
              $mined = $lab_grown = '';
              
              foreach ($type as $type) {
                  if ($type == 'mined') {
                    $mined = "lab_grown_natural = '1'";
                  }
                  if ($type == 'lab_grown') {
                    $lab_grown = "lab_grown_natural = '0'";
                  }
              }

              //$shape = isset($input['shape']) && $input['shape'] != '' ? $input['shape'] : 'Round';
              $shape = isset($input['shape']) && $input['shape'] != '' ? $input['shape'] : '';
                
              $shapeDetails = ShapeSetup::select('clarity','color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();
           
              $template = DB::table('diamond_templates')->select("*")->where(['collection_id' => 24813961490, 'status' => 1])
                  ->get();
                

                  $desired_grades = ["Ideal", "Excellent", "Very Good"];
                  
                  foreach ($template as $template) {
                    $id = $template->id;
                    $color_list = (array)unserialize($template->color);
                    $clarity_list = (array)unserialize($template->clarity);
                    $cut_grade = (array)unserialize($template->cut);
                    $polish_list = (array)unserialize($template->polish);
                    $symmetry_list = (array)unserialize($template->symmetry);
                  
                    
                    $csv_mined = Csv::where('purchased_diamonds', 0)
                    ->where('lab_grown_natural', $diamond)
                    ->where('shape', $shape)
                    ->whereIn('color', $color_list)
                    ->whereIn('clarity', $clarity_list)
                    ->whereIn('polish', $polish_list)
                    ->whereIn('symmetry', $symmetry_list);

                  
                  if($shapeDetails[0]->cut==1){
                    if (count(array_intersect($desired_grades, $cut_grade)) === count($desired_grades)) {
                      $csv_mined = $csv_mined->where('cut_grade', '');
                    } else {    
                      //$csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
                      $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade)->orWhere('cut_grade', '');
                    }
                  }

                  if($shapeDetails[0]->polish==1){
                    $csv_mined=$csv_mined->whereIn('polish', $polish_list);
                  }
                  if($shapeDetails[0]->symmetry==1){
                    $csv_mined=$csv_mined->whereIn('symmetry', $symmetry_list);
                  }

                if ($min_weight !== null && $max_weight !== null) {
                    $csv_mined = $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
                }
                


                $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->limit(3)->get()->toArray();
                        if (!empty($csv_mined)) {
                          if (isset($templates[$template->label])) {
                          } else {
                            foreach ($csv_mined as $csv_mined) {
                              $templates[$template->label][] = $csv_mined;
                            }
                            
                          }
                        }
                  
                    
                  }

            if (!empty($templates)) {
            return view("frontend/includes/diamond-filter-smart", ['shop' => $shop,'shape' =>$shape, 'templates' => $templates, 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
            }
            else {
              return "<div class='not-found'>Please select a different shape or carat weight.</div>";
            }

          } else {
              echo "0";
              exit();
          }
      }


  //Custom Search 
  public function lbDiamonds(Request $request)
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $type = $data['type'];

    $filter = Csv::distinct()->pluck('shape');
    $color = Csv::distinct()->pluck('color');
    $clarity = Csv::distinct()->pluck('clarity');
    $cut = Csv::distinct()->pluck('cut_grade');
    $weightMax = ceil(Csv::max('weight'));
    $weightMin = floor(Csv::min('weight'));
    $lab = Csv::distinct()->pluck('lab');

    return view("frontend/lbDiamonds", ['type' => $type, 'shop' => $shop, 'filter' => $filter, 'color' => $color, 'clarity' => $clarity, 'cut' => $cut, 'weightMax' => $weightMax, 'weightMin' => $weightMin, 'lab' => $lab]);
  }


  //Smart Search 
  public function lbDiamondsSmart(Request $request)
  {
    $data = $_REQUEST;
    $shop = $data['shop'];
    $type = $data['type'];

    $filter = Csv::distinct()->pluck('shape');
    $color = Csv::distinct()->pluck('color');
    $clarity = Csv::distinct()->pluck('clarity');
    $cut = Csv::distinct()->pluck('cut_grade');
    $weightMax = ceil(Csv::max('weight'));
    $weightMin = floor(Csv::min('weight'));
    $lab = Csv::distinct()->pluck('lab');

    return view("frontend/lbDiamondsSmart", ['type' => $type, 'shop' => $shop, 'filter' => $filter, 'color' => $color, 'clarity' => $clarity, 'cut' => $cut, 'weightMax' => $weightMax, 'weightMin' => $weightMin, 'lab' => $lab]);
  }
}
