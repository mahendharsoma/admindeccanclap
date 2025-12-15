<?php
namespace App\Libraries;
use App\Models\Cities_Model;


class Cities_Library
{
    function __construct()
    {
    $this->cities_model = new Cities_Model();
    }
    
    function insert_data($data)
    {
    $result = $this->cities_model->insert_data($data);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to insert  list , data: '.print_r($data, true));
    return false;
    }
    return $result;
    }

    function get_data_by_id($city_id)
    {
    $area_data= $this->cities_model->get_data_by_id($city_id);
    if($area_data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  data, city_id: '.$city_id);
    return false;
    }
    return $area_data->getRowArray();
    }
    
    function update_data($city_id, $updated_data)
    {
    $result = $this->cities_model->update_data($city_id, $updated_data);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update, city_id: '.$city_id);
    return false;
    }
    return true;
	}
    
    function delete_data($city_id)
    {
    $result = $this->cities_model->delete_data($city_id);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to delete , city_id: '.$city_id);
    return false;
    }
    return true;
    } 
    function get_data()
    {
    $result = $this->cities_model->get_data();
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to get data');
    return false;
    }
    return $result->getResultArray();
    } 
   
    }