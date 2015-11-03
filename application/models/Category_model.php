<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {


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
    
    public function getCategories($parent=null, $tab=""){
        $this->db->where("parent_id", $parent);
        $query = $this->db->get('category');
        $result = $query->result();

        $tab = $tab."\t";
        $categories = "";

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

    public function getTree($categoryId){
        $this->db->select('ascending_path');
        $this->db->from('category');
        $this->db->where('id', $categoryId);
        $result = $this->db->get();
        return $result->row_array();
    }


    public function getLeafCategories(&$leafCategories, $parentCategoryId){
        //log_message('info', "Product_model getLeafCategories ParentID: ".$parentCategoryId, FALSE);
        $childCategories = $this->getCategory($parentCategoryId);
        if (count($childCategories)>0){
            foreach ($childCategories as $childCategory) {
                $this->getLeafCategories($leafCategories, $childCategory->id);
            }  
        } else {
             $leafCategories[] = $parentCategoryId;
        }
    }


}

