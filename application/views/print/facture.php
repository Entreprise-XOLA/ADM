<meta charset="UTF-8">
<div>
<div>

<img src="<?php  echo base_url('assets/images/en-tête.png') ; ?>" style="background-position:center; background-repeat: no-repeat; margin-top:-39px;" height="100%" width="100%">  
<div style="margin-left:380px;"> 

<table width="230" border ="1" cellspacing="1" cellpadding="1">
  <tr>
  <td><strong style="font-size:13px;">CLIENT: <?php echo  $info_facture->nom; ?></strong><br>

  </td>
</tr>
</table>
</div>

<div style="margin-top:-200px;">
<table width="230" border ="1" cellspacing="1" cellpadding="1">
  <tr>
  <td><strong style="font-size:13px;">Régime: <?php echo  $info_facture->declaration; ?></strong><br>
  <strong style="font-size:13px;">Concerne: <?php echo  $info_facture->concerne; ?></strong><br>
  <strong style="font-size:13px;">Destination: <?php echo  $info_facture->bureaudest; ?></strong><br>
  <strong style="font-size:13px;">Poids brut: <?php echo  $info_facture->poidbrut; ?></strong><br>
  <strong style="font-size:13px;">Poids net: <?php echo  $info_facture->poidnet; ?></strong><br>
  </td>
  

</tr></table> <div style="margin-left:500px;">
<div class="col-1" style="border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;height:-5%;margin-top:-100px; margin-right: 60px;">
<div style="margin-top:-30px; margin-left:10px;">VIGNETTE TVA</div>
</div>
</div>
</div>

<div style="margin-left:490px; margin-bottom: 15px;">

  
<strong style="font-size:13px;"> Lomé,le <?php echo $info_facture->dateajout ; ?> </strong>
  

  </div>

<div style="text-align:center">

  
<strong style="font-size:13px;margin-right:170px">FACTURE N° : <?php echo  $info_facture->numfacture; ?></strong>
  
N°_<?php echo  $info_facture->numfacture2; ?>
  </div>

<table style="border-collapse:collapse;
 width:20%;">
 
   <thead>
   <tr>
      
   <th style="border:1px solid black;background-color:#62bfe8;font-size:12px;font-weight:600;width:20%;">
      REF
   </th>
   <th style="border:1px solid black;width:400px;background-color:#62bfe8;font-size:12px;font-weight:600;">
      DESIGNATION
	  
   </th>

   <th style="border:1px solid black; background-color:#62bfe8;font-size:12px;font-weight:600;width:20%; margin: 2px;">
    QUANTITE
   </th>
   
   <th style="border:1px solid black;background-color:#62bfe8;font-size:12px;font-weight:600;width:120px; margin: 2px;">
      PRIX UNITAIRE HT
   </th>
   <th style="border:1px solid black; background-color:#62bfe8;font-size:12px;font-weight:600;width:70px; margin: 2px;">
     TOTAL HT
   </th>
   
   </tr>
   
   </thead>

   <tbody>
   
   <tr >
       <td style="border-left:1px solid black;font-size:13px;font-weight:600;"></td>
 
 <td style="text-align:right;font-size:13px;font-weight:600;"> <strong>DEBOURS</strong> </td>
 <td style="">  </td>
 <td style="">  </td>
 <td style="border-right:1px solid black;">  </td>
 
 
       
   </tr>
   <tr >
       <td style="border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"> </td>
 
 <td style="border-top:1px solid black;border-bottom:1px solid black;"><strong style="font-size:13px;"> FRAIS DE DOUANE </strong></td>
 <td style="border:1px solid black;"> </td>
 <td style="border:1px solid black;"> </td>
 <td style="border:1px solid black;">  </td>
 
 
       
   </tr>
   <?php

$liste_fraisdouane= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=1 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$info_facture->idfacturetemp." ")->result();

$liste_autredebours= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=2 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$info_facture->idfacturetemp." ")->result();
  
