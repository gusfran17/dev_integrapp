
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	function __construct() {
		parent::__construct();
   	}

   	public function index(){
   		$this->routedHome('login/login');
   	}

   	public function routedHome($section, $data=null){
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_home', $data);
		$this->load->view('home/'.$section, $data);
		$this->load->view('templates/template_footer', $data);
	}

   	public function authenticate(){
		$this->form_validation->set_rules('username', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_passwordAuthenticate');
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('passwordAuthenticate', 'El Password o Usuario es incorrecto');
		
		if ($this->form_validation->run()){
			redirect('home');
		}else{
			redirect('login');
		}


	}

	public function passwordAuthenticate(){
		$data = $this->input->post("username");
		$password = $this->input->post("password");
		return $this->User_model->passwordAuthenticate($password, $data);
	}

	public function forgotPassword(){
		$this->routedHome('login/forgot_password');
	}

	public function sendRenewPasswordEmail(){
		$usernameOrEmail = $this->input->post("usernameOrEmail");
		$this->form_validation->set_rules('usernameOrEmail', 'Usuario', 'required|callback_checkAccountExists');
		$this->form_validation->set_message('checkAccountExists', 'El Usuario no existe en IntegrApp, verifique que sea el correcto.');
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		if ($this->form_validation->run()){
			$email = $this->session->flashdata("userEmailRenew");
			$userid = $this->session->flashdata("useridRenew");
			if ($this->User_model->sendRenewPasswordEmail($userid, $email)){
				$email = 'xxxxx'.strstr($email, '@');
				$this->session->set_flashdata("success","Se ha enviado un email a $email para renovar su contraseña");
			} else {
				$this->session->set_flashdata("error","No se há podido realizar la transacción con éxito, por favor, intente más tarde. Si el problema persiste comuniquese con el administrador");
			}
			redirect('login');
		}else{
			$this->forgotPassword();
		}
	}

	public function checkAccountExists(){
		$usernameOrEmail = $this->input->post("usernameOrEmail");
		$user = $this->User_model->checkAccountExists($usernameOrEmail);
		if (isset($user)) {
			$this->session->set_flashdata("userEmailRenew",$user->email);
			$this->session->set_flashdata("useridRenew",$user->id);
			return true;
		} else {
			return false;
		}
	}

	public function inputNewPassword($userid,$token){
		if ($this->User_model->verifyEmailToken($userid,$token)){
			$this->User_model->updateEmailToken($userid);
			$emailToken = $this->User_model->getEmailToken($userid);
			$data['emailToken'] = $emailToken->token;
			$data['userid'] = $userid;
			$this->routedHome('login/renew_password', $data);
		} else {
			$this->session->set_flashdata("error","Hubo un error al ingresar el link de renovación de contraseña, o puede que el mismo ya haya expirado, por favor, intente de nuevo. Si el problema persiste contacte al administrador.");
			$this->routedHome('login/forgot_password');
		}
	}

	public function renewPassword(){
		$emailToken = $this->input->post("emailToken");
		$userid = $this->input->post("userid");
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
		$this->form_validation->set_rules('repassword', 'Repetir contraseña', 'required|matches[password]');
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('valid_email', 'Esto no parece ser un email');
		$this->form_validation->set_message('matches', 'Los campos de contraseña deben ser iguales');
		if ($this->form_validation->run()){
			if ($this->User_model->verifyEmailToken($userid,$emailToken)){
				$password = $this->input->post("password");
				$this->User_model->updateEmailToken($userid);
				$this->User_model->password_change($userid,$password);
				$this->session->set_flashdata("success","Su contraseña há sido renovada exitosamente!");
				redirect('login');
			} else {
				$this->session->set_flashdata("error","Hubo un error inesperado en la renovación de contraseña, por favor, intente de nuevo. Si el problema persiste contacte al administrador.");
				$this->routedHome('login/forgot_password');
			}
		}else{
			$data['userid'] = $userid;
			$data['emailToken'] = $emailToken;
			$this->routedHome('login/renew_password', $data);
		}
		// Verify token, update password, modify token redirect to login
	}

	public function sendEmailConfirmation($userid){
		if ($this->User_model->sendVerificationEmail($userid)){
			$this->session->set_flashdata("success","Se há enviado un mail de confirmación de cuenta a su correo de mail.");
		} else {
			$this->session->set_flashdata("success","Há habido un problema al intentar enviar el correo de confirmación, por favor, intente mas tarde o contactese con el administrador con este mensaje de texto.");
		}
		redirect('login');
	}

	public function logout(){
		$this->session->unset_userdata('role');
		redirect('home');
	}


 }
