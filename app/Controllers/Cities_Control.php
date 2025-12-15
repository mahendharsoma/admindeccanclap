<?php

namespace App\Controllers;
use App\Libraries\Cities_Library;

class Cities_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->cities_library = new Cities_Library();
       
    }
    public function index()
	{
        
        $data['nav'] = 'cities';
        $cities = $this->cities_library->get_data();
        if($cities === false)
        {
            log_message('error', __METHOD__.' error while getting data');
            $this->set_flash_error('Unable to get data, please try later');
            return redirect()->to('dashboard');
        }
		$data['cities'] = $cities;

	    return $this->generateView('content_panel/Cities/cities_view',$data);
	}
	public function ajax_add_city()
    {
       $rules = [
            'city_name' => ['label' => 'City Name', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        
        $city_details['city_name'] = $this->request->getPost('city_name');
        $city_details['created_by'] = session()->get('user_id');
        $city_details['created_on'] = get_current_datetime_for_db();
        $insert_city = $this->cities_library->insert_data($city_details);
        if($insert_city === false)
        {
            $this->db->transRollback();
            log_message('error', __METHOD__.' error while inserting  data, info: '.print_r($city_details, true));
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

       
        $this->ajax_success_response('Successfully Added!', array(), 'Yes');
        return;
    }
    
    public function ajax_edit_city()
    {
        $enc_city_id = $this->request->getPost('value');
        $city_id = get_decoded_value($enc_city_id);

        if(empty($enc_city_id) || empty($city_id) || $city_id === false)
        {
            log_message('error', __METHOD__ . ' error while getting City id, City id: ' .$city_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $city_result = $this->cities_library->get_data_by_id($city_id);
        if($city_result === false)
        {
            log_message('error', __METHOD__.' error while getting  details by city_id: '.$city_id);
            $this->ajax_failure_response('Something went wrong, please try later');
            return;
        }

        $output = '';
       $output = '<div class="row">
                <div class="col-md-12">
                <div class="mb-3">
                <label class="col-form-label">City Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="city_name" value="'.$city_result['city_name'].'">
                <input type="hidden" class="form-control" name="city_id" value="'.deccan_encode($city_result['city_id']).'">
                </div>
                </div>
                </div>';
                $response_data['edit_values'] = $output;

		                
	    $this->ajax_success_response('Success get  details', $response_data, NO);
        return;
    }
    public function ajax_update_city()
    {
       
        $rules = [
            'city_name' => ['label' => 'City Name', 'rules' => 'required'],
            'city_id' => ['label' => 'City Id', 'rules' => 'required']
        ];

        if ($this->validate($rules) === false) 
        {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        $city_id  = get_decoded_value($this->request->getPost('city_id'));
        $city_details['city_name'] = $this->request->getPost('city_name');
        $city_details['updated_by'] = session()->get('user_id');
        $city_details['updated_on'] = get_current_datetime_for_db();
        
        $update_city_data = $this->cities_library->update_data($city_id,$city_details);
        if($update_city_data === false)
        {
          
            log_message('error', __METHOD__.' error while updating city data, data: '.print_r($city_details, true));
            $this->ajax_failure_response('Something went wrong, Please try again later!');
            return;
        }

        

        
        $this->ajax_success_response('Successfully updated Data!', array(), 'Yes');
        return;
    }
    public function ajax_delete_city()
    {
        $city_id = get_decoded_value($this->request->getPost('post_value'));

        $delete_city = $this->cities_library->delete_data($city_id);

        if ($delete_city === false) 
        {
            log_message('error', __METHOD__.'Could not delete City , where  City id: '.$city_id);
            $this->ajax_failure_response('Unable to delete City, please try again', array(), 'NO');
            return;
        }

        $this->ajax_success_response('Deleted Successfully', array(), 'Yes');
        return;
    }

}