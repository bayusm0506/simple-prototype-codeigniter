<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_menu extends CI_Model
{
	public function menu($id){
		$this->db->select('groups.id, description');
		$this->db->from('groups');
		$this->db->join('users_groups', 'groups.id = users_groups.group_id');
		$this->db->where('users_groups.user_id', $id);
		$this->db->order_by('users_groups.group_id', 'ASC');
		return $this->db->get();
	}

	public function sub_menu($id){
		$this->db->where('group_id', $id);
		$this->db->where('is_active', 1);
		return $this->db->get('user_sub_menu');
	}
}