$liste_honoraire= $this->db->query("SELECT f.id_detailfacturetemp as id_detailfacturetemp, d.designation as designation FROM `factdetailtemp` f ,`detailfacturetemp` d,`facturetemp` ft WHERE d.idtypeprest=3 and f.id_detailfacturetemp=d.id_detailfacturetemp and f.idfacturetemp=ft.idfacturetemp and f.idfacturetemp=".$info_facture->idfacturetemp." ")->result();
$sommefraisdouane=0;
$sommeautredebours=0;
$sommehonoraire=0;
$sommedebours1=0;
$sommedebours2=0;
$sommedebours=0;
$i=1;
$f=1;
$g=1;
  //    var_dump($liste_fraisdouane)  ;
foreach($liste_fraisdouane as $info_fraisdouane){

  $j=$i++;
  $sommefraisdouane=$sommefraisdouane+$this->model_gestionfacture->total_fraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp);
  
  $sommedebours1=$sommedebours1+$this->model_gestionfacture->total_fraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp);
       
  
  //var_dump($somme);
 // var_dump($info_fraisdouane->id_detailfacturetemp);
   echo 
   '<tr >
       <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$j.'</td>
 
 <td style="border-top:1px solid black;border-bottom:1px solid black;font-size:13px;"> '.$this->model_gestionfacture->info_fraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp).' </td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->info_quantitefraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp).' </td>
 <td style="border:1px solid black;font-size:13px;text-align: center;"> '.$this->model_gestionfacture->info_prixunitairefraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp).'</td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->totalht_fraisdouane($info_facture->idfacturetemp,$info_fraisdouane->id_detailfacturetemp).' </td>
 
 
       
   </tr>
   ';
   
  }
  
  echo

   '<tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"><strong style="font-size:13px;"> TOTAL FRAIS DE DOUANE </strong></td>
 <td style="">  </td>
 <td style="">  </td>
 <td style="border-right:1px solid black;border-left:1px solid black;font-size:13px; text-align: center;"> '.$sommefraisdouane.' </td>
 
 
       
   </tr>'
;
   
    echo
   '<tr >
       <td style="border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"> </td>
 
 <td style="border-top:1px solid black;border-bottom:1px solid black;text-align:left;"> <strong style="font-size:13px;"> AUTRES DEBOURS </strong></td>
 <td style="border:1px solid black;">  </td>
 <td style="border:1px solid black;"> </td>
 <td style="border:1px solid black;">  </td>
 
 
       
   </tr>
   ';
   
  
  foreach($liste_autredebours as $info_autredebours){
    $sommeautredebours=$sommeautredebours+$this->model_gestionfacture->total_autredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp);
    $sommedebours2=$sommedebours2+$this->model_gestionfacture->total_autredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp);
    $k=$f++;
  echo
  '
   <tr >
       <td style="border:1px solid black;font-size:13px; text-align: center;">'.$k.' </td>
 
 <td style="border-top:1px solid black;border-bottom:1px solid black;font-size:13px;"> '.$this->model_gestionfacture->info_autredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp).'</td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->info_quantiteautredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp).' </td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->info_prixunitaireautredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp).'</td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->totalht_autredebours($info_facture->idfacturetemp,$info_autredebours->id_detailfacturetemp).' </td>
 
 
       
   </tr>'
   ;
   
  }
  echo

   '<tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"><strong style="font-size:13px;"> TOTAL  AUTRES DEBOURS </strong></td>
 <td style="">  </td>
 <td style="">  </td>
 <td style="border-right:1px solid black;border-left:1px solid black;font-size:13px; text-align: center;"> '.$sommeautredebours.' </td>
 
 
       
   </tr>'
;
   
    echo
   '<tr >
       <td style="border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"> </td>
 
      <td colspan="3" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;"> <strong style="font-size:13px;"> TOTAL DEBOURS </strong></td>
      <td style="border-right:1px solid black;border-left:1px solid black;font-size:13px; text-align: center;border-top:1px solid black;"> '.($sommedebours2+$sommedebours1).' </td>
 
 
       
   </tr>
   ';
   echo
   
  '<tr >
       <td style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;"></td>
 
 <td style="text-align:right;border-top:1px solid black;border-bottom:1px solid black;"> <strong style="font-size:13px;"> HONORAIRES </strong></td>
 <td style="border-top:1px solid black;border-bottom:1px solid black;">  </td>
 <td style="border-top:1px solid black;border-bottom:1px solid black;">  </td>
 <td style="border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;">  </td>
 
 
       
   </tr>
