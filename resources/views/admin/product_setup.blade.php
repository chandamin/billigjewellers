@include('admin.header')

<form action="" method="post" id="enable_product" style="padding-bottom: 80px;">

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
            <div class="Polaris-Page-Header__TitleWrapper"><h1 class="Polaris-Header-Title" style="display: inline-block;font-size: 23px;"><?php echo env("APP_NAME");?> Setup for <?php echo ucfirst($product['title']); ?></h1></div>
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
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails"><?php echo env("APP_NAME"); ?> Settings</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd">When enabled this product will display the <?php echo env("APP_NAME"); ?> app.</p>
              </div>
            </div>
          </div>

          <div class="Polaris-Layout__AnnotationContent">
            <div class="Polaris-LegacyCard">
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-wraaper">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label id=":Rq65:Label" for=":Rq65:" class="Polaris-Label__Text">
                            <span class=""><?php echo env("APP_NAME"); ?> for <?php echo ucfirst($product['title']); ?> is <?php if(isset($setup->id) && $setup->enable == 1){ echo '<b style="color:green;">Enabled</b>'; }else{ echo '<b style="color:red;">Disabled</b>'; } ?></label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-Select">
                    <select id=":Rq65:" class="Polaris-Select__Input  required" aria-invalid="false" name="status">
                      <option value="0" <?php if(isset($setup->id) && $setup->enable == 0){ echo "selected"; } ?>>Disabled</option>
                      <option value="1" <?php if(isset($setup->id) && $setup->enable == 1){ echo "selected"; } ?>>Enabled</option>
                    </select>
                    <div class="Polaris-Select__Content" aria-hidden="true">
                      <span class="Polaris-Select__SelectedOption"><?php if(isset($setup->id) && $setup->enable == 1){ echo "Enabled"; }else{ echo "Disabled"; } ?></span>
                      <span class="Polaris-Select__Icon">
                        <span class="Polaris-Icon">
                          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                            <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z">
                            </path>
                            <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z">
                            </path>
                          </svg>
                        </span>
                      </span>
                    </div>
                    <div class="Polaris-Select__Backdrop">
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

      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Diamond Types</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> offers both Ethically Mined & Lab Grown diamonds.</p>
              </div>
            </div>
          </div>
          <?php
            $type = [];
            if(isset($setup->type) && !empty($setup->type)){
              $type = unserialize($setup->type);
            }
          ?>
          <div class="Polaris-Layout__AnnotationContent">
            <div class="Polaris-LegacyCard">
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-InlineGrid " style="--pc-inline-grid-grid-template-columns-xs: minmax(0, 2fr) minmax(0, 1fr); --pc-inline-grid-gap-xs: var(--p-space-300);">
                  <div class="Polaris-Labelled--hidden">
                    

                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for=":Rq4:">
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                          <input id=":Rq4:" type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="mined" name="type[]" <?php if(!empty($type) && !in_array("mined", $type)){ }else{ echo "checked"; } ?>>
                          <span class="Polaris-Checkbox__Backdrop">
                          </span>
                          <span class="Polaris-Checkbox__Icon">
                          <span class="Polaris-Icon">
                            <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                            </span>
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                              <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z">
                              </path>
                            </svg>
                          </span>
                        </span>
                        </span>
                      </span>
                      <span class="Polaris-Choice__Label">
                        <span>Mined</span>
                      </span>
                    </label>

                  </div>
                  <div class="Polaris-Labelled--hidden">
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for=":Rq5:">
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                          <input id=":Rq5:" type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="lab_grown"  name="type[]" <?php if(!empty($type) && !in_array("lab_grown", $type)){ }else{ echo "checked"; } ?>>
                          <span class="Polaris-Checkbox__Backdrop">
                          </span>
                          <span class="Polaris-Checkbox__Icon">
                            <span class="Polaris-Icon">
                              <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                              </span>
                              <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z">
                                </path>
                              </svg>
                            </span>
                          </span>
                        </span>
                      </span>
                      <span class="Polaris-Choice__Label">
                        <span>Lab Grown</span>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Single Or Matched Pair</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> show single diamond options and matched pair options for this product .</p>
              </div>
            </div>
          </div>
           
                
          <div class="Polaris-Layout__AnnotationContent">
            <div class="Polaris-LegacyCard">
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-wraaper">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label id=":Rq6:Label" for=":Rq6:" class="Polaris-Label__Text">Single Or Matched Pair</label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-Select">
                    <select id=":Rq6:" class="Polaris-Select__Input  required" aria-invalid="false" name="pair">
                      <option value="False" <?php if(isset($setup->id) && $setup->pair == 'False'){ echo "selected"; } ?>>Single</option>
                      <option value="True" <?php if(isset($setup->id) && $setup->pair == 'True'){ echo "selected"; } ?>>Matched Pair</option>
                    </select>
                    <div class="Polaris-Select__Content" aria-hidden="true">
                      <span class="Polaris-Select__SelectedOption"><?php if(isset($setup->id) && $setup->pair == 'True'){ echo "Matched Pair"; }else{ echo "Single"; } ?></span>
                      <span class="Polaris-Select__Icon">
                        <span class="Polaris-Icon">
                          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                            <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z">
                            </path>
                            <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z">
                            </path>
                          </svg>
                        </span>
                      </span>
                    </div>
                    <div class="Polaris-Select__Backdrop">
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


