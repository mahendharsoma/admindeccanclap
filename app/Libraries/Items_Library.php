<?php
namespace App\Libraries;
use App\Models\Items_Model;


class Items_Library
{
    function __construct()
    {
    $this->items_model = new Items_Model();
    }
    
    function insert_data($data)
    {
    $result = $this->items_model->insert_data($data);
    if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to insert  list , data: '.print_r($data, true));
    return false;
    }
    return $result;
    }
    
    function get_data_by_id($item_id)
    {
    $get_data = $this->items_model->get_data_by_id($item_id);
    if($get_data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  data by, item_id: '.$item_id);
    return false;
    }
    return $get_data->getRowArray();
    }
    
    function delete_data($item_id)
    {
    $result = $this->items_model->delete_data($item_id);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update data, item_id: '.$item_id);
    return false;
    }
    return true;
	}
	
	function update_data($item_id, $updated_data)
    {
    $result = $this->items_model->update_data($item_id, $updated_data);
	if($result === false)
    {
    log_message('error', __METHOD__.' error while trying to update,  where item_id: '.$item_id);
    return false;
    }
    return true;
	}
	
	function get_data_by_product($product_id)
    {
    $data= $this->items_model->get_data_by_product($product_id);
    if($data === false)
    {
    log_message('error', __METHOD__.' error while trying to get  data  by, product_id: '.$product_id);
    return false;
    }
    return $data->getResultArray();
    }
    
    
    
   
    
}    