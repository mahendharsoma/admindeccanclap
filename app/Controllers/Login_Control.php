<?php

namespace App\Controllers;
use App\Libraries\User_Library;

class Login_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
        $this->user_library = new User_Library();
    }

	public function index()
	{
        $data = array();

        if ($_POST)
        {
            $rules = [
                'user_email' => ['label' => 'User Email', 'rules' => 'trim|required|valid_email'],
                'user_password' => ['label' => 'User Password', 'rules' => 'trim|required'],
            ];

            if ($this->validate($rules) === false) {
                $data['errors'] = $this->validator->getErrors();
                return $this->generateView('login',$data, false);
            }

            $email = $this->request->getPost('user_email');
            $password = $this->request->getPost('user_password');

            $result = $this->user_library->verify_user_login_by_email($email, $password);
            if($result === EMAIL_NOT_FOUND)
            {
                log_message('debug', __METHOD__.' email not found: '.$email);
                $data['errors'][] = EMAIL_NOT_FOUND_MSG;
                return $this->generateView('login', $data, false);
            }
            if($result === YOU_ARE_UNAUTHORIZED)
            {
                log_message('debug', __METHOD__.' unauthorized user: '.$email);
                $data['errors'][] = YOU_ARE_UNAUTHORIZED_MSG;
                return $this->generateView('login', $data, false);
            }
            if($result === PASSWORD_INCORRECT)
            {
                log_message('debug', __METHOD__.__FUNCTION__.' Password Incorrect: '.$email.', password: '.$password);
                $data['errors'][] = PASSWORD_INCORRECT_MSG;
                return $this->generateView('login', $data, false);
            }
            if($result === false)
            {
                log_message('error', __METHOD__.' error while logging with email: '.$email.', password: '.$password);
                $data['errors'][] = SYSTEM_ERROR_MSG;
                return $this->generateView('login', $data, false);
            }

            $info['user_email'] = $email;
            $user_session = $this->set_sesison_data($info);
            
            if($user_session === false)
            {
                log_message('error', __METHOD__.' error while setting the session, data: '.print_r($info, true));
                $data['errors'][] = SYSTEM_ERROR_MSG;
                return false;
            }

            return redirect()->to('/dashboard');
        }

        return $this->generateView('login',$data, false);
    }

    // Set Session 
    private function set_sesison_data($user_info)
    {
        if(!isset($user_info['user_name']))
        {
            $user_detail = $this->user_library->get_user_details_by_email($user_info['user_email']);
            if($user_detail === false)
            {
                log_message('error', __METHOD__.' error while getting user data, email: '.$user_info['user_email']);
                return false;
            }

            $user_info['user_name']  = $user_detail->user_name;
            $user_info['user_id']    = $user_detail->user_id;
            $user_info['parent_id']  = $user_detail->parent_id;
            $user_info['user_phone'] = $user_detail->phone;
            $user_info['user_email'] = $user_detail->email_id;
            $user_info['user_role']  = $user_detail->role_name;
        }

        $user_info['is_logged_in'] = true;
        $this->session->set($user_info);
        return true;     // <--- Important!
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}