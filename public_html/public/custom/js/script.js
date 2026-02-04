function alert_msg(text) {
  jQuery(".alert_msg").html(text);
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
$(document).ready(function () {
    var base_url = 'https://app.billigjewelers.com/';

    if(jQuery(".default").hasClass("active-nav")){    

       jQuery(".reorder_table tbody").sortable({ 
           cursor: 'move', 
           update: function() {
           var order = jQuery("#reorder_form").serialize(); 
           
             jQuery.ajax({
                url: base_url + "reorder",
                type: "post",
                data: order,
                success: function(data) {
                   
                }
            }); 
        }
    });
    }
    jQuery("#check_all").click(function () {
        if (jQuery(this).is(":checked")) {
            jQuery(".size_section").find(".required").prop("checked", true);
        } else {
            jQuery(".size_section").find(".required").prop("checked", false);
        }
    });
    jQuery('input[name="size"]').click(function () {
        if (!jQuery(this).is(":checked")) {
            jQuery("#check_all").prop("checked", false);
        }
    });
    
    jQuery(".submit_btn").on("click", function (e) {
        jQuery(".Polaris-TextField__Backdrop,.Polaris-Checkbox__Backdrop").removeClass("input_error");
        e.preventDefault();
        var error = 0;
        jQuery(".submit_btn .text_btn").hide();
        jQuery(".submit_btn .Polaris-Spinner").removeClass("hidden");
        jQuery(".required").each(function () {
            if (jQuery(this).is(":visible") && jQuery(this).val() == "") {
                jQuery(this).addClass("input_error");
                jQuery(this).parents(".Polaris-TextField").find(".Polaris-TextField__Backdrop").addClass("input_error");
                error = 1;
            }
        });
        $("input:checkbox.required").each(function () {
            var name = jQuery(this).attr("name");
            if (jQuery(this).is(":visible")) {
                if (jQuery("input[name='" + name + "']:checked").length == 0) {
                    jQuery(this).parents(".Polaris-Checkbox").find(".Polaris-Checkbox__Backdrop").addClass("input_error");
                    error = 1;
                }
            }
        });
        if (error == 1) {
            jQuery(".submit_btn .Polaris-Spinner").addClass("hidden");
            jQuery(".submit_btn .text_btn").show();
            return false;
        }

        jQuery.ajax({
                url: base_url+"enable_product",
                type: "post",
                data: jQuery("#enable_product").serialize(),
                success: function(data) {
                    alert_msg("Records saved");
                    jQuery(".submit_btn .Polaris-Spinner").addClass("hidden");
                    jQuery(".submit_btn .text_btn").show();
                    window.location.reload(true);
                }
            });

    });

       jQuery('body').on('click',".submit_btns",function() {
           jQuery(".Polaris-TextField__Backdrop,.Polaris-Checkbox__Backdrop,.Polaris-Select__Backdrop").removeClass("input_error");
 
           var error = 0;
           jQuery(".required").each(function () {
                if (jQuery(this).is(":visible") && jQuery(this).val() == "") {
                    jQuery(this).addClass("input_error");
                    jQuery(this).parents(".Polaris-TextField").find(".Polaris-TextField__Backdrop").addClass("input_error");
                    error = 1;
                }
            });

            jQuery("select.required").each(function () {
                if (jQuery(this).is(":visible") && jQuery(this).val() == "") {

                    jQuery(this).parents(".Polaris-Select").find(".Polaris-Select__Backdrop").addClass("input_error");
                    error = 1;
                    
                }
            });

            $("input:checkbox.required").each(function () {
                var name = jQuery(this).attr("name");
                if (jQuery(this).is(":visible")) {
                    if (jQuery("input[name='" + name + "']:checked").length == 0) {
                        jQuery(this).parents(".Polaris-Checkbox").find(".Polaris-Checkbox__Backdrop").addClass("input_error");
                        error = 1;
                    }
                }
            });
            if (error == 1) {
                jQuery(".Polaris-Frame-Toast").css("background-color", "#e51c00");
                alert_msg('Please fill all the required fields');
                return false;
            }

              jQuery.ajax({
                async: false,
                url: base_url + "add-template",
                type: "post",
                data: jQuery("#add_setting").serialize(),
                success: function(data) {
                jQuery(".Polaris-Frame-Toast").css("background-color", "#1f2124");

                alert_msg('Record saved!');
                location.reload();
                    
                }
            });
        });


    $(".setting-tab").click(function() {
        $('.setting-tab').removeClass('active-nav');
        $(this).addClass(' active-nav')

        var tab = $(this).attr('data-tab');
        var cat = $(this).attr('data-cat');
        if(tab != 'All'){
          jQuery("#templateData tr").hide();
          jQuery("#templateData tr."+cat).show();
        }else{
          jQuery("#templateData tr").show();  
        }
        
    });

        $(document).on('click', '.delete_template', function() {
        var id = $(this).data("id");
        $.ajax({
            type: "POST",
            url: base_url+"delete-tab",
            data: {
                id: id
            },
            beforeSend: function() {
                //loader show
            },
            complete: function() {
                //loader hide
            },
            success: function(response) {
                alert_msg('Record deleted successfully!');
                location.reload();
            }
        });
    });

});
