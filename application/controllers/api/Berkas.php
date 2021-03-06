<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Berkas extends REST_Controller {

    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }
    }

    public function index_post() {
        if($this->session->userdata('id')) {
            $id = $this->post('id');
            $id_mahasiswa = $this->post('id_mahasiswa');
            $nomor_mahasiswa = $this->post('nomor_mahasiswa');
            $toefl_file = $this->post('toefl_file');
            // $toefl_file_verified = $this->post('toefl_file_verified');
            $transkrip_file = $this->post('transkrip_file');
            // $skripsi_file_verified_ketua_penguji = $this->post('skripsi_file_verified_ketua_penguji');
            $skripsi_file = $this->post('skripsi_file');
            // $skripsi_file_verified = $this->post('skripsi_file_verified');
            $bimbingan_file = $this->post('bimbingan_file');
            // $bimbingan_file_verified = $this->post('bimbingan_file_verified');
            $which_one = $this->post('which_one');
            $file = $this->post('file');
            date_default_timezone_set('Asia/Jakarta');
            $tempfilename = $_FILES['file']['tmp_name'];
            $dir = './assets/berkas/';
            if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'pdf') {
                if($which_one =='toefl') {
                    $filename = $this->session->userdata('nomor') . '-TOEFL-' . date('dmY-His') . '.pdf';
                    if($this->M_Berkas->storeToefl($id,base_url('assets/berkas/').$filename)) {
                        $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                        $this->response(
                            array(
                                'status' => TRUE,
                                'message' => $this::UPDATE_SUCCESS_MESSSAGE
                            ), REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => $this::UPDATE_FAILED_MESSAGE
                            ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                } else {
                    if($which_one == 'transkrip') {
                        $filename = $this->session->userdata('nomor') . '-transkrip-' . date('dmY-His') . '.pdf';
                        if($this->M_Berkas->storeTranskripNew($id,base_url('assets/berkas/').$filename)) {
                            $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                            $this->response(
                                array(
                                    'status' => TRUE,
                                    'message' => $this::UPDATE_SUCCESS_MESSSAGE
                                ), REST_Controller::HTTP_OK
                            );
                        } else {
                            $this->response(
                                array(
                                    'status' => FALSE,
                                    'message' => $this::UPDATE_FAILED_MESSAGE
                                ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                            );
                        }
                    } else {
                        if($which_one == 'skripsi') {
                            $filename = $this->session->userdata('nomor') . '-skripsi-' . date('dmY-His') . '.pdf';
                            if($this->M_Berkas->storeSkripsi($id,base_url('assets/berkas/').$filename)) {
                                $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                                $this->response(
                                    array(
                                        'status' => TRUE,
                                        'message' => $this::UPDATE_SUCCESS_MESSSAGE
                                    ), REST_Controller::HTTP_OK
                                );
                            } else {
                                $this->response(
                                    array(
                                        'status' => FALSE,
                                        'message' => $this::UPDATE_FAILED_MESSAGE
                                    ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                );
                            }
                        } else {
                            if($which_one == 'bimbingan') {
                                $filename = $this->session->userdata('nomor') . '-kartubimbingan-' . date('dmY-His') . '.pdf';
                                if($this->M_Berkas->storeBimbingan($id,base_url('assets/berkas/').$filename)) {
                                    $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                                    $this->response(
                                        array(
                                            'status' => TRUE,
                                            'message' => $this::UPDATE_SUCCESS_MESSSAGE
                                        ), REST_Controller::HTTP_OK
                                    );
                                } else {
                                    $this->response(
                                        array(
                                            'status' => FALSE,
                                            'message' => $this::UPDATE_FAILED_MESSAGE
                                        ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                    );
                                }
                            } else {
                                if($which_one == 'revisi_dosen_pembimbing') {
                                    $filename = $nomor_mahasiswa . '-revisiDosenPembimbing-' . date('dmY-His') . '.pdf';
                                    if($this->M_Berkas->storeRevisiDosenPembimbing($id,base_url('assets/berkas/').$filename)) {
                                        $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                                        $this->response(
                                            array(
                                                'status' => TRUE,
                                                'message' => base_url('assets/berkas/').$filename
                                            ), REST_Controller::HTTP_OK
                                        ); 
                                    } else {
                                        $this->response(
                                            array(
                                                'status' => FALSE,
                                                'message' => $this->M_Berkas->get_by_id($id)
                                            ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                        );
                                    }
                                } else {
                                    if($which_one == 'revisi_ketua_penguji') {
                                        $filename = $nomor_mahasiswa . '-revisiKetuaPenguji-' . date('dmY-His') . '.pdf';
                                        if($this->M_Berkas->storeRevisiKetuaPenguji($id,base_url('assets/berkas/').$filename)) {
                                            $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                                            $this->response(
                                                array(
                                                    'status' => TRUE,
                                                    'message' => $this->M_Berkas->get_by_id($id)
                                                ), REST_Controller::HTTP_OK
                                            ); 
                                        } else {
                                            $this->response(
                                                array(
                                                    'status' => FALSE,
                                                    'message' => $this::UPDATE_FAILED_MESSAGE
                                                ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                            );
                                        }
                                    } else {
                                        if($which_one == 'revisi_dosen_penguji') {
                                            $filename = $nomor_mahasiswa . '-revisiDosenPenguji-' . date('dmY-His') . '.pdf';
                                            if($this->M_Berkas->storeRevisiDosenPenguji($id,base_url('assets/berkas/').$filename)) {
                                                $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                                                $this->response(
                                                    array(
                                                        'status' => TRUE,
                                                        'message' => $this->M_Berkas->get_by_id($id)
                                                    ), REST_Controller::HTTP_OK
                                                ); 
                                            } else {
                                                $this->response(
                                                    array(
                                                        'status' => FALSE,
                                                        'message' => $this::UPDATE_FAILED_MESSAGE
                                                    ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                                );
                                            }
                                        } else {
                                            $this->response(
                                                array(
                                                    'status' => FALSE,
                                                    'message' => $this::UPDATE_FAILED_MESSAGE
                                                ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => 'ONLY ACCEPT PDF FILE TYPE'
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        }
        
    }

    public function index_get() {
        $id_mahasiswa = $this->get('id_mahasiswa');
        if(isset($id_mahasiswa)) {
            $result = $this->M_Berkas->get_berkas_where_mahasiswa($id_mahasiswa);
            $this->response($result,REST_Controller::HTTP_OK);
        } else {
            $idx = 0;
            $result = $this->M_User->get_all_user();
            foreach($result as $row) {
                $berkas = $this->M_Berkas->get_berkas_where_mahasiswa($row['id']);
                $temp = array_merge($result[$idx], array('berkas' => $berkas));
                $result[$idx] = $temp;
                $idx++;
            } $this->response($result,REST_Controller::HTTP_OK);
        }
    }

    public function index_put() {
        if($this->session->userdata('id')) {
            $toefl_file_verified = $this->put('toefl_file_verified');
            $skripsi_file_verified_dosen_pembimbing = $this->put('skripsi_file_verified_dosen_pembimbing');
            $skripsi_file_verified_ketua_penguji = $this->put('skripsi_file_verified_ketua_penguji');
            $skripsi_file_verified_dosen_penguji = $this->put('skripsi_file_verified_dosen_penguji');
            $transkrip_file_verified = $this->put('transkrip_file_verified');
            $bimbingan_file_verified = $this->put('bimbingan_file_verified');
            $id = $this->put('id');
            $id_mahasiswa = $this->put('id_mahasiswa');
            $reset = $this->put('reset');
            if(isset($reset) && $reset == 1) {
                if($this->M_Berkas->storeEmpty($id_mahasiswa)) {
                    $this->response(
                        array(
                            'status' => TRUE,
                            'message' => $this::UPDATE_SUCCESS_MESSSAGE
        
                        ),
                        REST_Controller::HTTP_OK
                    );
                    return;
                }
            }
            $datas = array();
            if(!isset($id)) {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => $this::REQUIRED_PARAMETER_MESSAGE." id"
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );
                return;
            }
            $datas = array_merge($datas, array('id' => $id));
            if(isset($toefl_file_verified)){
                $datas = array_merge($datas, array('toefl_file_verified' => $toefl_file_verified));
            }
            if(isset($skripsi_file_verified_dosen_pembimbing)){
                $datas = array_merge($datas, array('skripsi_file_verified_dosen_pembimbing' => $skripsi_file_verified_dosen_pembimbing));
            }
            if(isset($skripsi_file_verified_ketua_penguji)){
                $datas = array_merge($datas, array('skripsi_file_verified_ketua_penguji' => $skripsi_file_verified_ketua_penguji));
            }
            if(isset($skripsi_file_verified_dosen_penguji)){
                $datas = array_merge($datas, array('skripsi_file_verified_dosen_penguji' => $skripsi_file_verified_dosen_penguji));
            }
            if(isset($transkrip_file_verified)){
                $datas = array_merge($datas, array('transkrip_file_verified' => $transkrip_file_verified));
            }
            if(isset($bimbingan_file_verified)){
                $datas = array_merge($datas, array('bimbingan_file_verified' => $bimbingan_file_verified));
            }
            if($this->M_Berkas->verify($id,$datas)) {
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => $this::UPDATE_SUCCESS_MESSSAGE

                    ),
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => $this::UPDATE_FAILED_MESSAGE
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );
            }
        }
    }

}