@include('frontend.header')
<div class="filter-diamond-origin selectDataDia">
    <button type="button" class="lab-grown active-diamond getTypeData">Lab Grown</button>
    <button type="button" class="natural getTypeData">Natural</button>
</div>

<div class="sub_title selectDataDia addDataaa">These are the best <span id="selected_type">Lab Grown</span> choices for your setting based on price and diamond characteristics:</div>
<div class="table-responsive">
    <table class="diamondtable">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);


            //$types = ['mined', 'lab_grown'];
            $i = 0;
            foreach ($templates  as $label => $tamplate) {
                if (!empty($tamplate)) {

                    if (isset($label) && !empty($label)) {
            ?>
                        <tr></tr>
                        <tr></tr>
                        <tr class="outer-tr">

                            <td class="label_td" colspan="3">


                                <?php if (empty($diamond_selected)) {  ?>

                                    <div class="mobile_img">
                                        <span>
                                            <?php echo ucwords($label); ?>
                                        </span>
                                    </div>
                                <?php } ?>


                            </td>

                        </tr>



                        <?php }



                    if (isset($tamplate)) {

                        foreach ($tamplate as $value) {

                            $value = (array) $value;


                        ?>

                            <tr class="inner_tr <?= $value['lab_grown_natural'] == 0 ? 'lab_grown' : 'mined'; ?>">

                                <?php
                                if ($value['lab_grown_natural'] == 1) {
                                    $type = 'mined';
                                }
                                if ($value['lab_grown_natural'] == 0) {
                                    $type = 'lab_grown';
                                }
                                ?>
                                <td class="uui_hover first_td">

                                    <div>
                                        <?php if (!empty($shape_image)) { ?>
                                            <div class="diamond_img">
                                                <img src="<?php echo $shape_image; ?>" />
                                            </div>
                                        <?php } ?>
                                        <div class="input_checkbox">

                                            <input type="checkbox" data-sku="<?php echo  number_format($value['weight'], 2) . 'ct .  ' . $value['color'] . '  .  ' . $value['clarity']; ?>" data-certificate="<?php echo $value['certificate_image']; ?>" class="checkbox_ids" name="sku" value="<?php echo $value['stock_number']; ?>" <?php if (!empty($diamond_selected) && $diamond_selected == $value['stock_number']) {
                                                                                                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                                                                                                        } ?> />
                                        </div>

                                    </div>
                                </td>

                                <td class="uui_hover">
                                    <div class="titleTabss">Carat</div>
                                   
                                    <div class="titleValuess"> <?php echo number_format($value['weight'], 2); ?></div>
                                </td>
                                <td class="uui_hover">
                                    <div class="titleTabss">Color</div>
                                    <div class="titleValuess"> <?php echo $value['color']; ?> </div>
                                </td>
                                <td class="uui_hover">
                                    <div class="titleTabss">Clarity</div>
                                    <div class="titleValuess"> <?php echo $value['clarity']; ?> </div>
                                </td>
                                <td class="uui_hover">
                                    <div class="titleTabss">Cut</div>
                                    <div class="titleValuess">
                                        <?php
                                        echo !empty(trim($value['cut_grade'])) ? $value['cut_grade'] : (!empty(trim($value['polish'])) ? $value['polish'] : (!empty(trim($value['symmetry'])) ? $value['symmetry'] : 'No data'));
                                        ?>
                                        <?php 
                                        //echo ($value['cut_grade'] == '') ? '&nbsp;' : $value['cut_grade']
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="certi-video">
                                        <?php if (!empty($value['external_url'])) { ?>
                                            <a style="color: #000;font-size: 0;" class="video_popup" target="_blank" href="<?php echo $value['external_url']; ?>">
                                                <img src="<?= asset('public/custom/images/search/picture-1.svg') ?>" />
                                            </a>
                                        <?php } ?>
                                        <?php if (!empty($value['certificate_image'])) { ?>
                                            <button class="certificate_popup" data-src="<?php echo $value['certificate_image']; ?>">
                                                <img alt="Certificate" title='Certificate' src="<?= asset('public/custom/images/search/features-alt.svg') ?>">
                                            </button>
                                        <?php }  ?>
                                    </div>
                                </td>
                                <td class="uui_hover">
                                    <?php

                                    $typ = $type . '_price';
                                    if (isset($priceSetupData[0]->$typ)) {
                                        $value['total_price'] = ($value['total_price'] * $priceSetupData[0]->$typ / 100);
                                    }
                                    
                                    $value['total_price'] = round($value['total_price'], -1);
                                    ?>
                                    
                                    <input type="hidden" class="unit_price" value="<?php echo $value['total_price']; ?>">
                                    <span class="price_money">
                                        <?php
                                        echo $fmt->formatCurrency($value['total_price'], "USD");
                                        //echo $fmt->formatCurrency(ceil($value['total_price']), "USD");
                                        ?></span>
                                </td>
                            </tr>


            <?php }
                    }
                    $i++;
                }
            } ?>

        </tbody>
    </table>
