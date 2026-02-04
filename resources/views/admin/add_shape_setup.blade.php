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

<form action="" method="post" id="add_shape_setup">
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
                        <p class="Polaris-Text--root Polaris-Text--headingLg" style="font-size: 25px;font-weight: 500;">Add Shape Set Up</p>
                    </div>
                </div>

                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                                <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Shape</h2>
                                <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                    <p class="Polaris-Text--root Polaris-Text--bodyMd"></p>
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
                                                    <span class=""><b>Shape</b></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="Polaris-Connected">
                                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                <div class="Polaris-Select">
                                                    <select id="shape_type" class="Polaris-Select__Input required" name="shape_type">
                                                        <option value="" selected="">Select</option>
                                                        @if(!empty($distinctShape))
                                                            @foreach($distinctShape as $shape)
                                                                <option value="{{ $shape }}">{{ $shape }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="Polaris-Select__Content" aria-hidden="true">
                                                        <span class="Polaris-Select__SelectedOption"></span>
                                                        <span class="Polaris-Select__Icon">
                                                            <span class="Polaris-Icon">
                                                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                    <path d="M10.884 4.323a1.25 1.25 0 0 0-1.768 0l-2.646 2.647a.75.75 0 0 0 1.06 1.06l2.47-2.47 2.47 2.47a.75.75 0 1 0 1.06-1.06l-2.646-2.647Z"></path>
                                                                    <path d="m13.53 13.03-2.646 2.647a1.25 1.25 0 0 1-1.768 0l-2.646-2.647a.75.75 0 0 1 1.06-1.06l2.47 2.47 2.47-2.47a.75.75 0 0 1 1.06 1.06Z"></path>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="Polaris-Select__Backdrop" id="Rq65-option"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="shape_details_section" class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                                <h2 class="Polaris-Text--root Polaris-Text--headingMd" id="storeDetails">Shape Details</h2>
                                <div class="Polaris-Box" style="--pc-box-color:var(--p-color-text-secondary)">
                                    <p class="Polaris-Text--root Polaris-Text--bodyMd"></p>
                                </div>
                            </div>
                        </div>

                        <div class="Polaris-Layout__AnnotationContent">
                            <div class="Polaris-LegacyCard">
                                <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
                                <div class="Polaris-wraaper">
                                    
                                <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                    <span class="Polaris-Choice__Control">
                                        <span class="Polaris-Checkbox">
                                            <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="" name="color">
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
                                            <span>Color</span>
                                        </span> 
                                        </label>
                                   

                                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                        <span class="Polaris-Choice__Control">
                                            <span class="Polaris-Checkbox">
                                                <input type="checkbox" class="Polaris-Checkbox__Input required" aria-invalid="false" role="checkbox" aria-checked="false" value="" name="clarity">
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
                                            <span>Clarity</span>
                                        </span> 
                                    </label>
                                   
                                    <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                        <span class="Polaris-Choice__Control">
                                        <span class="Polaris-Checkbox">
                                            <input type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="" name="cut">
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
                                        <span>Cut</span>
                                        </span> 
                                   </label>
                                    
                                   <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                        <span class="Polaris-Choice__Control">
                                        <span class="Polaris-Checkbox">
                                            <input type="checkbox" class="Polaris-Checkbox__Input " aria-invalid="false" role="checkbox" aria-checked="false" value="" name="polish">
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
                                        <span>Polish</span>
                                        </span> 
                                   </label>
                                    
                                   <label class="Polaris-Choice Polaris-Checkbox__ChoiceLabel" style="margin-right: 20px;"> 
                                        <span class="Polaris-Choice__Control">
                                        <span class="Polaris-Checkbox">
                                            <input type="checkbox" class="Polaris-Checkbox__Input " aria-invalid="false" role="checkbox" aria-checked="false" value="" name="symmetry">
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
                                        <span>Symmetry </span>
                                        </span> 
                                   </label>
                                    
                                    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="Polaris-Frame-ContextualSaveBar__ActionContainer">
                                <div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionTrailing">
                                    <div class="Polaris-Stack__Item" style="text-align: center;">
                                        <br>
                                        <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantTertiary Polaris-Button--sizeLarge Polaris-Button--textAlignCenter submit_btnss" type="button" style="border-radius: 3px;font-size: 15px;background: #000;padding: 8px 18px;color:#fff;box-shadow:none;border:none;">
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

                      
                        <div class="Polaris-DataTable Polaris-DataTable__ShowTotals Polaris-DataTable__ShowTotalsInFooter">
                            <div class="Polaris-DataTable__ScrollContainer">
                                <form action="" method="post" id="reorder_form">
                                <table class="Polaris-DataTable__Table reorder_table">
                                    <thead>
                                        <tr>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col" style="width: 5%;"></th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Shape</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Color</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Clarity</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Cut</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Polish</th>
                                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Symmetry</th>
                                            <!-- <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Action</th> -->
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
                                            
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{$Default->shape}}</td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{ $Default->color == 1 ? 'Checked' : 'Unchecked' }}
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{ $Default->clarity == 1 ? 'Checked' : 'Unchecked' }}
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">{{ $Default->cut == 1 ? 'Checked' : 'Unchecked' }}</td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"> 
                                                {{ $Default->polish == 1 ? 'Checked' : 'Unchecked' }}
                                            </td>
                                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"> 
                                            {{ $Default->symmetry == 1 ? 'Checked' : 'Unchecked' }}
                                            </td>
                                             <!-- <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                                <button class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantSecondary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter delete_template" data-id="{{$Default->id}}" type="button">
                                                    <span class="">Delete</span>
                                                </button>
                                            </td> -->
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
            </div>
        </div>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $('.submit_btnss').click(function() {
        var shape_type = $('[name="shape_type"]').val();
        var colors = $("input[name='color']:checked").map(function() {
            return $(this).val();
        }).get();
        var clarity = $("input[name='clarity']:checked").map(function() {
            return $(this).val();
        }).get();
        var cut = $("input[name='cut']:checked").map(function() {
            return $(this).val();
        }).get() || [];
        var polish = $("input[name='polish']:checked").map(function() {
            return $(this).val();
        }).get() || [];
        var symmetry = $("input[name='symmetry']:checked").map(function() {
            return $(this).val();
        }).get() || [];

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // var error = 0;
        // jQuery(".required").each(function() {
        //     if (jQuery(this).is(":visible") && jQuery(this).val() == "") {
        //         jQuery(this).addClass("input_error");
        //         error = 1;
        //     }
        // });

        // if (error == 1) {
        //     jQuery(".Polaris-Frame-Toast").css("background-color", "#e51c00");
        //     alert_msg('Please fill all the required fields');
        //     return false;
        // }

        $.ajax({
            url: '/add-shape',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                shape_type: shape_type,
                colors: colors,
                clarity: clarity,
                cut: cut,
                polish: polish,
                symmetry: symmetry,
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script>

<style>
    .checkbox-container {
        display: block;
       
    }
</style>
