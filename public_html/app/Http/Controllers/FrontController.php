<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiamondTemplate;
use App\Models\ShapeSetup;
use DB;
use App\Models\Csv;
use Illuminate\Support\Facades\Cache;


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

        $templates = [];
        $templates[$type] = (array)$selected;
        $templates = json_decode(json_encode($templates), true);
        // $templates[0][$type] = objectToArray($selected);



        $shape_image = asset("public/custom/images/" . strtolower($selected[0]->shape) . ".webp");

        return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => $data['diamond_selected'], 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
        exit();
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

        $shape = ucfirst($shape);

        if (file_exists(public_path("/custom/images/" . strtolower($shape) . ".webp"))) {
          $shape_image = asset("public/custom/images/" . strtolower($shape) . ".webp");
        }

        $templates = $arrs = [];

        // 
        $shapeDetails = ShapeSetup::select('clarity', 'color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();

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
            $diamond = $template->type;
            //print_r($diamond);

            //check added by deepika
            if ($diamond == 'Lab Grown') {
              $d_type = 0;
            }
            if ($diamond == 'Natural') {
              $d_type = 1;
            }



            $csv_mined = Csv::where('purchased_diamonds', 0);
            $csv_mined = $csv_mined->where('lab_grown_natural', $d_type);
            $csv_mined = $csv_mined->where('shape', $shape);
            $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);

            if ($shapeDetails[0]->color == 1) {
              $csv_mined = $csv_mined->whereIn('color', $color_list);
            }
            if ($shapeDetails[0]->clarity == 1) {
              $csv_mined = $csv_mined->whereIn('clarity', $clarity_list);
            }
            if ($shapeDetails[0]->cut == 1) {
              $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
            }
            if ($shapeDetails[0]->cut == 0) {
              if ($shapeDetails[0]->polish == 1) {
                $csv_mined = $csv_mined->whereIn('polish', $polish_list);
              }
              if ($shapeDetails[0]->symmetry == 1) {
                $csv_mined = $csv_mined->whereIn('symmetry', $symmetry_list);
              }
            }
            if ($min_weight !== null && $max_weight !== null) {
              $csv_mined = $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
            }
            // $sql_query = $csv_mined->orderBy('total_price', 'ASC')->limit(3)->toSql();

            //$csv_mined = $csv_mined->orderBy('total_price', 'ASC')->limit(1)->get()->unique('total_price')->toArray();

            //updated by deepika
            $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->get()->unique('total_price')->take(1)->toArray();



            //print_r($sql_query);


            if (!empty($csv_mined)) {

              foreach ($csv_mined as $csv_mined) {
                //print_r($arrs[$template->label][$csv_mined['lab_grown_natural']]);
                //print_r($arrs[$template->label]);
                //print_r($arrs[$csv_mined['lab_grown_natural']]);
                if (!isset($arrs[$template->label][$csv_mined['lab_grown_natural']])) {

                  $templates[$template->label][] = $csv_mined;

                  $arrs[$template->label][$csv_mined['lab_grown_natural']] = $csv_mined['lab_grown_natural'];
                }
              }
            }
          }
          $temp = [];

          $arr = ['Best Quality', 'Better Quality', 'Good Quality'];
          foreach ($arr as $arr) {
            if (isset($templates[$arr])) {
              $temp[$arr] = $templates[$arr];
            }
          }
          $templates = $temp;



          if (!empty($templates)) {
            return view("frontend/search_records", ['shop' => $shop, 'product_id' => $product_id, 'templates' => $templates, 'shape_image' => $shape_image, 'diamond_selected' => '', 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
          } else {
            return "<div class='not-found'>Please select a different carat weight.<br>This carat weight is not available in this shape.</div>";
          }
        }
      } else {
        return "<div class='not-found'>Shape variant not found</div>";
      }
    }
  }
  public function search_records_14()
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

        $templates = [];






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

        $shapeDetails = ShapeSetup::select('clarity', 'color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();

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
                if (($shapeDetails[0]->color == 1) && !empty($color)) {
                  $filter[] = "color = '" . $color . "'";
                }
                if (($shapeDetails[0]->clarity == 1) && !empty($clarity)) {
                  $filter[] = "clarity = '" . $clarity . "'";
                }
                if (($shapeDetails[0]->cut == 1) && !empty($cut)) {
                  $filter[] = "cut_grade = '" . $cut . "'";
                }
                if (($shapeDetails[0]->polish == 1) && !empty($polish)) {
                  $filter[] = "polish = '" . $polish . "'";
                }
                if (($shapeDetails[0]->symmetry == 1) && !empty($symmetry)) {
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

          // $temp = [];

          // $temp['good'] = $templates['good']]

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
        //dd($shape);
        $Query = <<<QUERY
                    {
                      productVariants(first: 250, query: "option1:$shape AND product_status:active") {
                        edges {
                          node {
                            product {
                              id
                              title
                              handle
                              featuredImage {
                                url
                              }
                              variants(first: 250) {
                                edges {
                                  node {
                                    id
                                    price
                                    image {  
                                      url
                                    }
                                    selectedOptions {
                                      name
                                      value
                                    }
                                  }
                                }
                              }
                              collections(first: 10) {  
                                edges {
                                  node {
                                    id
                                    title 
                                    handle
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

        // dd($meta);
        if (isset($meta['data']['productVariants']['edges']) && !empty($meta['data']['productVariants']['edges'])) {
          foreach ($meta['data']['productVariants']['edges'] as $products) {
            $product = $products['node']['product'];
            $product_id = $product['id'];
            // $PID = str_replace("gid://shopify/Product/", "", $product_id);
            // $productSetup = DB::table('product_setup')
            //   ->where('product_id', $PID)
            //   ->first();


            $collectionMatch = false;
            if (isset($product['collections']['edges']) && !empty($product['collections']['edges'])) {
              foreach ($product['collections']['edges'] as $collection) {
                $collection_id = str_replace("gid://shopify/Collection/", "", $collection['node']['id']);
                if ($collection_id == "488697200914") {
                  $collectionMatch = true;
                  break;
                }
              }
            }



            // if ($productSetup) {
            if ($collectionMatch) {
              $handle = $product['handle'];
              $title = $product['title'];
              $image = $product['featuredImage']['url'];
              $variants = $product['variants']['edges'];

              // foreach ($variants as $variant) {
              //   if (!empty($variant['node']['image'])) {
              //     $image = $variant['node']['image']['url'];
              //   }
              //   $variant_id = str_replace("gid://shopify/ProductVariant/", "", $variant['node']['id']);
              //   $price = $variant['node']['price'];
              // }


              foreach ($variants as $variant) {
                // Check if the variant has the selected option with value equal to $shape
                $matchesShape = false;
                foreach ($variant['node']['selectedOptions'] as $option) {
                  if ($option['value'] === $shape) {
                    $matchesShape = true;
                    break;
                  }
                }

                if ($matchesShape) {
                  // Update image if the variant has a specific image
                  if (!empty($variant['node']['image'])) {
                    $image = $variant['node']['image']['url'];
                  }

                  // Collect variant data
                  $variant_id = str_replace("gid://shopify/ProductVariant/", "", $variant['node']['id']);
                  $price = $variant['node']['price'];

                  $product_variants[$product_id] = [
                    "id" => $variant_id,
                    'image' => $image,
                    'price' => $price,
                    'handle' => $handle,
                    'title' => $title
                  ];

                  // Stop after finding a matching variant for this product
                  break;
                }
              }

              // $product_variants[$product_id] = ["id" => $variant_id, 'image' => $image, 'price' => $price, 'handle' => $handle, 'title' => $title];
            }
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
    $handle = $data['handle'];
    
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

    return view("frontend/product_template", ['shop' => $shop, 'product_id' => $product_id, 'variant_id' => $variant_id, 'price' => $price, 'size' => $this->size, 'selected' => $selected, 'diamond_selected' => $diamond_selected, 'size_min_weight' => $size_min_weight, 'size_max_weight' => $size_max_weight, 'production_days' => $production_days , 'handle' => $handle]);
  }

  public function get_sidebar()
  {

    return view("frontend/includes/sidebar");
  }

// public function generate()
// {
//    dd($_POST);
//     $shop = $_POST['shop'] ?? '';
//     $variantid = $_POST['variant_id'] ?? '';
//     $product_id = $_POST['product_id'] ?? '';
//     $sku = $_POST['sku'] ?? '';
//     $variant_id = '';
//     $output = [];
//     $cache = [];

//     // --- 1. Quick DB preloads ---
//     static $priceSetupCache = null;
//     if ($priceSetupCache === null) {
//         $priceSetupCache = DB::table('price_setup')
//             ->select('lab_grown_price', 'mined_price')
//             ->first();
//     }

//     $product_setup = [];
//     if (!empty($product_id)) {
//         $product_setup = DB::table('product_setup')
//             ->where(['product_id' => $product_id, 'enable' => 1])
//             ->get()
//             ->toArray();
//     }

//     // --- 2. Skip if SKU empty ---
//     if (empty($sku)) {
//         return json_encode(['error' => 'SKU missing']);
//     }

//     // --- 3. Check Shopify for variant (cached or direct) ---
//     $variantFound = false;
//     $meta = Cache::remember("shopify_variant_meta_$sku", 60, function () use ($shop, $sku) {
//         $query = <<<GRAPHQL
//         {
//           productVariants(first: 1, query: "sku:$sku") {
//             edges {
//               node {
//                 id
//                 sku
//                 product { id }
//               }
//             }
//           }
//         }
//         GRAPHQL;
//         return $this->graphql($shop, $query);
//     });

//     // --- 4. Load CSV record (only if exists) ---
//     $csv = DB::table('csv_records')
//         ->where('purchased_diamonds', 0)
//         ->where('stock_number', $sku)
//         ->first();
             
//     if (empty($csv)) {
//         return json_encode(['error' => 'CSV record not found']);
//     }

//     // Extract CSV fields
//     $weight = number_format($csv->weight, 2) . " ct";
//     $color = $csv->color;
//     $clarity = $csv->clarity;
//     $shape = $csv->shape;
//     $lab = $csv->lab;
//     $price = $csv->total_price;
//     $csv_type = $csv->lab_grown_natural;
//     $c_type = $csv_type == '1' ? "Mined" : "Lab Grown";
//     $add_price = $csv_type == '1' ? 'mined_price' : 'lab_grown_price';

//     if (!empty($priceSetupCache->$add_price)) {
//         $price = ($price * $priceSetupCache->$add_price / 100);
//     }

//     $variant_title = "$weight $lab $shape $color/$clarity $c_type";
//     $priceRounded = round($price, -1);

//     // --- 5. Fast check if variant exists in Shopify ---
//     $edges = $meta['data']['productVariants']['edges'] ?? [];
//     if (!empty($edges)) {
//         $node = $edges[0]['node'];
//         if (!empty($node['sku']) && $node['sku'] === $sku) {
//             $variantFound = true;
//             $variant_id = str_replace("gid://shopify/ProductVariant/", "", $node['id']);

//             // Update price if needed
//             $this->shopify_api($shop, "PUT", "/admin/api/2023-07/variants/$variant_id.json", [
//                 'variant' => ['price' => $priceRounded]
//             ]);
//         }
//     }

//     // --- 6. If not found, create new product/variant ---
//     if (!$variantFound) {
//         $description = '';
//         if (!empty($csv->cert))
//             $description .= '<p>Certificate: ' . $csv->lab . " " . $csv->cert . "</p>";
//         if (!empty($csv->certificate_image))
//             $description .= '<p>Certificate URL: <a href="' . $csv->certificate_image . '" target="_blank">Link</a></p>';
//         if (!empty($csv->external_url))
//             $description .= '<p>Media: <a href="' . $csv->external_url . '" target="_blank">Media link</a></p>';

//         // Memoized image path check
//         static $shapeCache = [];
//         $src_shape = str_replace(" ", "_", strtolower($shape));
//         if (!isset($shapeCache[$src_shape])) {
//             $localPath = public_path("/custom/images/addcart/$src_shape.webp");
//             $shapeCache[$src_shape] = file_exists($localPath)
//                 ? asset("public/custom/images/addcart/$src_shape.webp")
//                 : asset("public/custom/images/shape-$src_shape.svg");
//         }
//         $src = $shapeCache[$src_shape];

//         // Use REST only (faster & simpler)
//         $restPayload = [
//             'product' => [
//                 'title' => $variant_title,
//                 'body_html' => $description,
//                 'template_suffix' => 'Base Diamond Product',
//                 'tags' => 'diamonds-product',
//                 'published' => true,
//                 'variants' => [[
//                     'price' => (string)$priceRounded,
//                     'sku' => $sku,
//                     'option1' => $weight,
//                     'option2' => $color,
//                     'option3' => $clarity
//                 ]],
//                 'images' => [['src' => $src]]
//             ]
//         ];

//         $restCreate = $this->shopify_api($shop, "POST", "/admin/api/2023-07/products.json", $restPayload);

//         if (!empty($restCreate['product']['variants'][0]['id'])) {
//             $variant_id = (string)$restCreate['product']['variants'][0]['id'];
//         }
//     }

//     // --- 7. Prepare diamond variant cart item ---
//     if (!empty($variant_id)) {
//         $diamondItem = [
//             "id" => $variant_id,
//             'quantity' => 1,
//             'properties' => [
//                 '_main_variant' => $variantid,
//                 '_diamond_variant' => $variant_id,
//                 '_ring_size' => $_POST['ring_size'] ?? '',
//                 '_weight' => $_POST['weight'] ?? '',
//                 '_handle' => $_POST['handle'] ?? '',
//                 '_carat' => str_replace("ct", "", $weight)
//             ]
//         ];
//         if (!empty($_POST['diamond_selected'])) {
//             $diamondItem['properties']['_diamond_selected'] = 'yes';
//             $diamondItem['properties']['_sku'] = $sku;
//         }
//         $output['items'][] = $diamondItem;
//     }

//     // --- 8. Add main variant (ring) ---
//     if (!empty($variantid)) {
//         $ringItem = [
//             "id" => $variantid,
//             'quantity' => 1,
//             'properties' => [
//                 'Ring Size' => $_POST['ring_size'] ?? '',
//                 '_main_variant' => $variantid,
//                 '_diamond_variant' => $variant_id,
//                 '_ring_size' => $_POST['ring_size'] ?? '',
//                 '_weight' => $_POST['weight'] ?? '',
//                 '_handle' => $_POST['handle'] ?? '',
//                 '_carat' => str_replace("ct", "", $weight)
//             ]
//         ];
//         if (!empty($_POST['diamond_selected'])) {
//             $ringItem['properties']['_diamond_selected'] = 'yes';
//             $ringItem['properties']['_sku'] = $sku;
//         }
//         $output['items'][] = $ringItem;
//     }

//     return json_encode($output);
// }



public function generate()
{
    $shop = $_POST['shop'] ?? '';
    $variantid = $_POST['variant_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $variant_id = '';
    $output = [];

    // --- 1. Quick DB preloads ---
    static $priceSetupCache = null;
    if ($priceSetupCache === null) {
        $priceSetupCache = DB::table('price_setup')
            ->select('lab_grown_price', 'mined_price')
            ->first();
    }

    // Validate price setup exists
    if (empty($priceSetupCache)) {
        return json_encode([
            'error' => 'Price setup not configured',
            'details' => 'Please configure price_setup table first'
        ]);
    }

    $product_setup = [];
    if (!empty($product_id)) {
        $product_setup = DB::table('product_setup')
            ->where(['product_id' => $product_id, 'enable' => 1])
            ->get()
            ->toArray();
    }

    // --- 2. Validate required parameters ---
    if (empty($sku)) {
        return json_encode(['error' => 'SKU missing']);
    }

    if (empty($shop)) {
        return json_encode(['error' => 'Shop parameter missing']);
    }

    // --- 3. Check Shopify for variant (cached or direct) ---
    $variantFound = false;
    try {
        $meta = Cache::remember("shopify_variant_meta_$sku", 60, function () use ($shop, $sku) {
            $query = <<<GRAPHQL
            {
              productVariants(first: 1, query: "sku:$sku") {
                edges {
                  node {
                    id
                    sku
                    product { id }
                  }
                }
              }
            }
            GRAPHQL;
            return $this->graphql($shop, $query);
        });
    } catch (\Exception $e) {
        return json_encode([
            'error' => 'Failed to query Shopify',
            'details' => $e->getMessage()
        ]);
    }

    // --- 4. Load CSV record (only if exists) ---
    $csv = DB::table('csv_records')
        ->where('purchased_diamonds', 0)
        ->where('stock_number', $sku)
        ->first();
             
    if (empty($csv)) {
        return json_encode([
            'error' => 'CSV record not found',
            'details' => "No unpurchased diamond found with SKU: $sku"
        ]);
    }

    // --- 5. Extract and validate CSV fields ---
    $weight = $csv->weight ?? 0;
    $color = $csv->color ?? '';
    $clarity = $csv->clarity ?? '';
    $shape = $csv->shape ?? '';
    $lab = $csv->lab ?? '';
    $basePrice = $csv->total_price ?? 0;
    $csv_type = $csv->lab_grown_natural ?? '';

    // Validate essential fields
    if (empty($weight) || empty($color) || empty($clarity) || empty($shape)) {
        return json_encode([
            'error' => 'Incomplete diamond data in CSV',
            'details' => [
                'weight' => $weight,
                'color' => $color,
                'clarity' => $clarity,
                'shape' => $shape
            ]
        ]);
    }

    // Validate base price
    if (empty($basePrice) || $basePrice <= 0) {
        return json_encode([
            'error' => 'Invalid base price from CSV',
            'details' => [
                'csv_price' => $basePrice,
                'sku' => $sku
            ]
        ]);
    }

    // --- 6. Calculate final price with markup ---
    $c_type = $csv_type == '1' ? "Mined" : "Lab Grown";
    $add_price = $csv_type == '1' ? 'mined_price' : 'lab_grown_price';

    // Get markup percentage
    $markupPercentage = $priceSetupCache->$add_price ?? null;

    if (empty($markupPercentage) || $markupPercentage <= 0) {
        return json_encode([
            'error' => 'Invalid or missing markup percentage',
            'details' => [
                'type' => $c_type,
                'markup_field' => $add_price,
                'markup_value' => $markupPercentage
            ]
        ]);
    }

    // Calculate price with markup
    $calculatedPrice = ($basePrice * $markupPercentage / 100);

    // Round to 2 decimal places (NOT -1 which rounds to nearest 10)
    $priceRounded = round($calculatedPrice, 2);

    // Final price validation
    if ($priceRounded <= 0) {
        return json_encode([
            'error' => 'Price calculation resulted in zero or negative',
            'details' => [
                'base_price' => $basePrice,
                'markup_percentage' => $markupPercentage,
                'calculated_price' => $calculatedPrice,
                'rounded_price' => $priceRounded
            ]
        ]);
    }

    // Format weight for display
    $weightFormatted = number_format($weight, 2) . " ct";
    $variant_title = "$weightFormatted $lab $shape $color/$clarity $c_type";

    // --- 7. Check if variant exists in Shopify ---
    $edges = $meta['data']['productVariants']['edges'] ?? [];
    if (!empty($edges)) {
        $node = $edges[0]['node'];
        if (!empty($node['sku']) && $node['sku'] === $sku) {
            $variantFound = true;
            $variant_id = str_replace("gid://shopify/ProductVariant/", "", $node['id']);

            // Update price if needed
            try {
                $updateResponse = $this->shopify_api($shop, "PUT", "/admin/api/2023-07/variants/$variant_id.json", [
                    'variant' => ['price' => $priceRounded]
                ]);

                // Verify price was updated
                if (isset($updateResponse['variant']['price'])) {
                    $updatedPrice = (float)$updateResponse['variant']['price'];
                    if ($updatedPrice != $priceRounded) {
                        error_log("Warning: Price mismatch after update. Expected: $priceRounded, Got: $updatedPrice");
                    }
                }
            } catch (\Exception $e) {
                return json_encode([
                    'error' => 'Failed to update variant price',
                    'details' => $e->getMessage(),
                    'variant_id' => $variant_id
                ]);
            }
        }
    }

    // --- 8. If not found, create new product/variant ---
    if (!$variantFound) {
        // Build description
        $description = '';
        if (!empty($csv->cert)) {
            $description .= '<p>Certificate: ' . $csv->lab . " " . $csv->cert . "</p>";
        }
        if (!empty($csv->certificate_image)) {
            $description .= '<p>Certificate URL: <a href="' . $csv->certificate_image . '" target="_blank">Link</a></p>';
        }
        if (!empty($csv->external_url)) {
            $description .= '<p>Media: <a href="' . $csv->external_url . '" target="_blank">Media link</a></p>';
        }

        // Memoized image path check
        static $shapeCache = [];
        $src_shape = str_replace(" ", "_", strtolower($shape));
        if (!isset($shapeCache[$src_shape])) {
            $localPath = public_path("/custom/images/addcart/$src_shape.webp");
            $shapeCache[$src_shape] = file_exists($localPath)
                ? asset("public/custom/images/addcart/$src_shape.webp")
                : asset("public/custom/images/shape-$src_shape.svg");
        }
        $src = $shapeCache[$src_shape];

        // Create product via REST API
        $restPayload = [
            'product' => [
                'title' => $variant_title,
                'body_html' => $description,
                'template_suffix' => 'Base Diamond Product',
                'tags' => 'diamonds-product',
                'published' => true,
                'variants' => [[
                    'price' => number_format($priceRounded, 2, '.', ''), // Ensure proper format
                    'sku' => $sku,
                    'option1' => $weightFormatted,
                    'option2' => $color,
                    'option3' => $clarity,
                    'inventory_management' => null,
                    'requires_shipping' => true
                ]],
                'options' => [
                    ['name' => 'Weight'],
                    ['name' => 'Color'],
                    ['name' => 'Clarity']
                ],
                'images' => [['src' => $src]]
            ]
        ];

        try {
            $restCreate = $this->shopify_api($shop, "POST", "/admin/api/2023-07/products.json", $restPayload);

            if (empty($restCreate['product']['variants'][0]['id'])) {
                return json_encode([
                    'error' => 'Product created but variant ID not returned',
                    'details' => $restCreate,
                    'payload' => $restPayload
                ]);
            }

            $variant_id = (string)$restCreate['product']['variants'][0]['id'];
            
            // Verify the price was set correctly
            $createdPrice = (float)($restCreate['product']['variants'][0]['price'] ?? 0);
            if ($createdPrice != $priceRounded) {
                error_log("Warning: Price mismatch on creation. Expected: $priceRounded, Got: $createdPrice");
                
                // Attempt to fix the price immediately
                $this->shopify_api($shop, "PUT", "/admin/api/2023-07/variants/$variant_id.json", [
                    'variant' => ['price' => number_format($priceRounded, 2, '.', '')]
                ]);
            }

        } catch (\Exception $e) {
            return json_encode([
                'error' => 'Failed to create product in Shopify',
                'details' => $e->getMessage(),
                'payload' => $restPayload
            ]);
        }
    }

    // --- 9. Prepare diamond variant cart item ---
    if (empty($variant_id)) {
        return json_encode([
            'error' => 'Variant ID not available',
            'details' => 'Failed to create or find variant in Shopify'
        ]);
    }

    $diamondItem = [
        "id" => $variant_id,
        'quantity' => 1,
        'properties' => [
            '_main_variant' => $variantid,
            '_diamond_variant' => $variant_id,
            '_ring_size' => $_POST['ring_size'] ?? '',
            '_weight' => $_POST['weight'] ?? '',
            '_handle' => $_POST['handle'] ?? '',
            '_carat' => str_replace(" ct", "", $weightFormatted)
        ]
    ];
    
    if (!empty($_POST['diamond_selected'])) {
        $diamondItem['properties']['_diamond_selected'] = 'yes';
        $diamondItem['properties']['_sku'] = $sku;
    }
    
    $output['items'][] = $diamondItem;

    // --- 10. Add main variant (ring) if provided ---
    if (!empty($variantid)) {
        $ringItem = [
            "id" => $variantid,
            'quantity' => 1,
            'properties' => [
                'Ring Size' => $_POST['ring_size'] ?? '',
                '_main_variant' => $variantid,
                '_diamond_variant' => $variant_id,
                '_ring_size' => $_POST['ring_size'] ?? '',
                '_weight' => $_POST['weight'] ?? '',
                '_handle' => $_POST['handle'] ?? '',
                '_carat' => str_replace(" ct", "", $weightFormatted)
            ]
        ];
        
        if (!empty($_POST['diamond_selected'])) {
            $ringItem['properties']['_diamond_selected'] = 'yes';
            $ringItem['properties']['_sku'] = $sku;
        }
        
        $output['items'][] = $ringItem;
    }

    // --- 11. Add success metadata ---
    $output['success'] = true;
    $output['price'] = $priceRounded;
    $output['variant_id'] = $variant_id;
    $output['sku'] = $sku;

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

        $weigCur = explode("-", $input['weight']);
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


  public function diamondMinedLabSmart13_6_24(Request $request)
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
      $shapeDetails = ShapeSetup::select('clarity', 'color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();

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
          $csv_mined = $csv_mined->where('lab_grown_natural', $diamond);
          $csv_mined = $csv_mined->where('shape', $shape);
          $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
          // $csv_mined=$csv_mined->whereIn('color', $color_list);
          // $csv_mined=$csv_mined->whereIn('clarity', $clarity_list);
          // $csv_mined=$csv_mined->whereIn('polish', $polish_list);
          // $csv_mined=$csv_mined->whereIn('symmetry', $symmetry_list);

          if ($shapeDetails[0]->color == 1) {
            $csv_mined = $csv_mined->whereIn('color', $color_list);
          }
          if ($shapeDetails[0]->clarity == 1) {
            $csv_mined = $csv_mined->whereIn('clarity', $clarity_list);
          }
          if ($shapeDetails[0]->cut == 1) {
            if (count(array_intersect($desired_grades, $cut_grade)) === count($desired_grades)) {
              $csv_mined = $csv_mined->where('cut_grade', '');
            } else {
              //$csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
              $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade)->orWhere('cut_grade', '');
            }
          }
          if ($shapeDetails[0]->polish == 1) {
            $csv_mined = $csv_mined->whereIn('polish', $polish_list);
          }
          if ($shapeDetails[0]->symmetry == 1) {
            $csv_mined = $csv_mined->whereIn('symmetry', $symmetry_list);
          }
          if ($min_weight !== null && $max_weight !== null) {
            $csv_mined = $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
          }

          if ($diamond !== null) {
            $csv_mined = $csv_mined->where('lab_grown_natural', $diamond);
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
          return view("frontend/includes/diamond-filter-smart", ['shop' => $shop, 'shape' => $shape, 'templates' => $templates, 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
        } else {
          return "<div class='not-found'>Please select a different shape or carat weight.</div>";
        }
      } else {
        return "<div class='not-found'>Please choose a different shape, this shape does not exist in the global size setup.</div>";
      }
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
        //  print_r($type);
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




      $shapeDetails = ShapeSetup::select('clarity', 'color', 'cut', 'polish', 'symmetry')->where('shape', $shape)->orderBy('id', 'desc')->take(1)->get();

      if (!$shapeDetails->isEmpty()) {

        //check added by deepika
        if ($diamond == 0) {
          $d_type = 'Lab Grown';
        }
        if ($diamond == 1) {
          $d_type = 'Natural';
        }

        $template = DB::table('diamond_templates')->select("*")->where('type', $d_type)->where(['collection_id' => 24813961490, 'status' => 1])
          ->get();

        $desired_grades = ["Ideal", "Excellent", "Very Good"];

        foreach ($template as $template) {
          $id = $template->id;
          $color_list = (array)unserialize($template->color);
          $clarity_list = (array)unserialize($template->clarity);
          $cut_grade = (array)unserialize($template->cut);
          $polish_list = (array)unserialize($template->polish);
          $symmetry_list = (array)unserialize($template->symmetry);
          //   echo "<pre>";
          //  print_r($color_list);
          //  print_r($clarity_list);
          //  print_r($cut_grade);
          //  print_r($polish_list);
          //  print_r($symmetry_list);
          //   print_r($diamond);

          $csv_mined = Csv::where('purchased_diamonds', 0);
          $csv_mined = $csv_mined->where('lab_grown_natural', $diamond);
          $csv_mined = $csv_mined->where('shape', $shape);
          //  $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);

          if ($shapeDetails[0]->color == 1) {
            $csv_mined = $csv_mined->whereIn('color', $color_list);
          }
          if ($shapeDetails[0]->clarity == 1) {
            $csv_mined = $csv_mined->whereIn('clarity', $clarity_list);
          }
          if ($shapeDetails[0]->cut == 1) {
            $csv_mined = $csv_mined->whereIn('cut_grade', $cut_grade);
          }


          //check added by deepika
          if ($shapeDetails[0]->cut == 0) {
            if ($shapeDetails[0]->polish == 1) {
              $csv_mined = $csv_mined->whereIn('polish', $polish_list);
            }
            if ($shapeDetails[0]->symmetry == 1) {
              $csv_mined = $csv_mined->whereIn('symmetry', $symmetry_list);
            }
          }

          if ($min_weight !== null && $max_weight !== null) {
            $csv_mined = $csv_mined->whereBetween('weight', [$min_weight, $max_weight]);
          }

          // if ($diamond !== null) {
          //   $csv_mined = $csv_mined->where('lab_grown_natural', $diamond);
          // }

          //  $sql_query = $csv_mined->orderBy('total_price', 'ASC')->limit(3)->toSql();


          // $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->limit(3)->get()->unique('total_price')->toArray();

          //updated by deepika
          $csv_mined = $csv_mined->orderBy('total_price', 'ASC')->get()->unique('total_price')->take(3)->toArray();


          if (!empty($csv_mined)) {
            if (isset($templates[$template->label])) {
            } else {


              foreach ($csv_mined as $csv_mined) {
                $templates[$template->label][] = $csv_mined;
              }
            }
          }
        }

        //  print_r($templates);
        if (!empty($templates)) {
          return view("frontend/includes/diamond-filter-smart", ['shop' => $shop, 'shape' => $shape, 'templates' => $templates, 'product_setup' => $product_setup, 'priceSetupData' => $priceSetupData]);
        } else {
          return "<div class='not-found'>Please select a different shape or carat weight.</div>";
        }
      } else {
        return "<div class='not-found'>Please choose a different shape, this shape does not exist in the global size setup.</div>";
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
