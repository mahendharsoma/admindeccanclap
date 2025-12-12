<?php
namespace App\Libraries;
use App\Models\Products_Model;


class Products_Library
{
    function __construct()
    {
    $this->products_model = new Products_Model();
    }
    
    function insert_data($data)
    {
    $result = $this->products_model->insert_data($data);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to insert Product list , data: '.print_r($data, true));
    return false;
    }
    return $result;
    }
    
    function get_data_by_id($product_id)
    {
    $get_data = $this->products_model->get_data_by_id($product_id);
    if($get_data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  data by, product_id: '.$product_id);
    return false;
    }
    return $get_data->getRowArray();
    }
    
    function delete_data($product_id)
    {
    $result = $this->products_model->delete_data($product_id);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update data, product_id: '.$product_id);
    return false;
    }
    return true;
	}
	
	function update_data($product_id, $updated_data)
    {
    $result = $this->products_model->update_data($product_id, $updated_data);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update,  where product_id: '.$product_id);
    return false;
    }
    return true;
	}
	
	function get_data_by_service($service_id)
    {
    $data= $this->products_model->get_data_by_service($service_id);
    if($data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  data  by, service_id: '.$service_id);
    return false;
    }
    return $data->getResultArray();
    }
    
    
    
   
    
}    