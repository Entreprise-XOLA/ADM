<?php

/* 
 * copyright Adjdyssa.
 * 0022892545925

 */
class Menu {
    
    
    public $table;
    public $data;
    public $ci ;
    
    
    public function __construct() {
        $this->ci = & get_instance();
        $this->table ="menu";
    }
    
    
    function sous_menu($id_item){
        
    $menu =    $this->ci->db->query("select * from ".$this->table." where id_parent = '".$id_item."' order by id_element asc");
       $verif = $menu->result_array();
      
    if ( empty($verif)){
        // var_dump($verif);
        return false;
    }else {
       // var_dump($verif);
        return true;
    }
    
    }
  
    function do_menu($lang){
        
        
        $menu = $this->ci->db->query("select * from menu order by id_element asc;");
        $donne= $menu->result_array();
        if ($lang =="fr"){
            
                echo  '
            <nav class="top-bar" data-topbar role="navigation" style="background-color: rgba(236, 25, 40, 0.91);">
  
  
  <section class="top-bar-section">
    <!-- Right Nav Section -->
  
 <ul class="title-area">
    <li class="name hidden-for-medium-up  hidden-for-large">
      <h1><a href="#">ACDI</a></h1>
    </li>
  </ul>

              
    <!-- Left Nav Section -->

    <ul class="left">
    

        <li ><a  href="'.  site_url().'"><span class="fa fa-bars"></span> Accueil</a></li>';
        
   //     $temp = "";
        // var_dump($donne);
        foreach ( $donne as $row ){
              //   var_dump($row['id_parent']);
            if ($row['id_parent'] == '0' ){
                //var_dump($this->sous_menu($row['id_element']) );
           
                if($this->sous_menu($row['id_element']) == true ){
                    
                     $temp = '<li  class=" has-dropdown " ><a href="'.site_url($lang)."/".$row['cible'].'"> '.$row['libelet_menu'].'</a>';
              
                    echo $temp .'   <ul class="dropdown">';
                    $query = "select * from menu where id_parent = '".$row['id_element']."' order by id_element asc;";
                     $sous_menu = $this->ci->db->query($query);
                     //var_dump($sous_menu);
                    $donne_sous_menu = $sous_menu->result_array();
                   // $sous_menu_output ='';
                 //  var_dump($donne_sous_menu);
                    foreach ($donne_sous_menu as $value){
                        
                        echo '<li><a href="'.site_url($lang)."/".$value['cible'].'"> '.$value['libelet_menu'].'</a></li>';
                    }
               //     var_dump($sous_menu_output);
                  echo '  </ul> </li>';
                    //$temp = $temp.$sous_menu_output;
                   //var_dump($temp);
                }else{
                    
                  echo  '<li><a href="'.site_url($lang)."/".$row['cible'].'"> '.$row['libelet_menu'].'</a></li>';
              
                    
                }
                
                
               }
              
          //echo $finaloutput;        
        }  echo "</ul>
    
 
  </section>
                
                
</nav>      
       ";
        
      
            
            
        }  else {
            
             echo  '
            <nav class="top-bar" data-topbar role="navigation" style="background-color: rgba(236, 25, 40, 0.91);">
  
  
  <section class="top-bar-section">
    <!-- Right Nav Section -->
  
 <ul class="title-area">
    <li class="name hidden-for-medium-up  hidden-for-large">
      <h1><a href="#">ACDI</a></h1>
    </li>
  </ul>

              
    <!-- Left Nav Section -->

    <ul class="left">
    

        <li ><a  href="'.  site_url("en").'"><span class="fa fa-bars"></span> Home</a></li>';
        
   //     $temp = "";
        // var_dump($donne);
        foreach ( $donne as $row ){
              //   var_dump($row['id_parent']);
            if ($row['id_parent'] == '0' ){
                //var_dump($this->sous_menu($row['id_element']) );
           
                if($this->sous_menu($row['id_element']) == true ){
                    
                     $temp = '<li  class=" has-dropdown " ><a href="'.site_url($lang)."/".$row['cible'].'"> '.$row['en_libelet_menu'].'</a>';
              
                    echo $temp .'   <ul class="dropdown">';
                    $query = "select * from menu where id_parent = '".$row['id_element']."' order by id_element asc;";
                     $sous_menu = $this->ci->db->query($query);
                     //var_dump($sous_menu);
                    $donne_sous_menu = $sous_menu->result_array();
                   // $sous_menu_output ='';
                 //  var_dump($donne_sous_menu);
                    foreach ($donne_sous_menu as $value){
                        
                        echo '<li><a href="'.site_url($lang)."/".$value['cible'].'"> '.$value['en_libelet_menu'].'</a></li>';
                    }
               //     var_dump($sous_menu_output);
                  echo '  </ul> </li>';
                    //$temp = $temp.$sous_menu_output;
                   //var_dump($temp);
                }else{
                    
                  echo  '<li><a href="'.site_url($lang)."/".$row['cible'].'"> '.$row['en_libelet_menu'].'</a></li>';
              
                    
                }
                
                
               }
              
          //echo $finaloutput;        
        }  echo "</ul>
    
 
  </section>
                
                
</nav>      
       ";
        
     
            
            
            
        }
  
     
        
    }
    
  
    
}
