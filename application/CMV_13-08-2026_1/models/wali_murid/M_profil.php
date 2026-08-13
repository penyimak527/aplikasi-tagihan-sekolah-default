<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_profil extends CI_Model
{
    public function akun($id_wali)
    {
        return $this->db->where('id', (int) $id_wali)->get('wali_murid')->row_array();
    }

    public function ubah_password($id_wali)
    {
        $password_lama = (string) $this->input->post('password_lama');
        $password_baru = (string) $this->input->post('password_baru');
        $konfirmasi = (string) $this->input->post('konfirmasi_password');

        $wali = $this->akun($id_wali);
        if (!$wali || $wali['status'] !== 'Aktif') {
            return model_response(false, 'Akun wali murid tidak ditemukan atau tidak aktif.');
        }
        if (!password_verify($password_lama, (string) $wali['password_hash'])) {
            return model_response(false, 'Password saat ini tidak sesuai.');
        }
        if (strlen($password_baru) < 8) {
            return model_response(false, 'Password baru minimal 8 karakter.');
        }
        if ($password_baru !== $konfirmasi) {
            return model_response(false, 'Ulangi password baru tidak sesuai.');
        }
        if (password_verify($password_baru, (string) $wali['password_hash'])) {
            return model_response(false, 'Password baru harus berbeda dengan password saat ini.');
        }

        $this->db->trans_begin();
        $this->db->where('id', (int) $id_wali)->update('wali_murid', array(
            'password_hash' => password_hash($password_baru, PASSWORD_DEFAULT),
            'wajib_ganti_password' => 'Tidak',
            'tanggal_password_update' => tanggal_sekarang(),
            'waktu_password_update' => waktu_sekarang()
        ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return model_response(false, 'Password gagal diperbarui.');
        }
        $this->db->trans_commit();
        return model_response(true, 'Password berhasil diperbarui.');
    }
}
