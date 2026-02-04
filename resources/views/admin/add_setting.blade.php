@include('admin.header')
<style>
    select{
        padding-left: 10px ;
    }
    select option{
        padding-bottom: 10px ;
    }

    .Polaris-InlineGrid {
        display: grid;
        grid-template-columns: auto auto;
    }
</style>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<form action="" method="post" id="add_setting">
    <div class="Polaris-Page main_section">

        <div class="Polaris-Box" style="
            --pc-box-padding-block-end-xs: var(--p-space-4);
            --pc-box-padding-block-end-md: var(--p-space-6);
            --pc-box-padding-block-start-xs: var(--p-space-4);
            --pc-box-padding-block-start-md: var(--p-space-6);
            --pc-box-padding-inline-start-xs: var(--p-space-4);
            --pc-box-padding-inline-start-sm: var(--p-space-0);
            --pc-box-padding-inline-end-xs: var(--p-space-4);
            --pc-box-padding-inline-end-sm: var(--p-space-0);
            position: relative;
        ">
            <div class="Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
                <div class="Polaris-Page-Header__Row">
                </div>
            </div>
        </div>
        <form action="" method="post" id="form_template">
        <div class="Polaris-Page Polaris-Page--fullWidth" style="background: #FFFFFF;">
            <div class="Polaris-Page__Content">
                <div class="Polaris-Layout">

                    <div class="Polaris-Frame-ContextualSaveBar__Contents" style="max-width: 95%; margin-top: 25px;padding: 0;">
                        <div class="Polaris-Frame-ContextualSaveBar__MessageContainer">
                            <p class="Polaris-Text--root Polaris-Text--headingLg" style="font-size: 25px;font-weight: 500;">Add Diamond Template</p>
                        </div>
                      
                    </div>

                    <div class="Polaris-Layout__AnnotatedSection">
                        <div class="Polaris-Layout__AnnotationWrapper">
                            <div class="Polaris-Layout__Annotation">
                                <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                                    <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Product Collection</h2>
                                    <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                        <p class="Polaris-Text--root Polaris-Text--bodyMd">If the example you have a "ear studs" and "engagement ring" product collection you can create diffrent diamond templates to have show high quality diamond for engagement rings and lower quality diamond for ear studs.</p>
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
                                                        <span class=""><b>Product Collection</b></label>
                                                </div>
                                            </div>
                                            <div class="Polaris-Connected">
                                                <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                    <div class="Polaris-Select">
                                                        <select id=":Rq65:" class="Polaris-Select__Input  required" aria-invalid="false" name="collection_type">
                                                            <option value="" selected="">Select</option>
                                                            @if(!empty($collection))
                                                            @foreach($collection as $collection_data)
                                                            <option value="{{ $collection_data['id'] }}-{{ $collection_data['displayName'] }}">{{ $collection_data['displayName'] }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <div class="Polaris-Select__Content" aria-hidden="true">
                                                            <span class="Polaris-Select__SelectedOption"></span>
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
                                                        <div class="Polaris-Select__Backdrop" id="Rq65-option">
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
                                    <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Table Header Label</h2>
                                    <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                        <p class="Polaris-Text--root Polaris-Text--bodyMd">The label goes to as a header in the table of dimaond results. eg. Ideal, Premimun and Standand. either all tempalte must have labels or none at all. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="Polaris-Layout__AnnotationContent">
                                <div class="Polaris-LegacyCard">
                                    <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                                        <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
                                            <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                                                <div class="">
                                                    <div class="Polaris-Labelled__LabelWrapper">
                                                        <div class="Polaris-Label">
                                                            <label id=":R2q6:Label" for=":R2q6:" class="Polaris-Label__Text">Label</label>
                                                        </div>
                                                    </div>
                                                    <div class="Polaris-Connected">
                                                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                            <div class="Polaris-TextField">
                                                                <input id=":R2q6:" autocomplete="off" class="Polaris-TextField__Input required" type="text" aria-labelledby=":R2q6:Label" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="" required name="label">
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
                    </div>

                    <div class="Polaris-Layout__AnnotatedSection">
                        <div class="Polaris-Layout__AnnotationWrapper">
                            <div class="Polaris-Layout__Annotation">
                                <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                                    <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Diamond Types</h2>
                                    <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                        <p class="Polaris-Text--root Polaris-Text--bodyMd"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="Polaris-Layout__AnnotationContent">
                                <div class="Polaris-LegacyCard">
                                    <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                                        <div class="Polaris-LegacyStack Polaris-LegacyStack--vertical Polaris-LegacyStack--spacingExtraTight">
                                            <div class="Polaris-LegacyStack__Item">
                                                <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
                                                    <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
                                                        <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                                                            <div>
                                                                <div class="Polaris-Labelled__LabelWrapper">
                                                                    <div class="Polaris-Label"> 
                                                                       <label class="Polaris-Label__Text">Diamond Type</label>
                                                                    </div> 
                                                                </div>
                                                                <div class="Polaris-Connected">
                                                                    <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                                        <?php foreach ($labGrownNaturalValues as $value) { ?>
                                                                            <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                                                                <span class="Polaris-Choice__Control">
                                                                                    <span class="Polaris-Checkbox">
                                                                                        <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $value; ?>" name="lab_grown_natural[]">
                                                                                        <span class="Polaris-Checkbox__Backdrop"></span>
                                                                                        <span class="Polaris-Checkbox__Icon">
                                                                                            <span class="Polaris-Icon">
                                                                                                <span class="Polaris-Text--root Polaris-Text--visuallyHidden"></span>
                                                                                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                                    <path fill-rule="evenodd" d="M14.03 7.22a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 3.97-3.97a.75.75 0 0 1 1.06 0Z"></path>
                                                                                                </svg>
                                                                                            </span>
                                                                                        </span>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="Polaris-Choice__Label">
                                                                                    <span><?php echo ($value == '1') ? 'Natural' : 'Lab Grown'; ?></span>
                                                                                    
                                                                                </span> 
                                                                            </label>
                                                                        <?php } ?>
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
                        </div>
                    </div>


                    
                    <div class="Polaris-Layout__AnnotatedSection">
                        <div class="Polaris-Layout__AnnotationWrapper">
                            <div class="Polaris-Layout__Annotation">
                                <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                                    <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Diamond Quality</h2>
                                    <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                        <p class="Polaris-Text--root Polaris-Text--bodyMd">Define the diamond qualities for the template machine learning will match the best diamond in the inventory each time customer searches.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="Polaris-Layout__AnnotationContent">
                                <div class="Polaris-LegacyCard">
                                    <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                                        <div class="Polaris-LegacyStack Polaris-LegacyStack--vertical Polaris-LegacyStack--spacingExtraTight">
    <div class="Polaris-LegacyStack__Item">
        <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
            <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
                <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                    <div class="">
                        <div class="Polaris-Labelled__LabelWrapper">
                            <div class="Polaris-Label"> 
                                <label class="Polaris-Label__Text">Color</label>
                            </div> 
                        </div>
                        <div class="Polaris-Connected">
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
      
                <?php foreach ($distinctColors as $color) { ?>
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                              <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $color; ?>" name="color[]">
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
                            <span><?php echo $color; ?></span>
                          </span> 
                        </label>
                    <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

<div class="Polaris-LegacyStack__Item">
        <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
            <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
                <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                    <div class="">
                        <div class="Polaris-Labelled__LabelWrapper">
                            <div class="Polaris-Label"> 
                                <label class="Polaris-Label__Text">Clarity</label>
                            </div> 
                        </div>
                        <div class="Polaris-Connected">
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
      
                <?php foreach ($distinctClarity as $clarity) { ?>
                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                      <span class="Polaris-Choice__Control">
                        <span class="Polaris-Checkbox">
                              <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $clarity; ?>" name="clarity[]">
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
                            <span><?php echo $clarity; ?></span>
                          </span> 
                        </label>
                    <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

        <div class="Polaris-LegacyStack__Item">
             <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
                 <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
                 <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                    <div class="">
                        <div class="Polaris-Labelled__LabelWrapper">
                            <div class="Polaris-Label"> 
                                <label class="Polaris-Label__Text">Cut</label>
                            </div> 
                        </div>
                        <div class="Polaris-Connected">
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
      

                            <?php foreach ($distinctCut as $cut) { ?>
                                <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                    <span class="Polaris-Choice__Control">
                                    <span class="Polaris-Checkbox">
                                            <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $cut; ?>" name="cut[]">
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
                                        <span><?php echo $cut; ?></span>
                                        </span> 
                                    </label>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

<div class="Polaris-LegacyStack__Item">
    <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
        <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
            <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                <div class="">
                    <div class="Polaris-Labelled__LabelWrapper">
                        <div class="Polaris-Label"> 
                            <label class="Polaris-Label__Text">Polish</label>
                        </div> 
                    </div>
                    <div class="Polaris-Connected">
                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">


                        <?php foreach ($distinctPolish as $polish) { ?>
                            <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                <span class="Polaris-Choice__Control">
                                <span class="Polaris-Checkbox">
                                        <input type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $polish; ?>" name="polish[]">
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
                                    <span><?php echo $polish; ?></span>
                                    </span> 
                                </label>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>

<div class="Polaris-LegacyStack__Item">
    <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-400)">
        <div class="Polaris-BlockStack" style="--pc-block-stack-order:column;--pc-block-stack-gap-xs:var(--p-space-200)" role="group">
            <div class="Polaris-FormLayout__Item Polaris-FormLayout--grouped">
                <div class="">
                    <div class="Polaris-Labelled__LabelWrapper">
                        <div class="Polaris-Label"> 
                            <label class="Polaris-Label__Text">Symmetry</label>
                        </div> 
                    </div>
                    <div class="Polaris-Connected">
                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">


                        <?php foreach ($distinctSymmetry as $symmetry) { ?>
                            <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                <span class="Polaris-Choice__Control">
                                <span class="Polaris-Checkbox">
                                        <input type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="<?php echo $symmetry; ?>" name="symmetry[]">
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
                                    <span><?php echo $symmetry; ?></span>
                                    </span> 
                                </label>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   <div class="Polaris-Frame-ContextualSaveBar__ActionContainer">
                        <div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionTrailing">
                            <div class="Polaris-Stack__Item" style="text-align: center;">
                                <br>
                                <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantTertiary Polaris-Button--sizeLarge Polaris-Button--textAlignCenter submit_btns" type="button" style="border-radius: 3px;font-size: 15px;background: #000;padding: 8px 18px;color:#fff;box-shadow:none;border:none;">
                                    <span class="text_btn">Add Template</span>
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
                    </div>

                </div>
            </div>
        </div>
    </form>

        <div class="Polaris-Page" style="background: #FFFFFF;">
            <div class="Polaris-Box" style="--pc-box-padding-block-start-xs:var(--p-space-400);--pc-box-padding-block-start-md:var(--p-space-600);--pc-box-padding-block-end-xs:var(--p-space-400);--pc-box-padding-block-end-md:var(--p-space-600);--pc-box-padding-inline-start-xs:var(--p-space-400);--pc-box-padding-inline-start-sm:var(--p-space-0);--pc-box-padding-inline-end-xs:var(--p-space-400);--pc-box-padding-inline-end-sm:var(--p-space-0);position:relative">
                <div role="status">
                    <p class="Polaris-Text--root Polaris-Text--visuallyHidden">Saved Diamond Templates. This page is ready</p>
                </div>
                <div class="Polaris-Page-Header--isSingleRow Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
                    <div class="Polaris-Page-Header__Row">
                        <div class="Polaris-Page-Header__TitleWrapper">
                            <div class="Polaris-Header-Title__TitleWrapper">
                                <h1 class="Polaris-Header-Title">Saved Diamond Templates</h1>
                                <p class="Polaris-Text--root">Default template will be used when there is no defined templates for a collection that has diamond-customizer products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin: 30px 0;">
                <div class="Polaris-LegacyCard">
                    <div class="">
                        <div class="Polaris-DataTable__Navigation">
                            <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantTertiary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter Polaris-Button--iconOnly Polaris-Button--disabled" aria-label="Scroll table left one column" aria-disabled="true" type="button" tabindex="-1">
                                <span class="Polaris-Button__Icon">
                                    <span class="Polaris-Icon">
                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M11.764 5.204a.75.75 0 0 1 .032 1.06l-3.516 3.736 3.516 3.736a.75.75 0 1 1-1.092 1.028l-4-4.25a.75.75 0 0 1 0-1.028l4-4.25a.75.75 0 0 1 1.06-.032Z">
                                            </path>
                                        </svg>
                                    </span>
                                </span>
                            </button>
                            <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantTertiary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter Polaris-Button--iconOnly" aria-label="Scroll table right one column" type="button">
                                <span class="Polaris-Button__Icon">
                                    <span class="Polaris-Icon">
                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.72 14.53a.75.75 0 0 1 0-1.06l3.47-3.47-3.47-3.47a.75.75 0 0 1 1.06-1.06l4 4a.75.75 0 0 1 0 1.06l-4 4a.75.75 0 0 1-1.06 0Z">
                                            </path>
                                        </svg>
                                    </span>
                                </span>
                            </button>
                        </div>

                        <div class="Polaris-ActionMenu">
                            <div class="">
                                <div class="Polaris-ButtonGroup Polaris-ButtonGroup--tight">

                                    <div class="Polaris-ButtonGroup__Item">
                                        <div class="Polaris-ActionMenu-SecondaryAction">
                                            <a class="Polaris-Button active-nav setting-tab default" data-tab="All" href="javascript:void(0)">
                                                <span class="Polaris-Navigation__Text">Default</span>
                                            </a>
                                        </div>
                                    </div>
                                    @if(!empty($dataTab))
                                    @foreach($dataTab as $Tab)
                                    <div class="Polaris-ButtonGroup__Item">
                                        <div class="Polaris-ActionMenu-SecondaryAction">
                                            <a class="Polaris-Button setting-tab" data-tab="{{ $Tab }}" href="javascript:void(0)" 
                                            data-cat="<?php echo str_replace(" ","_",strtolower($Tab));?>">
                                                <span class="Polaris-Navigation__Text"> {{ $Tab }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="Polaris-DataTable Polaris-DataTable__ShowTotals Polaris-DataTable__ShowTotalsInFooter">
                            <div class="Polaris-DataTable__ScrollContainer">
                                <form action="" method="post" id="reorder_form">
                                <table class="Polaris-DataTable__Table reorder_table">
                                    <thead>
                                        <tr>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col" style="width: 5%;"></th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Product Collection</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Label</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Color</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Clarity</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Cut</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Polish</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Symmetry</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Type</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="templateData" class="Polaris-DataTable__Table">
                                        @if(!empty($dataDefault))
                                        @php $counter = 1; @endphp
                                        @foreach($dataDefault as $Default)
                                        <?php //echo "<pre>"; print_r($dataDefault); ?>
                                        <tr class="Polaris-DataTable__TableRow Polaris-DataTable--hoverable <?php echo str_replace(" ","_",strtolower($Default->collection_type));?>">
                                            <input type="hidden" name="reorder[]" value="{{$Default->id}}"/>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row"  style="width: 5%;">
                                                <div class="Polaris-Stack__Item"><div tabindex="0" data-rbd-drag-handle-draggable-id="2" data-rbd-drag-handle-context-id="0" aria-labelledby="rbd-lift-instruction-0" draggable="false"><span tabindex="0" aria-describedby="PolarisTooltipContent2"><span class="Polaris-Icon Polaris-Icon--colorInkLightest Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2m0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8m0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14m6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6m0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8m0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14"></path></svg></span></span></div></div>
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{$Default->collection_type}}</td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{$Default->label}}</td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                            <?php echo implode(", ",unserialize($Default->color)); ?></td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                             <?php echo implode(", ",unserialize($Default->clarity)); ?></td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"> <?php echo implode(", ",unserialize($Default->cut)); ?></td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"> 
                                            <?php
                                                $polishData = unserialize($Default->polish);
                                                if (is_array($polishData)) {
                                                    echo implode(", ", $polishData);
                                                } else {
                                                  //  echo "N/A";
                                                }
                                                ?>
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"> 
                                            <?php
                                                $symmetryData = unserialize($Default->symmetry);
                                                if (is_array($symmetryData)) {
                                                    echo implode(", ", $symmetryData);
                                                } else {
                                                   // echo "N/A";
                                                }
                                                ?>
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                            {{$Default->type}}</td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                                <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantSecondary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter delete_template" data-id="{{$Default->id}}" type="button">
                                                    <span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        @php $counter++; @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

