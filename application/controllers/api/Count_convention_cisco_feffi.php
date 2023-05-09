<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_convention_cisco_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $validation = $this->get('validation');
        $menu = $this->get('menu');
        $id_cisco = $this->get('id_cisco');
        $data = array();
        if ($menu=='countbyciscovalidation')
        {
            $convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->countConventionbyciscovalidation($id_cisco,$validation);          
            $data = $convention_cisco_feffi_entete;
           
           
        }

        if ($menu=='countbyvalidation')
        {
            $convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->countConventionbyvalidation($validation); 
            $data = $convention_cisco_feffi_entete;
           
           
           
        }
    
        
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
