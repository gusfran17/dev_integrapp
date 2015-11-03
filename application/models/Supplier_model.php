<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Supplier_model extends CI_Model {

    public function getSupplierByUserId($userId){
        $this->db->where('userid', $userId);
        $query = $this->db->get('supplier');
        if ($query->num_rows() == 1){
            $result = $query->result();
            $result[0]->logo = $this->get_logo($result[0]->userid);      
            return $result[0];
        } else {
            return false;
        }
    }

    public function getSupplierById($supplierId){
        $this->db->where('id', $supplierId);
        $query = $this->db->get('supplier');
        if ($query->num_rows() == 1){
            $result = $query->result();
            $result[0]->logo = $this->get_logo($result[0]->userid);           
            return $result[0];
        } else {
            return false;
        }
    }

    public function getPendingSuppliers(){
        $this->db->where('status', 'pending');
        $this->db->where('role', 'supplier');
        $query = $this->db->get("user");
        return $query->result();
    }

    public function getApprovedSuppliers(){
        $this->db->where('status', 'active');
        $this->db->where('role', 'supplier');
        $query = $this->db->get("user");
        return $query->result();
    }

    public function createSupplierDistributorAssolciation($userId){
        $this->db->where('userid', $userId);
        $query = $this->db->get('supplier');
        $supplier = $query->result();

        $query = $this->db->get('distributor');
        $distributors = $query->result();
        foreach ($distributors as $key => $distributorRecord) {
            $insert = array();
            $insert['distributor_id'] = $distributorRecord->id;
            $insert['supplier_id'] = $supplier[0]->id;
            $insert['status'] = 'pending';
            $insert['discount'] = 0;
            $this->db->insert('supplier_distributor_association', $insert);           
        }
    }

    public function getSuppliersForSupplier($exceptSupplierId){
        $suppliers = $this->getAllSuppliers($exceptSupplierId);
        $this->setSuppliersAssociationDetalisForSupplier($exceptSupplierId, $suppliers);
        return $suppliers;
    }

    public function getAssociatedSupplierIdsForSupplier($roleId){
        $sql =  "select ssa1.* ".
                "from supplier_supplier_association ssa1, ".
                "supplier_supplier_association ssa2 ".
                "where ssa1.from_supplier_id = ssa2.to_supplier_id ".
                "and ssa2.from_supplier_id = ssa1.to_supplier_id ".
                "and ssa1.from_supplier_id = $roleId";
        $query = $this->db->query($sql);
        $associatedSuppliers = $query->result();
        $associatedIds = array();
        foreach ($associatedSuppliers as $key => $associatedSupplier) {
            $associatedIds[] = $associatedSupplier->to_supplier_id;
        }
        return $associatedIds;
    }

    public function setSuppliersAssociationDetalisForSupplier($supplierId, &$suppliers) {
        foreach ($suppliers as $key => $supplier) {
            $suppliers[$key]->supplierSuplierAssociationStatus = "none";
            $suppliers[$key]->toSupplierDiscount = 0;
        }
        $this->db->from('supplier_supplier_association');
        $this->db->where('supplier_supplier_association.to_supplier_id', $supplierId);
        $query = $this->db->get();
        $receivedRequests = $query->result();
        foreach ($receivedRequests as $rquestkey => $receivedResquest) {
            foreach ($suppliers as $supplierkey => $supplier) {
                if ($supplier->id == $receivedResquest->from_supplier_id){
                    $suppliers[$supplierkey]->supplierSuplierAssociationStatus = "received";
                }
            }
        }
        $this->db->from('supplier_supplier_association');
        $this->db->where('supplier_supplier_association.from_supplier_id', $supplierId);
        $query = $this->db->get();
        $sentRequests = $query->result();
        foreach ($sentRequests as $rquestkey => $sentRequest) {
            foreach ($suppliers as $supplierkey => $supplier) {
                if ($supplier->id == $sentRequest->to_supplier_id){
                    if ($supplier->supplierSuplierAssociationStatus == "received"){
                        $suppliers[$supplierkey]->supplierSuplierAssociationStatus = "associated";
                        $suppliers[$supplierkey]->toSuplierDiscount = $sentRequest->to_supplier_discount;
                    } else {
                        $suppliers[$supplierkey]->supplierSuplierAssociationStatus = "sent";
                    }
                }
            }
        }
    }

    public function sendSupplierSupplierRequest($fromSupplierId, $toSupplierId){
        $this->db->set('supplier_supplier_association.from_supplier_id', $fromSupplierId);
        $this->db->set('supplier_supplier_association.to_supplier_id', $toSupplierId);
        $this->db->set('supplier_supplier_association.to_supplier_discount', 0);
        $this->db->insert('supplier_supplier_association');
        return $this->db->insert_id();
    }

    public function cancelSupplierSupplierRequest($fromSupplierId, $toSupplierId){
        $this->db->where('supplier_supplier_association.from_supplier_id', $fromSupplierId);
        $this->db->where('supplier_supplier_association.to_supplier_id', $toSupplierId);
        $this->db->delete('supplier_supplier_association');
        if ($this->db->affected_rows()!=0){
            $this->db->where('secondary_supplier_catalog.supplier_id', $fromSupplierId);
            $this->db->delete('secondary_supplier_catalog');
            $this->db->where('secondary_supplier_catalog.supplier_id', $toSupplierId);
            $this->db->delete('secondary_supplier_catalog');
            if ($this->db->affected_rows()!=0){
                return $this->db->affected_rows();
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    public function setToSupplierDiscount($fromSupplierId, $toSupplierId, $toSupplierDiscount){
        $this->db->where('supplier_supplier_association.from_supplier_id', $fromSupplierId);
        $this->db->where('supplier_supplier_association.to_supplier_id', $toSupplierId);
        $this->db->set('supplier_supplier_association.to_supplier_discount', $toSupplierDiscount);
        $this->db->update('supplier_supplier_association');
        return $this->db->affected_rows();
    }

    public function getToSupplierDiscount($fromSupplierId, $toSupplierId){
        $this->db->where('supplier_supplier_association.from_supplier_id', $fromSupplierId);
        $this->db->where('supplier_supplier_association.to_supplier_id', $toSupplierId);
        $query = $this->db->get('supplier_supplier_association');
        $toSuppResult = $query->result();
        if (count($toSuppResult)>0){
            return $toSuppResult[0]->to_supplier_discount;
        } else {
            return false;
        }
    }

    public function isSupplierSupplierAssociation($supplierOne, $supplierTwo){
        $OneAssociatedSuppsIds = $this->getAssociatedSupplierIdsForSupplier($supplierOne);
        if (count($OneAssociatedSuppsIds>0)){
            $found = false;
            foreach ($OneAssociatedSuppsIds as $key => $id) {
                if ($id==$supplierTwo) {
                    $found = true;
                }
            }
            return $found;
        } else {
            return false;
        }
    }

	function save($userid, $data){
        $this->db->where('userid', $userid);
        return $this->db->update('supplier', $data);
    }


    function get_completeness($userid){
        $supplier = $this->getsupplierByUserId($userid);
        $amountCompleted = 0;
        $steps = array();
        $steps['registered'] = true;
        $steps['service_description'] = ($supplier->service_description != "");
        //$steps['commercial_address'] = ($supplier->commercial_address != "");
        $steps['comercial_email'] = ($supplier->comercial_email != "");
        $steps['fiscal_address'] = ($supplier->fiscal_address != "");
        $steps['cuit'] = ($supplier->cuit != "");        
        $steps['razon_social'] = ($supplier->razon_social != "");
        $steps['fake_name'] = ($supplier->fake_name != "");
        //$steps['latLocation'] = ($supplier->latLocation != "");
        //$steps['longLocation'] = ($supplier->longLocation != "");
        $steps['bannk_account'] = ($supplier->bank_account != "");
        $steps['cbu'] = ($supplier->cbu != "");
        $steps['bank_name'] = ($supplier->bank_name != "");
        $steps['bank_branch'] = ($supplier->bank_branch != "");
        $steps['bank_account_name'] = ($supplier->bank_account_name != "");
        $steps['logo'] = ($this->get_logo($userid) != IMAGES_PATH."noProfilePic.jpg");
        foreach($steps as $key=>$step){
            if($step != false){
                $amountCompleted++;
            }
        }
        $porcentaje = ($amountCompleted*100)/count($steps);
        return round($porcentaje, 0);
    }


    public function save_logo($id){
        $upload_path = '.' . SUPPLIER_PROFILE_IMAGE_PATH;
        if (!file_exists(SUPPLIER_PROFILE_IMAGE_PATH)){
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
        $path = '.' . SUPPLIER_PROFILE_IMAGE_PATH;
        $url_path = SUPPLIER_PROFILE_IMAGE_PATH;
        
        $filename = $path . md5($userid) . ".png";
        if(file_exists($filename)){
            return $url_path . md5($userid) . ".png";
        }else{
            return IMAGES_PATH . 'noProfilePic.jpg';
        }
        
    }

    public function suppliersCount(){
        return $this->db->count_all("supplier");
    }

    public function getSuppliers($page, $rangePerPage){
        $from =  ($page-1) * $rangePerPage;
        $this->db->select('supplier.*');
        $this->db->join('user','user.id = supplier.userid');
        $this->db->where('user.status','active');
        $query = $this->db->get('supplier', $rangePerPage, $from);
        $result = $query->result();
        for ($i=0; $i<count($result); $i++) {
            $result[$i]->logo = $this->get_logo($result[$i]->userid);
        }
        return $result;
    }

    public function getAllSuppliers($exceptSupplierId){
        $this->db->select('supplier.*');
        $this->db->join('user','user.id = supplier.userid');
        $this->db->where('user.status','active');
        $this->db->where('supplier.id <>',$exceptSupplierId);
        $query = $this->db->get('supplier');
        $result = $query->result();
        for ($i=0; $i<count($result); $i++) {
            $result[$i]->logo = $this->get_logo($result[$i]->userid);
        }
        return $result;
    }

    public function notExistFakename($fake_name){
        $this->db->where('fake_name', $fake_name);
        $query = $this->db->get('supplier');
        if ($query->num_rows()==0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getAssociatedDistributors($supplierId, $status = null){
        $this->db->select('distributor.*, supplier_distributor_association.*');
        $this->db->from('distributor');
        $this->db->join('supplier_distributor_association', 'distributor.id = supplier_distributor_association.distributor_id', 'inner');
        $this->db->join('user', 'distributor.userid = user.id', 'inner');
        $this->db->where('supplier_distributor_association.supplier_id', $supplierId);
        $this->db->where('user.status', 'active');
        if (isset($status)){
            $this->db->where('supplier_distributor_association.status', $status);
        }
        $query = $this->db->get();
        $distributors = $query->result();
        for ($i=0; $i<count($distributors); $i++) {
            $distributors[$i]->logo = $this->Distributor_model->get_logo($distributors[$i]->userid);
        }
        return $distributors;
    }

    public function getDistributorAssociationStatus($distributorId, $supplierId){
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('distributor_id', $distributorId);
        $query = $this->db->get('supplier_distributor_association');
        $association = $query->result();
        return $association[0]->status;
    }

    public function isDistributorAssociationActive($distributorId, $supplierId){
        if ($this->getDistributorAssociationStatus($distributorId, $supplierId) == 'approved') {
            return true;
        } else {
            return false;
        }
    }

    public function isDistributorAssociationActiveForProduct($distributorId, $product){
        $isAssociated = false;
        $secSuppliers = $this->getSecondarySuppliersForProduct($product->id, $distributorId);
        foreach ($secSuppliers as $key => $secSupplier) {
            if (isset($secSupplier->price)){
                $isAssociated = true;
            }
        }
        if ($this->getDistributorAssociationStatus($distributorId, $product->supplier_id) == 'approved') {
            $isAssociated = true;
        } 
        return $isAssociated;
    }

    public function getAssociationDiscountForDistributor($distributorId, $supplierId){
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('distributor_id', $distributorId);
        $query = $this->db->get('supplier_distributor_association');
        $association = $query->result();
        return $association[0]->discount;
    }

    public function getSupplierFakeName($supplierId){
        $this->db->where('id', $supplierId);
        $query = $this->db->get('supplier');
        $supplier = $query->result();
        return $supplier[0]->fake_name;
    }

    public function addAssociationDetailsToProductForDistributor($distributorId, &$catalog){
        for ($i=0; $i < count($catalog); $i++) { 
            $catalog[$i]->associationStatus = $this->isDistributorAssociationActiveForProduct($distributorId, $catalog[$i]);
            //$catalog[$i]->associationDiscount = $this->getAssociationDiscountForDistributor($distributorId, $catalog[$i]->supplier_id);
            //$catalog[$i]->supplier_fakename = $this->getSupplierFakeName($catalog[$i]->supplier_id);
            $catalog[$i]->isCatalogItem = $this->Distributor_model->isCatalogItem($distributorId, $catalog[$i]->id);
        }
    }

    public function isSupplierCatalogItemForCatalog($supplierId, &$catalog){
        for ($i=0; $i < count($catalog); $i++) { 
            $catalog[$i]->isCatalogItem = $this->isSecondarySupplierForProduct($catalog[$i]->id, $supplierId);
        }
    }

    public function getSupplierId($userId){
        $this->db->where('userid', $userId);
        $query = $this->db->get('supplier');
        $result = $query->result();
        log_message('info',"USER ID en Supplier_model: ".count($result),false);
        return $result[0]->id;
    }

    public function getProductsAmountByStatus($userId, $status){
        $supplierId = $this->getSupplierId($userId);
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('status', $status);
        $this->db->from('product');
        return $this->db->count_all_results();
    }
    
    public function getPendingDistributorsAmount($userId){
        $supplierId = $this->getSupplierId($userId);
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('status', 'pending');
        $this->db->from('supplier_distributor_association');
        return $this->db->count_all_results();
    }

    public function setSupplierStatus($userId, $status){
        $updateData = array("status"=>$status);
        $this->db->where("id", $userId);
        $this->db->where("role", 'supplier');
        return $this->db->update("user", $updateData);
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function addProductToCatalog($supplierId, $productId, $newPrice){
        $product = $this->Product_model->getProductById($productId);
        if ($product->supplier_id == $supplierId){
            $this->session->set_flashdata('error', "Usted ya es proveedor principal de este producto.");    
            return false;
        }
        $product = $this->Product_model->getProductById($productId);
        if ($this->isSupplierSupplierAssociation($supplierId, $product->supplier_id)){
            $this->db->set('supplier_id', $supplierId);
            $this->db->set('product_id', $productId);
            $this->db->set('price', $newPrice);
            $this->db->insert('secondary_supplier_catalog');
            $this->session->set_flashdata('success', "Se há agregado el producto a su catálogo secundario con éxito.");
            return true;
        } else {
            return false;
            $this->session->set_flashdata('error', "No se há podido agregar el producto a su catálogo secundario ya que no esta asociado con el distribuidor.");    
        }
    }

    public function removeProductFromCatalog($supplierId, $productId){
        $product = $this->Product_model->getProductById($productId);
        if ($this->isSupplierSupplierAssociation($supplierId, $product->supplier_id)){
            if ($this->isSecondarySupplierForProduct($productId,$supplierId)){
                $this->db->where('supplier_id', $supplierId);
                $this->db->where('product_id', $productId);
                $this->db->delete('secondary_supplier_catalog');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function addSuppliersDetailsToProducts(&$catalog, $distributorId=null){
        if (count($catalog)){
            foreach ($catalog as $key => $product) {
                $catalog[$key]->secondarySuppliers = $this->getSecondarySuppliersForProduct($product->id, $distributorId);
                $catalog[$key]->primarySupplier = $this->getSupplierById($product->supplier_id);
                if (isset($distributorId)){
                     if (!$this->isDistributorAssociationActive($distributorId,$product->supplier_id)){
                        unset($catalog[$key]->price);
                    } else {
                        $discount = $this->getAssociationDiscountForDistributor($distributorId, $product->supplier_id);
                        $catalog[$key]->primarySupplier->price = ($catalog[$key]->price - (($catalog[$key]->price*$discount)/100));
                    }   
                }
            }
        }
    }

    public function getSecondarySuppliersForProduct($productId, $distributorId=null){
        $this->db->select('supplier.id, supplier.fake_name, secondary_supplier_catalog.price');
        $this->db->from('supplier');
        $this->db->join('secondary_supplier_catalog', 'secondary_supplier_catalog.supplier_id = supplier.id');
        $this->db->where('secondary_supplier_catalog.product_id', $productId);
        $query = $this->db->get();
        $secondarySuppliers = $query->result();
        foreach ($secondarySuppliers as $SSkey => $secondarySupplier) {
            $secondarySuppliers[$SSkey]->logo = $this->Supplier_model->get_logo($secondarySupplier->id);
            if (isset($distributorId)) {
                if ($this->isDistributorAssociationActive($distributorId,$secondarySupplier->id)) {
                    $discount = $this->getAssociationDiscountForDistributor($distributorId, $secondarySupplier->id);
                    $secondarySuppliers[$SSkey]->price = ($secondarySupplier->price - (($secondarySupplier->price*$discount)/100));
                } else {
                    unset($secondarySuppliers[$SSkey]->price);
                }
                 
            } else {
                unset($secondarySuppliers[$SSkey]->price);
            }
        }
        return $secondarySuppliers;
    }

    public function getPrimarySuppliersForProduct($productId, $distributorId=null){
        $this->db->select('supplier.*, product.price');
        $this->db->from('supplier');
        $this->db->join('product', 'product.supplier_id = supplier.id');
        $this->db->where('product.id', $productId);
        $query = $this->db->get();
        $supplier = $query->result()[0];
        if (isset($distributorId)){
             if ($this->isDistributorAssociationActive($distributorId,$supplier->id)){
                $discount = $this->getAssociationDiscountForDistributor($distributorId, $supplier->id);
                $supplier->price = ($supplier->price - (($supplier->price*$discount)/100));
            } else {
                unset($supplier->price);
            }
        }
        return $supplier;
    }

    public function isSecondarySupplierForProduct($productId, $supplierId){
        $this->db->from('secondary_supplier_catalog');
        $this->db->where('secondary_supplier_catalog.product_id', $productId);
        $this->db->where('secondary_supplier_catalog.supplier_id', $supplierId);

        $query = $this->db->get();
        if ($query->num_rows()>0) {
            //log_message('info',"TRUE PROD: ".$productId." SUPP: ".$supplierId, false);
            return TRUE;
        }else{
            //log_message('info',"FALSE PROD: ".$productId." SUPP: ".$supplierId, false);
            return FALSE;
        }

    }

    public function addSuppliersAssociationToProducts(&$catalog, $supplierId){
        foreach ($catalog as $key => $product) {
            $this->addSuppliersAssociationToProduct($catalog[$key], $supplierId);
        }
    }

    public function addSuppliersAssociationToProduct(&$product, $supplierId){
        $associatedIds = $this->getAssociatedSupplierIdsForSupplier($supplierId);
        $associatedIds[] = $associatedIds[0];   
        unset($associatedIds[0]);
        if (array_search($product->supplier_id, $associatedIds) != false){
            $product->isSupplierAssociated = true;
            $product->supplierAssociationDiscount = $this->getToSupplierDiscount($product->supplier_id, $supplierId);
            $product->isSecSupplierCatalogItem = $this->isSecondarySupplierForProduct($product->id, $supplierId);
            //log_message('info', "SUCCESS Associated Suppliers for supplier ".$supplierId." with ".count($associatedIds)." suppliers in list. Product: ". $product->id . " Product Suppier: " . $product->supplier_id,false);
        } else {
            $product->isSupplierAssociated = false;
            //log_message('info', "ERROR Associated Suppliers for ".$supplierId." with ".count($associatedIds)." suppliers in list. Product: ".$product->id . " Product Suppier: " . $product->supplier_id,false);
        }
    }

    public function getSecondarySupplierCatalog($supplierId, $parentCategoryId = null, $status = null, $orderBy = null, $page = 1, $rangePerPage = 1000, &$totalRows){
        //Category ID needs to be fetched first to avoid where clauses errors
        if (isset($parentCategoryId) and ($parentCategoryId != 0)){
            $leafCategories = array();
            $this->Product_model->getLeafCategories($leafCategories, $parentCategoryId);
            $this->db->where_in("category_id", $leafCategories);
        }
        $this->db->select('product.*, secondary_supplier_catalog.price as secondary_price');
        $this->db->from('product');
        $this->db->join('secondary_supplier_catalog', 'product.id = secondary_supplier_catalog.product_id', 'inner');
        $this->db->join('supplier', 'supplier.id = secondary_supplier_catalog.supplier_id', 'inner');
        $this->db->join('user', 'supplier.userid = user.id', 'inner');
        $this->db->where("user.status", 'active');
        $this->db->where("secondary_supplier_catalog.supplier_id", $supplierId);
        if (isset($status)) {
            $this->db->where("product.status", $status);
        }
        if (isset($orderBy)){
            $this->db->order_by($orderBy);     
        }
        $from =  ($page-1) * $rangePerPage;
        $query = $this->db->get();
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

    public function getGeneralCatalog($supplierId, $parentCategoryId = null, $orderBy, $page = 1, $rangePerPage = 1000, &$totalRows){
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
        $queryScript = 
        "SELECT DISTINCT * 
        FROM (
            SELECT product.*
            FROM secondary_supplier_catalog
            INNER JOIN product ON product.id = secondary_supplier_catalog.product_id
            INNER JOIN supplier ON product.supplier_id = supplier.id
            INNER JOIN user ON supplier.userid = user.id
            INNER JOIN supplier s2 ON secondary_supplier_catalog.supplier_id = s2.id
            INNER JOIN user u2 ON s2.userid = u2.id
            WHERE secondary_supplier_catalog.supplier_id = $supplierId
            AND product.status = 'published'
            AND user.status = 'active'
            AND u2.status = 'active'
            $whereCategoryIn
            UNION
            SELECT product.*
            FROM product
            INNER JOIN supplier ON product.supplier_id = supplier.id
            INNER JOIN user ON supplier.userid = user.id
            WHERE user.status = 'active'
            AND product.status = 'published'
            AND product.supplier_id = $supplierId
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


