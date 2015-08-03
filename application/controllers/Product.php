<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->pagination_uri_segment = 4;
		$this->categoryLevelsAmount = 5;
	}
	
	public function product_view($data=NULL, $orderBy='category_id', $myCatalog='false'){
		$role = $this->session->userdata("role");
		if ($myCatalog=='true'){
			$data['viewMyCatalog'] = true;
		}
		$data['loadCategory']= $this->Product_model->getCategory();
		$data['orderBy'] = $orderBy;
		$this->routedHome($role, $data);
	}

	//New Test functions
	public function productLoadView($data=NULL, $orderBy='category_id'){
		$role = $this->session->userdata("role");
		$data['productLoadView'] = true;
		$data['Catalog'] = array();
		$data['loadCategory']= $this->Product_model->getCategory();
		$this->tabbedRoutedHome($data, 'product_load');
	}

	//New Test functions
	public function tabbedRoutedHome($data = null, $tab){
		if($this->session->has_userdata('role')){
			$role = $this->session->userdata("role");
		} else {
			redirect('Login/Logout');
			die;
		}
		$this->load->view('templates/template_header');
		$this->load->view('templates/template_nav');
		$this->load->view('navs/nav_'.$this->session->userdata("role"));
		$this->load->view($role.'/product/product_tabs_top', $data);
		$this->load->view($role.'/product/' . $tab, $data);
		$this->load->view($role.'/product/product_tabs_bottom', $data);
		$this->load->view('templates/template_footer');
	}

	public function setPagination($url, $totalRows){	
		$config = array();
		$config["base_url"] = $url;
		$config["total_rows"] = $totalRows;
		$config['uri_segment'] = $this->pagination_uri_segment;
		$config["per_page"] = PROD_MAX_PAGE_AMOUNT;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 1;
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
			log_message('info', "null. ".$selectedCategoryId, false);
			if ($this->session->has_userdata('selectedCategoryId')){
				$selectedCategoryId = $this->session->userdata('selectedCategoryId');
			}
		} else {
			$this->session->set_userdata('selectedCategoryId', $selectedCategoryId);
		}
		return $selectedCategoryId;
	}

	public function orderCatalogBy ($orderBy){
		$url = base_url() . "Product/orderCatalogBy/$orderBy";
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->getCategoryBranch($selectedCategoryId);
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;
		$data['childCategories'] = $this->Product_model->getCategory($selectedCategoryId); 
		if($this->uri->segment($this->pagination_uri_segment)){
			$page = ($this->uri->segment($this->pagination_uri_segment)) ;
		}else{
			$page = 1;
		}
		$totalRows = 0;
		$data['Catalog'] = $this->Product_model->get_catalog(null, $orderBy, $page, PROD_MAX_PAGE_AMOUNT, $selectedCategoryId, $totalRows);
		$this->setPagination($url, $totalRows);
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		log_message('info',"Pagination: ".$str_links . "total rows: " . $totalRows,false);
		$role = $this->session->userdata("role");
		$data['orderBy'] = $orderBy;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data,$tab);
	}

	public function orderMyCatalogBy ($orderBy){
		$role_id = $this->session->userdata('role_id');
		$url = base_url() . "Product/orderCatalogBy/$orderBy";
		$selectedCategoryId = $this->getCategoryFilter();
		$branch = $this->getCategoryBranch($selectedCategoryId);
		$data['selectedCategoryId'] = $selectedCategoryId;
		$data['branch'] = $branch;
		$data['childCategories'] = $this->Product_model->getCategory($selectedCategoryId); 
		if($this->uri->segment($this->pagination_uri_segment)){
			$page = ($this->uri->segment($this->pagination_uri_segment)) ;
		}else{
			$page = 1;
		}
		$totalRows = 0;
		$data['Catalog'] = $this->Product_model->get_catalog($role_id, $orderBy, $page, PROD_MAX_PAGE_AMOUNT, $selectedCategoryId, $totalRows);
		$this->setPagination($url, $totalRows);
		
		$str_links = $this->pagination->create_links();
		$data["pageLinks"] = explode('&nbsp;',$str_links );
		log_message('info',"Pagination: ".$str_links . "total rows: " . $totalRows,false);
		$data['viewMyCatalog'] = true;
		$role = $this->session->userdata("role");
		$data['orderBy'] = $orderBy;
		$tab = 'product_catalog';
		$this->tabbedRoutedHome($data, $tab);
	}

	public function getCategoryBranch($selectedCategoryId){
		$categoriesArray = array();
		if (isset($selectedCategoryId)){
				$this->Product_model->getCategoryBranch($selectedCategoryId, $categoriesArray);	
		}
		return $categoriesArray;
	}

	public function getCategories($id=NULL){
		if (isset($id)) {
			$data['NextCategory'] = $this->Product_model->getCategory($id);
			echo json_encode($data);
			die();
		}else{
			$data['category'] = $this->Product_model->getCategory();
		}

	}

	public function getTree($id=NULL){
			$data['tree'] = $this->Product_model->getTree($id);
			echo json_encode($data) ;
	}


	public function saveProduct(){
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
	   		$this->form_validation->set_rules('productDesc', 'Descripcion', 'required|min_length[' . PROD_DESCRIPTION_MIN_LENGTH . ']|max_length[' . PROD_DESCRIPTION_MAX_LENGTH . ']');
	   		
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
				$this->product_view($data);
	   		} else {
	   			if ($this->form_validation->run()) {

		   			$insert = array();
		   			$insert['name'] = $this->input->post("productName");
					$insert['description'] = $this->input->post("productDesc");
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
						$id = $this->Product_model->saveProduct($insert);
					} else {
						$new_id = $editID;
						$insert['last_update'] = date("Y-m-d H:i:s");
						$id = $this->Product_model->updateProduct($insert, $new_id);

					}

					$product_added = $this->Product_model->getProductById($new_id);
					if ($product_added!=FALSE) {
						//if edition it needs to delete all existing attributes in order to save them again (if not it will add them)
						if ($editProduct){
							$this->Product_model->deleteProductAttributes($new_id);	
						}
						
						for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

							$attribute = $this->input->post('attribute'.$i);
							$value = $this->input->post('value'.$i);
							if (isset($attribute) && isset($value)) {
								$this->Product_model->saveProductAttribute($new_id, $attribute, $value);
							}
						}
					
						//Guarda las imagenes en la carpeta del producto (si es una edicion borra las actuales para que no se sumen)
						$this->Product_model->setImagesFolder($editProduct, $this->input->post('imagen'), $new_id);
						
						//Guarda los colores del producto
						$selectedColors = $this->input->post('selectedColorsArray');
						if(isset($selectedColors)){
							$this->Product_model->setProductColors($editProduct, $selectedColors, $new_id);	
						}
						
						//Goes back to the form 
		   				$recent_products = $this->input->post('recentlyAddedIntegrappCode');
		   				if (!$editProduct){
		   					$recent_products[] = $integrappCode; //if it is a new saved product it gets loaded in the last loaded products grid
		   				}
						$lastloadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
						$data['lastLoadedProductsGrid'] = $lastloadedProducts;
						$data['productLoaded'] = "Loaded";
						$this->product_view($data);

					} else {
						log_message('error', 'Controller: Product Function: saveProduct - The product was not inserted in DB', false);
						$data['error'] = 'Ha ocurrido un error al guardar, por favor intente más tarde';
						$this->product_view($data);
					}
		   		}else{
					for ($i=0; $i < MAX_ATTRIBUTE_AMOUNT ; $i++) { 

						$attribute_name = $this->input->post('attribute'.$i);
						$attribute_value = $this->input->post('value'.$i);
						if (($attribute_name != null) or ($attribute_name != "")){
							$attribute = new stdClass();
							$attribute->name = $attribute_name;
							$attribute->value = $attribute_value;
							$attributes[] = $attribute;
						}

					}		
					if (isset($attributes)){
						$data['attributes'] = $attributes;
					}   			
		   			$data['imagen'] = $this->input->post('imagen');
					$productColors = $this->input->post('selectedColorsArray');
		   			$data['colors'] = $productColors;
					$recent_products = $this->input->post('recentlyAddedIntegrappCode');
					if (!isset($recent_products)){
						//If it is the first time a product is loaded the array needs to be initialized so as not to bring all existing products
						$recent_products = array("");
					}
					$lastLoadedProducts = $this->Product_model->getProductsByIntegrappCode($recent_products);
					$data['lastLoadedProductsGrid'] = $lastLoadedProducts;
					if ($editProduct){
						$data['editProductID'] = $editID;
					}
					$this->product_view($data);
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
			echo json_encode($data);
		}
	}

	public function deleteProduct(){
		$deletionProduct = $this->input->post("deletionIntegrapCode");
		if ($this->Product_model->deleteProductByIntegrappCode($deletionProduct)){
			$data['deletionProduct'] = $deletionProduct;
			echo json_encode($data);
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
 


}


?>