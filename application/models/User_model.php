<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User_model extends CI_Model {




    function get_user($id)
    {
        $query = $this->db->get_where('user', array("id"=>$id));
        if ($query->num_rows() == 1){
            $query->row(0)->password = '';
            return $query->row(0);
        } else {
            return false;
        }
     }

    function getUserByUsername($username){
        $query = $this->db->get_where('user', array("username"=>$username));
        if ($query->num_rows() == 1){
            $query->row(0)->password = '';
            return $query->row(0);
        } else {
            return false;
        }
     }

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
    
    function register_user($data, $role, $fake_name){
        $this->db->insert("user", $data);
        $id = $this->db->insert_id();
        if (isset($id) and (($role=='supplier')or($role=='distributor'))) {
            $this->db->set('fake_name', $fake_name);
            $this->db->where('userid', $id);
            $this->db->update($role);
        }
        return $id;
    }


    function save($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }


    public function usernameCheck($password, $username){
        
        $query = $this->db->get_where("user", array("username"=>$username));
        $user_result = $query->result();

        if(count($user_result) == 1){
            $passwordDB = $user_result[0]->password;
            $passwordDB_decoded = $this->encrypt->decode($passwordDB, $this->config->item('encryption_key'));

            if ($password==$passwordDB_decoded) {
                if ($user_result[0]->status == 'pending'){
                    $this->session->set_flashdata("error","El usuario aún no fue aprobado por el administrador de la aplicación");
                    return FALSE;
                }   else {
                    $role = $user_result[0]->role;
                    if ($role == 'supplier') {
                        $role_information = $this->Supplier_model->getSupplierByUserId($user_result[0]->id);
                    } else if ($role == 'distributor'){
                        $role_information = $this->Distributor_model->getDistributorByUserId($user_result[0]->id);
                    }
                    $this->setLoadInfo($user_result[0]->id);
                    $this->session->set_userdata(array('id'=>$user_result[0]->id, 'role_id'=>$role_information->id,'user'=>$user_result[0]->username, 'role'=>$user_result[0]->role, 'email'=>$user_result[0]->email, 'logged_in'=>true));
                    
                    return TRUE;
                }         
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
                if ($user_result[0]->status == 'pending'){
                    $this->session->set_flashdata("error","El usuario aun no fue aprobado por el administrador de la aplicación");
                    return FALSE;
                } else {

                    $role = $user_result[0]->role;
                    if ($role == 'supplier') {
                        $role_information = $this->Supplier_model->getSupplierByUserId($user_result[0]->id);
                    } else if ($role == 'distributor'){
                        $role_information = $this->Distributor_model->getDistributorByUserId($user_result[0]->id);
                    }
                    $this->setLoadInfo($user_result[0]->id);
                    $this->session->set_userdata(array('id'=>$user_result[0]->id, 'role_id'=>$role_information->id, 'user'=>$user_result[0]->username, 'role'=>$user_result[0]->role, 'email'=>$user_result[0]->email,  'logged_in'=>true));
                    
                    return TRUE;
                }
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

    public function setLoadInfo($userId){
        $this->db->where('id', $userId);
        $query = $this->db->get('user');
        $user_result = $query->result();
        $loadInfo = new stdclass();
        if ($user_result[0]->role == 'supplier') {
            $loadInfo->activeProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'active');
            $loadInfo->inactiveProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'inactive');
            $loadInfo->publishedProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'published');
            $loadInfo->pendingDistributors = $this->Supplier_model->getPendingDistributorsAmount($userId);
        } else if ($user_result[0]->role == 'distributor'){

        }
        $this->session->set_userdata(array('loadInfo'=>$loadInfo));
    }

   public function password_change($id, $newpassword){

        $this->db->where('id', $id);
        return $this->db->update('user', array('password'=>$this->encrypt->encode($newpassword, $this->config->item('encryption_key'))));

    }

   public function email_change($id, $newemail){

        $this->db->where('id', $id);
        return $this->db->update('user', array('email'=>$newemail));

    }


   public function username_change($id, $new_username){

        $this->db->where('id', $id);
        return $this->db->update('user', array('username'=>$new_username));

    }


 }