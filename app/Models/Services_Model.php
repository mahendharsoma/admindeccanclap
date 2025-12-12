<?php namespace App\Models;

use CodeIgniter\Model;

class Services_Model extends Model
{
    public function __construct()
    {
    parent::__construct();
    $db = db_connect();
    $this->table = $db->table(SERVICES_TABLE);
    }
    
    function insert_data($info)
    {
    $result = $this->table->insert($info);
    if ($result === false)
    {
    log_message('error', __METHOD__.'error while trying to insert  with, info: '.print_r($info, true).', last query: '.$this->db->getLastQuery());
    return false;
    }
     return $this->db->insertID();
    }
    
    function get_data_by_id($service_id)
    {
    $this->table->where('service_id',$service_id);
    $result = $this->table->get();
	if ($result === false)
    {
    log_message('error', __METHOD__.' error while getting data with, service_id : '.$service_id.', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $result;
    }
    
    function update_data($service_id, $updated_data)
    {
    $this->table->where('service_id', $service_id);
    $this->table->update($updated_data);
    // var_dump($this->db->getLastQuery());
    // exit();
    if($this->db->affectedRows() < 0)
    {
    log_message('error', __METHOD__.'error while trying update , service_id : '.$service_id.', updated data: '.print_r($updated_data, true).', last query: '.$this->db->getLastQuery());
    return false;
    }
    return true;
    }
    
    function delete_data($service_id)
    {
    $this->table->where('service_id', $service_id);
    $query = $this->table->delete();
    if ($query === false)
    {
    log_message('error', __METHOD__.'error while trying to delete with,service_id : '.$service_id .', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $query;
    }
    
    public function get_data()
    {
    $result = $this->table->get();
	if ($result === false)
    {
    log_message('error', __METHOD__.' error while getting data , last query: '.$this->db->getLastQuery());
    return false;
    }
    return $result;
    }
    
    
    
}