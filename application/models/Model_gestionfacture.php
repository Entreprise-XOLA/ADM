<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_gestionfacture extends CI_Model {

    var $client_service = "GestionFacture-client";
    var $auth_key       = "api_gestion_gestionfacture";

    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }


    
    /*public function login($username,$password)
    {
        $q  = $this->db->select('password,id')->from('users')->where('username',$username)->get()->row();
       
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->id;
          //   echo $hashed_password ." ".$password;
        //exit;
            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
               $last_login = date('Y-m-d H:i:s');
               $token = crypt(substr( md5(rand()), 0, 7));
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('id',$id)->update('users',array('last_login' => $last_login));
               $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token,'expired_at' => $expired_at));
               if ($this->db->trans_status() === FALSE){
                  $this->db->trans_rollback();
                  return array('status' => 500,'message' => 'Internal server error.');
               } else {
                  $this->db->trans_commit();
                  return array('status' => 200,'message' => 'Successfully login.','id' => $id, 'token' => $token);
               }
            } else {
                echo "Wrong password";
                exit();
               return array('status' => 204,'message' => 'Wrong password.');
            }
        }
    }*/


    public function login1($email,$pwd){
 
        
        $q  = $this->db->query("SELECT IDUTILISATEUR as id_utilisateur , nom,prenom,tel, email , pwd FROM  utilisateur  WHERE  email ='".$email."' ;")->row();
        $hashed_password = $q->pwd;
        //var_dump($hashed_password);
        //var_dump($pwd);
        $id              = $q->id_utilisateur;
        //$password = password_hash($pwd, PASSWORD_DEFAULT); 
        $data['idutilisateur']=$q->id_utilisateur;
        $data['nom']=$q->nom;
        $data['prenom']=$q->prenom;
        $data['tel']=$q->tel;
        //var_dump(password_verify($pwd, $hashed_password));
        if (password_verify($pwd, $hashed_password)) {
            
            $last_login = date('Y-m-d H:i:s');
            
            $dateajout = date('Y-m-d H:i:s');
               $token = password_hash(substr( md5(rand()), 0, 7),PASSWORD_DEFAULT);
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('IDUTILISATEUR',$id)->update('utilisateur',array('LAST_LOGIN' => $last_login));
               $this->db->insert('utilisateurtoken',array('idutilisateur' => $id,'token' => $token,'dateajout' => $dateajout,'dateexpiration' => $expired_at));
                
               $this->db->trans_commit();
                  $data['token'] =$token;
                return $data;
                 //echo 'test';
                  //return array('status' => 200,'message' => 'Successfully login.','id_utilisateur' => $id, 'token' => $token)  
            
        } else {
            echo 'Le mot de passe est invalide.';
        }

    }





    public function logout()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id',$users_id)->where('token',$token)->delete('users_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
    }

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

