$(document).ready(function(){

$('#role').change(function(){
	$('#description-user').find('div').fadeOut('slow');
	var option= $('#role option:selected').val();
	$.ajax({
		type:"POST",
		url:"../../Resources/data/userOptions.php",
		data:{option:option},
		success: function(data){
			console.log(data);
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

function ajaxCall(){
	var categoryLevel= idCategory.substr(8,1);
	for ( i = parseInt(categoryLevel)+1; i <= 5; i++) {
		$("#category"+i).remove();
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
  		success:function(data){
  			categoryLevel++;
  			$('#products').append("<select id='category"+categoryLevel+"' class=''></select>");
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
	ajaxCall();
});


});