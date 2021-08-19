<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecommerce extends CI_Controller {

    public $est_autoriser = false;

	public function __construct()
    {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
        
		 header("Access-Control-Allow-Origin: *");
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );//autoriser les requete de l'api a partir d'un domaine
   
   //Pour voir dans le posman toute les requêtes qui ont été passée 
//$this->output->enable_profiler(true);
	$this->est_autoriser = 	$this->MyModel->check_auth_client();

        /*
        $check_auth_client = $this->MyModel->check_auth_client();
		if($check_auth_client != true){
			die($this->output->get_output());
		}
		*/
    }

	

	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_all_data();
	    			json_output($response['status'],$resp);
		        }
			}
		}
    }
    


	public function detail($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_detail_data($id);
					json_output($response['status'],$resp);
		        }
			}
		}
	}

	public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        $respStatus = $response['status'];
		        if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        		$resp = $this->MyModel->book_create_data($params);
					}
					json_output($respStatus,$resp);
		        }
			}
		}
	}

	public function update($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        $respStatus = $response['status'];
		        if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					$params['updated_at'] = date('Y-m-d H:i:s');
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        		$resp = $this->MyModel->book_update_data($id,$params);
					}
					json_output($respStatus,$resp);
		        }
			}
		}
	}

	public function delete($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_delete_data($id);
					json_output($response['status'],$resp);
		        }
			}
		}
	}
	

	public function login1()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			$check_auth_client = $this->model_ecommerce->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$params = $_REQUEST;
				$email = $this->input->post('email');
		        $pwd = $this->input->post('pwd');
				$rponse['status']=200;
		        $response = $this->model_ecommerce->login1($email,$pwd);
				
				json_output($rponse['status'],$response);
			}
		}
	}


	public function loginclient()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			$check_auth_client = $this->model_ecommerce->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$params = $_REQUEST;
				$email = $this->input->post('email');
		        $pwd = $this->input->post('pwd');
				$rponse['status']=200;
		        $response = $this->model_ecommerce->loginclient($email,$pwd);
				
				json_output($rponse['status'],$response);
			}
		}
	}

	
    

	public function ajout_role()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$libelle = $this->input->post('libelle');
		        $response = $this->model_ecommerce->ajout_role($libelle);
				
				json_output($response['status'],$response);
			}
		}
	}

	public function modification_role(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idrole = $this->input->get('idrole');
			$libelle = $this->input->get('libelle');
			

            $this->load->model('model_ecommerce');

            $modifrole = $this->model_ecommerce->modification_role($idrole,$libelle);
            if(!empty($modifrole)){
                $data['infos'] = $modifrole ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function suppression_role(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idrole = $this->input->get('idrole');
			

            $this->load->model('model_ecommerce');

            $suprole = $this->model_ecommerce->suppression_role($idrole);
            if(!empty($suprole)){
                $data['infos'] = $suprole ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}



	public function liste_role(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			
            $this->load->model('model_ecommerce');

            $listerole = $this->model_ecommerce->liste_role();
            if(!empty($listerole)){
                $data['infos'] = $listerole;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function ajout_permission()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$libelle = $this->input->post('libelle');
		        $response = $this->model_ecommerce->ajout_permission($libelle);
				
				json_output($response['status'],$response);
			}
		}
	}
	public function modification_permission(){

		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
	
			//$idutilisateur = $this->input->get('idutilisateur');
			$idpermission = $this->input->get('idpermission');
			$libelle = $this->input->get('libelle');
			
			
	
			$this->load->model('model_ecommerce');
	
			$modifpermission = $this->model_ecommerce->modification_permission($idpermission,$libelle);
			if(!empty($modifpermission)){
				$data['infos'] = $modifpermission ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
			}else{
				
				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
			}
	
		}
	}

	public function suppression_permission(){

		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
	
			//$idutilisateur = $this->input->get('idutilisateur');
			$idpermission = $this->input->get('idpermission');
			
	
			$this->load->model('model_ecommerce');
	
			$suppermission = $this->model_ecommerce->suppression_permission($idpermission);
			if(!empty($suppermission)){
				$data['infos'] = $suppermission ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
			}else{
				
				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
			}
	
		}
	}

	public function liste_permission(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			
            $this->load->model('model_ecommerce');

            $listepermission = $this->model_ecommerce->liste_permission();
            if(!empty($listepermission)){
                $data['infos'] = $listepermission;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}



	public function ajout_rolepermission()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idpermission = $this->input->post('idpermission');
				$idrole = $this->input->post('idrole');
		        $response = $this->model_ecommerce->ajout_rolepermission($idpermission,$idrole);
				
				json_output($response['status'],$response);
			}
		}
	}

	public function modification_rolepermission(){

		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
	
			//$idutilisateur = $this->input->get('idutilisateur');
			$idroleperm = $this->input->get('idroleperm');
			$idpermission = $this->input->get('idpermission');
			$idrole = $this->input->get('idrole');
			
			
	
			$this->load->model('model_ecommerce');
	
			$modifrolepermission = $this->model_ecommerce->modification_rolepermission($idroleperm,$idpermission,$idrole);
			if(!empty($modifrolepermission)){
				$data['infos'] = $modifrolepermission ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
			}else{
				
				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
			}
	
		}
	}

	public function suppression_rolepermission(){

		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
	
			//$idutilisateur = $this->input->get('idutilisateur');
			$idroleperm = $this->input->get('idroleperm');
			
	
			$this->load->model('model_ecommerce');
	
			$suproleperm = $this->model_ecommerce->suppression_rolepermission($idroleperm);
			if(!empty($suproleperm)){
				$data['infos'] = $suproleperm ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
			}else{
				
				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
			}
	
		}
	}

	public function liste_rolepermission(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			
            $this->load->model('model_enseignant');

            $info_rolepermission = $this->model_enseignant->liste_rolepermission();
            if(!empty($info_rolepermission)){
                $data['infos'] = $info_rolepermission ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_inscription()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){

                //$fichier=$this->do_upload();
				
				
				$idrole =$this->input->post('idrole');
				$nom = $this->input->post('nom');
				
				$email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                $confirmpwd = $this->input->post('confirmpwd');
                //$code = $this->input->post('code');
                
		        $response = $this->model_ecommerce->ajout_inscription($idrole,$nom,$email,$pwd,$confirmpwd);
				
				json_output($response['status'],$response);
			}
		}
	}
	

	public function modification_inscription(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idutilisateur = $this->input->get('idutilisateur');
			$idrole = $this->input->get('idrole');
			$nom = $this->input->get('nom');
			$email = $this->input->get('email');
			$pwd = $this->input->get('pwd');
			

            $this->load->model('model_ecommerce');

            $modifinscription = $this->model_ecommerce->modification_inscription($idutilisateur,$idrole,$nom,$email,$pwd);
            if(!empty($modifinscription)){
                $data['infos'] = $modifinscription ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
	

	
	public function suppression_inscription(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idutilisateur = $this->input->get('idutilisateur');
			

            $this->load->model('model_ecommerce');

            $supidutilisateur = $this->model_ecommerce->suppression_inscription($idutilisateur);
            if(!empty($supidutilisateur)){
                $data['infos'] = $supidutilisateur ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_inscription(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			
            $this->load->model('model_ecommerce');

            $listeidutilisateur = $this->model_ecommerce->liste_inscription();
            if(!empty($listeidutilisateur)){
                $data['infos'] = $listeidutilisateur;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_categorie()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idutilisateur = $this->input->post('idutilisateur');
				$libelle = $this->input->post('libelle');
				
		        $response = $this->model_ecommerce->ajout_categorie($idutilisateur,$libelle);
				
				json_output($response['status'],$response);  
			}
		}
	}
	  
	public function modification_categorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idcat = $this->input->get('idcat');
			$idutilisateur = $this->input->get('idutilisateur');
			$libelle = $this->input->get('libelle');
			
            $this->load->model('model_ecommerce');

            $modifcategorie = $this->model_ecommerce->modification_categorie($idcat,$idutilisateur,$libelle);
            if(!empty($modifcategorie)){
                $data['infos'] = $modifcategorie ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
   
	public function suppression_categorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcat = $this->input->get('idcat');
			

            $this->load->model('model_ecommerce');

            $supcategorie = $this->model_ecommerce->suppression_categorie($idcat);
            if(!empty($supcategorie)){
                $data['infos'] = $supcategorie ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_categorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listecategorie = $this->model_ecommerce->liste_categorie();
            if(!empty($listecategorie)){
                $data['infos'] = $listecategorie;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_souscategorie()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idcat = $this->input->post('idcat');
				$idutilisateur = $this->input->post('idutilisateur');
				$libelle = $this->input->post('libelle');
				
		        $response = $this->model_ecommerce->ajout_souscategorie($idcat,$idutilisateur,$libelle);
				
				json_output($response['status'],$response);  
			}
		}
	}


	public function modification_souscategorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idsouscat = $this->input->get('idsouscat');
			$idcat = $this->input->get('idcat');
			$idutilisateur = $this->input->get('idutilisateur');
			$libelle = $this->input->get('libelle');
			
            $this->load->model('model_ecommerce');

            $modifsouscategorie = $this->model_ecommerce->modification_souscategorie($idsouscat,$idcat,$idutilisateur,$libelle);
            if(!empty($modifsouscategorie)){
                $data['infos'] = $modifsouscategorie ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function suppression_souscategorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idsouscat = $this->input->get('idsouscat');
			

            $this->load->model('model_ecommerce');

            $supsouscategorie = $this->model_ecommerce->suppression_souscategorie($idsouscat);
            if(!empty($supsouscategorie)){
                $data['infos'] = $supsouscategorie ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_souscategorie(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listesouscategorie = $this->model_ecommerce->liste_souscategorie();
            if(!empty($listesouscategorie)){
                $data['infos'] = $listesouscategorie;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_client()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$nom = $this->input->post('nom');
				$email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                $confirmpwd = $this->input->post('confirmpwd');
				
		        $response = $this->model_ecommerce->ajout_client($nom,$email,$pwd,$confirmpwd);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function modification_client(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idclient = $this->input->get('idclient');
			$nom = $this->input->get('nom');
			$email = $this->input->get('email');
			$pwd = $this->input->get('pwd');
			
            $this->load->model('model_ecommerce');

            $modifclient = $this->model_ecommerce->modification_client($idclient,$nom,$email,$pwd);
            if(!empty($modifclient)){
                $data['infos'] = $modifclient ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function suppression_client(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idclient = $this->input->get('idclient');
			

            $this->load->model('model_ecommerce');

            $supclient = $this->model_ecommerce->suppression_client($idclient);
            if(!empty($supclient)){
                $data['infos'] = $supclient ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_client(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeclient = $this->model_ecommerce->liste_client();
            if(!empty($listeclient)){
                $data['infos'] = $listeclient;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_info()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idutilisateur = $this->input->post('idutilisateur');
				$texte = $this->input->post('texte');
				
				
		        $response = $this->model_ecommerce->ajout_info($idutilisateur,$texte);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_info(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idinfo = $this->input->get('idinfo');
			$idutilisateur = $this->input->get('idutilisateur');
			$texte = $this->input->get('texte');
			
			
            $this->load->model('model_ecommerce');

            $modifinfo = $this->model_ecommerce->update_info($idinfo,$idutilisateur,$texte);
            if(!empty($modifinfo)){
                $data['infos'] = $modifinfo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_info(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idinfo = $this->input->get('idinfo');
			

            $this->load->model('model_ecommerce');

            $supinfo = $this->model_ecommerce->delete_info($idinfo);
            if(!empty($supinfo)){
                $data['infos'] = $supinfo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_info(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeinfo = $this->model_ecommerce->liste_info();
            if(!empty($listeinfo)){
                $data['infos'] = $listeinfo;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function ajout_produit()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idsouscat = $this->input->post('idsouscat');
                $idutilisateur = $this->input->post('idutilisateur');
                $idimage = $this->input->post('idimage');
				$libelle = $this->input->post('libelle');
				$prix = $this->input->post('prix');
				$poids = $this->input->post('poids');
				
				
		        $response = $this->model_ecommerce->ajout_produit($idsouscat,$idutilisateur,$idimage,$libelle,$prix,$poids);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_produit(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idproduit = $this->input->get('idproduit');
			$idsouscat = $this->input->get('idsouscat');
			$idutilisateur = $this->input->get('idutilisateur');
			
			$libelle = $this->input->get('libelle');
			$prix = $this->input->get('prix');
			$poids = $this->input->get('poids');
			
			
            $this->load->model('model_ecommerce');

            $modifproduit = $this->model_ecommerce->update_produit($idproduit,$idsouscat,$idutilisateur,$libelle,$prix,$poids);
            if(!empty($modifproduit)){
                $data['infos'] = $modifproduit ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_produit(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idproduit = $this->input->get('idproduit');
			

            $this->load->model('model_ecommerce');

            $supproduit = $this->model_ecommerce->delete_produit($idproduit);
            if(!empty($supproduit)){
                $data['infos'] = $supproduit ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_produit(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeproduit = $this->model_ecommerce->liste_produit();
            if(!empty($listeproduit)){
                $data['infos'] = $listeproduit;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_panier()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idclient = $this->input->post('idclient');
				$libelle = $this->input->post('libelle');
				$statupanier = $this->input->post('statupanier');
				
				
				
		        $response = $this->model_ecommerce->ajout_panier($idclient,$libelle,$statupanier);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_panier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idpanier = $this->input->get('idpanier');
			$idclient = $this->input->get('idclient');
			$libelle = $this->input->get('libelle');
			
			$statupanier = $this->input->get('statupanier');
			
            $this->load->model('model_ecommerce');

            $modifpanier = $this->model_ecommerce->update_panier($idpanier,$idclient,$libelle,$statupanier);
            if(!empty($modifpanier)){
                $data['infos'] = $modifpanier ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_panier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idpanier = $this->input->get('idpanier');
			

            $this->load->model('model_ecommerce');

            $suppanier = $this->model_ecommerce->delete_panier($idpanier);
            if(!empty($suppanier)){
                $data['infos'] = $suppanier ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_panier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listepanier = $this->model_ecommerce->liste_panier();
            if(!empty($listepanier)){
                $data['infos'] = $listepanier;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function ajout_comment()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;

				$nom = $this->input->post('nom');
				$texte = $this->input->post('texte');
				
				
				
				
		        $response = $this->model_ecommerce->ajout_comment($nom,$texte);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_comment(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$texte = $this->input->get('texte');
			$idcommentaire = $this->input->get('idcommentaire');
			
			
            $this->load->model('model_ecommerce');

            $modifcomment = $this->model_ecommerce->update_comment($idcommentaire,$texte);
            if(!empty($modifcomment)){
                $data['infos'] = $modifcomment ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_comment(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcommentaire = $this->input->get('idcommentaire');
			

            $this->load->model('model_ecommerce');

            $supcomment = $this->model_ecommerce->delete_comment($idcommentaire);
            if(!empty($supcomment)){
                $data['infos'] = $supcomment ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_comment(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listecomment = $this->model_ecommerce->liste_comment();
            if(!empty($listecomment)){
                $data['infos'] = $listecomment;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function ajout_commande()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;

				$idclient = $this->input->post('idclient');
				$montanttotal = $this->input->post('montanttotal');
				$statucommande = $this->input->post('statucommande');
				
				
				
				
		        $response = $this->model_ecommerce->ajout_commande($idclient,$montanttotal,$statucommande);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_commande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idcommande = $this->input->get('idcommande');
			$idclient = $this->input->get('idclient');
			$montanttotal = $this->input->get('montanttotal');
			$statucommande = $this->input->get('statucommande');
			
			
            $this->load->model('model_ecommerce');

            $modifcommande = $this->model_ecommerce->update_commande($idcommande,$idclient,$montanttotal,$statucommande);
            if(!empty($modifcommande)){
                $data['infos'] = $modifcommande ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_commande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcommande = $this->input->get('idcommande');
			

            $this->load->model('model_ecommerce');

            $supidcommande = $this->model_ecommerce->delete_commande($idcommande);
            if(!empty($supidcommande)){
                $data['infos'] = $supidcommande ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_commande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listecommande = $this->model_ecommerce->liste_commande();
            if(!empty($listecommande)){
                $data['infos'] = $listecommande;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_produitpanier()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idproduit = $this->input->post('idproduit');
				$idpanier = $this->input->post('idpanier');
				$montant = $this->input->post('montant');
				$montanttotal = $this->input->post('montanttotal');
				$remise = $this->input->post('remise');
				
				
				
				
		        $response = $this->model_ecommerce->ajout_produitpanier($idproduit,$idpanier,$montant,$montanttotal,$remise);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_produitpanier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			$idproduitpanier = $this->input->get('idproduitpanier');
			$idproduit = $this->input->get('idproduit');
			$idpanier = $this->input->get('idpanier');
			$montant = $this->input->get('montant');
			$montanttotal = $this->input->get('montanttotal');
			$remise = $this->input->get('remise');
			
			
            $this->load->model('model_ecommerce');

            $modifproduitpanier = $this->model_ecommerce->update_produitpanier($idproduitpanier,$idproduit,$idpanier,$montant,$montanttotal,$remise);
            if(!empty($modifproduitpanier)){
                $data['infos'] = $modifproduitpanier ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_produitpanier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idproduitpanier = $this->input->get('idproduitpanier');
			

            $this->load->model('model_ecommerce');

            $supproduitpanier = $this->model_ecommerce->delete_produitpanier($idproduitpanier);
            if(!empty($supproduitpanier)){
                $data['infos'] = $supproduitpanier ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_produitpanier(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeproduitpanier = $this->model_ecommerce->liste_produitpanier();
            if(!empty($listeproduitpanier)){
                $data['infos'] = $listeproduitpanier;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function do_upload()
        {
			$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

            $this->load->model("model_ecommerce");
		   
			$check_auth_client=true;
			
			if($check_auth_client == true){
//echo(base_url()."assets/images");
//echo getcwd()."/n";

            //$config['upload_path']          = "/home/admin/web/vps732924.ovh.net/public_html/Ecommerce/assets/images";
            $config['upload_path']          = "C:\wamp64\www\E-Commerce\assets\images";  
                $config['allowed_types']        = 'gif|jpg|jpeg|png|csv|pdf|mpeg|avi|mp4|mov';
                $config['max_size']             = 400000000000000000;
                $config['max_width']            = 4024;
                $config['max_height']           = 4024;

                

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('idimage'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        var_dump($error);
                }
                else
                {
                        $data2 = $this->upload->data();
//var_dump($data2);
//exit;
$idutilisateur = $this->input->post('idutilisateur');
$chemin['chemin']=base_url('assets/images/'.$data2['file_name']);
$datafichier['datafichier']=$data2['image_size_str'];
$nom['nom']=$data2['orig_name'];



$response = $this->model_ecommerce->ajout_image($idutilisateur,$nom['nom'],$chemin['chemin'],$datafichier['datafichier']);

			
return $response;
//$this->image->insert($data1); 
				}

                }
		}	
    }


    public function modification_image(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $idimage = $this->input->get('idimage');
			$idutilisateur = $this->input->get('idutilisateur');
			$idproduit = $this->input->get('idproduit');
			$chemin = $this->input->get('chemin');
			$datafichier = $this->input->get('datafichier');
			$nom = $this->input->get('nom');
			
            $this->load->model('model_ecommerce');

            $modifimage = $this->model_ecommerce->modification_image($idimage,$idutilisateur,$idproduit,$chemin,$datafichier,$nom);
            if(!empty($modifimage)){
                $data['infos'] = $modifimage ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
    

    public function suppression_image(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idimage = $this->input->get('idimage');
			

            $this->load->model('model_ecommerce');

            $supimage = $this->model_ecommerce->suppression_image($idimage);
            if(!empty($supimage)){
                $data['infos'] = $supimage ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    

    public function liste_image(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeimage = $this->model_ecommerce->liste_image();
            if(!empty($listeimage)){
                $data['infos'] = $listeimage;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
    


    public function ajout_video()
        {
			$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

            $this->load->model("model_ecommerce");
		   
			$check_auth_client=true;
			
			if($check_auth_client == true){
//echo(base_url()."assets/images");
//echo getcwd()."/n";

            //$config['upload_path']          = "/home/admin/web/vps732924.ovh.net/public_html/Ecommerce/assets/images";
            $config['upload_path']          = "C:\wamp64\www\E-Commerce\assets\images";  
                $config['allowed_types']        = 'gif|jpg|jpeg|png|csv|pdf|mpeg|avi|mp4|mov';
                $config['max_size']             = 400000000000000000;
                $config['max_width']            = 4024;
                $config['max_height']           = 4024;

                

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('idvideo'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        var_dump($error);
                }
                else
                {
                        $data2 = $this->upload->data();
//var_dump($data2);
//exit;
$idutilisateur = $this->input->post('idutilisateur');
$chemin['chemin']=base_url('assets/images/'.$data2['file_name']);
$datafichier['datafichier']=$data2['image_size_str'];
$libelle['libelle']=$data2['orig_name'];



$response = $this->model_ecommerce->ajout_video($idutilisateur,$libelle['libelle'],$chemin['chemin'],$datafichier['datafichier']);

			
return $response;
//$this->image->insert($data1); 
				}

                }
		}	
    }


    public function update_video(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $idvideo = $this->input->get('idvideo');
			$idutilisateur = $this->input->get('idutilisateur');
			$libelle = $this->input->get('libelle');
			$chemin = $this->input->get('chemin');
			$datafichier = $this->input->get('datafichier');
			
            $this->load->model('model_ecommerce');

            $modifvideo = $this->model_ecommerce->update_video($idvideo,$idutilisateur,$libelle,$chemin,$datafichier);
            if(!empty($modifvideo)){
                $data['infos'] = $modifvideo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
    

    public function delete_video(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idvideo = $this->input->get('idvideo');
			

            $this->load->model('model_ecommerce');

            $supidvideo = $this->model_ecommerce->delete_video($idvideo);
            if(!empty($supidvideo)){
                $data['infos'] = $supidvideo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    

    public function liste_video(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listevideo = $this->model_ecommerce->liste_video();
            if(!empty($listevideo)){
                $data['infos'] = $listevideo;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
	
	

	public function ajout_produitcommande()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_ecommerce');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idproduit = $this->input->post('idproduit');
				$idcommande = $this->input->post('idcommande');
				$montant = $this->input->post('montant');
				$montanttotal = $this->input->post('montanttotal');
				$remise = $this->input->post('remise');
		        $response = $this->model_ecommerce->ajout_produitcommande($idproduit,$idcommande,$montant,$montanttotal,$remise);
				
				json_output($response['status'],$response);
			}
		}
	}

	public function update_produitcommande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idproduitcommande = $this->input->get('idproduitcommande');
			$idproduit = $this->input->get('idproduit');
			$idcommande = $this->input->get('idcommande');
			$montant = $this->input->get('montant');
			$montanttotal = $this->input->get('montanttotal');
			$remise = $this->input->get('remise');
			

            $this->load->model('model_ecommerce');

            $modifproduitcommande = $this->model_ecommerce->update_produitcommande($idproduitcommande,$idproduit,$idcommande,$montant,$montanttotal,$remise);
            if(!empty($modifproduitcommande)){
                $data['infos'] = $modifproduitcommande ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function suppression_produitcommande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idproduitcommande = $this->input->get('idproduitcommande');
			

            $this->load->model('model_ecommerce');

            $supproduitcommande = $this->model_ecommerce->suppression_produitcommande($idproduitcommande);
            if(!empty($supproduitcommande)){
                $data['infos'] = $supproduitcommande ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_produitcommande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_ecommerce');

            $listeproduitcommande = $this->model_ecommerce->liste_produitcommande();
            if(!empty($listeproduitcommande)){
                $data['infos'] = $listeproduitcommande;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


}
