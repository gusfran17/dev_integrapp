<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Product_model extends CI_Model {


    function get_category($parent=null){

        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        if($query->num_rows() == 0){
            $parent = $this->db->get_where("categorias", array("id"=>$parent))->result()[0]->parent_id;
            $this->db->where("parent_id", $parent);
            $query = $this->db->get('categorias');
        }
        $result = $query->result();
        return $result;
    }

    function get_all_categories($parent=NULL; $tab){
        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        $result = $query->result();

        $tab = $tab."\t";

        foreach($result as $record){
                $categories = $categories . $tab . $record->name . "\n" . $this->get_categories($record->id,$tab);
        }
        return  $categories;


    }
  


}

