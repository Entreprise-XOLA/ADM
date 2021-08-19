<?php

//Error reading included file Templates/Scripting/Templates/Licenses/license-default_1.txt

        class brique {
    
    public $ci;
    
    public function __construct() {
            $this->ci = & get_instance();
    }
    
    
    function contact_form($langue='fr'){
        if ($langue=='fr'){
            
     
        
      echo  form_open("fr/message");
echo '
        <div class="large-6 columns">

 <strong> Formulaire de contacts</strong><br>
   
 <br>
  <div class="row">

    <div class="large-12 columns">
      <label>Nom
        <input name="nom" type="text" placeholder=" Votre Nom" />
      </label>
    </div>
  </div>
   <div class="row">
    <div class="large-12 columns">
      <label>email
        <input name="email" type="email" placeholder=" Votre email" />
      </label>
    </div>
  </div>
  
  <div class="row">
    <div class="large-12 columns">
      <label>Objet
        <input name="objet" type="text" placeholder="objet" />
      </label>
    </div>
  </div>
  

 <div class="row">
    <div class="large-12 columns">
      <label>Message
        <textarea name="message" rows="3">  </textarea> 
      </label>
    </div>
  </div>
 <div class="row">
    <div class="large-12 columns">
<input type="submit" class="button" value="envoyer">
     </div>
     </div>

       </div>
    
         </div>   </form>';
           }  else {
               
           
                  
      echo  form_open("fr/message");
echo '
        <div class="large-6 columns">

 <strong> Formulaire de contacts</strong><br>
   
 <br>
  <div class="row">

    <div class="large-12 columns">
      <label>Nom
        <input name="nom" type="text" placeholder=" Votre Nom" />
      </label>
    </div>
  </div>
   <div class="row">
    <div class="large-12 columns">
      <label>email
        <input name="email" type="email" placeholder=" Votre email" />
      </label>
    </div>
  </div>
  
  <div class="row">
    <div class="large-12 columns">
      <label>Objet
        <input name="objet" type="text" placeholder="objet" />
      </label>
    </div>
  </div>
  

 <div class="row">
    <div class="large-12 columns">
      <label>Message
        <textarea name="message" rows="3">  </textarea> 
      </label>
    </div>
  </div>
 <div class="row">
    <div class="large-12 columns">
<input type="submit" class="button" value="envoyer">
     </div>
     </div>

       </div>
    
         </div>   </form>';
               
               
               
           }
        
        
        
        
        
    }
    
    function newletter($langue='fr'){
        
        if ($langue=='fr'){
            
            
     
        
     echo    '  <strong>     s\'inscrire à notre lettre d\'information</strong>
                <br>
                <br>
                
                 <div class="row ">
                     <form action="<?php echo site_url("fr/sub") ?>" method="post">
                         
                    
        <div class="small-9 columns">
            <input type="email" name="email" placeholder="Votre email">
        </div>
        <div class="small-3 columns">
            <input type="submit" style="padding-right:10px;padding-left: 5px; font-size: 12px" value=" souscrire" class="button tiny "/>
        </div>
                     
                      </form>
      </div>';
     
        }  else {
            
             
     echo    '  <strong>   Newsletters</strong>
                <br>
                <br>
                
                 <div class="row ">
                     <form action="'. site_url("en/sub").'" method="post">
                         
                    
        <div class="small-9 columns">
            <input type="email" name="email" placeholder="your email">
        </div>
        <div class="small-3 columns">
            <input type="submit" style="padding-right:10px;padding-left: 5px; font-size: 12px" value=" sub" class="button tiny "/>
        </div>
                     
                      </form>
      </div>';
            
            
            
            
        }
        
        
    }
    // cette fonction affiche les j'aime facebook
    function facelike($link= ''){
        
        if ($link=''){
        
    echo     '   <div class="fb-like" data-href="'.site_url().'" data-width="100" data-layout="box_count" data-action="like" data-show-faces="false" data-share="true"></div>'
        ;}  else {
            
             echo     '   <div class="fb-like" data-href="'.$link.'" data-width="100" data-layout="box_count" data-action="like" data-show-faces="false" data-share="true"></div>'
    ;
    
}
    }
    
    
    function facebook_share(){
        
        
        
    }
    
    
    //cette fonction affiche affiche le menu des réseaux sociaux 
    function social_menu($page_facebook,$pagegoogle,$page_twitter, $postition='vertical'){
        
       if ($postition='vertical'){
           
      
     echo    '           <div class="icon-bar vertical three-up hide-for-small " style="position: absolute;top: 230px;left: 0px; height: 150px;padding: 0px; background-color: #dfe0de">
  <a href="'.$page_facebook.'
" class="item">
      <span class="fa fa-2x fa-facebook-square"></span> </a>
  </a>
  <a href="http://www.plus.google.com/share?url='.$pagegoogle.'" class="item">
     <span class="fa fa-2x fa-google-plus-square"></span>
  </a>
  <a href="http://www.twitter.com/share?url='.$page_twitter.'" class="item">
      <span class="fa fa-2x fa-twitter-square"></span>
      
  </a>
 
</div>';  } else {
      
  
    echo '       ';
    
    
    
}
        
        
        
        
    }
       // cette fonction affiche une liste d'article avec des mignateur d'images et un text descriptif
            
    function thumb_article($objet_article, $nb_element_ligne='3',$colone_id='id',$colone_article='article',$colone_resume='resume',$photo='images'){
                
                
                
                
            }
            
            //cette fonction permet de faire  une liste d'article ainsi que leur résumés
            function liste_article( $data,$nbarticle='5',$link_all='',$colone_id='id_article',$colone_article='contenu',$colone_titre='lib_art',$photo='img_a_la_une',$lang='fr')
            {
                	
                $output = " ";
                
                
                foreach ( $data as $row){
                if (!empty($row[$photo])){
                   $image = $row[$photo];
                }  else {
                     $image = "logo.jpg";
                }
                       if ($lang=='fr'){
                  $output = $output. '<div class="row"> <div class = "medium-2 column"> <img src ="'
                    .base_url("assets/images")."/".$image.'" /> </div> <div class="medium-7 column end"> <strong>'
                            
                                .$row[$colone_titre] 
                            . ' </strong><p> '.strip_tags(word_limiter($row[$colone_article],'20')).'<a href="'.  site_url("fr/page").'/'.$row[$colone_id].'"> Lire la suite</a> <p></div>  </div>';
                      
                  
                  
                  
                       }else{
                           
                                  $output = $output. '<div class="row"> <div class = "medium-2 column"> <img src ="'
                    .base_url("assets/images")."/".$image.'" /> </div> <div class="medium-7 column end"> <strong>'
                            
                                .$row[$colone_titre] 
                            . ' </strong><p> '.strip_tags(word_limiter($row[$colone_article],'20')).'<a href="'.  site_url("en/page").'/'.$row[$colone_id].'"> continue</a> <p></div>  </div>';
                        
                           
                           
                       }
               
                  
                  
                  
                       }
               
                return $output;
                
                
                
            }
            
            
            // cette fonction affiche un texe dans une fennetre windows style windows 8
            function windows($text){
                
                
            }
            
            // cette fonction affiche des information sur le createur du site
            function copyrigth(){
                
           echo '     <div class="row copyright">
                    
                    
                    <div class="medium-6 large-6 column medium-offset-1">
                        <br>
                        &COPY; '.site_url().' 
                         <br>
                    </div>
                    
                    <div class="medium-3 large-3 column end">
                       <br>  Designed By <a href="mailto:adjdyssa@gmail.com"> Adjdyssa</a>
                    </div>
                    
                </div>';
                
            }
            
            // cette fonction permet de creer un slider
            
            function slider($tab_slider,$colone_image='file_name',$colone_article='titre'){
                
           echo '      <ul class="example-orbit" data-orbit>';
                                    
               
             
                if (isset($tab_slider)){
                
              
$i = 0;
foreach ($tab_slider as $row){  
                                    
 echo '                                   
  <li>
      <img src=" '.base_url().'assets/images/'.$row[$colone_image] .'  />'
   ;
    if ( isset($row[$colone_article]) and $row[$colone_article]<> ""){
        
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
              
            
            
            function search(){
                
                
            }
            
            
            
            
            
        }
