<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enseignant extends CI_Controller {


	public $est_autoriser = false;

	public function __construct()
    {
		parent::__construct();
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
	public function login()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$this->load->model('model_enseignant');

			//$check_auth_client = $this->model_enseignant->check_auth_client();
			$check_auth_client=true;
			
			if($check_auth_client == true){
				$params = $_REQUEST;
				$username = $params['username'];
		        $password = $params['password'];
 
		        $response = $this->model_enseignant->login($username,$password);
				
				json_output($response['status'],$response);
			}
		}
	}

	public function liste_matiere(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_professeur = $this->input->get('id_professeur'); 

$id_classe = $this->input->get('id_classe'); 

$this->load->model('model_enseignant');

/**  auth bloc 
$check_auth_client = $this->model_enseignant->check_auth_client();

			if($check_auth_client == true){

				$response = $this->model_enseignant->auth();
		        if($response['status'] == 200){
// ramener le bloc ici


				}

			}


			*/
		$info_matiere= 	$this->model_enseignant->liste_matiere($id_professeur,$id_classe);

		if(!empty($info_matiere)){
			$data['infos'] = $info_matiere ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}



	}


	public function liste_classe(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

            $id_professeur = $this->input->get('id_professeur');

            $id_cycle = $this->input->get('id_cycle');

            $this->load->model('model_enseignant');

/**  auth bloc 
$check_auth_client = $this->model_enseignant->check_auth_client();

			if($check_auth_client == true){

				$response = $this->model_enseignant->auth();
		        if($response['status'] == 200){
// ramener le bloc ici


				}

			}

 */

		$info_classe = 	$this->model_enseignant->liste_classe($id_professeur,$id_cycle);

		if(!empty($info_classe)){
            $data['infos'] = $info_classe ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);
		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);
		}


    }





	}

	public function liste_coupureannee(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            $id_cycle = $this->input->get('id_cycle');

            $this->load->model('model_enseignant');

            $info_coupureannee = $this->model_enseignant->liste_coupureannee($id_cycle);
            if(!empty($info_coupureannee)){
                $data['infos'] = $info_coupureannee ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}

	public function liste_cycle_ecole(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            $id_ecole = $this->input->get('id_ecole');

            $this->load->model('model_enseignant');

            $info_cycleecole = $this->model_enseignant->liste_cycle_ecole($id_ecole);
            if(!empty($info_cycleecole)){
                $data['infos'] = $info_cycleecole ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }

        }
	}
	

	public function consulter_presence_classe(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            $id_classe = $this->input->get('id_classe');
            $id_professeur = $this->input->get('id_professeur');
            $id_matiere = $this->input->get('id_matiere');
			$date_presence = $this->input->get('date_presence');

            $this->load->model('model_enseignant');

            $liste_eleve_classe = $this->model_enseignant->consulter_presence_classe($id_classe,$id_professeur,$id_matiere,$date_presence);
           // var_dump($liste_eleve_classe);
            if(!empty($liste_eleve_classe)){
                $data['infos'] = $liste_eleve_classe ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
                }
            }

        }
