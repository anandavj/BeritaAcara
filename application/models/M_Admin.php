<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model{
    private $id;
    private $username;
    private $password;
    const TABLE_NAME = 'admin';

    public function login($username,$password) {
        $this->username = $username;
        $this->password = $password;

        return $this->db->get_where($this::TABLE_NAME, array (
            'username' => $this->username,
            'password' => $this->password
        ));
    }

    public function verify($users) {
        foreach($users as $user) {
            $this->db->where('id', $user['id']);
            $this->db->update('user', [
                'verified' => 1
            ]);
            $this->db->insert('berkas', array(
                'id_mahasiswa' => $user['id'],
            ));
        }
        return $this->db->affected_rows();
    }

    public function updateDate($date) {
        $result = $this->db->get_where('timeline', $date);
        if($result->num_rows() > 0) return true;

        $this->db->update('timeline', $date, "id=1");
        
        return $this->db->affected_rows();
    }
}