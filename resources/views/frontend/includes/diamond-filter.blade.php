<?php

$fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
// echo "<pre>";
// print_r($priceSetupData); die('kk');

foreach ($csv as $index => $csv_data) {
    $img = str_replace(" ", "_", strtolower($csv_data->shape));

    $shapeImageSrc = asset("public/custom/images/shape-" . $img . ".svg");

    if (file_exists(public_path("/custom/images/" . $img . ".webp"))) {
        $shapeImageSrc = asset("public/custom/images/" . $img . ".webp");
    }

    $ratio = (float)$csv_data->ratio;
    $dimensions = str_replace('|', ' x ', $csv_data->dimension);
    $certificate_image = $csv_data->certificate_image ?
        '<button class="certificate_popup" data-src="' . $csv_data->certificate_image . '">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="3 3 29 30" fill="none" width="16px" height="16px" class="uui-fill-current uui-text-ublue">
                <title>Certificate</title>
                <path d="M27.708 32.583H7.292a4.375 4.375 0 0 1-4.375-4.375V4.875c0-.806.653-1.458 1.458-1.458h20.417c.805 0 1.458.652 1.458 1.458v17.5h5.833v5.833a4.375 4.375 0 0 1-4.375 4.375Zm-1.458-7.291v2.916a1.458 1.458 0 1 0 2.917 0v-2.916H26.25Zm-2.917 4.374V6.334h-17.5v21.875c0 .806.653 1.459 1.459 1.459h16.041ZM8.75 10.709h11.667v2.917H8.75v-2.917Zm0 5.833h11.667v2.917H8.75v-2.916Zm0 5.834h7.292v2.916H8.75v-2.916Z"></path>
            </svg>
        </button>' : '';
?>

    <li class="list-item-part">
        <div class='img-sect-1' >
            <?php
            if ($csv_data->lab != '') {
                
          ?>
        
                <span class="certificate_popup list-item-tag-badeeg custom-popuppp" data-src="<?php echo $csv_data->certificate_image; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M12.8002 9.06665C12.8002 10.3397 12.2945 11.5606 11.3943 12.4608C10.4941 13.3609 9.27323 13.8667 8.0002 13.8667C6.72716 13.8667 5.50626 13.3609 4.60608 12.4608C3.70591 11.5606 3.2002 10.3397 3.2002 9.06665C3.20069 8.13131 3.47456 7.2165 3.98814 6.43477C4.50172 5.65303 5.23259 5.03846 6.09086 4.66665L6.2786 4.81278L7.1042 5.45385C6.29603 5.65326 5.57776 6.11719 5.06363 6.77184C4.5495 7.42648 4.26904 8.23425 4.26686 9.06665C4.26686 11.1253 5.94153 12.8 8.0002 12.8C10.0589 12.8 11.7335 11.1253 11.7335 9.06665C11.7314 8.23425 11.4509 7.42648 10.9368 6.77184C10.4226 6.11719 9.70436 5.65326 8.8962 5.45385L9.90953 4.66665C10.7678 5.03846 11.4987 5.65303 12.0123 6.43477C12.5258 7.2165 12.7997 8.13131 12.8002 9.06665ZM8.0002 4.79998L10.6669 2.72532L9.6002 1.06665H6.4002L5.33353 2.72532L6.93353 3.97012L8.0002 4.79998Z" fill="black" style="fill:black;fill-opacity:1;" />
                    </svg>
                    <?php
        
                      if ($csv_data->lab == 'IGI-NY') {
                          echo 'IGI-Certificate';
                      } else {
                          echo $csv_data->lab . ' Certificate';
                      }
                      ?>
                </span>
            <?php } ?>
            <div  class="custom-img">
                <img src="<?php echo $shapeImageSrc; ?>" alt="">
            </div>
        </div>
        <div class="second-mid">
            <div class="m-1 title-dia">
                <h4><?php echo  $csv_data->shape; ?></h4>
                <p>
                <div class="diamond_price">
                    <span>
                        <?php

                        ?>
                        <?php
                        // echo $fmt->formatCurrency($csv_data->total_price, "USD");
                        if ($csv_data->lab_grown_natural === 1) {
                            $type = 'mined';
                        } elseif ($csv_data->lab_grown_natural === 0) {
                            $type = 'lab_grown';
                        }
                        $total_price_str = $csv_data->total_price;
                        $total_price_numeric = floatval(preg_replace("/[^0-9.]/", "", $total_price_str));
                        $type_price = $priceSetupData->first()->{$type . '_price'} ?? null;

                        if ($type_price !== null) {
                            $price = $total_price_numeric * $type_price / 100;
                            $rounded_price = round($price, -1);
                            $formatted_price = '$' . number_format($rounded_price, 2);
                           // $formatted_price = '$' . number_format(ceil($price), 2);
                            echo $formatted_price;
                        } else {
                            echo "Invalid total price.";
                        }

                        ?>

                    </span>
                </div>
                </p>
            </div>
            <div class="m-1 sub-title-dia">

                <div class='mid-main'>
                    <div class='mid-1 ssk'>
                        <?php echo number_format($csv_data->weight, 2); ?>
                    </div>
                    <div class='mid-1-heading'>
                        Carat
                    </div>
                </div>
                <div class='mid-main'>
                    <div class='mid-2 ssk2'>
                        <?php echo $csv_data->color ?>
                    </div>
                    <div class='mid-2-heading'>
                        Color
                    </div>
                </div>
                <div class='mid-main ssk3'>
                    <div class='mid-3'>
                        <?php echo $csv_data->clarity ?>
                    </div>
                    <div class='mid-3-heading'>
                        Clarity
                    </div>
                </div>
                <div class='mid-main ssk4'>
                    <div class='mid-4'>
                    
                        <?php echo ($csv_data->cut_grade == '') ? '&nbsp;' : $csv_data->cut_grade ?>
                    </div>
                    <div class='mid-4-heading'>
                        Cut
                    </div>
                </div>


            </div>

            <div class="cart-button">
                <div class="dropdown" id="cartDropdown_<?php echo $index; ?>">
                    <button class="dropbtn add_jewelry " data-sku="<?php echo $csv_data->stock_number; ?>">
                    <span class="btn_label">Add to Setting
                                <!-- <span class="drop-b-arrow"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8" width="14px" height="14px" class="uui-ml-2 uui-fill-current uui-text-white">
                                    <path d="m7 5.173 4.95-4.95 1.415 1.414L7 8 .637 1.637 2.05.223 7 5.173Z"></path>
                                </svg></span> stroke:#fff !important;-->
                            </span>
                        <div class="loading-overlay__spinner hidden">
                            <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30" style=""></circle>
                            </svg>
                        </div>
                    </button>
                    <!-- <div class="dropdown-content" id="myDropdown_<?php // echo $index; ?>">
                        <button class="add_diamond">To You Cart</button>
                        <button class="add_jewelry btn_disabled" disabled>Add to Setting <span></span></button>
                    </div> -->
                </div>
            </div>
    </li>
<?php
}

$lastPage = $csv->lastPage();

$firstItem = $csv->firstItem();
$lastItem = $csv->lastItem();
$totalItems = $csv->total();

$showingText = "Showing ".$firstItem."–".$lastItem." of ".$totalItems." results";
?>
<input type='hidden' class='total-records' value='<?= $lastPage ?>' />
<input type='hidden' class='showing-text' value='<?= $showingText ?>' />