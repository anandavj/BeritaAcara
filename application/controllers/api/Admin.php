<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Admin extends REST_Controller {

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


    public function index_put() {
        if($this->session->userdata('id')) {
            $users = $this->put('users');
            if(isset($users)) {
                if($this->M_Admin->verify($users)) {
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
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => $this::UPDATE_FAILED_MESSAGE
                    ),
                    REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
    }

}
