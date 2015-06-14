<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	
	public function get_categories($id=NULL){
				
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


	public function get_tree($id=NULL){
			$data['tree'] = $this->Product_model->get_tree($id);
			echo json_encode($data) ;
	}


	public function save_product(){
			$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required');
	   		$this->form_validation->set_rules('productCode', 'Codigo', 'required');
	   		$this->form_validation->set_rules('productVAT', 'IVA', 'trim');
	   		$this->form_validation->set_rules('productDesc', 'Descripcion', 'required|min_length[30]|max_length[400]');




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

				$product_added = $this->Product_model->get_added_product($new_id);
				echo json_encode($product_added);
				

	   		}else{

	   			/*
	   			$section=$this->uri->segment(2);
	   			$role=$this->session->userdata("role");
	   			$this->session->set_flashdata('error', "active in");
	   			$data['error'] = $this->session->flashdata('error');

				$this->load->view('templates/template_header');
				$this->load->view('templates/template_nav');
				$this->load->view('navs/nav_'.$role);
				$this->load->view('supplier/product', $data);
				$this->load->view('templates/template_footer');*/
				echo "no corre";
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



}


?>