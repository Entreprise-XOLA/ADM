<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ecommerce extends CI_Model {

    var $client_service = "Ecommerce-client";
    var $auth_key       = "api_gestion_ecommerce";

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
 
        
        $q  = $this->db->query("SELECT IDUTILISATEUR as id_utilisateur , nom,email , pwd FROM  utilisateur  WHERE  email ='".$email."' ;")->row();
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
    public function ajout_inscription($idrole,$nom,$email,$pwd,$confirmpwd)
    {
       $nom= htmlentities($nom,ENT_QUOTES);
        $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
        $pass_hache1 = password_hash($confirmpwd, PASSWORD_DEFAULT);
        
        if($pwd==$confirmpwd){
            $this->db->query("INSERT into utilisateur(idrole,nom,email,pwd,confirmpwd,dateajout) VALUES('$idrole','$nom','$email','$pass_hache','$pass_hache1',NOW())");        
            return array('status' => 201,'message' => 'Inscription fait avec succes.');
        }else{
            return array('status' => 201,'message' => 'Mot de passe incorrect.');
        }
       
        
    }


    public function modification_inscription($idutilisateur,$idrole,$nom,$email,$pwd)
    {

        $this->db->query("UPDATE utilisateur set idrole=$idrole, nom=$nom, email=$email, pwd=$pwd  where idutilisateur=".$idutilisateur);
       
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
       
        $inscription= $this->db->query("SELECT idutilisateur,nom,email FROM `utilisateur`")->result();

        foreach($inscription as $inscrip){
        $data['idutilisateur']= $inscrip->idutilisateur;
        $data['nom']= html_entity_decode($inscrip->nom,ENT_QUOTES);
        $data['email']= $inscrip->email;
       

        array_push($listeinscription,$data);

        }
        return $listeinscription;
    }

    

    
  //ajout des categories(boisson,farine,legumes...)

  public function ajout_categorie($idutilisateur,$libelle)
  {

    $libelle= htmlentities($libelle,ENT_QUOTES);
      $this->db->query("INSERT into categorie(idutilisateur,libelle,dateajout) VALUES('$idutilisateur','$libelle',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  }  


  public function modification_categorie($idcat,$idutilisateur,$libelle)
    {

        $this->db->query("UPDATE categorie set idutilisateur=$idutilisateur, libelle=$libelle  where idcat=".$idcat);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    
    public function suppression_categorie($idcat)
    {
       
        $this->db->query("DELETE FROM categorie where idcat=".$idcategorie);
        return array('status' => 201,'message' => 'Categorie supprimée avec succès.');
    }

    public function liste_categorie()
    {
        $listecategorie=array();
        
        $categorie= $this->db->query("SELECT idutilisateur,libelle FROM `categorie`")->result();

        foreach($categorie as $cl){
        $data['idutilisateur']= $cl->idutilisateur;
        $data['libelle']= html_entity_decode($cl->libelle,ENT_QUOTES);
        
       
        array_push($listecategorie,$data);

        }
        return $listecategorie;  
    }


//ajout des clients
public function ajout_client($nom,$email,$pwd,$confirmpwd)
{
    $nom= htmlentities($nom,ENT_QUOTES);
    $pass_hache = password_hash($pwd, PASSWORD_DEFAULT);
    $pass_hache1 = password_hash($confirmpwd, PASSWORD_DEFAULT);
    if($pwd==$confirmpwd){
        $this->db->query("INSERT into client(nom,email,pwd,dateajout) VALUES('$nom','$email','$pass_hache','$pass_hache1',NOW())");
        return array('status' => 201,'message' => 'Inscription fait avec succes.');
    }else{
        return array('status' => 201,'message' => 'Mot de passe incorrect.');
    }
    
    
    
}

public function modification_client($idclient,$nom,$email,$pwd)
    {

        $this->db->query("UPDATE client set nom=$nom, email=$email, pwd=$pwd  where idclient=".$idclient);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    
    public function suppression_client($idclient)
    {
       
        $this->db->query("DELETE FROM client where idclient=".$idclient);
        return array('status' => 201,'message' => 'Client supprimé avec succes.');
    }


    public function liste_client()
    {
        $listeclient=array();
        
        $client= $this->db->query("SELECT idclient,nom,email FROM `client`")->result();

        foreach($client as $cl){
        $data['idclient']= $cl->idclient;
        $data['nom']= html_entity_decode($cl->nom,ENT_QUOTES);
        $data['email']= $cl->email;
       

        array_push($listeclient,$data);

        }
        return $listeclient;
    }
  
  
  //ajout des sous categorie(boisson alcolisée,non alcolisé...)
  public function ajout_souscategorie($idcat,$idutilisateur,$libelle)
  {

    $libelle= htmlentities($libelle,ENT_QUOTES);
      $this->db->query("INSERT into souscategorie(idcat,idutilisateur,libelle,dateajout) VALUES('$idcat','$idutilisateur','$libelle',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  } 


  public function modification_souscategorie($idsouscat,$idcat,$idutilisateur,$libelle)
    {

        $this->db->query("UPDATE souscategorie set idcat=$idcat, idutilisateur=$idutilisateur, libelle=$libelle  where idsouscat=".$idsouscat);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    
    public function suppression_souscategorie($idsouscat)
    {
       
        $this->db->query("DELETE FROM souscategorie where idsouscat=".$idsouscat);
        return array('status' => 201,'message' => 'Sous categorie supprimé avec succès.');
    }

    public function liste_souscategorie()
    {
        $listesouscategorie=array();

        $souscategorie= $this->db->query("SELECT idsouscat,idcat,idutilisateur,libelle FROM `souscategorie`")->result();

        foreach($souscategorie as $souscat){
        $data['idsouscat']= $souscat->idsouscat;
        $data['idcat']= $souscat->idcat;
        $data['idutilisateur']= $souscat->idutilisateur;
        $data['libelle']= html_entity_decode($souscat->libelle,ENT_QUOTES);
       

        array_push($listesouscategorie,$data);

        }
        return $listesouscategorie;
    }

    
  //ajout des video
  public function ajout_video($idutilisateur,$libelle,$chemin,$datafichier)
  {
    $dateajout= date("Y-m-d H:i:s");

    $data= array(
        'idutilisateur' =>$idutilisateur,
        'libelle' =>$libelle,
        'chemin' =>$chemin,
        'datafichier' =>$datafichier,
        'dateajout' => $dateajout
        
    );
    $this->db->insert('video', $data);

    $insert_id = $this->db->insert_id();  
    //var_dump($insert_id);
    return  $insert_id;
    //$libelle= htmlentities($libelle,ENT_QUOTES);
      //$this->db->query("INSERT into video(idutilisateur,libelle,dateajout) VALUES('$idutilisateur','$libelle',NOW())");
     
      //return array('status' => 201,'message' => 'Data has been created.');
  } 
   

  public function update_video($idvideo,$idutilisateur,$libelle,$chemin,$datafichier)
  {
      
      $requete=$this->db->query("UPDATE video set idutilisateur='$idutilisateur',libelle='$libelle',chemin='$chemin',datafichier='$datafichier' where idvideo=".$idvideo."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_video($idvideo)
    {
        $this->db->query("DELETE  From video WHERE idvideo=".$idvideo);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }

    public function liste_video()
    {
        $listevideo=array();

        $video= $this->db->query("SELECT idvideo,idutilisateur,libelle FROM `video`")->result();

        foreach($video as $vid){
        $data['idvideo']= $vid->idvideo;
        $data['idutilisateur']= $vid->idutilisateur;
        $data['libelle']= html_entity_decode($vid->libelle,ENT_QUOTES);
       

        array_push($listevideo,$data);

        }
        return $listevideo;
    }


  //ajout des info(à propos de nous)
  public function ajout_info($idutilisateur,$texte)
  {

    $texte= htmlentities($texte,ENT_QUOTES);
      $this->db->query("INSERT into info(idutilisateur,texte,dateajout) VALUES('$idutilisateur','$texte',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  } 


  public function update_info($idinfo,$idutilisateur,$texte)
  {
      
      $requete=$this->db->query("UPDATE info set idutilisateur='$idutilisateur',texte='$texte' where idinfo=".$idinfo."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_info($idinfo)
    {
        $this->db->query("DELETE  From info WHERE idinfo=".$idinfo);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_info()
    {
        $listeinfo=array();

        $info= $this->db->query("SELECT idinfo,idutilisateur,texte FROM `info`")->result();

        foreach($info as $inf){
        $data['idinfo']= $inf->idinfo;
        $data['idutilisateur']= $inf->idutilisateur;
        $data['texte']=html_entity_decode($inf->texte,ENT_QUOTES);
       

        array_push($listeinfo,$data);

        }
        return $listeinfo;
    }




  //ajout des produits
  public function ajout_produit($idsouscat,$idutilisateur,$idimage,$libelle,$prix,$poids)
  {

    $libelle= htmlentities($libelle,ENT_QUOTES);
      $this->db->query("INSERT into produit(idsouscat,idutilisateur,idimage,libelle,prix,poids,dateajout) VALUES('$idsouscat','$idutilisateur','$idimage','$libelle','$prix','$poids',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  } 

  public function update_produit($idproduit,$idsouscat,$idutilisateur,$libelle,$prix,$poids)
  {
      
      $requete=$this->db->query("UPDATE produit set idsouscat='$idsouscat',idutilisateur='$idutilisateur',libelle='$libelle',prix='$prix',poids='$poids' where idproduit=".$idproduit."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_produit($idproduit)
    {
        $this->db->query("DELETE  From produit WHERE idproduit=".$idproduit);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_produit()
    {
        $listeproduit=array();

        $produit= $this->db->query("SELECT idproduit,idsouscat,idutilisateur,libelle,prix,poids FROM `produit`")->result();

        foreach($produit as $prod){
        $data['idproduit']= $prod->idproduit;
        $data['idsouscat']= $prod->idsouscat;
        $data['idutilisateur']= $prod->idutilisateur;
        $data['libelle']=html_entity_decode($prod->libelle,ENT_QUOTES);
        $data['prix']= $prod->prix;
        $data['poids']= $prod->poids;
       

        array_push($listeproduit,$data);

        }
        return $listeproduit;
    }
   
    
    public function ajout_panier($idclient,$libelle,$statupanier)
  {

    $libelle= htmlentities($libelle,ENT_QUOTES);
      $this->db->query("INSERT into panier(idclient,libelle,statupanier,dateajout) VALUES('$idclient','$libelle','$statupanier',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function update_panier($idpanier,$idclient,$libelle,$statupanier)
  {
      
      $requete=$this->db->query("UPDATE panier set idclient='$idclient',libelle='$libelle',statupanier='$statupanier' where idpanier=".$idpanier."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_panier($idpanier)
    {
        $this->db->query("DELETE  From panier WHERE idpanier=".$idpanier);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_panier()
    {
        $listepanier=array();

        $panier= $this->db->query("SELECT idpanier,idclient,libelle,statupanier FROM `panier`")->result();

        foreach($panier as $pan){
        $data['idpanier']= $pan->idpanier;
        $data['idclient']= $pan->idclient;
        $data['libelle']= html_entity_decode($pan->libelle,ENT_QUOTES);
        $data['statupanier']= $pan->statupanier;

        array_push($listepanier,$data);

        }
        return $listepanier;
    }
    

    //ajout des images

    public function ajout_image($idutilisateur,$nom,$chemin,$datafichier)
    {
        $dateajout= date("Y-m-d H:i:s");
       // $code="TG-".rand_string(2)."-".rand_string(2);
    $data= array(
        'idutilisateur' =>$idutilisateur,
        'nom' =>$nom,
        'chemin' =>$chemin,
        'datafichier' =>$datafichier,
        'dateajout' => $dateajout
        
    );

    $this->db->insert('image', $data);

    $insert_id = $this->db->insert_id();  
    //var_dump($insert_id);
    return  $insert_id;

        //$this->db->query("INSERT into fichier(chemin,datafichier,date,libelle) VALUES('$chemin','$datafichier',NOW(),'$libelle')");
        //$fichier= $this->db->query("SELECT idfichier FROM `fichier`")->row();
        //$data['idfichier'];
        
    }

    
    

    public function modification_image($idimage,$idutilisateur,$idproduit,$chemin,$datafichier,$nom)
    {

        $this->db->query("UPDATE `image` set idutilisateur=$idutilisateur,idproduit=$idproduit,chemin=$chemin,datafichier=$datafichier,nom=$nom  where idimage=".$image);
       
        return array('status' => 201,'message' => 'Modification avec succes.');
    }

    

    public function suppression_image($idimage)
    {
       
        $this->db->query("DELETE FROM `image` where idimage=".$idimage);
        return array('status' => 201,'message' => 'Fichier supprimée avec succes.');
    }


    public function liste_image()
    {
        $listeimage=array();

        $image= $this->db->query("SELECT idimage,nom FROM `image`")->result();

        foreach($image as $im){
        $data['idimage']= $im->idimage;
        $data['nom']= html_entity_decode($im->nom,ENT_QUOTES);
        
        

        array_push($listeimage,$data);

        }
        return $listeimage;
    }



    public function ajout_comment($nom,$texte)
  {
    $nom= htmlentities($nom,ENT_QUOTES);
    $texte= htmlentities($texte,ENT_QUOTES);
      $this->db->query("INSERT into commentaire(nom,texte,dateajout) VALUES('$nom','$texte',NOW())");
     
      return array('status' => 201,'message' => 'Data has been created.');
  } 

  public function update_comment($idcommentaire,$nom,$texte)
  {
      
      $requete=$this->db->query("UPDATE commentaire set nom='$nom',texte='$texte' where idcommentaire=".$idcommentaire."'");
      
      return array('status' => 201,'message' => 'Data has been created.');
  }

  public function delete_comment($idcommentaire)
    {
        $this->db->query("DELETE  From commentaire WHERE idcommentaire=".$idcommentaire);
       
        return array('status' => 201,'message' => 'Data has been deleted.');
    }


    public function liste_comment()
    {
        $listecomment=array();

        $comment= $this->db->query("SELECT idcommentaire,nom,texte FROM `commentaire`")->result();

        foreach($comment as $com){
        $data['idcommentaire']= $com->idcommentaire;
        $data['nom']= html_entity_decode($com->nom,ENT_QUOTES);
        $data['texte']= html_entity_decode($com->texte,ENT_QUOTES);
        

        array_push($listecomment,$data);

        }
        return $listecomment;
    }


    public function ajout_commande($idclient,$montanttotal,$statucommande)
    {
        $this->db->query("INSERT into commande(idclient,montanttotal,statucommande,dateajout) VALUES('$idclient','$montanttotal','$statucommande',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 
  
    public function update_commande($idcommande,$idclient,$montanttotal,$statucommande)
    {
        
        $requete=$this->db->query("UPDATE commande set idclient='$idclient',montanttotal='$montanttotal',statucommande='$statucommande' where idcommande=".$idcommande."'");
        
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
  
          $commande= $this->db->query("SELECT idcommande,idclient,montanttotal,statucommande FROM `commande`")->result();
  
          foreach($commande as $com){
          $data['idcommande']= $com->idcommande;
          $data['idclient']= $com->idclient;
          $data['montanttotal']= $com->montanttotal;
          $data['statucommande']= $com->statucommande;
          
  
          array_push($listecommande,$data);
  
          }
          return $listecommande;
      }

    public function ajout_produitcommande($idproduit,$idcommande,$montant,$montanttotal,$remise)
    {
        $this->db->query("INSERT into produitcommande(idproduit,idcommande,montant,montanttotal,remise,dateajout) VALUES('$idproduit','$idcommande','$montant','$montanttotal','$remise',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 
  
    public function update_produitcommande($idproduitcommande,$idproduit,$idcommande,$montant,$montanttotal,$remise)
    {
        
        $requete=$this->db->query("UPDATE produitcommande set idproduit='$idproduit',idcommande='$idcommande',montant='$montant',montanttotal='$montanttotal',remise='$remise' where idproduitcommande=".$idproduitcommande."'");
        
        return array('status' => 201,'message' => 'Data has been created.');
    }
  
    public function delete_produitcommande($idproduitcommande)
      {
          $this->db->query("DELETE  From produit WHERE idproduit=".$idproduitcommande);
         
          return array('status' => 201,'message' => 'Data has been deleted.');
      }


      public function liste_produitcommande()
    {
        $listeproduitcommande=array();

        $produitcommande= $this->db->query("SELECT idproduitcommande,idproduit,idcommande,montant,montanttotal,remise FROM `produitcommande`")->result();

        foreach($produitcommande as $produitcomm){
            $data['idproduitcommande']= $produitcomm->idproduitcommande;
        $data['idproduit']= $produitcomm->idproduit;
        $data['idcommande']= $produitcomm->idcommande;
        $data['montant']= $produitcomm->montant;
        $data['montanttotal']= $produitcomm->montanttotal;
        $data['remise']= $produitcomm->remise;
        
        

        array_push($listeproduitcommande,$data);

        }
        return $listeproduitcommande;
    }

    public function ajout_produitpanier($idproduit,$idpanier,$montant,$montanttotal,$remise)
    {
        $this->db->query("INSERT into produitpanier(idproduit,idpanier,montant,montanttotal,remise,dateajout) VALUES('$idproduit','$idpanier','$montant','$montanttotal','$remise',NOW())");
       
        return array('status' => 201,'message' => 'Data has been created.');
    } 
  
    public function update_produitpanier($idproduitpanier,$idproduit,$idpanier,$montant,$montanttotal,$remise)
    {
        
        $requete=$this->db->query("UPDATE produitpanier set idproduit='$idproduit',idpanier='$idpanier',montant='$montant',montanttotal='$montanttotal',remise='$remise' where idproduitpanier=".$idproduitpanier."'");
        
        return array('status' => 201,'message' => 'Data has been created.');
    }
  
    public function delete_produitpanier($idproduitpanier)
      {
          $this->db->query("DELETE  From produitpanier WHERE idproduitpanier=".$idproduitpanier);
         
          return array('status' => 201,'message' => 'Data has been deleted.');
      }


      public function liste_produitpanier()
    {
        $listeproduitpanier=array();

        $produitpanier= $this->db->query("SELECT idproduitcommande,idproduit,idpanier,montant,montanttotal,remise FROM `produitpanier`")->result();

        foreach($produitpanier as $produitpan){
            $data['idproduitpanier']= $produitpan->idproduitpanier;
        $data['idproduit']= $produitpan->idproduit; 
        $data['idpanier']= $produitpan->idpanier;
        $data['montant']= $produitpan->montant;
        $data['montanttotal']= $produitpan->montanttotal;
        $data['remise']= $produitpan->remise;
        
        

        array_push($listeproduitpanier,$data);

        }
        return $listeproduitpanier;
    }

    
}
