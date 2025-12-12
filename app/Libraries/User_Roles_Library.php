<?php
namespace App\Libraries;
use App\Models\Users_Roles_Model;

class User_Roles_Library
{
    function __construct()
    {
        $this->db = db_connect();
        $this->users_roles_model = new Users_Roles_Model();
    }

    // Get all Users Roles (Deccan)
    function get_user_roles()
    {
        $result = $this->users_roles_model->get_user_roles();
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user roles');
            return false;
        }

        return $result->getResultArray();
    }

    // Insert User Role(Deccan)
    function insert_user_role($user_role_map_info)
    {
        $result = $this->users_roles_model->insert_user_role($user_role_map_info);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to insert user role , data: '.print_r($user_role_map_info, true));
            return false;
        }

        return true;
    }

    // Checking User Role by user id(Deccan)
    function get_user_roles_by_user_id($user_id)
    {
        $result = $this->users_roles_model->get_user_roles_by_user_id($user_id);
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user role with, user id: '.$user_id);
            return false;
        }

        return $result->getRowArray();
    }

    // Updating User Role(Deccan)
    function update_user_role_by_user_id($user_id, $role_info)
    {
        $result = $this->users_roles_model->update_user_role_by_user_id($user_id, $role_info);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user role with user id: '.$user_id.', data: '.print_r($role_info, true));
            return false;
        }

        return true;
    }

    // Deleting User Role(Deccan)
    function delete_user_role($user_id)
    {
        $update['updated_on'] = get_current_datetime_for_db();
        $update['updated_by'] = session()->get('user_id');

        $this->db->transStart();

        // Updating User Role Mapping before delete
        $result = $this->users_roles_model->update_user_role_by_user_id($user_id, $update);
        if($result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while trying to update user role, user id: '.$user_id.', update data: '.print_r($update));
            return false;
        }

        // Delete User Role
        $result = $this->users_roles_model->delete_user_role($user_id);
        if($result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while trying to delete user, user id: '.$user_id);
            return false;
        }
        $this->db->transComplete();
        return true;
    } 
}