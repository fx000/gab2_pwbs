<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/Server.php";
class Mahasiswa extends Server {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Mmahasiswa", "model", TRUE);
    }

    function service_get(){
        $token = $this->get('npm_mhs');
                
        $this->response(array("mahasiswa" => $this->model->get_data(base64_encode($token))), 200);
    }

    function service_post(){

        $data = array(
            'npm'          => $this->post('npm_mhs'),
            'nama'          => $this->post('nama_mhs'),
            'telepon'      => $this->post('telepon_mhs'),
            'jurusan'      => $this->post('jurusan_mhs')
        );
        
        
        $save_data = $this->model->post_data($data);

        if ($save_data["status"]) {
            $this->response(array("status" => "Success","mahasiswa"=> $save_data['payload']), 200);
        } else {
            $this->response(array("status" => "Failed","mahasiswa"=> $save_data['payload']), 500);
        }
    }

    function service_put(){

        
        $data = array(
            'npm'          => $this->put('npm_mhs'),
            'nama'          => $this->put('nama_mhs'),
            'telepon'      => $this->put('telepon_mhs'),
            'jurusan'      => $this->put('jurusan_mhs')
        );

        $token = $this->put('token');
        

        $update_data = $this->model->put_data($data, base64_encode($token));
        if ($update_data["status"]) {
            $this->response(array("status" => "Success","mahasiswa"=> $update_data['payload']), 200);
        } else {
            $this->response(array("status" => "Failed","mahasiswa"=> $update_data['payload']), 500);
        }

    }

    function service_delete(){
        $token = $this->delete('npm_mhs');
        
        
        $delete = $this->model->delete_data(base64_encode($token));
        if ($delete == 1) {
            $this->response(array("status" => "Success","npm_mhs"=> $token), 200);
        } else {
            $this->response(array("status" => "Failed","npm_mhs"=> null), 500);
        }
    }
}