//ajout des type prestation

    public function ajout_typeprestation($libelle)
    {
        $this->db->query("INSERT into typeprestation(libelle,dateajout) VALUES('$libelle',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    }



    public function liste_typeprestation()
    {
        $listetypeprestation=array();

        
        $typeprestation= $this->db->query("SELECT idtypeprestation ,libelle FROM `typeprestation`")->result();
        foreach($typeprestation as $typeprest){

        $data['idtypeprestation']= $typeprest->idtypeprestation;
        $data['libelle']= $typeprest->libelle;
        

        array_push($listetypeprestation,$data);

    }   
        return $listetypeprestation;
    }



    public function ajout_inscription($idtype,$idrole,$nom,$prenom,$tel,$ville,$quartier,$email,$pwd)
    {
        $dateexpiration=date("Y-m-d H:i:s", strtotime('+12 hours'));
        $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
        
        $this->db->query("INSERT into utilisateur(idtype,idrole,nom,prenom,tel,ville,quartier,dateexpiration,email,pwd,dateajout) VALUES('$idtype','$idrole','$nom','$prenom','$tel','$ville','$quartier','$dateexpiration','$email','$pass_hache',NOW())");
        //$this->db->insert('utilisateur',$data);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }


    public function rand_string($length) {  
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
        $size = strlen( $chars );  
        $retour = "";
       // echo "Random string =";  
        for( $i = 0; $i < (int)$length; $i++ ) {  
        $str= $chars[ rand( 0, $size - 1 ) ];  
        $retour = $retour.$str;  
        }  
        
        return $retour;

        }  

        public function rand_int($length) {  
            $chars = "0123456789";  
            $size = strlen( $chars );  
            $retour = "";
           // echo "Random string =";  
            for( $i = 0; $i < (int)$length; $i++ ) {  
            $str= $chars[ rand( 0, $size - 1 ) ];  
            $retour = $retour.$str;  
            }  
            
            return $retour;
    
            }  

    
 
    
//ajout num facture et designation detail facture
    
    
    public function ajout_factdetailtemp($idfacturetemp,$idtype,$designation,$quantite,$prixunitaire)
    { 
        $idfacturetemp1= $this->db->query("SELECT idfacturetemp FROM `facturetemp` where idfacturetemp=".$idfacturetemp."")->row();

        $idfacturetemp=$idfacturetemp1->idfacturetemp;

        $date= date("Y-m-d H:i:s");

        $designation = htmlentities($designation,ENT_QUOTES);

        $data= array(
            'idtypeprest' =>$idtype,
            'designation' =>$designation,
            'dateajout' => $date
        );
       
        $this->db->insert('detailfacturetemp', $data);
       
        $insert_id = $this->db->insert_id(); 
       
        $id_detailfacturetemp1=$this->db->query("SELECT id_detailfacturetemp FROM `detailfacturetemp` WHERE id_detailfacturetemp=$insert_id")->row();

        $id_detailfacturetemp=$id_detailfacturetemp1->id_detailfacturetemp;
//var_dump($id_detailfacturetemp);
        $selection1= $this->db->query("SELECT  id_detailfacturetemp, idtypeprest, designation FROM `detailfacturetemp` WHERE id_detailfacturetemp=".$id_detailfacturetemp." ")->row();
        $this->db->query("INSERT into detailfact(id_detailfact,idtype,designation,dateajout) VALUES('$selection1->id_detailfacturetemp','$selection1->idtypeprest','$selection1->designation',NOW())");
        
        //$this->db->query("INSERT into detailfacturetemp(idtypeprest,designation,dateajout) VALUES('$idtype','$designation',NOW())");
       
        $this->db->query("INSERT into factdetailtemp(idfacturetemp,id_detailfacturetemp,quantite,prixunitaire,dateajout) VALUES('$idfacturetemp','$id_detailfacturetemp','$quantite','$prixunitaire',NOW())");
        
        

        $selection= $this->db->query("SELECT  idfacturetemp,id_detailfacturetemp, quantite, prixunitaire FROM `factdetailtemp` WHERE idfacturetemp=".$idfacturetemp." and id_detailfacturetemp=".$selection1->id_detailfacturetemp." ")->row();
       

        $this->db->query("INSERT into factdetail(idfacture,id_detailfacture,quantite,prixunitaire,dateajout) VALUES('$selection->idfacturetemp','$selection->id_detailfacturetemp','$selection->quantite','$selection->prixunitaire',NOW())");
        
        return array('status' => 201,'message' => 'Data has been created.');
    }



    public function ajout_factdetail($idfacture,$id_detailfact)
    { 
        $idfacturetemp1= $this->db->query("SELECT idfacturetemp FROM `facturetemp` where idfacturetemp=".$idfacturetemp."")->row();

        $idfacturetemp=$idfacturetemp1->idfacturetemp;

        $date= date("Y-m-d H:i:s");

        $data= array(
            'idtypeprest' =>$idtype,
            'designation' =>$designation,
            'dateajout' => $date
        );
       
        $this->db->insert('detailfacturetemp', $data);
       
        $insert_id = $this->db->insert_id(); 
       
        $id_detailfacturetemp1=$this->db->query("SELECT id_detailfacturetemp FROM `detailfacturetemp` WHERE id_detailfacturetemp=$insert_id")->row();

        $id_detailfacturetemp=$id_detailfacturetemp1->id_detailfacturetemp;


        //$this->db->query("INSERT into detailfacturetemp(idtypeprest,designation,dateajout) VALUES('$idtype','$designation',NOW())");
       
        $this->db->query("INSERT into factdetailtemp(idfacturetemp,id_detailfacturetemp,quantite,prixunitaire,dateajout) VALUES('$idfacturetemp','$id_detailfacturetemp','$quantite','$prixunitaire',NOW())");
        
        return array('status' => 201,'message' => 'Data has been created.');
    }


    //ajout info facture
    public function update_facturetemp($idfacturetemp,$numfacture,$reduction,$nom,$nif,$adresse,$bp,$telephone,$email,$declaration,$concerne,$bureaudest,$poidbrut,$poidnet)
    { 
        $declaration = htmlentities($declaration,ENT_QUOTES);
        $concerne = htmlentities($concerne,ENT_QUOTES);
        $bureaudest = htmlentities($bureaudest,ENT_QUOTES);
        $nom = htmlentities($nom,ENT_QUOTES);
        $facturetemp=$this->db->query("SELECT idfacturetemp,numfacture FROM `facturetemp` WHERE idfacturetemp=".$idfacturetemp." and numfacture='".$numfacture."' ")->row();
       
        $requete=$this->db->query("UPDATE facturetemp set reduction='$reduction' ,nom='$nom', nif='$nif', adresse='$adresse', bp='$bp', telephone='$telephone',email='$email', declaration='$declaration',concerne='$concerne',bureaudest='$bureaudest',poidbrut='$poidbrut',poidnet='$poidnet' where idfacturetemp=".$facturetemp->idfacturetemp." and numfacture='".$facturetemp->numfacture."'");

        $selection=$this->db->query("SELECT idfacturetemp,numfacture,reduction,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poidbrut,poidnet FROM `facturetemp` WHERE idfacturetemp=".$idfacturetemp." and numfacture='".$numfacture."' ")->row();
        
       
        $this->db->query("INSERT into facture(idfacture,numfacture,reduction,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poidbrut,poidnet,dateajout) VALUES('$selection->idfacturetemp','$selection->numfacture','$selection->reduction','$selection->nom','$selection->nif','$selection->adresse','$selection->bp','$selection->telephone','$selection->email','$selection->declaration','$selection->concerne','$selection->bureaudest','$selection->poidbrut','$selection->poidnet',NOW())");
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function update_facturetemp1($idfacturetemp,$numfacture,$reduction,$nom,$nif,$adresse,$bp,$telephone,$email,$declaration,$concerne,$bureaudest,$poidbrut,$poidnet)
    { 
        $declaration = htmlentities($declaration,ENT_QUOTES);
        $concerne = htmlentities($concerne,ENT_QUOTES);
        $bureaudest = htmlentities($bureaudest,ENT_QUOTES);
        $nom = htmlentities($nom,ENT_QUOTES);
        $facturetemp=$this->db->query("SELECT idfacturetemp,numfacture FROM `facturetemp` WHERE idfacturetemp=".$idfacturetemp." and numfacture='".$numfacture."' ")->row();
       
        $requete=$this->db->query("UPDATE facturetemp set reduction='$reduction' ,nom='$nom', nif='$nif', adresse='$adresse', bp='$bp', telephone='$telephone',email='$email', declaration='$declaration',concerne='$concerne',bureaudest='$bureaudest',poidbrut='$poidbrut',poidnet='$poidnet' where idfacturetemp=".$facturetemp->idfacturetemp." and numfacture='".$facturetemp->numfacture."'");

        $selection=$this->db->query("SELECT idfacturetemp,numfacture,reduction,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poidbrut,poidnet FROM `facturetemp` WHERE idfacturetemp=".$idfacturetemp." and numfacture='".$numfacture."' ")->row();
        
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    //ajout de la quantite et du prix unitaire

    public function update_factdetailtemp($idfacturetemp,$id_detailfacturetemp,$designation,$quantite,$prixunitaire)
    {
        $designation = htmlentities($designation,ENT_QUOTES);
        $factdetailtemp=$this->db->query("SELECT idfacturetemp,id_detailfacturetemp FROM `factdetailtemp` WHERE idfacturetemp=".$idfacturetemp." and id_detailfacturetemp='".$id_detailfacturetemp."' ")->row();
        $requete=$this->db->query("UPDATE factdetailtemp set quantite='$quantite',prixunitaire='$prixunitaire' where idfacturetemp=".$factdetailtemp->idfacturetemp." and id_detailfacturetemp='".$factdetailtemp->id_detailfacturetemp."'");
        $requete1=$this->db->query("UPDATE detailfacturetemp d,factdetailtemp f ,facturetemp ft set d.designation='$designation' where f.idfacturetemp=".$factdetailtemp->idfacturetemp." and d.id_detailfacturetemp='".$factdetailtemp->id_detailfacturetemp."'");
        return array('status' => 201,'message' => 'Data has been created.');
    }


   //liste facture
    
   public function liste_facturetemp()
    {
        $listefacturetemp=array();

        
        $listefact= $this->db->query("SELECT idfacturetemp ,numfacture, nom, dateajout FROM `facturetemp`")->result();
        foreach($listefact as $listef){

        $data['idfacturetemp']= $listef->idfacturetemp;
        $data['numfacture']= $listef->numfacture;
        $data['nom']= html_entity_decode($listef->nom,ENT_QUOTES);
        $data['dateajout']= $listef->dateajout;
        

        array_push($listefacturetemp,$data);

    }   
        return $listefacturetemp;
    }


    //liste detail facture

    public function liste_detailfacturetemp()
    {
        $listedetailfacturetemp=array();

        
        $listedetailfact= $this->db->query("SELECT id_detailfacturetemp ,designation FROM `detailfacturetemp`")->result();
        foreach($listedetailfact as $listedetail){

        $data['id_detailfacturetemp']= $listedetail->id_detailfacturetemp;
        $data['designation']= $listedetail->designation;
        

        array_push($listedetailfacturetemp,$data);

    }   
        return $listedetailfacturetemp;
    }

    public function liste_fraisdedouane($idfacturetemp)
    {
        $listefraisdouane=array();

        
        $liste_fraisdouane= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." ")->result();

        foreach($liste_fraisdouane as $liste_frais){

        $data['id_detailfacturetemp']= (int)$liste_frais->id_detailfacturetemp;
        $data['designation']= html_entity_decode($liste_frais->designation,ENT_QUOTES);
        $data['quantite']= (int)$liste_frais->quantite;
        $data['prixunitaire']= (int)$liste_frais->prixunitaire;
        $data['tht']= ((int)$liste_frais->quantite)*((int)$liste_frais->prixunitaire);
        

        array_push($listefraisdouane,$data);

    }   
        return $listefraisdouane;
    }


    public function liste_autredebours($idfacturetemp)
    {
        $listeautredebours=array();

        
        $liste_autredebours= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." ")->result();
  
        foreach($liste_autredebours as $liste_autredeb){

        $data['id_detailfacturetemp']= (int)$liste_autredeb->id_detailfacturetemp;
        $data['designation']= html_entity_decode($liste_autredeb->designation,ENT_QUOTES);
        $data['quantite']= (int)$liste_autredeb->quantite;
        $data['prixunitaire']= (int)$liste_autredeb->prixunitaire;
        $data['tht']= ((int)$liste_autredeb->quantite)*((int)$liste_autredeb->prixunitaire);
        

        array_push($listeautredebours,$data);

    }   
        return $listeautredebours;
    }

    public function liste_honoraire($idfacturetemp)
    {
        $listehonoraire=array();

        
        $liste_honoraire= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." ")->result();

        foreach($liste_honoraire as $liste_honor){

        $data['id_detailfacturetemp']= (int)$liste_honor->id_detailfacturetemp;
        $data['designation']= html_entity_decode($liste_honor->designation,ENT_QUOTES);
        $data['quantite']= (int)$liste_honor->quantite;
        $data['prixunitaire']= (int)$liste_honor->prixunitaire;
        $data['tht']= ((int)$liste_honor->quantite)*((int)$liste_honor->prixunitaire);
        

        array_push($listehonoraire,$data);

    }   
        return $listehonoraire;
    }

    
    public function liste_detail($idfacturetemp,$id_detailfacturetemp)
    {
        $listedetail=array();

        
        $liste_detail= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp." ")->result();

        foreach($liste_detail as $liste_det){

        $data['id_detailfacturetemp']= (int)$liste_det->id_detailfacturetemp;
        $data['designation']= html_entity_decode($liste_det->designation,ENT_QUOTES);
        $data['quantite']= (int)$liste_det->quantite;
        $data['prixunitaire']= (int)$liste_det->prixunitaire;
        

        array_push($listedetail,$data);

    }   
        return $listedetail;
    }



    public function recherche_detailfacture($idtypeprest,$designation)
    {

        $detailfacture= $this->db->query("SELECT typeprestation.libelle as libelle,detailfacturetemp.designation as designation FROM `detailfacturetemp`,`typeprestation` WHERE detailfacturetemp.idtypeprest=typeprestation.idtypeprestation and idtypeprest like '%".$idtypeprest."%' or designation like '%".$designation."%'")->row();
        
        
        $data['libelle']= $detailfacture->libelle;
        $data['designation']= $detailfacture->designation;
        
        
        return $data;
         //echo $requete;
        //var_dump($code);
    }


    public function recherche_facture($nom)
    {

        $facture= $this->db->query("SELECT numfacture,nom FROM `facturetemp` WHERE nom like '%".$nom."%'")->row();
        
        
        $data['numfacture']= $facture->numfacture;
        $data['nom']= $facture->nom;
        
        return $data;
         //echo $requete;
        //var_dump($code);
    }


    public function totalht_fraisdouane($idfacturetemp,$id_detailfacturetemp)
    {

        $prixunitaire= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp." ")->row();
        
       $prixunitaire1=$prixunitaire->prixunitaire;
       
        $quantite= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp.";")->row();
        $quantite1=$quantite->quantite;
 
        (int)$total=(int)$prixunitaire1*(int)$quantite1;
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       $this->db->query("UPDATE factdetailtemp set totalht='$total'  where id_detailfacturetemp=".$id_detailfacturetemp." and idfacturetemp=".$idfacturetemp." ");
        
        return (int)$total;
         //echo $requete;
        //var_dump($code);
    }

    public function totalht_autredebours($idfacturetemp,$id_detailfacturetemp)
    {

        $prixunitaire= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp." ")->row();
        
       $prixunitaire1=$prixunitaire->prixunitaire;
       
        $quantite= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp.";")->row();
        $quantite1=$quantite->quantite;
 
        (int)$total=(int)$prixunitaire1*(int)$quantite1;
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       $this->db->query("UPDATE factdetailtemp set totalht='$total' where id_detailfacturetemp=".$id_detailfacturetemp." and idfacturetemp=".$idfacturetemp." ");
        
        return (int)$total;
         //echo $requete;
        //var_dump($code);
    }

    public function totalht_honoraire($idfacturetemp,$id_detailfacturetemp)
    {

        $prixunitaire= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp." ")->row();
        
        $prixunitaire1=$prixunitaire->prixunitaire;
        
         $quantite= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp.";")->row();
         $quantite1=$quantite->quantite;
  
         (int)$total=(int)$prixunitaire1*(int)$quantite1;
         //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
        // return array('status' => 201,'message' => 'Data has been created.');
        $this->db->query("UPDATE factdetailtemp set totalht='$total'  where id_detailfacturetemp=".$id_detailfacturetemp." and idfacturetemp=".$idfacturetemp." ");
         
         return (int)$total;
         //echo $requete;
        //var_dump($code);
    }

    
    public function total_fraisdouane($idfacturetemp,$id_detailfacturetemp)
    {


        $somme= $this->db->query("SELECT sum(f.totalht) as somme FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=1 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp." ")->row();
        
       $somme1=$somme->somme;
        

        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       $this->db->query("UPDATE `factdetailtemp` f, `detailfacturetemp` d,`facturetemp` ft set f.total='$somme1'  where f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=1 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp."");
         
        return (int)$somme1;
         //echo $requete;
        //var_dump($code);
    }


    public function total_autredebours($idfacturetemp,$id_detailfacturetemp)
    {


        $somme= $this->db->query("SELECT sum(f.totalht) as somme FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=2 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp." ")->row();
        
       $somme1=$somme->somme;
        

        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       $this->db->query("UPDATE `factdetailtemp` f, `detailfacturetemp` d,`facturetemp` ft set f.total='$somme1'  where f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=2 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp."");
         
        return (int)$somme1;
         //echo $requete;
        //var_dump($code);
    }

    public function total_debours($idfacturetemp,$id_detailfacturetemp)
    {
        $total=0;

        $total_autredebours= $this->total_autredebours($idfacturetemp,$id_detailfacturetemp);

        $total_fraisdouane= $this->total_fraisdouane($idfacturetemp,$id_detailfacturetemp);
        
        $total=$total_autredebours+$total_fraisdouane;
        
        $this->db->query("UPDATE `factdetailtemp` f, `detailfacturetemp` d,`facturetemp` ft set f.totaldebours='$total'  where d.idtypeprest=1 and d.idtypeprest=2 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp."");

        return (int)$total;
         //echo $requete;
        //var_dump($code);
    }


    public function total_honoraire($idfacturetemp,$id_detailfacturetemp)
    {


        $somme= $this->db->query("SELECT sum(f.totalht) as somme FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=3 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp." ")->row();
        
        $somme1=$somme->somme;
         
 
         //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
        // return array('status' => 201,'message' => 'Data has been created.');
        $this->db->query("UPDATE `factdetailtemp` f, `detailfacturetemp` d,`facturetemp` ft set f.total='$somme1'  where f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=3 and f.id_detailfacturetemp=".$id_detailfacturetemp." and f.idfacturetemp=".$idfacturetemp."");
          
         return (int)$somme1;
         //echo $requete;
        //var_dump($code);
    }



    public function montantht($idfacturetemp)
    {


        $total=0;

        $total_debours= $this->total_debours();

        $total_honoraire= $this->total_honoraire();
        
        $total=$total_debours+$total_honoraire;
        
        $this->db->query("UPDATE facturetemp set montantht='$total'  where idfacturetemp=".$idfacturetemp."");

        return (int)$total;
         //echo $requete;
        //var_dump($code);
    }


    public function montantnetht($idfacturetemp)
    {


        $total=0;

        $montantht= $this->montantht($idfacturetemp);

        $somme1= $this->db->query("SELECT reduction FROM `facturetemp` WHERE idfacturetemp=".$idfacturetemp." ")->row();

       $somme=$somme1->reduction;
        
        $total=$montantht-$somme;
        
        $this->db->query("UPDATE facturetemp set montantnet='$total'  where idfacturetemp=".$idfacturetemp."");

        return (int)$total;
    }


    public function tva($idfacturetemp)
    {


        $total_honoraire= $this->total_honoraire($idfacturetemp);
        
       $tva=($total_honoraire*18)/100;
        

        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       $this->db->query("UPDATE facturetemp set tva='$tva'  where idfacturetemp=".$idfacturetemp."");
        
        return (int)$tva;
         //echo $requete;
        //var_dump($code);
    }


 

    public function montanttc($idfacturetemp)
    {

        $total=0;

        $montantnetht= $this->montantnetht($idfacturetemp);

        $tva= $this->tva($idfacturetemp);

        $total=$montantnetht+$tva;
        
        $this->db->query("UPDATE facturetemp set montanttc='$total'  where idfacturetemp=".$idfacturetemp."");

        return (int)$total;
         //echo $requete;
        //var_dump($code);
    }

    public function info_fraisdouane($idfacturetemp,$id_detailfacturetemp)
    {
       
        $info_detail= $this->db->query("SELECT d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp)->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->designation;
         //echo $requete;
        //var_dump($code);
    }

    public function info_quantitefraisdouane($idfacturetemp,$id_detailfacturetemp)
    {
       
        $info_detail= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp)->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->quantite;
         //echo $requete;
        //var_dump($code);
    }

    public function info_prixunitairefraisdouane($idfacturetemp,$id_detailfacturetemp)
    {
       
        $info_detail= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp)->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->prixunitaire;
         //echo $requete;
        //var_dump($code);
    }

    public function info_autredebours($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp." ")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->designation;
         //echo $requete;
        //var_dump($code);
    }

    public function info_quantiteautredebours($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp." ")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->quantite;
         //echo $requete;
        //var_dump($code);
    }

    public function info_prixunitaireautredebours($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp." ")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->prixunitaire;
         //echo $requete;
        //var_dump($code);
    }

    public function info_honoraire($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp."")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->designation;
         //echo $requete;
        //var_dump($code);
    }

    public function info_quantitehonoraire($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT f.quantite as quantite FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp."")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->quantite;
         //echo $requete;
        //var_dump($code);
    }

    public function info_prixunitairehonoraire($idfacturetemp,$id_detailfacturetemp)
    {

        $info_detail= $this->db->query("SELECT f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." and f.id_detailfacturetemp=".$id_detailfacturetemp."")->row();
        
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_detail->prixunitaire;
         //echo $requete;
        //var_dump($code);
    }

   
    public function modification_numfacture($idfacturetemp,$numfacture)
    {
 
        $requete=$this->db->query("UPDATE facturetemp set numfacture='$numfacture'  where idfacturetemp=".$idfacturetemp."");
        $retournum= $this->db->query("SELECT numfacture FROM `facturetemp` where idfacturetemp=".$idfacturetemp." ")->row();

        return $retournum;
         //echo $requete;
        //var_dump($code);
    }
    
    public function modification_numfacture2($idfacturetemp,$numfacture)
    {
 
        $requete=$this->db->query("UPDATE facturetemp set numfacture2='$numfacture'  where idfacturetemp=".$idfacturetemp."");
        $retournum= $this->db->query("SELECT numfacture2 FROM `facturetemp` where idfacturetemp=".$idfacturetemp." ")->row();

        return $retournum;
         //echo $requete;
        //var_dump($code);
    }

    public function dateToFrench($date, $format) 
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
    }

    public function retour_numfacture()
    {
        $date= date("Y-m-d H:i:s");

        $numfacture=$this->rand_string('3').$this->rand_int('6')."/".$this->rand_int('2');

        $data1= array(
            'numfacture' =>$numfacture,
            'dateajout' => $date
        );
       
        $this->db->insert('facturetemp', $data1);
       
        $insert_id1 = $this->db->insert_id();
       
        $retournum= $this->db->query("SELECT idfacturetemp,numfacture,dateajout FROM `facturetemp` order by idfacturetemp desc ")->row();

        $data['idfacturetemp']= $retournum->idfacturetemp;
        $data['numfacture']= $retournum->numfacture;
       
      
        return $data;

    }

    public function info_type($idfacturetemp,$type)
    {
        
        $info_facture= $this->db->query("SELECT distinct f.id_detailfacturetemp as id_detailfacturetemp, d.idtypeprest as idtypeprest ,d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=".$type." and f.idfacturetemp=".$idfacturetemp." ")->result();
        
        return $info_facture;  
      
    }

    public function info_facture1($idfacturetemp)
    {
        $listetype=array();
        $type= $this->db->query("SELECT distinct d.idtypeprest as idtypeprest FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." ")->result();
        
       
       
        foreach($type as $liste_det){
            $info_type= $this->db->query("SELECT distinct d.idtypeprest as idtypeprest,f.id_detailfacturetemp as id_detailfacturetemp,f.idfacturetemp as idfacturetemp,d.designation as designation,f.quantite as quantite,f.prixunitaire as prixunitaire FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and d.idtypeprest=".$liste_det->idtypeprest." and f.idfacturetemp=".$idfacturetemp." ")->row();
            //var_dump($info_type);
            $data['idtypeprest']= $info_type->idtypeprest;
            $data['infodetail']= $this->info_type($info_type->idfacturetemp,$info_type->idtypeprest);
            
           
    
            array_push($listetype,$data);

        }
       
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $listetype;
         //echo $requete;
        //var_dump($code);
    }
    
    
    public function info_facture($idfacturetemp)
    {
       
        $listedetail=array();

        $info_facture= $this->db->query("SELECT distinct f.idfacturetemp as idfacturetemp,ft.numfacture as numfacture,ft.numfacture2 as numfacture2,ft.reduction as reduction,ft.nom as nom,ft.nif as nif,ft.adresse as adresse,ft.bp as bp,ft.telephone as telephone,ft.email as email,ft.declaration declaration,ft.concerne as concerne,ft.bureaudest as bureaudest,ft.poidbrut as poidbrut,ft.poidnet as poidnet,ft.dateajout as dateajout FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$idfacturetemp." ")->result();
        
        
        
        foreach($info_facture as $liste_det){
            $data['idfacturetemp']= $liste_det->idfacturetemp;
            $data['numfacture']= $liste_det->numfacture;
            $data['numfacture2']= $liste_det->numfacture2;
            $data['reduction']= $liste_det->reduction;
            $data['nom']= html_entity_decode($liste_det->nom,ENT_QUOTES);
            $data['nif']= $liste_det->nif;
            $data['adresse']= $liste_det->adresse;
            $data['bp']= $liste_det->bp;
            $data['telephone']= $liste_det->telephone;
        $data['email']= $liste_det->email;
        $data['declaration']= html_entity_decode($liste_det->declaration,ENT_QUOTES);
        $data['concerne']= html_entity_decode($liste_det->concerne,ENT_QUOTES);
        $data['bureaudest']= html_entity_decode($liste_det->bureaudest,ENT_QUOTES);
        $data['poidbrut']= $liste_det->poidbrut;
        $data['poidnet']= $liste_det->poidnet;
        $data['dateajout']= $liste_det->dateajout;

        $data['detail']= $this->info_facture1($liste_det->idfacturetemp);
        
      

        array_push($listedetail,$data);

    }   
        return $listedetail;
        
        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
       
         //echo $requete;
        //var_dump($code);
    }

    public function modification_date($idfacturetemp,$dateajout)
    {
 
        $date=$this->db->query("UPDATE facturetemp set dateajout='$dateajout'  where idfacturetemp=".$idfacturetemp."");
        $retourdate= $this->db->query("SELECT dateajout FROM `facturetemp` where idfacturetemp=".$idfacturetemp." ")->row();

        return $retourdate;
         //echo $requete;
        //var_dump($code);
    }


    public function delete_facture($idfacturetemp)
    {
       
        $requete=$this->db->query("UPDATE facturetemp set reduction='$reduction' ,nom='$nom', nif='$nif', adresse='$adresse', bp='$bp', telephone='$telephone',email='$email', declaration='$declaration',concerne='$concerne',bureaudest='$bureaudest',poidbrut='$poidbrut',poidnet='$poidnet' where idfacturetemp=".$facturetemp->idfacturetemp." and numfacture='".$facturetemp->numfacture."'");

        $factdetailtemp=$this->db->query("SELECT idfacturetemp,id_detailfacturetemp FROM `factdetailtemp` WHERE idfacturetemp=".$idfacturetemp." and id_detailfacturetemp='".$id_detailfacturetemp."' ")->row();
       
        $requete=$this->db->query("UPDATE factdetailtemp set quantite='$quantite',prixunitaire='$prixunitaire' where idfacturetemp=".$factdetailtemp->idfacturetemp." and id_detailfacturetemp='".$factdetailtemp->id_detailfacturetemp."'");

        $requete1=$this->db->query("UPDATE detailfacturetemp d,factdetailtemp f ,facturetemp ft set d.designation='$designation' where f.idfacturetemp=".$factdetailtemp->idfacturetemp." and f.id_detailfacturetemp='".$factdetailtemp->id_detailfacturetemp."'");

        //$this->db->query("INSERT into facturetemp(reduction,numfacture,nom,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poids,dateajout) VALUES('$reduction','$numfacture','$nom','$nif','$adresse','$bp','$telephone','$email','$declaration','$concerne','$bureaudest','$poids',NOW())");
       // return array('status' => 201,'message' => 'Data has been created.');
       
        return $info_facture;
         //echo $requete;
        //var_dump($code);
    }

    public function delete_detailfacture($idfacturetemp)
    {
        $this->db->query("DELETE  From factdetailtemp WHERE id_detailfacturetemp=".$idfacturetemp);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function delete_factureglobal($idfacturetemp)
    {
        $this->db->query("DELETE  From facturetemp WHERE idfacturetemp=".$idfacturetemp);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }
   
}
