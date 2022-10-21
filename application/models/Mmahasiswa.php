<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmahasiswa extends CI_Model {

    function get_data($token){
        $this->db->select("npm AS npm_mhs, nama AS nama_mhs, telepon AS telepon_mhs, jurusan AS jurusan_mhs");
        if ($token != '' && $token != null) {
            $this->db->where("TO_BASE64(npm) = '$token'");
        }
        return $this->db->get('tb_mahasiswa')->result();        
    }

    function post_data($data){
        $npm = base64_encode($data['npm']);
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        $this->db->where("TO_BASE64(npm) = '$npm'");

        $query = $this->db->get()->result();

        if (count($query)==0) {
            $this->db->insert('tb_mahasiswa', $data);
            return array("status" => true,"payload"=> $this->mdl->get_data($npm));
        } else {
            return array("status" => false,"payload"=> null);
        }
        
    }

    function put_data($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('tb_mahasiswa', $data);
    }

    function delete_data($token){
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        $this->db->where("TO_BASE64(npm) = '$token'");

        $query = $this->db->get()->result();

        if (count($query)==1) {
            $this->db->where("TO_BASE64(npm) = '$token'");
            $this->db->delete('tb_mahasiswa');
            return 1;
        } else {
            return 0;
        }
    }
    
}
