<?php
namespace App\Libraries;
use App\Models\Users_Model;

class User_Library
{
    function __construct()
    {
        $this->db = db_connect();
        $this->users_model = new Users_Model();
    }

    // Checking Email(Deccan)
    function verify_user_login_by_email($email, $password)
    {
        $result = $this->users_model->user_login($email, $password);
        if($result === EMAIL_NOT_FOUND)
        {
            log_message('debug', __METHOD__.' email not found: '.$email);
            return EMAIL_NOT_FOUND;
        }
        if($result === YOU_ARE_UNAUTHORIZED)
        {
            log_message('debug', __METHOD__.' unauthorized Login: '.$email);
            return YOU_ARE_UNAUTHORIZED;
        }
        if($result === PASSWORD_INCORRECT)
        {
            log_message('debug', __METHOD__.' password not match: '.$email);
            return PASSWORD_INCORRECT;
        }
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to login with, email: '.$email.', password: '.$password);
            return false;
        }

        return $result;
    }

    // Getting user Details By Email Id
    function get_user_details_by_email($email)
    {
        $result = $this->users_model->get_users($email);
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user with, email: '.$email);
            return false;
        }

        return $result;
    }

    // Getting All Users
    // function get_user_details()
    // {
    //     $result = $this->users_model->get_all_users();
    //     if($result === false)
    //     {
    //         log_message('error', __METHOD__.'error while trying to get users');
    //         return false;
    //     }

    //     return $result->getResultArray();
    // }
    
    // Getting All Users by User Roles(Deccan)
    function get_user_details_by_user_roles($user_roles)
    {
        $result = $this->users_model->get_user_details_by_user_roles($user_roles);
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get users for roles: '.implode(', ', $user_roles));
            return false;
        }

        return $result->getResultArray();
    }

    // Getting Active Users by User Roles(Deccan)
    function get_active_user_details_by_user_roles($user_roles)
    {
        $result = $this->users_model->get_active_user_details_by_user_roles($user_roles);
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get users for roles: '.implode(', ', $user_roles));
            return false;
        }

        return $result->getResultArray();
    }

    // Getting Active Users by User Roles(Deccan)
    function get_user_details_by_user_roles_and_user_id($user_roles, $parent_id)
    {
        $result = $this->users_model->get_user_details_by_user_roles_and_user_id($user_roles, $parent_id);
        if($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get users for roles: '.implode(', ', $user_roles));
            return false;
        }

        return $result->getResultArray();
    }

    // Checking Email while adding user(Deccan)
    function email_check($email)
    {
        $result = $this->users_model->email_check($email);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to insert user  email check, data: '.print_r($email, true));
            return false;
        }

         return $result->getResultArray();  
    }

    // Insert User Data(Deccan)
    function insert_user($user_details)
    {
        $result = $this->users_model->insert_user($user_details);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to insert user , data: '.print_r($user_details, true));
            return false;
        }

        return $result;
    }

    function insert_user_document($docData)
    {
        $result = $this->users_model->insert_user_document($docData);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to insert user , data: '.print_r($docData, true));
            return false;
        }

        return $result;
    }
    function insert_user_bank_details($user_bank_details)
    {
        $result = $this->users_model->insert_user_bank_details($user_bank_details);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to insert user , data: '.print_r($user_bank_details, true));
            return false;
        }

        return $result;
    }

    // Getting User Details by User Id(Deccan)
	function get_user_data_user_id($user_id)
    {
        $result = $this->users_model->get_user_data_user_id($user_id);
        if ($result === false) 
        {
            log_message('error', __METHOD__ . ' error while trying to get user details , user_id: ' . $user_id);
            return false;
        }
        return $result->getRowArray();
    }

	function get_user_bank_data_user_id($user_id)
    {
        $result = $this->users_model->get_user_bank_data_user_id($user_id);
        if ($result === false) 
        {
            log_message('error', __METHOD__ . ' error while trying to get user bank details , user_id: ' . $user_id);
            return false;
        }
        return $result->getRowArray();
    }

	function get_user_doc_data_user_id($user_id)
    {
        $result = $this->users_model->get_user_doc_data_user_id($user_id);
        if ($result === false) 
        {
            log_message('error', __METHOD__ . ' error while trying to get user bank details , user_id: ' . $user_id);
            return false;
        }
        return $result->getResultArray();
    }

    // Check Email While Updating User Data(Deccan)
    function email_update_check($user_id,$email)
    {
        $result = $this->users_model->email_update_check($user_id,$email);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user  email check, data: '.print_r($email, true));
            return false;
        }

         return $result->getResultArray();  
    }

     // Update User Details (Deccan)
	function update_user($user_id,$user_data)
	{
		$result = $this->users_model->update_user_details($user_id, $user_data);
		 if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user, user id: '.$user_id);
            return false;
        }
        return true;	
	}

     // Update User Details (Deccan)
	function update_bank_details($user_id, $bank_details)
	{
		$result = $this->users_model->update_bank_details($user_id, $bank_details);
		 if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user, user id: '.$user_id);
            return false;
        }
        return true;	
	}

     // Update User Details (Deccan)
	function update_user_document($user_document_id, $document_details)
	{
		$result = $this->users_model->update_user_document($user_document_id, $document_details);
		 if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user, user id: '.$user_document_id);
            return false;
        }
        return true;	
	}

    // delete user(Deccan)
    function delete_user($user_id)
    {
        $update['updated_on'] = get_current_datetime_for_db();
        $update['updated_by'] = session()->get('user_id');

        $this->db->transStart();

        // update user before deleting
        $result = $this->users_model->update_user_details($user_id, $update);
        if($result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while trying to update user, user_id: '.$user_id.', update data: '.print_r($update));
            return false;
        }

        // delete user data
        $result = $this->users_model->delete_user($user_id);
        if($result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while trying to delete user, user id: '.$user_id);
            return false;
        }

        $this->db->transComplete();
        return true;
    }

    // Active and Inactive user (Deccan)
    function update_user_status($user_id, $user_status_info)
    {
        $result = $this->users_model->update_user_status($user_id, $user_status_info);
        if($result === false)
        {
            log_message('error', __METHOD__.' error while trying to update user status with user id: '.$user_id.', data: '.print_r($user_status_info, true));
            return false;
        }

        return true;
    }
}