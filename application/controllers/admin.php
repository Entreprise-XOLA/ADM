<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

   
    
    public function __construct() {

      
        parent::__construct();
        //$this->output->enable_profiler(TRUE);

    }

    function factureinfo($idfacturetemp){
        //echo $idrecu;
        //permet d'afficher sur la vue
        $recup = $this->db->query("SELECT idfacturetemp,numfacture,numfacture2,nom,reduction,nif,adresse,bp,telephone,email,declaration,concerne,bureaudest,poidbrut,poidnet,dateajout FROM `facturetemp`  where idfacturetemp=".$idfacturetemp." ")->row();
        return $recup;
         
        // $recup1 = $this->db->query("SELECT idcycle,idclasse,libelleclasse FROM `classe` where idcycle=".$dat)->row();

          //return $this->load->view("print/recette",$dat);
       
        }

       

   

function facture($idfacturetemp){
		
		
		$this->load->library("Numbertowords");
		$this->load->model('model_gestionfacture');
        $data['info_facture'] = $this->factureinfo($idfacturetemp);
		$tit = uniqid();
		 $this->load->view("print/facture",$data,true);
		
	}


    function facture2($idfacturetemp){
	$tit = uniqid();
    
    $facture= $this->facture($idfacturetemp);

    //var_dump($facture);
    $alpha=$this->load->view("print/facture",$facture,true);
   $this->load->library("Numbertowords");

    $this->load->library('html2pdf');
    $this->html2pdf->folder('./assets/documents/');
    $nomfichier = $tit.".pdf";
    $this->html2pdf->filename($nomfichier);
   $this->html2pdf->paper('a4', 'portrait');
    
    $this->html2pdf->html($alpha);
    
    $this->html2pdf->create('save');
   
    $this->load->helper('download');

	force_download('./assets/documents/'.$nomfichier, NULL);
	
}



}