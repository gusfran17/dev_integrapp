$(document).ready(function(){

	$('#role').change(function(){
		$('#description-user').find('div').fadeOut('slow');
		var option= $('#role option:selected').val();
		$.ajax({
			type:"POST",
			url:"Resources/data/userOptions.php",
			data:{option:option},
			success: function(data){
				$('#description-user').hide().append("<div>"+data+"<div>").delay(800).fadeIn('slow');
			}
		});

	});

	$(function(){
		$('body').on('focusout', '.landing-search', function(){
			var el = $(this);
			if(el.val() !== ""){
				el.addClass('-active');
			} else {
				el.removeClass('-active');
			}
		});
	});

	var idCategory;
	var finalCategory;
	var finalCategoryID;


	//Gets the select category event and calls setNextCategory with its ID
	$('#productsCategorySelect').on('change', 'select', function () {
		idCategory=$(this).attr('id');
		finalCategory=$(this).find(':selected').text();
		finalCategoryID = $(this).find(':selected').attr('id');
		//console.log("idCat: " + idCategory + " fCat: " + finalCategory + " fCatID: " + finalCategoryID);
		divID = "productsCategorySelect";
		setNextCategory(divID);
	});

	$('#productsCategorySelect').on('click', 'button', function(){
		getTree();
                $('#categoryLoaded').remove();
		$('#productsCategorySelect').append('<div id="categoryLoaded"> <p style="margin-top: 10px" >Se ha cargado la categoria del producto más abajo...</p></div>');
	});

	function getTree(){
			var str = "";
	    $( "#productsCategorySelect select option:selected" ).each(function() {
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

	function setNextCategory(divID){
		if (divID != null) {	
			//console.log(divID);
			var categoryLevel= idCategory.substr(8,1);
			//Deletes all spare dropdowns when root categories are changed
			for ( i = parseInt(categoryLevel)+1; i <= 5; i++) {
				$("#category"+i).remove();
				$("#confirmation").remove();
				$("#categoryLoaded").remove();
			}
			var str = "";

		    $( "#" + divID + " select option:selected" ).each(function() {
		      str = $( this ).attr('id') + " ";
		      //console.log(str);
		    });
		    //console.log(str);
		    if (str!=0){
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
			  				$('#' + divID).append("<select id='category"+categoryLevel+"' class='categories col-xs-12 col-sm-12 col-md-12 col-lg-12'></select>");
			  				$('#category'+categoryLevel).append("<option id='"+0+"'>Seleccione una sub-categoria</option>");
			  				for(var i in data){
					     		var obj=data[i];
					     		if (obj != null){
					     			//console.log(data);
						     		for(var j in obj){
						     			var id=obj[j].id;
						     			var name=obj[j].name;
						     			$('#category'+categoryLevel).append("<option id='"+id+"'>"+name+"</option>");
						     		}
							    } 	
					     	}
			  			} else {
			  				if (divID == "productsCategorySelect") {
				  				$("#categoryID").val(finalCategoryID);
						  		$('#' + divID).append("<div id='confirmation' style='margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;'><p>Ha seleccionado la categoria "+finalCategory+"</p><button class='btn btn-default' type='submit' id='submit1' data-toggle='popover' title='La categoria será agregada más abajo' style='margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;'>Confirmar</button></div>");
					  		} else {
					  			$('#' + divID).append("<div id='confirmation' style='margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;'><p>"+finalCategory+" es la categoria final</p></div>");	
					  		}
				  		}
			  		}
			  	});
		    }
		}
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
				$('.alert').remove();
				integrappCode = $(this).attr('id');
				duplicateOrEditProduct(integrappCode, true);
			
		} else if (buttonName=="duplicateRecentlyAdded") {
				$('.alert').remove();
				integrappCode = $(this).attr('id');
				duplicateOrEditProduct(integrappCode, false);
		} else if (buttonName=="deleteRecentlyAdded") {
				$('.alert').remove();
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
		//Product is being edited already, in order to prevent conflicts with dropzone this won't let you continue
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
			//console.log (form_data);
			$.ajax({
				url: $("#basePath").val() + 'product/editProduct',
				type:'POST',
				data: form_data,
				dataType:'html',
				success:function(data, textStatus, jqXHR){
					//console.log(data);
					//console.log("jqXHR: " + jqXHR);
					var json = JSON.parse(data);
					//console.log(json);
					$("#productName").val(json.editProduct.name);
					$("#categoryTree").val(json.editProduct.short_desc);
					$("#categoryID").val(json.editProduct.category_id);
					$("#productCode").val(json.editProduct.code);
					$("#productVAT").val(json.editProduct.tax);
					$("#productPrice").val(json.editProduct.price);
					$("#productDesc").val(json.editProduct.description);
					$("#productIndic").val(json.editProduct.indications);
					$("#productPresc").val(json.editProduct.prescription);
					$("#prodImagesArray").remove();
					$("#productEdition").val("true");
					$('#selected_colors').empty();
					$("#editProductStatus").val("");
					$.each(json.editProduct.colors, function(index, value) {
						//console.log("Color: "+ value.color)
						$('.selected_colors_div').show();
						var newColor = $("<div/>");
        				newColor.addClass('color').attr('style', "border-style: solid; border-width: 1px; background-color: "+ value.color + "; height: 20px; width: 20px;");
        				var inputColor = $('<input/>');
        				inputColor.attr("name", "selectedColorsArray[]").attr("value", value.color);
        				inputColor.attr("type", "hidden");
        				inputColor.attr("id", "selectedColorsArray[]");
        				newColor.append(inputColor);
        				//console.log(newColor);
        				//console.log(inputColor);
        				newColor.on('click', function(){
        					$(this).remove();
        				});
        				$('#selected_colors').append(newColor);
					});
					$('.form-group_specifications').remove();
					$.each(json.editProduct.attributes, function(index, value) {
						//console.log("name: "+ value.attribute_name + " value: "+ value.attribute_value)
						$(".input_fields_wrap").append('<div class="form-group_specifications" >'+
															'<textarea type="text" id="' + index + '" name="attribute' + index + '" placeholder="Tipo de Variante..." class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-right:10px;">' + 
																value.attribute_name + 
															'</textarea>'+
															'<textarea type="text" id="' + index + '" name="value' + index + '" placeholder="Valor de Variante..." class="col-xs-6 col-sm-6 col-md-6 col-lg-6">' + 
																value.attribute_value + 
															'</textarea>'+
															'<a href="#" class="remove_field"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'+
														'</div>');
					});
					if (isEdit){
						$("#editProductStatus").val(json.editProduct.status);
						if ($("#editProductStatus").val() == "published"){
							$("#categorySelection").hide();
						}
						$("#editProductID").val(json.editProduct.id);
						var myDropzone = Dropzone.forElement('#freewalk-dropzone');
						$.each(myDropzone.files, function(index, value) {
							myDropzone.removeFile(value);
						});
						if (json.editProduct.hasImages==true){
							$.each(json.editProduct.images, function(index, value) {
								var mockFile = { name: "Imagen", size: 12345, file_name: value };
								myDropzone.options.addedfile.call(myDropzone, mockFile);
								myDropzone.options.thumbnail.call(myDropzone, mockFile, $("#imagesPath").val() + "/" + value);
								$("#imagesArray").append("<input type='hidden' name='images[]' value='"+ value +"' />");
							});
						}
						//Alert that a product is being edited
						$("#editionAlert").empty();
						$("#editionAlert").append('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button><strong>¡Atención!</strong> Se encuentra editando del producto ' + json.editProduct.integrapp_code + ' cargado recientemente.<br>Para volver a cargar un producto desde el inicio debe presionar en <b>Cancelar</b> al final de la pantalla.</div>');
					} else {
						//Alert that a product is being copied
						$("#editionAlert").append('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button><strong>¡Atencion!</strong> Se encuentra duplicando información del producto ' + json.editProduct.integrapp_code + ' que ha cargado recientemente, para volver a cargar un producto desde el inicio debe presionar en Cancelar al final de la pantalla.</div>');
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
        //console.log(x);
        var existingDivs = $('.form-group_specifications');
        console.log(existingDivs);
        $.each(existingDivs, function(index, value) {
        	//console.log("X a secas: "+x);
        	//console.log("Index: "+index);
        	//console.log($(this).find('input').attr('id'));
        	var auxId = $(this).find('textarea').attr('id');
        	if (x <= auxId){
        		x = (parseInt(auxId) + 1);
        	}
        	//console.log(x);
        });
        if(x < max_fields){ //max input box allowed
            $(wrapper).append('<div class="form-group_specifications">'+
	            					'<textarea type="text" id="' + x + '" name="attribute' + x + '" placeholder="Atributo..." class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-right:10px;"></textarea>'+
	            					'<textarea type="text" id="' + x + '" name="value' + x + '" placeholder="Valor..." class="col-xs-6 col-sm-6 col-md-6 col-lg-6" ></textarea>'+
	            					'<a href="#" class="remove_field"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'+
            				  '</div>'); //add input box
            $('.example_specifications').remove();
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove();
    });



});

