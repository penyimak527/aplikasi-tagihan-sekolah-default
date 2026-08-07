<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model
{
    public function get_by_username($username)
    {
        return $this->db
            ->where('username', trim((string) $username))
            ->limit(1)
            ->get('users')
            ->row_array();
    }
}
