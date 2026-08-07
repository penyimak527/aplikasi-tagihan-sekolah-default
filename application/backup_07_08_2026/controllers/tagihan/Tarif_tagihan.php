<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_tagihan extends MY_Controller
{
    public function index()
    {
        $id = (int) $this->input->get('id_tagihan');
        redirect('tagihan/tarif_per_kelas' . ($id > 0 ? '?id_tagihan=' . $id : ''));
    }
}
