<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataPegawai extends CI_Controller {
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
		$this->data['title'] = 'Data Pegawai';
		$this->template->load('layouts/main','dataPegawai/index', $this->data);
	}

	public function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->M_pegawai->autocomplete($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->NIP;
                echo json_encode($arr_result);
            }
        }
    }

    public function get_autocomplete_name(){
        if (isset($_GET['term'])) {
            $result = $this->M_pegawai->autocomplete_name($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->NM_PEGAWAI;
                echo json_encode($arr_result);
            }
        }
    }

	public function ajax_list()
	{
		$list = $this->M_pegawai->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pegawai) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pegawai->NIP;
			$row[] = $pegawai->NM_PEGAWAI;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_pegawai('."'".$pegawai->NIP."'".')"><i class="glyphicon glyphicon-edit"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pegawai('."'".$pegawai->NIP."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->M_pegawai->count_all(),
						"recordsFiltered" => $this->M_pegawai->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function save()
	{
		$this->_validate();

		$data = array(
            'NIP'=>$this->input->post('nip'),
            'NM_PEGAWAI'=>$this->input->post('nm_pegawai')
		);

		$cek_nip = $this->M_pegawai->cek($this->input->post('nip'))->num_rows();
		if ($cek_nip > 0) {
			echo json_encode(array("status" => 'error', 'msg'=>"NIP Sudah Terdaftar"));
		}else{
			$insert = $this->M_pegawai->save($data);
			echo json_encode(array("status" => 'info', 'msg'=>"Data Berhasil Disimpan"));
		}
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nip') == '')
		{
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'NIP Harus Diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('nm_pegawai') == '')
		{
			$data['inputerror'][] = 'nm_pegawai';
			$data['error_string'][] = 'Nama Pegawai Harus Diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function ajax_edit($id)
	{
		$data = $this->M_pegawai->get_by_id($id);
		echo json_encode($data);
	}

	public function edit(){
        $this->_validate();

		$data = array(
            'NIP'=>$this->input->post('nip'),
            'NM_PEGAWAI'=>$this->input->post('nm_pegawai')
		);

		$this->M_pegawai->update(array('NIP' => $this->input->post('nip')), $data);
		echo json_encode(array("status" => 'info', 'msg'=>"Data Berhasil Diperbarui"));
	}

	public function delete(){
		if($_POST['empid']) {
			$resultset = $this->M_pegawai->delete($_POST['empid']);
			if($resultset) {
				echo "Record Deleted";
			}
		}
	}
}
