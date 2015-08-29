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
            $this->db->insert('supplier_distributor_association', $insert);           
        }
    }


	function save($userid, $data){

        $this->db->where('userid', $userid);

        return $this->db->update('supplier', $data);

    }


    function get_completeness($userid){

        $supplier = $this->get_supplier($userid);
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
            return null;
        }
        
    }

    public function suppliersCount(){
        return $this->db->count_all("supplier");
    }

    public function getSuppliers($page, $rangePerPage){
        $from =  ($page-1) * $rangePerPage;
        $query = $this->db->get('supplier', $rangePerPage, $from);
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
        $this->db->join('supplier_distributor_association', 'distributor.id = supplier_distributor_association.distributor_id');
        $this->db->where('supplier_distributor_association.supplier_id', $supplierId);
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

    public function associationStatus($role, $roleId, $supplierId){
        if ($role == 'supplier') { 

        } else if ($role == 'distributor') {
            $this->db->where('supplier_id', $supplierId);
            $this->db->where('distributor_id', $roleId);
            $query = $this->db->get('supplier_distributor_association');
            $association = $query->result();
            return $association[0]->status;
        }
    }

    public function associationDiscount($role, $roleId, $supplierId){
        if ($role == 'supplier') {

        } else if ($role == 'distributor') {
            $this->db->where('supplier_id', $supplierId);
            $this->db->where('distributor_id', $roleId);
            $query = $this->db->get('supplier_distributor_association');
            $association = $query->result();
            return $association[0]->discount;
        }
    }

    public function addAssociationDetailsToProduct($role, $roleId, &$catalog){
        if ($role == 'supplier') {

        } else if ($role == 'distributor') {
            for ($i=0; $i < count($catalog); $i++) { 
                $this->db->where('supplier_id', $catalog[$i]->supplier_id);
                $this->db->where('distributor_id', $roleId);
                $query = $this->db->get('supplier_distributor_association');
                $association = $query->result();
                $catalog[$i]->associationStatus = $association[0]->status;
                $catalog[$i]->associationDiscount = $association[0]->discount;
                $this->db->where('id', $catalog[$i]->supplier_id);
                $query = $this->db->get('supplier');
                $supplier = $query->result();
                $catalog[$i]->supplier_fakename = $supplier[0]->fake_name;
                $this->db->where('product_id', $catalog[$i]->id);
                $this->db->where('distributor_id', $roleId);
                $query = $this->db->get('distributor_catalog');
                if ($query->num_rows() > 0){
                    $catalog[$i]->isCatalogItem = true;
                } else {
                    $catalog[$i]->isCatalogItem = false;
                }

            }
        }        
    }

    public function getSupplierId($userId){
        $this->db->where('userid', $userId);
        $query = $this->db->get('supplier');
        $result = $query->result();
        return $result[0]->id;
    }

    public function getActiveProductsAmount($userId){
        $supplierId = $this->getSupplierId($userId);
        $this->db->where('supplier_id', $supplierId);
        $this->db->where('status', 'active');
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
}


