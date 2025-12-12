<?php namespace App\Models;

use CodeIgniter\Model;

class Products_Model extends Model
{
    public function __construct()
    {
    parent::__construct();
    $db = db_connect();
    $this->table = $db->table(PRODUCTS_TABLE);
    }
    
    function insert_data($info)
    {
    $result = $this->table->insert($info);
    if ($result === false)
    {
    log_message('error', __METHOD__.'error while trying to insert data  with, info: '.print_r($info, true).', last query: '.$this->db->getLastQuery());
    return false;
    }
    return true;
    }
    function get_data_by_id($product_id)
    {
    $this->table->where('product_id',$product_id);
    $result = $this->table->get();
	if ($result === false)
    {
    log_message('error', __METHOD__.' error while getting data with, product_id: '.$product_id.', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $result;
    }
    function delete_data($product_id)
    {
    $this->table->where('product_id', $product_id);
    $query = $this->table->delete();
    if ($query === false)
    {
    log_message('error', __METHOD__.'error while trying to delete with,product_id: '.$product_id.', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $query;
    }
    
    function update_data($product_id, $updated_data)
    {
    $this->table->where('product_id', $product_id);
    $this->table->update($updated_data);
    // var_dump($this->db->getLastQuery());
    // exit();
    if($this->db->affectedRows() < 0)
    {
    log_message('error', __METHOD__.'error while trying update data , product_id: '.$product_id.', updated data: '.print_r($updated_data, true).', last query: '.$this->db->getLastQuery());
    return false;
    }
    return true;
    }
    function get_data_by_service($service_id)
    {
    $this->table->where('service_id',$service_id);
    $result = $this->table->get();
	if ($result === false)
    {
    log_message('error', __METHOD__.' error while getting data with, service_id: '.$service_id.', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $result;
    }
    
   



}