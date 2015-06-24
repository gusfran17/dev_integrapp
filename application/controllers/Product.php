<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	
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
			$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required');
	   		$this->form_validation->set_rules('productCode', 'Codigo', 'required');
	   		$this->form_validation->set_rules('productVAT', 'IVA', 'trim');
	   		$this->form_validation->set_rules('productDesc', 'Descripcion', 'required|min_length[30]|max_length[400]');

		/*	$this->form_validation->set_rules('atribute', 'Atributo', 'required');
	   		$this->form_validation->set_rules('value', 'Valor', 'required'); */



	   		if ($this->form_validation->run()) {



	   			$insert = array();
				$insert['name'] = $this->input->post("productName");
				$insert['description'] = $this->input->post("productDesc");
				$insert['code'] = $this->input->post("productCode");
				$insert['supplier_id'] = $this->session->userdata("role_id");
				$insert['category_id'] = $this->input->post("categoryID");
				$insert['tax'] = $this->input->post("productVAT");
				$insert['published_date'] = date("Y-m-d H:i:s");
				$insert['short_desc'] = $this->input->post("categoryTree"); 

				$new_id= $this->Product_model->get_new_id();
				
				$insert['integrapp_code'] = "PR".$new_id."C".$this->input->post("categoryID");

				$insert['id']= $new_id;

				$id = $this->Product_model->save_product($insert);

				$product_added = $this->Product_model->get_added_product($id);

				if ($product_added!=FALSE) {
				
					for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

						$attribute = $this->input->post('attribute'.$i);
						$value = $this->input->post('value'.$i);
						
						if ($attribute !=NULL && $value!=NULL) {
							$this->Product_model->save_product_attribute($new_id, $attribute, $value);
						}
					}
				}
				//echo json_encode($product_added);

				//copy images permanently
				if($this->input->post('imagen')){
					echo "Hay imagenes";
					foreach($this->input->post('imagen') as $img){
						@mkdir("." . PRODUCT_IMAGES_PATH . $new_id);
						@mkdir("." . PRODUCT_IMAGES_PATH . $new_id . "/thumbs");
						@copy("." . PRODUCT_IMAGES_PATH . "temp/" . $img, "." . PRODUCT_IMAGES_PATH . $new_id . "/" . $img);
						@copy("." . PRODUCT_IMAGES_PATH . "temp/thumbs/". $img, "." . PRODUCT_IMAGES_PATH . $new_id . "/thumbs/" . $img);
					}
				}

	   		}else{

				$data = array(
					'categoryTree' => form_error('categoryTree'),
                    'productName' => form_error('productName'), 
                    'productCode' => form_error('productCode'),
                    'productDesc' => form_error('productDesc')
           			 );
				echo json_encode($data);
	   		}
	}


	public function productcheck(){
		//$name = $this->input->post("productName");
		//return $this->Product_model->product_check($name);
		return TRUE;
	}

	public function codecheck(){
		//$code = $this->input->post("productCode");
		//return $this->Product_model->code_check($code);
		return TRUE;
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


}


?>