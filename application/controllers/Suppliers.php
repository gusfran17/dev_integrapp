<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->catalog_pagination_uri_segment = 4;
		$this->suppliers_pagination_uri_segment = 3;
		$this->suppliersPerPage = 20;
		$this->productsPerPage = 10;
		$this->paginationLinksAmount = 3;
	}
	
	public function routedHome($data = null, $section, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"]=$this->session->userdata("user");
			$data["loadInfo"]=$this->session->userdata("loadInfo");
		} else {
			redirect(TIMEOUT_REDIRECT);
			die;
		}
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	} 


public function index(){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'distributor'){
			$this->viewSuppliersForDistributor($roleId);
		} else if ($role=='supplier') {
			$this->viewSuppliersForSupplier($roleId);
		}
	}

	private function viewSuppliersForSupplier($roleId){
		$data['suppliers'] = $this->Supplier_model->getSuppliersForSupplier($roleId);
		$data['tableScripts'] = true;
		$this->routedHome($data, 'suppliers');
	}

	private function viewSuppliersForDistributor($roleId){
		$role = 'distributor';
		$url = base_url() . "suppliers/index";
		$totalRows = $this->Supplier_model->suppliersCount();
		$this->setPagination($url, $totalRows, $this->suppliers_pagination_uri_segment, $this->suppliersPerPage);
		$page = $this->getPage($this->suppliers_pagination_uri_segment);
		$suppliers =  $this->Supplier_model->getSuppliers($page, $this->suppliersPerPage);
		for ($i=0; $i < count($suppliers); $i++) {
			$suppliers[$i]->associationStatus = $this->Supplier_model->isDistributorAssociationActive($roleId, $suppliers[$i]->id);
			$suppliers[$i]->associationDiscount = $this->Supplier_model->getAssociationDiscountForDistributor($roleId, $suppliers[$i]->id);
		}
		$data["suppliers"] = $suppliers;
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$data['watchingRole'] = $role;
		// View data according to array.
		$section = 'suppliers';
		$this->routedHome($data, $section, false);
	}

	public function viewSupplier($supplierId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$supplier = $this->Supplier_model->getSupplierById($supplierId);
		if ($role=='distributor'){
			$supplier->associationStatus = $this->Supplier_model->isDistributorAssociationActive($roleId, $supplierId);
			$supplier->associationDiscount = $this->Supplier_model->getAssociationDiscountForDistributor($roleId, $supplierId);		
		} else if ($role == 'supplier'){
			$supplier->associationStatus = "";
			$supplier->associationDiscount = "";		
		}
		
		$data['supplier'] = $supplier;
		$data['watchingRole'] = $role;
		$this->routedHome($data, 'templates/supplier/supplier', true);
	}
	
	public function setPagination($url, $totalRows, $uriSegment, $itemsPerPage){	
		$config = array();
		$config["base_url"] = $url;
		$config["total_rows"] = $totalRows;
		$config['uri_segment'] = $uriSegment;
		$config["per_page"] = $itemsPerPage;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $this->paginationLinksAmount;
		$config['first_link'] = '<< ';
		$config['last_link'] = ' >>';
		$config['next_link'] = ' >';
		$config['prev_link'] = '< ';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
	}

	public function viewCatalog($selectedSupplierId){
		$this->session->set_userdata('selectedSupplierId', $selectedSupplierId);
		$this->session->unset_userdata('selectedCategoryId');
		$this->viewSupplierCatalog(DEFAULT_CATALOG_ORDER);		
	}

	public function viewSupplierCatalog($orderBy = null){
		if($this->session->has_userdata('role')){
			$this->session->set_userdata('catalogView', 'viewSupplierCatalog');
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			$selectedSupplierId = $this->session->userdata('selectedSupplierId');		
			if (($selectedSupplierId == $roleId) && ($role=='supplier')){
				$data['itIsMe'] = true;
			}	
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		//set sidebar
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->Category_model->getCategoryBranchIds($selectedCategoryId);
		$data['childCategories'] = $this->Category_model->getCategory($selectedCategoryId); 
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;

		//setSupplierCatalog
		if ($orderBy == null){
			$orderBy = DEFAULT_CATALOG_ORDER;
		}
		$totalRows = 0;
		$page = $this->getPage($this->catalog_pagination_uri_segment);
		$catalog = $this->Supplier_model->getGeneralCatalog($selectedSupplierId, $selectedCategoryId, $orderBy, $page, $this->productsPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$supplier = $this->Supplier_model->getSupplierById($selectedSupplierId);
		if ($role=='distributor'){
			$supplier->associationStatus = $this->Supplier_model->isDistributorAssociationActive($roleId, $supplier->id);
			$supplier->associationDiscount = $this->Supplier_model->getAssociationDiscountForDistributor($roleId, $supplier->id);
			$this->Distributor_model->isDistributorCatalogItemForCatalog($roleId,$catalog);
		} else if ($role == 'supplier'){
			$supplier->associationStatus = $this->Supplier_model->isSupplierSupplierAssociation($supplier->id, $roleId);
			$supplier->associationDiscount = $this->Supplier_model->getToSupplierDiscount($supplier->id, $roleId);
			$this->Supplier_model->isSupplierCatalogItemForCatalog($roleId,$catalog);
		}
		$data['supplier'] = $supplier;
		$data['Catalog'] = $catalog;
		$url = base_url() . "Suppliers/viewSupplierCatalog/$orderBy";
		$this->setPagination($url, $totalRows, $this->catalog_pagination_uri_segment, $this->productsPerPage);
		$data['orderBy']=$orderBy;
		$data['watchingRole'] = $role;
		$data['watchingRoleId'] = $roleId;
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$section = 'templates/supplier/supplier_catalog';
		$this->routedHome($data, $section, true);		
	}


	public function getPage($uri_segment){
		if($this->uri->segment($uri_segment)){
			$page = ($this->uri->segment($uri_segment)) ;
			log_message('info',"Supplier Controller setPage Function uri_segment  Page:" . $page, false);
		}else{
			$page = 1;
		}
		return $page;
	}

	public function getCategoryFilter(){
		$selectedCategoryId = $this->input->post("selectedCategoryId");
		if (($selectedCategoryId == -1) or ($selectedCategoryId == 0)){
			if ($selectedCategoryId == -1) $this->session->unset_userdata('selectedCategoryId');
			$selectedCategoryId = null;
		}
		if ($selectedCategoryId == null){
			if ($this->session->has_userdata('selectedCategoryId')){
				$selectedCategoryId = $this->session->userdata('selectedCategoryId');
			}
		} else {
			$this->session->set_userdata('selectedCategoryId', $selectedCategoryId);
		}
		return $selectedCategoryId;
	}

	public function setAssociationPending($supplierId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			if ($role == 'distributor'){
				$distributorId = $this->session->userdata("role_id");
				$this->Distributor_model->setSupplierDistributorStatus($supplierId, $distributorId, 'pending');
			}
		}
		redirect('Suppliers');
	}

	public function setAssociationRejected($supplierId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			if ($role == 'distributor'){
				$distributorId = $this->session->userdata("role_id");
				$this->Distributor_model->setSupplierDistributorStatus($supplierId, $distributorId, 'rejected');
			}
		}
		redirect('Suppliers');
	}

	public function sendSupplierSupplierRequest($supplierId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$this->Supplier_model->sendSupplierSupplierRequest($roleId, $supplierId);
		$this->session->set_flashdata('success', "La solicitud se há enviado exitosamente");
		redirect('suppliers');
	}

	public function cancelSupplierSupplierRequest($supplierId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($this->Supplier_model->cancelSupplierSupplierRequest($roleId, $supplierId)!=0){
			$this->session->set_flashdata('success', "Se há cancelado la asociación exitosamente");
			redirect('suppliers');
		}
	}

	public function setToSupplierDiscount($supplierId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$setToSupplierDiscount = $this->input->post("discount");
		if ($this->Supplier_model->setToSupplierDiscount($roleId, $supplierId, $setToSupplierDiscount)>0){
			$this->session->set_flashdata('success', "Se há modificado el monto a descontar exitosamente");
			redirect('suppliers');
		} else {
			$this->session->set_flashdata('error', "Hubo un error por favor intentelo más tarde. Si el problema persiste comuniquese con el administrador");
			redirect('suppliers');
		}
	}

}


?>