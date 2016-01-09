<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->pagination_uri_segment = 4;
		$this->categoryLevelsAmount = 5;
		$this->productsAmountPerPage = 9;
		$this->myProductsAmountPerPage = 15;
	}
	

	public function tabbedRoutedHome($data = null, $tab){
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
		$this->load->view($role.'/product/product_tabs_top', $data);
		$this->load->view($role.'/product/' . $tab, $data);
		$this->load->view($role.'/product/product_tabs_bottom', $data);
		$this->load->view('templates/template_footer');
	}

	public function routedHome($data = null, $section = null, $template=false){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$data["username"]=$this->session->userdata("user");
			$data["loadInfo"]=$this->session->userdata("loadInfo");
		} else {
			$role = 'home';
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
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'supplier'){
			$this->myProducts();
		} else if ($role == 'distributor'){
			$this->products();
		}
	}

	public function products($categoryId=null){
		if (isset($categoryId)){
			$this->session->set_userdata('selectedCategoryId', $categoryId);
		} else {
			$this->session->unset_userdata('selectedCategoryId');
		}
		$this->session->set_userdata('statusFilter', 'published');
		$this->setView('viewCatalog');
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'supplier'){
			$this->orderSupplierCatalogBy(DEFAULT_CATALOG_ORDER);
		} else {
			$this->orderDistributorCatalogBy(DEFAULT_CATALOG_ORDER);
		}
	}

	public function myProducts(){
		$this->session->unset_userdata('selectedCategoryId');
		$this->session->set_userdata('statusFilter', 'published');
		$this->setView('viewMyCatalog');
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'supplier'){
			$this->orderMySupplierCatalogBy(DEFAULT_CATALOG_ORDER);
		} else {
			$this->orderMyDistributorCatalogBy(DEFAULT_CATALOG_ORDER);
		}	
	}

	public function mySecondaryProducts(){
		$this->session->unset_userdata('selectedCategoryId');
		$this->session->set_userdata('statusFilter', 'published');
		$this->setView('viewMySecSuppCatalog');
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		if ($role == 'supplier'){
			$this->orderMySecondarySupplierCatalogBy(DEFAULT_CATALOG_ORDER);
		} else {
			redirect(TIMEOUT_REDIRECT);
		}	
	}

	public function setView($view){
		$this->session->set_userdata('catalogView', $view);
	}

	public function showPublishedProducts(){
		$this->session->set_userdata('statusFilter', 'published');
		$this->orderMySupplierCatalogBy(DEFAULT_CATALOG_ORDER);
	}

	public function showActiveProducts(){
		$this->session->set_userdata('statusFilter', 'active');
		$this->orderMySupplierCatalogBy(DEFAULT_CATALOG_ORDER);
	}

	public function showInactiveProducts(){
		$this->session->set_userdata('statusFilter', 'inactive');
		$this->orderMySupplierCatalogBy(DEFAULT_CATALOG_ORDER);
	}

	public function productLoadView($data=NULL){
		$role = $this->session->userdata("role");
		$data['productLoadView'] = true;
		$data['Catalog'] = array();
		$data['loadCategory']= $this->Category_model->getCategory();
		$this->tabbedRoutedHome($data, 'product_load');
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


	public function orderSupplierCatalogBy ($orderBy){
		$statusFilter = $this->session->userdata('statusFilter');
		$supplierId = $this->session->userdata("role_id");
		$data['statusFilter'] = $statusFilter; 
		$url = base_url() . "Product/orderSupplierCatalogBy/$orderBy";
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
		$catalog = $this->Product_model->get_catalog(null, $selectedCategoryId, $statusFilter, $orderBy, $page, $this->productsAmountPerPage, $totalRows);
		$this->Supplier_model->addSuppliersDetailsToProducts($catalog);
		$this->Supplier_model->addSuppliersAssociationToProducts($catalog, $supplierId);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->productsAmountPerPage);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		$role = $this->session->userdata("role");
		$data['viewCatalog'] = true;
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['tableScripts'] = true;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data,$tab);
	}

	public function orderMySupplierCatalogBy ($orderBy){
		$role_id = $this->session->userdata('role_id');
		$statusFilter = $this->session->userdata('statusFilter');
        $data['statusFilter'] = $statusFilter; 
		$url = base_url() . "Product/orderMySupplierCatalogBy/$orderBy";
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
		$catalog = $this->Product_model->get_catalog($role_id, $selectedCategoryId, $statusFilter, $orderBy, $page, $this->myProductsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$this->Product_model->addProductsPublishingCost($catalog);
		$this->Supplier_model->addSuppliersDetailsToProducts($catalog);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->myProductsAmountPerPage);
		
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links);
		$data['viewMyCatalog'] = true;
		$role = $this->session->userdata("role");
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['tableScripts'] = true;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data, $tab);
	}

	public function orderMySecondarySupplierCatalogBy ($orderBy){
		$role_id = $this->session->userdata('role_id');
        $statusFilter = 'published';
        $data['statusFilter'] =  $statusFilter;
		$url = base_url() . "Product/orderMySecondarySupplierCatalogBy/$orderBy";
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
		$catalog = $this->Supplier_model->getSecondarySupplierCatalog($role_id, $selectedCategoryId, $statusFilter, $orderBy, $page, $this->myProductsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$this->Supplier_model->addSuppliersDetailsToProducts($catalog);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->myProductsAmountPerPage);
		
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links);
		$data['viewMySecSuppCatalog'] = true;
		$role = $this->session->userdata("role");
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['tableScripts'] = true;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data, $tab);
	}

	public function orderDistributorCatalogBy ($orderBy){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}

		$statusFilter = $this->session->userdata('statusFilter');
		$data['statusFilter'] = $statusFilter; 
		$url = base_url() . "Product/orderDistributorCatalogBy/$orderBy";
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
		$catalog = $this->Product_model->get_catalog(null, $selectedCategoryId, $statusFilter, $orderBy, $page, $this->myProductsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$this->Supplier_model->addAssociationDetailsToProductForDistributor($roleId,$catalog);
		$this->Supplier_model->addSuppliersDetailsToProducts($catalog, $roleId);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->myProductsAmountPerPage);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		log_message('info',"Pagination: ".$str_links . "total rows: " . $totalRows,false);
		
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['tableScripts'] = true;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data,$tab);
	}

	public function orderMyDistributorCatalogBy ($orderBy){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$url = base_url() . "Product/orderMyDistributorCatalogBy/$orderBy";
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
		$catalog = $this->Distributor_model->get_catalog($roleId, $selectedCategoryId, $orderBy, $page, $this->myProductsAmountPerPage, $totalRows);
		$this->Product_model->addCategoryPathToProducts($catalog);
		$this->Supplier_model->addAssociationDetailsToProductForDistributor($roleId,$catalog);
		$this->Supplier_model->addSuppliersDetailsToProducts($catalog, $roleId);
		$data['Catalog'] = $catalog;
		$this->setPagination($url, $totalRows, $this->myProductsAmountPerPage);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		log_message('info',"Pagination: ".$str_links . "total rows: " . $totalRows,false);
		
		$data['viewMyCatalog'] = true;
		$data['orderBy'] = $orderBy;
		$data['hasSidebar'] = true;
		$data['tableScripts'] = true;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data,$tab);
	}

	public function search(){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			//redirect(TIMEOUT_REDIRECT);
		}
		$searchString = $this->input->post("searchCatalog");
		if (isset($role)){
			if ($role = 'distributor'){
				$catalog = $this->Product_model->productSearch($searchString, null, $roleId);
			} else if ($role = 'supplier') {
				$catalog = $this->Product_model->productSearch($searchString, $roleId, null);
			}
		} else {
			$catalog = $this->Product_model->productSearch($searchString);
		}
		$this->Product_model->addCategoryPathToProducts($catalog);
		$data['searchString'] = $searchString;
		$data['Catalog'] = $catalog;
		$data['orderBy'] = DEFAULT_CATALOG_ORDER;
		$data['tableScripts'] = true;
		$tab = 'templates/product/search_results';
		$this->routedHome($data,$tab,true);
		
	}

	public function getCategories($id=NULL){
		if (isset($id)) {
			$data['NextCategory'] = $this->Category_model->getCategory($id);
			echo json_encode($data);
			die();
		}else{
			$data['category'] = $this->Category_model->getCategory();
		}

	}

	public function getTree($id=NULL){
			$data['tree'] = $this->Category_model->getTree($id);
			echo json_encode($data) ;
	}


	public function saveProduct(){
		if($this->session->has_userdata('role')){
			$userId = $this->session->userdata("id");
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		$editID = $this->input->post("editProductID");
		$editProduct = ($editID != "");
		if (!$editProduct){ 
			$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required|callback_productNameCheck');
	   		$this->form_validation->set_rules('productCode', 'Codigo', 'required|callback_productCodeCheck');	
	   		$this->form_validation->set_message('productNameCheck', 'Usted ya tiene un producto con este nombre en su catalogo');
   			$this->form_validation->set_message('productCodeCheck', 'Usted ya tiene un producto con este código en su catalogo');
		} else {
			$this->form_validation->set_rules('productName', 'Nombre del Producto', 'required|callback_productNameCheckForEdition');
   			$this->form_validation->set_rules('productCode', 'Codigo', 'required|callback_productCodeCheckForEdition');
	   		$this->form_validation->set_message('productNameCheckForEdition', 'Usted ya tiene un producto con este nombre en su catalogo');
   			$this->form_validation->set_message('productCodeCheckForEdition', 'Usted ya tiene un producto con este código en su catalogo');
		}
		$this->form_validation->set_rules('categoryTree', 'Categoria de producto', 'required');
   		$this->form_validation->set_rules('productVAT', 'IVA', 'trim');
   		$this->form_validation->set_rules('productPrice', 'Precio', 'required|trim|numeric');
   		$this->form_validation->set_rules('productDesc', 'Descripción', 'required|min_length[' . PROD_DESCRIPTION_MIN_LENGTH . ']|max_length[' . PROD_DESCRIPTION_MAX_LENGTH . ']');
   		$this->form_validation->set_rules('productPresc', 'Como Prescribirlo', 'required|min_length[' . PROD_DESCRIPTION_MIN_LENGTH . ']|max_length[' . PROD_DESCRIPTION_MAX_LENGTH . ']');

   		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
   		$this->form_validation->set_message('numeric', 'El campo %s solo puede contener vlores numéricos');
   		$this->form_validation->set_message('min_length', 'La descripcion debe tener al menos ' . PROD_DESCRIPTION_MIN_LENGTH . ' caracteres');
   		$this->form_validation->set_message('max_length', 'La descripcion debe tener a lo sumo ' . PROD_DESCRIPTION_MAX_LENGTH . ' caracteres');

   		//El boton de submit apretado fue Cancelar
   		$cancel =  $this->input->post('submitLoad');
   		if ($cancel=="Cancelar"){
   			//Goes back to the form (now empty values)
				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
				if (!isset($recent_products)){
				//If it is the first time a product is loaded the array needs to be initialized so as not to bring all existing products
				$recent_products = array("");
			}
			$lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
			$data['lastLoadedProductsGrid'] = $lastloadedProducts;
			$data['productCancelled'] = "Cancelled";
			$this->productLoadView($data);
   		} else {
   			if ($this->form_validation->run()) {

	   			$insert = array();
	   			$insert['name'] = $this->input->post("productName");
				$insert['description'] = $this->input->post("productDesc");
				$insert['prescription'] = $this->input->post("productPresc");
				$insert['code'] = $this->input->post("productCode");
				$insert['category_id'] = $this->input->post("categoryID");
				$insert['tax'] = $this->input->post("productVAT");
				$insert['price'] = $this->input->post("productPrice");
				$insert['short_desc'] = $this->input->post("categoryTree"); 
				if (!$editProduct){
					$role_id = $this->session->userdata("role_id");
					$new_id = $this->Product_model->getNewId();
					$insert['id']= $new_id;
					$insert['published_date'] = date("Y-m-d H:i:s");
					$integrappCode = "PR".$new_id."C".$this->input->post("categoryID")."P".$role_id;
					$insert['supplier_id'] = $role_id;
					$insert['integrapp_code'] = $integrappCode;
					$insert['status'] = 'active';
					$id = $this->Product_model->saveProduct($insert);
				} else {
					$new_id = $editID;
					$insert['last_update'] = date("Y-m-d H:i:s");
					$id = $this->Product_model->updateProduct($insert, $new_id);

				}

				$product_added = $this->Product_model->getProductById($new_id);
				if ($product_added!=FALSE) {
					$this->User_model->setLoadInfo($userId);
					//if edition it needs to delete all existing attributes in order to save them again (if not it will add them)
					if ($editProduct){
						$this->Product_model->deleteProductAttributes($new_id);	
					}
					
					for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

						$attribute = $this->input->post('attribute'.$i);
						$value = $this->input->post('value'.$i);
						if (isset($attribute) && isset($value) && ($value!="") && ($attribute!="")) {
							$this->Product_model->saveProductAttribute($new_id, $attribute, $value);
						}
					}
				
					//Guarda las imagenes en la carpeta del producto (si es una edicion borra las actuales para que no se sumen)
					$this->Product_model->setImagesFolder($editProduct, $this->input->post('images'), $new_id);
					
					//Guarda los colores del producto
					$selectedColors = $this->input->post('selectedColorsArray');
					if (!(isset($selectedColors))) {
						$selectedColors = array();
					}
					$this->Product_model->setProductColors($editProduct, $selectedColors, $new_id);	
					
					//Goes back to the form 
	   				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
	   				if (!$editProduct){
	   					$recent_products[] = $integrappCode; //if it is a new saved product it gets loaded in the last loaded products grid
	   				}
					$lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
					$data['lastLoadedProductsGrid'] = $lastloadedProducts;
					$data['productLoaded'] = "Loaded";
					$this->productLoadView($data);

				} else {
					log_message('error', 'Controller: Product Function: saveProduct - The product was not inserted in DB', false);
					$data['error'] = 'Ha ocurrido un error al guardar, por favor intente más tarde';
					$this->productLoadView($data);
				}
	   		}else{
	   			$this->session->set_flashdata('error', "Hay datos mal ingresados. Más abajo se indica el error sobre cada campo.");
				for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

					$attribute_name = $this->input->post('attribute'.$i);
					$attribute_value = $this->input->post('value'.$i);
					if (($attribute_name != null) or ($attribute_name != "")){
						$attribute = new stdClass();
						$attribute->attribute_name = $attribute_name;
						$attribute->attribute_value = $attribute_value;
						$attributes[] = $attribute;
					}

				}		
				if (isset($attributes)){
					$data['attributes'] = $attributes;
				}   			
	   			$data['images'] = $this->input->post('images');
				$productColors = $this->input->post('selectedColorsArray');
	   			if (isset($productColors)){
	   				$colors = array();
		   			foreach ($productColors as $color) {
		   				$colorObject = new stdClass();
		   				$colorObject->color = $color;
		   				$colors[] = $colorObject;
		   			}
		   			$data['colors'] = $colors;
		   		}
				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
				if (!isset($recent_products)){
					//If it is the first time a product is loaded the array needs to be initialized so as not to bring all existing products
					$recent_products = array("");
				}
				$lastLoadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
				$data['lastLoadedProductsGrid'] = $lastLoadedProducts;
				$this->productLoadView($data);
	   		}

   		}
	   		
	}

	public function editProduct(){
		$editionProduct[] = $this->input->post("editionIntegrapCode");
		$product = $this->Product_model->getProductsByIntegrappCode($editionProduct);
		if (count($product)>0){
			$colors = $this->Product_model->getProductColors($product[0]->id);
			$attributes = $this->Product_model->getProductAttributes($product[0]->id);
			$productImages = $this->Product_model->getProductImages($product[0]->id);

			$data['editProduct'] = $product[0];
			$data['editProduct']->colors = $colors;
			$data['editProduct']->images = $productImages;
			$data['editProduct']->attributes = $attributes;
			if (count($productImages)>0) {
				if ($productImages[0]!= PRODUCT_NO_FOTO) {
					$data['editProduct']->hasImages = true;
				} else {
					$data['editProduct']->hasImages = false;	
				}
			} else {
				$data['editProduct']->hasImages = false;
			}
			echo json_encode($data);
		}
	}

	public function editCatalogProduct($productId){
		$product = $this->Product_model->getProductById($productId);
		if (count($product)>0){
			$colors = $this->Product_model->getProductColors($product->id);
			$attributes = $this->Product_model->getProductAttributes($product->id);
			$productImages = $this->Product_model->getProductImages($product->id);
			$category = $this->Category_model->getCategoryRecord($product->category_id);

			$data['editProduct'] = $product;
			$data['colors'] = $colors;
			if (count($productImages)>0){
				if ($productImages[0] != PRODUCT_NO_FOTO){
					$data['images'] = $productImages;
				}
			}
			$data['attributes'] = $attributes;
			$data['editProduct']->category = $category[0];
			
			//Goes back to the form 
			// $recent_products = $this->input->post('recentlyAddedIntegrappCode');
			// if (!(isset($recent_products)))  $recent_products = array();
			// $recent_products[] = $product->integrapp_code;
			// $lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
			// $data['lastLoadedProductsGrid'] = $lastloadedProducts;
			$this->productLoadView($data);
		}
	}

	public function deleteProduct(){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$userId = $this->session->userdata("id");
			if ($role == 'supplier'){
				$deletionProduct = $this->input->post("deletionIntegrapCode");
				if ($this->Product_model->deleteProductByIntegrappCode($deletionProduct)){
					$data['deletionProduct'] = $deletionProduct;
					$this->User_model->setLoadInfo($userId);
					echo json_encode($data);
				}				
			}
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function viewProduct($productId){
		$product = $this->Product_model->getProductById($productId);
		//$supplier = $this->Supplier_model->getSupplierById($product->supplier_id);
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
		} else {
			//redirect(TIMEOUT_REDIRECT);
		}
		$productImages = $this->Product_model->getProductImages($productId);
		$colors = $this->Product_model->getProductColors($productId);
		$attributes = $this->Product_model->getProductAttributes($productId);
		$branch = $this->Category_model->getCategoryBranchIds($product->category_id);
		if (isset($role)){
			if (($product->supplier_id == $roleId) and ($role=='supplier')) {
				$product->mine = true;
				$this->Product_model->addProductPublishingCost($product);
			} else {
				$product->mine = false;
			}
			if ($role == 'supplier') {
				$product->primarySupplier = $this->Supplier_model->getPrimarySuppliersForProduct($productId);
				$product->secondarySuppliers = $this->Supplier_model->getSecondarySuppliersForProduct($productId);
				$product->primarySupplier->associationStatus = $this->Supplier_model->isSupplierSupplierAssociation($product->supplier_id, $roleId);
				$product->primarySupplier->associationDiscount = $this->Supplier_model->getToSupplierDiscount($product->supplier_id, $roleId);
				$product->isCatalogItem = $this->Supplier_model->isSecondarySupplierForProduct($productId, $roleId);
			} else if ($role == 'distributor') {
				$product->primarySupplier = $this->Supplier_model->getPrimarySuppliersForProduct($productId,$roleId);
				$product->secondarySuppliers = $this->Supplier_model->getSecondarySuppliersForProduct($productId, $roleId);
				$product->primarySupplier->associationStatus = $this->Supplier_model->isDistributorAssociationActive($roleId, $product->supplier_id);
				$product->primarySupplier->associationDiscount = $this->Supplier_model->getAssociationDiscountForDistributor($roleId, $product->supplier_id);
				$product->isCatalogItem = $this->Distributor_model->isCatalogItem($roleId, $productId);	
			}
			$data['watchingRole'] = $role;
		} else {
			$product->mine = false;	
			$data['watchingRole'] = 'pacient';
		}
		$data['product'] = $product;
		//$data['product']->supplier = $supplier;
		$data['product']->images = $productImages;
		$data['product']->branch = $branch;
		$data['product']->colors = $colors;
		$data['product']->attributes = $attributes;
		$data['distributorLocations'] = $this->getDistributorLocations($productId);
		$data['googleMapsScripts'] = true;
		$data['locatePointsScripts'] = true;
		$this->routedHome($data, 'templates/product/product', true);
	}

	public function getDistributorLocations($productId){
		$distributors = $this->Product_model->getProductDistributors($productId);
		$locations = array();
		foreach ($distributors as $key => $distributor) {
			if ((isset($distributor->latLocation)) and (isset($distributor->longLocation))) {
				$location = array();
				$location['lat'] = $distributor->latLocation;
				$location['lng'] = $distributor->longLocation;
				$location['title'] = $distributor->fake_name;
				$location['description'] = $distributor->service_description;
				$location['email'] = $distributor->comercial_email;
				$location['phone'] = $distributor->contact_phone;
				$location['address'] = $distributor->commercial_address;
				$location['workingHours'] = $distributor->working_hours;
				$location['img'] = base_url() . ((isset($distributor->logo))? $distributor->logo: IMAGES_PATH . 'noProfilePic.jpg');
				$location['link'] = base_url() . "distributors/viewDistributor/" . $distributor->id;
				$location['bg-color'] = "#ffff88";
				$location['icon-point'] = base_url() . IMAGES_PATH . "location.png";
				$locations[] = $location;		
			}
		}
		if (count($locations)==0){
			$location = array();
			$location['lat'] = -34.60697760000000;
			$location['lng'] = -58.39412620000002;
			$location['title'] = "";
			$location['description'] = "Ninguno de los Ortopedistas inscriptos en esta página distribuyen este producto. Puede solicitar a su ortopedista de confianza que obtenga dicho producto, disculpe los inconvenientes.";
			$location['email'] = "";
			$location['phone'] = "";
			$location['workingHours'] = "";
			$location['img'] = base_url() . IMAGES_PATH . "example.png";
			$location['link'] = "#";
			$location['bg-color'] = "#ff5555";
			$location['icon-point'] = base_url() . IMAGES_PATH . "location.png";
			$locations[] = $location;		
		}
		return $locations;
		
	}

	public function setResultMessage($editionSuccess, $status){
		if ($editionSuccess) {
			if ($status == 'published') { 
				$this->session->set_flashdata('success', "Se há publicado el producto con éxito.");
			} else if ($status == 'active') {
				$this->session->set_flashdata('success', "Se há despublicado el producto con éxito. El mismo se encuentra entre los productos activos.");
			} else if ($status == 'inactive') {
				$this->session->set_flashdata('success', "Se há eliminado el producto con éxito.");
			}
		} else {
			$this->session->set_flashdata('error', "No se há logrado modificar el estado del producto. Pruebe ms tarde.");
		}
	}

	public function publishProduct($productId){
		if ($this->session->has_userdata('role')){
			$userId = $this->session->userdata('id');
			$credit = $this->Credit_model->getLatestBalance($userId);
			$cost = $this->Product_model->getPublishingCost($productId);
			$restCredit = $credit - $cost;
			log_message('info',"COST: " . -$cost,false);
			$product = $this->Product_model->getProductById($productId);
			if (($restCredit) > LEAST_CREDIT_AMOUNT) {
				$description = 'PRODUCTO PÚBLICADO: ' . $product->name . ' (id: ' . $product->id . ')';
				$this->Credit_model->addTransaction($userId, -$cost, $description);
				$this->setProductStatus($productId, 'published');	
				$this->session->set_flashdata('success', "Se há publicado el producto con éxito. Su crédito restante es de $" . $restCredit );
			} else{
				$this->session->set_flashdata('error', "Su crédito no es suficiente para publicar el producto. Su crédito restante es de $" . $credit );
			}
			redirect('Product/orderMySupplierCatalogBy/' . DEFAULT_CATALOG_ORDER);
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function activateProduct($productId){
		$result = $this->setProductStatus($productId, 'active');
		if ($result){
			$this->session->set_flashdata('success', "El producto actualmente esta en la lista de activos");
		} else {
			$this->session->set_flashdata('error', "Hubo un error al intentar activar el producto, intente más tarde o comuniquese con el administrador");
		}
		redirect('Product/orderMySupplierCatalogBy/' . DEFAULT_CATALOG_ORDER);
	}

	public function deactivateProduct($productId){
		$result = $this->setProductStatus($productId, 'inactive');
		if ($result){
			$this->session->set_flashdata('success', "Se há eliminado el producto con éxito");
		} else {
			$this->session->set_flashdata('error', "Hubo un error al intentar eliminar el producto, intente más tarde o comuniquese con el administrador");
		}
		redirect('Product/orderMySupplierCatalogBy/' . DEFAULT_CATALOG_ORDER);
	}

	private function setProductStatus($productId, $status){
		$result = false;
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$userId = $this->session->userdata("id");
			if ($role == 'supplier'){
				$update = array();
				$update['status'] = $status;
				if ($status=='published') $update['published_date'] = date("Y-m-d H:i:s");
				$result = $this->Product_model->updateProduct($update, $productId);
				$this->User_model->setLoadInfo($userId);
			}
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
		return $result;
	}

	public function addProductToDistributorCatalog($productId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			if ($role == 'distributor') {
				if ($this->Distributor_model->addProductToCatalog($roleId, $productId)!=false){
					$this->session->set_flashdata('success', "Se há agregado el producto a su catálogo con éxito.");	
				} else {
					$this->session->set_flashdata('error', "No se há podido agregar el producto a su catálogo ya que no esta asociado con el distribuidor.");	
				}
				
			}	
			if ($this->session->userdata('catalogView') == 'viewSupplierCatalog') {
				redirect('Suppliers/viewSupplierCatalog/'.DEFAULT_CATALOG_ORDER);
			} else {
				redirect('Product/products');
			}
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function removeProductFromDistributorCatalog($productId){
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			if ($role == 'distributor') {
				$this->Distributor_model->removeProductFromCatalog($roleId, $productId);
				$this->session->set_flashdata('success', "Se há eliminado el producto de su catálogo con éxito.");
			}
			if (($this->session->has_userdata('catalogView')) and ($this->session->userdata('catalogView') == 'viewMyCatalog')) {
				redirect('Product/myProducts');
			} else {
				if ($this->session->userdata('catalogView') == 'viewSupplierCatalog') {
					redirect('Suppliers/viewSupplierCatalog/'.DEFAULT_CATALOG_ORDER);
				} else {
					redirect('Product/products');
				}
			}
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function addProductToSupplierCatalog($productId){	
		$newPrice = $this->input->post("productPrice".$productId);	
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			if ($role == 'supplier') {
				$this->Supplier_model->addProductToCatalog($roleId, $productId, $newPrice);
				if ($this->session->userdata('catalogView') == 'viewSupplierCatalog') {
					redirect('Suppliers/viewSupplierCatalog/'.DEFAULT_CATALOG_ORDER);
				} else {
					redirect('Product/products');
				}
			}
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function removeProductFromSupplierCatalog($productId){		
		if ($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
			$roleId = $this->session->userdata("role_id");
			if ($role == 'supplier') {
				if ($this->Supplier_model->removeProductFromCatalog($roleId, $productId) != 0){
					$this->session->set_flashdata('success', "Se há eliminado el producto a su catálogo secundario con éxito.");
				} else {
					$this->session->set_flashdata('error', "No se há podido eliminar el producto a su catálogo secundario ya que no esta asociado con el distribuidor.");	
				}
				if (($this->session->has_userdata('catalogView')) and ($this->session->userdata('catalogView') == 'viewMyCatalog')) {
					redirect('Product/myProducts');
				} else if (($this->session->has_userdata('catalogView')) and ($this->session->userdata('catalogView') == 'viewCatalog')) {
					redirect('Product/products');
				} else if (($this->session->has_userdata('catalogView')) and ($this->session->userdata('catalogView') == 'viewMySecSuppCatalog')) {
					redirect('Product/mySecondaryProducts');
				} else if ($this->session->userdata('catalogView') == 'viewSupplierCatalog') {
					redirect('Suppliers/viewSupplierCatalog/'.DEFAULT_CATALOG_ORDER);
				} else {
					redirect('Product/products');
				}
			}
			
		} else {
			redirect(TIMEOUT_REDIRECT);
		}
	}

	public function productNameCheck(){
		$name = $this->input->post("productName");
		return $this->Product_model->productNameCheck($name);
	}

	public function ProductCodeCheck(){
		$code = $this->input->post("productCode");
		return $this->Product_model->productCodeCheck($code);
	}

	public function productNameCheckForEdition(){
		$name = $this->input->post("productName");
		$id = $this->input->post("editProductID");
		return $this->Product_model->productNameCheckForEdition($name,$id);
	}

	public function ProductCodeCheckForEdition(){
		$code = $this->input->post("productCode");
		$id = $this->input->post("editProductID");
		return $this->Product_model->productCodeCheckForEdition($code,$id);
	}

	public function upload_foto(){
		$filename = md5(date("Y-m-d h:i:s") . microtime());
		$upload_path = '.' . PRODUCT_IMAGES_PATH . "temp/";
		if (!file_exists('.' . PRODUCT_IMAGES_PATH)){
			@mkdir('.' . PRODUCT_IMAGES_PATH);
		}
		if (!file_exists($upload_path)){
			@mkdir($upload_path);
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|png|gif';
		$config['max_size']	= '5000';
		$config['max_width']  = '7000';
		$config['max_height']  = '7000';
		$config['file_name'] = $filename;
		$this->load->library('upload', $config);

		$result = new stdClass();

		if ( ! $this->upload->do_upload())
		{
			$result->error = $this->upload->display_errors();
		}else{
			$result->success = $this->upload->data();
			$this->do_resize($result->success['file_name']);
		}
		echo  json_encode($result);
	}


	public function do_resize($filename)
	{
	    $source_path = '.' . PRODUCT_IMAGES_PATH . "temp/" . $filename;
	    $target_path = '.' . PRODUCT_IMAGES_PATH. 'temp/thumbs/';
	    if (!file_exists($target_path)){
			@mkdir($target_path);
		}
	    $config_manip = array(
	        'image_library' => 'gd2',
	        'source_image' => $source_path,
	        'new_image' => $target_path,
	        'maintain_ratio' => TRUE,
	        'create_thumb' => TRUE,
	        'thumb_marker' => '',
	        'width' => 100,
	        'height' => 100
	    );

	    $this->image_lib->initialize($config_manip);
	    if (!$this->image_lib->resize()) {
	        echo $this->image_lib->display_errors();
	    }
	    // clear //
	    $this->image_lib->clear();
	}


	public function massiveProductUpload($userId){
		$csv = '.' . SUPPLIER_MASSIVE_UPLOAD_PATH. $userId . "/massUpload.csv";
	    $target_path = '.' . SUPPLIER_MASSIVE_UPLOAD_PATH. $userId;
	    if (!file_exists($target_path)){
			$this->session->set_flashdata('error', "No existe carpeta de carga masiva para este usuario.");
		}
		echo $csv;
		$this->processCSVFile($csv);
	}

	public function processCSVFile($csv){
		$fila = 1;
		if (($gestor = fopen($csv, "r")) !== FALSE) {
		    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
		        $numero = count($datos);
		        echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
		        $fila++;
		        for ($c=0; $c < $numero; $c++) {
		            echo $datos[$c] . "<br />\n";
		        }
		    }
		    fclose($gestor);
		}
	}

}


?>