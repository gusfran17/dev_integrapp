<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {


    function getCategory($parent=null){

        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        if($query->num_rows() == 0){
            return null;
        }
        $result = $query->result();
        
        if($parent != ""){
            $result_with_home = array();
            $home_element = new stdClass();
            $home_element->id = " ";
            $home_element->name = "Seleccione  sub-categoria...";
            $home_element->seo_name = "";
            $home_element->parent_id = null;
            $result_with_home[] = $home_element;
            foreach($result as $r){
                $result_with_home[] = $r;
            }
            $result = $result_with_home;
        }

        return $result;
    }

    
    function get_all_categories($parent=null, $tab){

        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        $result = $query->result();
        $tab = $tab."\t";
        foreach($result as $record){
                $categories = $categories . $tab . $record->name . "\n" . $this->getCategories($record->id,$tab);
        }
        return  $categories;

    }

    function getTree($id){
        $this->db->select('ascending_path');
        $this->db->from('category');
        $this->db->where('id', $id);
        $result = $this->db->get();

        return $result->row_array();;
    }

    function productNameCheck($productName){
        $this->db->where("name", $productName);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            return true;
        } else{ 
            return false;
        }
    }

    function productCodeCheck($productCode){
        $this->db->where("code", $productCode);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            return true;
        } else{ 
            return false;
        }
    }

    function productNameCheckForEdition($productName, $productId){
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

    function productCodeCheckForEdition($productCode, $productId){
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


    function saveProduct($data){
        $this->db->insert("product", $data);
        return $this->db->insert_id();
    }

    function updateProduct($data, $id){
        $this->db->where('id', $id);
        $this->db->update('product', $data); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    function getProductsByIntegrappCode($integrappCodes){
        $this->db->where_in('integrapp_code', $integrappCodes);
        $query = $this->db->get('product');
        return $query->result();
    }

    function getProductById($id){
        $this->db->where("id", $id);
        $query = $this->db->get('product');
        $result = $query->result();
        return $result[0];
    }


    function deleteProductById($productId){
        $this->db->where('id', $productId); 
        $this->db->delete('product'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    function deleteProductByIntegrappCode($integrappCode){
        $this->db->where('integrapp_code', $integrappCode); 
        $this->db->delete('product'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    function getNewId(){
        $this->db->select_max('id');
        $query = $this->db->get('product');
        $result = $query->result();
        return ($result[0]->id+1);
    }

    function saveProductAttribute($product_id, $attribute_name, $attribute_value){
        $insert = array();
        $insert['product_id'] = $product_id;
        $insert['attribute_name'] = $attribute_name;
        $insert['attribute_value'] = $attribute_value;
        $insert['published_date'] = date("Y-m-d H:i:s");
        $insert['last_update'] = date("Y-m-d H:i:s");
        $this->db->insert("product_attribute", $insert);
        return $this->db->insert_id();
    }

    function getProductAttributes($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->get('product_attribute');
        return $query->result();
    }

    function deleteProductAttributes($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->delete('product_attribute');
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    
    function get_catalog($id=null, $orderBy = null, $page = 1, $rangePerPage = 1000){
        if (isset($id)){
            $this->db->where("supplier_id", $id);
        }
        if (isset($orderBy)){
                $this->db->order_by($orderBy);     
        }
        log_message('info', "Page: " .  $page . " Range: " . $rangePerPage, FALSE);
        $from =  ($page-1) * $rangePerPage;
        $query = $this->db->get('product');
        $result = $query->result();
        $j = 0;
        $finalResult = array();
        for ($i= (($page-1)*$rangePerPage); $i< (((($page)*$rangePerPage) < count($result))? ($page*$rangePerPage): count($result)); $i++){
            $result[$i]->images = $this->getProductImages($result[$i]->id);
            $finalResult[$j] = $result[$i];
            $j++;
        }
        return $finalResult;
    }

    function getCatalogCount($supplier_id=null){
        log_message('info', "Product_model getCatalogCount Supplier ID: " .  $supplier_id, FALSE);
        if (isset($supplier_id)){
            $this->db->where("supplier_id", $supplier_id);
        }
        $this->db->from('product');
        $count = $this->db->count_all_results();
        log_message('info', "Product_model getCatalogCount ProductCount: " .  $count, FALSE);
        return $count;
    }

    function getProductImages($productId){
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
            //if it is edition, moves existing images to temp in order to upload them again
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

