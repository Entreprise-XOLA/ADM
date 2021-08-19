<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_enseignant extends CI_Model {

    var $client_service = "Enseignant-client";
    var $auth_key       = "api_xola_enseignant";

    /**
     * verification si l'application qui appel l'api est autorisée
     */
    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }

    
    public function login($username,$password)
    {
        $q  = $this->db->query("SELECT P.IDPROFESSEUR as id_professeur , us.IDUTILISATEUR as id_utilisateur , us.MOT_DE_PASSE as password , us.IDENTIFIANT as username, P.IDECOLE as idecole FROM professeur P , utilisateur us  WHERE  P.IDUTILISATEUR = us.IDUTILISATEUR and us.IDENTIFIANT ='".$username."' ;")->row();
       
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->id_utilisateur;
            $id_professeur =  $q->id_professeur;
            $idecole= $q->idecole;
           //  echo $hashed_password ." ".$password;
        //exit;
            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
               $last_login = date('Y-m-d H:i:s');
               $token = crypt(substr( md5(rand()), 0, 7));
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('IDUTILISATEUR',$id)->update('utilisateur',array('LAST_LOGIN' => $last_login));
               $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token,'expired_at' => $expired_at));
               if ($this->db->trans_status() === FALSE){
                  $this->db->trans_rollback();
                  return array('status' => 500,'message' => 'Internal server error.');
               } else {
                  $this->db->trans_commit();
                 
                  return array('status' => 200,'message' => 'Successfully login.','id_professeur'=>$id_professeur, 'id_utilisateur' => $id, 'token' => $token, 'idecole'=>$idecole);
               }
            } else {
                exit();
               return array('status' => 204,'message' => 'Wrong password.');
            }
        }
    }

    public function logout()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id',$users_id)->where('token',$token)->delete('users_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
    }

    // permet de verifier si l'utilisateur qui fait la requete est connecté ou pas 
    public function auth()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->select('expired_at')->from('users_authentication')->where('users_id',$users_id)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        } else {
            if($q->expired_at < date('Y-m-d H:i:s')){
                return json_output(401,array('status' => 401,'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('users_id',$users_id)->where('token',$token)->update('users_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }
/**
 * liste matière 
 *  permet de retourner la liste des matière enseigner par un professeur  

 * 
 */
    public function liste_matiere($id_professeur,$id_classe)
    {
        $info_matieres =  $this->db->query("SELECT e.idprofesseur,e.idclasse,m.libellematiere ,m.idmatiere FROM `enseigner` e ,`matiere` m WHERE e.idmatiere=m.idmatiere and e.idclasse=".$id_classe." and e.idprofesseur=".$id_professeur)->result();
 
        $liste_matiere = array();
        foreach($info_matieres as $info){

            $data['idmatiere'] = $info->idmatiere;
            $data['libellematiere'] = $info->libellematiere;
            $data['idclasse'] = $info->idclasse;
            $data['idprofesseur'] = $info->idprofesseur;

            array_push($liste_matiere, $data);
        }

        return $liste_matiere;
    }


    public function liste_classe($id_professeur,$id_cycle){

        $infos_classe =  $this->db->query("SELECT  distinct e.idprofesseur,c.idcycle,c.libelleclasse,e.idclasse FROM `enseigner` e ,`classe` c WHERE e.idclasse=c.idclasse and e.idprofesseur=".$id_professeur." and c.idcycle= ".$id_cycle." ;   ")->result();

        $liste_classes = array();
        foreach($infos_classe as $info){

            $data['idprofesseur'] = $info->idprofesseur;
            $data['idcycle'] = $info->idcycle;
            $data['libelleclasse'] = $info->libelleclasse;
            $data['idclasse'] = $info->idclasse;
            $data['url_matiere'] = "#/listmatiere/".$info->idclasse;

            array_push($liste_classes, $data);
        }

        return $liste_classes;
        
    }

    public function liste_coupureannee($id_cycle)
    {
        return $this->db->query("SELECT ca.idcoupure, libellecoupure FROM `coupureannee` ca, `cycle` c WHERE ca.idcycle=c.idcycle and c.idcycle=".$id_cycle)->result();
    }

    public function consulter_presence_classe($id_classe,$id_professeur,$id_matiere,$date_presence)
    {
        $liste_eleve=$this->db->query("SELECT a.codeappr, a.nomappr, a.prenomappr, a.sexe, a.datenaisance, a.adresse, i.idinscription from apprenant a, inscription i, classe c, enseigner e, professeur p where a.codeappr=i.codeappr and c.idclasse=i.idclasse and c.idclasse=e.idclasse and e.idprofesseur=p.idprofesseur and c.idclasse=".$id_classe." and p.idprofesseur=".$id_professeur)->result();
         $listes_eleves =array();
        foreach ($liste_eleve as $eleve) {
            $info_eleve['nomappr']= $eleve->nomappr;
            $info_eleve['prenomappr']= $eleve->prenomappr;
            $info_eleve['sexe']= $eleve->sexe;
            $info_eleve['idinscription']= $eleve->idinscription;
            $info_eleve['statuspresence']= $this->consult_presence($eleve->idinscription,$id_professeur,$id_classe,$id_matiere,$date_presence);
            array_push($listes_eleves, $info_eleve);
        }
        return $listes_eleves;
    }
    public function consult_presence($id_inscription,$id_professeur,$id_classe,$id_matiere,$date_presence)
    {
        $info_presence= $this->db->query("SELECT p.actif FROM `presence` p,`enseigner` e WHERE p.id_enseigner=e.id_enseigner and p.idinscription=".$id_inscription." and e.idprofesseur=".$id_professeur." and p.datepresence= '".$date_presence."' and e.idclasse=".$id_classe." and e.idmatiere=".$id_matiere)->row();
        if (isset($info_presence->actif) ) {
            return (int)$info_presence->actif;
        }else{
            return 0;
        }
    }

   // e.idprofesseur,e.idclasse, a.codeappr,a.nomappr,a.prenomappr ,,`inscription` i,`apprenant` a and c.idinscription=i.idinscription 

    public function liste_note_eleve($id_inscription,$id_classe,$id_professeur,$id_matiere){
        return $this->db->query(" SELECT e.idclasse,e.idprofesseur,e.idmatiere,a.codeappr,a.nomappr,a.prenomappr,c.idcoupure,c.idexamen ,c.note FROM `composer` c ,`inscription` i, `enseigner` e, `apprenant` a WHERE c.id_enseigner=e.id_enseigner and c.idinscription=i.idinscription and i.codeappr=a.codeappr and c.idinscription=".$id_inscription." and e.idclasse=".$id_classe." and e.idprofesseur=".$id_professeur." and e.idmatiere=".$id_matiere.";   ")->result(); 
        
    }

    public function liste_eleve_clase($id_classe,$id_professeur,$id_matiere){

        $listeleve=$this->db->query(" SELECT a.codeappr,a.nomappr,a.prenomappr ,i.idinscription FROM `inscription` i,`apprenant` a WHERE i.codeappr=a.codeappr and i.idclasse=".$id_classe.";   ")->result();
  $listeleves=array();
          foreach($listeleve as $eleve) {
              $info_eleve['nomappr']= $eleve->nomappr;
              $info_eleve['prenomappr']= $eleve->prenomappr;
              $info_eleve['idinscription']= $eleve->idinscription;
               $info_eleve['listenote']= $this->liste_note_eleves($eleve->idinscription,$id_classe,$id_professeur,$id_matiere);
              array_push($listeleves, $info_eleve);
          }
          $data['listeleve']=$listeleves;
          //$data['libelleexams']=$this->libelle_exam($idexamen);
          $data['nomatiere']=$this->nom_matiere($id_matiere);
          return $data;  
      }
    public function liste_note_eleves($id_inscription,$id_classe,$id_professeur,$id_matiere){
        $listenote=$this->db->query(" SELECT e.idclasse,e.idprofesseur,e.idmatiere,m.libellematiere,c.idcoupure,c.idexamen,c.note,c.base FROM `composer` c ,`inscription` i, `enseigner` e, matiere m WHERE c.id_enseigner=e.id_enseigner and c.idinscription=i.idinscription and e.idmatiere=m.idmatiere and e.idprofesseur=".$id_professeur."  and e.idclasse=".$id_classe." and e.idmatiere=".$id_matiere." and c.idinscription=".$id_inscription." ;   ")->result(); 
         
        $listenotes=array();
        foreach($listenote as $note) {
            $info_note['idclasse']= $note->idclasse;
            $info_note['idprofesseur']= $note->idprofesseur;
            $info_note['idcoupure']= $note->idcoupure;
            $info_note['idexamen']= $note->idexamen;
            $info_note['note']= $note->note;
            $info_note['base']= $note->base;
            
            array_push($listenotes, $info_note);
        }
        
        return $listenotes;
        
    }
    public function nom_matiere($id_matiere)
    {
        $mat= $this->db->query("SELECT libellematiere FROM `matiere` WHERE idmatiere=".$id_matiere)->row();
        return $mat->libellematiere;

    }
    public function listeExam($id_ecole)
    {
        return $this->db->query("SELECT e.idexamen, e.libelleexamen FROM `examen` e WHERE  e.idecole=".$id_ecole." ;   ")->result();

    }
    public function liste_cycle_ecole($id_ecole){
        $info_cycle =  $this->db->query(" SELECT idcycle, libellecycle FROM `cycle` WHERE idecole=".$id_ecole." ;  ")->result(); 
        $liste_cycle = array();
        foreach($info_cycle as $info){

            $data['idcycle'] = $info->idcycle;
            $data['libellecycle'] = $info->libellecycle;
            $data['url_class'] = "#/ConsultNote/".$info->idcycle;

            array_push($liste_cycle, $data);
        }

        return $liste_cycle;
        
    }

    public function nbre_presence_absence($id_ecole,$id_professeur){
        return $this->db->query(" SELECT Month(p.datepresence),count(p.idpresence) FROM `presence` p,`enseigner` e WHERE p.id_enseigner=e.id_enseigner and p.idecole=".$id_ecole." and e.idprofesseur=".$id_professeur." and p.actif=1 or p.actif=2
        group by Month(p.datepresence)")->result(); 
        
        
    }
    public function liste_profes($id_ecole,$id_professeur)
    {
        $listeprof=$this->db->query("SELECT distinct p.idprofesseur, nomprofesseur, prenomprofesseur, telephoneprofesseur FROM `enseigner` en,`professeur` p, `ecole` e WHERE en.idprofesseur=p.idprofesseur  and e.idecole=".$id_ecole)->result();
        $listeprofs=array();
        foreach($listeprof as $professeur) {
            $info_prof['nomprofesseur']= $professeur->nomprofesseur;
            $info_prof['prenomprofesseur']= $professeur->prenomprofesseur;
            $info_prof['telephoneprofesseur']= $professeur->telephoneprofesseur;
            $info_prof['idprofesseur']= $professeur->idprofesseur;
            $info_prof['listematiere']= $this->listematiere($professeur->idprofesseur,$id_professeur);
            array_push($listeprofs, $info_prof);
        }
        return $listeprofs;
    }
    public function listematiere($id_professeur){
        $listemat=array();
        $info_matiere=$this->db->query("SELECT DISTINCT m.idmatiere, m.libellematiere FROM `enseigner` e,`matiere` m where e.idmatiere=m.idmatiere and e.idprofesseur=".$id_professeur)->result();
        $info_matieres=array();
        foreach($info_matiere as $matiere) {
            $info_mat['idmatiere']= $matiere->idmatiere;
            $info_mat['libellematiere']= $matiere->libellematiere;
            $info_mat['listeclasse'] =$this->db->query("SELECT c.libelleclasse FROM `enseigner` e ,`classe` c WHERE  e.idclasse=c.idclasse and e.idprofesseur=".$id_professeur." and e.idmatiere=".$matiere->idmatiere)->result();
            array_push($info_matieres, $info_mat);
        }
        return $info_matieres;
    
    }
    public function recuperation_idenseigner($id_classe,$id_matiere,$id_professeur)
    {
        $recup= $this->db->query("SELECT id_enseigner FROM `enseigner` WHERE idclasse=".$id_classe." and idmatiere=".$id_matiere." and idprofesseur=".$id_professeur)->row();
        return $recup->id_enseigner;

    }
    public function Update_presence($id_professeur,$idecole, $id_inscription, $id_classe, $id_cycle, $id_matiere, $date_presence, $heureDebut, $heureFin,$actif)
    {
        //Verifier dans la table presence si une presence correspond aux informations envoyé si oui faire une mise à jour sinon insertion
        $presence_eleve= $this->consult_presence($id_inscription,$id_professeur,$id_classe,$id_matiere,$date_presence);
        if($presence_eleve!==0){
            //l'appel a été déja fait 
            $recupid_enseigner= $this->recuperation_idenseigner($id_classe,$id_matiere,$id_professeur);
            $res =  $this->db->query("UPDATE `presence` p SET p.actif=".$actif." WHERE idinscription=".$id_inscription." and datepresence='".$date_presence."' and id_enseigner='".$recupid_enseigner."' ");
        if(!empty($res) && $res === true){

            return  1;
        }else{
            return 0;
        }
        
        } else {

            // l'appel n'a pas encore ete fais
            $recupid_enseigner= $this->recuperation_idenseigner($id_classe,$id_matiere,$id_professeur);
            $today = date("Y-m-d"); 
            $date_presence = "'".$date_presence."'";
            $heureDebut = "'".$heureDebut."'" ;
             $heureFin = "'".$heureFin."'" ;
             $today = "'".$today."'";
            $res  =  $this->db->query("INSERT INTO `presence` (id_enseigner,idinscription,idecole,actif,datepresence, heureDebut,heureFin,dateajout) VALUES ($recupid_enseigner, $id_inscription, $idecole,$actif,$date_presence,$heureDebut, $heureFin,$today) ");
       
            if(!empty($res) && $res === true){

                return  1;
            }else{
                return 0;
            }
        }
    }
    
   /*public function nbre_absence_par_classe($id_classe,$id_professeur){
        return $this->db->query(" SELECT Month(p.datepresence),count(p.idpresence) FROM `presence` p,`enseigner` e WHERE p.id_enseigner=e.id_enseigner and p.actif=1  and e.idclasse=1
        group by Month(p.datepresence) ")->result(); 
        
        
    }*/



}
