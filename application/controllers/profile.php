<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index(){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($this->session->userdata("role").'/home');
		$this->load->view('templates/template_footer');
	}



	public function routedHome($section){
		$data["userdata"]=$this->session->userdata("role");
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"), $data);
		$this->load->view($this->session->userdata("role").'/'.$section);
		$this->load->view('templates/template_footer');
	}


}


?>