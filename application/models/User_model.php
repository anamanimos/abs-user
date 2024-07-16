<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function get_user_profile($nisn)
    {
        $this->db->select('students.id,students.nisn,students.full_name,students.class_id, class.class_name');
        $this->db->from('students');
        $this->db->join('class', 'students.class_id = class.id');
        $this->db->where('students.nisn', $nisn);
        $query = $this->db->get();
        return $query->row();
    }
}
