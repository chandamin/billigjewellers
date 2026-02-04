@include('frontend.header')

<form action="" method="post" id="cart_form">

  <?php if (!empty($diamond_selected) && !empty($selected)) { ?>
    <script>
      jQuery(document).ready(function() {
        search_records();
      });
    </script>
  <?php } ?>
  <div class="product-form__input--dropdown diamond_size_section" <?php if (!empty($diamond_selected) && !empty($selected)) {
                                                                    echo "style='display:none;'";
                                                                  } ?>>
    <div class="select" style="width: 50%;">
      <select name="weight" id="diamond_size" class="select__select">
        <option value="">Select Carat Weight</option>
        <?php foreach ($size as $size_key => $size_val) {
          if ($size_key >= $size_min_weight && $size_key <= $size_max_weight) {
            echo "<option value='" . $size_key . "'>" . $size_val . "</option>";
          }
        } ?>
      </select>
    </div>
  </div>

  <input type="hidden" name="variant_id" class="variantid" value="<?php echo $variant_id; ?>">
  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
  <input type="hidden" name="price" class="product_price" value="<?php echo $price; ?>">
  <input type="hidden" name="shop" value="<?php echo $shop; ?>">
  <input type="hidden" name="handle" value="<?php echo $handle; ?>">
  <div class="uui-relative">
    <div class="diamond_records"></div>
    <div class="loader_sec" style="text-align: center;padding: 20px;display: none;">
      <div class="loading-overlay__spinner"><svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
          <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
        </svg></div>
    </div>
  </div>
  <div class="cart_total_price">
    <?php
    // $fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
    // echo $fmt->formatCurrency($price, "USD");
    ?>
  </div>

  <div id="error-message"></div>
  <div class="product-form_buttons">
    <button class="button button--full-width button--primary add_to_cart" disabled>
      <span>Add to Cart</span>
      <div class="loading-overlay__spinner hidden">
        <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
          <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
        </svg>
      </div>
    </button>
</form>
<div class="btn-share-now"></div>
</div>

