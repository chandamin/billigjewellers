<!-- Add this in the <head> section -->

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
            <button class='accordin-search smart-search active'>Smart Search</button>
            <button data-type='mined-lab-diamonds-smart' class='accordin-search custom-search ssk1 custom-search-sm'>Custom Search</button>
        </div>
    </div>
    <div class="diamond-filter-container page-width">
      <div class="validation-shape-wrapper">
      <p class='shape-head shape-column'><span>Step 1:</span> Select Shape</p>
      <span class="custom-text-validation-shape shape-column valiadte-text">Please Select to Proceed</span>
        <span class="shape-column empty"></span>
      </div>
        <ul class="ring_images">

            <?php foreach ($filter as $filter_key => $filter_val) {

                $img = str_replace(" ", "_", strtolower($filter_val));

                if (file_exists(public_path("/custom/images/" . $img . ".webp"))) {
                    $shape_image = asset("public/custom/images/" . $img . ".webp");

            ?>
                    <li data-type="<?= $filter_val ?>" class="link-faded">
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


        <div class='second-filter-an smart-second'>
            <div class='filter-cart'>
               <div class="validation-shape-wrapper">
              <p class="shape-column"><span>Step 2: </span> Select Carat Weight</p>
              <span class="custom-text-validation-Carat-Weight shape-column valiadte-text">Please Select to Proceed</span>

              </div>
                    <div class="main-filter-first cl">
                        <div class="main-filter-first-button"><label for="cart-0.5">
                                <input type="checkbox" id="cart-0.5" name="cartFilter[]" value="0.5">
                                <span>0.50</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-1.0">
                                <input type="checkbox" id="cart-1.0" name="cartFilter[]" value="1.0">
                                <span>1.00</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-1.5">
                                <input type="checkbox" id="cart-1.5" name="cartFilter[]" value="1.5">
                                <span>1.50</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-2">
                                <input type="checkbox" id="cart-2" name="cartFilter[]" value="2">
                                <span>2.00</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-2.5">
                                <input type="checkbox" id="cart-2.5" name="cartFilter[]" value="2.5">
                                <span>2.50</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-3">
                                <input type="checkbox" id="cart-3" name="cartFilter[]" value="3">
                                <span>3.00</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-3.5">
                                <input type="checkbox" id="cart-3.5" name="cartFilter[]" value="3.5">
                                <span>3.50</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-4">
                                <input type="checkbox" id="cart-4" name="cartFilter[]" value="4">
                                <span>4.00</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-4.5">
                                <input type="checkbox" id="cart-4.5" name="cartFilter[]" value="4.5">
                                <span>4.50</span></label>
                        </div>
                        <div class="main-filter-first-button"><label for="cart-5">
                                <input type="checkbox" id="cart-5" name="cartFilter[]" value="5">
                                <span>5.00</span></label>
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
            <p class='empty-text'>Please select Diamond Shape and Carat Weight</p>
            <p class='smart-dis'>These are the best <span class="smart-name"><?= ($type == 0) ? "lab grown" : "natural"; ?> </span>choices for you based on price and diamond characteristics:</p>
            <div class="best_pox">
            </div>

        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/><link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/><script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(document).ready(function() {
    let isMobile = window.matchMedia("only screen and (max-width: 768px)").matches; 
    if (isMobile) {
        setTimeout(function() {
  $('.cl_backup').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 3,
    arrows: false,
    dots: false,
    centerMode: true,
    variableWidth: true,
    centerPadding: '40px'

  });
}, 2000);
}
});

</script>