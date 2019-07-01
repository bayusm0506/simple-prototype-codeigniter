<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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
            'css13'=>base_url().takeCssAdmin()['css13'],
            'css4'=>base_url().takeCssAdmin()['css4'],
            'css5'=>base_url().takeCssAdmin()['css5'],
        );

        $this->data['jsFile'] = array(
            'js15'=>base_url().takeJsAdmin()['js15'],
            'js16'=>base_url().takeJsAdmin()['js16'],
            'js26'=>base_url().takeJsAdmin()['js26'],
        );
	}

	public function index(){
		self::actionCssJs();
		$this->data['title'] = 'Dashboard';
		// $this->data['pegawai'] = $this->dbOracle->query("SELECT * FROM PEGAWAI")->result();
		$this->template->load('layouts/main','dashboard/index', $this->data);
	}
}
