<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class read{
    public $nombrelignes;
    public $type;
    public $colone ;
  public $where_collonne;
  public $where_valeur;
  public $join_table;
  public $join_colone;
  
    public $where_collonne2;
  public $where_valeur2;
  public $join_table2;
  public $join_colone2;
  
    public $commande;
    public $action =array();
      public $table ;
    public $ci ;
  
    public $objettable;

    public function __construct() {
       
        $this->ci = & get_instance();
        $this->ci->load->helper('url');

    }
    
    
    public function colonne($data=  array()){
        
        $this->colone = $data;
        return $this;
        
    }
    
    
    // renseigne les info sur la table a parcourir
    
    function table($nomtable){
        $this->table= $nomtable;
    
  $this->ci->load->model($nomtable);
      $objet_model = new $nomtable;  
 $this->objettable = $objet_model;
 //$this->objettable = new $this->table;
//var_dump($this->objettable);
        return $this;
    }
    
    
   public function join($table,$colonne){
        //var_dump($this->objettable);
        $this->objettable = $this->objettable->join($table,$colonne);
        return $this;
       // $this->join_table =$table;
       // $this->join_colone = $colonne;
        //return $this->objettable->join($table,$colonne);
    }
    
   
    
    public function action($data){
        // permet de definir l'url de laction
        $this->action = $data;
        return $this;
        
        
    }
    
    /*
     * 
     */
    
    public function where($colonne,$valeur){
        
      //  $this->where_collonne = $colonne;
       // $this->where_valeur = $valeur;
        $this->objettable = $this->objettable->where($colonne,$valeur);
        return $this;
    }
      

    
    
    function show_item($id){
  
         //var_dump($objet_table);
         //
         //
        //  var_dump($this->objettable);
        
        
        $resultat = $this->objettable->as_array()->find($id);


              echo "<table class='table medium-11' name='' >";
            foreach ( $this->colone as $element=>$valeur ){
       
            
           echo "<tr><td>" .$valeur. "</td><td>".$resultat[$element]."</td> </tr>";
           
            }
            
            echo "</table> ";
        } 
     
        



    /**
     * cette fonction affiche la lisete des element d'une ou de pluisieurs tables
     * le paramettre permet de specifier les url de show  
     */
    function show_all($context="admin"){
        $this->ci->load->model($this->table);
 
        if ($context <> 'admin'){
            
        
        $this->action['show'] = site_url("ajaxserver_").$context."/".$this->table."/show/" ;
               $this->action['edit'] = site_url("ajaxserver_").$context."/".$this->table."/update/" ;
                       $this->action['delete'] = site_url("op_").$context."/".$this->table."/delete/" ;
        
            
        } else{
            
        
        $this->action['show'] = site_url("ajaxserver")."/".$this->table."/show/" ;
               $this->action['edit'] = site_url("ajaxserver")."/".$this->table."/update/" ;
                       $this->action['delete'] = site_url("op")."/".$this->table."/delete/" ;
        
        }
        
       
        
       //  var_dump($this->objettable);
        $resultat = $this->objettable->as_array()->find_all();


     if (!empty($resultat)) {

     //   var_dump($resultat); 
        echo "<table class='datatable'  name='' >  <thead><tr>";
        foreach ( $this->colone as $valeur ){
            
           echo "<th>".$valeur."</th>";
            
        }
        if (!empty($this->action)){
            echo "<th> Actions </th>";
        }
        echo "</tr> </thead> <tbody>";
         echo "<tr> ";
    


       foreach ( $resultat as $read ){
          foreach ( $this->colone as $element=>$dat){
           //   var_dump($read);
            
           echo "<td>".character_limiter($read[$element],"20")."</td>";
            
        }
        
           echo " <td> <a   data-reveal-id='firstModals' data-reveal-ajax='true'  href='".$this->action['show'].$read[$this->ci->db->primary($this->table)]."' > <span class='fa fa-info-circle fa-2x'></span></a>";
           echo " <a   data-reveal-id='firstModals' data-reveal-ajax='true' href='".$this->action['edit'].$read[$this->ci->db->primary($this->table)]."' > <span class='fa fa-edit fa-2x'></span></a>";
           echo ' <a   onclick="del(\''.$this->table.'\',\'delete\',\''.$read[$this->ci->db->primary($this->table)].'\');" '."  > <span class='fa fa-trash-o fa-2x'></span></a></td>";
          
          
        echo "</tr>  ";
        
       } 
          
           # code...
       
    echo "<tbody></table> ";
          }
    }
  

    function bulletin_all($context="admin"){
        $this->ci->load->model($this->table);

 
        if ($context <> 'admin'){
           
            $this->action['imprimer'] = site_url("ajaxserver")."/".$this->table."/imprimer/" ;
           
           
            
            
        } else{
            
            $this->action['imprimer'] = site_url("ajaxserver")."/".$this->table."/imprimer/" ;
        }
        
       
        
       //  var_dump($this->objettable);
        $resultat = $this->objettable->as_array()->find_all();


     if (!empty($resultat)) {

     //   var_dump($resultat); 
        echo "<table class='datatable'  name='' >  <thead><tr>";
        foreach ( $this->colone as $valeur ){
            
           echo "<th>".$valeur."</th>";
            
        }
        if (!empty($this->action)){
            echo "<th> Actions </th>";
        }
        
        echo "</tr> </thead> <tbody>";
         echo "<tr> ";
   


       foreach ( $resultat as $read ){
          foreach ( $this->colone as $element=>$dat){
           //   var_dump($read);
            
           echo "<td>".character_limiter($read[$element],"20")."</td>";
            
        }
        

           echo "  <td> <a href='".$this->action['imprimer'].$read[$this->ci->db->primary($this->table)]."' > <input type='submit' value='Mettre à jour'  class=' button right' style='width:150px;padding:2px' /></a>";
           echo  " <a   data-reveal-id='firstModals' data-reveal-ajax='true' href='".$this->action['imprimer'].$read[$this->ci->db->primary($this->table)]."' > <input type='submit' value='Bulletin'  class=' button' style='width:150px;padding:2px' /></a>";
          
          
        echo "</tr>  ";
        
       } 
          
           # code...
       
    echo "<tbody></table> ";
          }
    }
  
    
    
    
    function print_all(){
        $this->ci->load->model($this->table);
 
        
        $this->action['show'] = site_url("ajaxserver")."/".$this->table."/show/" ;
               $this->action['edit'] = site_url("ajaxserver")."/".$this->table."/update/" ;
                       $this->action['delete'] = site_url("op")."/".$this->table."/delete/" ;
        
        $this->objettable = new $this->table;
       //  var_dump($this->objettable);
        
      
        if (!empty($this->table) and !empty($this->join_table) and !empty($this->join_table2)  ){
            
            
           $resultat = $this->objettable->as_array()->join($this->join_table, $this->join_colone)
                                                    ->join($this->join_table2,$this->join_colone2)
                                       ->find_all();
            
              
            
        }
       elseif (!empty($this->table) and !empty($this->join_table)){
            
            
            $resultat = $this->objettable->as_array()->join($this->join_table, $this->join_colone)
                                         ->find_all();
            
           }     
             elseif(!empty ($this->table) and !empty ($this->where_collonne) and !empty ($this->where_collonne2) ) {
            
            
            $resultat = $this->objettable->as_array()->where($this->where_collonne,  $this->where_valeur)->where($this->where_collonne2,$this->where_valeur2)
                                       ->find_all();
         } 
         elseif(!empty ($this->table) and !empty ($this->where_collonne)) {
            
            
               $resultat = $this->objettable->as_array()->where($this->where_collonne,$this->where_valeur)
                                         ->find_all();
        } elseif (!empty ($this->table)) {
             
           
            $resultat = $this->objettable->as_array()
                                         ->find_all();
     }
        
       // return $resultat;
                 
        
        
     
      
     //   var_dump($resultat); 
        echo "<table class='table'  name='' >  <thead><tr>";
        foreach ( $this->colone as $valeur ){
            
           echo "<th>".$valeur."</th>";
            
        }
        
        echo "</tr> </thead> <tbody>";
         echo "<tr> ";
         $counti =0;
          foreach ( $resultat as $read ){
              
              $counti = $counti +1;
              
              if ($counti==20){
                  echo '</table>';
                  
                  
                  
                  $counti= 30;
              }elseif($counti % 30 == 0){
                   echo "<table class='table'  name='' >  <thead><tr>";
        foreach ( $this->colone as $valeur ){
            
           echo "<th>".$valeur."</th>";
            
        }
        
        echo "</tr> </thead> <tbody>";
         echo "<tr> ";
                  
              }
          foreach ( $this->colone as $element=>$dat){
           //   var_dump($read);
            
           echo "<td>".$read[$element]."</td>";
            
        }
        
          
          
        echo "</tr>  ";
        
       }  echo "<tbody></table> ";
        
    }
    
    
    /**
     * orbit slider de fondation
     * 
     * @param type $colone_image
     * @param type $colone_article
     */
    
 
            function orbit_slider($colone_image='file_name',$colone_article='titre'){
                
          $this->ci->load->model($this->table);

          $this->objettable = new $this->table;
       $slider =     $this->objettable->find_all()->result_array();
//                $this->load
                
           echo '        <ul class="orbit" style="height:200px;" data-options="animation_speed:
                                    1000;
                                    next_on_click: true;
                                    slide_number: false; 
                                    timer_speed: 1500; " data-orbit>';
                                    
               
             
                if (!empty($slider)){
                
              
$i = 0;
foreach ($slider as $row){  
                                    
 echo '                                   
  <li>
      <img src=" '.base_url().'assets/images/'.$row[$colone_image] .'  />'
   ;
    if ( !empty($row[$colone_article]) and $row[$colone_article]<> ""){
        
        echo ' <div class="orbit-caption">';
        echo $row[$colone_article];
    
       echo ' </div>';
    
    
    }  
echo '
         
  </li>
  
                '; }}  else {
    
echo "Aucune image à afficher pour le moment";} 

echo '</ul>';
                
            }
    
            
            
            function link_list($colone_libelet="",$url_base="",$context="admin"){
                        $this->ci->load->model($this->table);
 
        if ($context <> 'admin'){
            
        
        $this->action['show'] = site_url("ajaxserver_").$context."/".$this->table."/show/" ;
               $this->action['edit'] = site_url("ajaxserver_").$context."/".$this->table."/update/" ;
                       $this->action['delete'] = site_url("op_").$context."/".$this->table."/delete/" ;
        
            
        } else{
            
        
        $this->action['show'] = site_url("ajaxserver")."/".$this->table."/show/" ;
               $this->action['edit'] = site_url("ajaxserver")."/".$this->table."/update/" ;
                       $this->action['delete'] = site_url("op")."/".$this->table."/delete/" ;
        
        }
        
          
       //  var_dump($this->objettable);
        $resultat = $this->objettable->as_array()->find_all();


        
     
      
     //   var_dump($resultat); 
         if (!empty($resultat)) {

echo '
<div class="row">
    <div class="medium-11 column">
        <ul class="medium-block-grid-4">

';
             
             
       foreach ( $resultat as $read ){
           echo '<li>


<a style="color:white;" href="'.site_url($url_base)."/".$read[$this->ci->db->primary($this->table)].'" >
    
  <div style="height:100px;margin-top:0px;" class=" button  expand">





'.character_limiter($read[$colone_libelet],"25").'
    

       
      </div></a>
   
<div class="row " style="margin-top:-20px;padding:0px;margin-right:0px;margin-left:0px;">
  <a href="'.$this->action['edit'].$read[$this->ci->db->primary($this->table)].'"  data-reveal-id="firstModals" data-reveal-ajax="true" > 
<div class="medium-6 small-6 medium-offset-0 button tiny success columns" >
    
<span class="fa fa-2x fa-pencil" style="color:white;" ></span> 
 </div>

</a>
    <a   onclick="del(\''.$this->table.'\',\'delete\',\''.$read[$this->ci->db->primary($this->table)].'\');"   >
<div class="medium-6 small-6 columns end alert button tiny" >
  
<span class="fa fa-2x fa-close " style="color:white;" ></span>


</div> </a>

</div>

    </li>
';
           
          
        
       } 
       
       
       
       echo '</ul>


        </div>

        </div>';
       
       
           # code...
         }
                
            }
            
            
    
            /**
             * affiche une liste d'article avec  un petit resume descriptif
             * cette fonction utilise des classe fondation
             * 
             * @param type $setting = array('titre'=>'titre de l'image ','file_name'=>'nom du fichier') 
             * 
             * ce param renseigne les info sur les colone utiliser pour l'affichage
             * 
             */
            function liste_image__show($file_name,$titre_image,$id_article,$controleur){
                
                
          $this->ci->load->model($this->table);

          $this->objettable = new $this->table;
       $galerie =     $this->objettable->find_all()->result_array();
       
       
             	
             echo '<div class="row"">';
$i = 0;
foreach ($galerie as $row){

echo '<div class="col-md-3"> 
	
	<a class="fancybox" data-fancybox-group="group" href="'.base_url().'assets/images/' ;

 echo $row['nom_fichier'].'">	
<img class="thumbnail" width="98%" height="180" src ="'.base_url().'assets/images/' ;

 echo $row['nom_fichier']; echo '"/> </a>
		
		
		<div class="caption"  style="position :absolute;bottom:0px;padding:10px;margin-bottom:10px;">
<strong>'.$row['libelet'].'</strong>		
<p>
                

                </p>
		</div>	
		
     </div> ';


 $i++;
if ($i % 3  == '0'){

echo '</div> ';
echo '<div class="row"">';

 }

}
echo '</div> ';



                
            }
            
            
            
            function fondation_liste_liens($url_base="admin/ajax",$colone_id,$colone_titre_lien){
                
                
          $this->ci->load->model($this->table);

          $this->objettable = new $this->table;
       $link =     $this->objettable->find_all()->result_array();
       
       echo '<ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">';
       
       foreach ($link as $row){
          
       echo '<li> <a href="'.site_url().'/'.$url_base.'/'.$row[$colone_id].'  ">   '.$row[$colone_titre_lien].' </li> ';
           
       }
       
  echo '
</ul>';
             	
                $output = " ";
                
                
                foreach ( $galerie as $row){
                if (!empty($row[$file_name])){
                   $image = $row[$file_name];
                }  else {
                     $image = "logo.jpg";
                }
                       if ($lang=='fr'){
                  $output = $output. '<div class="row"> <div class = "medium-2 column"> <img src ="'
                    .base_url("assets/images")."/".$file_name.'" /> </div> <div class="medium-7 column end"> <strong>'
                            
                                .$row[$titre_image] 
                            . ' </strong><p> '.strip_tags(word_limiter($row[$titre_image],'20')).'<a href="'.  site_url($controleur).'/'.$row[$id_article].'"> Lire la suite</a> <p></div>  </div>';
                      
                  
                  
                  
                       }else{
                           
                                  $output = $output. '<div class="row"> <div class = "medium-2 column"> <img src ="'
                    .base_url("assets/images")."/".$image.'" /> </div> <div class="medium-7 column end"> <strong>'
                            
                                .$row[$colone_titre] 
                            . ' </strong><p> '.strip_tags(word_limiter($row[$colone_article],'20')).'<a href="'.  site_url("en/page").'/'.$row[$colone_id].'"> continue</a> <p></div>  </div>';
                        
                           
                           
                       }
               
                  
                  
                  
                       }
               
                echo $output;
                
       
                
            }
}
