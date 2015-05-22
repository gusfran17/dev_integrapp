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

$('#products').on('change', 'select', function () {
	idCategory=$(this).attr('id');
	finalCategory=$(this).find(':selected').text();
	ajaxCall();

});

function ajaxCall(){
	var categoryLevel= idCategory.substr(8,1);
	for ( i = parseInt(categoryLevel)+1; i <= 5; i++) {
		$("#category"+i).remove();
		$("#confirmation").remove();
	}
	var str = "";

    $( "select option:selected" ).each(function() {
      str = $( this ).attr('id') + " ";
    });
	$.ajax({
  		url:'/dev_integrapp/product/get_categories/'+str,
  		type:'POST',
  		dataType:'json',
  		data:{id:str},
		statusCode: {
		    500: function() {
		      $('#products').append("<div id='confirmation'><p>Ha seleccionado la categoria "+finalCategory+"</p><button type='submit' id='submit1'>Confirmar</button></div>");
		    }
		  },
  		success:function(data){
  			categoryLevel++;
  			$('#products').append("<select id='category"+categoryLevel+"' class='categories'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#category'+categoryLevel).append("<option id='"+id+"'>"+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
}
/*End code*/

$(document).ready(function() {
    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" class="inputProperty" name="mytext[]" placeholder="Atributo..."/><input type="text" class="inputProperty" name="mytext[]" placeholder="Valor..."/><a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});




var property;

function drawPannels(){



}


function propertySwitch(){

}





var buttonId;

$('#products').on('click', 'button', function(){
		var str = "";

    $( "select option:selected" ).each(function() {
      str = $( this ).attr('id') + " ";
    });
	var category = $('#products').find('select').last().find('option:selected').text();
	$.ajax({
		url:'/dev_integrapp/product/get_tree/'+str,
		type:'post',
		data:{id:str},
		success:function(data){
			$('#categoryTree').val(data);
			console.log(data);
		}
	});

	/*$('#medidas').empty();
	$('#properties').fadeIn();
	buttonId=$(this).attr('id');
	buttonIdNumber=buttonId.substr(6,1);
	var category = $('#products').find('select').last().find('option:selected').text();

	$('#input'+buttonIdNumber).fadeIn();
	$('#input'+buttonIdNumber+' input').val(category);

	$('#confirmation').fadeOut();
	 	  var str = "";
    $( "select option:selected" ).each(function() {
      str = $( this ).attr('id');
    });
	$.ajax({
  		url:'/dev_integrapp/profile/getProperties/'+str,
  		type:'GET',
  		dataType:'json',
  		success:function(data){
	        $.each(data, function(index, item) {
	        	var items = item[0];
	         	$.each(Object.keys(items).slice(1,5), function(property, value){
	        		$('#medidas').append('<label>'+value+': </label><input type="text" placeholder="30cm"><label>Unidad: </label><select><option>cm</option><option>mts</option></select> </br>');
	        	});

	        });
  		}
  	});*/
});




});