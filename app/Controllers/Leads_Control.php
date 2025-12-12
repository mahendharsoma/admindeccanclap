<?php

namespace App\Controllers;

class Leads_Control extends Default_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->session = \Config\Services::session();
       
    }

	public function index()
	{
        $data = array();

	    return $this->generateView('content_panel/Leads/leads_view',$data);
	}

	public function add_leads()
	{
        $data = array();

	    return $this->generateView('content_panel/Leads/add_leads_view',$data);
	}

	public function lead_sources()
	{
        $data = array();

	    return $this->generateView('content_panel/Leads/lead_sources_view',$data);
	}

	public function followups_leads()
	{
        $data = array();

	    return $this->generateView('content_panel/Leads/followups_leads_view',$data);
	}

}