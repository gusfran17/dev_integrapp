<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	
	public function get_categories($id=NULL){
		$role = $this->session->userdata("role");
		
		if (isset($id)) {
			$data['SecondCategory'] = $this->Product_model->get_category($id);
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

}


?>