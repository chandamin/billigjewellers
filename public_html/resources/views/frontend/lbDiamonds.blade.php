@include('frontend.header')

<div class="hidden_section" style="display:none;">
    @include('frontend.includes.sidebar')
    @include('frontend.includes.popup')
</div>

<div class="an_page-width hidden_section" style="display:none;">

    <div class="wraper-width">
        <h1 class="ring_images-heading"><?php if ($type == 1) {
                                            echo "Mined";
                                        } else {
                                            echo "Lab Grown";
                                        } ?> Diamonds</h1>
        <!-- <button class="diamond-guide">Guide</button> -->
    </div>
    <div class='diamond-header'>
        <h3>Select your stones shape and quality</h3>
        <p>Use the filters below to begin designing your perfect engagement ring</p>
        <div class="ssk-custom-wrapper">
            <button class='accordin-search smart-search'>Smart Search</button>
            <button data-type='mined-lab-diamonds' class='accordin-search custom-search ssk-custom-class'>Custom Search</button>
            <!-- <button data-type='mined-lab-diamonds' class='accordin-search custom-search ssk active'>Custom Search</button> -->
        </div>
    </div>
    <div class="diamond-filter-container page-width">

        <ul class="ring_images">
            <?php foreach ($filter as $filter_key => $filter_val) {

                $img = str_replace(" ", "_", strtolower($filter_val));

                if (file_exists(public_path("/custom/images/" . $img . ".webp"))) {
                    $shape_image = asset("public/custom/images/" . $img . ".webp");

            ?>
                    <li data-type="<?= $filter_val ?>" class="link-faded <?= ($filter_val == 'Round') ? 'active-ring' : '' ?>">
                        <a href="javascript:void(0);">
                            <div class="img_div">
                                <img src="<?= $shape_image ?>">
                            </div>
                            <?= $filter_val ?>
                        </a>
                    </li>
            <?php }
            } ?>
        </ul>

        <div class="Select-filters-btn">
        <button class="button">Select Filters</button>
        </div>

        <div class='first-filter-an'>
            <div class='filter-color'>
                <p>Color</p>
                <div class="main-filter-first">
                    <?php
                    // foreach ($color as $color_key => $color_val) {
                    //     if ($color_val != '') {
                    ?>
                    {{-- <button class="fil-color color color-btn <?= //$color_val ?>" data-color="<?= //$color_val ?>"><?= //$color_val ?></button> --}}
                           
                    <?php  
                    //}
                    //}
                    ?>
                    <?php
                    
                    $orderData = ['D', 'E', 'F', 'G', 'H', 'I', 'J'];
                   // $orderData = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'U', 'Y-Z'];
                    
                    foreach ($orderData as $order_val) {
                        if ($order_val != '') {
                    ?>
                            <button class="fil-color color color-btn <?= $order_val ?>" data-color="<?= $order_val ?>"><?= $order_val ?></button>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>



            <div class='filter-clarity'>
                <p>Clarity</p>
                <div class="main-filter-first">
                    <?php
                    //foreach ($clarity as $clarity_key => $clarity_val) {
                    ?>
                       <!-- {{-- <button class="fil-clarity clarity clarity-btn <?= // $clarity_val ?>" data-clarity="<?= //$clarity_val ?>"><?= //$clarity_val ?></button> --}} -->
                    <?php  
                    // }
                    ?>
                    <?php
                    
                    $orderedClarityValues = ['FL', 'IF', 'VVS1', 'VVS2', 'VS1', 'VS2', 'SI1', 'SI2'];
                    //$orderedClarityValues = ['FL', 'IF', 'VVS1', 'VVS2', 'VS1', 'VS2', 'SI1', 'SI2', 'SI3', 'I1', 'I2'];
                    
                    foreach ($orderedClarityValues as $clarity_val) {
                        if ($clarity_val != '') {
                    ?>
                         <button class="fil-clarity clarity clarity-btn <?= $clarity_val ?>" data-clarity="<?= $clarity_val ?>"><?= $clarity_val ?></button>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class='filter-cut'>
                <p>Cut</p>
                <div class="main-filter-first">
                    <?php
                    // foreach ($cut as $cut_key => $cut_val) {
                    //     if ($cut_val != '') {
                    ?>
                     {{-- <button class="fil-cut cut cut-btn <?= //$cut_val ?>" data-cut="<?= //$cut_val ?>"><?= //$cut_val ?></button> --}}
                     <?php 
                    //  }
                    // }
                    ?>
                      <?php

                      $cutArray = ['Ideal', 'Excellent', 'Very Good', 'Good'];

                      foreach ($cutArray as $cut_val) {
                          if ($cut_val != '') {
                      ?>

                       <button class="fil-cut cut cut-btn <?= $cut_val ?>" data-cut="<?= $cut_val ?>"><?= $cut_val ?></button>

                      <?php
                          }
                      }
                      ?>
                </div>
            </div>
        </div>
        <div class='second-filter-an'>
        <div class='filter-carat-weight'>
            <p>Carat Weight</p>
            <div id="slider-range"></div>
            <input type='hidden' id='max-min' value='<?= $weightMin ?>-<?= $weightMax ?>'>
            <div class="min-max-p">
                <div class="mix_po">
                    <div class="mini_mum">minimum</div>
                    <input type="number" step="0.1" min='0' max='15' value="<?= $weightMin ?>" id="minimum">

                    <div class="w-8-mx"><button type="button" class="btn-max increaseBtnmin"> <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                                <path d="M1.25 4.5L4.25 1.5L7.25 4.5" stroke="#8F8F8F" style="stroke:#8F8F8F;stroke:color(display-p3 0.5608 0.5608 0.5608);stroke-opacity:1;" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button><button type="button" class="svg_icon decreaseBtnmin"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                                <path d="M1.25 1.5L4.25 4.5L7.25 1.5" stroke="#8F8F8F" style="stroke:#8F8F8F;stroke:color(display-p3 0.5608 0.5608 0.5608);stroke-opacity:1;" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button></div>
                </div>
                <div class="center_border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="5" viewBox="0 0 42 5" fill="none">
                        <line y1="2.75" x2="41" y2="2.75" stroke="#7E7E7E" style="stroke:#7E7E7E;stroke:color(display-p3 0.4941 0.4941 0.4941);stroke-opacity:1;" stroke-width="0.5" />
                        <line x1="0.25" y1="1.09278e-08" x2="0.25" y2="5" stroke="#7E7E7E" style="stroke:#7E7E7E;stroke:color(display-p3 0.4941 0.4941 0.4941);stroke-opacity:1;" stroke-width="0.5" />
                        <line x1="41.25" y1="1.09278e-08" x2="41.25" y2="5" stroke="#7E7E7E" style="stroke:#7E7E7E;stroke:color(display-p3 0.4941 0.4941 0.4941);stroke-opacity:1;" stroke-width="0.5" />
                    </svg>
                </div>
                <div class="max_po">
                    <div class="mini_mum">maximum</div>
                    <input type="number" min='0' max='15' value="<?= $weightMax ?>" id="maximum" >

                    <div class="w-8-mx"><button type="button" class="btn-max increaseBtnmax">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                                <path d="M1.25 4.5L4.25 1.5L7.25 4.5" stroke="#8F8F8F" style="stroke:#8F8F8F;stroke:color(display-p3 0.5608 0.5608 0.5608);stroke-opacity:1;" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>

                        <button type="button" class="svg_icon decreaseBtnmax"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6" fill="none">
                                <path d="M1.25 1.5L4.25 4.5L7.25 1.5" stroke="#8F8F8F" style="stroke:#8F8F8F;stroke:color(display-p3 0.5608 0.5608 0.5608);stroke-opacity:1;" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>

            <div class='filter-diamond-origin' data-type="<?= ($type == 0) ? "lab_grown" : "mined"; ?>">
                <p>Diamond Origin</p>
                <button class='lab-grown <?php if ($type == 0) { ?> active-diamond <?php }  ?>'>Lab Grown</button>
                <!-- <input type="checkbox" id="diamondOrigin" name="diamondOrigin" value="0" <?php if ($type == 1) {
                                                                                                }  ?>> -->
                <button class='natural <?php if ($type == 1) { ?> active-diamond <?php }  ?>'>Natural</button>
            </div>


            <div class='filter-certificate'>
                <p>Certificate</p>
                <div class="Certificate_btn">
                    <?php
                    foreach ($lab as $lab_key => $lab_val) {
                        if ($lab_val != ''  &&  $lab_val == 'GIA' ||  $lab_val == 'IGI' ||  $lab_val == 'GCAL') {
                    ?>
                            <div class="gia-button">
                                <label for="lab-<?= $lab_val ?>">
                                    <input type="checkbox" id="lab-<?= $lab_val ?>" name="labFilter[]" value="<?= $lab_val ?>">
                                    <span><?= $lab_val ?></span></label>
                            </div>
                    <?php  }
                    }
                    ?>
                </div>
            </div>

        </div>



    </div>

    <div class="diamon_filter_Section" style="text-align: center;padding: 20px;">
        <div class="loading-overlay__spinner" style="width: 100px;">
            <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle class="path" fill="none" stroke-width="3" cx="33" cy="33" r="30"></circle>
            </svg>
        </div>
    </div>




    <div class="image-section an_page-width hidden_section" style="display:none;">
        <div class="page-width">
            <p class='display-showing-text'></p>
            <ul class="list-part">

            </ul>
            <div class="pagination" id="pagination">
                <a href="#" class="page-link" data-page="prev">&laquo;</a>
                <span class="page-numbers"></span>
                <a href="#" class="page-link" data-page="next">&raquo;</a>
            </div>
        </div>
    </div>
    
    <script>
        console.log("Loaded....");
        var min = parseFloat($("#minimum").val());
        var max = parseFloat($("#maximum").val());
        SliderData(min, max);

        function SliderData(min, max) {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 15,
                step: 0.1,  // Allow decimal steps
                values: [min, max],
                slide: function(event, ui) {
                    $("#minimum").val(ui.values[0]);
                    $("#maximum").val(ui.values[1]);
                    $("#max-min").val(ui.values[0] + "-" + ui.values[1]);
                    $("input").trigger("select");
                }
            });
        }

        $(document).ready(function() {
            var inputField = $("#minimum");
            var increaseBtn = $(".increaseBtnmin");
            var decreaseBtn = $(".decreaseBtnmin");

            var inputField_m = $("#maximum");
            var increaseBtn_m = $(".increaseBtnmax");
            var decreaseBtn_m = $(".decreaseBtnmax");

            // min
            increaseBtn.click(function() {
                var value = parseFloat(inputField.val());
                if (value < 15) { // Add check to not exceed max
                    inputField.val((value + 0.1).toFixed(1));
                    SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                    $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                    $("input").trigger("select");
                    $(".filter-carat-weight").trigger('click')
                }
            });

            decreaseBtn.click(function() {
                var value = parseFloat(inputField.val());
                if (value > 0) {
                    inputField.val((value - 0.1).toFixed(1));
                    SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                    $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                    $("input").trigger("select");
                    $(".filter-carat-weight").trigger('click')
                }
            });

            // max
            increaseBtn_m.click(function() {
                var value = parseFloat(inputField_m.val());
                if (value < 15) { // Add check to not exceed max
                    inputField_m.val((value + 0.1).toFixed(1));
                    SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                    $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                    $("input").trigger("select");
                    $(".filter-carat-weight").trigger('click')
                }
            });

            decreaseBtn_m.click(function() {
                var value = parseFloat(inputField_m.val());
                if (value > 0) {
                    inputField_m.val((value - 0.1).toFixed(1));
                    SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                    $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                    $("input").trigger("select");
                    $(".filter-carat-weight").trigger('click')
                }
            });

           $("#maximum").change(function() {
                   var value = parseFloat(inputField_m.val());
                   console.log("#maximum",value)
                   if (value < 15) { // Add check to not exceed max
                       inputField_m.val((value + 0.1).toFixed(1));
                       SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                       $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                       $("input").trigger("select");
                       $(".filter-carat-weight").trigger('click')
                   }
               });

               $("#minimum").change(function() {
                   var value = parseFloat(inputField_m.val());
                   if (value > 0) {
                       inputField_m.val((value - 0.1).toFixed(1));
                       SliderData(parseFloat($("#minimum").val()), parseFloat($("#maximum").val()));
                       $("#max-min").val($("#minimum").val() + "-" + $("#maximum").val());
                       $("input").trigger("select");
                       $(".filter-carat-weight").trigger('click')
                   }
               });
        });
    </script>

<script>
jQuery(document).ready(function() {
    // color
    let prevSelectedBtn = null;
    let doubleClickTimer;

    $("body").on("click", ".color-btn", function() {
        const currentBtn = $(this);
        const color = currentBtn.data("color");

        if (doubleClickTimer) {
            clearTimeout(doubleClickTimer);
            doubleClickTimer = null;
            $(".color-btn").addClass("active").css({ "border": "none", "border-radius": "0" });
            $(".color-btn.active:first").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-left": "2px solid #2D75FF",
                "border-top-left-radius": "4px",
                "border-bottom-left-radius": "4px"
            });
            $(".color-btn.active:last").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-right": "2px solid #2D75FF",
                "border-top-right-radius": "4px",
                "border-bottom-right-radius": "4px"
            });
            $(".color-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF", "border-radius": "0" });
            prevSelectedBtn = null;
        } else {
            if (!prevSelectedBtn) {
                $(".color-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
                currentBtn.addClass("active").css({ "border": "2px solid #2D75FF", "border-radius": "4px" });
                prevSelectedBtn = currentBtn;
            } else {
                const startIndex = $(".color-btn").index(prevSelectedBtn);
                const endIndex = $(".color-btn").index(currentBtn);
                $(".color-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
                $(".color-btn").slice(Math.min(startIndex, endIndex), Math.max(startIndex, endIndex) + 1).addClass("active");

                
                $(".color-btn.active").css({ "border-radius": "0" });

               
                $(".color-btn.active:first").css({
                    "border-top": "2px solid #2D75FF",
                    "border-bottom": "2px solid #2D75FF",
                    "border-left": "2px solid #2D75FF",
                    "border-top-left-radius": "4px",
                    "border-bottom-left-radius": "4px"
                });
                $(".color-btn.active:last").css({
                    "border-top": "2px solid #2D75FF",
                    "border-bottom": "2px solid #2D75FF",
                    "border-right": "2px solid #2D75FF",
                    "border-top-right-radius": "4px",
                    "border-bottom-right-radius": "4px"
                });
                $(".color-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF" });

                prevSelectedBtn = currentBtn;
            }
            doubleClickTimer = setTimeout(function() {
                doubleClickTimer = null;
            }, 300);
        }
        currentColor = [];
        $(".color-btn.active").each(function() {
            currentColor.push($(this).data("color"));
        });
    });
});
// clarity

let prevSelectedBtnClarity = null;
let doubleClickTimerClarity;

$("body").on("click", ".clarity-btn", function() {
    const currentBtnClarity = $(this);
    const clarity = currentBtnClarity.data("clarity");

    if (doubleClickTimerClarity) {
        clearTimeout(doubleClickTimerClarity);
        doubleClickTimerClarity = null;
        $(".clarity-btn").addClass("active").css({ "border": "none", "border-radius": "0" });
        $(".clarity-btn.active:first").css({
            "border-top": "2px solid #2D75FF",
            "border-bottom": "2px solid #2D75FF",
            "border-left": "2px solid #2D75FF",
            "border-top-left-radius": "4px",
            "border-bottom-left-radius": "4px"
        });
        $(".clarity-btn.active:last").css({
            "border-top": "2px solid #2D75FF",
            "border-bottom": "2px solid #2D75FF",
            "border-right": "2px solid #2D75FF",
            "border-top-right-radius": "4px",
            "border-bottom-right-radius": "4px"
        });
        $(".clarity-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF", "border-radius": "0" });
        prevSelectedBtnClarity = null;
    } else {
        if (!prevSelectedBtnClarity) {
            $(".clarity-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
            currentBtnClarity.addClass("active").css({ "border": "2px solid #2D75FF", "border-radius": "4px" });
            prevSelectedBtnClarity = currentBtnClarity;
        } else {
            const startIndexClarity = $(".clarity-btn").index(prevSelectedBtnClarity);
            const endIndexClarity = $(".clarity-btn").index(currentBtnClarity);
            $(".clarity-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
            $(".clarity-btn").slice(Math.min(startIndexClarity, endIndexClarity), Math.max(startIndexClarity, endIndexClarity) + 1).addClass("active");

            $(".clarity-btn.active").css({ "border-radius": "0" });
  
            $(".clarity-btn.active:first").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-left": "2px solid #2D75FF",
                "border-top-left-radius": "4px",
                "border-bottom-left-radius": "4px"
            });
            $(".clarity-btn.active:last").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-right": "2px solid #2D75FF",
                "border-top-right-radius": "4px",
                "border-bottom-right-radius": "4px"
            });
            $(".clarity-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF" });

            prevSelectedBtnClarity = currentBtnClarity;
        }
        doubleClickTimerClarity = setTimeout(function() {
            doubleClickTimerClarity = null;
        }, 300);
    }
    currentclarity = [];
    $(".clarity-btn.active").each(function() {
        currentclarity.push($(this).data("clarity"));
    });
});
// cut
let prevSelectedBtncut = null;
let doubleClickTimercut;

