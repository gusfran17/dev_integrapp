/*
 * Name: GeoLocalizr.js: Funciones utiles para dibujar un mapa de googlemaps con diferentes puntos
 * 					teniendo un json como input, como asi tambien la posibilidad de la geolocalizacion HTML5
 *					del usuario, centrando en el mapa la ubicacion del usuario.
 * Author: Lucas Paiva - (AR)		
 * License: MIT
 * Support: contacto.lucas.paiva@gmail.com
 *
 */	

var path_app = 'dev_integrapp/Resources/imgs/';
var path_images = 'http://' + window.location.host + '/' + path_app;

//Metodo que inicializa el mapa 
function initializeNewMap(locations,zoom){

	var map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: zoom,
      center: new google.maps.LatLng(locations[0]["lat"], locations[0]["lng"]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;	

    //Recorro locations
    for (i = 0; i < locations.length; i++) {  
    	
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i]["lat"], locations[i]["lng"]),
			map: map,
			icon: locations[i]["icon-point"]
		});

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
		return function() {
			var imgTag = '<div class="img" style="text-align: center; padding-top:5px; padding-bottom:5px; background-color: ' + locations[i]["bg-color"] +';"><img style=" max-height:50px; max-width:140px;" src="' + locations[i]["img"]  + '"></img></div>';
			var titleTag = '<div class="title" style="text-align: center;"><h3>' + locations[i]["title"] + '</h3></div>';
			var descriptionTag = '<div class="description" style="text-align: center;">' + 
								 '<p>' + locations[i]["description"] + '</p>' +
								 '</div>';
			var phoneTag = (((locations[i]["phone"] != "") && (locations[i]["phone"] != null)) ? '<div class="phone" style="text-align: center;"><strong>Tel: </strong>' + locations[i]["phone"] + '</div>' : "Telefono no disponible <br>");
			var emailTag = (((locations[i]["email"] != "") && (locations[i]["email"] != null)) ? '<div class="email" style="text-align: center;"><strong>Email: </strong>' + locations[i]["email"] + '</div>' : "Email no disponible <br>");
			var addressTag = (((locations[i]["address"] != "") && (locations[i]["address"] != null)) ? '<div class="address" style="text-align: center;"><strong>Direeción: </strong>' + locations[i]["address"] + '</div>' : "Dirección no disponible <br>");


			var contentString = '<div id="containerInfoMap" style="width: 300px; height: 250px;">' +
				imgTag +
				titleTag +
				descriptionTag +
				phoneTag +
				emailTag +
				addressTag
				'</div>';			            	

			infowindow.setContent(contentString);
			infowindow.open(map, marker);
		}
		})(marker, i));

    }
  
}

//Metodo que valida geolocalizacion y obtiene coordenadas del usuario
function getGeolocalization(callback){

	if(navigator.geolocation){

		navigator.geolocation.getCurrentPosition(function(objPosition){

			var latInit = objPosition.coords.latitude;
			var lngInit = objPosition.coords.longitude;
			//Obtengo mis datos de perfil
			$.ajax({
		  		url: '../../Profile/getMyDetailsForMap',
		  		success:function(data){
		  			if (data != null){
		  				var json = JSON.parse(data);
		  				console.log(json);
		  				locations[0]["title"] = json["title"];
						locations[0]["description"] = "Esta es su ubicación actual según el navegador";
						locations[0]["address"] = json["address"] + " (ubicación que usted declaró en su perfil)";
						locations[0]["email"] = json["email"];
						locations[0]["phone"] = json["phone"];
						locations[0]["img"] = json["img"];
						locations[0]["link"] = json["link"];
						locations[0]["bg-color"] = json["bg-color"];
						locations[0]["icon-point"] = json["icon-point"];
						console.log(locations);
		  			}
		  		}
		  	});
			//Inserto coordenadas del usuario al array de locations en primer lugar
			locations.splice(0, 0,
				    {
						"lat" 			: latInit,
						"lng"			: lngInit,
						"title"			: "Mi Ubicación",
						"description"	: "Puede ver que distribuidores se encuentran en las zonas más cercanas a sus alrededores.",
						"email"			: "",
						"phone"			: "",
						"img"			: path_images + "noProfilePic.png",
						"link"			: "#",
						"bg-color"		: "#0F0",
						"icon-point"	: path_images + "my_location_96x96.png"
					});

			return callback();

		},function(objError){

			switch(objError.code){
				case objError.POSITION_UNAVAILABLE:
					console.log("La información de su posición no está disponible.");
				break;
				case objError.TIMEOUT:
					console.log("Tiempo de espera agotado.");
				break;
				case objError.PERMISSION_DENIED:
				    console.log("Acceso denegado.")
				    return callback();
				break;
				case objError.UNKNOWN_ERROR:
					console.log("Error desconocido.");
					return callback();
				break;
			}
		});

	}else{
		//el navegador del usuario no soporta el API de Geolocalizacion de HTML5
		console.log("Su navegador no soporta Geolocalizacion");
		return callback();
	}

}

//Metodo que bindea el mapa
function bindGoogleMaps(points,zoom){
	google.maps.event.addDomListener(window, 'load', initializeNewMap(points,zoom));
}