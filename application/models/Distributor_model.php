<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Distributor_model extends CI_Model {


    public function getDistributorByUserId($userid)
    {
        $query = $this->db->get_where('distributor', array("userid"=>$userid));
        if ($query->num_rows() == 1){
            $result = $query->result();
            $result[0]->logo = $this->get_logo($result[0]->userid);      
            return $result[0];
        } else {
            return false;
        }
     }

     public function getDistributorById($id)
    {
        $query = $this->db->get_where('distributor', array("id"=>$id));
        if ($query->num_rows() == 1){
            return $query->row(0);
        } else {
            return false;
        }
     } 

     public function getApprovedDistributors(){
        $this->db->where('status', 'active');
        $this->db->where('role', 'distributor');
        $query = $this->db->get("user");
        return $query->result();
     }

    public function createSupplierDistributorAssolciation($userId){
        $this->db->where('userid', $userId);
        $query = $this->db->get('distributor');
        $distributor = $query->result();

        $query = $this->db->get('supplier');
        $suppliers = $query->result();
        foreach ($suppliers as $key => $supplierRecord) {
            $insert = array();
            $insert['supplier_id'] = $supplierRecord->id;
            $insert['distributor_id'] = $distributor[0]->id;
            $insert['status'] = 'pending';
            $insert['discount'] = 0;
            $this->db->insert('supplier_distributor_association', $insert);           
        }
    }

    public function setSupplierDistributorStatus($supplierId, $distributorId, $status){
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('distributor_id', $distributorId);
        $this->db->set('status',$status);
        $this->db->update('supplier_distributor_association'); 
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }

    public function setSupplierDistributorDiscount($supplierId, $distributorId, $discount){
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('distributor_id', $distributorId);
        $this->db->set('discount',$discount);
        $this->db->update('supplier_distributor_association'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;    
        } 
    }

    public function save($userid, $data){
        $this->db->where('userid', $userid);
        return $this->db->update('distributor', $data);
    }

    public function isDistributorCatalogItemForCatalog($distributorId, &$catalog){
        for ($i=0; $i < count($catalog); $i++) { 
            $catalog[$i]->isCatalogItem = $this->isCatalogItem($distributorId, $catalog[$i]->id);
        }
    }

    public function isCatalogItem($distributorId, $productId){
        $this->db->where('product_id', $productId);
        $this->db->where('distributor_id', $distributorId);
        $query = $this->db->get('distributor_catalog');
        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }

    }

    public function addProductToCatalog($distributorId, $productId){
        $product = $this->Product_model->getProductById($productId);
        if ($this->Supplier_model->isDistributorAssociationActive($distributorId, $product->supplier_id)){
            $this->db->set('distributor_id', $distributorId);
            $this->db->set('product_id', $productId);
            $this->db->insert('distributor_catalog'); 
            return true;   
        } else {
            return false;
        }
    }

    public function removeProductFromCatalog($distributorId, $productId){
        $this->db->where('distributor_id', $distributorId);
        $this->db->where('product_id', $productId);
        $this->db->delete('distributor_catalog');   
    }

    public function get_completeness($userid){

        $distributor = $this->getDistributorByUserId($userid);
        $amountCompleted = 0;
        $steps = array();
        $steps['registered'] = true;
        $steps['service_description'] = ($distributor->service_description != "");
        $steps['commercial_address'] = ($distributor->commercial_address != "");
        $steps['comercial_email'] = ($distributor->comercial_email != "");
        $steps['fiscal_address'] = ($distributor->fiscal_address != "");
        $steps['cuit'] = ($distributor->cuit != "");        
        $steps['razon_social'] = ($distributor->razon_social != "");
        $steps['fake_name'] = ($distributor->fake_name != "");
        //$steps['latLocation'] = ($distributor->latLocation != "");
        //$steps['longLocation'] = ($distributor->longLocation != "");
        //$steps['bannk_account'] = ($distributor->bank_account != "");
        //$steps['cbu'] = ($distributor->cbu != "");
        //$steps['bank_name'] = ($distributor->bank_name != "");
        //$steps['bank_branch'] = ($distributor->bank_branch != "");
        //$steps['bank_account_name'] = ($distributor->bank_account_name != "");
        $steps['logo'] = ($this->get_logo($userid) != null);
        foreach($steps as $key=>$step){
            if($step != false){
                $amountCompleted++;
            }
        }
        $porcentaje = ($amountCompleted*100)/count($steps);
        return round($porcentaje, 0);

    }

    public function save_logo($id){
        $upload_path = '.' . DISTRIBUTOR_PROFILE_IMAGE_PATH;
        if (!file_exists($upload_path)){
            @mkdir($upload_path);
        }
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = ALLOWED_PROFILE_IMAGE_TYPE;
        $config['max_size'] = ALLOWED_PROFILE_IMAGE_MAXSIZE;
        $config['max_width']  = ALLOWED_PROFILE_IMAGE_MAXWIDTH;
        $config['max_height']  = ALLOWED_PROFILE_IMAGE_MAXHEIGHT;
        $config['file_name']  = md5($id);
        $config['overwrite']  = true;
        $this->load->library('upload', $config);
        return $this->upload->do_upload();
    }


    public function get_logo($userid){
        $path = '.' . DISTRIBUTOR_PROFILE_IMAGE_PATH;
        $url_path = DISTRIBUTOR_PROFILE_IMAGE_PATH;
        $filename = $path . md5($userid) . ".png";
        if(file_exists($filename)){
            return $url_path . md5($userid) . ".png";
        }else{
            return IMAGES_PATH . 'noProfilePic.jpg';
        }
        
    }

    public function notExistFakename($fake_name){
        $this->db->where('fake_name', $fake_name);
        $query = $this->db->get('distributor');
        if ($query->num_rows()==0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function get_catalog($distributorId, $parentCategoryId = null, $orderBy = null, $page = 1, $rangePerPage = 1000, &$totalRows){
        $whereCategoryIn = "";
        //Category ID needs to be fetched first to avoid where clauses errors
        if (isset($parentCategoryId) and ($parentCategoryId != 0)){
            $leafCategories = array();
            $this->Product_model->getLeafCategories($leafCategories, $parentCategoryId);
            if (count($leafCategories)>0){
                $whereCategoryIn = "AND category_id IN ( ";
                for ($i=0; $i < count($leafCategories); $i++) {
                    $whereCategoryIn = $whereCategoryIn . $leafCategories[$i];
                    if ($i <count($leafCategories)-1){
                        $whereCategoryIn = $whereCategoryIn . ",";
                    }
                }
                $whereCategoryIn = $whereCategoryIn . ")";
            }
            
        }
        //El primer select es para elegir los productos de los mayoristas asociados al minorista
        //El segundo select es para elegir los productos de los mayoristas asociados a otro mayorista que a la vez esta asociado con el minorista
        $queryScript = 
        "SELECT DISTINCT result.* FROM (
            SELECT product.*
            FROM product
            INNER JOIN supplier ON product.supplier_id = supplier.id
            INNER JOIN user ON supplier.userid = user.id
            INNER JOIN distributor_catalog ON distributor_catalog.product_id = product.id
            INNER JOIN supplier_distributor_association ON supplier_distributor_association.supplier_id = product.supplier_id
            WHERE supplier_distributor_association.distributor_id = $distributorId
            AND supplier_distributor_association.status = 'approved'
            AND distributor_catalog.distributor_id = $distributorId
            AND user.status = 'active'
            AND product.status = 'published'
            $whereCategoryIn
            UNION
            SELECT  product.*
            FROM product
            INNER JOIN distributor_catalog ON distributor_catalog.product_id = product.id
            INNER JOIN secondary_supplier_catalog on secondary_supplier_catalog.product_id = product.id 
            INNER JOIN supplier ON secondary_supplier_catalog.supplier_id = supplier.id
            INNER JOIN user ON supplier.userid = user.id
            INNER JOIN supplier_distributor_association ON supplier_distributor_association.supplier_id = secondary_supplier_catalog.supplier_id
            WHERE supplier_distributor_association.distributor_id = $distributorId
            AND supplier_distributor_association.status = 'approved'
            AND distributor_catalog.distributor_id = $distributorId
            AND user.status = 'active'
            AND product.status = 'published'
            $whereCategoryIn
        ) result
        ORDER BY $orderBy"; 

        $from =  ($page-1) * $rangePerPage;
        $query = $this->db->query($queryScript);
        $result = $query->result();
        $totalRows = count($result);
        $j = 0;
        $finalResult = array();
        for ($i= (($page-1)*$rangePerPage); $i< (((($page)*$rangePerPage) < count($result))? ($page*$rangePerPage): count($result)); $i++){
            $result[$i]->images = $this->Product_model->getProductImages($result[$i]->id);
            $finalResult[$j] = $result[$i];
            $j++;
        }
        return $finalResult;
    }

}

