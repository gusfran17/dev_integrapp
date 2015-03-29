<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User_model extends CI_Model {


    function username_check($username){

        $query = $this->db->get_where("user", array("username"=>$username));

        if ($query->num_rows()==0) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }



    function email_check($email){

        $query = $this->db->get_where("user", array("email"=>$email));

		if ($query->num_rows()==0) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }
    
    function register_user($data){

        $this->db->insert("user", $data);

    }

 }