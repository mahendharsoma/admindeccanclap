<?php

namespace App\Controllers;
use App\Libraries\User_Library;
use App\Libraries\User_Roles_Library;

class Field_Sales_Executive_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->user_library = new User_Library();
        $this->user_roles_library = new User_Roles_Library();
       
    }

    public function index($seg1 = false, $seg2 = false)
	{
        $data = array();
        // $data["admins_url"] = base_url('admins');

        $user_roles = [2];

        $admin_info = $this->user_library->get_active_user_details_by_user_roles($user_roles);
        if($admin_info === false)
        {
            log_message('error', __METHOD__.' error while getting user data for roles: '.implode(', ', $user_roles));
            $this->set_flash_error('Unable to get users, please try later');
            return redirect()->to('dashboard');
        }
		$data['active_admin_data'] = $admin_info;

        $enc_parent_id = $seg1;
        $parent_id = get_decoded_value($enc_parent_id);

        if(!empty($enc_parent_id) && !empty($parent_id)){

            $data['selected_parent_id'] = $parent_id;

            $user_roles = [3];

            $sales_managers_info = $this->user_library->get_user_details_by_user_roles_and_user_id($user_roles, $parent_id);
            if($sales_managers_info === false)
            {
                log_message('error', __METHOD__.' error while getting user data for roles: '.implode(', ', $user_roles));
                $this->set_flash_error('Unable to get users, please try later');
                return redirect()->to('dashboard');
            }
            $data['sales_managers_data'] = $sales_managers_info;

            $enc_sales_manager_id = $seg2;
            $sales_manager_id = get_decoded_value($enc_sales_manager_id);

            if(!empty($sales_manager_id) && !empty($sales_manager_id))
            {

                $data['selected_sales_manager_id'] = $sales_manager_id;

                $user_roles = [5];

                $field_sales_executives_info = $this->user_library->get_user_details_by_user_roles_and_user_id($user_roles, $sales_manager_id);
                if($field_sales_executives_info === false)
                {
                    log_message('error', __METHOD__.' error while getting user data for roles: '.implode(', ', $user_roles));
                    $this->set_flash_error('Unable to get users, please try later');
                    return redirect()->to('dashboard');
                }
                $data['field_sales_executives_data'] = $field_sales_executives_info;
            }
        }

	    return $this->generateView('content_panel/User_Management/field_sales_executives_view',$data);
	}

    public function ajax_add_field_sales_executive()
    {
       // --------------------- VALIDATION ---------------------
        $rules = [
            'user_name'        => ['label' => 'User Name', 'rules' => 'required'],
            'email_id'         => ['label' => 'Email ID', 'rules' => 'required'],
            'phone'            => ['label' => 'Phone', 'rules' => 'required'],
            'password'         => ['label' => 'Password', 'rules' => 'required'],
            'dob'              => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining'  => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address'          => ['label' => 'Address', 'rules' => 'required'],
            'bank_account_number'  => ['label' => 'Bank Account Number', 'rules' => 'required'],
            'ifsc_code'          => ['label' => 'IFSC Code', 'rules' => 'required'],
            'bank_name'          => ['label' => 'Bank Name', 'rules' => 'required'],
            'branch_name'          => ['label' => 'Branch Name', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        // --------------------- MANDATORY DOCUMENTS CHECK ---------------------
        $mandatoryDocs = [
            'pan_image'           => 'Pancard Image',
            'aadhaar_image'       => 'Aadhaar Image',
            'agreement_file'      => 'Agreement File',
            'bank_passbook_image' => 'Bank Passbook Image'
        ];

        foreach ($mandatoryDocs as $field => $label) {
            if (empty($_FILES[$field]['name'])) {
                return $this->ajax_failure_response("$label is required.", [], NO);
            }
        }


        // --------------------- PROFILE IMAGE UPLOAD ---------------------
        $user_details = [];

        if (!empty($_FILES['profile_image']['name'])) 
        {
            $file = $this->request->getFile('profile_image');

            if ($file->isValid()) 
            {
                $uploadPath = ROOTPATH . 'public/assets/images/profile/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $ext = $file->getClientExtension();
                $uniqueName = uniqid('profile_', true) . '.' . $ext;

                $file->move($uploadPath, $uniqueName);

                $user_details['profile_image'] = $uniqueName;
            }
        }

        // --------------------- COLLECT USER DATA ---------------------
        $user_details['user_name']  = $this->request->getPost('user_name');
        $user_details['email_id']   = $this->request->getPost('email_id');
        $user_details['password']   = $this->request->getPost('password');
        $user_details['phone']      = $this->request->getPost('phone');
        $user_details['dob']        = $this->request->getPost('dob');
        $user_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $user_details['pan_card']        = $this->request->getPost('pan_card');
        $user_details['aadhaar_card']    = $this->request->getPost('aadhaar_card');
        $user_details['address']         = $this->request->getPost('address');
        $user_details['parent_id']       = get_decoded_value($this->request->getPost('parent_id'));
        $user_details['created_by']      = 1;
        $user_details['created_on']      = get_current_datetime_for_db();


        // --------------------- EMAIL CHECK ---------------------
        $email_user = $this->user_library->email_check($user_details['email_id']);
        if (count($email_user) > 0) {
            $this->ajax_failure_response('Unable to Create, Email already existed!', array(), NO);
            return;
        }


        // --------------------- START TRANSACTION ---------------------
        $this->db->transStart();

        // --------------------- INSERT USER ---------------------
        $insert_id = $this->user_library->insert_user($user_details);
        if (empty($insert_id)) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while insert user data: '.print_r($user_details, true));
            $this->ajax_failure_response("Error while inserting user information.");
            return;
        }


        // --------------------- GENERATE EMPLOYEE CODE ---------------------
        $employee_code = "DECSM" . str_pad($insert_id, 4, '0', STR_PAD_LEFT);
        $update_user_info['employee_code'] = $employee_code;

        $update_user_info = $this->user_library->update_user($insert_id, $update_user_info);
        if (empty($update_user_info)) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while Update user data: '.print_r($update_user_info, true));
            $this->ajax_failure_response("Unable to generate employee code, Please try again later.", array(), 'YES');
            return;
        }

        // Initialize bank details array first
        $user_bank_details = [
            'user_id' => $insert_id,
            'bank_account_number' => $this->request->getPost('bank_account_number'),
            'ifsc_code' => $this->request->getPost('ifsc_code'),
            'bank_name' => $this->request->getPost('bank_name'),
            'branch_name' => $this->request->getPost('branch_name'),
            'created_by' => 1,
            'created_on' => get_current_datetime_for_db()
        ];

        // Upload bank passbook image
        if (!empty($_FILES['bank_passbook_image']['name'])) 
        {
            $file = $this->request->getFile('bank_passbook_image');

            if ($file->isValid()) 
            {
                $uploadPath = ROOTPATH . 'public/assets/images/bank_passbook/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $ext = $file->getClientExtension();
                $uniqueName = uniqid('bank_passbook_', true) . '.' . $ext;

                $file->move($uploadPath, $uniqueName);

                // Add image name into the same array
                $user_bank_details['bank_passbook_image'] = $uniqueName;
            }
        }


        $insert_user_bank_result = $this->user_library->insert_user_bank_details($user_bank_details);
        if (empty($insert_user_bank_result)) {
            $this->db->transRollback();
                log_message('error', __METHOD__.' error while insert user bank details: '.print_r($user_bank_details, true));
            $this->ajax_failure_response("Unable to upload bank details. Please try again later.", array(), 'YES');
            return;
        }

        // --------------------- DOCUMENT UPLOADS ---------------------
        $documentFields = [
            'pan_image'           => 'PANCARD',
            'aadhaar_image'       => 'AADHAAR CARD',
            'agreement_file'      => 'AGREEMENT',
        ];

        $uploadPath = ROOTPATH . 'public/uploads/user_documents/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        foreach ($documentFields as $fieldName => $docType) 
        {
            if (!empty($_FILES[$fieldName]['name'])) 
            {
                $file = $this->request->getFile($fieldName);

                if ($file->isValid()) 
                {
                    $ext = $file->getClientExtension();
                    $uniqueName = uniqid($fieldName . '_', true) . '.' . $ext;

                    $file->move($uploadPath, $uniqueName);

                    // Save to user_document table
                    $docData = [
                        'user_id' => $insert_id,
                        'user_document_type' => $docType,
                        'user_document_url'  => $uniqueName,
                        'created_by'         => 1,
                        'created_on'         => get_current_datetime_for_db()
                    ];

                    $insert_user_doc_result = $this->user_library->insert_user_document($docData);
                    if (empty($insert_user_doc_result)) {
                        $this->db->transRollback();
                            log_message('error', __METHOD__.' error while insert user document data: '.print_r($docData, true));
                        $this->ajax_failure_response("Failed uploading $docType document. Please try again later.", array(), 'YES');
                        return;
                    }
                }
            }
        }


        // --------------------- ASSIGN ROLE ---------------------
        $user_role_map_info = [
            'user_id'    => $insert_id,
            'role_id'    => 5,
            'created_by' => 1,
            'created_on' => get_current_datetime_for_db()
        ];

        $insert_user_role_result = $this->user_roles_library->insert_user_role($user_role_map_info);
        if (empty($insert_user_role_result)) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while insert user role data: '.print_r($user_role_map_info, true));
            $this->ajax_failure_response("Unable to create user, Please try again later.", array(), 'YES');
            return;
        }

        // --------------------- COMPLETE TRANSACTION ---------------------
        $this->db->transComplete();
        $this->ajax_success_response('Successfully Created Field Sales Executive!', array(), 'Yes');
        return;
    }

    public function ajax_get_edit_field_sales_executive_details()
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

        $user_bank_details_result = $this->user_library->get_user_bank_data_user_id($user_id);
        if($user_bank_details_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }
        
        $user_doc_details_result = $this->user_library->get_user_doc_data_user_id($user_id);
        if($user_doc_details_result === false)
        {
            log_message('error', __METHOD__.' error while getting user details by user id: '.$user_id);
            $this->ajax_failure_response('Unable to get user details, please try later');
            return;
        }

        // Build HTML Output
        $output = '';

        /* ----------------------------------------------------------
        USER DETAILS
        ---------------------------------------------------------- */
        $output .= '
        <div class="row">
            <div class="col-md-12">
                <div class="profile-pic-upload">
                    <div class="profile-pic" id="previewContainer">
                        <img id="previewImage"
                            src="'.(!empty($user_result['profile_image']) ? base_url("assets/images/profile/".$user_result['profile_image']) : base_url("assets/images/profile/profile_icon.png")).'"
                            alt="Profile Image" />
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

        /* ----------------------------------------------------------
            BANK DETAILS (ADD BELOW USER DETAILS)
        ---------------------------------------------------------- */

        $output .= '
        <hr>
        <h5>Bank Details</h5>
        <div class="row">

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="col-form-label">Account Number</label>
                    <input type="text" class="form-control" name="bank_account_number" value="'.$user_bank_details_result['bank_account_number'].'">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="col-form-label">IFSC Code</label>
                    <input type="text" class="form-control" name="ifsc_code" value="'.$user_bank_details_result['ifsc_code'].'">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="col-form-label">Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" value="'.$user_bank_details_result['bank_name'].'">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="col-form-label">Branch Name</label>
                    <input type="text" class="form-control" name="branch_name" value="'.$user_bank_details_result['branch_name'].'">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="col-form-label">Upload Bank Passbook Image <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="bank_passbook_image" accept="image/*">
                </div>
                <a href="'.base_url("assets/images/bank_passbook/".$user_bank_details_result['bank_passbook_image']).'" target="_blank" class="btn btn-sm btn-info mt-1">View</a>
            </div>
        </div>';

        /* ----------------------------------------------------------
            DOCUMENT DETAILS (ADD BELOW BANK DETAILS)
        ---------------------------------------------------------- */

        $output .= '
        <hr>
        <h5>Document Details</h5>
        <div class="row">';

        foreach ($user_doc_details_result as $doc)
        {
            $fileLink = '';
            if (!empty($doc['user_document_url'])) {
                $fileLink = '<a href="'.base_url("uploads/user_documents/".$doc['user_document_url']).'" target="_blank" class="btn btn-sm btn-info mt-1">View</a>';
            }

            $output .= '
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="col-form-label">'.$doc['user_document_type'].'</label>
                    <input type="file" class="form-control" name="'.$doc['user_document_type'].'">
                    '.$fileLink.'
                </div>
            </div>';
        }

        $output .= '</div>';

        $response_data['edit_values'] = $output;

	    $this->ajax_success_response('Successfully get User details', $response_data, NO);
        return;
    }

    public function ajax_update_field_sales_executive()
    {
       $rules = [
            'user_name'        => ['label' => 'User Name', 'rules' => 'required'],
            'email_id'         => ['label' => 'Email ID', 'rules' => 'required'],
            'phone'            => ['label' => 'Phone', 'rules' => 'required'],
            'password'         => ['label' => 'Password', 'rules' => 'required'],
            'dob'              => ['label' => 'Date of Birth', 'rules' => 'required'],
            'date_of_joining'  => ['label' => 'Date of Joining', 'rules' => 'required'],
            'address'          => ['label' => 'Address', 'rules' => 'required'],
            'bank_account_number'  => ['label' => 'Bank Account Number', 'rules' => 'required'],
            'ifsc_code'          => ['label' => 'IFSC Code', 'rules' => 'required'],
            'bank_name'          => ['label' => 'Bank Name', 'rules' => 'required'],
            'branch_name'          => ['label' => 'Branch Name', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        $enc_user_id = $this->request->getPost('user_id');
        $user_id = get_decoded_value($enc_user_id);

        if (empty($enc_user_id) || empty($user_id) || $user_id === false) {
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($user_id, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        // Email Validation
        $email_user = $this->user_library->email_update_check($user_id, $this->request->getPost('email_id'));
        if (count($email_user) > 0) {
            $this->ajax_failure_response('Unable to Update User, Email already existed!', array(), NO);
            return;
        }

        /* ----------------------------------------------------------
            PROFILE IMAGE
        ---------------------------------------------------------- */
        if (!empty($_FILES['profile_image']['name'])) {
            if (!empty($this->request->getPost('previous_profile_name'))) {
                $oldImagePath = ROOTPATH.'public/assets/images/profile/'.$this->request->getPost('previous_profile_name');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $this->request->getFile('profile_image');
            if (!$file->isValid()) {
                $this->ajax_failure_response($file->getErrorString(), array(), NO);
                return;
            }

            $uploadPath = ROOTPATH.'public/assets/images/profile/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

            $ext = $file->getClientExtension();
            $uniqueName = uniqid('profile_', true).'.'.$ext;
            $file->move($uploadPath, $uniqueName);

            $update_admin_details['profile_image'] = $uniqueName;
        }
        
        $this->db->transStart();

        /* ----------------------------------------------------------
            UPDATE USER MASTER
        ---------------------------------------------------------- */
        $update_admin_details['user_name'] = $this->request->getPost('user_name');
        $update_admin_details['email_id'] = $this->request->getPost('email_id');
        $update_admin_details['password'] = $this->request->getPost('password');
        $update_admin_details['phone'] = $this->request->getPost('phone');
        $update_admin_details['dob'] = $this->request->getPost('dob');
        $update_admin_details['date_of_joining'] = $this->request->getPost('date_of_joining');
        $update_admin_details['pan_card'] = $this->request->getPost('pan_card');
        $update_admin_details['aadhaar_card'] = $this->request->getPost('aadhaar_card');
        $update_admin_details['address'] = $this->request->getPost('address');

        $update_admin_result = $this->user_library->update_user($user_id, $update_admin_details);
        if ($update_admin_result === false) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($update_admin_details, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        /* ----------------------------------------------------------
            UPDATE BANK DETAILS
        ---------------------------------------------------------- */
        $bank_details = [
            'bank_account_number' => $this->request->getPost('bank_account_number'),
            'ifsc_code' => $this->request->getPost('ifsc_code'),
            'bank_name' => $this->request->getPost('bank_name'),
            'branch_name' => $this->request->getPost('branch_name'),
            'updated_on' => get_current_datetime_for_db(),
            'updated_by' => 1
        ];

        // Passbook Upload
        if (!empty($_FILES['bank_passbook_image']['name'])) {
            $file = $this->request->getFile('bank_passbook_image');

            if ($file->isValid()) {
                $uploadPath = ROOTPATH.'public/assets/images/bank_passbook/';
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

                $ext = $file->getClientExtension();
                $uniqueName = uniqid('passbook_', true).'.'.$ext;

                $file->move($uploadPath, $uniqueName);

                $bank_details['bank_passbook_image'] = $uniqueName;
            }
        }

        $update_user_bank_result = $this->user_library->update_bank_details($user_id, $bank_details);
        if ($update_user_bank_result === false) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($bank_details, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        /* ----------------------------------------------------------
            UPDATE DOCUMENTS
        ---------------------------------------------------------- */
        $user_docs = $this->user_library->get_user_doc_data_user_id($user_id);
        if ($user_docs === false) {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($bank_details, true));
            $this->ajax_failure_response('Something went wrong, please try again later');
            return;
        }

        foreach ($user_docs as $doc) 
        {
            $docType = $doc['user_document_type'];

            if (!empty($_FILES[$docType]['name'])) {

                $file = $this->request->getFile($docType);

                if ($file->isValid()) {
                    $uploadPath = ROOTPATH.'public/uploads/user_documents/';
                    if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

                    $ext = $file->getClientExtension();
                    $uniqueName = uniqid('doc_', true).'.'.$ext;
                    $file->move($uploadPath, $uniqueName);

                    $update_doc = [
                        'user_document_url' => $uniqueName,
                        'updated_on' => get_current_datetime_for_db(),
                        'updated_by' => 1
                    ];

                    $update_user_doc = $this->user_library->update_user_document($doc['user_document_id'], $update_doc);
                     if ($update_user_doc === false) {
                        $this->db->transRollback();
                        log_message('error', __METHOD__.' error while updating user, data: '.print_r($update_doc, true));
                        $this->ajax_failure_response('Something went wrong, please try again later');
                        return;
                    }
                }
            }
        }

        /* ----------------------------------------------------------
            SUCCESS RESPONSE
        ---------------------------------------------------------- */
        $this->db->transComplete();
        $this->ajax_success_response('Successfully Field Sales Executive data updated!', array(), 'Yes');
        return;
    }

}