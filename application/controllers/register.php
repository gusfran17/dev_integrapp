<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
   	}



	public function register(){
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'required|callback_usernamecheck');
		$this->form_validation->set_rules('name', 'Nombre', 'required|alpha');
		$this->form_validation->set_rules('lastname', 'Apellido', 'required|alpha');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailcheck');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
		$this->form_validation->set_rules('repassword', 'Repetir contraseña', 'required|matches[password]');
		$this->form_validation->set_rules('terms', 'Términos y condiciones', 'required');
		if ($this->form_validation->run()){
			$insert = array();
			$insert['email'] = $this->input->post("email");
			$insert['username'] = $this->input->post("username");
			$insert['password'] = $this->encrypt->encode($this->input->post("password"), $this->config->item('encryption_key'));
			$insert['name'] = $this->input->post("name");
			$insert['lastname'] = $this->input->post("lastname");
			//$insert['newsletter'] = "testregistronewsletter";//$this->input->post("newsletter");
			$insert['register_date'] = date("Y-m-d H:i:s");
			$id = $this->register_model->register_user($insert);
			redirect('startApp/routedHome/login');
		}else{
			$this->load->view('templates/template_header');
			$this->load->view('templates/template_nav');
			$this->load->view('user/register');
			$this->load->view('templates/template_footer');
		}
	}

	
	public function usernamecheck(){
		$username = $this->input->post("username");
		return $this->register_model->username_check($username);
	}



	public function emailcheck(){
		$email = $this->input->post("email");
		return 	$this->register_model->email_check($email); 
	}


 }