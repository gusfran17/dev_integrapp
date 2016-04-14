<?php 

$texts = array('user' => "<h3>USUARIO</h3><p> normal Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, </p><p>vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. </p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad.</p>",
               'distributor' => "<h3>ORTOPEDISTA</h3><p> normal Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, </p><p>vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. </p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad.</p>",
               'supplier' => "<h3>MAYORISTA</h3><p> normal Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, </p><p>vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. </p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad.</p>"
			 );


$getText= $_POST['option'];

if ($getText=='noselect') {
	echo "<p>Seleccione un rol para saber mas sobre las caracteristicas particulares del mismo</p>";
}else{
	echo $texts[$getText];
}



 ?>