</div>
<?php if (!empty($diamond_selected)) {  ?>
    <div class="table_bottom"><span class="change_variant">Change Diamond</span></div>
<?php } ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".filter-diamond-origin button").click(function() {
            $(".filter-diamond-origin button").removeClass("active-diamond");
            $(this).addClass("active-diamond");
            var type = $(this).hasClass("lab-grown") ? 'lab_grown' : 'natural';
            console.log("Selected type:", type);
            $("#selected_type").text(type === 'lab_grown' ? 'Lab Grown' : 'Natural');

            $(".outer-tr").show();
            $(".outer-tr").each(function() {
                var $outerTr = $(this);
                var innerTrsVisible = false;
                $outerTr.nextUntil(".outer-tr", ".inner_tr").each(function() {
                    var isLabGrown = $(this).hasClass('lab_grown');
                    var shouldShow = type === 'lab_grown' ? isLabGrown : !isLabGrown;
                    $(this).toggle(shouldShow);

                    if (shouldShow) {
                        innerTrsVisible = true;
                    }
                });

                if (!innerTrsVisible) {
                    $outerTr.hide();
                }

                // var isOuterTrVisible = $('.outer-tr:visible').length > 0;
                // if (isOuterTrVisible) {
                //     $('.addDataaa').html('<div class="sub_title selectDataDia addDataaa">These are the best <span id="selected_type">'+type+'</span>  choices for your setting based on price and diamond characteristics:</div>');
                // } else {
                //     $('.addDataaa').text('No data Found for ' + (type === 'lab_grown' ? 'Lab Grown' : 'Natural'));
                //// $('.addDataaa').html('<div class="sub_title selectDataDia addDataaa">No data Found for ' + (type === 'lab_grown' ? 'Lab Grown' : 'Natural') + '</div>');
                // }

            });
        });
    });

    function price() {
        $('tr.inner_tr').removeClass('checked-row');
        var total_price = jQuery(".product_price").val();
        if (jQuery(".checkbox_ids:checked").length > 0) {
                jQuery(".checkbox_ids:checked").each(function() {
                var price = jQuery(this).parents("tr").find(".unit_price").val();
                total_price = parseFloat(total_price) + parseFloat(price);

            });

            $('input[name="sku"]:checked').parents('tr.inner_tr').addClass('checked-row');
            jQuery(".cart_total_price").show();
            jQuery(".cart_total_price").html('Ring total: ' + USDollar.format(total_price));

            jQuery(".add_to_cart").prop("disabled", false);
        } else {
            jQuery(".add_to_cart").prop("disabled", true);
            jQuery(".cart_total_price").hide();
        }



    }

    jQuery(document).ready(function() {
        let USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        price();

        jQuery(".checkbox_ids").on("click change", function() {

            $('.checkbox_ids').not(this).prop('checked', false);
            price();
        })

    });
</script>
<?php if (empty($diamond_selected)) { ?>
    <script>
        jQuery(document).ready(function() {
            jQuery(".uui_hover").on("click", function() {

                var item = jQuery(this).parents("tr");

                //item.find(".diamond_img").hide();
                //item.find(".input_checkbox").show();

                //if(!jQuery(this).hasClass("first_td")){

                if (!item.find(".input_checkbox input").is(":checked")) {
                    jQuery('.checkbox_ids').prop('checked', false);
                    item.find(".input_checkbox input").prop("checked", true);
                    item.css("background-color", "#fbfbfb");
                } else {
                    item.find(".input_checkbox  input").prop("checked", false);
                    item.css("background-color", "none");
                }
                //}
                price();
            })
            jQuery(".uui_hover").on("mouseenter", function() {
                var item = jQuery(this).parents("tr");
                //item.find(".diamond_img").hide();
                //item.find(".input_checkbox").show();
                //item.find(".input_checkbox").css('display' , 'flex');
                item.css("background-color", "#fbfbfb");
                item.css("cursor", "pointer");

                // item.parents('tr.inner_tr').css("cursor","pointer");


            })
            jQuery(".uui_hover").on("mouseleave", function() {
                var item = jQuery(this).parents("tr");
                if (!item.find(".input_checkbox  input").is(":checked")) {
                    item.find(".diamond_img").show();
                    item.find(".input_checkbox").hide();
                    item.css("background-color", "none");
                }
            })
        });
    </script>
<?php } ?>