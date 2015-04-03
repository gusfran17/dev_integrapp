<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User_model extends CI_Model {


    function username_not_exist($username){

        $query = $this->db->get_where("user", array("username"=>$username));

        if ($query->num_rows()==0) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }



    function email_not_exist($email){

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


    public function usernameCheck($password, $username){
        
        $query = $this->db->get_where("user", array("username"=>$username));
        $user_result = $query->result();

        if(count($user_result) == 1){
            $passwordDB = $user_result[0]->password;
            $passwordDB_decoded = $this->encrypt->decode($passwordDB, $this->config->item('encryption_key'));

            if ($password==$passwordDB_decoded) {

                $this->session->set_userdata(array('user'=>$user_result[0], 'role'=>$user_result[0]->role, 'logged_in'=>true));
                return TRUE;
            }else{
                    return FALSE;
            }

        return TRUE;
        }else{
            return FALSE;
        }
        
    }


    public function emailCheck($password, $email){
        $query = $this->db->get_where("user", array("email"=>$email));
        $user_result = $query->result();

        if(count($user_result) == 1){
            $passwordDB = $user_result[0]->password;
            $passwordDB_decoded = $this->encrypt->decode($passwordDB, $this->config->item('encryption_key'));

            if ($password==$passwordDB_decoded) {
                $this->session->set_userdata(array('user'=>$user_result[0], 'role'=>$user_result[0]->role, 'logged_in'=>true));
                return TRUE;
            }else{
                    return FALSE;
            }

        }else{
            return FALSE;
        }
    }



   public function passwordAuthenticate($password, $data){
    
        return $this->usernameCheck($password, $data) or 
               $this->emailCheck($password, $data);
    }


 }