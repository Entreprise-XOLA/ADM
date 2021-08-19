<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_livraison extends CI_Model {

    var $client_service = "Livraison-client";
    var $auth_key       = "api_gestion_livraison";

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


    public function login1($tel,$pwd){
 
        
        $q  = $this->db->query("SELECT IDUTILISATEUR as id_utilisateur ,idtype, nom,prenom,tel , email, pwd FROM  utilisateur  WHERE  tel ='".$tel."' ;")->row();
        $hashed_password = $q->pwd;
        //var_dump($hashed_password);
        //var_dump($pwd);
        $id              = $q->id_utilisateur;
        //$password = password_hash($pwd, PASSWORD_DEFAULT); 
        $data['idutilisateur']=$q->id_utilisateur;
        $data['nom']=$q->nom;
        $data['prenom']=$q->prenom;
        $data['tel']=$q->tel;
        $data['email']=$q->email;
        $data['idtype']=$q->idtype;
        
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

    public function login2($tel,$pwd){
 
        
        $q  = $this->db->query("SELECT IDUTILISATEUR as id_utilisateur , nom,tel , pwd FROM  utilisateur  WHERE  tel ='".$tel."' ;")->row();
        $hashed_password = $q->pwd;
        //var_dump($hashed_password);
        //var_dump($pwd);
        $id              = $q->id_utilisateur;
        //$password = password_hash($pwd, PASSWORD_DEFAULT); 
        $data['idutilisateur']=$q->id_utilisateur;
        $data['nom']=$q->nom;
        
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


    public function loginclient($email,$pwd){
 
        
        $q  = $this->db->query("SELECT idclient as id_client , nom,email , pwd FROM  client  WHERE  email ='".$email."' ;")->row();
        $hashed_password = $q->pwd;
        //var_dump($hashed_password);
        //var_dump($pwd);
        $id              = $q->id_client;
        //$password = password_hash($pwd, PASSWORD_DEFAULT); 
        $data['idclient']=$q->id_idclient;
        $data['nom']=$q->nom;
        
        //var_dump(password_verify($pwd, $hashed_password));
        if (password_verify($pwd, $hashed_password)) {
            
            $last_login = date('Y-m-d H:i:s');
            
            $dateajout = date('Y-m-d H:i:s');
               $token = password_hash(substr( md5(rand()), 0, 7),PASSWORD_DEFAULT);
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('idclient',$id)->update('client',array('LAST_LOGIN' => $last_login));
               $this->db->insert('clienttoken',array('idclient' => $id,'token' => $token,'dateajout' => $dateajout,'dateexpiration' => $expired_at));
                
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


    //ajout des role parametre: libelle
    public function ajout_role($libelle)
    {
       
        $this->db->query("INSERT into role(libelle,dateajout) VALUES('$libelle',NOW())");
        //$this->db->insert('role',$data);
        return array('status' => 201,'message' => 'Role creer avec succes.');
    }

    //modification parametre: idrole,libellerole
    public function modification_role($idrole,$libellerole)
    {

        $this->db->query("UPDATE role set libellerole=$libellerole where idrole=".$idrole);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }
//suppression parametre: idrole
    public function suppression_role($idrole)
    {
       
        $this->db->query("DELETE FROM role where idrole=".$idrole);
        //$this->db->insert('role',$data);
        return array('status' => 201,'message' => 'Role supprimé avec succes.');
    }


    public function liste_role()
    {
        $listerole=array();

        $role= $this->db->query("SELECT idrole,libelle FROM `role`")->result();
        
        foreach($role as $rol){
        $data['idrole']= $rol->idrole;
        $data['libelle']= $rol->libelle;
       

        array_push($listerole,$data);

        }
        return $listerole;
    }


    public function ajout_permission($libelle)
    {
        
        $this->db->query("INSERT INTO permission(libelle,dateajout) values('$libelle',NOW())");

        return array('status' => 201,'message' => 'Permission ajoutée avec succès.');
    }

    //modification prametre: idpermission,libelle
    public function modification_permission($idpermission,$libelle)
    {

        $this->db->query("UPDATE permission set libelle=$libelle  where idpermission=".$idpermission);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }
//suppression parametre: idpermission
    public function suppression_permission($idpermission)
    {
       
        $this->db->query("DELETE FROM permission where idpermission=".$idpermission);
        return array('status' => 201,'message' => 'Permission supprimée avec succes.');
    }


    //ajout de rolepermission parametre: idpermission,idrole

    public function ajout_rolepermission($idpermission,$idrole)
    {
        
        $this->db->query("INSERT INTO rolepermission(idpermission,idrole,dateajout) values('$idpermission','$idrole',NOW())");

        return array('status' => 201,'message' => 'RolePermission ajoutée avec succès.');
    }

    //modification parametre: idroleperm,idpermission,idrole

    public function modification_rolepermission($idroleperm,$idpermission,$idrole)
    {

        $this->db->query("UPDATE rolepermission set idpermission=$idpermission,idrole=$idrole where idroleperm=".$idroleperm);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    //suppression parametre: idroleperm

    public function suppression_rolepermission($idroleperm)
    {
       
        $this->db->query("DELETE FROM rolepermission where idroleperm=".$idroleperm);
        return array('status' => 201,'message' => 'RolePermission supprimée avec succes.');
    }

    //ajout d'un utilisateur
    public function ajout_inscriptionclient($idrole,$nom,$prenom,$tel,$email,$pwd,$confirmpwd)
    {
       $nom= htmlentities($nom,ENT_QUOTES);
        $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
        if($pwd==$confirmpwd){
            $idtype=1;
            $this->db->query("INSERT into utilisateur(idrole,idtype,nom,prenom,tel,email,pwd,dateajout) VALUES('$idrole','$idtype','$nom','$prenom','$tel','$email','$pass_hache',NOW())");        
            return array('status' => 201,'message' => 'Inscription fait avec succes.');
        } else{
            return array('status' => 201,'message' => 'Mot de passe incorrect.');
        }
          
    }

    public function ajout_inscriptionlivreur($idrole,$nom,$prenom,$tel,$email,$pwd,$confirmpwd)
    {
       $nom= htmlentities($nom,ENT_QUOTES);
        $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
        if($pwd==$confirmpwd){
            $idtype=2;
            $this->db->query("INSERT into utilisateur(idrole,idtype,nom,prenom,tel,email,pwd,dateajout) VALUES('$idrole','$idtype','$nom','$prenom','$tel','$email','$pass_hache',NOW())");        
            return array('status' => 201,'message' => 'Inscription fait avec succes.');
        } else{
            return array('status' => 201,'message' => 'Mot de passe incorrect.');
        }
          
    }


    public function modification_inscription($idutilisateur,$idrole,$idtype,$nom,$prenom,$tel,$email,$pwd)
    {

        
        $this->db->query("UPDATE utilisateur set idrole=$idrole, idtype=$idtype, nom=$nom, prenom=$prenom, tel=$tel, email=$email, pwd=$pwd  where idutilisateur=".$idutilisateur);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    //suppression parametre: idutilisateur
    public function suppression_inscription($idutilisateur)
    {
       
        $this->db->query("DELETE FROM utilisateur where idutilisateur=".$idutilisateur);
        return array('status' => 201,'message' => 'Utilisateur supprimée avec succes.');
    }


    public function liste_inscription() 
    {
        $listeinscription=array();
       
        $inscription= $this->db->query("SELECT idutilisateur,idtype,nom,prenom,tel,email FROM `utilisateur`")->result();

        foreach($inscription as $inscrip){
        $data['idutilisateur']= $inscrip->idutilisateur;
        $data['idtype']= $inscrip->idtype;
        $data['nom']= html_entity_decode($inscrip->nom,ENT_QUOTES);
        $data['prenom']= $inscrip->prenom;
        $data['tel']= $inscrip->tel;
        $data['email']= $inscrip->email;
       

        array_push($listeinscription,$data);

        }
        return $listeinscription;
    }

    
    public function ajout_client($idutilisateur,$idtype,$nom,$prenom,$tel,$email,$pwd,$confirmpwd)
    {
  
      $nom= htmlentities($nom,ENT_QUOTES);
      $prenom= htmlentities($prenom,ENT_QUOTES);
      $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
      if($pwd==$confirmpwd){
        $this->db->query("INSERT into client(idutilisateur,idtype,nom,prenom,tel,email,pwd,dateajout) VALUES('$idutilisateur','$idtype','$nom','$prenom','$tel','$email','$pass_hache',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } else{
      return array('status' => 201,'message' => 'Mot de passe incorrect.');
  }
  
    }


    public function modification_client($idutilisateur,$nom,$prenom,$tel,$email,$pwd,$idtype)
    {

        $this->db->query("UPDATE utilisateur set nom=$nom, prenom=$prenom, tel=$tel, email=$email, pwd=$pwd, idtype=$idtype  where idutilisateur=".$idutilisateur);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    
    public function suppression_client($idutilisateur)
    {
       
        $this->db->query("DELETE FROM utilisateur where idutilisateur=".$idutilisateur);
        return array('status' => 201,'message' => 'Utilisateur supprimé avec succès.');
    }

    
    public function liste_client()
    {
        $listeclient=array();

        $client= $this->db->query("SELECT idutilisateur,nom,prenom,tel,email FROM `utilisateur` where idtype=1")->result();

        foreach($client as $cl){
        $data['idutilisateur']= $cl->idutilisateur;
        $data['nom']= html_entity_decode($cl->nom,ENT_QUOTES);
        $data['prenom']= html_entity_decode($cl->prenom,ENT_QUOTES);
        $data['tel']= $cl->tel;
        $data['email']= $cl->email;

        array_push($listeclient,$data);

        }
        return $listeclient;
    }

    
  

  public function ajout_livreur($idutilisateur,$nom,$prenom,$tel,$email,$pwd)
  {
    $this->load->controller('livraison');
    $nom= htmlentities($nom,ENT_QUOTES);
    $prenom= htmlentities($prenom,ENT_QUOTES);
    $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
    if($this->livraison->ajout_livreur()){
        $idtype=2;
      $this->db->query("INSERT into livreur(idutilisateur,idtype,nom,prenom,tel,email,pwd,dateajout) VALUES('$idutilisateur','$idtype','$nom','$prenom','$tel','$email','$pass_hache',NOW())");
      return array('status' => 201,'message' => 'Data has been created.');
  }  
  }



  public function modification_livreur($idutilisateur,$nom,$prenom,$tel,$email,$pwd,$idtype)
    {

        $this->db->query("UPDATE utilisateur set nom=$nom, prenom=$prenom, tel=$tel, email=$email, pwd=$pwd , idtype=$idtype where idutilisateur=".$idutilisateur);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    
    public function suppression_livreur($idutilisateur)
    {
       
        $this->db->query("DELETE FROM utilisateur where idutilisateur=".$idutilisateur);
        return array('status' => 201,'message' => 'Livreur supprimée avec succès.');
    }

    public function liste_livreur()
    {
        $listelivreur=array();
        
        $livreur= $this->db->query("SELECT idutilisateur,nom,prenom,tel,email FROM `utilisateur` where idtype=2")->result();

        foreach($livreur as $liv){
           
        $data['idutilisateur']= $liv->idutilisateur;
        $data['nom']= html_entity_decode($liv->nom,ENT_QUOTES);
        $data['prenom']= html_entity_decode($liv->prenom,ENT_QUOTES);
        $data['tel']= html_entity_decode($liv->tel,ENT_QUOTES);
        $data['email']= $liv->email ;
        
       
        array_push($listelivreur,$data);

        }
        return $listelivreur;  
    }



    
  
    public function ajout_geolocalisation($longitude,$latitude)
    {
        $date= date("Y-m-d H:i:s");

        $data= array(
            'longitude' =>$longitude,
            'latitude' =>$latitude,
            'dateajout' =>$date
            
        );
    
        $this->db->insert('geolocalisation', $data);
    
        $insert_id = $this->db->insert_id();  
        //var_dump($insert_id);
        return  $insert_id;
        //$this->db->query("INSERT INTO geolocalisation(longitude,latitude,dateajout) values('$longitude','$latitude',NOW())");
        //$this->db->insert('geolocalisation',$data);
        
       // return array('status' => 201,'message' => 'Geolocalisation creer avec succes.');
    }



  public function modification_geolocalisation($idgeo,$longitude,$latitude)
    {

        $this->db->query("UPDATE geolocalisation set longitude=$longitude,latitude=$latitude  where idgeo=".$idgeo);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

//suppression parametre: idgeo
    public function suppression_geolocalisation($idgeo)
    {
       
        $this->db->query("DELETE FROM geolocalisation where idgeo=".$idgeo);
        return array('status' => 201,'message' => 'Geolocalisation supprimée avec succes.');
    }


    public function liste_geolocalisation()
    {
        $listegeolocalisation=array();

        $geolocalisation= $this->db->query("SELECT idgeo,longitude, latitude FROM `geolocalisation`")->result();
        
        foreach($geolocalisation as $geo){
        $data['idgeo']= $geo->idgeo;
        $data['longitude']= $geo->longitude;
        $data['latitude']= $geo->latitude;
       

        array_push($listegeolocalisation,$data);

        }
        return $listegeolocalisation;
    }
 



  //ajout des produits
  public function ajout_commande($idutilisateur,$latitude,$longitude,$nomdestinataire,$prenomdestinataire,$adressedestinataire,$teldestinataire,$note,$typepaiement)
  {

    $nomdestinataire= htmlentities($nomdestinataire,ENT_QUOTES);
    $prenomdestinataire= htmlentities($prenomdestinataire,ENT_QUOTES);
    $note= htmlentities($note,ENT_QUOTES);
      $this->db->query("INSERT into commande(idutilisateur,latitude,longitude,nomdestinataire,prenomdestinataire,adressedestinataire,teldestinataire,note,typepaiement,dateajout) VALUES('$idutilisateur','$latitude','$longitude','$nomdestinataire','$prenomdestinataire','$adressedestinataire','$teldestinataire','$note','$typepaiement',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  } 

  public function update_commande($idcommande,$idutilisateur,$latitude,$longitude,$nomdestinataire,$prenomdestinataire,$adresse,$teldestinataire,$note,$typepaiement)
  {
      
      $requete=$this->db->query("UPDATE commande set idutilisateur=$idutilisateur,latitude=$latitude,longitude=$longitude,nomdestinataire=$nomdestinataire,prenomdestinataire=$prenomdestinataire,adressedestinataire=$adressedestinataire,teldestinataire=$teldestinataire,note=$note,typepaiement=$typepaiement where idcommande=".$idcommande."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_commande($idcommande)
    {
        $this->db->query("DELETE  From commande WHERE idcommande=".$idcommande);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_commande()
    {
        $listecommande=array();

        $commande= $this->db->query("SELECT idcommande,c.idutilisateur,nom,prenom,latitude,longitude,nomdestinataire,prenomdestinataire,adressedestinataire,teldestinataire,note,t.libelle as libelle FROM `commande` c,`typepaiement` t,`utilisateur` u where c.typepaiement=t.idpaiement and c.idutilisateur=u.idutilisateur ")->result();

        foreach($commande as $com){
        $data['idcommande']= $com->idcommande;
        $data['idutilisateur']= $com->idutilisateur;
        $data['nom']= $com->nom;
        $data['prenom']= $com->prenom;
        $data['latitude']= $com->latitude;
        $data['longitude']= $com->longitude;
        $data['nomdestinataire']=html_entity_decode($com->nomdestinataire,ENT_QUOTES);
        $data['prenomdestinataire']=html_entity_decode($com->prenomdestinataire,ENT_QUOTES);
        $data['adressedestinataire']=$com->adressedestinataire;
        $data['teldestinataire']= $com->teldestinataire;
        $data['note']=html_entity_decode($com->note,ENT_QUOTES);
        $data['libelle']= html_entity_decode($com->libelle,ENT_QUOTES);
       

        array_push($listecommande,$data);

        }
        return $listecommande;
    }
   
    
    public function ajout_typepaiement($libelle)
    {
  
      $libelle= htmlentities($libelle,ENT_QUOTES);

        $this->db->query("INSERT into typepaiement(libelle,dateajout) VALUES('$libelle',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 

    public function update_typepaiement($idpaiement,$libelle)
    {
        
        $requete=$this->db->query("UPDATE typepaiement set libelle=$libelle where idpaiement=".$idpaiement);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function delete_typepaiement($idpaiement)
    {
        $this->db->query("DELETE  From typepaiement WHERE idpaiement=".$idpaiement);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function liste_typepaiement()
    {
        $listetypepaiement=array();

        $typepaiement= $this->db->query("SELECT idpaiement, libelle FROM `typepaiement` ")->result();

        foreach($typepaiement as $paiement){
        $data['idpaiement']= $paiement->idpaiement;
        
        $data['libelle']=html_entity_decode($paiement->libelle,ENT_QUOTES);
     
        array_push($listetypepaiement,$data);

        }
        return $listetypepaiement;
    }

    public function ajout_course($idutilisateur,$adressedepart,$adressearrive,$datelivraison,$prix)
    {
       
        $this->db->query("INSERT into course(idutilisateur,adressedepart,adressearrive,datelivraison,prix,dateajout) VALUES('$idutilisateur','$adressedepart','$adressearrive','$datelivraison','$prix',NOW())");

        $solde=$this->calcul_montant($idutilisateur);
        $requete=$this->db->query("UPDATE course set solde=$solde where idutilisateur=".$idutilisateur." and dateajout=CURRENT_DATE()");
        
        return array('status' => 201,'message' => 'Data has been created.');
    } 

    public function update_course($idcourse,$idutilisateur,$adressedepart,$adressearrive,$datelivraison,$prix)
    {
        
        $requete=$this->db->query("UPDATE course set idutilisateur=$idutilisateur,adressedepart=$adressedepart,adressearrive=$adressearrive,datelivraison=$datelivraison,prix=$prix where idcourse=".$idcourse);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function delete_course($idcourse)
    {
        $this->db->query("DELETE  From course WHERE idcourse=".$idcourse);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function liste_course()
    {
        $listecourse=array();

        $course= $this->db->query("SELECT idcourse,c.idutilisateur,nom,prenom,adressedepart,adressearrive,datelivraison,prix  FROM `course` c , `utilisateur` u where c.idutilisateur=u.idutilisateur ")->result();

        foreach($course as $cou){
        $data['idcourse']= $cou->idcourse;
        $data['idutilisateur']= $cou->idutilisateur;
        $data['nom']= $cou->nom;
        $data['prenom']= $cou->prenom;
        $data['adressedepart']= $cou->adressedepart;
        $data['adressearrive']= $cou->adressearrive;
        $data['datelivraison']= $cou->datelivraison;
        $data['prix']=$cou->prix;
        
     
        array_push($listecourse,$data);

        }
        return $listecourse;
    }


    public function liste_courselivreur($idutilisateur)
    {
        $listecourse=array();

        $course= $this->db->query("SELECT distinct solde,idcourse,idutilisateur,adressedepart,adressearrive,datelivraison,prix,dateajout FROM `course` where idutilisateur= ".$idutilisateur)->result();

        foreach($course as $cou){
        $data['idcourse']= $cou->idcourse;
        $data['idutilisateur']= $cou->idutilisateur;
        $data['adressedepart']= $cou->adressedepart;
        $data['adressearrive']= $cou->adressearrive;
        $data['datelivraison']= $cou->datelivraison;
        $data['prix']=$cou->prix;
        $data['solde']=$cou->solde;
        $data['dateajout']=$cou->dateajout;
     
        array_push($listecourse,$data);

        }
        return $listecourse;
    }

    public function ajout_contact($idutilisateur,$objet,$message1)
    {
        $objet= htmlentities($objet,ENT_QUOTES);
        $message1= htmlentities($message1,ENT_QUOTES);
        $this->db->query("INSERT into contact(idutilisateur,objet,message1,dateajout) VALUES('$idutilisateur','$objet','$message1',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 

    public function update_contactclient($idcontact,$idutilisateur,$objet,$message)
    {
        
        $requete=$this->db->query("UPDATE contact set idutilisateur='$idutilisateur',objet='$objet',message1='$message1' where idcontact=".$idcontact);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function delete_contact($idcontact)
    {
        $this->db->query("DELETE  From contact WHERE idcontact=".$idcontact);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function liste_contact()
    {
        $listecontact=array();

        $contact= $this->db->query("SELECT idcontact,c.idutilisateur as idutilisateur,nom,prenom,objet,message1,reponse FROM `contact` c,`utilisateur` u where c.idutilisateur=u.idutilisateur ")->result();

        foreach($contact as $cont){
        $data['idcontact']= $cont->idcontact;
        $data['idutilisateur']= $cont->idutilisateur;
        $data['nom']= $cont->nom;
        $data['prenom']= $cont->prenom;
        $data['objet']= html_entity_decode($cont->objet,ENT_QUOTES);
        $data['message1']= html_entity_decode($cont->message1,ENT_QUOTES);
        $data['reponse']= html_entity_decode($cont->reponse,ENT_QUOTES);
        
        array_push($listecontact,$data);

        }
        return $listecontact;
    }

    public function info_message($idcontact)
    {
        $listeinfo=array();

        $info= $this->db->query("SELECT c.idutilisateur as idutilisateur,nom,prenom,objet,message1,reponse FROM `contact` c,`utilisateur` u where c.idutilisateur=u.idutilisateur and idcontact=$idcontact ")->result();

        foreach($info as $cont){
        
        $data['idutilisateur']= $cont->idutilisateur;
        $data['nom']= $cont->nom;
        $data['prenom']= $cont->prenom;
        $data['objet']= html_entity_decode($cont->objet,ENT_QUOTES);
        $data['message1']= html_entity_decode($cont->message1,ENT_QUOTES);
        $data['reponse']= html_entity_decode($cont->reponse,ENT_QUOTES);
        
        array_push($listeinfo,$data);

        }
        return $listeinfo;
    }


    public function ajout_contactlivreur($idlivreur,$objet,$message1)
    {
        $objet= htmlentities($objet,ENT_QUOTES);
        $message1= htmlentities($message1,ENT_QUOTES);
        $this->db->query("INSERT into contactlivreur(idlivreur,objet,message1,dateajout) VALUES('$idlivreur','$objet','$message1',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 
    

    public function update_contactlivreur($idcontact,$idlivreur,$objet,$message)
    {
        
        $requete=$this->db->query("UPDATE contactlivreur set idlivreur='$idlivreur',objet='$objet',message1='$message1' where idcontact=".$idcontact);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function delete_contactlivreur($idcontact)
    {
        $this->db->query("DELETE  From contactlivreur WHERE idcontact=".$idcontact);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function liste_contactlivreur()
    {
        $listecontact=array();

        $contact= $this->db->query("SELECT idcontact,idlivreur,objet,message1 FROM `contactlivreur` ")->result();

        foreach($contact as $cont){
        $data['idcontact']= $cont->idcontact;
        $data['idlivreur']= $cont->idlivreur;
        $data['objet']= html_entity_decode($cont->objet,ENT_QUOTES);
        $data['message1']= html_entity_decode($cont->message1,ENT_QUOTES);
        
        array_push($listecontact,$data);

        }
        return $listecontact;
    }
    


    public function ajout_typeclient($libelle)
    {
        $libelle= htmlentities($libelle,ENT_QUOTES);
       
        $this->db->query("INSERT into typeclient(libelle,dateajout) VALUES('$libelle',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 

    public function update_typeclient($idtype,$libelle)
    {
        
        $requete=$this->db->query("UPDATE typeclient set libelle='$libelle' where idtype=".$idtype);
        
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function delete_typeclient($idtype)
    {
        $this->db->query("DELETE  From typeclient WHERE idtype=".$idtype);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_typeclient()
    {
        $listetypeclient=array();

        $typeclient= $this->db->query("SELECT idtype,libelle FROM `typeclient` ")->result();

        foreach($typeclient as $type){
        $data['idtype']= $type->idtype;
        $data['libelle']= html_entity_decode($type->libelle,ENT_QUOTES);
       
        array_push($listetypeclient,$data);

        }
        return $listetypeclient;
    }


    public function calcul_montant($idutilisateur)
    {
        
        $solde= $this->db->query("SELECT sum(prix) as prix FROM `course` where idutilisateur=".$idutilisateur." and dateajout=CURRENT_DATE()")->row();
       
        return $solde->prix;
    } 

    public function ajout_reponse($idcontact,$reponse)

    {
        $rep=$this->db->query("SELECT message1,reponse,dateajout FROM `contact` where idcontact= ".$idcontact)->row();

        $reponse= htmlentities($reponse,ENT_QUOTES);
        $requete=$this->db->query("UPDATE contact set reponse='$reponse' where idcontact=".$idcontact);

        return array('status' => 201,'message' => 'Data has been created.');

    } 

//fonction d'affichage de reponse coté mobile

public function affiche_reponse($idutilisateur)

    {

        $affichereponse=array();
        
        $reponse=$this->db->query("SELECT idcontact,message1,reponse,dateajout FROM `contact` where idutilisateur= ".$idutilisateur)->result();

        foreach($reponse as $rep){
            $data['idcontact']= $rep->idcontact;
            $data['message1']= html_entity_decode($rep->message1,ENT_QUOTES);
            $data['reponse']= html_entity_decode($rep->reponse,ENT_QUOTES);
            $data['dateajout']=$rep->dateajout;

            array_push($affichereponse,$data);

            }
            return $affichereponse;
    } 
}
