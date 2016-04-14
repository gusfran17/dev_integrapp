<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->pagination_uri_segment = 4;
		$this->productsAmountPerPage = 9;
	}

	public function index(){
		if($this->session->userdata("role")){ 
			redirect('profile');
		} else { 
			$this->homepage();
		}
	}

	public function routedHome($section, $data=null, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"]=$this->session->userdata("user");
			$data["loadInfo"]=$this->session->userdata("loadInfo");
		} else {
			$role = "home";
		}
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_'.$role, $data);
		if ($template) $this->load->view($section, $data);
		else $this->load->view($role.'/'.$section, $data);
		$this->load->view('templates/template_footer', $data);
	}

	public function homepage(){
			$totalRows = 0;
			$data['Catalog'] = $this->Product_model->get_catalog(null, null, 'published', DEFAULT_CATALOG_ORDER, 1, 4, $totalRows);
			$this->load->view('home/home', $data);
	}

	public function integrapp(){
			$this->routedHome('integrapp',null);
	}

	public function faq(){
			$this->routedHome('faq',null);
	}

	public function contact(){
			$this->routedHome('contact',null);
	}

	public function community(){
			$this->routedHome('community',null);
	}

	public function catalog($viewType=null){
		if (isset($viewType)){
			$this->session->set_userdata('viewType', $viewType);
		} else {
			$this->session->set_userdata('viewType', PRODUCT_DEFAULT_VIEW);
		}
		$this->orderCatalogBy(DEFAULT_CATALOG_ORDER);
	}

	public function orderCatalogBy ($orderBy){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata('role');
		} else {
			$role = 'pacient';
		}
		$url = base_url() . "home/orderCatalogBy/$orderBy";
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->Category_model->getCategoryBranchIds($selectedCategoryId);
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;
		$data['childCategories'] = $this->Category_model->getCategory($selectedCategoryId); 
		$page = $this->getPage($this->pagination_uri_segment);
		$totalRows = 0;
		$catalog = $this->Product_model->get_catalog(null, $selectedCategoryId, 'published', $orderBy, $page, $this->productsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->productsAmountPerPage);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$data['orderBy'] = $orderBy;
		$data['tableScripts'] = true;
		$data['watchingRole'] = $role;
		$data['viewType'] = $this->session->userdata('viewType');
		$section = 'templates/product/catalog';
		$this->routedHome($section, $data,true);
	}

	public function setPagination($url, $totalRows, $amountPerPage){	
		$config = array();
		$config["base_url"] = $url;
		$config["total_rows"] = $totalRows;
		$config['uri_segment'] = $this->pagination_uri_segment;
		$config["per_page"] = $amountPerPage;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 3;
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

	public function viewDistributorForPacient($distributorId){
		$distributor = $this->Distributor_model->getDistributorById($distributorId);
		$distributor->associationStatus = false;
		$distributor->associationDiscount = false;		
		$data['distributor'] = $distributor;
		$data['watchingRole'] = "pacient";
		$this->routedHome('templates/distributor/distributor', $data, true);
	}



	public function viewDistributorCatalogForPacient($orderBy){
		$selectedDistributorId = $this->session->userdata('selectedDistributorId');
		$distributor = $this->Distributor_model->getDistributorById($selectedDistributorId);
		$data['distributor'] = $distributor;
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
		$page = $this->getPage($this->pagination_uri_segment);
		$catalog = $this->Distributor_model->get_catalog($selectedDistributorId, $selectedCategoryId, $orderBy, $page, $this->productsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['Catalog'] = $catalog;
		$url = base_url() . "Distributors/viewDistributorCatalogForPacient/$orderBy";
		$this->setPagination($url, $totalRows, $this->pagination_uri_segment, $this->productsAmountPerPage);
		$data['orderBy']=$orderBy;
		$data['watchingRole'] = 'pacient';
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$section = 'templates/distributor/distributor_catalog';
		$this->routedHome($section, $data, true);	
	}

	public function sendMessage(){
		$name = $this->input->post("name");
		$subject = $name . ": " . $this->input->post("subject");
		$email = $this->input->post("email");
		$message = $this->input->post("message") . "\n Mensaje enviado por: " . $email;
		$from = NOREPLY_ACCOUNT;
		$to = "info@integrapp.com.ar";
		$cc = "";
		$bcc = "";
		$this->User_model->sendEmail($subject, $message, $from, $to, $cc, $bcc);
		redirect("home/contact");

	}

}

?>