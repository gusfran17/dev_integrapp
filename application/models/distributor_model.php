<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Distributor_model extends CI_Model {


    function get_distributor($userid)
    {
        $query = $this->db->get_where('distributor', array("userid"=>$userid));
        if ($query->num_rows() == 1){
        	return $query->row(0);
        } else {
        	return false;
        }
     }


    function save($userid, $data){

        $this->db->where('userid', $userid);

        return $this->db->update('distributor', $data);

    }


}

