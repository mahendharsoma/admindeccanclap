<?php

namespace App\Controllers;
use App\Libraries\Services_Library;

class Services_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->services_library = new Services_Library();
       
    }
    	public function index()
	{
        
        $data['nav'] = 'services';
        $services = $this->services_library->get_data();
        if($services === false)
        {
            log_message('error', __METHOD__.' error while getting data');
            $this->set_flash_error('Unable to get data, please try later');
            return redirect()->to('dashboard');
        }
		$data['services'] = $services;

	    return $this->generateView('content_panel/Services/services_view',$data);
	}
	public function ajax_add_service()
    {
       $rules = [
            'service_name' => ['label' => 'Service Name', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        
        $service_details['service_name'] = $this->request->getPost('service_name');
        $service_details['created_by'] = session()->get('user_id');
        $service_details['created_on'] = get_current_datetime_for_db();
        $insert_service = $this->services_library->insert_data($service_details);
        if($insert_service === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting  data, info: '.print_r($service_details, true));
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

       
        $this->ajax_success_response('Successfully Added!', array(), 'Yes');
        return;
    }
    
    public function ajax_edit_service()
    {
        $enc_service_id = $this->request->getPost('value');
        $service_id = get_decoded_value($enc_service_id);

        if(empty($enc_service_id) || empty($service_id) || $service_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting Service id, Service id: ' .$service_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $service_result = $this->services_library->get_data_by_id($service_id);
        if($service_result === false)
        {
            log_message('error', __METHOD__.' error while getting  details by service_id: '.$service_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $output = '';
       $output = '<div class="row">
                <div class="col-md-12">
                <div class="mb-3">
                <label class="col-form-label">Service Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="service_name" value="'.$service_result['service_name'].'">
                <input type="hidden" class="form-control" name="service_id" value="'.deccan_encode($service_result['service_id']).'">
                </div>
                </div>
                </div>';
                $response_data['edit_values'] = $output;

		                
	    $this->ajax_success_response('Success get  details', $response_data, NO);
        return;
    }
    public function ajax_update_service()
    {
       
        $rules = [
            'service_name' => ['label' => 'Service Name', 'rules' => 'required'],
            'service_id' => ['label' => 'Service Id', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        $service_id  = get_decoded_value($this->request->getPost('service_id'));
        $service_details['service_name'] = $this->request->getPost('service_name');
        $service_details['updated_by'] = session()->get('user_id');
        $service_details['updated_on'] = get_current_datetime_for_db();
        
        $update_service_data = $this->services_library->update_data($service_id,$service_details);
        if($update_service_data === false)
        {
          
            log_message('error', __METHOD__.' error while updating user, data: '.print_r($service_details, true));
            $this->ajax_failure_response('Something went wrong, Please try again later!');
            return;
        }

        

        
        $this->ajax_success_response('Successfully updated Data!', array(), 'Yes');
        return;
    }
    public function ajax_delete_service()
    {
        $servie_id = get_decoded_value($this->request->getPost('post_value'));

        $delete_service = $this->services_library->delete_data($servie_id);

        if ($delete_service === false) 
        {
            log_message('error', __METHOD__.'Could not delete Service , where  Service id: '.$servie_id);
            $this->ajax_failure_response('Unable to delete Service, please try again', array(), 'NO');
            return;
        }

        $this->ajax_success_response('Deleted Successfully', array(), 'Yes');
        return;
    }

}