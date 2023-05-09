<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Utilisateurs extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('utilisateurs_model', 'UserManager');

        $this->load->model('region_model', 'RegionManager');
        $this->load->model('district_model', 'DistrictManager');
        $this->load->model('cisco_model', 'CiscoManager');
    }

    public function index_get() 
    {
        //find by id
        $id = $this->get('id');
        $enabled = $this->get('enabled');
        $profil = $this->get('profil');
        $type_get = $this->get('type_get');

       /* if ($profil == 1) 
        {
            $data = array(
                'nom' => $this->post('nom'),
                'prenom' => $this->post('prenom'),
                'email' => $this->post('email'),
                'password' => sha1($this->post('password'))
      
            );

         

            $data = $this->UserManager->update_profil($id, $data);
           
        }*/

        if ($id) 
        {
            $user = $this->UserManager->findById($id);
            if ($user) 
            {   
                $region = array();
                    $region = $this->RegionManager->findById($user->id_region);

                    $district = array();
                    $district = $this->DistrictManager->findById($user->id_district);

                    $cisco = array();
                    $cisco = $this->CiscoManager->findById($user->id_cisco);

                $data['id'] = $user->id;
                $data['nom'] = $user->nom;
                $data['prenom'] = $user->prenom;
                $data['telephone'] = $user->telephone;
               // $data['sigle'] = $user->sigle;
                $data['token'] = $user->token;
                $data['email'] = $user->email;
                $data['enabled'] = $user->enabled;

                $data['cisco'] = $cisco;
                $data['region'] = $region;
                $data['district'] = $district;
      
                $data['roles'] = unserialize($user->roles);
            }
            else
            {
                $data = array();
            }
            
    
                
        }

        if ($enabled == 1) 
        {
            $nbr = 0 ;
            $user = $this->UserManager->findAllByEnabled(0);          
            $data = $user[0];   
        }
        
        if ($type_get == "findAll") 
        {
            $usr = $this->UserManager->findAll();
            if ($usr)
            {
                foreach ($usr as $key => $value) 
                {
                    $region = array();
                    $region = $this->RegionManager->findById($value->id_region);

                    $district = array();
                    $district = $this->DistrictManager->findById($value->id_district);

                    $cisco = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['telephone'] = $value->telephone;
                 //   $data[$key]['sigle'] = $value->sigle;
                    $data[$key]['token'] = $value->token;
                    $data[$key]['email'] = $value->email;
                    $data[$key]['enabled'] = $value->enabled;

                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['region'] = $region;
                    $data[$key]['district'] = $district;              
           
                    $data[$key]['roles'] = unserialize($value->roles);


                }
            }
            else
            {
                $data = array();
            }
        }
        
       

        //authentification
        $email = $this->get('email');
        $pwd = sha1($this->get('pwd'));
        $site = $this->get('site');

        if ($email && $pwd) {
            $value = $this->UserManager->sign_in($email, $pwd);
            if ($value)
            {
                $data = array();
                $data['id'] = $value[0]->id;
                $data['nom'] = $value[0]->nom;
                $data['prenom'] = $value[0]->prenom;
                $data['telephone'] = $value[0]->telephone;
           //     $data['sigle'] = $value[0]->sigle;
                $data['token'] = $value[0]->token;
                $data['email'] = $value[0]->email;
                $data['enabled'] = $value[0]->enabled;
         
                $data['roles'] = unserialize($value[0]->roles);

                

            }else{
                $data = array();
            }
        }

        //find by email
        $fndmail = $this->get('courriel');
        if ($fndmail) {
            $data = $this->UserManager->findByMail($fndmail);
            if (!$data)
                $data = array();
        }

        //find by mdp
        $fndmdp = $this->get('mdp');
        if ($fndmdp) {
            $data = $this->UserManager->findByPassword($fndmdp);
            if (!$data)
                $data = array();
        }

        //mise a jour mdp
        $courriel = $this->get('courriel');
        $reinitpwd = sha1($this->get('reinitpwd'));
        $reinitpwdtoken = $this->get('reinitpwdtoken');

        if ($courriel && $reinitpwd && $reinitpwdtoken) {
            $data = $this->UserManager->reinitpwd($courriel, $reinitpwd, $reinitpwdtoken);
            if (!$data)
                $data = array();
        }

        //status success + data
        if (($data)) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } 
        else 
        {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_post() {
        
     
        $id = $this->post('id') ;
        $gestion_utilisateur = $this->post('gestion_utilisateur') ;
        $supprimer = $this->post('supprimer') ;
        $profil = $this->post('profil') ;

        if ($gestion_utilisateur == 1) 
        {

            if ($supprimer == 0) 
            {
                $getrole = $this->post('roles');
                $id_region=null;
                $tmp_region = $this->post('id_region');
                if($tmp_region !="" && intval($tmp_region) >0) 
                {
                    $id_region=$tmp_region;
                }
                $id_district=null;
                $tmp_district = $this->post('id_district');
                if($tmp_district !="" && intval($tmp_district) >0) 
                {
                    $id_district=$tmp_district;
                }
                $id_cisco=null;
                $tmp_cisco = $this->post('id_cisco');
                if($tmp_cisco !="" && intval($tmp_cisco) >0) 
                {
                    $id_cisco=$tmp_cisco;
                }
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'telephone' => $this->post('telephone'),         
                 //   'sigle' => $this->post('sigle'),
                    'email' => $this->post('email'),                 
                    'enabled' => $this->post('enabled'),
                    'roles' => serialize($getrole),                  
                    'id_region' => $id_region,                 
                    'id_district' => $id_district,                 
                    'id_cisco' => $id_cisco
                  
                );

                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $update = $this->UserManager->update($id, $data);
                
                if(!is_null($update))
                {
                    $this->response([
                        'status' => TRUE,
                        'response' => $update,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                }
                else
                {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
            else
            {
                    //si suppression
            }
            
        }
        else
        {
            if ($profil == 1) 
            {   
                $id_region=null;
                $tmp_region = $this->post('id_region');
                if($tmp_region !="" && intval($tmp_region) >0) 
                {
                    $id_region=$tmp_region;
                }
                $id_district=null;
                $tmp_district = $this->post('id_district');
                if($tmp_district !="" && intval($tmp_district) >0) 
                {
                    $id_district=$tmp_district;
                }
                $id_cisco=null;
                $tmp_cisco = $this->post('id_cisco');
                if($tmp_cisco !="" && intval($tmp_cisco) >0) 
                {
                    $id_cisco=$tmp_cisco;
                }
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'telephone' => $this->post('telephone'),
                    //'cin' => $this->post('cin'),
                    'email' => $this->post('email'),
                    'password' => sha1($this->post('password')),                 
                    'id_region' => $id_region,                 
                    'id_district' => $id_district,                 
                    'id_cisco' => $id_cisco
          
                );

                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $dataId = $this->UserManager->update_profil($id, $data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found 2'
                            ], REST_Controller::HTTP_OK);
                }
            }
            else 
            {
                $getrole = array("USER");
                $id_region=null;
                $tmp_region = $this->post('id_region');
                if($tmp_region !="" && intval($tmp_region) >0) 
                {
                    $id_region=$tmp_region;
                }
                $id_district=null;
                $tmp_district = $this->post('id_district');
                if($tmp_district !="" && intval($tmp_district) >0) 
                {
                    $id_district=$tmp_district;
                }
                $id_cisco=null;
                $tmp_cisco = $this->post('id_cisco');
                if($tmp_cisco !="" && intval($tmp_cisco) >0) 
                {
                    $id_cisco=$tmp_cisco;
                }
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'telephone' => $this->post('telephone'),
                    'sigle' => $this->post('sigle'),
                    'email' => $this->post('email'),                 
                    'id_region' => $id_region,                 
                    'id_district' => $id_district,                 
                    'id_cisco' => $id_cisco,
                    'password' => sha1($this->post('password')),
                    'enabled' => 0,
                    'token' => bin2hex(openssl_random_pseudo_bytes(32)),
                    'roles' => serialize($getrole)
                );

                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $dataId = $this->UserManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
           
                
            

        }
        
    }

    public function index_put($id) {
        $data = array(
            'nom' => $this->put('nom'),
            'prenom' => $this->put('prenom'),
            'telephone' => $this->put('telephone'),
            'email' => $this->put('email'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            'fonction' => $this->put('fonction'),
            'cin' => $this->put('cin'),
            'enabled' => $this->put('enabled'),
            'token' => bin2hex(openssl_random_pseudo_bytes(32))
        );

        if (!$data || !$id) {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $update = $this->UserManager->update($id, $data);
        
        if(!is_null($update))
        {
            $this->response([
                'status' => TRUE,
                'response' => 1,
                'message' => 'Update data success'
                    ], REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete($id) {
        
        if (!$id) {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $delete = $this->UserManager->delete($id);
        
        if (!is_null($delete)) {
            $this->response([
                'status' => TRUE,
                'response' => 1,
                'message' => "Delete data success"
                    ], REST_Controller::HTTP_OK);
        } 
        else 
        {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */