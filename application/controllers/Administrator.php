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
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	}

    public function credit(){
    	$data['pendingTransfers'] = $this->Credit_model->getPendingTransfers();
    	$data['tableScripts'] = true;
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
    	$data['showApprovalForm'] = true;
    	$this->routedHome("credit/transfer_details", $data);
    }

    public function viewTransactionHistory($userId){
    	$data['transactions'] = $this->Credit_model->getTransactionsByUserId($userId);
    	$user = $this->User_model->get_user($userId);
    	$this->routedHome("credit/transfer_details", $data);
    }

    public function users(){
    	$data['pendingSuppliers'] = $this->Supplier_model->getPendingSuppliers();
    	$data['suppliers'] = $this->Supplier_model->getApprovedSuppliers();
    	$data['distributors'] = $this->Distributor_model->getApprovedDistributors();
    	$data['tableScripts'] = true;
    	$this->routedHome("users", $data);
    }

    public function approveSupplier($userId){
    	if(!$this->session->has_userdata('role')){
			redirect(TIMEOUT_REDIRECT);
		} else {
			if ($this->Supplier_model->setSupplierStatus($userId, 'active')) {
				$this->session->set_flashdata("success","Se há aprobado al mayorista con éxito");	
			} else {
				$this->session->set_flashdata("error","Se há producido un error que no ha permitido aprobar el usuario. Pruebe más tarde");
			}
	    	redirect("/administrator/users");
		}
    }

    public function deactivateUser($userId){
    	if(!$this->session->has_userdata('role')){
			redirect(TIMEOUT_REDIRECT);
		} else {
			if ($this->Supplier_model->setSupplierStatus($userId, 'pending')) {
				$this->session->set_flashdata("success","Se há desactivado al mayorista con éxito");	
			} else {
				$this->session->set_flashdata("error","Se há producido un error que no ha permitido desactivar el usuario. Pruebe más tarde");
			}
	    	redirect("/administrator/users");
		}
    }

    public function impersonateUser(){
    	if ((!$this->session->has_userdata('role')) and ($this->session->userdata('role') != "administrator")){
    		redirect(TIMEOUT_REDIRECT);
		} else {
	    	$username = $this->input->post("imperUsername");
	    	$user = $this->User_model->getUserByUsername($username);
	    	if ($user->role == 'supplier') { 
	    		$supplier = $this->Supplier_model->getSupplierByUserId($user->id);
	    		$this->session->set_userdata(array('id'=>$user->id, 'role_id'=>$supplier->id, 'user'=>$user->username, 'role'=>$user->role, 'email'=>$user->email,  'logged_in'=>true));	
	    		$this->User_model->setLoadInfo($user->id);
	    	} else if ($user->role == 'distributor') {
	    		$distributor = $this->Distributor_model->getDistributorByUserId($user->id);
	    		$this->session->set_userdata(array('id'=>$user->id, 'role_id'=>$distributor->id, 'user'=>$user->username, 'role'=>$user->role, 'email'=>$user->email,  'logged_in'=>true));
	    		$this->User_model->setLoadInfo($user->id);
	    	}
	    	redirect('home');
	    }
    }

    public function settings(){
    	$data['settings'] = $this->Settings_model->getSettings();
    	$this->routedHome("settings", $data);
    }

    public function activateEmailVerification(){
    	if ((!$this->session->has_userdata('role')) and ($this->session->userdata('role') != "administrator")){
    		redirect(TIMEOUT_REDIRECT);
		} else {
    		$this->Settings_model->setSettings("EMAIL_REGISTER_VERIFICATION", true);
    		redirect("administrator/settings");
    	}
    }

    public function deactivateEmailVerification(){
    	if ((!$this->session->has_userdata('role')) and ($this->session->userdata('role') != "administrator")){
    		redirect(TIMEOUT_REDIRECT);
		} else {
    		$this->Settings_model->setSettings("EMAIL_REGISTER_VERIFICATION", false);	
    		redirect("administrator/settings");
    	}
    }


    public function refund($userId){
    	if ((!$this->session->has_userdata('role')) and ($this->session->userdata('role') != "administrator")){
    		redirect(TIMEOUT_REDIRECT);
		} else {
	    	$this->form_validation->set_rules('refundAmount', 'cantidad', 'numeric');
	    	$amount = $this->input->post("refundAmount");
			if ($this->form_validation->run() == TRUE){
		    	if ($amount>0){
		    		$this->Credit_model->refund($userId,$amount);
		    		$this->session->set_flashdata("success","Se ha agregado exitosamente $" . $amount);
		    	} else {
		    		$this->session->set_flashdata("error","Debe ingresar un monto positivo");
		    	}
		    } else { 
		    	$this->session->set_flashdata("error","Debe ingresar un valor numérico. Usted ingresó <b>" . $amount . "</b>");
		    }
	    	redirect("administrator/users");
	    }
    }

}

?>