<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User_model extends CI_Model {




    public function get_user($id)
    {
        $query = $this->db->get_where('user', array("id"=>$id));
        if ($query->num_rows() == 1){
            $query->row(0)->password = '';
            return $query->row(0);
        } else {
            return false;
        }
     }

    public function getUserByUsername($username){
        $query = $this->db->get_where('user', array("username"=>$username));
        if ($query->num_rows() == 1){
            $query->row(0)->password = '';
            return $query->row(0);
        } else {
            return false;
        }
     }

     public function getUserByEmail($email){
        $query =$this->db->get_where('user', array("email"=>$email));
        if ($query->num_rows() == 1){
            $query->row(0)->password = '';
            return $query->row(0);
        } else {
            return false;
        }
     }

    private function getUserByIdPassword($id)
    {
        $query = $this->db->get_where('user', array("id"=>$id));
        if ($query->num_rows() == 1){
            return $query->row(0);
        } else {
            return false;
        }
     }

    private function getUserByUsernamePassword($username){
        $query = $this->db->get_where('user', array("username"=>$username));
        if ($query->num_rows() == 1){
            return $query->row(0);
        } else {
            return false;
        }
     }

     private function getUserByEmailPassword($email){
        $query =$this->db->get_where('user', array("email"=>$email));
        if ($query->num_rows() == 1){
            return $query->row(0);
        } else {
            return false;
        }
     }

    private function getUserByEmailOrUsernamePassword($str){
        $this->db->where("email",$str);
        $this->db->or_where("username",$str);
        $query =$this->db->get('user');
        if ($query->num_rows() == 1){
            return $query->row(0);
        } else {
            return false;
        }
     }

    public function username_not_exist($username){
        $query = $this->db->get_where("user", array("username"=>$username));
        if ($query->num_rows()==0) {
        	return TRUE;
        }else{
        	return FALSE;
        }
    }



    public function email_not_exist($email){
        $query = $this->db->get_where("user", array("email"=>$email));
		if ($query->num_rows()==0) {
        	return TRUE;
        }else{
        	return FALSE;
        }
    }
    
    public function registerUser($insert, $role, $fake_name){
        $isEmailVerificationEnabled = $this->Settings_model->getSetting('EMAIL_REGISTER_VERIFICATION');
        if ($role != 'supplier') {
            $insert['status'] = 'active';
        } else {
            $insert['status'] = 'pending';
        }
        $this->db->insert("user", $insert);
        $id = $this->db->insert_id();

        if (isset($id) and (($role=='supplier')or($role=='distributor'))) {
            $this->db->set('fake_name', $fake_name);
            $this->db->where('userid', $id);
            $this->db->update($role);
        }
        $email = $insert['email'];
        $this->createEmailToken($id, $email);
        if ($isEmailVerificationEnabled == true){
            $email = $insert['email'];
            $this->sendVerificationEmail($id);
        }

        return $id;
    }

    public function save($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    public function sendVerificationEmail($userid){
        $user = $this->get_user($userid);
        if ($user!=false){
            $token = $this->getEmailToken($userid);
            $subject = 'Confirmación de cuenta IntegrApp';
            $message = "¡¡BIENVENIDO A INTEGRAPP!!\n\n\nPor favor haga click en el siguiente link para confirmar su cuenta IntegrApp: \n  " . base_url() . "register/verifyAccount/$userid/" . $token->token . " \n\nSi el link no funciona, por favor, copielo y peguelo en una ventana del navegador.\nMuchas gracias!\nSaludos!";
            $from = NOREPLY_ACCOUNT;
            $to = $user->email;
            $cc = "";
            $bcc = "gusfran17@gmail.com";
            return $this->sendEmail($subject,$message,$from,$to,$cc,$bcc);
        }
    }

    public function sendEmail($subject, $message, $from, $to, $cc, $bcc){
        $this->load->library('email');
        $this->email->from($from, 'Administrador IntegrApp');
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send(FALSE)){
            //log_message('info', "SENT: " . $this->email->print_debugger(), false);
            return true;
        } else {
            //log_message('info', "UNSENT: " . $this->email->print_debugger(), false);
            return false;
        }
    }

    public function sendRenewPasswordEmail($userid, $email){
        $this->updateEmailToken($userid);
        $token = $this->getEmailToken($userid);
        $subject = 'Renovación de contraseña IntegrApp';
        $message = "Por favor haga click en el siguiente link para ingresar su nueva contraseña IntegrApp: \n  " . base_url() . "login/inputNewPassword/$userid/$token->token \n\nSi el link no funciona, por favor, copielo y peguelo en una ventana del navegador.\nMuchas gracias!\nSaludos!";
        $from = NOREPLY_ACCOUNT;
        $to = $email;
        $cc = "";
        $bcc = 'gusfran17@gmail.com';
        return $this->sendEmail($subject, $message, $from, $to, $cc, $bcc);
    }

    public function verifyAccount($userid,$token){
        if ($this->verifyEmailToken($userid,$token)){
            $this->updateEmailToken($userid);
            return $this->updateEmailTokenStatus($userid,'confirmed');
        }   else {
            $this->session->set_flashdata("error","Hubo un error en la verificación de su cuenta, por favor comuniquese con el administrador.");
            return false;
        }

    }

    public function verifyEmailToken($userid, $token){
        $this->db->from('email_token');
        $this->db->where('userid',$userid);
        $this->db->where('token',$token);
        $query = $this->db->get();
        if ($query->num_rows()>0)
            return true;
        else 
            return false;
    }

    public function updateEmailTokenStatus($userid, $status){
        $this->db->from('email_token');
        $this->db->where('userid',$userid);
        $this->db->set('status',$status);
        $this->db->set('last_update', date("Y-m-d H:i:s"));
        $this->db->update();
        if ($this->db->affected_rows() > 0){
            $this->session->set_flashdata("success","Su cuenta fue confirmada con éxito! Ya puede loguearse a IntegrApp!!");
            return true;
        } else {
            $this->session->set_flashdata("error","Hubo un error en la verificación de su cuenta, por favor intente de nuevo más tarde.");
            return false;
        }
    }


    public function isEmailTokenConfirmed($userid){
        $token = $this->getEmailToken($userid);
        if (isset($token)){
            if ($token->status == 'confirmed'){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }   
    }

    public function createEmailToken($userid){
            $token = $this->randomString();
            $insert = array();
            $insert['userid'] = $userid;
            $insert['token'] = $token;
            $this->db->insert("email_token", $insert);
            return $this->db->insert_id();
    }

    public function updateEmailToken($userid){
        $token = $this->randomString();
        $this->db->from('email_token');
        $this->db->where('userid',$userid);
        $this->db->set('token',$token);
        $this->db->update();
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getEmailToken($userid){
        $this->db->from('email_token');
        $this->db->where('userid',$userid);
        $query = $this->db->get();
        $token = $query->result();
        if (count($token)>0){
            return $token[0];
        } else {
            return null;
        }
    }

    public function randomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 50; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }

    public function checkAccountExists($usernameOrEmail){
        $user = $this->User_model->getUserByUsername($usernameOrEmail);
        if ($user != false){
            return $user;
        } else {
            $user = $this->User_model->getUserByEmail($usernameOrEmail);
            if ($user != false){
                return $user;
            } else {
                return null;
            }
        }
    }

    public function emailOrUsernameCheck($password, $username){        
        $user_result = $this->getUserByEmailOrUsernamePassword($username);
        if($user_result != false){
            $isEmailVerificationEnabled = $this->Settings_model->getSetting('EMAIL_REGISTER_VERIFICATION');
            if ($isEmailVerificationEnabled){
                $tokenConfirmed = $this->isEmailTokenConfirmed($user_result->id);
            } else {
                $tokenConfirmed = true;
            }
            if ($tokenConfirmed){
                $passwordDB = $user_result->password;
                $passwordDB_decoded = $this->encrypt->decode($passwordDB, $this->config->item('encryption_key'));
                if ($password==$passwordDB_decoded) {
                    if ($user_result->status == 'pending'){
                        $this->session->set_flashdata("error","El usuario PROVEEDOR aún no fue aprobado por el administrador de la aplicación. Contactese con el mismo para solicitar la aprobación de la misma");
                        return FALSE;
                    }   else {
                        $role = $user_result->role;
                        if ($role == 'supplier') {
                            $role_information = $this->Supplier_model->getSupplierByUserId($user_result->id);
                        } else if ($role == 'distributor'){
                            $role_information = $this->Distributor_model->getDistributorByUserId($user_result->id);
                        }
                        $this->setLoadInfo($user_result->id);
                        $this->session->set_userdata(array('id'=>$user_result->id, 'role_id'=>((isset($role_information))?$role_information->id:0),'user'=>$user_result->username, 'role'=>$user_result->role, 'email'=>$user_result->email, 'logged_in'=>true));
                        
                        return TRUE;
                    }         
                }else{
                        return FALSE;
                }
            } else {
                $this->session->set_flashdata("error","El usuario aun no há confirmado su cuenta de email. Por favor, verifiquela. Si no ha recibido el mail de confirmación haga <a href='".base_url()."login/sendEmailConfirmation/$user_result->id'>click aqui</a> para reenviarlo.");
                return FALSE;
            }
        }else{
            return FALSE;
        }
        
    }

   public function passwordAuthenticate($password, $data){
        return $this->emailOrUsernameCheck($password, $data);
    }

    public function setLoadInfo($userId){
        $user_result = $this->get_user($userId);
        $loadInfo = new stdclass();
        if ($user_result->role == 'supplier') {
            $loadInfo->activeProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'active');
            $loadInfo->inactiveProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'inactive');
            $loadInfo->publishedProducts = $this->Supplier_model->getProductsAmountByStatus($userId, 'published');
            $loadInfo->pendingDistributors = $this->Supplier_model->getPendingDistributorsAmount($userId);
        } else if ($user_result->role == 'distributor'){

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