$(document).ready(function(){

$('#role').change(function(){
	$('#description-user').find('div').fadeOut('slow');
	var option= $('#role option:selected').val();
	$.ajax({
		type:"POST",
		url:"../../Resources/data/userOptions.php",
		data:{option:option},
		success: function(data){
			$('#description-user').hide().append("<div>"+data+"<div>").delay(800).fadeIn('slow');
		}
	})

});

$(window).scroll(function(){
	if ($(window).scrollTop()>50) {
		$('.navbar').css("height", "65px");
		$('.navbar-nav > li > a').css("padding", "5px");
		$('.navbar-brand figure img').css("width", "75%");

	}else{
		$('.navbar').css("height", "80px");
		$('.navbar-nav > li > a').css("padding", "15px");
		$('.navbar-brand figure img').css("width", "100%");

	}
});



/*!!! Codigo para dropdown menu !!!*/
var idCategory;
var finalCategory;
var finalCategoryID;



$('#products').on('change', 'select', function () {
	idCategory=$(this).attr('id');
	finalCategory=$(this).find(':selected').text();
	finalCategoryID = $(this).find(':selected').attr('id');
	ajaxCall();

});

$('#products').on('click', 'button', function(){
	getTree();
});

function getTree(){
		var str = "";
    $( "select option:selected" ).each(function() {
      str = $( this ).attr('id') + " ";
    });

	$.ajax({
  		url:'/dev_integrapp/product/get_tree/'+str,
		type:'POST',
		data:{id:str},
		dataType:'json', 
		success:function(data){
			
			var tree = data['tree'].ascending_path;
			$('#categoryTree').val(tree);
			$('#categoryTree').html(tree);
		}
	});
}

function ajaxCall(){
	var categoryLevel= idCategory.substr(8,1);
	//Deletes all spare dropdowns when root categories are changed
	for ( i = parseInt(categoryLevel)+1; i <= 5; i++) {
		$("#category"+i).remove();
		$("#confirmation").remove();
	}
	var str = "";

    $( "select option:selected" ).each(function() {
      str = $( this ).attr('id') + " ";
    });
    console.log(str);
	$.ajax({
  		url:'/dev_integrapp/product/get_categories/'+str,
  		type:'POST',
  		dataType:'json',
  		data:{id:str},
		statusCode: {
		    500: function() {
		      

		    }
		  },
  		success:function(data){
  			if (data['NextCategory'] != null){
  				categoryLevel++;
  				$('#products').append("<select id='category"+categoryLevel+"' class='categories'></select>");
  				for(var i in data){
		     		var obj=data[i];
		     		if (obj != null){
		     			console.log(data);
			     		for(var j in obj){
			     			var id=obj[j].id;
			     			var name=obj[j].name;
			     			$('#category'+categoryLevel).append("<option id='"+id+"'>"+name+"</option>");
			     		}
				    } 	
		     	}
  			} else {
  				$("#categoryID").val(finalCategoryID);
		  		$('#products').append("<div id='confirmation'><p>Ha seleccionado la categoria "+finalCategory+"</p><button type='submit' id='submit1'>Confirmar</button></div>");
	  		}
  		}
  	});
}
/*End code*/


$('#saveProduct').click(function(){
	//To obtain categoryTree information through post it needs to be enabled temporary
	$("#categoryTree").removeAttr('disabled');

	// var form_data = {
	// 	productName: $("input[name='productName']").val(), 
	// 	productCode: $("input[name='productCode']").val(),
	// 	productVAT: $("input[name='productVAT']").val(),
	// 	categoryID: finalCategoryID,
	// 	categoryTree: $("input[name='categoryTree']").val(),
	// 	productDesc: $("textarea[name='productDesc']").val(),
	// }

	// if ($('.specifications')) {

	// 	var i=1;

	// 	$('.specifications').each(function(){
	// 		var attribute=$(this).find('input[name="attribute"]').val();
	// 		var value=$(this).find('input[name="value"]').val();
	// 		form_data['attribute'+i] = attribute;
	// 		form_data['value'+i] = value;
	// 		i++;
	// 	});



	// };
	// event.preventDefault();
	
	// console.log (form_data);

	// $.ajax({

	// 	url:'../product/save_product',
	// 	type:'POST',
	// 	data: form_data,
	// 	dataType:'json',
	// 	success:function(data){
	// 		console.log(data);
	// 		$('#tableBody').append("<tr><td>"+data.name+"</td><td>"+data.description+"</td><td>"+data.integrapp_code+"</td><td>"+data.code+"</td></tr>")
	// 		$('#formOptions input[type=text]').val('');
	// 		$('#formOptions textarea').val('');
	// 		$('.alert').removeClass('insight');
	// 	}

	// });
	});


	$('#divRecentlyAddedProducts').on('click', 'button', function(){
		buttonName = $(this).attr('name');
		if(buttonName=="editRecentlyAdded"){
			var islreadyEditing = $("#productEdition").val();
			if (islreadyEditing == "true") {
				alert("¡ATENCION! Usted ya esta editando otro producto. Para escoger otro producto a editar haga click en Cancelar al final de la pantalla.")
			} else {
				integrappCode = $(this).attr('id');
				var form_data = {
					editionIntegrapCode : integrappCode
				}
				console.log (form_data);
				$.ajax({
					url:'../product/editProduct',
					type:'POST',
					data: form_data,
					dataType:'html',
					success:function(data, textStatus, jqXHR){
						//console.log(data);
						//console.log("jqXHR: " + jqXHR);
						var json = JSON.parse(data);
						console.log(json);
						$("#productName").val(json.editProduct.name);
						$("#categoryTree").val(json.editProduct.short_desc);
						$("#categoryID").val(json.editProduct.category_id);
						$("#productID").val(json.editProduct.id);
						$("#productCode").val(json.editProduct.code);
						$("#productVAT").val(json.editProduct.tax);
						$("#productDesc").val(json.editProduct.description);
						$("#prodImagesArray").remove();
						$("#productEdition").val("true");
						var myDropzone = Dropzone.forElement('#freewalk-dropzone');
						//Dropzone.forElement("#freewalk-dropzone").removeAllFiles(myDropzone.files);
						//myDropzone.removeAllFiles();
						$.each(myDropzone.files, function(index, value) {
							myDropzone.removeFile(value);
						});
						$.each(json.editProduct.images, function(index, value) {
							var mockFile = { name: "Imagen", size: 12345, file_name: value };
							myDropzone.options.addedfile.call(myDropzone, mockFile);
							myDropzone.options.thumbnail.call(myDropzone, mockFile, $("#imagesPath").val() + "/" + json.editProduct.id + "/thumbs/" + value);
							$("#imagesArray").append("<input type='hidden' name='imagen[]' value='"+ value +"' />");
						});
						$.each(json.editProduct.attributes, function(index, value) {
							console.log(value);
							console.log(index);
							attributeNumber = index + 1; //index starts in 0 (refer below for: $(add_button).click(function(e) )
							$(".input_fields_wrap").append('<div class="form-group specifications"><input type="text" class="inputProperty" name="attribute' + attributeNumber + '" value="' + value.attribute_name + '" placeholder="Atributo..."/><input type="text" class="inputProperty" name="value' + attributeNumber + '" value="' + value.attribute_value + '" placeholder="Valor..."/><a href="#" class="remove_field">X</a></div>');
						});
					},
					error: function(jqXHR,textStatus,errorThrown){
						console.log("jqXHR: "+jqXHR);
						console.log("Status: "+textStatus);
						console.log("Error: "+errorThrown);
					},

		 		});

			}

	
		}
	});



    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(wrapper).append('<div class="form-group specifications"><input type="text" class="inputProperty" name="attribute' + x + '" placeholder="Atributo..."/><input type="text" class="inputProperty" name="value' + x + '" placeholder="Valor..."/><a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });



});