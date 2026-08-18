<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model
{
    public function get_by_username($username)
    {
        return $this->db
            ->select('u.*, COALESCE(l.level, u.level) AS nama_level')
            ->from('users u')
            ->join('level l', 'l.id = u.id_level', 'left')
            ->where('u.username', trim((string) $username))
            ->limit(1)
            ->get()
            ->row_array();
    }

}
