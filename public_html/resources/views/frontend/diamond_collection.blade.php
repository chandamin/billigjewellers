<?php if(isset($csv[0]) && !empty($csv[0])){ 
    $csv = $csv[0];
//     echo "<pre>";
// print_r($priceSetupData); die('kk');
    ?>
@include('frontend.header')

<div class="diamond_section" style="display: none;">
    <div class="diamond-info_section">
    <h2 class="diamond-collection-title">Add your Diamond</h2>

    <div class="diamond-info-wrapper">
    <div class="diamond-shape">
        <img src="<?php echo asset("public/custom/images/".strtolower($csv->shape).".webp");?>" alt="<?php echo $csv->shape;?>">
    </div>
    <div class="diamond-info">
        <p class="singleDiamondTitle">
            <?php 
            $fmt = new NumberFormatter( 'en-US', NumberFormatter::CURRENCY );

                $v = [];
                
                $v[] = number_format($csv->weight, 2)."ct";

                if($csv->lab_grown_natural == '1'){
                    $v[] = "Mined";
                 }else{
                    $v[] = "Lab Grown";
                 }
              $v[] = $csv->shape;
              $v[] = $csv->color."/".$csv->clarity;
              echo implode(" ", $v);
             ?></p>
    </div>
    <div class="diamond-price">
        <div class="singleDiamondPrice">
            <?php 
                //echo $fmt->formatCurrency($csv->total_price, "USD"); 
                      if ($csv->lab_grown_natural === 1) {
                            $type = 'mined';
                        } elseif ($csv->lab_grown_natural === 0) {
                            $type = 'lab_grown';
                        }
                        $total_price_str = $csv->total_price;
                        $total_price_numeric = floatval(preg_replace("/[^0-9.]/", "", $total_price_str));
                        $type_price = $priceSetupData->first()->{$type.'_price'} ?? null;

                        if ($type_price !== null) {
                            $price = $total_price_numeric * $type_price / 100;
                            $formatted_price = '$' . number_format($price, 2);
                            echo $formatted_price;
                        } else {
                            echo "Invalid total price.";
                        }
                
            ?></div>
    </div>
</div>
</div>
<h2 class="diamond-collection-title">─ to the perfect settings below ─</h2>
<div class="image-section">
    <ul class="diamond_grid list-part">
        <?php if(!empty($product_variants)){ 
            foreach ($product_variants as $variant) {
                ?>
        <li class="list-item-part" style="border: none;">
         <a href="/products/<?php echo $variant['handle']."?variant=".$variant['id']."&diamond_selected=".$csv->stock_number; ?>" style="text-decoration: none;color:#000 !important;">
            <div class="card-wrapper">
                <div class="card__inner">
                    <div class="card__media">
                        <img src="<?php echo $variant['image']; ?>" alt="<?php echo $variant['title']; ?>" class="motion-reduce" loading="lazy" width="2962" height="2962">
                    </div>
                </div>
                <div class="diamond_card_content">
                    <div class="diamond_card_information">
                        <h3 class="diamond_card_heading">
                         
                                <?php echo $variant['title']; ?>
                            
                        </h3>
                        <div class="diamonds_price">
                         <?php echo $fmt->formatCurrency($variant['price'], "USD"); ?></div>
                    </div>
                </div>
         </a>
        </li>
       <?php } }  ?>

    </ul>
</div>
</div>
<?php } ?>