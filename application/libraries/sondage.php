<?php


class Sondage {
    
    
    
    
    public $ci ;
    
    public function __construct() {
        $this->ci = & get_instance();
    }
    
    
    
    
            function questionnaire($tableau_question){
                
                foreach($tableau_question as $question){
                    
                    if ($question['type']== 'choix'){
                        
                    $propposition =    $this->ci->db->query(' select * from sondage_sugestion where id_question = '.$question['id_question'])->result_array();
                 
                    foreach ( $propposition as $ligne){
                        
                        echo  $ligne['libelet'] ;
                        
                        
                    }
                    
                    
                    }  elseif($question['type']== 'reponse') {
                        
                        echo $question['libelet'];
                        
                    }
                    
                }
                
                
            }
    
}