$("body").on("click", ".cut-btn", function() {
    const currentBtncut = $(this);
    const cut = currentBtncut.data("cut");

    if (doubleClickTimercut) {
        clearTimeout(doubleClickTimercut);
        doubleClickTimercut = null;
        $(".cut-btn").addClass("active").css({ "border": "none", "border-radius": "0" });
        $(".cut-btn.active:first").css({
            "border-top": "2px solid #2D75FF",
            "border-bottom": "2px solid #2D75FF",
            "border-left": "2px solid #2D75FF",
            "border-top-left-radius": "4px",
            "border-bottom-left-radius": "4px"
        });
        $(".cut-btn.active:last").css({
            "border-top": "2px solid #2D75FF",
            "border-bottom": "2px solid #2D75FF",
            "border-right": "2px solid #2D75FF",
            "border-top-right-radius": "4px",
            "border-bottom-right-radius": "4px"
        });
        $(".cut-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF", "border-radius": "0" });
        prevSelectedBtncut = null;
    } else {
        if (!prevSelectedBtncut) {
            $(".cut-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
            currentBtncut.addClass("active").css({ "border": "2px solid #2D75FF", "border-radius": "4px" });
            prevSelectedBtncut = currentBtncut;
        } else {
            const startIndexcut = $(".cut-btn").index(prevSelectedBtncut);
            const endIndexcut = $(".cut-btn").index(currentBtncut);
            $(".cut-btn").removeClass("active").css({ "border": "none", "border-radius": "0" });
            $(".cut-btn").slice(Math.min(startIndexcut, endIndexcut), Math.max(startIndexcut, endIndexcut) + 1).addClass("active");

            $(".cut-btn.active").css({ "border-radius": "0" });

            $(".cut-btn.active:first").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-left": "2px solid #2D75FF",
                "border-top-left-radius": "4px",
                "border-bottom-left-radius": "4px"
            });
            $(".cut-btn.active:last").css({
                "border-top": "2px solid #2D75FF",
                "border-bottom": "2px solid #2D75FF",
                "border-right": "2px solid #2D75FF",
                "border-top-right-radius": "4px",
                "border-bottom-right-radius": "4px"
            });
            $(".cut-btn.active:not(:first):not(:last)").css({ "border-top": "2px solid #2D75FF", "border-bottom": "2px solid #2D75FF" });

            prevSelectedBtncut = currentBtncut;
        }
        doubleClickTimercut = setTimeout(function() {
            doubleClickTimercut = null;
        }, 300);
    }
    currentcut = [];
    $(".cut-btn.active").each(function() {
        currentcut.push($(this).data("cut"));
    });
});

