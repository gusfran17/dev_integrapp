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

$('#FirstCategory').change(function () {
	$('#result').empty();
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).attr('id') + " ";
    });
   	$.ajax({
  		url:'/dev_integrapp/profile/product/'+str,
  		type:'POST',
  		dataType:'json',
  		data:{parent:str},
  		success:function(data){
  			$('#result').append("<select id='SecondCategory'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#SecondCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
  })
  .change();

  /*$('#SecondCategory').ready(function(){

  	$(this).change(function () {
  		$('#ThirdCategory').remove();
	    var id = "";
	    $("#SecondCategory option:selected").each(function() {
	      id += $( this ).attr('id') + " ";
	    });
	    	$.ajax({
  		url:'/dev_integrapp/profile/product/'+id,
  		type:'POST',
  		dataType:'json',
  		data:{parent:id},
  		success:function(data){
  			$('#result').append("<select id='ThirdCategory'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#ThirdCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
	  })
 
  });*/

$('body').on('change', '#SecondCategory', function () { 
	$('#ThirdCategory').remove();
	$('#FourthCategory').remove();
	$('#FifthCategory').remove();
	    var id = "";
	    $("#SecondCategory option:selected").each(function() {
	      id += $( this ).attr('id') + " ";
	    });
	    	$.ajax({
  		url:'/dev_integrapp/profile/product/'+id,
  		type:'POST',
  		dataType:'json',
  		data:{parent:id},
  		success:function(data){
  			$('#result').append("<select id='ThirdCategory'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#ThirdCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
	
});

$('body').on('change', '#ThirdCategory', function () { 
	$('#FourthCategory').remove();
	$('#FifthCategory').remove();
	    var id = "";
	    $("#ThirdCategory option:selected").each(function() {
	      id += $( this ).attr('id') + " ";
	    });
	$.ajax({
  		url:'/dev_integrapp/profile/product/'+id,
  		type:'POST',
  		dataType:'json',
  		data:{parent:id},
  		success:function(data){
  			$('#result').append("<select id='FourthCategory'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#FourthCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
});


$('body').on('change', '#FourthCategory', function () { 
	$('#FifthCategory').remove();
	    var id = "";
	    $("#FourthCategory option:selected").each(function() {
	      id += $( this ).attr('id') + " ";
	    });
	$.ajax({
  		url:'/dev_integrapp/profile/product/'+id,
  		type:'POST',
  		dataType:'json',
  		data:{parent:id},
  		success:function(data){
  			$('#result').append("<select id='FifthCategory'></select>");
  	     	for(var i in data){
	     		var obj=data[i];
	     		for(var j in obj){
	     			var id=obj[j].id;
	     			var name=obj[j].name;
	     			$('#FifthCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	     		}
	     		
	     	}
  		}
  	});
});


  // $('#ThirdCategory').ready(function(){
  // 	console.log('hola');  	// $(this).change(function () {
  	// 	$('#FourthCategory').remove();
	  //   var id = "";
	  //   $("#ThirdCategory option:selected").each(function() {
	  //     id += $( this ).attr('id') + " ";
	  //   });
	  //   	$.ajax({
  	// 	url:'/dev_integrapp/profile/product/'+id,
  	// 	type:'POST',
  	// 	dataType:'json',
  	// 	data:{parent:id},
  	// 	success:function(data){
  	// 		$('#result').append("<select id='FourthCategory'></select>");
  	//      	for(var i in data){
	  //    		var obj=data[i];
	  //    		for(var j in obj){
	  //    			var id=obj[j].id;
	  //    			var name=obj[j].name;
	  //    			$('#FourthCategory').append("<option id='"+id+"'>"+id+" - "+name+"</option>");
	  //    		}
	     		
	  //    	}
  	// 	}
  	// });
	  // })
 
  //});


});