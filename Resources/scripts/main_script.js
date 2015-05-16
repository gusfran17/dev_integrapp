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


var idCategory;
var finalCategory;

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
  		url:'/dev_integrapp/profile/product/'+str,
  		type:'POST',
  		dataType:'json',
  		data:{parent:str},
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





$('#products').on('change', 'select', function () {
	idCategory=$(this).attr('id');
	finalCategory=$(this).find(':selected').text();
	ajaxCall();


});


var buttonId;

$('#products').on('click', 'button', function(){
	$('#properties').empty();
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
	        		$.each(item[0], function(property, value){
	        			if (value == 'true' ) {
	        				$('#properties').append('<p>'+property+'</p>')
	        			};
	        		});

	        });
  		}
  	});
});


function categoryProperty(){

 

}


});