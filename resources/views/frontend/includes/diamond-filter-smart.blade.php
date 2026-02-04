<?php

$fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);

$labelOrder = ['Best Quality', 'Better Quality', 'Good Quality'];
$foundLabels = [];

$foundInOrder = [];
$foundNotInOrder = [];

foreach ($templates as $label => $template) {
    if (!empty($template) && isset($label) && !empty($label)) {
        if (in_array($label, $labelOrder)) {
            $foundInOrder[$label] = $template;
        } else {
            $foundNotInOrder[$label] = $template;
        }
    }
}


ksort($foundInOrder);
$sortedTemplates = $foundInOrder + $foundNotInOrder;

foreach ($sortedTemplates as $foundLabel => $templates) {
    ?>
    <p class="smart-qty"><?php echo ucwords($foundLabel); ?></p>
    <ul class="good list-part">
        <?php
        foreach ($templates as $value) {
            $value = (array)$value;
            $img = str_replace(" ", "_", strtolower($shape));
            $shapeImageSrc = asset("public/custom/images/shape-" . $img . ".svg");

            if (file_exists(public_path("/custom/images/" . $img . ".webp"))) {
                $shapeImageSrc = asset("public/custom/images/" . $img . ".webp");
            }
           

            ?>
             
            <li class="list-item-part <?= $value['lab_grown_natural'] == 0 ? 'lab_grown' : 'mined'; ?>" >
                
                <div class='img-sect-1'>
                    <?php if (!empty($value['lab'])) { ?>
                        <span class="certificate_popup list-item-tag-badeeg " data-src="<?php echo $value['certificate_image']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M12.8002 9.06665C12.8002 10.3397 12.2945 11.5606 11.3943 12.4608C10.4941 13.3609 9.27323 13.8667 8.0002 13.8667C6.72716 13.8667 5.50626 13.3609 4.60608 12.4608C3.70591 11.5606 3.2002 10.3397 3.2002 9.06665C3.20069 8.13131 3.47456 7.2165 3.98814 6.43477C4.50172 5.65303 5.23259 5.03846 6.09086 4.66665L6.2786 4.81278L7.1042 5.45385C6.29603 5.65326 5.57776 6.11719 5.06363 6.77184C4.5495 7.42648 4.26904 8.23425 4.26686 9.06665C4.26686 11.1253 5.94153 12.8 8.0002 12.8C10.0589 12.8 11.7335 11.1253 11.7335 9.06665C11.7314 8.23425 11.4509 7.42648 10.9368 6.77184C10.4226 6.11719 9.70436 5.65326 8.8962 5.45385L9.90953 4.66665C10.7678 5.03846 11.4987 5.65303 12.0123 6.43477C12.5258 7.2165 12.7997 8.13131 12.8002 9.06665ZM8.0002 4.79998L10.6669 2.72532L9.6002 1.06665H6.4002L5.33353 2.72532L6.93353 3.97012L8.0002 4.79998Z" fill="black" style="fill:black;fill-opacity:1;" />
                            </svg>
                         <?php
                            if($value['lab'] == 'IGI-NY') {
                                echo 'IGI-Certificate';
                            } else {
                                echo $value['lab'] . ' Certificate';
                            }
                            ?>

                        </span>
                    <?php } ?>
                  <div class="custom-img">
                        <img src="<?php echo $shapeImageSrc; ?>" alt="">
                  </div>
                </div>
                <div class="second-mid">
                    <div class="m-1 title-dia">
                        <h4><?php echo $shape; ?></h4>
                        <p>
                            <div class="diamond_price">
                                <span>
                                    <?php
                                    if (is_array($priceSetupData)) {
                                        $type = $value['lab_grown_natural'] == 1 ? 'mined' : 'lab_grown';

                                        $total_price_str = $value['total_price'];
                                        $total_price_numeric = floatval(preg_replace("/[^0-9.]/", "", $total_price_str));

                                        if (!empty($priceSetupData[0]->{$type . '_price'})) {
                                            $type_price = $priceSetupData[0]->{$type . '_price'};
                                            $price = $total_price_numeric * $type_price / 100;
                                            $rounded_price = round($price, -1);
                                            echo $fmt->formatCurrency($rounded_price, 'USD'); 
                                           // echo $fmt->formatCurrency(ceil($price), 'USD'); 
                                        } else {
                                            echo "Invalid total price.";
                                        }
                                    } else {
                                        echo "Invalid price setup data.";
                                    }
                                    ?>
                                </span>
                            </div>
                        </p>
                    </div>
                    <div class="m-1 sub-title-dia">
                        <div class='mid-main ssk'>
                            <div class='mid-1'>
                           

                            <?php echo number_format($value['weight'], 2); ?>

                            </div>
                            <div class='mid-1-heading'>
                                Carat
                            </div>
                        </div>
                        <div class='mid-main'>
                            <div class='mid-2'>
                                <?php echo $value['color']; ?>
                            </div>
                            <div class='mid-2-heading'>
                                Color
                            </div>
                        </div>
                        <div class='mid-main'>
                            <div class='mid-3'>
                                <?php echo $value['clarity']; ?>
                            </div>
                            <div class='mid-3-heading'>
                                Clarity
                            </div>
                        </div>
                        <div class='mid-main'>
                            <div class='mid-4'>
                            <?php //echo ($value['cut_grade'] == '') ? '&nbsp;' : $value['cut_grade'] ?>
                                <?php

                                
                                 echo !empty(trim($value['cut_grade'])) ? $value['cut_grade'] :
                                     (!empty(trim($value['polish'])) ? $value['polish'] :
                                    (!empty(trim($value['symmetry'])) ? $value['symmetry'] : 'No data'));
                                ?>
                            </div>
                            <div class='mid-4-heading'>
                                Cut
                            </div>
                        </div>
                    </div>
                    <?php //echo $value['stock_number']; ?>
                    <div class="cart-button">
                        <div class="dropdown" id="cartDropdown_">
                            <button class="dropbtn add_jewelry" data-sku="<?php echo $value['stock_number']; ?>">
                                <span class="btn_label">Add to Setting</span>
                                <div class="loading-overlay__spinner hidden">
                                    <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