public function consult_presence(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            $id_inscription = $this->input->get('id_inscription');

            $id_professeur = $this->input->get('id_professeur');

            $id_classe = $this->input->get('id_classe');

            $id_matiere = $this->input->get('id_matiere');

            $date_presence = $this->input->get('date_presence');

            $this->load->model('model_enseignant');


            $presence = $this->model_enseignant->consult_presence($id_inscription,$id_professeur,$id_classe,$id_matiere,$date_presence);

            if(!empty($presence)){
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$presence);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }


        }
    }
	public function liste_note_eleve(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_inscription = $this->input->get('id_inscription'); 

$id_classe = $this->input->get('id_classe'); 
$id_professeur = $this->input->get('id_professeur'); 
$id_matiere = $this->input->get('id_matiere'); 

$this->load->model('model_enseignant');

/**  auth bloc 
$check_auth_client = $this->model_enseignant->check_auth_client();

			if($check_auth_client == true){

				$response = $this->model_enseignant->auth();
		        if($response['status'] == 200){
// ramener le bloc ici


				}

			}


			*/
		$info_note_eleve= 	$this->model_enseignant->liste_note_eleve($id_classe,$id_professeur,$id_matiere);

		if(!empty($info_note_eleve)){
			
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$info_note_eleve);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}



	}

	public function liste_note_eleves(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_classe= $this->input->get('id_classe');
$id_professeur = $this->input->get('id_professeur'); 
$id_matiere = $this->input->get('id_matiere'); 

$this->load->model('model_enseignant');

		$info_note_eleves= 	$this->model_enseignant->liste_note_eleves($id_classe,$id_professeur,$id_matiere);

		if(!empty($info_note_eleves)){
			$data['infos'] = $info_note_eleves ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}



	}

	public function liste_profes(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_ecole = $this->input->get('id_ecole');
			$id_professeur = $this->input->get('id_professeur');

			$this->load->model('model_enseignant');

			$liste_profes = $this->model_enseignant->liste_profes($id_ecole,$id_professeur);
		   // var_dump($liste_eleve_classe);
			if(!empty($liste_profes)){
				$data['infos'] = $liste_profes ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
			}else{

				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
				}
			}

		}

    public function listematiere(){


        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {

            $id_professeur = $this->input->get('id_professeur');

            $this->load->model('model_enseignant');


            $presence = $this->model_enseignant->listematiere($id_professeur);

            if(!empty($presence)){
                $data['classe'] = $presence ;
                $response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$data);
            }else{

                $message['message']= " aucune donnée trouvé";
                $response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
                json_output($response['status'],$message);
            }


        }
    }
	public function nbre_presence_absence(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_ecole = $this->input->get('id_ecole'); 
			$id_professeur = $this->input->get('id_professeur'); 



$this->load->model('model_enseignant');

/**  auth bloc 
$check_auth_client = $this->model_enseignant->check_auth_client();

			if($check_auth_client == true){

				$response = $this->model_enseignant->auth();
		        if($response['status'] == 200){
// ramener le bloc ici


				}

			}


			*/
		$info_presence_absence= 	$this->model_enseignant->nbre_presence_absence($id_ecole,$id_professeur);

		if(!empty($info_presence_absence)){
			$data['infos'] = $info_presence_absence ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}



	}

	public function nbre_absence(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			



$this->load->model('model_enseignant');

/**  auth bloc 
$check_auth_client = $this->model_enseignant->check_auth_client();

			if($check_auth_client == true){

				$response = $this->model_enseignant->auth();
		        if($response['status'] == 200){
// ramener le bloc ici


				}

			}


			*/
		$info_absence= 	$this->model_enseignant->nbre_absence();

		if(!empty($info_absence)){
			$data['infos'] = $info_absence ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


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
	public function liste_eleve_clase(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

$id_classe = $this->input->get('id_classe'); 
$id_professeur = $this->input->get('id_professeur'); 
$id_matiere = $this->input->get('id_matiere'); 

$this->load->model('model_enseignant');

		$info_eleve_classe = $this->model_enseignant->liste_eleve_clase($id_classe,$id_professeur,$id_classe);

		if(!empty($info_eleve_classe['listeleve'])){
			$data['infos'] = $info_eleve_classe ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}	
		}

	}
	public function nom_matiere(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$id_matiere = $this->input->get('id_matiere'); 

$this->load->model('model_enseignant');

		$info_mat= 	$this->model_enseignant->nom_matiere($id_matiere);

		if(!empty($info_mat)){
			$data['infos'] = $info_mat ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}
	}	
		
	public function listeExam(){


			$method = $_SERVER['REQUEST_METHOD'];
			if($method != 'GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			} else {

				$id_ecole = $this->input->get('id_ecole'); 
	
	$this->load->model('model_enseignant');
	
			$info_mat= 	$this->model_enseignant->listeExam($id_ecole);
	
			if(!empty($info_mat)){
				$data['infos'] = $info_mat ;
				$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$data);
	
	
			}else{
	
				$message['message']= " aucune donnée trouvé";
				$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
				json_output($response['status'],$message);
	
	
			}
	
		
			}


	}
	public function Update_presence(){


		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$id_professeur = $this->input->get('id_professeur');
			$idecole = $this->input->get('idecole');
			$id_inscription = $this->input->get('id_inscription');
			$id_classe = $this->input->get('id_classe');
			$id_cycle = $this->input->get('id_cycle');
			$id_matiere = $this->input->get('id_matiere');
			$date_presence = $this->input->get('date_presence');
			$heureDebut = $this->input->get('heureDebut');
			$heureFin = $this->input->get('heureFin');
			$heureFin = $this->input->get('heureFin');
			$actif = $this->input->get('actif');

$this->load->model('model_enseignant');

		$info_mat= 	$this->model_enseignant->Update_presence($id_professeur,$idecole, $id_inscription, $id_classe, $id_cycle, $id_matiere, $date_presence, $heureDebut, $heureFin,$actif);

		if(!empty($info_mat)){
			$data['infos'] = $info_mat ;
			$response['status'] = 200;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$data);


		}else{

			$message['message']= " aucune donnée trouvé";
			$response['status'] = 404;  // ligne a enlever quand on ramene dns le bloc de login
			json_output($response['status'],$message);


		}

	
		}


}
	




}