'
;
   
  
  foreach($liste_honoraire as $info_honoraire){
    $sommehonoraire=$sommehonoraire+$this->model_gestionfacture->total_honoraire($info_facture->idfacturetemp,$info_honoraire->id_detailfacturetemp);
    $l=$g++;
  
    echo
  '
   <tr >
       <td style="border:1px solid black;font-size:13px; text-align: center;">'.$l.' </td>
 
 <td style="border-top:1px solid black;border-bottom:1px solid black;font-size:13px;">'.$this->model_gestionfacture->info_honoraire($info_facture->idfacturetemp,$info_honoraire->id_detailfacturetemp).'  </td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->info_quantitehonoraire($info_facture->idfacturetemp,$info_honoraire->id_detailfacturetemp).' </td>
 <td style="border:1px solid black;font-size:13px; text-align: center;">'.$this->model_gestionfacture->info_prixunitairehonoraire($info_facture->idfacturetemp,$info_honoraire->id_detailfacturetemp).' </td>
 <td style="border:1px solid black;font-size:13px; text-align: center;"> '.$this->model_gestionfacture->totalht_honoraire($info_facture->idfacturetemp,$info_honoraire->id_detailfacturetemp).'  </td>
 
 
       
   </tr>'
   ;
   
  }
  $x=$sommehonoraire-(($sommehonoraire*5)/100);
  $montantht=(($sommedebours2+$sommedebours1)+$sommehonoraire);
  $montantnetht=((($sommedebours2+$sommedebours1)+$sommehonoraire)-($info_facture->reduction));
  echo
   '<tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"></td>
 <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;"> <strong style="font-size:12px;">MONTANT HT  </strong></td>
 <td style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;font-size:13px; text-align: center;"> '.$montantht.' </td>
 
 
       
   </tr>
   <tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"></td>
 <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;font-size:12px;"> <strong>RED. SUR HONO.(5%)</strong> </td>
 <td style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;font-size:13px; text-align: center;">  '.(($sommehonoraire*5)/100).'</td>
 
 
       
   </tr>
   <tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"></td>
 <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;"> <strong style="font-size:12px;">MONTANT NET HT </strong> </td>
 <td style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;font-size:13px; text-align: center;"> '.$montantnetht .' </td>
 
 
       
   </tr>
   <tr >
       <td style="border-left:1px solid black;"></td>
 
 <td style="text-align:right;"></td>
 <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;"><strong style="font-size:12px;">TVA SUR HONO. </strong> </td>
 <td style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;font-size:13px; text-align: center;"> 0  </td>
 
 
       
   </tr>
   <tr >
       <td style="border-left:1px solid black;border-bottom:1px solid black;"></td>
 
 <td style="text-align:right;border-bottom:1px solid black;"></td>
 <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;"> <strong style="font-size:12px;">MONTANT TTC  </strong></td>
 <td style="border-right:1px solid black;border-left:1px solid black;font-size:13px;border-bottom:1px solid black;background-color:#62bfe8; text-align: center;"> '.($montantnetht+$x).' </td>
 
 
       
   </tr>

   <tr >
       <td style="border-left:1px solid black;border-bottom:1px solid black;background-color:#62bfe8"></td>
 
 <td colspan="4" style="border-bottom:1px solid black;border-right:1px solid black;background-color:#62bfe8"><strong style="font-size:13px;">Arrêté à la présente facture à la somme de '.$this->numbertowords->convert_number(($montantnetht+$x).' </strong></td>
 
 
       
   </tr>'
   ?>
   </tbody>
   </table>
   <div style="font-size:12px;">
      <div style="margin-left:490px; margin-top: 7px; margin-bottom:30px;"> 
          <strong style="font-size:10px;"> LE DIRECTEUR GENERAL DELEGUE</strong>
      </div>
      <div style="margin-left:490px; margin-top: 60px;"> 
          <strong style="font-size:13px;"> FRANK GBETUDOR</strong>
      </div>
    </div>

 <img src="<?php  echo base_url('assets/images/pieddepagemd.png') ; ?>" style="background-position:center; background-repeat: no-repeat;position:absolute;top:990px;" height="100%" width="100%">  
 
          

</div>
</div>

<style>
  .lib{margin-bottom:20px; border-top:1px solid #000 !important; width:100px;} 
</style>
             