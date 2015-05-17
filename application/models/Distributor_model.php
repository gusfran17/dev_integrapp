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



    function get_completeness($userid){

        $distributor = $this->get_distributor($userid);
        $pasos_completos = 0;
        $steps = array();
        $steps['registered'] = true;
        $steps['service_description'] = ($distributor->service_description != "");
        $steps['commercial_address'] = ($distributor->commercial_address != "");
        $steps['comercial_email'] = ($distributor->comercial_email != "");
        $steps['fiscal_address'] = ($distributor->fiscal_address != "");
        $steps['cuit'] = ($distributor->cuit != "");        
        $steps['razon_social'] = ($distributor->razon_social != "");
        $steps['fake_name'] = ($distributor->fake_name != "");
        //$steps['latLocation'] = ($distributor->latLocation != "");
        //$steps['longLocation'] = ($distributor->longLocation != "");
        //$steps['bannk_account'] = ($distributor->bank_account != "");
        //$steps['cbu'] = ($distributor->cbu != "");
        //$steps['bank_name'] = ($distributor->bank_name != "");
        //$steps['bank_branch'] = ($distributor->bank_branch != "");
        //$steps['bank_account_name'] = ($distributor->bank_account_name != "");
        foreach($steps as $key=>$step){
            if($step != false){
                $pasos_completos++;
            }
        }
        $porcentaje = ($pasos_completos*100)/count($steps);
        return round($porcentaje, 0);

    }

}

