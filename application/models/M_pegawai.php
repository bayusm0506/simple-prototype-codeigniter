<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pegawai extends CI_Model
{
  var $table = 'PEGAWAI';
  var $column_order = array('NIP','NM_PEGAWAI'); //set column field database for datatable orderable
  var $column_search = array('NIP','NM_PEGAWAI'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('NIP' => 'ASC'); // default order 

  private function _get_datatables_query()
  {
    //add custom filter here
    if($this->input->post('nip'))
    {
        $this->dbOracle->like('NIP', $this->input->post('nip'));
    }

    if($this->input->post('nm_pegawai'))
    {
        $this->dbOracle->like('NM_PEGAWAI', $this->input->post('nm_pegawai'));
    }

    $this->dbOracle->from($this->table);
    $i = 0;
  
    foreach ($this->column_search as $item) // loop column 
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
      {
        
        if($i===0) // first loop
        {
          $this->dbOracle->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->dbOracle->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->dbOracle->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
          $this->dbOracle->group_end(); //close bracket
      }
      $i++;
    }
    
    if(isset($_POST['order'])) // here order processing
    {
      $this->dbOracle->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } 
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->dbOracle->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->dbOracle->limit($_POST['length'], $_POST['start']);
    $query = $this->dbOracle->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->dbOracle->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->dbOracle->from($this->table);
    return $this->dbOracle->count_all_results();
  }

  public function delete($nip){
    $this->dbOracle->where('NIP', $nip);
    return $this->dbOracle->delete($this->table);
  }

  public function save($data){
    return $this->dbOracle->insert($this->table, $data);
  }

  public function update($where, $data){
    $this->dbOracle->update($this->table, $data, $where);
    return $this->dbOracle->affected_rows();
  }

  public function autocomplete_name($nm_pegawai){
    $this->dbOracle->like('NM_PEGAWAI', $nm_pegawai , 'both');
    $this->dbOracle->order_by('NM_PEGAWAI', 'ASC');
    $this->dbOracle->limit(10);
    return $this->dbOracle->get($this->table)->result();
  }

  public function autocomplete($nip){
    $this->dbOracle->like('NIP', $nip , 'both');
    $this->dbOracle->order_by('NIP', 'ASC');
    $this->dbOracle->limit(10);
    return $this->dbOracle->get($this->table)->result();
  }

  public function get_by_id($id)
  {
    $this->dbOracle->from($this->table);
    $this->dbOracle->where('NIP',$id);
    $query = $this->dbOracle->get();
    return $query->row();
  }

  public function cek($nip){
    $this->dbOracle->where('NIP',$nip);
    return $this->dbOracle->get($this->table);
  }
}