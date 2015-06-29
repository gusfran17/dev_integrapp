<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Product_model extends CI_Model {


    function get_category($parent=null){

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
                $categories = $categories . $tab . $record->name . "\n" . $this->get_categories($record->id,$tab);
        }
        return  $categories;

    }

    function get_property($parent=null){
        $this->db->where("category_id", $parent);
        $query = $this->db->get('category_properties');
        $result = $query->result();
        return $result;
    }

    function get_tree($id){
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


    function get_new_id(){
        $this->db->select_max('id');
        $query = $this->db->get('product');
        $result = $query->result();
        return ($result[0]->id+1);
    }


    function get_added_product($id){

        $this->db->where("id", $id);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            echo "El Producto no se cargo satisfactoriamente, Intente volver a cargarlo por favor.";
        } else{ 
            $result = $query->result();
            return $result[0];

        }
    }

    function getProductsByIntegrappCode($integrappCodes){
        $this->db->where_in('integrapp_code', $integrappCodes);
        $query = $this->db->get('product');
        return $query->result();
    }

    function getProductAttributes($productId){
        $this->db->where("product_id", $productId);
        $query = $this->db->get('product_attribute');
        return $query->result();
    }

    function getProductImages($productId){
        //echo "." . base_url() . PRODUCT_IMAGES_PATH . $productId . "/";
        $targetPath = ".".PRODUCT_IMAGES_PATH . $productId . "/";
        if (file_exists($targetPath)) {
            $files = scandir($targetPath,1);    
            return array_diff($files, array('.', '..', 'thumbs'));
        }   else {
            return array();
        }
        

    }


    function get_catalog($id){

        $this->db->where("supplier_id", $id);
        $query = $this->db->get('product');
        if($query->num_rows() == 0){
            echo "No registra ningun producto cargado hasta el momento";
        } else{ 
            $result = $query->result();
            return $result;
            }
    }

    function save_product_attribute($product_id, $attribute_name, $attribute_value){
        $insert = array();
        $insert['product_id'] = $product_id;
        $insert['attribute_name'] = $attribute_name;
        $insert['attribute_value'] = $attribute_value;
        $insert['published_date'] = date("Y-m-d H:i:s");
        $insert['last_update'] = date("Y-m-d H:i:s");
        $this->db->insert("product_attribute", $insert);
        return $this->db->insert_id();
    }


}

