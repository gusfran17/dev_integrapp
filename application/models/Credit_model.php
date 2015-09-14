<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class  Credit_model extends CI_Model {

    function getLatestBalance($userId){
        $user = $this->User_model->get_user($userId);
        if ($user->role == 'supplier'){
            $this->db->order_by("date_added", "desc");
            $result = $this->db->get_where("transaction", array("userid"=>$userId))->result();
            if(count($result)>0){
                return $result[0]->balance;
            }else{
                return 0;
            }

        }
    }

    public function requestCredit($userId, $amount, $note, $voucherImage){
        $insert_data = array();
        $insert_data['userid'] = $userId;
        $insert_data['transfer_date'] = date("Y-m-d h:i:s");
        $insert_data['message'] = $note;
        $insert_data['amount'] = $amount;
        $insert_data['voucher_image'] = $voucherImage;
        $this->db->insert("transfer", $insert_data);
        if($voucherImage){
            $transferId = $this->db->insert_id();
            $result = $this->Credit_model->saveVoucherImage($userId, $transferId, $voucherImage);
        }
        return $this->db->insert_id();
    }

    public function approveTransfer($transferId, $adminApprovalComment, $adminId){
        $query = $this->db->get_where("transfer", array("confirmed"=>false, "id"=>$transferId));
        $transfer = $query->result()[0];

        if($query->num_rows() > 0){
            $data = array(
                   'confirmed' => true,
                   'confirmed_date' => date("Y-m-d h:i:s"),
                   'administrator_message' => $adminApprovalComment, 
                   'administrator_id' => $adminId 
                );

            $this->db->where('id', $transferId);
            $this->db->update('transfer', $data);
            $this->addTransaction($transfer->userid, $transfer->amount, "Transfer");
        }
    }

    function addTransaction($administratorId, $amount, $description){
        if($amount < 0){
            $insert_data = array(
                "date_added"=> date("Y-m-d h:i:s"),
                "description"=> $description,
                "debit"=>-$amount,
                "credit"=> 0,
                "balance"=> $this->getLatestBalance($administratorId) + $amount,
                "userid"=> $administratorId);
        }else if($amount> 0){
            $insert_data = array(
                "date_added"=> date("Y-m-d h:i:s"),
                "description"=> $description,
                "debit"=>0,
                "credit"=> $amount,
                "balance"=> $this->getLatestBalance($administratorId) + $amount,
                "userid"=> $administratorId);
        }else if($amount == 0){
            $insert_data = array(
                "date_added"=> date("Y-m-d h:i:s"),
                "description"=> $description,
                "debit"=>0,
                "credit"=> 0,
                "balance"=> $this->getLatestBalance($administratorId),
                "userid"=> $administratorId);
        }
        $this->db->insert("transaction", $insert_data);
    }

    function getTransactionsByUserId($userId)
    {
        $this->db->order_by("date_added", "desc");
        $query = $this->db->get_where('transaction', array('userid'=>$userId));
        return $query->result();
    }

    function getTransferById($transferId){
        $query = $this->db->get_where("transfer", array("id"=>$transferId));
        return $query->result()[0];
    }

    public function getPendingTransfers(){
        $this->db->select('u.username, u.role, t.* from transfer t, user u where u.id = t.userid and confirmed = false', FALSE); 
        $query = $this->db->get();
        return $query->result();
    }

    public function getPendingTransfersByUserId($userId){
        $this->db->where("userid", $userId);
        $this->db->where("confirmed", false);
        $query = $this->db->get('transfer');
        $result = $query->result();
        return $result;
    }

    public function saveVoucherImage($userId, $transferId, $voucherImage){
        $upload_path = '.' . VOUCHER_IMAGES_PATH . "$userId/";
        $tempFile = "." . VOUCHER_IMAGES_PATH . "temp/" . $voucherImage;
        if (!file_exists(VOUCHER_IMAGES_PATH . "$userId")){
            @mkdir($upload_path);
        }
        if (!file_exists(VOUCHER_IMAGES_PATH . "temp/" . $voucherImage)){
            @copy($tempFile, $upload_path . $voucherImage);
            unlink($tempFile);
        }
    }

    public function getUserTransferHistory($userId){
        return $this->db->get_where("transfer", array("userid"=>$userId))->result();
    }

    public function deletePendingTransfer($transferId){
        $this->db->where('id', $transferId);
        $this->db->where('confirmed', false); 
        $this->db->delete('transfer'); 
        if ($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
 }