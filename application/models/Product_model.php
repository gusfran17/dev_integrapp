<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {


    public function getCategory($parent=null){

        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        if($query->num_rows() == 0){
            return null;
        }
        $result = $query->result();
        return $result;
    }

    public function getCategoryRecord($categoryId){
        $this->db->where("id", $categoryId);
        $query = $this->db->get('category');
        if($query->num_rows() == 0){
            return null;            
        }
        $result = $query->result();
        return $result;
    }
    
    public function getCategories($parent=null, $tab){
        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        $result = $query->result();
        $tab = $tab."\t";
        foreach($result as $record){
                $categories = $categories . $tab . $record->name . "\n" . $this->getCategories($record->id,$tab);
        }
        return  $categories;

    }

    public function getCategoryBranch($categoryId, &$branch, $level=0){
            $categoryRecord = $this->getCategoryRecord($categoryId);
            if (isset($categoryRecord)){
                $branch[$level] = $categoryRecord[0];
                $level ++;
                $this->getCategoryBranch($categoryRecord[0]->parent_id, $branch, $level);
            } 
    }

    public function getTree($id){
        $this->db->select('ascending_path');
        $this->db->from('category');
        $this->db->where('id', $id);
        $result = $this->db->get();

        return $result->row_array();;
    }

    public function productNameCheck($productName){
        $this->db->where("name", $productName);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            return true;
        } else{ 
            return false;
        }
    }

    public function productCodeCheck($productCode){
        $this->db->where("code", $productCode);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            return true;
        } else{ 
            return false;
        }
    }

    public function productNameCheckForEdition($productName, $productId){
        if (($productName!=null) and ($productId!=null)){
            $this->db->where("name", $productName);
            $query = $this->db->get('product');
            if($query->num_rows() == 0){
                return true;
            } else{ 
                $result = $query->result();
                if ($result[0]->id == $productId){
                    return true;
                }
                return false;
            }
        } 
        return false;
    }

    public function productCodeCheckForEdition($productCode, $productId){
        if (($productCode!=null) and ($productId != null)){
            $this->db->where("code", $productCode);
            $query = $this->db->get('product');
            if($query->num_rows() == 0){
                return true;
            } else{ 
                $result = $query->result();
                if ($result[0]->id == $productId){
                    return true;
                }
                return false;
            }
        }
        return false;
    }


    public function saveProduct($data){
        $this->db->insert("product", $data);
        return $this->db->insert_id();
    }

    public function updateProduct($data, $id){
        $this->db->where('id', $id);
        $this->db->update('product', $data); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getProductsByIntegrappCode($integrappCodes){
        $this->db->where_in('integrapp_code', $integrappCodes);
        $query = $this->db->get('product');
        return $query->result();
    }

    public function getProductById($id){
        $this->db->where("id", $id);
        $query = $this->db->get('product');
        $result = $query->result();
        return $result[0];
    }

    public function deleteProductById($productId){
        $this->db->where('id', $productId); 
        $this->db->delete('product'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function deleteProductByIntegrappCode($integrappCode){
        $this->db->where('integrapp_code', $integrappCode); 
        $this->db->delete('product'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    public function getNewId(){
        $this->db->select_max('id');
        $query = $this->db->get('product');
        $result = $query->result();
        return ($result[0]->id+1);
    }

    public function saveProductAttribute($product_id, $attribute_name, $attribute_value){
        $insert = array();
        $insert['product_id'] = $product_id;
        $insert['attribute_name'] = $attribute_name;
        $insert['attribute_value'] = $attribute_value;
        $insert['published_date'] = date("Y-m-d H:i:s");
        $insert['last_update'] = date("Y-m-d H:i:s");
        $this->db->insert("product_attribute", $insert);
        return $this->db->insert_id();
    }

    public function getProductAttributes($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->get('product_attribute');
        return $query->result();
    }

    public function deleteProductAttributes($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->delete('product_attribute');
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function setProductColors($isEditProduct, $colors, $productId){
        if ($isEditProduct){
            $this->deleteProductColors($productId);            
        }
        foreach($colors as $color){
            $insert['product_id'] = $productId;
            $insert['color'] = $color;
            $insert['published_date'] = date("Y-m-d H:i:s");
            $this->db->insert("product_color", $insert);
        }

    }

    public function getProductColors($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->get('product_color');
        return $query->result();
    }

    public function deleteProductColors($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->delete('product_color');
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    
    public function get_catalog($supplierId=null, $parentCategoryId = null, $status = null, $orderBy = null, $page = 1, $rangePerPage = 1000, &$totalRows){
        //Category ID needs to be fetched first to avoid where clauses errors
        if (isset($parentCategoryId) and ($parentCategoryId != 0)){
            $leafCategories = array();
            $this->getLeafCategories($leafCategories, $parentCategoryId);
            $this->db->where_in("category_id", $leafCategories);
        }
        $this->db->select('product.*');
        $this->db->from('product');
        $this->db->join('supplier', 'product.supplier_id = supplier.id', 'inner');
        $this->db->join('user', 'supplier.userid = user.id', 'inner');
        $this->db->where("user.status", 'active');
        if (isset($supplierId)){
            $this->db->where("product.supplier_id", $supplierId);
        }
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
            $result[$i]->images = $this->getProductImages($result[$i]->id);
            $finalResult[$j] = $result[$i];
            $j++;
        }
        return $finalResult;
    }

    public function getLeafCategories(&$leafCategories, $parentCategoryId){
        log_message('info', "Product_model getLeafCategories ParentID: ".$parentCategoryId, FALSE);
        $childCategories = $this->getCategory($parentCategoryId);
        if (count($childCategories)>0){
            foreach ($childCategories as $childCategory) {
                $this->getLeafCategories($leafCategories, $childCategory->id);
            }  
        } else {
             $leafCategories[] = $parentCategoryId;
        }
    }

    public function addProductPublishingCost(&$product){
        $this->db->where("id", $product->category_id);
        $query = $this->db->get("category");
        $category = $query->result();
        $product->publishing_cost = $category[0]->publishing_cost;
    }

    public function getPublishingCost($productId){
        $this->db->from('category');
        $this->db->join('product', 'product.category_id = category.id', 'inner');
        $this->db->where("product.id", $productId);
        $query = $this->db->get();
        $category = $query->result();
        return $category[0]->publishing_cost;
    }

    public function addProductsPublishingCost(&$catalog){
        for ($i=0; $i < count($catalog); $i++) { 
            if ($i==0){
                $this->db->where("id", $catalog[$i]->category_id);
            } else {
                $this->db->or_where("id", $catalog[$i]->category_id);
            }
        }
        $query = $this->db->get("category");
        
        $categories = $query->result();
        for ($i=0; $i < count($catalog); $i++) { 
            foreach ($categories as $category) {
                if ($category->id == $catalog[$i]->category_id){
                    $catalog[$i]->publishing_cost = $category->publishing_cost;
                }
            }    
        }
    }

    public function getProductDistributors($productId){
        $this->db->select('distributor.*');
        $this->db->from('distributor');
        $this->db->join('distributor_catalog', 'distributor_catalog.distributor_id = distributor.id');
        $this->db->where('distributor_catalog.product_id', $productId);
        $query = $this->db->get();
        $distributors = $query->result();
        foreach ($distributors as $key => $distributor) {
            $distributors[$key]->logo = $this->Distributor_model->get_logo($distributor->userid);
        }
        return $distributors;
    }

    public function addCategoryPathToProducts(&$catalog){
        $this->db->select('id, ascending_path from category where id not in (select distinct parent_id from category where parent_id is not null)', FALSE); 
        $query = $this->db->get();
        $categories = $query->result();

        foreach ($categories as $category) {
            for ($i=0; $i < count($catalog) ; $i++) { 
                if ($category->id == $catalog[$i]->category_id){
                    $catalog[$i]->categoryPath = $category->ascending_path;
                }
            }
        }
    }

    public function getCatalogCount($supplier_id=null){
        log_message('info', "Product_model getCatalogCount Supplier ID: " .  $supplier_id, FALSE);
        if (isset($supplier_id)){
            $this->db->where("supplier_id", $supplier_id);
        }
        $this->db->from('product');
        $count = $this->db->count_all_results();
        log_message('info', "Product_model getCatalogCount ProductCount: " .  $count, FALSE);
        return $count;
    }

    public function getProductImages($productId){
        $targetPath = ".".PRODUCT_IMAGES_PATH . $productId . "/";
        if (file_exists($targetPath)) {
            $files = scandir($targetPath,1);    
            $array = array_diff($files, array('.', '..', 'thumbs'));
            $max_key = max(array_keys($array)); 
        }   else {
            $array = array();
            $max_key = 0;
        }
        $images = array();
        //Rearrange array keys order
        $j = 0;
        for ($i=0; $i<$max_key+1; $i++){
            if (isset($array[$i])){
                $images[$j] = $array[$i];
                $j++;
            }
        }
        return $images;
    }


    public function setImagesFolder($isEditProduct, $images, $productId){
        if($images!=null){
            //if it is edition, moves existing images to temp in order to upload them again (deletes existing ones)
            if ($isEditProduct){
                @copy( "." . PRODUCT_IMAGES_PATH . $productId . "/" . $img, "." . PRODUCT_IMAGES_PATH . "temp/" . $img);
                @copy("." . PRODUCT_IMAGES_PATH . $productId . "/thumbs/" . $img, "." . PRODUCT_IMAGES_PATH . "temp/thumbs/". $img);
                $this->delTree("." . PRODUCT_IMAGES_PATH . $productId);

            }
            foreach($images as $img){
                @mkdir("." . PRODUCT_IMAGES_PATH . $productId);
                @mkdir("." . PRODUCT_IMAGES_PATH . $productId . "/thumbs");
                @copy("." . PRODUCT_IMAGES_PATH . "temp/" . $img, "." . PRODUCT_IMAGES_PATH . $productId . "/" . $img);
                @copy("." . PRODUCT_IMAGES_PATH . "temp/thumbs/". $img, "." . PRODUCT_IMAGES_PATH . $productId . "/thumbs/" . $img);
            }
        } else {//If during edition all images are erased and the product is saved with no images.
            if ($isEditProduct){ 
                $this->delTree("." . PRODUCT_IMAGES_PATH . $productId);
            }
        }
    }

    public function delTree($dir) { 
        if (file_exists($dir)) {
            $files = array_diff(scandir($dir), array('.','..')); 
            foreach ($files as $file) { 
                if (is_dir("$dir/$file")){
                    $this->delTree("$dir/$file");
                } else {
                    unlink("$dir/$file");   
                }
            } 
            return rmdir($dir); 
        }

    }

}

