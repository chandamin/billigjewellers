<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiamondTemplate;
use App\Models\ShapeSetup;
use DB;
use Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
class AdminController extends Controller
{

  public function products()
  {

    $enabled = $pid = $p_id = $product = [];
    $ids = $search_ids = '';

    $product_setup = DB::table('product_setup')
      ->select("*")
      ->where(['enable' => 1])
      ->get();

    if (isset($product_setup) && !empty($product_setup)) {
      foreach ($product_setup as $product_setup) {
        $enabled[$product_setup->product_id] = $product_setup->enable;
        $pid[] = $product_setup->product_id;
      }
    }

    if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'enabled' && !empty($pid)) {
      $ids = "&ids=" . implode(",", $pid);
    }

    $product = $this->shopify_api($_REQUEST['shop'], "GET", "/admin/api/2023-07/products.json?limit=250" . $ids);

    if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
      $products = $product['products'];
      $product = [];
      foreach ($products as $item) {
        $title = strtolower($item['title']);
        $search = strtolower($_REQUEST['search']);
        if (str_contains($title, $search)) {

          if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'disabled' && isset($enabled[$item['id']]) && $enabled[$item['id']] == 1) {
            continue;
          }

          $product['products'][] = ['id' => $item['id'], 'title' => $item['title']];
        }
      }
    }

    return view("admin/products")->with(['page' => 'products', 'products' => $product, 'enabled' => $enabled]);
  }

  public function product_setup()
  {

    $product_id = $_GET['id'];

    $product = $this->shopify_api($_GET['shop'], "GET", "/admin/api/2023-07/products/" . $product_id . ".json");
    $options = [];

    $metafields = $this->shopify_api($_GET['shop'], "GET", "/admin/api/2023-07/products/" . $product_id . "/metafields.json");

    foreach ($metafields['metafields'] as $value) {

      if ($value['key'] == 'diamond_shape') {

        $collection_id = $value['value'];
        $shape = $this->metaobject($_GET['shop'], $collection_id, "displayName");

        $name = ucfirst($shape);

        $setup = DB::table('csv_records')
          ->select(\DB::raw('MIN(ratio) AS min_ratio, MAX(ratio) AS max_ratio'))
          ->where('shape', $name)
          ->get();
        if (isset($setup[0])) {
          $setup = $setup[0];
          $options[$shape] =  ['min_ratio' => $setup->min_ratio, 'max_ratio' => $setup->max_ratio];
        }
      }
    }

    $csv = DB::table('csv_records')
      ->select(\DB::raw('MIN(weight) AS min_weight, MAX(weight) AS max_weight'))
      ->get();

    $setup = DB::table('product_setup')->select("*")->where('product_id', $product_id)
      ->get();
    if (isset($setup[0])) {
      $setup = $setup[0];
    }

    return view("admin/product_setup")->with(['page' => 'products', 'csv' => $csv, 'options' => $options, 'product' => $product['product'], 'setup' => $setup]);
  }

  public function enable_product()
  {
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
      $product_id = $_POST['product_id'];
      $insert['type'] = serialize($_POST['type']);
      $insert['pair'] = $_POST['pair'];
      //$insert['lab_grown_price'] = $_POST['lab_grown_price'];
      //$insert['mined_price'] = $_POST['mined_price'];
      $insert['ratio'] = '';
      //$insert['size'] = serialize($_POST['size']);
      if (isset($_POST['ratio'])) {
        $insert['ratio'] = serialize($_POST['ratio']);
      }
      $insert['min_weight'] = $_POST['min_weight'];
      $insert['max_weight'] = $_POST['max_weight'];
      $insert['product_id'] = $product_id;
      $insert['enable'] = $_POST['status'];

      $product_setup = DB::table('product_setup')->select("*")->where('product_id', $product_id)
        ->get();
      if (isset($product_setup[0])) {
        unset($insert['product_id']);
        DB::table('product_setup')
          ->update(
            $insert,
            ['product_id' => $product_id]
          );
      } else {
        DB::table('product_setup')
          ->insert(
            $insert
          );
      }
    }
  }

  public function reorder()
  {

    $rows = $_REQUEST['reorder'];
    $insert = [];
    $templates = DB::table('diamond_templates')->select("*")->get();
    foreach ($templates as $template) {
      $template = (array) $template;
      $insert[$template['id']] = $template;
      unset($insert[$template['id']]['id']);
    }
    DiamondTemplate::truncate();
    foreach ($rows as $row) {
      DB::table('diamond_templates')->insert($insert[$row]);
    }
  }

  public function add_setting(Request $request)
  {

    $input = $request->all();
    $shop = $input['shop'];
    $distinctColors = DB::table('csv_records')
      ->select('color')
      ->distinct()
      ->whereNotNull('color')
      ->pluck('color');
    $distinctColors = $distinctColors->reject(function ($color) {
      return $color === '';
    });
    $distinctClarity = DB::table('csv_records')
      ->select('clarity')
      ->distinct()
      ->whereNotNull('clarity')
      ->pluck('clarity');
    $distinctClarity = $distinctClarity->reject(function ($clarity) {
      return $clarity === '';
    });
    $distinctCut = DB::table('csv_records')
      ->select('cut_grade')
      ->distinct()
      ->whereNotNull('cut_grade')
      ->pluck('cut_grade');
    $distinctCut = $distinctCut->reject(function ($cut) {
      return $cut === '';
    });

      $distinctPolish = DB::table('csv_records')
      ->select('polish')
      ->distinct()
      ->whereNotNull('polish')
      ->pluck('polish');
      
      $distinctPolish = $distinctPolish->reject(function ($polish) {
        return $polish === '';
      });


      $distinctSymmetry = DB::table('csv_records')
      ->select('symmetry')
      ->distinct()
      ->whereNotNull('symmetry')
      ->pluck('symmetry');
        
      $distinctSymmetry = $distinctSymmetry->reject(function ($symmetry) {
        return $symmetry === '';
      });

    $labGrownNaturalValues = DB::table('csv_records')
    ->select('lab_grown_natural')
    ->distinct()
    ->pluck('lab_grown_natural');

    //get collection data
    $metaobjects = '
      {
        metaobjects(first: 100, type: "collection") {
          edges {
            node {
              id
              displayName
            }
          }
        }
      }
      ';
    $getMetaobjects = $this->graphql($shop, $metaobjects);
    $metaobjectsData = $getMetaobjects['data']['metaobjects']['edges'];

    $collection = [];

    foreach ($metaobjectsData as $edge) {
      $node = $edge['node'];
      $id = preg_replace('/[^0-9]/', '', $node['id']);
      $collection[] = [
        'id' => $id,
        'displayName' => $node['displayName'],
      ];
    }

    //Get Saved Diamond Templates
    $dataTab = DiamondTemplate::distinct()->pluck('collection_type');
    $dataDefault = DiamondTemplate::get();
   
    return view("admin/add_setting")->with(['page' => 'add_setting', 'distinctColors' => $distinctColors, 'distinctCut' => $distinctCut, 'distinctClarity' => $distinctClarity, 'collection' => $collection, 'dataTab' => $dataTab, 'dataDefault' => $dataDefault,  'labGrownNaturalValues' => $labGrownNaturalValues,'distinctPolish' => $distinctPolish, 'distinctSymmetry' => $distinctSymmetry ]);
  }


 
  public function addTemplate()
  {
    $validatedData = $_REQUEST;
    $collection = explode("-", $validatedData['collection_type']);
    $collection_type = $collection[1];
    $collection_id = $collection[0];
    $diamondTemplate = new DiamondTemplate();
    $diamondTemplate->label = $validatedData['label'];
    $diamondTemplate->color = serialize($validatedData['color']);
    $diamondTemplate->clarity = serialize($validatedData['clarity']);
    $diamondTemplate->cut = serialize($validatedData['cut']);
    $diamondTemplate->symmetry = serialize($validatedData['symmetry']);
    $diamondTemplate->polish = serialize($validatedData['polish']);
  
    if ((in_array(0, $validatedData['lab_grown_natural']) && in_array(1, $validatedData['lab_grown_natural'])) || 
        (in_array(1, $validatedData['lab_grown_natural']) && in_array(0, $validatedData['lab_grown_natural']))) {
        $diamondTemplate->type = 'Lab Grown, Natural';
    } elseif (in_array(0, $validatedData['lab_grown_natural'])) {
        $diamondTemplate->type = 'Lab Grown';
    } elseif (in_array(1, $validatedData['lab_grown_natural'])) {
        $diamondTemplate->type = 'Natural';
    }

  
    $diamondTemplate->collection_type = $collection_type;
    $diamondTemplate->collection_id = $collection_id;
    $diamondTemplate->status = 1;
    $diamondTemplate->save();

    $data = DiamondTemplate::get();


    return response()->json(['message' => 'Diamond template added successfully', 'data' => $data], 200);
  }
  
  public function addTemplate_11_6_24()
  {
      $validatedData = $_REQUEST;
      $collection = explode("-", $validatedData['collection_type']);
      $collection_type = $collection[1];
      $collection_id = $collection[0];
      
      $diamondTemplate = DiamondTemplate::where('label', $validatedData['label'])
          ->where('collection_type', $collection_type)
          ->first();
      
      if ($diamondTemplate) {
         $message = 'Diamond template updated successfully';
      } else {
          $diamondTemplate = new DiamondTemplate();
          $diamondTemplate->label = $validatedData['label'];
          $message = 'Diamond template added successfully';
      }

      
      $diamondTemplate->color = serialize($validatedData['color']);
      $diamondTemplate->clarity = serialize($validatedData['clarity']);
      $diamondTemplate->cut = serialize($validatedData['cut']);
      $diamondTemplate->symmetry = serialize($validatedData['symmetry']);
      $diamondTemplate->polish = serialize($validatedData['polish']);

      if ((in_array(0, $validatedData['lab_grown_natural']) && in_array(1, $validatedData['lab_grown_natural'])) || 
          (in_array(1, $validatedData['lab_grown_natural']) && in_array(0, $validatedData['lab_grown_natural']))) {
          $diamondTemplate->type = 'Lab Grown, Natural';
      } elseif (in_array(0, $validatedData['lab_grown_natural'])) {
          $diamondTemplate->type = 'Lab Grown';
      } elseif (in_array(1, $validatedData['lab_grown_natural'])) {
          $diamondTemplate->type = 'Natural';
      }

      $diamondTemplate->collection_type = $collection_type;
      $diamondTemplate->collection_id = $collection_id;
      $diamondTemplate->status = 1;
      $diamondTemplate->save();

      $data = DiamondTemplate::get();

      return response()->json(['message' => $message, 'data' => $data], 200);
  }


  public function addTemplate_lab_mined_bkp()
  {
      $validatedData = $_REQUEST;
      $collection = explode("-", $validatedData['collection_type']);
      $collection_type = $collection[1];
      $collection_id = $collection[0];
  
      if (in_array(0, $validatedData['lab_grown_natural']) && in_array(1, $validatedData['lab_grown_natural'])) {
          $type = 'Lab Grown, Natural';
      } elseif (in_array(0, $validatedData['lab_grown_natural'])) {
          $type = 'Lab Grown';
      } elseif (in_array(1, $validatedData['lab_grown_natural'])) {
          $type = 'Natural';
      } else {
          $type = null; 
      }
  
    
      $diamondTemplate = DiamondTemplate::where('label', $validatedData['label'])
          ->where('collection_type', $collection_type)
          ->where('type', 'Lab Grown, Natural')
          ->first();
  
      if ($diamondTemplate) {
      
          $message = 'Diamond template updated successfully';
      } else {
      
          $diamondTemplate = DiamondTemplate::where('label', $validatedData['label'])
              ->where('collection_type', $collection_type)
              ->where('type', $type)
              ->first();
  
          if ($diamondTemplate) {
            
              $message = 'Diamond template updated successfully';
          } else {
              $diamondTemplate = new DiamondTemplate();
              $diamondTemplate->label = $validatedData['label'];
              $message = 'Diamond template added successfully';
          }
      }
  
    
      $diamondTemplate->color = serialize($validatedData['color']);
      $diamondTemplate->clarity = serialize($validatedData['clarity']);
      $diamondTemplate->cut = serialize($validatedData['cut']);
      $diamondTemplate->symmetry = serialize($validatedData['symmetry']);
      $diamondTemplate->polish = serialize($validatedData['polish']);
      $diamondTemplate->type = $type;
      $diamondTemplate->collection_type = $collection_type;
      $diamondTemplate->collection_id = $collection_id;
      $diamondTemplate->status = 1;
      $diamondTemplate->save();
  
    
      $data = DiamondTemplate::get();
  
      return response()->json(['message' => $message, 'data' => $data], 200);
  }
  
 


  public function add_shape_setup(Request $request)
  {

    $input = $request->all();
    //$shop = $input['shop'];
  
    $distinctShape = DB::table('csv_records')
    ->select('shape')
    ->distinct()
    ->whereNotNull('shape')
    ->pluck('shape');

    $distinctShape = $distinctShape->reject(function ($shape) {
      return $shape === '';
    });

    $dataTab = ShapeSetup::distinct()->pluck('shape');
    $dataDefault = ShapeSetup::get();

    return view("admin/add_shape_setup")->with(['page' => 'add_shape_setup', 'dataTab' => $dataTab, 'dataDefault' => $dataDefault, 'distinctShape' => $distinctShape]);
  }
  

    public function addShape(Request $request)
    {
        $validatedData = $request->validate([
            'shape_type' => 'required',
            'colors' => 'required',
            'clarity' => 'required',
            'cut' => 'nullable|array',
            'polish' => 'nullable|array',
            'symmetry' => 'nullable|array',
        ]);

        
        $existingShape = ShapeSetup::where('shape', $validatedData['shape_type'])->first();

        if ($existingShape) {
          
            $existingShape->color = !empty($validatedData['colors']) ? 1 : 0;
            $existingShape->clarity = !empty($validatedData['clarity']) ? 1 : 0;
            $existingShape->cut = !empty($validatedData['cut']) ? 1 : 0;
            $existingShape->polish = !empty($validatedData['polish']) ? 1 : 0;
            $existingShape->symmetry = !empty($validatedData['symmetry']) ? 1 : 0;
            $existingShape->save();

            $message = 'Diamond Shape updated successfully';
        } else {
           
            $ShapeSetup = new ShapeSetup();
            $ShapeSetup->shape = $validatedData['shape_type'];
            $ShapeSetup->color = !empty($validatedData['colors']) ? 1 : 0;
            $ShapeSetup->clarity = !empty($validatedData['clarity']) ? 1 : 0;
            $ShapeSetup->cut = !empty($validatedData['cut']) ? 1 : 0;
            $ShapeSetup->polish = !empty($validatedData['polish']) ? 1 : 0;
            $ShapeSetup->symmetry = !empty($validatedData['symmetry']) ? 1 : 0;
            $ShapeSetup->status = 1;
            $ShapeSetup->save();

            $message = 'Diamond Shape added successfully';
        }

        $data = ShapeSetup::all();

        return response()->json(['message' => $message, 'data' => $data], 200);
    }


    public function addShape_bkp(Request $request)
    {
        $validatedData = $request->validate([
            'shape_type' => 'required',
            'colors' => 'required',
            'clarity' => 'required',
            'cut' => 'nullable|array',
            'polish' => 'nullable|array',
            'symmetry' => 'nullable|array',
        ]);
    
        $ShapeSetup = new ShapeSetup();
        $ShapeSetup->shape = $validatedData['shape_type'];
        $ShapeSetup->color = !empty($validatedData['colors']) ? 1 : 0;
        $ShapeSetup->clarity = !empty($validatedData['clarity']) ? 1 : 0;
        $ShapeSetup->cut = !empty($validatedData['cut']) ? 1 : 0;
        $ShapeSetup->polish = !empty($validatedData['polish']) ? 1 : 0;
        $ShapeSetup->symmetry = !empty($validatedData['symmetry']) ? 1 : 0;
    
        $ShapeSetup->status = 1;
        $ShapeSetup->save();
    
        $data = ShapeSetup::all();
    
        return response()->json(['message' => 'Diamond Shape added successfully', 'data' => $data], 200);
    }
  

  /**
   * Delete template tab data
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function deleteTab(Request $request)
  {
    $item = DiamondTemplate::find($request->id);
    if (!$item) {
      return response()->json(['error' => $e->getMessage()], 500);
    } else {
      $item->delete();
      $data = DiamondTemplate::get();
      return response()->json(['message' => 'Record deleted successfully', 'data' => $data], 200);
    }
  }
  // global price 
  public function global_price_multiple_setup()
  {

    $priceSetupData = DB::table('price_setup')
      ->select("*")
      ->get();

    return view("admin.global_price_multiple_setup", ['priceSetupData' => $priceSetupData]);
  }

  // update global price 
  public function updatePrices(Request $request)
  {
    $productId = $request->input('product_id');
    $minedPrice = $request->input('mined_price');
    $labGrownPrice = $request->input('lab_grown_price');

    DB::table('price_setup')
      ->where('id', $productId)
      ->update(['mined_price' => $minedPrice, 'lab_grown_price' => $labGrownPrice]);

    return response()->json(['success' => true, 'message' => 'Prices updated successfully']);
  }


  //webhook order-create
  public function createOrder(Request $request)
  {

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
  
public function csv()
{
    $csvPath = base_path('../public_html/csv'); // Path to your CSV folder
        
    if (!File::exists($csvPath)) {
        \Log::error("CSV folder not found: $csvPath");
        return;
    }

    $files = File::files($csvPath);

    // Cutoff: anything older than 2 full months ago
    $cutoffDate = now()->subMonthsNoOverflow(2)->startOfMonth();

    foreach ($files as $file) {
        $filename = $file->getFilename();

        if (preg_match('/_(\d{8})-/', $filename, $matches)) {
            $fileDateStr = $matches[1]; // e.g., "20250401"

            try {
                $fileDate = Carbon::createFromFormat('Ymd', $fileDateStr);

                // DELETE if file date is older than cutoff
                if ($fileDate->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    \Log::info("Deleted CSV file: " . $filename);
                }
            } catch (\Exception $e) {
                \Log::error("Invalid date format in file: $filename");
            }
        }
    }
}

}
