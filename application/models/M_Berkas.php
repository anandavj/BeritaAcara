<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Berkas extends CI_Model{
    private $id;
    private $id_mahasiswa;
    private $toefl_file;
    private $toefl_file_verified;
    private $transkrip_file;
    private $transkrip_file_verified;
    private $skripsi_file;
    private $skripsi_file_verified;
    private $bimbingan_file;
    private $bimbingan_file_verified;
    const TABLE_NAME = 'berkas';

    public function storeTranskrip($id_mahasiswa, $file) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'transkrip_file' => $file,
        ));
        return $this->db->insert_id();
    }

    public function storeEmpty($id_mahasiswa) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
        ));
        return $this->db->insert_id();
    }

    public function get_berkas_where_mahasiswa($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_mahasiswa='{$id}'");
        $this->db->order_by('time', 'DESC');
        return $this->db->get()->result_array();
    }

    public function delete($id) {
        $this->db->delete($this::TABLE_NAME, "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function storeToefl($id,$file) {
        $this->db->update($this::TABLE_NAME, array(
            'toefl_file' => $file,
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function storeTranskripNew($id,$file) {
        $this->db->update($this::TABLE_NAME, array(
            'transkrip_file' => $file,
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function storeSkripsi($id,$file) {
        $this->db->update($this::TABLE_NAME, array(
            'skripsi_file' => $file,
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function storeBimbingan($id,$file) {
        $this->db->update($this::TABLE_NAME, array(
            'bimbingan_file' => $file,
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function verify($which_one,$status,$id) {
        $this->db->update($this::TABLE_NAME, array(
            $which_one => $status
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }
    public function reset($id) {
        $this->db->update($this::TABLE_NAME, array(
            'toefl_file_verified' => null,
            'transkrip_file_verified' => null,
            'skripsi_file_verified' => null,
            'bimbingan_file_verified' => null,
        ), "id='{$id}'");
        return $this->db->affected_rows();
    }
}