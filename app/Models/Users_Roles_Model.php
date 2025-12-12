<?php namespace App\Models;

use CodeIgniter\Model;

class Users_Roles_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $db = db_connect();
        $this->users_table = $db->table(USERS_TABLE);
        $this->roles_table = $db->table(ROLES_TABLE);
        $this->user_role_mapping_table = $db->table(USER_ROLE_MAPPING_TABLE);
    }

    // Getting all roles(Deccan)
    function get_user_roles()
    {
        $result = $this->roles_table->get(); 
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user roles, last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

     // Insert User Role(Deccan)
    function insert_user_role($user_role_map_info)
    {
        
        $result = $this->user_role_mapping_table->insert($user_role_map_info);
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to insert user role, info: '.print_r($user_role_map_info, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

    // Getting User role by user id from user role mapping table(Deccan)
    function get_user_roles_by_user_id($user_id)
    {
        $this->user_role_mapping_table->select('role_id');
        $this->user_role_mapping_table->where('user_id', $user_id);
        $result = $this->user_role_mapping_table->get();
        
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user role list with, user_id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
        
    }

    // Updating User Role(Deccan) 
    function update_user_role_by_user_id($user_id, $role_info)
    {
        $this->user_role_mapping_table->where('user_id', $user_id);
        $result = $this->user_role_mapping_table->update($role_info);
        if ($this->db->affectedRows() == 0)
        {
            log_message('error', __METHOD__.'error while trying to Updating User Role with user id: '.$user_id.', info: '.print_r($role_info, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

     // Delete User Role form User Role Mapping(Deccan)
    function delete_user_role($user_id)
    {
        $this->user_role_mapping_table->where('user_id', $user_id);
        $query = $this->user_role_mapping_table->delete();
        if ($query === false)
        {
            log_message('error', __METHOD__.'error while trying to delete user with, user_id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $query;
    }
}