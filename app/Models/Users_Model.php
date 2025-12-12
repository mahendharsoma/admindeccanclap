<?php namespace App\Models;

use CodeIgniter\Model;

class Users_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $db = db_connect();
        $this->users_table = $db->table(USERS_TABLE);
        $this->roles_table = $db->table(ROLES_TABLE);
        $this->user_role_table = $db->table(USER_ROLE_MAPPING_TABLE);
        $this->user_documents_table = $db->table(USER_DOCUMENTS_TABLE);
        $this->user_bank_details_table = $db->table(USER_BANK_DETAILS_TABLE);
    }

     // Getting Email form Users by email (Deccan)
    public function get_user_by_email($email)
    {
        $this->users_table->where('email_id', $email);
        $this->users_table->where('status', 'Active');
        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to login with, email: '.$email.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    // Getting USer Role from Roles by User ID(Deccan)
    public function get_user_role_by_email($user_id)
    {
        $_t = USER_ROLE_MAPPING_TABLE;
        $_t1 = ROLES_TABLE; 
        
        $this->user_role_table->select($_t1.'.role_name');

        $this->user_role_table->join($_t1, $_t1.'.role_id = '.$_t.'.role_id');
        $this->user_role_table->where($_t.'.user_id', $user_id);
        $result = $this->user_role_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to login with, email: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    // Login Function (Deccan)
    function user_login($user_email, $password) 
    {
        $email_result = $this->get_user_by_email($user_email);
        if ($email_result === false)
        {
            log_message('error', __METHOD__.'error while trying to login with, email: '.$user_email.', password: '.$password.', last query: '.$this->db->getLastQuery());
            return false;
        }
        if(count($email_result->getResult()) == 0)
        {
            log_message('debug', __METHOD__.'user not found, email: '.$user_email.', password: '.$password.', last query: '.$this->db->getLastQuery());

            return EMAIL_NOT_FOUND; // email does not exists
        }

        $user_role_details = $email_result->getRow();

        $role_result = $this->get_user_role_by_email($user_role_details->user_id);
        $roles_details = $role_result->getRowArray();
        if ($role_result === false)
        {
            log_message('error', __METHOD__.'error while trying to login with, email: '.$user_email.', password: '.$password.', last query: '.$this->db->getLastQuery());
            return false;
        }
        if(count($role_result->getResult()) == 0)
        {
            log_message('debug', __METHOD__.'user not found, email: '.$user_email.', password: '.$password.', last query: '.$this->db->getLastQuery());

            return YOU_ARE_UNAUTHORIZED; // email does not exists
        }
        $allowed_roles = [
            'Super Admin',
            'Admin',
            'Inside Sales Executive',
            'Follow-Up Executive',
            'Accounts Executive'
        ];

        if (!in_array($roles_details['role_name'], $allowed_roles)) {
            log_message('debug', __METHOD__.' user role unauthorized, email: '.$user_email.', password: '.$password.', last query: '.$this->db->getLastQuery());
            return YOU_ARE_UNAUTHORIZED;
        }

        $user_detail = $email_result->getRow();
        $stored_password = $user_detail->password;
        return $this->verify_password($password, $stored_password);
    }

    // checking stored password and user entered password with out encrypt or decrypt
    function verify_password($password, $stored_password)
    {
        if($password === $stored_password)
        {
            return true;
        }
        else
        {
            return PASSWORD_INCORRECT;
        }
    }

    // Getting User Details by email id
    function get_users($email, $return_result_array = false)
    {
        $_t = USERS_TABLE;
        $_t1 = ROLES_TABLE;
        $_t2 = USER_ROLE_MAPPING_TABLE;

        $this->users_table->select($_t.'.*');
        $this->users_table->select($_t1.'.role_name');

        $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
        $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');

        $this->users_table->where('email_id', $email);
        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to update user with, email: '.print_r($email, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        if($return_result_array == true)
        {
            return $result->getResult();
        }
        return $result->getRow();
    }

    //get user details
    // function get_all_users()
    // {
    //     $_t = USERS_TABLE;
    //     $_t1 = ROLES_TABLE;
    //     $_t2 = USER_ROLE_MAPPING_TABLE;
      
    //     $this->users_table->select($_t.'.*');
    //     $this->users_table->select($_t1.'.role_name');

    //     $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
    //     $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');

    //     $this->users_table->where($_t1.'.role_name !=', 'Vendor');

    //     $result = $this->users_table->get();
    //     if ($result === false)
    //     {
    //         log_message('error', __METHOD__.'error while getting user list, last query: '.$this->db->getLastQuery());
    //         return false;
    //     }
    //     return $result;
    // }

    //get user details by roles(Deccan)
    function get_user_details_by_user_roles($user_roles)
    {
        $_t = USERS_TABLE;
        $_t1 = ROLES_TABLE;
        $_t2 = USER_ROLE_MAPPING_TABLE;
      
        $this->users_table->select($_t.'.*');
        $this->users_table->select($_t1.'.role_name');

        $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
        $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');

        $this->users_table->whereIn($_t1.'.role_id', $user_roles);

        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user list, last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    //get user details by roles(Deccan)
    function get_active_user_details_by_user_roles($user_roles)
    {
        $_t = USERS_TABLE;
        $_t1 = ROLES_TABLE;
        $_t2 = USER_ROLE_MAPPING_TABLE;
      
        $this->users_table->select($_t.'.*');
        $this->users_table->select($_t1.'.role_name');

        $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
        $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');

        $this->users_table->whereIn($_t1.'.role_id', $user_roles);
        $this->users_table->where($_t.'.status', 'Active');

        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user list, last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }
    //get user details by roles(Deccan)
    function get_user_details_by_user_roles_and_user_id($user_roles, $parent_id)
    {
        $_t = USERS_TABLE;
        $_t1 = ROLES_TABLE;
        $_t2 = USER_ROLE_MAPPING_TABLE;
      
        $this->users_table->select($_t.'.*');
        $this->users_table->select($_t1.'.role_name');

        $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
        $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');

        $this->users_table->whereIn($_t1.'.role_id', $user_roles);
        $this->users_table->where($_t.'.parent_id', $parent_id);

        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user list, last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    // Checking Email while adding user(Deccan)
    function email_check($email)
    {
        $this->users_table->where('email_id', $email);
        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user email with, email: '.$email.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

     // Insert User Data(Deccan)
    function insert_user($info)
    {  
        $result = $this->users_table->insert($info);
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to insert user with, info: '.print_r($info, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $this->db->insertID();
    }

     // Insert User Data(Deccan)
    function insert_user_document($docData)
    {  
        $result = $this->user_documents_table->insert($docData);
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to insert user with, info: '.print_r($docData, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

     // Insert User Data(Deccan)
    function insert_user_bank_details($user_bank_details)
    {  
        $result = $this->user_bank_details_table->insert($user_bank_details);
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to insert user with, info: '.print_r($user_bank_details, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

    // Getting User Details by User Id(Deccan)
    function get_user_data_user_id($user_id)
    {
        $_t = USERS_TABLE;
        $_t1 = ROLES_TABLE;
        $_t2 = USER_ROLE_MAPPING_TABLE;
      
        $this->users_table->select($_t.'.*');
        $this->users_table->select($_t1.'.role_id,'.$_t1.'.role_name');

        $this->users_table->join($_t2, $_t2.'.user_id='.$_t.'.user_id');
        $this->users_table->join($_t1, $_t1.'.role_id='.$_t2.'.role_id');
        
        $this->users_table->where($_t.'.user_id', $user_id);
        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user with, user id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    function get_user_bank_data_user_id($user_id)
    { 
        $this->user_bank_details_table->select('*');

        $this->user_bank_details_table->where('user_id', $user_id);
        $result = $this->user_bank_details_table->get();
        // var_dump($this->db->getLastQuery()); exit;
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user with, user id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    function get_user_doc_data_user_id($user_id)
    { 
        $this->user_documents_table->select('*');

        $this->user_documents_table->where('user_id', $user_id);
        $result = $this->user_documents_table->get();
        // var_dump($this->db->getLastQuery()); exit;
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while trying to get user with, user id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

     // Check Email While Updating User Data(Deccan)
    function email_update_check($user_id,$email)
    {
        $this->users_table->where('user_id !=', $user_id);
        $this->users_table->where('email_id', $email);
        $result = $this->users_table->get();
        if ($result === false)
        {
            log_message('error', __METHOD__.'error while getting user email with, email: '.$email.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $result;
    }

    // Updating User Details(Deccan)
    function update_user_details($user_id, $data)
    {
        $this->users_table->where('user_id', $user_id);
        $query = $this->users_table->update($data);
        if ($query === false)
        {
            log_message('error', __METHOD__.'error while trying to update user with, user id: '.$user_id.', data: '.print_r($data, true).', last query: '.$this->db->getLastQuery());
            return false;
        }

        if($this->db->affectedRows() > 0)
        {
            return true;
        }
        return true;
    }

    // Deleting User(Deccan)
    function delete_user($user_id)
    {
        $this->users_table->where('user_id', $user_id);
        $query = $this->users_table->delete();
        if ($query === false)
        {
            log_message('error', __METHOD__.'error while trying to delete user with, user_id: '.$user_id.', last query: '.$this->db->getLastQuery());
            return false;
        }
        return $query;
    }

    // update user status(Deccan)
    function update_user_status($user_id, $user_status_info)
    {
        $this->users_table->where('user_id', $user_id);
        $result = $this->users_table->update($user_status_info);
        if ($this->db->affectedRows() == 0)
        {
            log_message('error', __METHOD__.'error while trying to Updating User Status with user id: '.$user_id.', info: '.print_r($user_status_info, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

    // update user status(Deccan)
    function update_bank_details($user_id, $bank_details)
    {
        $this->user_bank_details_table->where('user_id', $user_id);
        $result = $this->user_bank_details_table->update($bank_details);
        if ($this->db->affectedRows() == 0)
        {
            log_message('error', __METHOD__.'error while trying to Updating User Status with user id: '.$user_id.', info: '.print_r($bank_details, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }

    // update user status(Deccan)
    function update_user_document($user_document_id , $document_details)
    {
        $this->user_documents_table->where('user_document_id ', $user_document_id );
        $result = $this->user_documents_table->update($document_details);
        if ($this->db->affectedRows() == 0)
        {
            log_message('error', __METHOD__.'error while trying to Updating User Status with user id: '.$user_document_id .', info: '.print_r($document_details, true).', last query: '.$this->db->getLastQuery());
            return false;
        }
        return true;
    }
}
