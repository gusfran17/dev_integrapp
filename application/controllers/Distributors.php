<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributors extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->catalog_pagination_uri_segment = 4;
		$this->productsPerPage = 10;
		$this->paginationLinksAmount = 3;
	}

	public function routedHome($data = null, $section, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"] = $this->session->userdata("user");
			$data["loadInfo"]=$this->session->userdata("loadInfo");
		} else {
			redirect(TIMEOUT_REDIRECT);
			die;
		}
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	} 


	public function viewDistributors(){
		$roleId = $this->session->userdata("role_id");
		$pendingDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'pending');
		$data['pendingDistributors'] = $pendingDistributors;
		$rejectedDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'rejected');
		$data['rejectedDistributors'] = $rejectedDistributors;
		$approvedDistributors = $this->Supplier_model->getAssociatedDistributors($roleId, 'approved');
		$data['approvedDistributors'] = $approvedDistributors;
		$section = 'distributors';
		$this->routedHome($data, $section);
	}

	public function viewDistributor($distributorId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$distributor = $this->Distributor_model->getDistributorById($distributorId);
		if($role=='supplier'){
			$distributor->associationStatus = $this->Supplier_model->getDistributorAssociationStatus($distributorId,$roleId);
			$distributor->associationDiscount = $this->Supplier_model->getAssociationDiscountForDistributor($distributorId, $roleId);		
		} else {
			$distributor->associationStatus = false;
			$distributor->associationDiscount = false;
		}
			
		$data['distributor'] = $distributor;
		$data['watchingRole'] = $role;
		$this->routedHome($data, 'templates/distributor/distributor', true);
	}

	public function viewCatalog($selectedDistributorId){
		$this->session->unset_userdata('selectedCategoryId');
		$this->session->set_userdata('selectedDistributorId', $selectedDistributorId);
		$this->viewDistributorCatalog(DEFAULT_CATALOG_ORDER);		
	}

	public function viewDistributorCatalog($orderBy = null){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			$selectedDistributorId = $this->session->userdata('selectedDistributorId');		
			if (($role == 'distributor') and ($selecteDistributorId == $roleId)){
				$data['itIsMe'] = true;
			}	
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$distributor = $this->Distributor_model->getDistributorById($selectedDistributorId);
		$data['distributor'] = $distributor;
		//set sidebar
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->getCategoryBranch($selectedCategoryId);
		$data['childCategories'] = $this->Product_model->getCategory($selectedCategoryId); 
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;

		//setSupplierCatalog
		if ($orderBy == null){
			$orderBy = DEFAULT_CATALOG_ORDER;
		}
		$totalRows = 0;
		$page = $this->getPage($this->catalog_pagination_uri_segment);
		$catalog = $this->Distributor_model->get_catalog($selectedDistributorId, $selectedCategoryId, $orderBy, $page, $this->productsPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['Catalog'] = $catalog;
		$url = base_url() . "Distributors/viewDistributorCatalog/$orderBy";
		$this->setPagination($url, $totalRows, $this->catalog_pagination_uri_segment, $this->productsPerPage);
		$data['orderBy']=$orderBy;
		
		$data['watchingRole'] = $role;
		$data['hasSidebar']= true;
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$section = 'templates/distributor/distributor_catalog';
		$this->routedHome($data, $section, true);		
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

	public function getPage($uri_segment){
		if($this->uri->segment($uri_segment)){
			$page = ($this->uri->segment($uri_segment)) ;
		}else{
			$page = 1;
		}
		return $page;
	}

	public function getCategoryBranch($selectedCategoryId){
		log_message('info', "Selected Category Id: " . $selectedCategoryId,false);
		$categoriesArray = array();
		if (isset($selectedCategoryId)){
			$this->Product_model->getCategoryBranch($selectedCategoryId, $categoriesArray);	
		}
		return $categoriesArray;
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

	public function setSupplierDistributorStatus($DistributorId, $status){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$userId = $this->session->userdata("id");
			$supplierId = $this->session->userdata("role_id");
			$result = $this->Distributor_model->setSupplierDistributorStatus($supplierId, $DistributorId, $status);
			$this->SetResultMessage($result, $status);
			$this->User_model->setLoadInfo($userId);
			$this->viewDistributors();
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function SetResultMessage($editionSuccess, $status){
		if ($editionSuccess) {
			if ($status == 'pending') { 
				$this->session->set_flashdata('success', "La solicitud esta ahora pendiente");
			} else if ($status == 'rejected') {
				$this->session->set_flashdata('success', "Se há rechazado la solicitud de la ortopedia, podra encontrar la misma en la solapa de <b>Rechazados</b>");
			} else if ($status == 'approved') {
				$this->session->set_flashdata('success', "Se há aprobado la solicitud de la ortopedia. <b>Recuerde que la misma vera sus productos con el descuento indicado.</b>");
			}
		} else {
			$this->session->set_flashdata('error', "No se há logrado completar la solicitud");
		}
	}

	public function setSupplierDistributorDiscount($distributorId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			if ($role == 'supplier'){
				$roleId = $this->session->userdata("role_id");
				$discount = $this->input->post('discount');
				if (!($this->Distributor_model->setSupplierDistributorDiscount($roleId, $distributorId, $discount))) {
					$this->session->set_flashdata('error', "Hubo un error al modificar el monto a descontar.");
				} else {
					$this->session->set_flashdata('success', "Se ha guardado el porcentaje de descuento exitosamente");
				}
			}
		}
		$this->viewDistributors();
	}

}

?>