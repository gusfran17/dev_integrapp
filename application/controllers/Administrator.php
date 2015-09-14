<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	private function routedHome($section, $data = null, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"]=$this->session->userdata("user");
			$data["loadInfo"]=$this->session->userdata("loadInfo");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}

    public function credit(){
    	$data['pendingTransfers'] = $this->Credit_model->getPendingTransfers();
    	$this->routedHome("credit/transfers", $data);
    }

    public function setApproveTransfer($transferId){
    	$data['transferId'] = $transferId;
    	$this->routedHome("credit/approve_transfer", $data);	
    }

    public function approveTransfer(){
    	if($this->session->has_userdata('role')){
			$userid = $this->session->userdata("id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$this->form_validation->set_rules('transferId', 'Transferencia', 'required');
		$this->form_validation->set_rules('adminNote', 'Nota de Aprobación', 'required');
		$this->form_validation->set_message('required', 'El campo %s es necesario');

		if ($this->form_validation->run() == TRUE){
			$transferId = $this->input->post("transferId");
			$adminNote = $this->input->post("adminNote");
			$this->Credit_model->approveTransfer($transferId, $adminNote, $userid);	
			$this->session->set_flashdata("success","La transferencia fue aprobada, el usuario podra utilizar su crédito ahora");
			redirect("/administrator/credit");
		} else {
			$this->session->set_flashdata("error","Hay errores, por favor verifique");
			$this->setApproveTransfer($this->input->post("transferId"));
		}
		
    }

    public function viewTransferDetails($transferId, $userId){
    	$data['transactions'] = $this->Credit_model->getTransactionsByUserId($userId);
    	$data['transfer'] = $this->Credit_model->getTransferById($transferId, $userId);
    	$user = $this->User_model->get_user($userId);
    	$data['transfer']->issuer = $user;
    	$this->routedHome("credit/transfer_details", $data);
    }
}

?>