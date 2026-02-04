@include('admin.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<form action="{{ route('update_prices') }}" method="post" id="enable_price" style="padding-bottom: 80px;">
 
<div class="Polaris-Page main_section">

<div
    class="Polaris-Box"
    style="
        --pc-box-padding-block-end-xs: var(--p-space-4);
        --pc-box-padding-block-end-md: var(--p-space-6);
        --pc-box-padding-block-start-xs: var(--p-space-4);
        --pc-box-padding-block-start-md: var(--p-space-6);
        --pc-box-padding-inline-start-xs: var(--p-space-4);
        --pc-box-padding-inline-start-sm: var(--p-space-0);
        --pc-box-padding-inline-end-xs: var(--p-space-4);
        --pc-box-padding-inline-end-sm: var(--p-space-0);
        position: relative;
    "
>
    <div class="Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
        <div class="Polaris-Page-Header__Row">
            <div class="Polaris-Page-Header__TitleWrapper"><h1 class="Polaris-Header-Title" style="display: inline-block;font-size: 23px;"><?php echo env("APP_NAME");?> Setup for <?php //echo ucfirst($product['title']); ?></h1></div>
        </div>
    </div>
</div>
<div class="Polaris-Page Polaris-Page--fullWidth">
  <div class="Polaris-Page__Content">
    <div class="Polaris-Layout">
      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Price Multiple</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> specify the multiple lab grown price and multiple mined price</p>
              </div>
            </div>
          </div>
          <div class="Polaris-Layout__AnnotationContent">
            <div class="Polaris-LegacyCard">
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-InlineGrid" style="--pc-inline-grid-grid-template-columns-xs: minmax(0, 2fr) minmax(0, 1fr); --pc-inline-grid-gap-xs: var(--p-space-300); gap: 20px;
                   align-items: center;">
    
                  <div class="Polaris-wraaper">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label id="mined_price" for="mined_price" class="Polaris-Label__Text">Multiple Mined Price (%)</label>
                      </div>
                    </div>
                  
                   @foreach($priceSetupData as $priceSetup)
                   <?php 
                       $lab_grown_price = $priceSetup->lab_grown_price ;
                       $mined_price = $priceSetup->mined_price;
                   ?>
               @endforeach
               
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input id="mined_price_input" autocomplete="off" class="Polaris-TextField__Input required" type="number" aria-labelledby="mined_priceLabel" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $mined_price; ?>" name="mined_price">
                           <div class="Polaris-TextField__Spinner" aria-hidden="true">
                            <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                              <div class="Polaris-TextField__SpinnerIcon">
                                <span class="Polaris-Icon">
                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M14.53 12.28a.75.75 0 0 1-1.06 0l-3.47-3.47-3.47 3.47a.75.75 0 0 1-1.06-1.06l4-4a.75.75 0 0 1 1.06 0l4 4a.75.75 0 0 1 0 1.06Z">
                                    </path>
                                  </svg>
                                </span>
                              </div>
                            </div>
                            <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                              <div class="Polaris-TextField__SpinnerIcon">
                                <span class="Polaris-Icon">
                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.72 8.47a.75.75 0 0 1 1.06 0l3.47 3.47 3.47-3.47a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 0 1 0-1.06Z">
                                    </path>  
                                  </svg>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="Polaris-TextField__Backdrop">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="Polaris-wraaper">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label id="lab_grown_price_label" for="lab_grown_price_input" class="Polaris-Label__Text">Multiple Lab Grown Price (%)</label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input id="lab_grown_price_input" autocomplete="off" class="Polaris-TextField__Input required" type="number" aria-labelledby="lab_grown_price_label" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $lab_grown_price; ?>"  name="lab_grown_price">
                           <div class="Polaris-TextField__Spinner" aria-hidden="true">
                            <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                              <div class="Polaris-TextField__SpinnerIcon">
                                <span class="Polaris-Icon">
                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M14.53 12.28a.75.75 0 0 1-1.06 0l-3.47-3.47-3.47 3.47a.75.75 0 0 1-1.06-1.06l4-4a.75.75 0 0 1 1.06 0l4 4a.75.75 0 0 1 0 1.06Z">
                                    </path>
                                  </svg>
                                </span>
                              </div>
                            </div>
                            <div role="button" class="Polaris-TextField__Segment" tabindex="-1">
                              <div class="Polaris-TextField__SpinnerIcon">
                                <span class="Polaris-Icon">
                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.72 8.47a.75.75 0 0 1 1.06 0l3.47 3.47 3.47-3.47a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 0 1 0-1.06Z">
                                    </path>
                                  </svg>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="Polaris-TextField__Backdrop">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  
  <div class="Polaris-Layout__Section">
    <div class="Polaris-PageActions">
        <div class="Polaris-LegacyStack Polaris-LegacyStack--spacingTight Polaris-LegacyStack--distributionTrailing">
            <div class="Polaris-LegacyStack__Item">
                 <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantPrimary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter submit_btn" style="background: #000;color: #fff;" type="button">
                    <span class="text_btn">Save</span>
                     <span class="Polaris-Spinner Polaris-Spinner--sizeLarge hidden">
                      <svg viewBox="0 0 44 44" style="fill: #fff;height: 22px;" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z">
                        </path>
                      </svg>
                    </span>

                  </button>
            </div>
        </div>
    </div>
  </div>

    </div>
  </div>
</div>
</div>

 
@foreach($priceSetupData as $priceSetup)
<?php 
    $product_id = $priceSetup->id;
    
?>
@endforeach

<input type="hidden" id="product_id" name="product_id" value="<?php echo  $product_id; ?>">

</form>

<style>
  .Polaris-InlineGrid {
    display: grid;
    grid-template-columns: auto auto;
  }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('.submit_btn').click(function() {
        var minedPrice = $('#mined_price_input').val();
        var labGrownPrice = $('#lab_grown_price_input').val();
        var  product_id = $('#product_id').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/update-prices',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken 
            },
            data: {
                mined_price: minedPrice,
                lab_grown_price: labGrownPrice,
                product_id: product_id
            },
            success: function(response) {
                console.log(response);
                     
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
