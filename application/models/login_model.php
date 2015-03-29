<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('encrypt');

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
            $passwordDB_decoded = $this->CI->encrypt->decode($passwordDB, $this->CI->config->item('encryption_key'));

            if ($password==$passwordDB_decoded) {
                $this->CI->session->set_userdata(array('user'=>$user_result[0], 'role'=>$user_result[0]->role, 'logged_in'=>true));
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