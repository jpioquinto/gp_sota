<?php

namespace App\Controllers;


class Home extends BaseController
{
	public function __construct()
	{
		@session_start();
	}

	public function index()
	{
		
		if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}
		
		return view('welcome_message');		
	}
}
