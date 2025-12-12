<?php namespace App\Controllers;
use App\Libraries\Services_Library;
use App\Libraries\Products_Library;
class Products_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->services_library = new Services_Library();
        $this->products_library = new Products_Library();
       $this->db = db_connect();
    } 
    public function index($seg1 = false)
    {
    $data['nav'] = 'products';
    $services = $this->services_library->get_data();
    if ($services === false) 
    {
        $this->set_flash_error('Unable to get Services list, please try later');
        return redirect()->to('home');
    }
    $data['services'] = $services;
    $service_id = get_decoded_value($seg1);
    if(!empty($service_id))
    {
    $data['selected_service_id'] = $service_id;    
    $products = $this->products_library->get_data_by_service($service_id);
    if ($products === false) 
    {
    log_message('error', __METHOD__.' error while getting Products');
    $this->set_flash_error('Unable to get products, please try later');
    return redirect()->to(base_url('home'));
    }
    $data['products'] = $products;
    
    }
    return $this->generateView('content_panel/Services/products_view',$data);
    }
  
     public function ajax_add_product()
     {
         $data = array();

         $rules = [
             'product_name' => ['label' => 'Name', 'rules' => 'trim|required'],
             'service_id' => ['label' => 'Service', 'rules' => 'trim|required']
           ];
         if ($this->validate($rules) === false) {
             $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
             return;
         }
         
         
         $product_data['product_name'] = $this->request->getPost('product_name');
         $product_data['service_id'] = $this->request->getPost('service_id');
         $product_data['created_on'] = get_current_datetime_for_db();
         $product_data['created_by'] = session()->get('user_id');
         
         $insert_data = $this->products_library->insert_data($product_data);
         if ($insert_data === false) {
          
             log_message('error', __METHOD__.'error while inserting  data: '.print_r($product_data,true));
             $this->ajax_failure_response('Something went wrong, please try again later');
             return;
         }
        
        
         $this->ajax_success_response('Added Successfully', array(), YES);
         return;
     }
     public function ajax_edit_product()
     {
         
            $enc_product_id = $this->request->getPost('value');

             $product_id = get_decoded_value($enc_product_id);

             if (empty($enc_product_id) || empty($product_id) || $product_id === false)
             {
                 log_message('error', 'error while getting  data by Product_id '.$product_id);
                 $this->ajax_failure_response('Unable to get product id, please try again', array(), 'NO');
                 return;
             }
            
             $get_product_details = $this->products_library->get_data_by_id($product_id);

             if ($get_product_details === false) 
             {
                 log_message('error', 'error while getting Product data by product_id '.$product_id);
                 $this->ajax_failure_response('Unable to get Product data, please try again', array(), 'NO');
                 return;
             }


             $output='<div class="row">
                <div class="col-md-12">
                <div class="mb-3">
                <label class="col-form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="product_name" value="'.$get_product_details['product_name'].'">
                
                </div>
                </div>
                <input type="hidden" class="form-control" name="product_id" value="'.deccan_encode($get_product_details['product_id']).'">
                </div>
                ';
             $response_data['edit_values'] = $output;
             $response_data['url'] = base_url('ajax_update_product');
             $this->ajax_success_response('Success', $response_data, NO);
             return;
         
     }
    public function ajax_update_product()
    {
        $rules = [
             'product_name' => ['label' => 'Name', 'rules' => 'trim|required'],
             
           ];
        if ($this->validate($rules) === false) {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        $product_id = get_decoded_value($this->request->getPost('product_id'));
        if (empty($product_id) || $product_id === false) 
        {
            log_message('error', __METHOD__.' error while  get product_id: '.$product_id);
            $this->ajax_failure_response('Unable to get  id, please try again', array(), 'NO');
            return;
        }
       
        
        $product_data['product_name'] = $this->request->getPost('product_name');
        $product_data['updated_on'] = get_current_datetime_for_db();
        $product_data['updated_by'] = session()->get('user_id');

        
        $update_product_data = $this->products_library->update_data($product_id,$product_data);

        if ($update_product_data === false)
        {
            log_message('error', __METHOD__.' error while updating  data, data: '.print_r($product_data, true));
            $this->ajax_failure_response('unable to update, please try again', array(), 'NO');
            return;
        }
        $this->ajax_success_response('information updated!', array(), 'Yes');
        return;
    }
    public function ajax_delete_product()
    {
        $product_id = get_decoded_value($this->request->getPost('post_value'));

        $delete_product = $this->products_library->delete_data($product_id);

        if ($delete_product === false) 
        {
            log_message('error', __METHOD__.'Could not delete data , where  product id: '.$product_id);
            $this->ajax_failure_response('Unable to delete Product, please try again', array(), 'NO');
            return;
        }

        $this->ajax_success_response('Deleted Successfully', array(), 'Yes');
        return;
    }
    
    }    