<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CronController;
use Log;
use Osiset\ShopifyApp\Messaging\Jobs\WebhookInstaller;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
   //   Route::middleware(['auth.shopify'])->group(function(){
   //     Route::get('/', function () {
   //        return view('welcome');   
   //     })->name('home');
   //   });
      Route::get('/import',[CsvController::class, 'cron']);
      Route::get('/delete_product',[CronController::class, 'delete_product']);

      /* admin URLs */
      Route::get('/',[AdminController::class, 'products'])->name('products');
      Route::get('/product_setup',[AdminController::class, 'product_setup'])->name('setup');
      Route::post('/enable_product', [AdminController::class, 'enable_product']);
      Route::any('/add_setting', [AdminController::class, 'add_setting']);
      Route::any('/add-template', [AdminController::class, 'addTemplate']);
      Route::any('/delete-tab', [AdminController::class, 'deleteTab'])->name('delete.tab');
      Route::post('/reorder', [AdminController::class, 'reorder']);
            
      /* admin global price */
      Route::get('/global-price-multiple-setup',[AdminController::class, 'global_price_multiple_setup'])->name('global_price_multiple_setup');
      Route::post('/update-prices', [AdminController::class, 'updatePrices'])->name('update_prices');
       Route::any('/csvs', [AdminController::class, 'csv'])->name('csv');
      /* admin shape setup */
      
      Route::any('/add_shape_setup', [AdminController::class, 'add_shape_setup']);
      Route::any('/add-shape', [AdminController::class, 'addShape']);
    
      /* frontend URLs */
      Route::post('/get_templates', [FrontController::class, 'get_templates']);
      Route::post('/search_records', [FrontController::class, 'search_records']);
      Route::post('/generate', [FrontController::class, 'generate']);
      Route::post('/diamond_collection', [FrontController::class, 'diamond_collection']);
      Route::post('/get_price', [FrontController::class, 'get_price']);
      Route::post('/get_sidebar', [FrontController::class, 'get_sidebar']);
      Route::post('/search_product', [FrontController::class, 'search_product']);
      Route::any('/lbDiamonds', [FrontController::class, 'lbDiamonds'])->name('lb.diamonds');
      Route::any('/mined-lab-diamonds', [FrontController::class, 'diamondMinedLab'])->name('mined.lab.diamonds');

      
      Route::any('/lbDiamondsSmart', [FrontController::class, 'lbDiamondsSmart'])->name('lb.diamonds.smart');
      Route::any('/mined-lab-diamonds-smart', [FrontController::class, 'diamondMinedLabSmart'])->name('mined.lab.diamonds.smart');
   /*  artisan commands routes*/
   Route::get('/cache', function () {
      Artisan::call('cache:clear');
      return "cache clear successfully";
   });
   Route::get('/optimize', function () {
      Artisan::call('optimize:clear');
      return "optimize clear successfully";
   });
   Route::get('/config', function () {
      Artisan::call('config:clear');
      return "config clear successfully";
   });
   Route::get('/migrate', function () {
      Artisan::call('migrate');
      return "migrate successfully";
   });
   Route::get('/version', function () {
      Artisan::call('--version');
      return "controller created successfully";
   });

   Route::get('/createcron', function () {
      Artisan::call('make:command PurchaseCron --command=Purchase:cron');
      return "Cron created successfully";
   });
Route::get('/csvcron', function () {
      Artisan::call('make:command Csvoptimize --command=Csvoptimize:cron');
      return "Cron created successfully";
   });
   Route::get('/orders-crt', function () {
      Artisan::call('shopify-app:make:webhook OrdersCreateJob orders/create');
      return "cache clear successfully";
   });

   // Route::get('/orders-create-webhook', function () {
   //    $webhook = fopen("php://input", "rb");
   //    $webhook_content = "";
   //    while (!feof($webhook)) {
   //       $webhook_content .= fread($webhook, 4096);
   //    }
   //    fclose($webhook);
   //    $order_arr = json_decode($webhook_content, true);
   //    Log::info("her===========================");
   // });

   Route::any('/orders-create-webhook', [AdminController::class, 'createOrder'])->name('order.create');

 
/*  end artisan commands routes*/