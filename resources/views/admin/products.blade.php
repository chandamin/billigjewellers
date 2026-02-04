@include('admin.header')
<?php 

 $status = 'all';
 $url = url('/?shop='.$_REQUEST['shop']);
 
 if(isset($_REQUEST['status'])){
    $status = $_REQUEST['status'];
 }
 ?>
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

        position: relative;"
>

    <div class="Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">

        <div class="Polaris-Page-Header__Row">

            <div class="Polaris-Page-Header__TitleWrapper"><h1 class="Polaris-Header-Title" style="display: inline-block;font-size: 24px;font-weight: 400;">Products</h1></div>

        </div>

    </div>

</div>

<div class="Polaris-LegacyCard">


            <form action="" method="get">   
<div class="Polaris-Connected">
    <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
        <div class="Polaris-TextField Polaris-TextField--hasValue Polaris-TextField--borderless Polaris-TextField--slim">
            <div class="Polaris-TextField__Prefix Polaris-TextField__PrefixIcon" id=":rc6:-Prefix"><span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.323 13.383a5.5 5.5 0 1 1 1.06-1.06l2.897 2.897a.75.75 0 1 1-1.06 1.06l-2.897-2.897Zm.677-4.383a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"></path>
                    </svg></span></div> 
                    <?php if(isset($_REQUEST['shop'])){ ?>
                    <input name="shop" value="<?php echo $_REQUEST['shop'];?>" type="hidden"/>
                   <?php } ?>
                   <?php if(isset($_REQUEST['status'])){ ?>
                    <input name="status" value="<?php echo $_REQUEST['status'];?>" type="hidden"/>
                   <?php } ?>    
                    <input id=":rc6:" placeholder="Searching all products" autocomplete="off" name="search" class="Polaris-TextField__Input Polaris-TextField__Input--hasClearButton" type="text" aria-labelledby=":rc6:Label :rc6:-Prefix" aria-invalid="false" data-1p-ignore="true" data-lpignore="true" data-form-type="other" value="<?php if(isset($_REQUEST['search'])){ echo $_REQUEST['search']; } ?>">
                   
            <div class="Polaris-TextField__Backdrop"></div>
             <button type="submit"  style="z-index: 99;background: #000;color: #fff;border: none;margin-right: 15px;margin-top: 10px;" class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantPrimary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter"><span class="Polaris-Text--root">Search</span>
                </button>
            
        </div>
    </div>
