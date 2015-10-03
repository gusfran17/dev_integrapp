<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index(){
		if($this->session->has_userdata('role')){
			$userId = $this->session->userdata("id");
			$role = $this->session->userdata("role");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'supplier') { 
			$data['balance'] = $this->Credit_model->getLatestBalance($userId);
			$data['transactions'] = $this->Credit_model->getTransactionsByUserId($userId);
			$data['pendingTransfers'] = $this->Credit_model->getPendingTransfersByUserId($userId);
			$this->routedHome("templates/credit/credit", $data, true);
		} else if ($role == 'administrator') {

		}
		
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

	public function viewTransferDetails($transferId){
		if($this->session->has_userdata('role')){
			$userId = $this->session->userdata("id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$data['transfer'] = $this->Credit_model->getTransferById($transferId);
		$data['transferHistory'] = $this->Credit_model->getUserTransferHistory($userId);
		$this->routedHome("templates/credit/transfer_details", $data, true);
	}

	public function setRequestCredit(){
		if($this->session->has_userdata('role')){
			$userId = $this->session->userdata("id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$data['balance'] = $this->Credit_model->getLatestBalance($userId);
		$this->routedHome("templates/credit/submit_transfer", $data, true);
	}

	public function requestCredit(){
		if($this->session->has_userdata('role')){
			$userId = $this->session->userdata("id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$data = array();
		$this->form_validation->set_rules('amount', 'Cantidad depositada', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('message', 'Nota al administrador', 'required');
		$this->form_validation->set_message('required', 'El campo %s es necesario.');
		$this->form_validation->set_message('numeric', 'Solo se pueden insertar numeros, puntos y comas');
		$this->form_validation->set_message('greater_than', 'La cantidad no puede ser negativa ni cero.');
		
		if ($this->form_validation->run() == FALSE){
			$data['balance'] = $this->Credit_model->getLatestBalance($userId);
			$this->routedHome("templates/credit/submit_transfer", $data, true);
		}else{
			$note = $this->input->post("message");
			$amount = $this->input->post("amount");
			if($this->input->post("uploadVoucher")){
				$voucherImage = $this->uploadTempVoucher($userId);
				if (isset($voucherImage)){
					$this->Credit_model->requestCredit($userId, $amount, $note, $voucherImage);
					$this->session->set_flashdata('success', "Se ha enviado aviso al administrador para validar la transferencia");
					redirect("credit");
				} else {
					$this->setRequestCredit();
				}
			}else{
				$voucherImage = "";
				$this->Credit_model->requestCredit($userId, $amount, $note, $voucherImage);
				$this->session->set_flashdata('success', "Se ha enviado aviso al administrador para validar la transferencia");
				redirect("credit");
			}

		}
    }

    public function uploadTempVoucher($userId){
		$upload_path = '.' . VOUCHER_IMAGES_PATH . "temp";
		if (!file_exists(VOUCHER_IMAGES_PATH)){
            @mkdir('.' . VOUCHER_IMAGES_PATH);
        }
		if (!file_exists(VOUCHER_IMAGES_PATH . "temp")){
            @mkdir($upload_path);
        }
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = ALLOWED_VOUCHER_IMAGE_TYPE;
        $config['max_size'] = ALLOWED_VOUCHER_IMAGE_MAXSIZE;
        $config['max_width']  = ALLOWED_VOUCHER_IMAGE_MAXWIDTH;
        $config['max_height']  = ALLOWED_VOUCHER_IMAGE_MAXHEIGHT;
        $config['file_name']  = md5($userId);
        $config['overwrite']  = true;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
        	$imageData = $this->upload->data();
        	return $imageData["file_name"];
        } else {
        	$error = $this->upload->display_errors('','');
			$this->session->set_flashdata('error', $error);
			return null;
        }
    }

    public function deletePendingTransfer($transferId){
		if($this->session->has_userdata('role')){
			if ($this->Credit_model->deletePendingTransfer($transferId)){
				$this->session->set_flashdata('success', "Se há eliminado la transferencia seleccionada");
			} else {
				$this->session->set_flashdata('error', "Hubo un error al eliminar la transferencia y no se pudo concretar la acción");
			}
			redirect('credit');
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
    	
    }

}

?>