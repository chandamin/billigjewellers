var base_url = 'https://app.billigjewelers.com/';
var site = 'https://billigjewelers.com/';

let USDollar = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});





function search_records() {
    var shape = diamond = '';
    var urlParams = new URLSearchParams(window.location.search);
    var diamond_selected = urlParams.get('diamond_selected');


    if (diamond_selected != null && diamond_selected != 'undefined') {
        diamond = "&diamond_selected=" + diamond_selected;
        jQuery("body .diamond_size_section").hide();

    } else {
        jQuery("body .diamond_size_section").show();

    }

    if (jQuery("body input[name='Shape").is(":visible")) {
        var shape = jQuery("body input[name='Shape']:checked").val();
        shape = "&shape=" + shape;
    }
    jQuery(".variantid").val(jQuery("input[name='id']").val());
    jQuery('.uui-relative .diamond_records').hide();
    jQuery('.uui-relative .loader_sec').show();
    jQuery.ajax({
        async: false,
        url: base_url + "search_records",
        type: "post",
        data: jQuery("#cart_form").serialize() + shape + diamond,
        //  data: jQuery("#cart_form").serialize() + shape + diamond + "&active_diamond=lab_grown", // Initially set active_diamond to lab_grown
        success: function (data) {
            jQuery('.uui-relative .diamond_records').html(data);
            if (diamond_selected != null && diamond_selected != 'undefined') {
                $(".inner_tr").each(function () {
                    var type = $(this).hasClass("lab_grown") ? 'lab_grown' : 'mined';
                    $("#selected_type").text(type === 'lab_grown' ? 'Lab Grown' : 'Natural');
                    if (type === 'lab_grown') {
                        console.log('aaa');
                        $(".filter-diamond-origin .lab-grown").addClass("active-diamond");
                        $(".filter-diamond-origin .natural").removeClass("active-diamond");
                        $(".filter-diamond-origin .natural").prop("disabled", true);
                        $(".filter-diamond-origin .lab-grown").prop("disabled", false);
                    } else {
                        console.log('kk');
                        $(".filter-diamond-origin .natural").addClass("active-diamond");
                        $(".filter-diamond-origin .lab-grown").removeClass("active-diamond");
                        $(".filter-diamond-origin .lab-grown").prop("disabled", true);
                        $(".filter-diamond-origin .natural").prop("disabled", false);
                    }
                });
                // console.log(data);
            } else {
                console.log('data');
                jQuery("body .selectDataDia").show();

                setTimeout(function () {
                    $(".lab-grown").trigger("click");
                }, 500);


            }

            setTimeout(function () {
                jQuery('.uui-relative .loader_sec').hide();
                jQuery('.uui-relative .diamond_records').show();
            }, 500);


            setTimeout(function () {
                var urlParams = new URLSearchParams(window.location.search);
                var caratValue = urlParams.get('carat');
                //cart back
                if (caratValue) {
                    $('.diamondtable .inner_tr').each(function () {
                        var caratText = $(this).find('.titleTabss:contains("Carat")').siblings('.titleValuess').text().trim();
                        if (caratText === caratValue) {

                            var total_price = jQuery(".product_price").val();


                            var price =  $(this).find('.unit_price').val();;

                            total_price = parseFloat(total_price) + parseFloat(price);






                            jQuery(".cart_total_price").show();
                            jQuery(".cart_total_price").html('Ring total: ' + USDollar.format(total_price));

                            jQuery(".add_to_cart").prop("disabled", false);


                          
                            $(this).find('.checkbox_ids').prop('checked', true);
                            $(this).addClass('checked-row');
                            return false;
                        }
                    });
                }
            }, 500);
        }
    });

}
$(document).ready(function () {

    var shop = Shopify.shop;
    var match = window.location.pathname;
    var urlParams = new URLSearchParams(window.location.search);


    if (match == '/pages/diamond-collection' && jQuery(".diamond_collections").is(":visible")) {
        var diamond_selected = urlParams.get('diamond_selected');

        if (diamond_selected != null && diamond_selected != 'undefined') {
            jQuery(".diamond_collections").html('<div style="text-align: center;padding: 50px;"><div class="loading-overlay__spinner" style="width: 12.8rem;"><svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle></svg></div></div>');
            jQuery.ajax({
                url: base_url + "diamond_collection",
                type: "post",
                data: {
                    shop: shop,
                    diamond_selected: diamond_selected
                },
                success: function (data) {
                    jQuery(".diamond_collections").html(data);
                }
            });
        }
    }


    if (jQuery(".product_iframe").is(":visible")) {
        setTimeout(function () {

            jQuery('.loader_frame').show();
            const set_int = setInterval(function () {
                if (!$('.btn-share-now').find('share-button').hasClass('share-button-custom')) {
                    var ShareCus = $('.custom-buttoon-share').html();
                    $('.btn-share-now').append(ShareCus);
                    //clearInterval(set_int);
                }
            }, 100);

            //cart back 
            var urlParams = new URLSearchParams(window.location.search);
            var diamondSelected = urlParams.get('ring_size');
            var selectedWeight = urlParams.get('weight');

            if (diamondSelected) {
                $('#select-1 option').each(function () {
                    if ($(this).val() === diamondSelected) {
                        $(this).prop('selected', true);
                    }
                });
            }
          






            var product_id = jQuery("input[name='product-id']").val();
            var variant_id = jQuery("input[name='id']").val();
            var handle = jQuery("input[name='handle']").val();

            var diamond_selected = urlParams.get('diamond_selected');

            jQuery.ajax({
                url: base_url + "get_templates",
                type: "post",
                data: {
                    product_id: product_id,
                    variant_id: variant_id,
                    shop: shop,
                    diamond_selected: diamond_selected,
                    handle: handle
                },
                success: function (data) {
                    jQuery('.loader_frame').hide();
                    jQuery(".product_iframe").html(data);

                    setTimeout(function () {

                        //cart back
                        if (selectedWeight) {
                            $('#diamond_size option').each(function () {
                                if ($(this).val() === selectedWeight) {
                                    $(this).prop('selected', true);
                                    $('#diamond_size').trigger("change");
                                }
                            });
                        }


                        jQuery.ajax({
                            url: base_url + "get_sidebar",
                            type: "post",
                            success: function (data) {
                                jQuery("body").append(data);
                            }
                        });
                    }, 500);
                }
            });







            jQuery(".product-form__submit").remove();
            jQuery(".shop_pay shop-pay-installments-banner p").css({ "margin-top": "10px", "text-align": "center", "font-size": "12px" });

            jQuery("body").on("change", ".form input[name='id']", function () {

                var variant_id = jQuery("input[name='id']").val();

                jQuery.ajax({
                    url: base_url + "get_price",
                    type: "post",
                    data: {
                        variant_id: variant_id,
                        shop: shop
                    },
                    success: function (total_price) {
                        jQuery(".product_price").val(total_price);
                        if (jQuery(".checkbox_ids:checked").length > 0) {
                            jQuery(".checkbox_ids:checked").each(function () {
                                var price = jQuery(this).parents("tr").find(".unit_price").val();
                                total_price = parseFloat(total_price) + parseFloat(price);
                            });

                            jQuery(".add_to_cart").prop("disabled", false);
                        } else {
                            jQuery(".add_to_cart").prop("disabled", true);
                        }

                        jQuery(".cart_total_price i").html(USDollar.format(total_price));
                    }
                });
            })


        }, 1000);
    }



    jQuery("body").on("click", ".video_popup", function (e) {
        e.preventDefault();
        var src = jQuery(this).attr("href");

        if (src.indexOf("videos.ud-ny.com") > -1) {
            jQuery("#media-frame").attr("src", src);
            jQuery("#unbridaled-player-container").show();
        } else {
            window.open(src, '_blank');
        }
    })
    jQuery("body").on("click", ".certificate_popup", function (e) {
        e.preventDefault();
        var src = jQuery(this).data("src") + "#toolbar=0&navpanes=0&scrollbar=0";
        jQuery("#cert-frame").attr("src", src);
        jQuery("#unbridaled-player").show();
    })
    jQuery("body").on("click", ".MediaPlayer_module_close,.Certificate_module_close", function () {
        jQuery("body #unbridaled-player-container,body #unbridaled-player").hide();
    })

    jQuery("body").on("change", "#diamond_size,input[name='Shape']", function () {
        search_records();
    })

    jQuery("body").on("click", ".change_variant", function () {  
            //var diamond_get = urlParams.get('diamond_selected');
            //window.location.href = site + "pages/diamond-collection?diamond_selected=" + diamond_get;
            window.location.href = site + "pages/lab-diamonds";
    });
    jQuery("body").on('click', '.diamond-guide', function (e) {
        jQuery(".an-side-bar").addClass('active');
    });
    jQuery("body").on('click', '.an-side-bar-close', function (e) {
        jQuery(".an-side-bar").removeClass('active');
    });
    jQuery("body").on("click", ".add_diamond", function (e) {
        jQuery(".dropdown-content").removeClass("show");
        e.preventDefault();
        var item = jQuery(this).parents(".dropdown");
        var sku = item.find(".dropbtn").data("sku");
        var form = "sku=" + sku + "&shop=" + shop;
        add_to_cart(item, form);

    });

    jQuery("body").on("click", ".add_jewelry.available", function (e) {
        e.preventDefault();
        jQuery(".dropdown-content").removeClass("show");
        var item = jQuery(this).parents(".dropdown");
        var sku = item.find(".dropbtn").data("sku");
        window.location.href = site + "pages/diamond-collection?diamond_selected=" + sku;

    });

    jQuery("body").on("click", ".dropbtn", function (e) {
        e.preventDefault();
        var add_j = jQuery(this);
        item = jQuery(this).parents(".dropdown");
        var sku = item.find(".dropbtn").data("sku");
        if (item.find(".dropdown-content").hasClass("show")) {
            item.find(".dropdown-content").removeClass("show");
        } else {
            jQuery(".dropdown-content").removeClass("show");
            add_j.addClass("btn_disabled");
            item.find(".add_jewelry").prop("disabled", true);
            item.find(".add_jewelry span").html('<div class="loading-overlay__spinner" style="float: right;margin-top:-8px;"><svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle></svg></div>');
            item.find(".dropdown-content").addClass("show");

            setTimeout(function () {
                jQuery.ajax({
                    async: true,
                    url: base_url + "search_product",
                    type: "post",
                    data: {
                        sku: sku,
                        shop: shop
                    },
                    success: function (data) {
                        if (data == 1) {
                            item.find(".add_jewelry").removeClass("btn_disabled");
                            item.find(".add_jewelry").prop("disabled", false);
                            item.find(".add_jewelry").addClass("available");
                            item.find(".add_jewelry span").html("");
                            var p_sku = add_j.attr('data-sku');
                            addTojewellry(p_sku);
                        } else {
                            item.find(".add_jewelry span").html("(Not available)");
                        }
                    }
                });
            }, 500);
        }
    })

    function addTojewellry(sku) {
        var sku = sku;
        window.location.href = site + "pages/diamond-collection?diamond_selected=" + sku;
    }

    jQuery("body").on("click", ".icons_button", function (e) {
        jQuery(".CustomBadge__popup").hide();
        var popup = jQuery(this).data("popup");
        jQuery("." + popup + "_popup").css("display", "flex");
    })
    jQuery("body").on("click", ".CustomBadge__popup-button", function (e) {
        jQuery(".CustomBadge__popup").hide();
    })
    jQuery("body").on("click", ".add_to_cart", function (e) {
        e.preventDefault();
        var item = jQuery(this);
        var form = jQuery("#cart_form").serialize();
        //======Start======

        //======End=====
        var ring = jQuery("select[name='Ring Size']");
        if (ring.is(":visible")) {
            if (ring.val() != null) {
                form = form + "&ring_size=" + ring.val();
            } else {
                jQuery("#error-message").html("<center>Please selece Ring Size.</center>");
                return false;
            }
        }


        var urlParams = new URLSearchParams(window.location.search);
        var diamond_selected = urlParams.get('diamond_selected');
        if(diamond_selected){
            form = form + "&diamond_selected=yes";
        }
       

        add_to_cart(item, form);
    })

    function add_to_cart(item, form) {
        
        item.prop("disabled", true);
        jQuery("#error-message").html("");
        item.find("span").hide();
        item.find(".loading-overlay__spinner").removeClass("hidden");
        
        jQuery.ajax({
          
            async: false,
            url: base_url + "generate",
            type: "post",
            data: form,
            success: function (data) {
              
                var data = JSON.parse(data);
               console.log(data,"hello")
                if (data.items != '') {

                    let formData = data;

                    fetch('/cart/add.js', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                        .then(response => {
                            return response.json();
                        })
                        .then(res => {
                            if (res.description != null) {

                                item.find(".loading-overlay__spinner").addClass("hidden");
                                item.find("span").show();
                                jQuery("#error-message").html(res.description);
                                item.prop("disabled", false);
                            }

                            if (res.items != null) {
                                setTimeout(function () {

                                    item.find(".loading-overlay__spinner").addClass("hidden");
                                    item.find("span").show();
                                    window.location.href = "/cart";
                                }, 3000)
                            }
                        })
                        .catch((error) => {
                            jQuery("#error-message").html(error);
                            item.prop("disabled", false);
                        });

                     
                } else {
                    item.find(".loading-overlay__spinner").addClass("hidden");
                    item.find("span").show();
                    jQuery("#error-message").html("Something wrong please try again.");
                    item.prop("disabled", false);
                }
            },
        });
    }

    if (jQuery("#LBdiamonds").is(":visible")) {
      
        var type = 0;

        if (jQuery("#LBdiamonds").data("type") == 'mined') {
            type = 1;
        }
        if (jQuery("#LBdiamonds").data("type") == 'lab_grown') {
            type = 0;
        }

        // DisplaySearch(type, 'lbDiamonds', shop, base_url, 'mined-lab-diamonds');
        DisplaySearch(type, 'lbDiamondsSmart', shop, base_url, 'mined-lab-diamonds-smart');

        function DisplaySearch(type, url, shop, base_url, display_diamond) {
            jQuery(".loading-overlay__spinner-main").show();
         
            jQuery.ajax({
                url: base_url + url,
                type: "post",
                data: {
                    type: type,
                    shop: shop
                },
                success: function (data) {
                    jQuery(".loading-overlay__spinner-main").hide();
                    jQuery("#LBdiamonds").html(data);
                    fetchData(display_diamond);
                }
            });
        }

        $("body").on("click", ".smart-search", function () {
            location.reload();
            //  $(this).addClass('active');
            //  $('.custom-search').removeClass('active');
            // currentColor = [];
            //  currentClarity = [];
            // currentCut = [];
            //DisplaySearch(type, 'lbDiamondsSmart', shop, base_url, 'mined-lab-diamonds-smart');
        });


        $("body").on("click", ".custom-search", function () {
            $(this).addClass('active');
            $.getScript("https://code.jquery.com/ui/1.12.1/jquery-ui.js")
                .done(function (script, textStatus) {
                    console.log("jQuery UI script loaded successfully.");
                })
                .fail(function (jqxhr, settings, exception) {
                    console.error("Error loading jQuery UI script: ", exception);
                });

            // Load the jQuery UI CSS file
            $("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: "//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
            }).appendTo("head");
            $('.smart-search').removeClass('active');
            DisplaySearch(type, 'lbDiamonds', shop, base_url, 'mined-lab-diamonds');
        });

        $("body").on("click", ".custom-search-sm", function () {
            $(this).addClass('active');
            currentShape = '';
            currentCart = [];
            $.getScript("https://code.jquery.com/ui/1.12.1/jquery-ui.js")
                .done(function (script, textStatus) {
                    console.log("jQuery UI script loaded successfully.");
                })
                .fail(function (jqxhr, settings, exception) {
                    console.error("Error loading jQuery UI script: ", exception);
                });

            // Load the jQuery UI CSS file
            $("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: "//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
            }).appendTo("head");
            DisplaySearch(type, 'lbDiamonds', shop, base_url, 'mined-lab-diamonds');
            //location.reload();
        });

    }









    /************** diamond filter page **********************/

    var type = 0;
    var currentPage = 1;
    var currentShape = '';
    var currentColor = [];
    var currentClarity = [];
    var currentCut = [];
    var currentLab = [];
    var currentCart = [];



    function fetchData(display_diamond, page = 1) {
        console.log('*********************sss*************Ok');
        // console.log(currentCart);
        $("body .diamon_filter_Section .loading-overlay__spinner").show();
        var currentDiamond = 0;
        if ($(".filter-diamond-origin").attr('data-type') == 'mined') {
            currentDiamond = 1;
        }
        if (page === 'next') {
            page = currentPage + 1;
            currentPage = page;
        } else if (page === 'prev') {
            page = currentPage - 1;
            currentPage = page;
        } else {
            currentPage = page;
        }
        var type = 0;

        var currentWeight = $("#max-min").val();
        if (jQuery("#LBdiamonds").data("type") == 'mined') {
            type = 1;
        }
        if (jQuery("#LBdiamonds").data("type") == 'lab_grown') {
            type = 0;
        }
        if (display_diamond === 'mined-lab-diamonds-smart' && (currentCart == '' || currentShape == '')) {
            $("body .diamon_filter_Section .loading-overlay__spinner").hide();
            $(".smart-dis").hide();
        } else {
            $(".empty-text").hide();
            $(".smart-dis").show();
            $.ajax({
                url: base_url + display_diamond + '?page=' + page,
                type: 'POST',
                data: {
                    type: type,
                    shop: shop,
                    shape: currentShape,
                    color: currentColor,
                    clarity: currentClarity,
                    cut: currentCut,
                    diamond: currentDiamond,
                    certificate: currentLab,
                    CartWeight: currentCart,
                    weight: currentWeight,

                    currentPage: currentPage
                },
                success: function (res) {
                    setTimeout(function () {
                        console.log(currentCart + 'ff');
                        $("body .diamon_filter_Section .loading-overlay__spinner").hide();

                        jQuery("body #LBdiamonds .list-part").html(res);
                        jQuery("body #LBdiamonds .best_pox").html(res);
                        currentPage = currentPage;
                        var totalRec = jQuery("body .total-records").val();
                        var showingText = jQuery(".showing-text").val();

                        jQuery(".display-showing-text").text(showingText);
                        var showingText = jQuery("body .showing-text").val();
                        updatePagination(totalRec);
                    }, 1000);
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }





    }

    //Weight
    $("body").on("click", ".filter-carat-weight", function () {
        fetchData($('.custom-search').attr('data-type'));
    });

    // Filter data shape
    $("body").on("click", ".link-faded", function () {
       $('span.custom-text-validation-shape').hide();
        currentShape = $(this).attr('data-type');
        $(".link-faded").removeClass("active-ring");
        $(this).addClass("active-ring");
        var display_diamond = $('custom-search').attr('data-type');
        fetchData($('.custom-search').attr('data-type'));
    });

    // Filter data color

    $("body").on("click", ".color-btn", function () {
        setTimeout(function () {
            currentColor = [];
            $(".color-btn.active").each(function () {
                currentColor.push($(this).data("color"));
            });
            fetchData($('.custom-search').attr('data-type'));
        }, 500);
    });

    // $(".color-btn").on("click", function () {
    //     $(this).toggleClass("active");
    // });

    // $("body").on("click", "input[name='colorFilter[]']", function () {
    //     currentColor = [];
    //     $("input[name='colorFilter[]']:checked").each(function () {
    //         currentColor.push($(this).val());
    //     });
    //     fetchData($('.custom-search').attr('data-type'));
    // });




    // Filter data clarity

    // $("body").on("click", "input[name='clarityFilter[]']", function () {
    //     currentClarity = [];
    //     $("input[name='clarityFilter[]']:checked").each(function () {
    //         currentClarity.push($(this).val());
    //     });
    //     fetchData($('.custom-search').attr('data-type'));
    // });

    $("body").on("click", ".clarity-btn", function () {
        setTimeout(function () {
            currentClarity = [];
            $(".clarity-btn.active").each(function () {
                currentClarity.push($(this).data("clarity"));
            });
            fetchData($('.custom-search').attr('data-type'));
        }, 500);
    });


    // Filter data cut
    // $("body").on("click", "input[name='cutFilter[]']", function () {
    //     currentCut = [];
    //     $("input[name='cutFilter[]']:checked").each(function () {
    //         currentCut.push($(this).val());
    //     });
    //     fetchData($('.custom-search').attr('data-type'));
    // });

    $("body").on("click", ".cut-btn", function () {
        setTimeout(function () {
            currentCut = [];
            $(".cut-btn.active").each(function () {
                currentCut.push($(this).data("cut"));
            });
            fetchData($('.custom-search').attr('data-type'));
        }, 500);
    });



    // Filter data labFilter
    $("body").on("click", "input[name='labFilter[]']", function () {
        currentLab = [];
        $("input[name='labFilter[]']:checked").each(function () {
            currentLab.push($(this).val());
        });
        fetchData($('.custom-search').attr('data-type'));
    });



    //Filter cart weight
    $("body").on("click", "input[name='cartFilter[]']", function () {
        $('span.custom-text-validation-Carat-Weight').hide();
        $("input[name='cartFilter[]']").not(this).prop('checked', false);
        currentCart = [];
        $("input[name='cartFilter[]']:checked").each(function () {
            currentCart.push($(this).val());
        });
        fetchData($('.custom-search').attr('data-type'));
    });



    // $("body").on("click", "input[name='cartFilter[]']", function () {
    //     currentCart = [];
    //     $("input[name='cartFilter[]']:checked").each(function () {
    //         currentCart.push($(this).val());
    //     });
    //     fetchData($('.custom-search').attr('data-type'));
    // });


    // Filter data Diamond origin 
    $("body").on("click", ".lab-grown", function () {

        $('.filter-diamond-origin').attr('data-type', 'lab_grown');
        $(this).addClass("active-diamond");
        $('.smart-name').text("lab grown ");
        $('.natural').removeClass("active-diamond");
        fetchData($('.custom-search').attr('data-type'));
    });

    $("body").on("click", ".natural", function () {
        $('.filter-diamond-origin').attr('data-type', 'mined');
        $(this).addClass("active-diamond");
        $('.smart-name').text("natural ");
        $('.lab-grown').removeClass("active-diamond");
        fetchData($('.custom-search').attr('data-type'));
    });






    // Pagination
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const clickedPage = $(this).data('page');
        if (clickedPage) {
            console.log(clickedPage);
            fetchData($('.custom-search').attr('data-type'), clickedPage);
        }
    });



    $(document).on('click', '.image-link', function (e) {
        e.preventDefault();
        var item = $(this).closest('li');
        item.find(".dropbtn").trigger("click");
    });

    function updatePagination(totalRec) {
        const paginationElement = $('.pagination');
        const lastPage = totalRec;
        const pageNumbersElement = paginationElement.find('.page-numbers');
        pageNumbersElement.empty();
        if (currentPage === 1) {
            paginationElement.find('[data-page="prev"]').addClass('disabled');
        } else {
            paginationElement.find('[data-page="prev"]').removeClass('disabled');
        }
        const visiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
        let endPage = Math.min(lastPage, startPage + visiblePages - 1);

        if (endPage - startPage < visiblePages - 1) {
            startPage = Math.max(1, endPage - visiblePages + 1);
        }

        // Generate page number links
        for (let i = startPage; i <= endPage; i++) {
            const pageLink = $('<a>', {
                href: '#',
                class: 'page-link',
                'data-page': i,
                text: i
            });

            // Highlight the current page
            if (i === currentPage) {
                pageLink.addClass('current');
            }

            pageNumbersElement.append(pageLink);
        }

        // Enable/disable "Next" link
        if (currentPage == lastPage) {
            paginationElement.find('[data-page="next"]').addClass('disabled');
        } else {
            paginationElement.find('[data-page="next"]').removeClass('disabled');
        }
    }


    $("input").select(function () {
        fetchData($('.custom-search').attr('data-type'));
    });

    $(document).on('click', '.Select-filters-btn .button', function (e) {
        $(".first-filter-an, .second-filter-an").toggle(function () {
            if ($(this).is(":visible")) {
                $(this).css('display', 'grid');
            }
        });
    });



});
$(document).ready(function(){
    console.log('Spinner visible:', jQuery(".loading-overlay__spinner").is(":visible"));

})
