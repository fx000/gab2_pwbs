<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";
class Mahasiswa extends Server {

    function service_get(){
        $token = $this->get('npm');
        $this->load->model("Mmahasiswa", "mdl", TRUE);        
        $this->response(array("mahasiswa" => $this->mdl->get_data(base64_encode($token))), 200);
    }

    function service_post(){

        $data = array(
            'npm'          => $this->post('npm_mhs'),
            'nama'          => $this->post('nama_mhs'),
            'telepon'      => $this->post('telepon_mhs'),
            'jurusan'      => $this->post('jurusan_mhs')
        );
        
        $this->load->model("Mmahasiswa", "mdl", TRUE);
        $save_data = $this->mdl->post_data($data);

        if ($save_data["status"]) {
            $this->response(array("status" => "Success","mahasiswa"=> $save_data['payload']), 200);
        } else {
            $this->response(array("status" => "Failed","mahasiswa"=> $save_data['payload']), 500);
        }
    }

    function service_put(){

        $id = $this->put('id');
        $data = array(
            'npm'          => $this->put('npm'),
            'nama'          => $this->put('nama'),
            'telepon'      => $this->put('telepon'),
            'jurusan'      => $this->put('jurusan')
        );

        $this->load->model("Mmahasiswa", "mdl", TRUE);        
        $this->response(array("status" => $this->mdl->put_data($data, $id)), 200);
    }

    function service_delete(){
        $token = $this->delete('npm_mhs');
        $this->load->model("Mmahasiswa", "mdl", TRUE);
        
        $delete = $this->mdl->delete_data(base64_encode($token));
        if ($delete == 1) {
            $this->response(array("status" => "Success","npm_mhs"=> $token), 200);
        } else {
            $this->response(array("status" => "Failed","npm_mhs"=> null), 500);
        }
    }
}
