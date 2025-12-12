<?php

namespace App\Controllers;
use App\Libraries\User_Library;
use App\Libraries\User_Roles_Library;

class User_Management_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->user_library = new User_Library();
        $this->user_roles_library = new User_Roles_Library();
       
    }

	public function index()
	{
        $data = array();
        // $data["admins_url"] = base_url('admins');

        $user_roles = [2];

        $admin_info = $this->user_library->get_user_details_by_user_roles($user_roles);
        if($admin_info === false)
        {
            log_message('error', __METHOD__.' error while getting user data for roles: '.implode(', ', $user_roles));
            $this->set_flash_error('Unable to get users, please try later');
            return redirect()->to('dashboard');
        }
		$data['admin_data'] = $admin_info;

	    return $this->generateView('content_panel/User_Management/admins_view',$data);
	}

    public function ajax_add_admin()
    {
       $rules = [
            'user_name' => ['label' => 'User Name', 'rules' => 'required'],
            'email_id' => ['label' => 'Email ID', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'dob' => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining' => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        if ((!empty($_FILES['profile_image']['name']))) 
        {
            $file = $this->request->getFile('profile_image');

            if (!$file->isValid()) {
                $error_msg =  $file->getErrorString();
                $this->ajax_failure_response($error_msg, array(), NO);
                return;
            }

            // Upload path
            $uploadPath = ROOTPATH . 'public/assets/images/profile/';

            // Create folder if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Get original extension (e.g. jpg, pdf)
            $extension = $file->getClientExtension();

            // Generate unique file name
            $uniqueName = uniqid('profile_', true) . '.' . $extension;

            // Move the file
            $file->move(ROOTPATH . 'public/assets/images/profile', $uniqueName);

            // Save unique file name
            $admin_details['profile_image'] = $uniqueName;
        }
        
        $admin_details['user_name'] = $this->request->getPost('user_name');
        $admin_details['email_id'] = $this->request->getPost('email_id');
        $admin_details['password'] = $this->request->getPost('password');
        $admin_details['phone'] = $this->request->getPost('phone');
        $admin_details['dob'] = $this->request->getPost('dob');
        $admin_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $admin_details['pan_card'] = $this->request->getPost('pan_card');
        $admin_details['aadhaar_card'] = $this->request->getPost('aadhaar_card');
        $admin_details['address'] = $this->request->getPost('address');
        $admin_details['created_by'] = 1;
        $admin_details['created_on'] = get_current_datetime_for_db();

        //email validation Start
        $email_user = $this->user_library->email_check($admin_details['email_id']);
        if(count($email_user) > 0)
        {
            $this->ajax_failure_response('Unable to Create, Email already existed!', array(), NO);
            return;
        }

        $this->db->transStart();

        $insert_admin = $this->user_library->insert_user($admin_details);
        if($insert_admin === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting user data, info: '.print_r($admin_details, true));
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

       $insert_id = $insert_admin; // Insert record, returns insert ID

        // Generate employee code
        $prefix = "DECA";
        $employee_code = $prefix . str_pad($insert_id, 4, '0', STR_PAD_LEFT);

        // Update employee_code after insert
        $admin_update_info['employee_code'] = $employee_code;

        $update_admin_result = $this->user_library->update_user($insert_id,$admin_update_info);
        if($update_admin_result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($admin_update_info, true));
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $user_role_map_info['user_id'] = $insert_admin;
        $user_role_map_info['role_id'] = 2;
        $user_role_map_info['created_by'] = 1;
        $user_role_map_info['created_on'] = get_current_datetime_for_db();

        $insert_user_role = $this->user_roles_library->insert_user_role($user_role_map_info);
        if($insert_user_role === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting user role data, info: '.print_r($user_role_map_info, true));
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $this->db->transComplete();
        $this->ajax_success_response('Successfully Add Admin!', array(), 'Yes');
        return;
    }

    public function ajax_get_edit_admin_details()
    {
        $enc_user_id = $this->request->getPost('value');
        $user_id = get_decoded_value($enc_user_id);

        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting user id, user id: ' .$user_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $user_result = $this->user_library->get_user_data_user_id($user_id);
        if($user_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $output = '';
       $output = '<div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic" id="previewContainer">
                                    <img id="previewImage"
                                        src="'.(!empty($user_result['profile_image']) ? base_url("assets/images/profile/".$user_result['profile_image']) : base_url("assets/images/profile/profile_icon.png")).'"
                                        alt="Profile Image />
                                    <span id="defaultIcon"></span>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="previous_profile_name" value="'.$user_result['profile_image'].'">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="user_name" value="'.$user_result['user_name'].'">
                                <input type="hidden" class="form-control" name="user_id" value="'.deccan_encode($user_result['user_id']).'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_id" value="'.$user_result['email_id'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="password" id="passwordField" value="'.$user_result['password'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" value="'.$user_result['phone'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">DOB <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dob" value="'.$user_result['dob'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Date of joining <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_joining" value="'.$user_result['date_of_joining'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">PANCARD</label>
                                <input type="text" class="form-control" name="pan_card" value="'.$user_result['pan_card'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">AADHAAR CARD</label>
                                <input type="text" class="form-control" name="aadhaar_card" value="'.$user_result['aadhaar_card'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address">'.$user_result['address'].'</textarea>
                            </div>
                        </div>
                    </div>';

                    $response_data['edit_values'] = $output;

		                
	    $this->ajax_success_response('Success get Admin details', $response_data, NO);
        return;
    }

    public function ajax_update_admin()
    {
       $rules = [
            'user_name' => ['label' => 'User Name', 'rules' => 'required'],
            'email_id' => ['label' => 'Email ID', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'dob' => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining' => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
          
        ];
        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        $enc_user_id = $this->request->getPost('user_id');
        $user_id = get_decoded_value($enc_user_id);
       
        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_id, true));
            $this->ajax_failure_response('Something went wrong, Please try again later!');
            return;
        }

         //email validation Start
        $email_user = $this->user_library->email_update_check($user_id, $this->request->getPost('email_id'));
        if(count($email_user) > 0)
         {
            $this->ajax_failure_response('Unable to Update, Email already existed!', array(), NO);
            return;
         }
        //email validation End
        
        if ((!empty($_FILES['profile_image']['name']))) 
        {
            if (!empty($this->request->getPost('previous_profile_name'))) {
                $oldImagePath = ROOTPATH . 'public/assets/images/profile/' . $this->request->getPost('previous_profile_name');

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // DELETE FILE
                }
            }
            
            $file = $this->request->getFile('profile_image');

            if (!$file->isValid()) {
                $error_msg =  $file->getErrorString();
                $this->ajax_failure_response($error_msg, array(), NO);
                return;
            }

            // Upload path
            $uploadPath = ROOTPATH . 'public/assets/images/profile/';

            // Create folder if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Get original extension (e.g. jpg, pdf)
            $extension = $file->getClientExtension();

            // Generate unique file name
            $uniqueName = uniqid('profile_', true) . '.' . $extension;

            // Move the file
            $file->move(ROOTPATH . 'public/assets/images/profile', $uniqueName);

            // Save unique file name
            $update_admin_details['profile_image'] = $uniqueName;
        }
        
        $update_admin_details['user_name'] = $this->request->getPost('user_name');
        $update_admin_details['email_id'] = $this->request->getPost('email_id');
        $update_admin_details['password'] = $this->request->getPost('password');
        $update_admin_details['phone'] = $this->request->getPost('phone');
        $update_admin_details['dob'] = $this->request->getPost('dob');
        $update_admin_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $update_admin_details['pan_card'] = $this->request->getPost('pan_card');
        $update_admin_details['aadhaar_card'] = $this->request->getPost('aadhaar_card');
        $update_admin_details['address'] = $this->request->getPost('address');
        
        // $this->db->transStart();

        $update_admin_result = $this->user_library->update_user($user_id,$update_admin_details);
        if($update_admin_result === false)
        {
            // $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($update_admin_details, true));
            $this->ajax_failure_response('Something went wrong, Please try again later!');
            return;
        }

        // $user_role_info = $this->user_roles_library->get_user_roles_by_user_id($user_id);
        // if($user_role_info === false)
        // {
        //     log_message('error', __METHOD__.' error while getting role data, user id: '.$user_id);
        //     $this->ajax_failure_response('Something went wrong, Please try again later!');
        //     return false;
        // }

        
        // $enc_role_id = $this->request->getPost('role_id');
        // $role_id = get_decoded_value($enc_role_id);

        // if($user_role_info['role_id'] !== $role_id)
        // {
        //     $role_info['role_id'] = $role_id;
        //     $role_info['updated_on'] = get_current_datetime_for_db();
        //     $role_info['updated_by'] = session()->get('user_id');

        //     $update_role_info = $this->user_roles_library->update_user_role_by_user_id($user_id, $role_info);
        //     if($update_role_info === false)
        //     {
        //         $this->db->transRollback();
        //         log_message('error', __METHOD__.' error while getting role data, user id: '.$user_id);
        //         $this->ajax_failure_response('Unable to Update User Details');
        //         return false;
        //     }

        //     $this->db->transComplete();
        //     $this->ajax_success_response('Successfully User data updated!', array(), 'Yes');
		//     return;
        // }
        
        // $this->db->transComplete();
        $this->ajax_success_response('Successfully updated Admin Details!', array(), 'Yes');
        return;
    }

    // get user details for delete user(Deccan)
    public function ajax_get_delete_user_details()
    {
        $enc_user_id = $this->request->getPost('value');
        $user_id = get_decoded_value($enc_user_id);

        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting user id, user id: ' .$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }

        $user_result = $this->user_library->get_user_data_user_id($user_id);
        if($user_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }

        $output = '';
        $output.='<div class="text-center">
					<div class="avatar avatar-xl bg-danger-light rounded-circle mb-3">
						<i class="ti ti-trash-x fs-36 text-danger"></i>
					</div>
					<h4 class="mb-2">Delete?</h4>
					<p class="mb-0">Are you sure you want to Delete?<br> <Strong>'.$user_result['user_name'].'('.$user_result['employee_code'].')</Strong></p>
                    <input type="hidden" class="form-control" value="'.deccan_encode($user_result['user_id']).'" name="user_id" />
					<div class="d-flex align-items-center justify-content-center mt-4">
						<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
						<button type="submit" class="btn btn-danger">Yes, Delete it</button>
					</div>
				</div>';

        $response_data['delete_values'] = $output;
		                
	    $this->ajax_success_response('Please check the details before deleting.', $response_data, NO);
        return;
    }

    public function ajax_delete_user()
    {

        $enc_user_id = $this->request->getPost('user_id');
        $user_id = get_decoded_value($enc_user_id);

        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_id, true));
            $this->ajax_failure_response('Unable to delete details, please try later');
            return;
        }

        $this->db->transStart();

        $delete_user = $this->user_library->delete_user($user_id);
        if($delete_user === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while deleting user data, user id: '.$user_id);
            $this->ajax_failure_response('Unable to delete details, please try later');
            return;
        }
        
        $delete_user_role = $this->user_roles_library->delete_user_role($user_id);
        if($delete_user_role === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while deleting user role data, user id: '.$user_id);
            $this->ajax_failure_response('Unable to delete details, please try later');
            return;
        }

        $this->db->transComplete();
        $this->ajax_success_response('Successfully Delete!', array(), 'Yes');
        return;
    }


    public function super_admins()
	{
        $data = array();

        $user_roles = [1];

        $super_admin_info = $this->user_library->get_user_details_by_user_roles($user_roles);
        if($super_admin_info === false)
        {
            log_message('error', __METHOD__.' error while getting user data for roles: '.implode(', ', $user_roles));
            $this->set_flash_error('Unable to get users, please try later');
            return redirect()->to('dashboard');
        }
		$data['super_admin_data'] = $super_admin_info;

	    return $this->generateView('content_panel/User_Management/super_admins_view',$data);
	}

    // Add super admin
    public function ajax_add_super_admin()
    {
       $rules = [
            'user_name' => ['label' => 'User Name', 'rules' => 'required'],
            'email_id' => ['label' => 'Email ID', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'dob' => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining' => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        if ((!empty($_FILES['profile_image']['name']))) 
        {
            $file = $this->request->getFile('profile_image');

            if (!$file->isValid()) {
                $error_msg =  $file->getErrorString();
                $this->ajax_failure_response($error_msg, array(), NO);
                return;
            }

            // Upload path
            $uploadPath = ROOTPATH . 'public/assets/images/profile/';

            // Create folder if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Get original extension (e.g. jpg, pdf)
            $extension = $file->getClientExtension();

            // Generate unique file name
            $uniqueName = uniqid('profile_', true) . '.' . $extension;

            // Move the file
            $file->move(ROOTPATH . 'public/assets/images/profile', $uniqueName);

            // Save unique file name
            $super_admin_details['profile_image'] = $uniqueName;
        }
        
        $super_admin_details['user_name'] = $this->request->getPost('user_name');
        $super_admin_details['email_id'] = $this->request->getPost('email_id');
        $super_admin_details['password'] = $this->request->getPost('password');
        $super_admin_details['phone'] = $this->request->getPost('phone');
        $super_admin_details['dob'] = $this->request->getPost('dob');
        $super_admin_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $super_admin_details['pan_card'] = $this->request->getPost('pan_card');
        $super_admin_details['aadhaar_card'] = $this->request->getPost('aadhaar_card');
        $super_admin_details['address'] = $this->request->getPost('address');
        $super_admin_details['created_by'] = 1;
        $super_admin_details['created_on'] = get_current_datetime_for_db();

        //email validation Start
        $email_user = $this->user_library->email_check($super_admin_details['email_id']);
        if(count($email_user) > 0)
        {
            $this->ajax_failure_response('Unable to Created Super Admin, Email already existed!', array(), NO);
            return;
        }

        $this->db->transStart();

        $insert_super_admin = $this->user_library->insert_user($super_admin_details);
        if($insert_super_admin === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting user data, info: '.print_r($super_admin_details, true));
            $this->ajax_failure_response('Unable to Created Super Admin, please try later');
            return;
        }

       $insert_id = $insert_super_admin; // Insert record, returns insert ID

        // Generate employee code
        $prefix = "DECSA";
        $employee_code = $prefix . str_pad($insert_id, 4, '0', STR_PAD_LEFT);

        // Update employee_code after insert
        $super_admin_update_info['employee_code'] = $employee_code;

        $update_super_admin_result = $this->user_library->update_user($insert_id,$super_admin_update_info);
        if($update_super_admin_result === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($super_admin_update_info, true));
            $this->ajax_failure_response('Unable to Created Super Admin, please try later');
            return;
        }

        $user_role_map_info['user_id'] = $insert_id;
        $user_role_map_info['role_id'] = 1;
        $user_role_map_info['created_by'] = 1;
        $user_role_map_info['created_on'] = get_current_datetime_for_db();

        $insert_user_role = $this->user_roles_library->insert_user_role($user_role_map_info);
        if($insert_user_role === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting user role data, info: '.print_r($user_role_map_info, true));
            $this->ajax_failure_response('Unable to Created Super Admin, please try later');
            return;
        }

        $this->db->transComplete();
        $this->ajax_success_response('Successfully Created Super Admin!', array(), 'Yes');
        return;
    }

    // Ajax Super Admin Edit
    public function ajax_get_edit_super_admin_details()
    {
        $enc_user_id = $this->request->getPost('value');
        $user_id = get_decoded_value($enc_user_id);

        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting user id, user id: ' .$user_id);
            $this->ajax_failure_response('Unable to get Super Admin details, please try later');
            return;
        }

        $user_result = $this->user_library->get_user_data_user_id($user_id);
        if($user_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Unable to get Super Admin details, please try later');
            return;
        }

        $output = '';
       $output = '<div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic" id="previewContainer">
                                    <img id="previewImage"
                                        src="'.(!empty($user_result['profile_image']) ? base_url("assets/images/profile/".$user_result['profile_image']) : base_url("assets/images/profile/profile_icon.png")).'"
                                        alt="Profile Image />
                                    <span id="defaultIcon"></span>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="previous_profile_name" value="'.$user_result['profile_image'].'">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="user_name" value="'.$user_result['user_name'].'">
                                <input type="hidden" class="form-control" name="user_id" value="'.deccan_encode($user_result['user_id']).'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_id" value="'.$user_result['email_id'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="password" id="passwordField" value="'.$user_result['password'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" value="'.$user_result['phone'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">DOB <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dob" value="'.$user_result['dob'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Date of joining <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_joining" value="'.$user_result['date_of_joining'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">PANCARD</label>
                                <input type="text" class="form-control" name="pan_card" value="'.$user_result['pan_card'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">AADHAAR CARD</label>
                                <input type="text" class="form-control" name="aadhaar_card" value="'.$user_result['aadhaar_card'].'">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address">'.$user_result['address'].'</textarea>
                            </div>
                        </div>
                    </div>';

                    $response_data['edit_values'] = $output;

		                
	    $this->ajax_success_response('Success Get Super Admin Details', $response_data, NO);
        return;
    }

    // Super Admin Update
    public function ajax_update_super_admin()
    {
       $rules = [
            'user_name' => ['label' => 'User Name', 'rules' => 'required'],
            'email_id' => ['label' => 'Email ID', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'dob' => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining' => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
          
        ];
        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        $enc_user_id = $this->request->getPost('user_id');
        $user_id = get_decoded_value($enc_user_id);
       
        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_id, true));
            $this->ajax_failure_response('Unable to Update Super Admin Details');
            return;
        }

         //email validation Start
        $email_user = $this->user_library->email_update_check($user_id, $this->request->getPost('email_id'));
        if(count($email_user) > 0)
         {
            $this->ajax_failure_response('Unable to Update, Email already existed!', array(), NO);
            return;
         }
        //email validation End
        
        if ((!empty($_FILES['profile_image']['name']))) 
        {
            if (!empty($this->request->getPost('previous_profile_name'))) {
                $oldImagePath = ROOTPATH . 'public/assets/images/profile/' . $this->request->getPost('previous_profile_name');

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // DELETE FILE
                }
            }
            
            $file = $this->request->getFile('profile_image');

            if (!$file->isValid()) {
                $error_msg =  $file->getErrorString();
                $this->ajax_failure_response($error_msg, array(), NO);
                return;
            }

            // Upload path
            $uploadPath = ROOTPATH . 'public/assets/images/profile/';

            // Create folder if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Get original extension (e.g. jpg, pdf)
            $extension = $file->getClientExtension();

            // Generate unique file name
            $uniqueName = uniqid('profile_', true) . '.' . $extension;

            // Move the file
            $file->move(ROOTPATH . 'public/assets/images/profile', $uniqueName);

            // Save unique file name
            $update_super_admin_details['profile_image'] = $uniqueName;
        }
        
        $update_super_admin_details['user_name'] = $this->request->getPost('user_name');
        $update_super_admin_details['email_id'] = $this->request->getPost('email_id');
        $update_super_admin_details['password'] = $this->request->getPost('password');
        $update_super_admin_details['phone'] = $this->request->getPost('phone');
        $update_super_admin_details['dob'] = $this->request->getPost('dob');
        $update_super_admin_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $update_super_admin_details['pan_card'] = $this->request->getPost('pan_card');
        $update_super_admin_details['aadhaar_card'] = $this->request->getPost('aadhaar_card');
        $update_super_admin_details['address'] = $this->request->getPost('address');
        
        // $this->db->transStart();

        $update_super_admin_result = $this->user_library->update_user($user_id,$update_super_admin_details);
        if($update_super_admin_result === false)
        {
            // $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($update_super_admin_details, true));
            $this->ajax_failure_response('Unable to Update Super Admin Details');
            return;
        }

        // $user_role_info = $this->user_roles_library->get_user_roles_by_user_id($user_id);
        // if($user_role_info === false)
        // {
        //     log_message('error', __METHOD__.' error while getting role data, user id: '.$user_id);
        //     $this->ajax_failure_response('Unable to Update Super Admin Details');
        //     return false;
        // }

        
        // $enc_role_id = $this->request->getPost('role_id');
        // $role_id = get_decoded_value($enc_role_id);

        // if($user_role_info['role_id'] !== $role_id)
        // {
        //     $role_info['role_id'] = $role_id;
        //     $role_info['updated_on'] = get_current_datetime_for_db();
        //     $role_info['updated_by'] = session()->get('user_id');

        //     $update_role_info = $this->user_roles_library->update_user_role_by_user_id($user_id, $role_info);
        //     if($update_role_info === false)
        //     {
        //         $this->db->transRollback();
        //         log_message('error', __METHOD__.' error while getting role data, user id: '.$user_id);
        //         $this->ajax_failure_response('Unable to Update User Details');
        //         return false;
        //     }

        //     $this->db->transComplete();
        //     $this->ajax_success_response('Successfully User data updated!', array(), 'Yes');
		//     return;
        // }
        
        // $this->db->transComplete();
        $this->ajax_success_response('Successfully updated Super Admin details!', array(), 'Yes');
        return;
    }

    
    // get user details for change status user(Deccan)
    public function ajax_get_user_status_details($seg1 = false)
    {
        $enc_user_id = $this->request->getPost('value');
        $user_id = get_decoded_value($enc_user_id);

        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting user id, user id: ' .$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }

        $enc_user_status = $seg1;
        $user_status = get_decoded_value($enc_user_status);

        $user_result = $this->user_library->get_user_data_user_id($user_id);
        if($user_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }

        $output = '';
        $output .= '<div class="text-center">
                        <div class="avatar avatar-xl bg-warning-light rounded-circle mb-3">
                            <i class="ti ti-refresh fs-36 text-warning"></i>
                        </div>
                        <h4 class="mb-2"><strong>'.$user_status.'</strong> User</h4>
                        <p class="mb-0">Are you sure you want to <strong>'.$user_status.'</strong> this user?<br>
                        <strong>'.$user_result['user_name'].' ('.$user_result['employee_code'].')</strong></p>

                        <input type="hidden" class="form-control" value="'.deccan_encode($user_result['user_id']).'" name="user_id" />
                        <input type="hidden" class="form-control" value="'.deccan_encode($user_status).'" name="user_status" />

                        <div class="d-flex align-items-center justify-content-center mt-4">
                            <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary">Yes, Confirm</button>
                        </div>
                    </div>';


        $response_data['status_values'] = $output;
		                
	    $this->ajax_success_response('Please check the details before '.$user_status.'', $response_data, NO);
        return;
    }

    public function ajax_status_update_user()
    {
        $enc_user_id = $this->request->getPost('user_id');
        $user_id = get_decoded_value($enc_user_id);
       
        if(empty($enc_user_id) || empty($user_id) || $user_id === false)
        {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_id, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        $enc_user_status = $this->request->getPost('user_status');
        $user_status = get_decoded_value($enc_user_status);
       
        if(empty($enc_user_status) || empty($user_status) || $user_status === false)
        {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_status, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        $user_status_info['status'] = $user_status;
        $user_status_info['updated_by'] = 1;
        $user_status_info['updated_on'] = get_current_datetime_for_db();

        $update_user_status_result = $this->user_library->update_user_status($user_id, $user_status_info);
        if($update_user_status_result === false)
        {
            log_message('error', __METHOD__.' error while updating user role with user id: ,'.$user_id.', info: '.print_r($user_status_info, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        $this->ajax_success_response('Successfully '.$user_status.' the User', array(), 'Yes');
        return;
    }

    // public function user_profile()
    // {
    //     $user_id = session()->get('user_id');  
    //     $user_data = $this->user_library->get_user_data_user_id($user_id);
    //         if($user_data === false)
    //         {
    //             log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
    //             $this->set_flash_error('Unable to get  User data, please try later');
    //             return redirect()->to('dashboard');
    //         }
    //     $data['user'] = $user_data;    
    //     // var_dump( $data['user']);
    //     // exit();
    //     return $this->generateView('content_panel/User_Management/users_profile_view',$data);    
    // }

    // public function ajax_edit_profile()
	// {  
    //     $data = array();
    //     $rules = [
    //     'name' => ['label' => 'Company Name', 'rules' => 'trim|required'],
    //     'phone' => ['label' => 'Phone', 'rules' => 'trim|required|numeric']
    //     ];
    //     if ($this->validate($rules) === false) 
    //     {
    //     $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
    //     return;
    //     }
    //     $user_id = session()->get('user_id');
    //     if((!empty($_FILES['image']['name']))){
    //     $file = $this->request->getFile('image');
    //     if (!$file->isValid())
    //     {
    //     return $this->fail($file->getErrorString());
    //     }
    //     $file->move(ROOTPATH . 'public/assets/images/profile/');
    //     $user_update_data['image'] = $file->getName();
    //     }
    //     $user_update_data['user_name'] = $this->request->getPost('name');
    //     $user_update_data['phone'] = $this->request->getPost('phone');
    //     $user_update_data['updated_on'] = get_current_datetime_for_db();
    //     $user_update_data['updated_by'] = session()->get('user_id');
    //     $update_user = $this->user_library->update_user($user_id,$user_update_data);
    //     if($update_user === false)
    //     {
    //     log_message('error', __METHOD__.' error while updating User Profile data, data: '.print_r($user_update_data, true));
    //     $this->ajax_failure_response('unable to update, please try again', array(), 'NO');
    //     return;
    //     }
    //     $this->ajax_success_response('User information updated!', array(), 'Yes');
    //     return;
	// }
}