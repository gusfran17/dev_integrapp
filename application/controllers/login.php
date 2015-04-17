<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	function __construct() {
		parent::__construct();
   	}


   	public function authenticate(){
		$this->form_validation->set_rules('username', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_passwordAuthenticate');
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('passwordAuthenticate', 'El Password o Usuario es incorrecto');
		
		if ($this->form_validation->run()){
			redirect('home');
		}else{
			$this->load->view('templates/template_header');
			$this->load->view('templates/template_nav');
			$this->load->view('navs/nav_home');
			$this->load->view('home/login');
			$this->load->view('templates/template_footer');
		}


}



	public function passwordAuthenticate(){
		$data = $this->input->post("username");
		$password = $this->input->post("password");
		return $this->User_model->passwordAuthenticate($password, $data);
	}

	public function logout(){
		$this->session->unset_userdata('role');
		redirect('home');
	}

 }
