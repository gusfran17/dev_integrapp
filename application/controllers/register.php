<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	
	function __construct() {
		parent::__construct();
   	}



	public function register(){
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'required|callback_usernamecheck');
		$this->form_validation->set_rules('name', 'Nombre', 'required|alpha');
		$this->form_validation->set_rules('lastname', 'Apellido', 'required|alpha');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailcheck');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
		$this->form_validation->set_rules('repassword', 'Repetir contraseña', 'required|matches[password]');
		$this->form_validation->set_rules('terms', 'Términos y condiciones', 'required');

		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('valid_email', 'Esto no parece ser un email');
		$this->form_validation->set_message('matches', 'Los campos de contraseña deben ser iguales');
		$this->form_validation->set_message('usernamecheck', 'Ops, el nombre de usuario ya esta en uso');
		$this->form_validation->set_message('emailcheck', 'Ops, el mail ya esta en uso');

		if ($this->form_validation->run()){
			$insert = array();
			$role = $this->input->post("role");
			$insert['email'] = $this->input->post("email");
			$insert['username'] = $this->input->post("username");
			$insert['password'] = $this->encrypt->encode($this->input->post("password"), $this->config->item('encryption_key'));
			$insert['name'] = $this->input->post("name");
			$insert['role'] = $role;
			$insert['lastname'] = $this->input->post("lastname");
			$insert['newsletter'] = $this->input->post("newsletter");
			if ($role == 'user') {
				$insert['status'] = 'active';
			} else {
				$insert['status'] = 'pending';
			}
			$insert['register_date'] = date("Y-m-d H:i:s");
			$id = $this->user_model->register_user($insert);
			redirect('home/routedHome/login');
		}else{
			$this->load->view('templates/template_header');
			$this->load->view('templates/template_nav');
			$this->load->view('navs/nav_home');
			$this->load->view('home/register');
			$this->load->view('templates/template_footer');
		}
	}

	
	public function usernamecheck(){
		$username = $this->input->post("username");
		return $this->user_model->username_not_exist($username);
	}



	public function emailcheck(){
		$email = $this->input->post("email");
		return 	$this->user_model->email_not_exist($email); 
	}


 }