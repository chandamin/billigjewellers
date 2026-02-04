if (jQuery("#LBdiamonds").is(":visible")) {
    var type = 0;

    if (jQuery("#LBdiamonds").data("type") == 'mined') {
        type = 1;
    }
    if (jQuery("#LBdiamonds").data("type") == 'lab_grown') {
        type = 0;
    }

    DisplaySearch(type, 'lbDiamonds', shop, base_url, 'mined-lab-diamonds');

    function DisplaySearch(type, url, shop, base_url, display_diamond) {
        jQuery.ajax({
            url: base_url + url,
            type: "post",
            data: {
                type: type,
                shop: shop
            },
            success: function (data) {
                jQuery("#LBdiamonds").html(data);
                fetchData(display_diamond);
            }
        });
    }

    $("body").on("click", ".smart-search", function () {
        $(this).addClass('active');
        $('.custom-search').removeClass('active');
        DisplaySearch(type, 'lbDiamondsSmart', shop, base_url, 'mined-lab-diamonds-smart');
    });


    $("body").on("click", ".custom-search", function () {
        $(this).addClass('active');
        $('.smart-search').removeClass('active');
        DisplaySearch(type, 'lbDiamonds', shop, base_url, 'mined-lab-diamonds');
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
    console.log('**********************************Ok');
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

    if (jQuery("#LBdiamonds").data("type") == 'mined') {
        type = 1;
    }
    if (jQuery("#LBdiamonds").data("type") == 'lab_grown') {
        type = 0;
    }
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
            // weight: currentWeight,

            currentPage: currentPage
        },
        success: function (res) {
            setTimeout(function () {
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
//=====Validation======
setInterval(function(){
  $('ul.ring_images li.link-faded').each(function(){
console.log($(this).find('.active-ring').length);
    if ($(this).find('.active-ring').length > 0) {
      // If the active-ring class is found
      $('span.custom-text-validation').hide();
    } else {
      $('span.custom-text-validation').show();
    }
  });
},1000);
//=====End here===== 

// Filter data shape
$("body").on("click", ".link-faded", function () {
     console.log('clicked');
    $('span.custom-text-validation').hide();
    currentShape = $(this).attr('data-type');
    $(".link-faded").removeClass("active-ring");
    $(this).addClass("active-ring");
    var display_diamond = $('custom-search').attr('data-type');
    fetchData($('.custom-search').attr('data-type'));
});

// Filter data color
$("body").on("click", "input[name='colorFilter[]']", function () {
    currentColor = [];
    $("input[name='colorFilter[]']:checked").each(function () {
        currentColor.push($(this).val());
    });
    fetchData($('.custom-search').attr('data-type'));
});

// Filter data clarity
$("body").on("click", "input[name='clarityFilter[]']", function () {
    currentClarity = [];
    $("input[name='clarityFilter[]']:checked").each(function () {
        currentClarity.push($(this).val());
    });
    fetchData($('.custom-search').attr('data-type'));
});

// Filter data cut
$("body").on("click", "input[name='cutFilter[]']", function () {
    currentCut = [];
    $("input[name='cutFilter[]']:checked").each(function () {
        currentCut.push($(this).val());
    });
    fetchData($('.custom-search').attr('data-type'));
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
    currentCart = [];
    $("input[name='cartFilter[]']:checked").each(function () {
        currentCart.push($(this).val());
    });
    fetchData($('.custom-search').attr('data-type'));
});




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

