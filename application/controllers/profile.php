<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	

	  function __construct() {
	  	
        parent::__construct();
        $this->section=$this->uri->segment(2);

    }
	
	
   
	public function index(){
		$data["userdata"]=$this->session->userdata("user");
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($this->session->userdata("role").'/home', $data);
		$this->load->view('templates/template_footer');
	}



	public function routedHome($section, $data){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($this->session->userdata("role").'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}


	public function account(){

		$userid = $this->session->userdata("id");

		$role = $this->session->userdata("role");

		$data['user'] = $this->user_model->get_user($userid);

		if($role == "supplier"){

			$data['supplier'] = $this->supplier_model->get_supplier($userid);

		}else if($role == "distributor"){

			$data['distributor'] = $this->distributor_model->get_distributor($userid);

		}


		// if(!$this->fabricante_model->is_verified($data['user']->id)){

		// 	$data["mensaje_verificacion"] = "Su usuario no ha sido verificado por administrador todavia, para facilitar el proceso complete todos los datos a continuacion. Una vez verificado podra acceder a todas las funciones. Si el proceso de verificacion demora mas de 48hs <strong><a href='/contacto'>Contacte con un administrador</a></strong>";

		// }
		$this->routedHome($this->section, $data);

	}

	public function product(){
		$data['user'] = $this->session->userdata("user");
		$this->routedHome($this->section, $data);
	}

	public function request(){
		$data['user'] = $this->session->userdata("user");
		$this->routedHome($this->section, $data);
	}

	public function auction(){
		$data['user'] = $this->session->userdata("user");
		$this->routedHome($this->section, $data);
	}

	public function credit(){
		$data['user'] = $this->session->userdata("user");
		$this->routedHome($this->section, $data);
	}

	public function suppliers(){
		$data['user'] = $this->session->userdata("user");
		$this->routedHome($this->section, $data);
	}



}


?>