</div>
</form>

     <div class="Polaris-IndexFilters__IndexFiltersWrapper" style="height: 45px;">
        <div></div>
        <div class="Polaris-IndexFilters">
            <div>
                <div class="Polaris-IndexFilters-Container">
                    <div class="Polaris-HorizontalStack" style="--pc-horizontal-stack-align: start; --pc-horizontal-stack-block-align: center; --pc-horizontal-stack-wrap: wrap; --pc-horizontal-stack-gap-xs: var(--p-space-0); --pc-horizontal-stack-gap-md: var(--p-space-2);">
                        <div class="Polaris-IndexFilters__TabsWrapper">
                            <div style="transition: opacity 150ms var(--p-motion-ease); opacity: 1;">
                                <div class="Polaris-Tabs__Outer">
                                    <div class="Polaris-Box" style="
                                        --pc-box-padding-block-end-md: var(--p-space-2);
                                        --pc-box-padding-block-start-md: var(--p-space-2);
                                        --pc-box-padding-inline-start-md: var(--p-space-2);
                                        --pc-box-padding-inline-end-md: var(--p-space-2);
                                    ">

                                        <div class="Polaris-Tabs__Wrapper Polaris-Tabs__WrapperWithNewButton">
                                            <div class="Polaris-Tabs__ButtonWrapper">
        <ul class="Polaris-Tabs" data-tabs-focus-catchment="true" role="tablist">
            <li class="Polaris-Tabs__TabContainer" role="presentation">
                <a data-polaris-unstyled="true" id="activeMeasurer" class="Polaris-Tabs__Tab  <?php if ($status == "all") {
                        echo "Polaris-Tabs__Tab--active";
                       } ?>" tabindex="-1" aria-selected="<?php if ($status == "all") {
                        echo "true";
                        } else {
                            echo "false";
                        } ?>" role="tab" href="<?php echo $url; ?>">

                    <div class="Polaris-HorizontalStack" style="--pc-horizontal-stack-align: center; --pc-horizontal-stack-block-align: center; --pc-horizontal-stack-wrap: nowrap; --pc-horizontal-stack-gap-xs: var(--p-space-2);">
                        <span class="Polaris-Text--root Polaris-Text--bodySm Polaris-Text--medium">All</span>
                    </div>
                </a>
            </li>

            <li class="Polaris-Tabs__TabContainer" role="presentation">
                <a data-polaris-unstyled="true" id="activeMeasurer" class="Polaris-Tabs__Tab  <?php if ($status == "enabled") 
                       {
                        echo "Polaris-Tabs__Tab--active";
                        } ?>" tabindex="-1" aria-selected="<?php if ($status == "active") {
                               echo "true";
                           } else {
                               echo "false";
                            } ?>" role="tab" href="<?php echo $url; ?>&status=enabled">
                    <div class="Polaris-HorizontalStack" style="--pc-horizontal-stack-align: center; --pc-horizontal-stack-block-align: center; --pc-horizontal-stack-wrap: nowrap; --pc-horizontal-stack-gap-xs: var(--p-space-2);">
                        <span class="Polaris-Text--root Polaris-Text--bodySm Polaris-Text--medium">Enabled</span>
                    </div>
                </a>
            </li>
            <li class="Polaris-Tabs__TabContainer" role="presentation">
                <a data-polaris-unstyled="true" id="activeMeasurer" class="Polaris-Tabs__Tab  <?php if ($status == "disabled") {
                      echo "Polaris-Tabs__Tab--active";
               } ?>" tabindex="-1" aria-selected="<?php if (
                $status == "disabled"
            ) {
                echo "true";
            } else {
                echo "false";
            } ?>" role="tab" href="<?php echo $url; ?>&status=disabled">
                    <div class="Polaris-HorizontalStack" style="--pc-horizontal-stack-align: center; --pc-horizontal-stack-block-align: center; --pc-horizontal-stack-wrap: nowrap; --pc-horizontal-stack-gap-xs: var(--p-space-2);">
                        <span class="Polaris-Text--root Polaris-Text--bodySm Polaris-Text--medium">Disabled</span>
                    </div>
                </a>
            </li>
        </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div></div>
        </div>
    </div>


    <div class="Polaris-IndexTable">
        
        <?php if (isset($products) && count($products) > 0) {


         ?>

        <div class="Polaris-IndexTable__IndexTableWrapper Polaris-IndexTable__IndexTableWrapper--scrollBarHidden">

            <div class="Polaris-IndexTable-ScrollContainer">

                <table class="Polaris-IndexTable__Table Polaris-IndexTable__Table--sticky">

                    <thead>

                        <tr>
                            <th class="Polaris-IndexTable__TableHeading Polaris-IndexTable__TableHeading--second" data-index-table-heading="true" style="padding-left: 15px;" >S.No</th>
                            <th class="Polaris-IndexTable__TableHeading Polaris-IndexTable__TableHeading--second" data-index-table-heading="true" style="padding-left: 15px;">Product</th>
                            <th class="Polaris-IndexTable__TableHeading Polaris-IndexTable__TableHeading--second" style="padding-left: 15px;">Status</th>
                            <th class="Polaris-IndexTable__TableHeading" data-index-table-heading="true"></th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php 
                        $line = 0;   


                        foreach ($products['products'] as $product) { 
                        
                        if(isset($_REQUEST['status']) && $_REQUEST['status']=='disabled' && isset($enabled[$product['id']]) && $enabled[$product['id']] == 1) 
                         { 
                           continue;
                         }

                            $line++;
                   
                        ?>

                        <tr class="Polaris-IndexTable__TableRow outer_tr" data-id="<?php echo $product['id']; ?>">
                            <td class="Polaris-IndexTable__TableCell">

                                <span class="Polaris-Text--root Polaris-Text--bodyMd"><?php echo $line; ?>
                                    
                                </span>

                            </td>
                 

                            <td class="Polaris-IndexTable__TableCell">

                                <span class="Polaris-Text--root Polaris-Text--bodyMd"><?php if(isset($product['title'])){  echo $product['title']; } ?></span>

                            </td>
                            <td class="Polaris-IndexTable__TableCell">
                                <span class="Polaris-Text--root Polaris-Text--bodyMd">
                                <?php 
                                
                                if(isset($enabled[$product['id']]) && $enabled[$product['id']] == 1) 
                                 {
                                   echo "<span style='color:green;'>Enabled</span>";
                                 }else{
                                   echo "<span style='color:red;'>Disabled</span>";
                                 }
                                ?>
                            </span>
                            </td>
                             <td class="Polaris-IndexTable__TableCell">
                                <a href="<?php echo url("/product_setup?id=".$product['id']."&shop=".$_REQUEST['shop']); ?>" style="background: #000;color: #fff;border: none;" class="Polaris-Button Polaris-Button--pressable Polaris-Button--variantPrimary Polaris-Button--sizeMedium Polaris-Button--textAlignCenter" aria-disabled="false">
                                    <span class="">Setup</span>
                                </a>
                            </td>

                        </tr>

                      <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

        <?php } else { ?>



        <div class="Polaris-IndexTable__IndexTableWrapper Polaris-IndexTable__IndexTableWrapper--scrollBarHidden">

            <div class="Polaris-IndexTable__EmptySearchResultWrapper">

                <div class="Polaris-LegacyStack Polaris-LegacyStack--vertical Polaris-LegacyStack--alignmentCenter">

                    <div class="Polaris-LegacyStack__Item">

                        <div class="Polaris-Box">

                            <div class="Polaris-VerticalStack">

                                <div class="Polaris-VerticalStack" style="--pc-vertical-stack-inline-align: center; --pc-vertical-stack-order: column;">

                                    <div class="Polaris-Box" style="--pc-box-padding-block-end-xs: var(--p-space-4);">

                                        <div class="Polaris-Box" style="--pc-box-padding-block-end-xs: var(--p-space-1_5-experimental);">

                                            <p class="Polaris-Text--root Polaris-Text--headingMd Polaris-Text--block Polaris-Text--center">No records found</p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php } ?>

        <div>

        </div>

    </div>



    <div class="Polaris-IndexTable__ScrollBarContainer Polaris-IndexTable--scrollBarContainerHidden">

        <div class="Polaris-IndexTable__ScrollBar" style="--pc-index-table-scroll-bar-content-width: 828px;">

            <div class="Polaris-IndexTable__ScrollBarContent">

            </div>

        </div>

    </div>

</div>
@include('admin.footer')
