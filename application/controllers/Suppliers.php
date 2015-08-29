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
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer');
	} 


	public function viewSuppliers(){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$url = base_url() . "Suppliers/viewSuppliers";
		$totalRows = $this->Supplier_model->suppliersCount();
		$this->setPagination($url, $totalRows, $this->suppliers_pagination_uri_segment, $this->suppliersPerPage);
		$page = $this->getPage($this->suppliers_pagination_uri_segment);
		$suppliers =  $this->Supplier_model->getSuppliers($page, $this->suppliersPerPage);
		for ($i=0; $i < count($suppliers); $i++) {
			$suppliers[$i]->associationStatus = $this->Supplier_model->associationStatus($role, $roleId, $suppliers[$i]->id);
			$suppliers[$i]->associationDiscount = $this->Supplier_model->associationDiscount($role, $roleId, $suppliers[$i]->id);
		}
		$data["suppliers"] = $suppliers;
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );

		// View data according to array.
		$section = 'templates/supplier/suppliers';
		$this->routedHome($data, $section, true);
	}

	public function viewSupplier($supplierId){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$supplier = $this->Supplier_model->getSupplierById($supplierId);
		$supplier->associationStatus = $this->Supplier_model->associationStatus($role, $roleId, $supplierId);
		$supplier->associationDiscount = $this->Supplier_model->associationDiscount($role, $roleId, $supplierId);		
		$data['supplier'] = $supplier;
		$data['role'] = $role;
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
		$this->viewSupplierCatalog('category_id');		
	}

	public function viewSupplierCatalog($orderBy = null){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			$selectedSupplierId = $this->session->userdata('selectedSupplierId');			
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$supplier = $this->Supplier_model->getSupplierById($selectedSupplierId);
		$supplier->associationStatus = $this->Supplier_model->associationStatus($role, $roleId, $supplier->id);
		$supplier->associationDiscount = $this->Supplier_model->associationDiscount($role, $roleId, $supplier->id);		
		$data['supplier'] = $supplier;
		//set sidebar
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->getCategoryBranch($selectedCategoryId);
		$data['childCategories'] = $this->Product_model->getCategory($selectedCategoryId); 
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;

		//setSupplierCatalog
		if ($orderBy == null){
			$orderBy = 'category_id';
		}
		$totalRows = 0;
		$page = $this->getPage($this->catalog_pagination_uri_segment);
		$data['Catalog'] = $this->Product_model->get_catalog($selectedSupplierId, $selectedCategoryId, 'published', $orderBy, $page, $this->productsPerPage, $totalRows);
		$url = base_url() . "Suppliers/viewSupplierCatalog/$orderBy";
		$this->setPagination($url, $totalRows, $this->catalog_pagination_uri_segment, $this->productsPerPage);
		$data['orderBy']=$orderBy;
		
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

	public function setSupplierDistributorStatus($supplierId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			if ($role == 'distributor'){
				$roleId = $this->session->userdata("role_id");
				$this->Distributor_model->setSupplierDistributorStatus($supplierId, $roleId, 'pending');
			}
		}
		redirect('Suppliers/viewSuppliers');
	}

}


?>