</script>
  
<style>
    .color-filter {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    }

    .color-btn {
    padding: 8px 16px;
    background-color: #f1f1f1;
    border: none;
    cursor: pointer;
    margin-right: 5px;
    /* border-radius: 4px; */
    }

    .color-btn.active {
    background-color: #333;
    color: #fff;
    }

    .clarity-filter {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    }

    .clarity-btn {
    padding: 8px 16px;
    background-color: #f1f1f1;
    border: none;
    cursor: pointer;
    margin-right: 5px;
   
    }

    .clarity-btn.active {
    background-color: #333;
    color: #fff;
    }


    .cut-filter {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    }

    .cut-btn {
    padding: 8px 16px;
    background-color: #f1f1f1;
    border: none;
    cursor: pointer;
    margin-right: 5px;
    /* border-radius: 4px; */
    }

    .cut-btn.active {
    background-color: #333;
    color: #fff;
    }

  /* button.fil-clarity.clarity.clarity-btn.active {
        border-radius: 4px !important ;
        
    }
    button.fil-clarity.clarity.clarity-btn.active {
        border-radius: 4px !important;
    } */
/*
    button.fil-clarity.clarity.clarity-btn.active:not(:first-child) {
        border-top-right-radius: 4px !important;
        border-bottom-right-radius: 4px !important;
    }

    button.fil-clarity.clarity.clarity-btn.active:not(:last-child) {
        border-top-left-radius: 4px !important;
        border-bottom-left-radius: 4px !important;
    }*/
</style>