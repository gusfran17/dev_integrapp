<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Supplier_model extends CI_Model {


    function get_supplier($userid)
    {
        $query = $this->db->get_where('supplier', array("userid"=>$userid));
        if ($query->num_rows() == 1){
        	return $query->row(0);
        } else {
        	return false;
        }
     }


	function save($userid, $data){

        $this->db->where('userid', $userid);

        return $this->db->update('supplier', $data);

    }


    function get_completeness($userid){

        $supplier = $this->get_supplier($userid);
        $pasos_completos = 0;
        $steps = array();
        $steps['registered'] = true;
        $steps['service_description'] = ($supplier->service_description != "");
        //$steps['commercial_address'] = ($supplier->commercial_address != "");
        $steps['comercial_email'] = ($supplier->comercial_email != "");
        $steps['fiscal_address'] = ($supplier->fiscal_address != "");
        $steps['cuit'] = ($supplier->cuit != "");        
        $steps['razon_social'] = ($supplier->razon_social != "");
        $steps['fake_name'] = ($supplier->fake_name != "");
        //$steps['latLocation'] = ($supplier->latLocation != "");
        //$steps['longLocation'] = ($supplier->longLocation != "");
        $steps['bannk_account'] = ($supplier->bank_account != "");
        $steps['cbu'] = ($supplier->cbu != "");
        $steps['bank_name'] = ($supplier->bank_name != "");
        $steps['bank_branch'] = ($supplier->bank_branch != "");
        $steps['bank_account_name'] = ($supplier->bank_account_name != "");
        
        foreach($steps as $key=>$step){
            if($step != false){
                $pasos_completos++;
            }
        }
        $porcentaje = ($pasos_completos*100)/count($steps);
        return round($porcentaje, 0);
    }

}

