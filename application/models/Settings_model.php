<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class  Settings_model extends CI_Model {

    public function getSetting($settingName){
        $this->db->from('settings');
        $this->db->where('setting_name', $settingName);
        $query = $this->db->get();
        $setting = $query->result();
        return $setting[0]->setting_value;
    }

    public function setSettings($settingName, $settingValue){
        $this->db->from('settings');
        $this->db->where('setting_name', $settingName);
        $this->db->set('setting_value', $settingValue);
        $this->db->update();
        if ($this->db->affected_rows() > 0){
            $this->session->set_flashdata("success","Se modifico la configuracion con éxito");
            return true;
        } else {
            $this->session->set_flashdata("error","Há habido un problema para modificar la configuración");
            return false;
        }
    }

    public function getSettings(){
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->result();
    }
 }