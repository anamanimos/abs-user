<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function login($nisn, $pin)
    {
        $this->db->where('nisn', $nisn);
        $query = $this->db->get('students');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($pin, $user->secret_number)) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
