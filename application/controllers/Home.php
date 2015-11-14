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
		$this->load->view('templates/template_header', $data);
		$this->load->view('templates/template_nav', $data);
		$this->load->view('navs/nav_home', $data);
		$this->load->view('home/'.$section,$data);
		$this->load->view('templates/template_footer', $data);
	}

	public function homepage(){
			$data['Catalog'] = $this->Product_model->getPacientCatalog();
			$this->routedHome('home',$data);
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
		$url = base_url() . "home/orderCatalogBy/$orderBy";
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->Category_model->getCategoryBranchIds($selectedCategoryId);
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;
		$data['childCategories'] = $this->Category_model->getCategory($selectedCategoryId); 
		if($this->uri->segment($this->pagination_uri_segment)){
			$page = ($this->uri->segment($this->pagination_uri_segment)) ;
		}else{
			$page = 1;
		}
		$totalRows = 0;
		$catalog = $this->Product_model->getPacientCatalog($selectedCategoryId, $page, $this->productsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->productsAmountPerPage);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['viewType'] = $this->session->userdata('viewType');
		$section = 'catalog';
		$this->routedHome($section, $data);
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


}

?>