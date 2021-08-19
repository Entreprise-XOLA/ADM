<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Livraison extends CI_Controller {

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
			$this->load->model('model_livraison');

			$check_auth_client = $this->model_livraison->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$params = $_REQUEST;
				$tel = $this->input->post('tel');
		        $pwd = $this->input->post('pwd');
				$rponse['status']=200;
		        $response = $this->model_livraison->login1($tel,$pwd);
				
				json_output($rponse['status'],$response);
			}
		}
    }
    
    public function login2()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			$check_auth_client = $this->model_livraison->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$params = $_REQUEST;
				$tel = $this->input->post('tel');
		        $pwd = $this->input->post('pwd');
				$rponse['status']=200;
		        $response = $this->model_livraison->login2($tel,$pwd);
				
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
			$this->load->model('model_livraison');

			$check_auth_client = $this->model_livraison->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$params = $_REQUEST;
				$email = $this->input->post('email');
		        $pwd = $this->input->post('pwd');
				$rponse['status']=200;
		        $response = $this->model_livraison->loginclient($email,$pwd);
				
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
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$libelle = $this->input->post('libelle');
		        $response = $this->model_livraison->ajout_role($libelle);
				
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
			

            $this->load->model('model_livraison');

            $modifrole = $this->model_livraison->modification_role($idrole,$libelle);
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
			

            $this->load->model('model_livraison');

            $suprole = $this->model_livraison->suppression_role($idrole);
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
			
            $this->load->model('model_livraison');

            $listerole = $this->model_livraison->liste_role();
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
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$libelle = $this->input->post('libelle');
		        $response = $this->model_livraison->ajout_permission($libelle);
				
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
			
			
	
			$this->load->model('model_livraison');
	
			$modifpermission = $this->model_livraison->modification_permission($idpermission,$libelle);
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
			
	
			$this->load->model('model_livraison');
	
			$suppermission = $this->model_livraison->suppression_permission($idpermission);
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
			
            $this->load->model('model_livraison');

            $listepermission = $this->model_livraison->liste_permission();
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
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$idpermission = $this->input->post('idpermission');
				$idrole = $this->input->post('idrole');
		        $response = $this->model_livraison->ajout_rolepermission($idpermission,$idrole);
				
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
			
			
	
			$this->load->model('model_livraison');
	
			$modifrolepermission = $this->model_livraison->modification_rolepermission($idroleperm,$idpermission,$idrole);
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
			
	
			$this->load->model('model_livraison');
	
			$suproleperm = $this->model_livraison->suppression_rolepermission($idroleperm);
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

			
            $this->load->model('model_livraison');

            $info_rolepermission = $this->model_livraison->liste_rolepermission();
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

	public function ajout_inscriptionclient()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){

                //$fichier=$this->do_upload();
				
				
				$idrole =$this->input->post('idrole');
				$nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $tel = $this->input->post('tel');
				$email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                $confirmpwd = $this->input->post('confirmpwd');
                
                //$code = $this->input->post('code');
                
		        $response = $this->model_livraison->ajout_inscriptionclient($idrole,$nom,$prenom,$tel,$email,$pwd,$confirmpwd);
				
				json_output($response['status'],$response);
			}
		}
    }
    

    public function ajout_inscriptionlivreur()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){

                //$fichier=$this->do_upload();
				
				
				$idrole =$this->input->post('idrole');
				$nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $tel = $this->input->post('tel');
				$email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                $confirmpwd = $this->input->post('confirmpwd');
                
                //$code = $this->input->post('code');
                
		        $response = $this->model_livraison->ajout_inscriptionlivreur($idrole,$nom,$prenom,$tel,$email,$pwd,$confirmpwd);
				
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
            $prenom = $this->input->get('prenom');
            $tel = $this->input->get('tel');
			$email = $this->input->get('email');
			$pwd = $this->input->get('pwd');
			$pd=password_hash($pwd, PASSWORD_DEFAULT);

            $this->load->model('model_livraison');

            $modifinscription = $this->model_livraison->modification_inscription($idutilisateur,$idrole,$nom,$prenom,$tel,$email,$pd);
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
			

            $this->load->model('model_livraison');

            $supidutilisateur = $this->model_livraison->suppression_inscription($idutilisateur);
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
			
            $this->load->model('model_livraison');

            $listeidutilisateur = $this->model_livraison->liste_inscription();
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

	public function ajout_livreur()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){ 
				//$data = $_REQUEST;
				$idutilisateur = $this->input->post('idutilisateur');
                $nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $tel = $this->input->post('tel');
                $email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                
				
		        $response = $this->model_livraison->ajout_livreur($idutilisateur,$nom,$prenom,$tel,$email,$pwd);
				
				json_output($response['status'],$response);  
			}
		}
    }
    
    public function ajout_livreur1()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){ 
				//$data = $_REQUEST;
				$idutilisateur = $this->input->post('idutilisateur');
                $nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $tel = $this->input->post('tel');
                $email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                $confirmpwd = $this->input->post('confirmpwd');
				
		        $response = $this->model_livraison->ajout_livreur($idutilisateur,$nom,$prenom,$tel,$email,$pwd,$confirmpwd);
				
				json_output($response['status'],$response);  
			}
		}
	}
	  
	public function modification_livreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			
			$idutilisateur = $this->input->get('idutilisateur');
            $nom = $this->input->get('nom');
            $prenom = $this->input->get('prenom');
            $tel = $this->input->get('tel');
            $email = $this->input->get('email');
            $pwd = $this->input->get('pwd');
			$idtype = $this->input->get('idtype');
            $this->load->model('model_livraison');

            $modiflivreur = $this->model_livraison->modification_livreur($idutilisateur,$nom,$prenom,$tel,$email,$pwd,$idtype);
            if(!empty($modiflivreur)){
                $data['infos'] = $modiflivreur ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
   
	public function suppression_livreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idutilisateur = $this->input->get('idutilisateur');
			

            $this->load->model('model_livraison');

            $suplivreur = $this->model_livraison->suppression_livreur($idutilisateur);
            if(!empty($suplivreur)){
                $data['infos'] = $suplivreur ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_livreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listelivreur = $this->model_livraison->liste_livreur();
            if(!empty($listelivreur)){
                $data['infos'] = $listelivreur;
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
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                $idutilisateur = $this->input->post('idutilisateur');
                $idtype = $this->input->post('idtype');
				$nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $tel = $this->input->post('tel');
                $email = $this->input->post('email');
                $pwd = $this->input->post('pwd');
                
				
		        $response = $this->model_livraison->ajout_client($idutilisateur,$idtype,$nom,$prenom,$tel,$email,$pwd);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function modification_client(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            
            $idutilisateur = $this->input->get('idutilisateur');
            $nom = $this->input->get('nom');
            $prenom = $this->input->get('prenom');
            $tel = $this->input->get('tel');
			$email = $this->input->get('email');
			$pwd = $this->input->get('pwd');
            $idtype = $this->input->get('idtype');
            
            $this->load->model('model_livraison');

            $modifclient = $this->model_livraison->modification_client($idutilisateur,$nom,$prenom,$tel,$email,$pwd,$idtype);
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
			$idutilisateur = $this->input->get('idutilisateur');
			

            $this->load->model('model_livraison');

            $supclient = $this->model_livraison->suppression_client($idutilisateur);
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
			

            $this->load->model('model_livraison');

            $listeclient = $this->model_livraison->liste_client();
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

	public function ajout_geolocalisation()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				//$data = $_REQUEST;
				$longitude = $this->input->post('longitude');
				$latitude = $this->input->post('latitude');
		        $response = $this->model_livraison->ajout_geolocalisation($longitude,$latitude);
				
				return $response;
			}
		}
	}

	public function modification_geolocalisation(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idgeo = $this->input->get('idgeo');
			$longitude = $this->input->get('longitude');
			$latitude = $this->input->get('latitude');
			

            $this->load->model('model_livraison');

            $modifgeo = $this->model_livraison->modification_geolocalisation($idgeo,$longitude,$latitude);
            if(!empty($modifgeo)){
                $data['infos'] = $modifgeo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";  
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function suppression_geolocalisation(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idgeo = $this->input->get('idgeo');
			

            $this->load->model('model_livraison');

            $supgeo = $this->model_livraison->suppression_geolocalisation($idgeo);
            if(!empty($supgeo)){
                $data['infos'] = $supgeo ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_geolocalisation(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listegeolocalisation = $this->model_livraison->liste_geolocalisation();
            if(!empty($listegeolocalisation)){
                $data['infos'] = $listegeolocalisation;
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
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                //$geolocalisation = $this->ajout_geolocalisation();
				$idutilisateur = $this->input->post('idutilisateur');
                //$idgeo = $geolocalisation;
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $nomdestinataire = $this->input->post('nomdestinataire');
				$prenomdestinataire = $this->input->post('prenomdestinataire');
				$adressedestinataire = $this->input->post('adressedestinataire');
                $teldestinaire = $this->input->post('teldestinaire');
				$note = $this->input->post('note');
				$typepaiement = $this->input->post('typepaiement');
				
				
		        $response = $this->model_livraison->ajout_commande($idutilisateur,$latitude,$longitude,$nomdestinataire,$prenomdestinataire,$adressedestinataire,$teldestinaire,$note,$typepaiement);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_commande(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            //$geolocalisation = $this->ajout_geolocalisation();
			$idcommande = $this->input->get('idcommande');
			$idclient = $this->input->get('idclient');
			//$idgeo = $geolocalisation;
            $latitude = $this->input->get('latitude');
            $longitude = $this->input->get('longitude');
			$nomdestinataire = $this->input->get('nomdestinataire');
			$prenomdestinataire = $this->input->get('prenomdestinataire');
            $adresse = $this->input->get('adresse');
            $teldestinaire = $this->input->get('teldestinaire');
			$note = $this->input->get('note');
			$typepaiement = $this->input->get('typepaiement');
			
			
            $this->load->model('model_livraison');

            $modifcommande = $this->model_livraison->update_commande($idcommande,$idclient, $latitude,$longitude,$nomdestinataire,$prenomdestinataire,$adresse,$teldestinaire,$note,$typepaiement);
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
			

            $this->load->model('model_livraison');

            $supcommande = $this->model_livraison->delete_commande($idcommande);
            if(!empty($supcommande)){
                $data['infos'] = $supcommande ;
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
			

            $this->load->model('model_livraison');

            $listecommande = $this->model_livraison->liste_commande();
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


	public function ajout_typepaiement()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                
				$libelle = $this->input->post('libelle');
                
				
		        $response = $this->model_livraison->ajout_typepaiement($libelle);
				
				json_output($response['status'],$response);  
			}
		}
	}

	public function update_typepaiement(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            
			$idpaiement = $this->input->get('idpaiement');
			$libelle = $this->input->get('libelle');
			
			
            $this->load->model('model_livraison');

            $modiftypepaiement = $this->model_livraison->update_typepaiement($idpaiement,$libelle);
            if(!empty($modiftypepaiement)){
                $data['infos'] = $modiftypepaiement ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function delete_typepaiement(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idpaiement = $this->input->get('idpaiement');
			

            $this->load->model('model_livraison');

            $suptypepaiement = $this->model_livraison->delete_typepaiement($idpaiement);
            if(!empty($suptypepaiement)){
                $data['infos'] = $suptypepaiement ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_typepaiement(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listetypepaiement = $this->model_livraison->liste_typepaiement();
            if(!empty($listetypepaiement)){
                $data['infos'] = $listetypepaiement;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function ajout_course()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                
				$idutilisateur = $this->input->post('idutilisateur');
				$adressedepart = $this->input->post('adressedepart');
				$adressearrive = $this->input->post('adressearrive');
				$datelivraison = $this->input->post('datelivraison');
				$prix = $this->input->post('prix');
                
				
		        $response = $this->model_livraison->ajout_course($idutilisateur,$adressedepart,$adressearrive,$datelivraison,$prix);
				
				json_output($response['status'],$response);  
			}
		}
	}


	public function update_course(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            
			$idcourse = $this->input->get('idcourse');
			$idutilisateur = $this->input->get('idutilisateur');
			$adressedepart = $this->input->get('adressedepart');
			$adressearrive = $this->input->get('adressearrive');
			$datelivraison = $this->input->get('datelivraison');
			$prix = $this->input->get('prix');
			
			
            $this->load->model('model_livraison');

            $modifcourse = $this->model_livraison->update_course($idcourse,$idutilisateur,$adressedepart,$adressearrive,$datelivraison,$prix);
            if(!empty($modifcourse)){
                $data['infos'] = $modifcourse ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function delete_course(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcourse = $this->input->get('idcourse');
			

            $this->load->model('model_livraison');

            $supcourse = $this->model_livraison->delete_course($idcourse);
            if(!empty($supcourse)){
                $data['infos'] = $supcourse ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_course(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listecourse = $this->model_livraison->liste_course();
            if(!empty($listecourse)){
                $data['infos'] = $listecourse;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    

    public function liste_courselivreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');
            $idutilisateur = $this->input->get('idutilisateur');
            $listecourse = $this->model_livraison->liste_courselivreur($idutilisateur);
            if(!empty($listecourse)){
                $data['infos'] = $listecourse;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function ajout_contact()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                
				$idutilisateur = $this->input->post('idutilisateur');
				
				$objet = $this->input->post('objet');
				$message1 = $this->input->post('message1');
				
                
				
		        $response = $this->model_livraison->ajout_contact($idutilisateur,$objet,$message1);
				
				json_output($response['status'],$response);  
			}
		}
	}


	public function update_contact(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            
			$idcontact = $this->input->get('idcontact');
			$idutilisateur = $this->input->get('idutilisateur');
			$objet = $this->input->get('objet');
			$message1 = $this->input->get('message1');
			
			
			
            $this->load->model('model_livraison');

            $modifcontact = $this->model_livraison->update_contact($idcontact,$idutilisateur,$objet,$message1);
            if(!empty($modifcontact)){
                $data['infos'] = $modifcontact ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function delete_contact(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcontact = $this->input->get('idcontact');
			

            $this->load->model('model_livraison');

            $supcontact = $this->model_livraison->delete_contact($idcontact);
            if(!empty($supcontact)){
                $data['infos'] = $supcontact ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}


	public function liste_contact(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listecontact = $this->model_livraison->liste_contact();
            if(!empty($listecontact)){
                $data['infos'] = $listecontact;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    
    public function info_message(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			
            $idcontact = $this->input->get('idcontact');
            $this->load->model('model_livraison');

            $listeinfo = $this->model_livraison->info_message($idcontact);
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

    public function ajout_contactlivreur()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                
				$idclient = $this->input->post('idclient');
				$idlivreur = $this->input->post('idlivreur');
				$objet = $this->input->post('objet');
				$message1 = $this->input->post('message1');
				
                
				
		        $response = $this->model_livraison->ajout_contactlivreur($idlivreur,$objet,$message1);
				
				json_output($response['status'],$response);  
			}
		}
	}

    public function update_contactlivreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            
			$idcontact = $this->input->get('idcontact');
			$idlivreur = $this->input->get('idlivreur');
			$objet = $this->input->get('objet');
			$message1 = $this->input->get('message1');
			
			
			
            $this->load->model('model_livraison');

            $modifcontactlivreur = $this->model_livraison->update_contactlivreur($idcontact,$idlivreur,$objet,$message1);
            if(!empty($modifcontactlivreur)){
                $data['infos'] = $modifcontactlivreur ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

    public function delete_contactlivreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idcontact = $this->input->get('idcontact');
			

            $this->load->model('model_livraison');

            $supcontactlivreur = $this->model_livraison->delete_contactlivreur($idcontact);
            if(!empty($supcontactlivreur)){
                $data['infos'] = $supcontactlivreur ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

    public function liste_contactlivreur(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listecontactlivreur = $this->model_livraison->liste_contactlivreur();
            if(!empty($listecontactlivreur)){
                $data['infos'] = $listecontactlivreur;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    
    public function ajout_typeclient()
    {
        $method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_livraison');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
                //$data = $_REQUEST;
                
				
				$libelle = $this->input->post('libelle');
				
				
		        $response = $this->model_livraison->ajout_typeclient($libelle);
				
				json_output($response['status'],$response);  
			}
		}
    }
    

    public function update_typeclient(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            
			$idtype = $this->input->get('idtype');
			$libelle = $this->input->get('libelle');
			
			
			
            $this->load->model('model_livraison');

            $modiftypeclient = $this->model_livraison->update_typeclient($idtype,$libelle);
            if(!empty($modiftypeclient)){
                $data['infos'] = $modiftypeclient ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    
    public function delete_typeclient(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

			//$idutilisateur = $this->input->get('idutilisateur');
			$idtype = $this->input->get('idtype');
			

            $this->load->model('model_livraison');

            $suptypeclient = $this->model_livraison->delete_typeclient($idtype);
            if(!empty($suptypeclient)){
                $data['infos'] = $suptypeclient ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
				
                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }
    
    public function liste_typeclient(){

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
			

            $this->load->model('model_livraison');

            $listetypeclient = $this->model_livraison->liste_typeclient();
            if(!empty($listetypeclient)){
                $data['infos'] = $listetypeclient;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{
                $message['message']= "aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
    }


    

//fonction de reponse cote admin

public function ajout_reponse(){

    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'GET'){

        json_output(400,array('status' => 400,'message' => 'Bad request.'));

    } else {
        $idcontact = $this->input->get('idcontact');
        $reponse = $this->input->get('reponse');
 
        $this->load->model('model_livraison');

        $modifreponse = $this->model_livraison->ajout_reponse($idcontact,$reponse);

        if(!empty($modifreponse)){

            $data['infos'] = $modifreponse ;

            $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login

            json_output($response['status'],$data);

        }else{
            $message['message']= " aucune donnée trouvé";
            $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
            json_output($response['status'],$message);
        }
    }
}

//fonction d'affichage de reponse coté mobile

public function affiche_reponse(){

    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'GET'){

        json_output(400,array('status' => 400,'message' => 'Bad request.'));

    } else {

        $idutilisateur = $this->input->get('idutilisateur');

        $this->load->model('model_livraison');

        $listereponse = $this->model_livraison->affiche_reponse($idutilisateur);

        if(!empty($listereponse)){

            $data['infos'] = $listereponse;

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
