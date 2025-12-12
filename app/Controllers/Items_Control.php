<?php namespace App\Controllers;
use App\Libraries\Items_Library;
use App\Libraries\Products_Library;
class Items_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->items_library = new Items_Library();
        $this->products_library = new Products_Library();
       $this->db = db_connect();
    } 
    public function index($seg1 = false)
    {
    $data['nav'] = 'items';
    
    $product_id = get_decoded_value($seg1);
   
    $data['selected_product_id'] = $product_id;    
    $items = $this->items_library->get_data_by_product($product_id);
    if ($items === false) 
    {
    log_message('error', __METHOD__.' error while getting Items');
    $this->set_flash_error('Unable to get Items, please try later');
    return redirect()->to(base_url('home'));
    }
    $data['items'] = $items;
    
    return $this->generateView('content_panel/Services/items_view',$data);
    }
  
    public function ajax_add_item()
    {
         $data = array();

         $rules = [
             'item_name' => ['label' => 'Name', 'rules' => 'trim|required'],
             'product_id' => ['label' => 'Product', 'rules' => 'trim|required']
           ];
         if ($this->validate($rules) === false) {
             $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
             return;
         }
         
         
         $item_data['item_name'] = $this->request->getPost('item_name');
         $item_data['product_id'] = $this->request->getPost('product_id');
         $item_data['created_on'] = get_current_datetime_for_db();
         $item_data['created_by'] = session()->get('user_id');
         
         $insert_data = $this->items_library->insert_data($item_data);
         if ($insert_data === false) {
          
             log_message('error', __METHOD__.'error while inserting  data: '.print_r($item_data,true));
             $this->ajax_failure_response('Something went wrong, please try again later');
             return;
         }
        
        
         $this->ajax_success_response('Added Successfully', array(), YES);
         return;
     }
    public function ajax_edit_item()
    {
         
            $enc_item_id = $this->request->getPost('value');

             $item_id = get_decoded_value($enc_item_id);

             if (empty($enc_item_id) || empty($item_id) || $item_id === false)
             {
                 log_message('error', 'error while getting  data by Item Id '.$item_id);
                 $this->ajax_failure_response('Unable to get  id, please try again', array(), 'NO');
                 return;
             }
            
             $get_item_details = $this->items_library->get_data_by_id($item_id);

             if ($item_id === false) 
             {
                 log_message('error', 'error while getting  data by item_id '.$item_id);
                 $this->ajax_failure_response('Unable to get  data, please try again', array(), 'NO');
                 return;
             }


             $output='<div class="row">
                <div class="col-md-12">
                <div class="mb-3">
                <label class="col-form-label"> Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" value="'.$get_item_details['item_name'].'">
                
                </div>
                </div>
                <input type="hidden" class="form-control" name="item_id" value="'.deccan_encode($get_item_details['item_id']).'">
                </div>
                ';
             $response_data['edit_values'] = $output;
           
             $this->ajax_success_response('Success', $response_data, NO);
             return;
         
     }
    public function ajax_update_item()
    {
         
         
        $rules = [
             'item_name' => ['label' => 'Name', 'rules' => 'trim|required'],
             'item_id' => ['label' => 'Id', 'rules' => 'trim|required'],
           ];
        if ($this->validate($rules) === false) {
            $this->ajax_failure_response($this->validator->getErrors(), array(), NO);
            return;
        }

        
        $item_id = get_decoded_value($this->request->getPost('item_id'));
        if (empty($item_id) || $item_id === false) 
        {
            log_message('error', __METHOD__.' error while  get item_id: '.$item_id);
            $this->ajax_failure_response('Unable to get  id, please try again', array(), 'NO');
            return;
        }
       
        
        $item_data['item_name'] = $this->request->getPost('item_name');
        $item_data['updated_on'] = get_current_datetime_for_db();
        $item_data['updated_by'] = session()->get('user_id');

        
        $update_item_data = $this->items_library->update_data($item_id,$item_data);

        if ($update_item_data === false)
        {
            log_message('error', __METHOD__.' error while updating  data, data: '.print_r($item_data, true));
            $this->ajax_failure_response('unable to update, please try again', array(), 'NO');
            return;
        }
        $this->ajax_success_response('information updated!', array(), 'Yes');
        return;
    }
    public function ajax_delete_item()
    {
        $item_id = get_decoded_value($this->request->getPost('post_value'));

        $delete_item = $this->items_library->delete_data($item_id);

        if ($delete_item === false) 
        {
            log_message('error', __METHOD__.'Could not delete data , where  item id: '.$item_id);
            $this->ajax_failure_response('Unable to delete data, please try again', array(), 'NO');
            return;
        }

        $this->ajax_success_response('Deleted Successfully', array(), 'Yes');
        return;
    }
    
    }    