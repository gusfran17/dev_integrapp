<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
	}
	
	public function suppliersView(){
		$role = $this->session->userdata("role");
		$config = array();
		$config["base_url"] = base_url() . "Suppliers/suppliersView";
		$total_row = $this->Supplier_model->suppliersCount();
		$config["total_rows"] = $total_row;
		$config["per_page"] = 9;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 2;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['cur_tag_open'] = $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<div class="col-md-1 col-sm-1 col-xs-1">';
        $config['cur_tag_close'] = $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3)) ;
		}else{
			$page = 1;
		}
		$data["suppliers"] = $this->Supplier_model->getSuppliers($page, $config["per_page"]);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );

		// View data according to array.
		$this->routedHome($role, $data);
	}
	
	public function routedHome($role = null, $data = null){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($role.'/suppliers', $data);
		$this->load->view('templates/template_footer');
	} 


}


?>