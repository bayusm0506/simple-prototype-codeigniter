<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('administrator/auth/login', 'refresh');
		}

		$this->dbOracle = $this->load->database('dbOracle',TRUE);
	}

	public function actionCssJs(){
		$this->data['cssFile'] = array(
	        'css1'=>base_url().takeCssAdmin()['css1'],
	        'css2'=>base_url().takeCssAdmin()['css2'],
	        'css3'=>base_url().takeCssAdmin()['css3'],
	        'css17'=>base_url().takeCssAdmin()['css17'],
	        'css18'=>base_url().takeCssAdmin()['css18'],
	        'css19'=>base_url().takeCssAdmin()['css19'],
	        'css20'=>base_url().takeCssAdmin()['css20'],
	        'css8'=>base_url().takeCssAdmin()['css8'],
	        'css13'=>base_url().takeCssAdmin()['css13'],
	        'css4'=>base_url().takeCssAdmin()['css4'],
	        'css5'=>base_url().takeCssAdmin()['css5'],
	        'css14'=>base_url().takeCssAdmin()['css14'],
	        'css15'=>base_url().takeCssAdmin()['css15'],
	    );

	    $this->data['jsFile'] = array(
	        'js29'=>base_url().takeJsAdmin()['js29'],
	        'js14'=>base_url().takeJsAdmin()['js14'],
	        'js15'=>base_url().takeJsAdmin()['js15'],
	        'js16'=>base_url().takeJsAdmin()['js16'],
	        'js17'=>base_url().takeJsAdmin()['js17'],
	    );
	}

	public function index(){
		self::actionCssJs();
		$this->data['title'] = 'Profile';
		$this->template->load('layouts/main','profile/index', $this->data);
	}
}
