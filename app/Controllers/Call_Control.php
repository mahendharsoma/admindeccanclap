<?php

namespace App\Controllers;

class Call_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
       
    }

	public function index()
	{
        $data = array();

	    return $this->generateView('content_panel/Calls_Management/audio_call_view',$data);
	}

	public function call_history()
	{
        $data = array();

	    return $this->generateView('content_panel/Calls_Management/call_history_view',$data);
	}

	public function all_leads_calls()
	{
        $data = array();

	    return $this->generateView('content_panel/Calls_Management/all_leads_call_history_view',$data);
	}

}