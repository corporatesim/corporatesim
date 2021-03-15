/**
 * 
 */

// set ajaxfolder
var ajaxfolder = "ux-admin/model/ajax/";

// On Service area change populate category
$('#s_id').change( function(){
	var s_id = $(this).val();
	$.ajax({
		url: site_root + ajaxfolder + "populate_dropdown.php",
		type: "POST",
		data: { s_id: s_id },
		success: function(data){
			$('#category').html(data);
		}
	});
});

//On Category change populate subcategory
$('#category').change( function(){
	var cat_id = $(this).val();
	$.ajax({
		url: site_root + ajaxfolder + "populate_dropdown.php",
		type: "POST",
		data: { cat_id: cat_id },
		success: function(data){
			$('#subcategory').html(data);
		}
	});
});

// Set Validate Form Rules on submit
$("#add_product").validate({
	rules: {
		s_id: {
            required: {
                depends: function(element) {
                    return $("#s_id").val() == '';
                }
            }
		},	
		category: {
            required: {
                depends: function(element) {
                    return $("#category").val() == '';
                }
            }
		},
		subcategory: {
            required: {
                depends: function(element) {
                    return $("#subcategory").val() == '';
                }
            }
		},
        company_name: {
			required: true,
		},
		product_name: {
			required: true,
		},
		product_spec: {
			required: true,
		}
	}
});
  
$('#frm_submit').click( function(){
	if($("#add_product").valid()){
		$( "#addproduct_btn" ).trigger( "click" );
	}
});

$('#updt_btn').click( function(){
	if($("#add_product").valid()){
		$( "#update_btn" ).trigger( "click" );
	}
});

$('.btn_img').click( function (){
	var btn = $(this);
	var img_name = btn.val();
	$.ajax({
		url: site_root + 'ux-admin/model/ajax/remove_img.php',
		type: 'POST',
		data: { imgname: img_name, p_id: p_id },
		success: function(data){
			var result = JSON.parse(data);
			if(result.success == 1){
				var parentid = $(this).parent().attr('id');
				var parentid = $('#' + parentid).parent().attr('id');
				btn.parent().parent().remove();				
			}else{
				alert(data);
			}
		}
	});
});