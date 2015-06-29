<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	
	public function product_view($id=NULL, $data=NULL){
		$role = $this->session->userdata("role");
		$role_id = $this->session->userdata('role_id');
		$data['catalog'] = $this->Product_model->get_catalog($role_id);

		if (isset($id)) {
			$data['NextCategory'] = $this->Product_model->get_category($id);
			//echo json_encode($data);
			//die();
		}else{
			$data['category'] = $this->Product_model->get_category();
		}
		$this->routedHome('product',$role, $data);
	}

	public function routedHome($section, $role = null, $data = null){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}

	public function get_categories($id=NULL){
				
		if (isset($id)) {
			$data['NextCategory'] = $this->Product_model->get_category($id);
			echo json_encode($data);
			die();
		}else{
			$data['category'] = $this->Product_model->get_category();
		}

	}


	public function getProperties($id=NULL){

			if (isset($id)) {
				$data['property'] = $this->Product_model->get_property($id);
				echo json_encode($data);
			
			}
	}


	public function get_tree($id=NULL){
			$data['tree'] = $this->Product_model->get_tree($id);
			echo json_encode($data) ;
	}


	public function save_product(){
			$editID = $this->input->post("productID");
			$editProduct = $editID != "";
			if (!$editProduct){ 
				$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required');
		   		$this->form_validation->set_rules('productCode', 'Codigo', 'required|callback_productCodeCheck');	
			} else {
				$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required');
	   			$this->form_validation->set_rules('productCode', 'Codigo', 'required');

			}
			$this->form_validation->set_rules('categoryTree', 'Categoria de producto', 'required');
	   		$this->form_validation->set_rules('productVAT', 'IVA', 'trim');
	   		$this->form_validation->set_rules('productDesc', 'Descripcion', 'required|min_length[' . PROD_DESCRIPTION_MIN_LENGTH . ']|max_length[' . PROD_DESCRIPTION_MAX_LENGTH . ']');
	   		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
	   		$this->form_validation->set_message('min_length', 'La descripcion debe tener al menos ' . PROD_DESCRIPTION_MIN_LENGTH . ' caracteres');
	   		$this->form_validation->set_message('max_length', 'La descripcion debe tener a lo sumo ' . PROD_DESCRIPTION_MAX_LENGTH . ' caracteres');
	   		$this->form_validation->set_message('productNameCheck', 'Usted ya tiene un producto con este nombre en su catalogo');
	   		$this->form_validation->set_message('productCodeCheck', 'Usted ya tiene un producto con este código en su catalogo');

			/*$this->form_validation->set_rules('atribute', 'Atributo', 'required');
	   		$this->form_validation->set_rules('value', 'Valor', 'required'); */

	   		$cancel =  $this->input->post('submitLoad');
	   		if ($cancel=="Cancelar"){
	   			//Goes back to the form (now empty values)
   				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
				$lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
				$data['lastLoadedProductsGrid'] = $lastloadedProducts;
				$data['productCancelled'] = "Cancelled";
				$this->product_view(null,$data);
	   		} else {
	   			if ($this->form_validation->run()) {

		   			$insert = array();
		   			$insert['name'] = $this->input->post("productName");
					$insert['description'] = $this->input->post("productDesc");
					$insert['code'] = $this->input->post("productCode");
					$insert['category_id'] = $this->input->post("categoryID");
					$insert['tax'] = $this->input->post("productVAT");
					$insert['short_desc'] = $this->input->post("categoryTree"); 
					if (!$editProduct){
						$new_id = $this->Product_model->get_new_id();
						$insert['id']= $new_id;
						$insert['published_date'] = date("Y-m-d H:i:s");
						$integrappCode = "PR".$new_id."C".$this->input->post("categoryID");
						$insert['supplier_id'] = $this->session->userdata("role_id");
						$insert['integrapp_code'] = $integrappCode;
						$id = $this->Product_model->saveProduct($insert);
					} else {
						$new_id = $editID;
						$insert['last_update'] = date("Y-m-d H:i:s");
						$id = $this->Product_model->updateProduct($insert, $new_id);

					}

					$product_added = $this->Product_model->get_added_product($new_id);

					if ($product_added!=FALSE) {
					
						for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

							$attribute = $this->input->post('attribute'.$i);
							$value = $this->input->post('value'.$i);
							
							if ($attribute !=NULL && $value!=NULL) {
								$this->Product_model->save_product_attribute($new_id, $attribute, $value);
							}
						}
					}


					if($this->input->post('imagen')){
						//if it is edition, moves existing images to temp in order to upload them again
						if ($editProduct){
							@copy( "." . PRODUCT_IMAGES_PATH . $new_id . "/" . $img, "." . PRODUCT_IMAGES_PATH . "temp/" . $img);
							@copy("." . PRODUCT_IMAGES_PATH . $new_id . "/thumbs/" . $img, "." . PRODUCT_IMAGES_PATH . "temp/thumbs/". $img);
							$this->delTree("." . PRODUCT_IMAGES_PATH . $new_id);

						}
						foreach($this->input->post('imagen') as $img){
							@mkdir("." . PRODUCT_IMAGES_PATH . $new_id);
							@mkdir("." . PRODUCT_IMAGES_PATH . $new_id . "/thumbs");
							@copy("." . PRODUCT_IMAGES_PATH . "temp/" . $img, "." . PRODUCT_IMAGES_PATH . $new_id . "/" . $img);
							@copy("." . PRODUCT_IMAGES_PATH . "temp/thumbs/". $img, "." . PRODUCT_IMAGES_PATH . $new_id . "/thumbs/" . $img);
						}
					} else {//If during edition all images are erased and the product is saved with no images.
						if ($editProduct){ 
							$this->delTree("." . PRODUCT_IMAGES_PATH . $new_id);
						}
					}
					
					//Goes back to the form 
	   				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
	   				if (!$editProduct){
	   					$recent_products[] = $integrappCode; //if it is a new saved product it gets loaded in the last loaded products grid
	   				}
					$lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
					$data['lastLoadedProductsGrid'] = $lastloadedProducts;
					//$data['productLoaded'] = "Loaded";
					$this->product_view(null,$data);
		   		}else{
					for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

						$attribute_name = $this->input->post('attribute'.$i);
						$attribute_value = $this->input->post('value'.$i);
						if (($attribute_name != null) or ($attribute_name != "")){
							$attribute = new stdClass();
							$attribute->name = $attribute_name;
							$attribute->value = $attribute_value;
							$attributes[] = $attribute;
						}

					}		
					if (isset($attributes)){
						$data['attributes'] = $attributes;
					}   			
		   			$data['imagen'] = $this->input->post('imagen');
					$recent_products = $this->input->post('recentlyAddedIntegrappCode');
					$lastLoadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
					$data['lastLoadedProductsGrid'] = $lastLoadedProducts;
					$this->product_view(null,$data);
		   		}

	   		}
	   		
	}

	public function editProduct(){
		$editionProduct[] = $this->input->post("editionIntegrapCode");
		$product = $this->Product_model->getProductsByIntegrappCode($editionProduct);
		if (count($product)>0){
			$attributes = $this->Product_model->getProductAttributes($product[0]->id);
			$productImages = $this->Product_model->getProductImages($product[0]->id);

			$data['editProduct'] = $product[0];
			$data['editProduct']->images = $productImages;
			$data['editProduct']->attributes = $attributes;
			echo json_encode($data);
			//$this->product_view(null,$data);	
		}
		


		// foreach($productImages as $image){
		// 	echo $image;
		// }
		
		// return true;

	}


	public function productNameCheck(){
		$name = $this->input->post("productName");
		return $this->Product_model->productNameCheck($name);
	}

	public function ProductCodeCheck(){
		$code = $this->input->post("productCode");
		return $this->Product_model->productCodeCheck($code);
	}


	public function upload_foto(){
		$filename = md5(date("Y-m-d h:i:s") . microtime());
		$config['upload_path'] = '.' . PRODUCT_IMAGES_PATH . "temp/";
		$config['allowed_types'] = 'jpg|png|gif';
		$config['max_size']	= '5000';
		$config['max_width']  = '7000';
		$config['max_height']  = '7000';
		$config['file_name'] = $filename;
		$this->load->library('upload', $config);

		$result = new stdClass();

		if ( ! $this->upload->do_upload())
		{
			$result->error = $this->upload->display_errors();
		}else{
			$result->success = $this->upload->data();
			$this->do_resize($result->success['file_name']);
		}
		echo  json_encode($result);
	}


	public function do_resize($filename)
	{
	    $source_path = '.' . PRODUCT_IMAGES_PATH . "temp/" . $filename;
	    $target_path = '.' . PRODUCT_IMAGES_PATH. 'temp/thumbs/';
	    $config_manip = array(
	        'image_library' => 'gd2',
	        'source_image' => $source_path,
	        'new_image' => $target_path,
	        'maintain_ratio' => TRUE,
	        'create_thumb' => TRUE,
	        'thumb_marker' => '',
	        'width' => 100,
	        'height' => 100
	    );

	    $this->image_lib->initialize($config_manip);
	    if (!$this->image_lib->resize()) {
	        echo $this->image_lib->display_errors();
	    }
	    // clear //
	    $this->image_lib->clear();
	}

	public function delTree($dir) { 
		if (file_exists($dir)) {
			$files = array_diff(scandir($dir), array('.','..')); 
			foreach ($files as $file) { 
				if (is_dir("$dir/$file")){
					$this->delTree("$dir/$file");
				} else {
					unlink("$dir/$file"); 	
				}
			} 
			return rmdir($dir); 
		}

	} 




}


?>