<!-- 
      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Ring Size</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> specify what ring sizes the product contain.</p>
              </div>
            </div>
          </div>
          <div class="Polaris-Layout__AnnotationContent size_section">
            <div class="Polaris-LegacyCard">
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-InlineGrid" style="--pc-inline-grid-grid-template-columns-xs: minmax(0, 2fr) minmax(0, 1fr); --pc-inline-grid-gap-xs: var(--p-space-300);">
                     <div class="Polaris-Labelled--hidden">
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for="check_all">
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                          <input id="check_all" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="">
                          <span class="Polaris-Checkbox__Backdrop">
                          </span>
                          <span class="Polaris-Checkbox__Icon">
                          <span class="Polaris-Icon">
                            <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                            </span>
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                              <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z">
                              </path>
                            </svg>
                          </span>
                        </span>
                        </span>
                      </span>
                      <span class="Polaris-Choice__Label">
                        <span>Check/Uncheck All</span>
                      </span>
                    </label>
                  </div>

                  <div class="product-container">
                    <div class="product-details">
                    </div>
                    <div class="ring-size-label">
                     <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for=":Rq7:">
                        <span class="Polaris-Choice__Control">
                          <span class="Polaris-Checkbox">
                            <input id=":Rq7:" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" name="size[]" value="no_size">
                            <span class="Polaris-Checkbox__Backdrop"></span>
                            <span class="Polaris-Checkbox__Icon Polaris-Checkbox--animated">
                              <svg viewBox="0 0 16 16" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">
                                <path class="Polaris-Checkbox--checked" d="M1.5,5.5L3.44655,8.22517C3.72862,8.62007,4.30578,8.64717,4.62362,8.28044L10.5,1.5" transform="translate(2 2.980376)" opacity="0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" pathLength="1"></path>
                              </svg>
                            </span>
                          </span>
                        </span>
                        <span class="Polaris-Choice__Label">
                          <span>This product does not have ring sizes</span>
                        </span>
                      </label>
                    </div>
                  </div>
               
                  <?php
                    $size = [];
                    if(isset($setup->size) && !empty($setup->size)){
                      $size = unserialize($setup->size);
                    }
                  ?>

                  <?php for ($i = 4; $i <= 8; $i += 0.5) { ?>
                  <div class="Polaris-Labelled--hidden">
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for=":Rq:<?php echo $i;?>">
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                          <input id=":Rq:<?php echo $i;?>" type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $i;?>" <?php if(!empty($size) && in_array($i, $size)){ echo "checked"; } ?>  name="size[]">
                          <span class="Polaris-Checkbox__Backdrop">
                          </span>
                          <span class="Polaris-Checkbox__Icon">
                          <span class="Polaris-Icon">
                            <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                            </span>
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                              <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z">
                              </path>
                            </svg>
                          </span>
                        </span>
                        </span>
                      </span>
                      <span class="Polaris-Choice__Label">
                        <span><?php echo $i;?></span>
                      </span>
                    </label>
                  </div>
                <?php } ?>
              
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Diamond Weights</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> specify the minimum and maximum carat weights the design can be made in.</p>
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
                        <label id="min_weight" for="min_weight" class="Polaris-Label__Text">Min Weight(ct)</label>
                      </div>
                    </div>
                    <?php 
                      $min_weight = $max_weight = 0;
                      
                      if(isset($csv[0]->min_weight)){ $min_weight = $csv[0]->min_weight; }
                      if(isset($setup->min_weight)){ $min_weight = $setup->min_weight; }

                      if(isset($csv[0]->max_weight)){ $max_weight = $csv[0]->max_weight; }
                      if(isset($setup->max_weight)){ $max_weight = $setup->max_weight; }
                    ?>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input id="min_weight" autocomplete="off" class="Polaris-TextField__Input required" type="number" aria-labelledby="min_weightLabel" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $min_weight; ?>" name="min_weight">
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
                        <label id="max_weight_label" for="max_weight_input" class="Polaris-Label__Text">Max Weight(ct)</label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input id="max_weight_input" autocomplete="off" class="Polaris-TextField__Input required" type="number" aria-labelledby="max_weight_label" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $max_weight; ?>"  name="max_weight">
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

      {{-- <div class="Polaris-Layout__AnnotatedSection">
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
                    <?php 
                      $lab_grown_price = $mined_price = '';
                      
                      if(isset($setup->lab_grown_price)){ $lab_grown_price = $setup->lab_grown_price; }

                      if(isset($setup->mined_price)){ $mined_price = $setup->mined_price; }
                    ?>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input id="mined_price" autocomplete="off" class="Polaris-TextField__Input required" type="number" aria-labelledby="mined_priceLabel" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $mined_price; ?>" name="mined_price">
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
      </div> --}}

      <div class="Polaris-Layout__AnnotatedSection">
        <div class="Polaris-Layout__AnnotationWrapper">
          <div class="Polaris-Layout__Annotation">
            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
              <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Diamond Ratio</h2>
              <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                <p class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo env("APP_NAME"); ?> for non round shapes only, specify the ratio(length/width) range the product can hold.</p>
              </div>
            </div>
          </div>
          
          <?php
            $ratio = [];
            if(isset($setup->ratio) && !empty($setup->ratio)){
              $ratio = unserialize($setup->ratio);
            }
          ?>

          <div class="Polaris-Layout__AnnotationContent">
            <div class="Polaris-LegacyCard">
              <?php foreach ($options as $value => $ratio) { 
                 $min_ratio = $max_ratio = $present_ratio = 0;

                    if(isset($ratio['min_ratio'])){
                      $min_ratio = $ratio['min_ratio']; 
                    }
                    if(isset($ratio['max_ratio'])){
                      $max_ratio = $ratio['max_ratio']; 
                    }
                    //  if(isset($ratio[$value]['present_ratio'])){
                    //   $present_ratio = $ratio[$value]['present_ratio']; 
                    // }

                 if(isset($setup->ratio)){

                    $ratio = unserialize($setup->ratio);

                    if(isset($ratio[$value]['min_ratio'])){
                      $min_ratio = $ratio[$value]['min_ratio']; 
                    }
                    if(isset($ratio[$value]['max_ratio'])){
                      $max_ratio = $ratio[$value]['max_ratio']; 
                    }
                    //  if(isset($ratio[$value]['present_ratio'])){
                    //   $present_ratio = $ratio[$value]['present_ratio']; 
                    // }
                 }
                ?>
              <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                <div class="Polaris-InlineGrid" style="--pc-inline-grid-grid-template-columns-xs: minmax(0, 2fr) minmax(0, 1fr); --pc-inline-grid-gap-xs: var(--p-space-300);     grid-template-columns: auto auto auto;     gap: 20px;
                   align-items: center;">
                  <div class="Polaris-Labelled--hidden">
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" for="shapes">
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                          <input type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $value;?>" name="ratio[<?php echo $value;?>][name]" checked>
                          <span class="Polaris-Checkbox__Backdrop">
                          </span>
                          <span class="Polaris-Checkbox__Icon">
                            <span class="Polaris-Icon">
                              <span class="Polaris-Text--root Polaris-Text--visuallyHidden">
                              </span>
                              <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z">
                                </path>
                              </svg>
                            </span>
                          </span>
                        </span>
                      </span>
                      <span class="Polaris-Choice__Label">
                        <span><?php echo ucfirst($value); ?></span>
                      </span>
                    </label>
                  </div>

                  <div class="Polaris-wraaper">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label for="min_ratio" class="Polaris-Label__Text">Min Ratio</label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input autocomplete="off" class="Polaris-TextField__Input" type="number" aria-labelledby="min_ratioLabel" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $min_ratio; ?>"  name="ratio[<?php echo $value;?>][min_ratio]">
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
                        <label for="max_ratio" class="Polaris-Label__Text">Max Ratio</label>
                      </div>
                    </div>
                    <div class="Polaris-Connected">
                      <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                        <div class="Polaris-TextField Polaris-TextField--hasValue">
                          <input autocomplete="off" class="Polaris-TextField__Input" type="number" aria-labelledby="min_ratioLabel" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php echo $max_ratio; ?>" name="ratio[<?php echo $value;?>][max_ratio]">
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
              <?php } ?>
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
<input type="hidden" name="product_id" value="<?php echo $product['id'];?>">

</div>
</form>

<style>
  .Polaris-InlineGrid {
    display: grid;
    grid-template-columns: auto auto;
  }
</style>