<?php

namespace App\Controllers;

class Dashboard_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();  
       
    }

	public function index()
	{
        $data = array();
        // var_dump(session()->get("user_role"));exit();
        // if(session()->get("user_role") == "Super Admin"){

        // }

	    return $this->generateView('content_panel/Dashboard/dashboard_view',$data);
	}
}