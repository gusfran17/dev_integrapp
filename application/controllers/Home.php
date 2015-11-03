<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		if($this->session->userdata("role")){ 
			redirect('profile');
		} else { 
			$this->homepage();
		}
	}


	public function routedHome($data=null, $section, $template=false){
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_home', $data);
		$this->load->view('home/'.$section,$data);
		$this->load->view('templates/template_footer', $data);
	}

	public function homepage(){
			$data['Catalog'] = $this->Product_model->getPacientCatalog();
			$this->routedHome($data, 'home');
	}

}


?>