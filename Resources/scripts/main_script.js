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

$('#1-category').change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).attr('id') + " ";
    });
    
    console.log(str);
  	$.ajax({
  		url:'/dev_integrapp/profile/product/'+str,
  		type:'POST',
  		dataType:'json',
  		data:{parent:str},
  		success:function(data){
  			
  			console.log(data)
  		}
  	});

  })
  .change();


});