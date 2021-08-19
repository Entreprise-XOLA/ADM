<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class delete {
    public $ci;
    public $table ;
    
    public function __construct() {
           ;
           $this->ci = & get_instance();
    
    
    }
    
    
    function supprimer($id){
       $supp = new $this->table;
       $supp->delete($id);
        
    }
    
    
    
}