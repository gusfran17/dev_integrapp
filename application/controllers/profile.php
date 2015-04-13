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



	public function routedHome($section){
		$data["userdata"]=$this->session->userdata("user");
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($this->session->userdata("role").'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}


	public function account(){
		$this->routedHome($this->section);
	}

	public function product(){
		$this->routedHome($this->section);
	}

	public function request(){
		$this->routedHome($this->section);
	}

	public function auction(){
		$this->routedHome($this->section);
	}

	public function credit(){
		$this->routedHome($this->section);
	}

	public function suppliers(){
		$this->routedHome($this->section);
	}



}


?>