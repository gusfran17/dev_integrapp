<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Product_model extends CI_Model {


    function get_category($parent=null)
    {


        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        
        //var_dump($query->result());exit;
        if($query->num_rows() == 0){ //si la categoria esta vacia, traemos la padre
            $parent = $this->db->get_where("categorias", array("id"=>$parent))->result()[0]->parent_id;
            
            $this->db->where("parent_id", $parent);
            $query = $this->db->get('categorias');
        }

        $result = $query->result();
        
        if($parent != ""){
            $result_with_home = array();
            $home_element = new stdClass();
            $home_element->id = 1;
            $home_element->name = "Inicio";
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
  


}

