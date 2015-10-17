<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class  Locations_model extends CI_Model {

    function getCity($data){
        $data = urldecode($data);
        $data = trim($data);
        $data = strtoupper($data);
        $sql = "SELECT * FROM (`city`) JOIN `province` ON `province`.`id` = `city`.`province_id` WHERE `city_name` LIKE '%$data%' ORDER BY CHAR_LENGTH(city_name) ASC";
        $query = $this->db->query($sql);
        //log_message('info', $sql, false);

        $series = array();
        foreach ($query->result() as $item){
            $obj = new stdClass();
            $obj->value = $item->city_name . ", " . utf8_encode($item->province_name);
            //log_message('info', $item->city_name . ", " . utf8_encode($item->province_name), false);
            $series[] = $obj;
        }
        return $series;
    }

 }