<link rel="stylesheet" type="text/css" href="<?php echo asset("public/custom/css/polaris.css");?>?ver=<?php echo time();?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo asset("public/custom/css/style.css");?>?ver=<?php echo time();?>"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo asset("public/custom/js/script.js");?>?ver=<?php echo time();?>"></script>

<script>
    jQuery(document).ready(function(){
        jQuery("body").on("change select", "select", function() {
            var text = jQuery(this).find("option:selected").text();
            jQuery(this).parent(".Polaris-Select").find(".Polaris-Select__SelectedOption").text(text);
        })
    })
</script>
<?php $shop = $_GET['shop'];?>
<div class="Polaris-Frame-ToastManager"  id="snackbar" aria-live="assertive">
    <div class="Polaris-Frame-ToastManager__ToastWrapper Polaris-Frame-ToastManager--toastWrapperEnterDone" style="--pc-toast-manager-translate-y-in: -66px; --pc-toast-manager-translate-y-out: 84px;">
        <div class="Polaris-Frame-Toast" aria-live="assertive">
            <div class="Polaris-HorizontalStack" style="--pc-horizontal-stack-block-align: center; --pc-horizontal-stack-wrap: wrap; --pc-horizontal-stack-gap-xs: var(--p-space-400);"><span class="Polaris-Text--root Polaris-Text--medium alert_msg"></span></div><button type="button" class="Polaris-Frame-Toast__CloseButton"><span class="Polaris-Icon"><span class="Polaris-Text--root Polaris-Text--visuallyHidden"></span><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path d="M12.72 13.78a.75.75 0 1 0 1.06-1.06l-2.72-2.72 2.72-2.72a.75.75 0 0 0-1.06-1.06l-2.72 2.72-2.72-2.72a.75.75 0 0 0-1.06 1.06l2.72 2.72-2.72 2.72a.75.75 0 1 0 1.06 1.06l2.72-2.72 2.72 2.72Z"></path>
                    </svg></span></button>
        </div>
    </div>
</div>


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

                <div class="Polaris-Page-Header__TitleWrapper">

                    <h1 class="Polaris-Header-Title" style="display: inline-block;font-size: 24px;font-weight: 400;"><?php echo env("APP_NAME");?></h1>

                </div>

                <div class="Polaris-Page-Header__RightAlign">
                    <div class="Polaris-ActionMenu">
                        <div class="Polaris-ActionMenu-Actions__ActionsLayout">
                            <div class="Polaris-ButtonGroup Polaris-ButtonGroup--tight">

                                <div class="Polaris-ButtonGroup__Item">
                                    <div class="Polaris-ActionMenu-SecondaryAction">
                                        <a class="Polaris-Button  <?php if (isset($page) && $page == "global_price_multiple_setup") { echo "active-nav"; } ?>" href="<?php echo url("/global-price-multiple-setup?shop=".$shop); ?>">
                                            <span class="Polaris-Navigation__Text"> GLOBAL PRICE SETUP</span>
                                        </a>
                                       
                                    </div>
                                </div>

                                <div class="Polaris-ButtonGroup__Item">
                                    <div class="Polaris-ActionMenu-SecondaryAction">
                                        <a class="Polaris-Button  <?php if (isset($page) && $page == "products") { echo "active-nav"; } ?>" href="<?php echo url("/?shop=".$shop); ?>">
                                            
                                            <span class="Polaris-Navigation__Text">ENABLE PRODUCTS</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="Polaris-ButtonGroup__Item">
                                    <div class="Polaris-ActionMenu-SecondaryAction">
                                        
                                        <a class="Polaris-Button  <?php if (isset($page) && $page == "add_setting") { echo "active-nav"; } ?>" href="<?php echo url("/add_setting?shop=".$shop); ?>">
                                            
                                            <span class="Polaris-Navigation__Text">TEMPLATES</span>

                                        </a>

                                    </div>

                                </div>


                                <div class="Polaris-ButtonGroup__Item">
                                    <div class="Polaris-ActionMenu-SecondaryAction">
                                        
                                        <a class="Polaris-Button  <?php if (isset($page) && $page == "add_shape_setup") { echo "active-nav"; } ?>" href="<?php echo url("/add_shape_setup?shop=".$shop); ?>">
                                            
                                            <span class="Polaris-Navigation__Text">SHAPE SETUP</span>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>