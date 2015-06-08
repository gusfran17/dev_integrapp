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

	public function save(){

			$this->form_validation->set_rules('productName', 'Nombre del Producto', 'trim|required|callback_productcheck');
	   		$this->form_validation->set_rules('productCode', 'Codigo', 'alpa_dash|required|callback_codecheck');
	   		$this->form_validation->set_rules('productVAT', 'IVA', 'trim');
	   		$this->form_validation->set_rules('productDesc', 'Descripcion', 'required|min_length[30]|max_length[400]');

	   		if ($this->form_validation->run()) {
	   			
	   		}else{

	   			$section=$this->uri->segment(2);
	   			$role=$this->session->userdata("role");

				$this->load->view('templates/template_header');
				$this->load->view('templates/template_nav');
				$this->load->view('navs/nav_'.$role);
				$this->load->view('supplier/product');
				$this->load->view('templates/template_footer');
	   		}
	}


	public function productcheck(){
		$name = $this->input->post("productName");
		return $this->Product_model->product_check($name);
	}

	public function codecheck(){
		$code = $this->input->post("productCode");
		return $this->Product_model->code_check($code);
	}



}


?>