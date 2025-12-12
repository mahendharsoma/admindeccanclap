<?php
namespace App\Libraries;
use App\Models\Services_Model;


class Services_Library
{
    function __construct()
    {
    $this->services_model = new Services_Model();
    }
    
    function insert_data($data)
    {
    $result = $this->services_model->insert_data($data);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to insert  list , data: '.print_r($data, true));
    return false;
    }
    return $result;
    }

    function get_data_by_id($service_id)
    {
    $area_data= $this->services_model->get_data_by_id($service_id);
    if($area_data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  Service, service_id: '.$service_id);
    return false;
    }
    return $area_data->getRowArray();
    }
    
    function update_data($service_id, $updated_data)
    {
    $result = $this->services_model->update_data($service_id, $updated_data);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update, service_id: '.$service_id);
    return false;
    }
    return true;
	}
    
    function delete_data($service_id)
    {
    $result = $this->services_model->delete_data($service_id);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to delete , service_id: '.$service_id);
    return false;
    }
    return true;
    } 
    function get_data()
    {
    $result = $this->services_model->get_data();
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to get data');
    return false;
    }
    return $result->getResultArray();
    } 
   
    }