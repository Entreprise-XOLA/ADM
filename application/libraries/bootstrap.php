<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bootstrap {

	/*cette fonction permet de charger les fichier de bootsraps
	 * 
	 * 
	 */
	function init(){
		
		
	}
	
	
	
    public function add_tooltipbtn($value,$content,$position)
    {
    	//@value exprime le texte a afficher en tooltip
    	//$content est le contenu du bouton lui meme
    	echo '<button type="button"
class="btn btn-default" data-toggle="tooltip" 
data-placement="'.$position.'" title="'.$value.'">'.$content.' </button>';
    	
    	
    }
    
    public function add_tooltiplnk($value,$content,$link)
    {
    	//permet d'ajouter un tooltip sur un liens
    	 
    	echo '<a class="btn btn-default" data-toggle="tooltip" href="'.$link.'" title="" data-original-title="'.$value.'">'.$content.' </a>';
    	
    }
    
    public function add_popoverbtn($value,$content,$position) {
    echo '	<button type="button" class="btn btn-default" data-container="body" data-toggle="popover"
    		 data-placement="'.$position.'" data-content="'.$value.'">
    	'.$content.'
    	</button>'
    	;
    }
    
    
    public function add_loadbtn($id,$btntext,$loadtext) {
    	
    	
    	echo '<button type="button" id="'.$id.'" data-loading-text="'.$loadtext.'" class="btn btn-primary">
 '.$btntext.'
</button>';
    	echo "
<script>
  $('".$id."').click(function () {
    var btn = $(this)
    btn.button('loading')
    $.ajax(...).always(function () {
      btn.button('reset')
    });
  });
</script>
    "
    	;
    }
    
    
    function add_chekbtn($name,$data,$value) {
    	
    	echo '<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary">';
    	
    $t = 	array_count_values($value);
    	for($i = 0 ; $i <= $t ; $i++) {
    		echo ' 
  <label class="btn btn-primary">
    				<input value="'.$value[$i].'" type="checkbox"> '.$data[$i].'
    				  </label>';
    		
    		
    	}
  echo '</div>';

    	
    }
    
    public function add_radiobtn($name,$data,$value){
    	
    	
    	echo '<div class="btn-group" data-toggle="buttons">';
    	 
    	$t = 	array_count_values($value);
    	for($i = 0 ; $i <= $t ; $i++) {
    		echo '
  <label class="btn btn-primary">
    				<input value="'.$value[$i].'" type="radio"> '.$data[$i].'
    				  </label>';
    	
    	
    	}
    	echo '</div>';
    	 
    	
    }
    
    
    
    public function add_inputgp($icone,$name){
    	
    	
    	echo '<div class="input-group input-group-lg">
  <span class="input-group-addon">'.$icone.'</span>
  <input type="text" name="'.$name.'" class="form-control" placeholder="Username">
</div>';
    }
    
    
    
    public function add_tabmenu($id,$data,$active){
    	//active est un entier qui permet de disigner dans le menu celui qui recevoir l'onglet
    	
    echo '	<ul class="nav nav-tabs">';
    
    foreach ($data as $value){
    
    	
    if ($value == $active )
    {
    	echo '	<li class="active"><a href="'.$value['link'].'">'.$value['contenu'].'</a></li>';
    }else {
    	

    	echo '<li><a href="'.$value['link'].'">'.$value['contenu'].'</a></li>';
    }
    	
    }
    
    	echo '	</ul>';
    
    	 
    
    	
    	
    }
    
    
    public function add_pins($id,$data,$active){
    	//active est un entier qui permet de disigner dans le menu celui qui recevoir l'onglet
    	
    echo '	<ul class="nav nav-pins">';
    
    foreach ($data as $value){
    
    	
    if ($value == $active )
    {
    	echo '	<li class="active"><a href="'.$value['link'].'">'.$value['contenu'].'</a></li>';
    }else {
    	

    	echo '<li><a href="'.$value['link'].'">'.$value['contenu'].'</a></li>';
    }
    	
    }
    
    	echo '	</ul>';
    
    	 
    
    	
    	
    }
    
    
    function add_jumptrump($content){
    	
    	//cette fonction permet d'ajouter un badeau occupant toute la page souvent utiliser sous le menu principale du site
    	// le seul paramettre est le contenu a afficher
    	echo '<div class="jumbotron">
  '.$content.'
    			
    			</div>
    ';
    }
    
    
    
    public function add_respimg($link,$alt) {
    	//cette fonction permet d'ajouter une image responsible
    	
    	// les paramtres sous la souce de l'image et le texte alternatif
    	echo '<img src="'.$link.'" class="img-responsive" alt="'.$alt.'">
    '
    	;
    }
    
    
    public  function add_imgrnd($link,$alt) {
    	//cette fonction permet d'ajouter une image arondi
    	//     	
    	// les paramtres sous la souce de l'image et le texte alternatif
    	echo '<img src="'.$link.'" alt="'.$alt.'class="img-rounded">'
    	;
    }
    
    
    public  function add_imgcrl($link,$alt) {

    	//cette fonction permet d'ajouter une image arondi en cercle
    	//
    	// les paramtres sous la souce de l'image et le texte alternatif
    	echo '<img src="'.$link.'" alt="'.$alt.'class="img-circle">'
    			;
    }
    
    
    public  function add_imgtmb($link,$alt) {
    	 

    	//cette fonction permet d'ajouter une image pour mignature
    	//
    	// les paramtres sous la souce de l'image et le texte alternatif
    	
    	
    	echo '<img src="'.$link.'" alt="'.$alt.'class="img-thumbnail">'
    			;
    }
    
    
    
    function add_descimgcrl($source,$link,$alt,$titre,$contentext){
    	
    	
    	echo '<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img data-src="holder.js/300x200" alt="...">
      <div class="caption">
        <h3> '.$titre.'</h3>
        <p>...</p>
        <p><a href="'.$link.'" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
  </div>
</div>
    ';
    }
    
    
   public function add_modal($modalnam,$modalcontent,$btnvalue) {
   	
   	echo '<button class="btn btn-primary" data-toggle="modal" data-target=".'.$modalnam.'"> '.$btnvalue.'</button>

<div class="modal fade '.$modalnam.'" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
   '.$modalcontent.'
    </div>
  </div>
</div>'
   	;
   }
   //cette fonctionpermet de charger les fichiers du lightbox
   function init_lightbox(){
   	
   }
   

    public function add_lightbox($imgminsource,$imgfullsource,$description,$id)
    {
    	
    	echo '<a data-toggle="lightbox" href="#'.$id.'" class="thumbnail">
					<img src="'.$imgsouce.'" alt="Click to view the lightbox">
				</a>';
    	
    	echo '        <div id="'.$id.'" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="lightbox-content">
        <img src="'.$imgfullsource.'">
        <div class="lightbox-caption"><p> '.$description.' </p></div>
        </div>
        </div>';
    }    
    
    
    

    //cette fonction permet d'afficher des messages de notifications de bootstap
    function notification($message,$type){
    	if (isset($type)){
    		echo '<div class="alert alert-'.$type.' alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
'.$message.'
</div>
';
    
    	}else {
    
    		echo '<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
'.$message.'
</div>
';
    
    	}
     
    }
    
    /* cette fonction permet d'afficher une progesse bar 
     * progess represente le pourcentage de progression
     * 
     * 
     */
    function progessbar($progress){
    	
    	echo '<div class="progress progress-striped active">
  <div class="progress-bar" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100"   style="width:'.$progress.'%" >
    '.$progress.'%
  </div>
</div>
    ';
    }
    
    
    function listegroupe($elements){
    	
    	echo '<ul class="list-group">';
    	foreach ($elements as $item)
    	echo '
  <li class="list-group-item"> '.$item.' </li>
    			
    			'	
    			;echo '
</ul>
    ';
    }
    
    
    function linklistegroupe($elements){
    	 
    	echo '<div class="list-group">';
    	foreach ($elements as $item)
    		if ($item['active']=='1'){
    		
    		echo '
    				  <a href="'.$item['lien'].'" class="list-group-item active">'.$item['contenu'].' </a>
    		
    		
    			';
    		
    	}else {
    		
    		echo '
    				  <a href="'.$item['lien'].'" class="list-group-item">'.$item['contenu'].' </a>
    				
    
    			';}
      		;echo '
</div>
    ';
    }
    
    function dropdowbuton($name,$element){
    	echo '<div class="dropdown">
  <button class="btn dropdown-toggle sr-only" type="button" id="'.$name.'" data-toggle="dropdown">
    '.$name.'
    <span class="caret"></span>
  </button>
    		
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    		';
    	foreach ($element as $item){
    		if ($item['contenu'] =='divider'){
    			echo '<li role="presentation" class="divider"></li>';
    		
    			
    		}else {
    		
    		echo '
    <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$item['lien'].'">'.$item['contenu'].'</a></li>';
    		
    		
    	}
    	echo ' </ul>
</div>';
    	
    	
    }
    
    
    
    
    }   
    
}










?>