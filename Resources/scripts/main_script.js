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
	  		url: $("#basePath").val() + 'product/getTree/'+str,
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
	  		url: $("#basePath").val() + 'product/getCategories/'+str,
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
	});

	// According to the option selected this function will prepare de form for edition or duplication of a product
	$('#divRecentlyAddedProducts').on('click', 'button', function(){
		buttonName = $(this).attr('name');
		if(buttonName=="editRecentlyAdded"){
				integrappCode = $(this).attr('id');
				duplicateOrEditProduct(integrappCode, true);
			
		} else if (buttonName=="duplicateRecentlyAdded") {
				integrappCode = $(this).attr('id');
				duplicateOrEditProduct(integrappCode, false);
		} else if (buttonName=="deleteRecentlyAdded") {
				integrappCode = $(this).attr('id');
				deleteProduct(integrappCode);
		}
	});

	function deleteProduct(integrappCode){
		var islreadyEditing = $("#editProductID").val();
		if (islreadyEditing != "") {
			alert("¡ATENCION! Usted esta editando un producto. Para realizar otra operación usted debe hacer click en Cancelar al final de la pantalla.");	
		} else {
			var form_data = {
				deletionIntegrapCode : integrappCode
			}
			//console.log (form_data);
			$.ajax({
				url: $("#basePath").val() + 'product/deleteProduct',
				type:'POST',
				data: form_data,
				dataType:'html',
				success:function(data, textStatus, jqXHR){
					//console.log(data);
					//console.log("jqXHR: " + jqXHR);
					var json = JSON.parse(data);
					//console.log("JSON: "+json);
					//console.log("deletionProduct: " + json.deletionProduct);
					if (json.deletionProduct){
						var trName = "tr_" + json.deletionProduct;
						//console.log(trName);
						$("#"+ trName).remove();
						alert("Se ha eliminado el producto de código " + json.deletionProduct + ".");
					}
					
					
				},
				error: function(jqXHR,textStatus,errorThrown){
					//console.log("jqXHR: "+jqXHR);
					//console.log("Status: "+textStatus);
					//console.log("Error: "+errorThrown);
				},
	 		});
		}
	}

	function duplicateOrEditProduct(integrappCode, isEdit){
		var islreadyEditing = $("#editProductID").val();
		if (islreadyEditing != "") {
			if (isEdit){
				alert("¡ATENCION! Usted ya esta editando otro producto. Para escoger otro producto a editar haga click en Cancelar al final de la pantalla.");
			} else {
				alert("¡ATENCION! Usted esta editando un producto. Para realizar otra operación usted debe hacer click en Cancelar al final de la pantalla.");	
			}
			//console.log(islreadyEditing);
		} else {
			var form_data = {
				editionIntegrapCode : integrappCode
			}
			console.log (form_data);
			$.ajax({
				url: $("#basePath").val() + 'product/editProduct',
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
					$("#productCode").val(json.editProduct.code);
					$("#productVAT").val(json.editProduct.tax);
					$("#productPrice").val(json.editProduct.price);
					$("#productDesc").val(json.editProduct.description);
					$("#prodImagesArray").remove();
					$("#productEdition").val("true");
					$.each(json.editProduct.attributes, function(index, value) {
						$(".input_fields_wrap").append('<div class="form-group_specifications"><input type="text" class="inputProperty" id="' + index + '" name="attribute' + index + '" value="' + value.attribute_name + '" placeholder="Atributo..."/><input type="text" class="inputProperty" id="' + index + '" name="value' + index + '" value="' + value.attribute_value + '" placeholder="Valor..."/><a href="#" class="remove_field">X</a></div>');
					});
					if (isEdit){
						$("#editProductID").val(json.editProduct.id);
						var myDropzone = Dropzone.forElement('#freewalk-dropzone');
						$.each(myDropzone.files, function(index, value) {
							myDropzone.removeFile(value);
						});
						$.each(json.editProduct.images, function(index, value) {
							var mockFile = { name: "Imagen", size: 12345, file_name: value };
							myDropzone.options.addedfile.call(myDropzone, mockFile);
							myDropzone.options.thumbnail.call(myDropzone, mockFile, $("#imagesPath").val() + "/" + json.editProduct.id + "/thumbs/" + value);
							$("#imagesArray").append("<input type='hidden' name='imagen[]' value='"+ value +"' />");
						});
						//Alert that a product is being edited
						$("#editionAlert").empty();
						$("#editionAlert").append('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Atencion!</strong> Se encuentra en modo edición de uno del producto ' + json.editProduct.integrapp_code + ' que ha cargado recientemente, para volver a cargar un producto desde el inicio debe presionar en Cancelar al final de la pantalla.</div>');
					} else {
						//Alert that a product is being copied
						$("#editionAlert").append('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Atencion!</strong> Se encuentra duplicando la informacion del producto ' + json.editProduct.integrapp_code + ' que ha cargado recientemente, para volver a cargar un producto desde el inicio debe presionar en Cancelar al final de la pantalla.</div>');
					}
				},
				error: function(jqXHR,textStatus,errorThrown){
					//console.log("jqXHR: "+jqXHR);
					//console.log("Status: "+textStatus);
					//console.log("Error: "+errorThrown);
				},

	 		});
		}
	}


    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        var x = 0; //starts in -1 to take off the existing example box
        console.log(x);
        var existingDivs = $('.input_fields_wrap .form-group_specifications');
        console.log(existingDivs);
        $.each(existingDivs, function(index, value) {
        	//console.log("X a secas: "+x);
        	//console.log("Index: "+index);
        	//console.log($(this).find('input').attr('id'));
        	var auxId = $(this).find('input').attr('id');
        	if (x <= auxId){
        		x = (parseInt(auxId) + 1);
        	}
        	console.log(x);
        });
        if(x < max_fields){ //max input box allowed
            $(wrapper).append('<div class="form-group_specifications"><input type="text" class="inputProperty" id="' + x + '" name="attribute' + x + '" placeholder="Atributo..."/><input type="text" class="inputProperty" id="' + x + '" name="value' + x + '" placeholder="Valor..."/><a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove();
    });



});