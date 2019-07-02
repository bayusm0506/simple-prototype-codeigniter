<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_menu extends CI_Model
{
	// public function menu($id){
	// 	$this->db->select('groups.id, description');
	// 	$this->db->from('groups');
	// 	$this->db->join('users_groups', 'groups.id = users_groups.group_id');
	// 	$this->db->where('users_groups.user_id', $id);
	// 	$this->db->order_by('users_groups.group_id', 'ASC');
	// 	return $this->db->get();
	// }

	public function menu($id){
		$this->db->select('user_menu.id, menu');
		$this->db->from('user_menu');
		$this->db->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id');
		$this->db->where('user_access_menu.role_id', $id);
		$this->db->order_by('user_access_menu.menu_id', 'ASC');
		return $this->db->get();
	}

	public function sub_menu($id){
		$this->db->select('*');
		$this->db->from('user_sub_menu');
		$this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.id');
		$this->db->where('user_sub_menu.menu_id', $id);
		$this->db->where('user_sub_menu.is_active', 1);
		return $this->db->get();
	}

	// public function sub_menu($id){
	// 	$this->db->where('group_id', $id);
	// 	$this->db->where('is_active', 1);
	// 	return $this->db->get('user_sub_menu');
	// }
}