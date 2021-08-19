<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontwidget{
	
	
	/*cette fonction permet d'afficher le widget de la souscription newletter
	 * 
	 * 
	 */
	public $ci;
	function __construct(){
		
		$this->ci = & get_instance();
		$this->ci->lang->load('admin', 'english');
	}
	
	
	
	function newletersub(){
		
		
		echo '<div class="input-group">
  <span class="input-group-addon">@</span>
  <input type="email" class="form-control" name= placeholder="votre adresse email">
</div>
				  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-default">envoyer</button>
</form>
				
				';
		
	}
	
	function adminlogform(){
		
		$messag = $this->ci->input->get('i');
		switch ($messag){
			case '1': echo '
					<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> vous devez renseigner tous les champs .
</div>
					'; 
		             break;
			case '2': echo '<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> vérifiez vos identifiants et mots de passe.
					
</div>'; 
			break;
			default:echo '';
		}
		
		
	echo 	'<div class="container">
		<div class="row">
		<div class="col-md-3 col-md-offset-4">'.
	
 validation_errors().
	'	<div class="login">
 		
 		
 		
		'. form_open('home').'
		
		
		<div class="input-group">
		<span class="input-group-addon"> login</span>
		<input type="text" name="logname" class="form-control" placeholder="'.$this->ci->lang->line('username').' "/>
		</div>
		<div class="input-group">
		<span class="input-group-addon"> pass</span>
		<input type="password" name="password" class="form-control"  placeholder="'.$this->ci->lang->line('password').'"/>
		</div>
		<input type="submit" name="submit" class="btn btn-default" value ="'. $this->ci->lang->line('logon').' " style="margin-top: 10px;"/>
		</form>
		</div>
		</div>
		</div></div>';
	}
	
	
	
	
	
	
}

