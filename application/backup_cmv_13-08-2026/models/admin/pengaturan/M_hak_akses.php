<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hak_akses extends CI_Model
{
    public function level_list()
    {
        return $this->db->order_by('level', 'ASC')->get('level')->result_array();
    }

    public function hak_akses_result()
    {
        $id_level = (int) $this->input->post('id_level');
        $search = trim((string) $this->input->post('search', true));

        if ($id_level <= 0) {
            return array();
        }

        $this->db
            ->select('lm.*, m.urut')
            ->from('list_menu lm')
            ->join('menu m', 'm.id = lm.id_menu', 'left')
            ->where('lm.id_level', $id_level);

        if ($search !== '') {
            $this->db->group_start()
                ->like('lm.name', $search)
                ->or_like('lm.path', $search)
                ->or_like('lm.`group`', $search)
                ->group_end();
        }

        return $this->db
            ->order_by('lm.`group`', 'ASC', false)
            ->order_by('m.urut', 'ASC')
            ->order_by('lm.id', 'ASC')
            ->get()
            ->result_array();
    }

    public function menu_belum_dipilih()
    {
        $id_level = (int) $this->input->post('id_level');
        $search = trim((string) $this->input->post('search', true));

        if ($id_level <= 0) {
            return array();
        }

        $sub = $this->db
            ->select('id_menu')
            ->from('list_menu')
            ->where('id_level', $id_level)
            ->get_compiled_select();

        $this->db->from('menu m');
        $this->db->where("m.id NOT IN ($sub)", null, false);

        if ($search !== '') {
            $this->db->group_start()
                ->like('m.name', $search)
                ->or_like('m.path', $search)
                ->or_like('m.`group`', $search)
                ->group_end();
        }

        return $this->db
            ->order_by('m.`group`', 'ASC', false)
            ->order_by('m.urut', 'ASC')
            ->order_by('m.id', 'ASC')
            ->get()
            ->result_array();
    }

    public function tambah()
    {
        $id_level = (int) $this->input->post('id_level');
        $id_menu = $this->input->post('id_menu');

        if ($id_level <= 0) {
            return array('result' => 'false', 'message' => 'Level belum dipilih.');
        }
        if (!is_array($id_menu) || count($id_menu) === 0) {
            return array('result' => 'false', 'message' => 'Pilih minimal satu menu.');
        }

        $this->db->trans_begin();
        foreach ($id_menu as $menu_id) {
            $menu_id = (int) $menu_id;
            $menu = $this->db->where('id', $menu_id)->get('menu')->row_array();
            if (!$menu) {
                continue;
            }

            $exists = $this->db
                ->where('id_level', $id_level)
                ->where('id_menu', $menu_id)
                ->count_all_results('list_menu');
            if ($exists > 0) {
                continue;
            }

            $this->db->insert('list_menu', array(
                'path' => $menu['path'],
                'name' => $menu['name'],
                'group' => $menu['group'],
                'id_level' => $id_level,
                'id_menu' => $menu_id
            ));
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return array('result' => 'false', 'message' => 'Hak akses gagal disimpan.');
        }

        $this->db->trans_commit();
        return array('result' => 'true', 'message' => 'Hak akses berhasil ditambahkan.');
    }

    public function hapus()
    {
        $id_level = (int) $this->input->post('id_level');
        $ids = $this->input->post('id');

        if ($id_level <= 0) {
            return array('result' => 'false', 'message' => 'Level belum dipilih.');
        }
        if (!is_array($ids) || count($ids) === 0) {
            return array('result' => 'false', 'message' => 'Pilih minimal satu hak akses yang akan dihapus.');
        }

        $ids = array_map('intval', $ids);
        $this->db->where('id_level', $id_level)->where_in('id', $ids)->delete('list_menu');

        return array('result' => 'true', 'message' => 'Hak akses berhasil dihapus.');
    }

}
