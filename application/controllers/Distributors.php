<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributors extends CI_Controller {

	public function routedHome($data = null, $section, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"]=$this->session->userdata("user");
		} else {
			redirect(TIMEOUT_REDIRECT);
			die;
		}
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	} 


	public function viewDistributors(){
		$roleId = $this->session->userdata("role_id");
		$pendingDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'pending');
		$data['pendingDistributors'] = $pendingDistributors;
		log_message('info', "Cantidad de asociaciones pending: " . count($pendingDistributors), false);
		$rejectedDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'rejected');
		$data['rejectedDistributors'] = $rejectedDistributors;
		$approvedDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'approved');
		$data['approvedDistributors'] = $approvedDistributors;
		$section = 'distributors';
		$this->routedHome($data, $section);
	}

	public function setSupplierDistributorStatus($distributorId, $status){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			if ($role == 'supplier'){
				$roleId = $this->session->userdata("role_id");
				$this->Distributor_model->setSupplierDistributorStatus($roleId, $distributorId, $status);
			}
		}
		$this->viewDistributors();
	}

}

?>