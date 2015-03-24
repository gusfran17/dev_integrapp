<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class startApp extends CI_Controller {

	public function index(){
		$this->load->view('templates/template_header');
		if($this->session->userdata("role")){ 
			$this->showLoginHome();
		} else { 
			$this->showUserHome();
		}
		$this->load->view('templates/template_footer');
	}


	private function showUserHome(){
		$this->load->view('templates/template_nav');
		$this->load->view('templates/template_home');
	}

	public function routedHome($data){
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('user/'.$data.'');
		$this->load->view('templates/template_footer');
	}

}


?>