<?php namespace App\Models;

use CodeIgniter\Model;

class Cities_Model extends Model
{
    public function __construct()
    {
    parent::__construct();
    $db = db_connect();
    $this->table = $db->table(CITIES_TABLE);
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
    
    function get_data_by_id($city_id)
    {
    $this->table->where('city_id',$city_id);
    $result = $this->table->get();
	if ($result === false)
    {
    log_message('error', __METHOD__.' error while getting data with, city_id : '.$city_id.', last query: '.$this->db->getLastQuery());
    return false;
    }
    return $result;
    }
    
    function update_data($city_id, $updated_data)
    {
    $this->table->where('city_id', $city_id);
    $this->table->update($updated_data);
    // var_dump($this->db->getLastQuery());
    // exit();
    if($this->db->affectedRows() < 0)
    {
    log_message('error', __METHOD__.'error while trying update , city_id : '.$city_id.', updated data: '.print_r($updated_data, true).', last query: '.$this->db->getLastQuery());
    return false;
    }
    return true;
    }
    
    function delete_data($city_id)
    {
    $this->table->where('city_id', $city_id);
    $query = $this->table->delete();
    if ($query === false)
    {
    log_message('error', __METHOD__.'error while trying to delete with,city_id : '.$city_id .', last query: '.$this->db->getLastQuery());
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