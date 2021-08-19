<?php

/* 
 * copyright Adjdyssa.
 * 0022892545925

 */
class message {
    public $ci;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper(array('url','mg_form'));
    }
    
    
function form_message($correspondant=""){
    
   ?> 
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3> Nouveau message</h3>
        <?php form_open("message")  ?>   
         <label for="destinataire"> Correspondant</label>
         <input type="text" class="form-control" name="destinataire" placeholder="to" <?php if (isset($correspondant)) { echo ' disabled="" value="'. $correspondant.'"'; } ?>    >
        
        <label for="sujet"> Sujet</label>
        <input type="text" class="form-control" name="sujet" id="sujet" placeholder="subject">
        <label for="message">Message</label>
<?php form_cktextarea("message")  ?>        
       
        
        
        
    </div>
    
</div>    


   <?php 
    
}


    
function form_user_message($correspondant=""){
    
   ?> 
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3> Nouveau message</h3>
        <?php form_open("message")  ?>   
         <label for="destinataire"> Correspondant</label>
         <input type="hidden" class="form-control" name="destinataire" placeholder="to" <?php if (isset($correspondant)) { echo ' value="'. $correspondant.'"'; } ?>    >
        
        <label for="sujet"> Sujet</label>
        <input type="text" class="form-control" name="sujet" id="sujet" placeholder="subject">
        <label for="message">Message</label>
<?php form_cktextarea("message")  ?>        
       
        
        
        
    </div>
    
</div>    


   <?php 
    
}

    
    
function newsletter($correspondant=""){
    
   ?> 
<div class="row">
    <div class="col-md-10 col-md-offset-1">
      
        <?php form_open("mail/newsletter")  ?>   
        
           <div class="row">
            
            <div class="col-md-7">
                <strong>
                    <h1> Nouveau message de diffusion</h1> 
                </strong> 
            </div>
            <div class="col-md-3 col-md-offset-1">
                <input type=" submit" class="btn btn-primary" value="Envoyer"/> 
            </div>
        </div>
        <br> 
        
      
        <label for="sujet"> Sujet</label>
        <input type="text" class="form-control" name="sujet" id="sujet" placeholder="subject">
        <label for="message">Message</label>
<?php form_cktextarea("message")  ?>        
       
        
        
        
    </div>
    
</div>    


   <?php 
    
}



    
    
function mail_form($correspondant=""){
    $this->ci->load->helper('mg_form');  
   ?> 
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php
          echo  validation_errors();
     echo    form_open("email/send") ; ?>   
        
        <div class="row">
            
            <div class="col-md-6">
                <strong>
                    <h1> Nouveau message</h1> 
                </strong> 
            </div>
            <div class="col-md-3 col-md-offset-3">
                <input type="submit" class="btn btn-lg btn-primary" value="Envoyer"/> 
            </div>
        </div>
       
         <label for="destinataire"> Correspondant</label>
         <input type="email" required="" class="form-control" name="destinataire" placeholder="to" <?php if (isset($correspondant)) { echo '  value="'. $correspondant.'"'; } ?>    />
        
        <label for="sujet"> Sujet</label>
        <input type="text" class="form-control" name="sujet" id="sujet" placeholder="subject">
        <label for="message">Message</label>
<?php form_cktextarea("message") ;  ?>        
       
        
    </form>
        
    </div>
    
</div>    


   <?php 
    
}






function send_mail($from){
    
    $this->ci->load->library("mail");
    $this->load->library('form_validation');
    
    $destinataire = $this->ci->input->post("destinataire");
    $objet = $this->ci->input->post("sujet");
    $message =  $this->ci->input->post("message");
    
    
    $this->form_validation->set_rules('destinataire', 'destinataire', 'required|email');
$this->form_validation->set_rules('message', 'message', 'required');
$this->form_validation->set_rules('sujet', 'sujet', 'required');

    
    
		if ($this->form_validation->run() == FALSE)
		{
                  
		$this;
		}
		else
		{
		
                     $this->email->from($from, base_url());
$this->email->to($destinataire); 


$this->email->subject($objet);
$this->email->message($message);	

$this->email->send();
                    
                    
		}
    
                
                
   
    
    
}


function get_messages($userid){
    
    $this->ci->load->helper("comon");
    
     $req =  $this->ci->db->query("select * from messages where id_user =' ".$userid."'");
  $resultat =  $req->result_array();
  //var_dump($resultat);
  echo "<table class='table table-striped'>";
  echo " <tr> <th> nom </th> <th>email </th> <th>contenu</th> <th>action</th> </tr>";
   foreach ($resultat as $row  ){
       
            echo "<tr><td> ".$row['nom']."</td> <td>".$row['email']."</td><td>".resume($row['contenu'],40)."</td> <td> <a class='btn btn-default' href='".  site_url("home/infomessage/")."/".$row['id']."' ><span class='fa fa-info'></span> </a> </td> </tr>";
       
   }
   echo "</table>";
    
    
}


function show_message($idmessage){
    
  $req =  $this->ci->db->query("select * from messages where id =' ".$idmessage."'");
  $resultat =  $req->result_array();
 foreach ($resultat as $row  ){
  echo " <div class='panel panel-info'>"
  . " <div class='panel-heading'> Message de ".$row['nom']. "</div> <div class='panel-body'>  <h5> Email : ".$row['email']."</h5> <h4> Sujet : ".$row['sujet']."</h4>"
          
          ." Message <br> <div class='panel-footer'>".$row['contenu']
          
          . "</div></div></div>";
  

  
       
      
       
   }

}

}

?>
