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



	public function routedHome($section, $data = null){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($this->session->userdata("role").'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}




	public function account(){

		$userid = $this->session->userdata("id");

		$role = $this->session->userdata("role");

		$data['user'] = $this->User_model->get_user($userid);

		if($role == "supplier"){

			$data['supplier'] = $this->Supplier_model->get_supplier($userid);

		}else if($role == "distributor"){

			$data['distributor'] = $this->Distributor_model->get_distributor($userid);

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

	public function save(){

  		$id = $this->session->userdata("id");
   		$role = $this->session->userdata("role");

	   	$this->form_validation->set_message('required', 'El campo %s es necesario');
	   	$this->form_validation->set_message('valid_email', 'El campo %s debe ser una dirección de email válida');

   		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
   		$this->form_validation->set_rules('lastname', 'Apellido', 'trim|required');

		if(($role == "distributor") or ($role == "supplier")){


	   		$this->form_validation->set_rules('comercial_email', 'Email comercial', 'trim|valid_email');

	   		$this->form_validation->set_rules('comercial_address', 'Dirección comercial', 'trim');

	   		$this->form_validation->set_rules('razon_social', 'Razon social', 'trim');

	   		$this->form_validation->set_rules('fiscal_address', 'Direccion fiscal', 'trim');

	   		$this->form_validation->set_rules('service_description', 'Descricion del servicio', 'trim');

	   		$this->form_validation->set_rules('cuit', 'cuit', 'trim');

	   		//$this->form_validation->set_rules('phone', 'Teléfono', 'trim');

	   		$this->form_validation->set_rules('city', 'Ciudad', 'trim');

   		}


   		if ($this->form_validation->run() == FALSE){

			// $this->load->view('templates/template_header');
			// $this->load->view('templates/template_nav');
			// $this->load->view('navs/nav_'.$this->session->userdata("role"));
			// $this->load->view($this->session->userdata("role").'/account');
			// $this->load->view('templates/template_footer');
			$this->routedHome('account');

		} else {

			$userdata = array();

	   		$data['name'] = $this->input->post("name");

	   		$data['lastname'] = $this->input->post("lastname");

	   		$resultado = $this->User_model->save($id, $data);

	   		if ($resultado){

		   		$data = array();

				if($role == "supplier"){

			   		$data['fake_name'] = $this->input->post("fake_name");

			   		$data['razon_social'] = $this->input->post("razon_social");

			   		$data['cuit'] = $this->input->post("cuit");

			   		$data['service_description'] = $this->input->post("service_description");

			   		$data['commercial_address'] = $this->input->post("comercial_address");

			   		$data['fiscal_address'] = $this->input->post("fiscal_address");

			   		$data['cbu'] = $this->input->post("cbu");

			   		$data['checks'] = $this->input->post("checks");

			   		$data['bank_account'] = $this->input->post("bank_account");

			   		//$data['phone'] = $this->input->post("phone");

			   		$data['comercial_email'] = $this->input->post("comercial_email");

			   		$data['bank_name'] = $this->input->post("bank_name");

			   		$data['bank_branch'] = $this->input->post("bank_branch");

			   		$data['bank_account_number'] = $this->input->post("bank_account_number");

			   		$data['bank_account_name'] = $this->input->post("bank_account_name");

		   			$resultado = $this->Supplier_model->save($id, $data);



		   		}else if($role == "distributor"){

			   		$data['commercial_address'] = $this->input->post("commercial_address");

			   		//$data['phone'] = $this->input->post("phone");

			   		$data['comercial_email'] = $this->input->post("comercial_email");

			   		$data['razon_social'] = $this->input->post("razon_social");

			   		$data['fake_name'] = $this->input->post("fake_name");

			   		$data['fiscal_address'] = $this->input->post("fiscal_address");

			   		$data['service_description'] = $this->input->post("service_description");

			   		$data['cuit'] = $this->input->post("cuit");

			   		$data['latLocation'] = $this->input->post("latLocation");

			   		$data['longLocation'] = $this->input->post("longLocation");

		   			$resultado = $this->Distributor_model->save($id, $data);

				}


	   		}

	  		$data = '';

	   		$data['success'] = "Sus datos de perfil se guardaron correctamente.";

	   		$this->routedHome('account');

			// $this->load->view('templates/template_header');
			// $this->load->view('templates/template_nav');
			// $this->load->view('navs/nav_'.$this->session->userdata("role"));
			// $this->load->view($this->session->userdata("role").'/account');
			// $this->load->view('templates/template_footer');

	   		//redirect('profile/account',$data);

			//$this->routedHome2('account');

			//$data['user'] = $this->session->userdata("user");

			//$this->routedHome($this->section, $data);
		}

 
	}



}


?>