<?php
/**
 * Min - Minimal WordPress Theme
 *
 * @author      Clivern <hello@clivern.com>
 * @copyright   2014 Clivern
 * @link        http://clivern.com
 * @license     GPL
 * @version     1.0
 * @package     Min
 */

class Kudos
{
	private $hash = "c787yj07szvtghku18lom2ad2crf82v";

	public function init()
	{
		add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue') );
		add_action( 'wp_print_footer_scripts', array(&$this, 'printFooter') );
		add_action( 'wp_footer', array(&$this, 'render') );
		add_action( 'wp_print_scripts', array(&$this, 'printHeader') );
		add_action( 'wp_ajax_kudos_action', array(&$this, 'kudosAction') );
		add_action( 'wp_ajax_nopriv_kudos_action', array(&$this, 'kudosAction') );		
	}

	public function kudosAction()
	{
            $response = array(
                  'status' => 'error',
                  'data' => array()
            );
            $action = ( (isset($_POST['action'])) && ($_POST['action'] == 'kudos_action') ) ? $_POST['action'] : false;
            $hash = ( (isset($_POST['hash'])) && ($_POST['hash'] == $this->hash) ) ? $_POST['hash'] : false;
            $post_id = ( (isset($_POST['post_id'])) && (filter_var($_POST['post_id'], FILTER_VALIDATE_INT)) ) ? filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT) : false;
    		$direction = ( (isset($_POST['direc'])) && (in_array($_POST['direc'], array('up', 'down'))) ) ? filter_var($_POST['direc'], FILTER_SANITIZE_STRING) : false;

            if( ($action == false) || ($hash == false) || ($post_id == false) || !($post_id > 0) || ($direction == false) ){
            	header('Content: application/json');
            	echo json_encode($response);
            	die;
      	}
		$post_kudos = get_post_meta( $post_id, 'post_kudos', true );
		if( ($post_kudos === false) || ($post_kudos === '') ){
			$post_kudos = 0;
		}
		if($direction == 'up'){
			$post_kudos = ((int) $post_kudos) + 1;
		}
		if($direction == 'down'){
			$post_kudos = ((int) $post_kudos) - 1;
		}
		update_post_meta( $post_id, 'post_kudos', $post_kudos);
		if($direction == 'up'){
			setcookie('kudos_' . $post_id, 'tybg', time() + (7 * 24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
		}
		if($direction == 'down'){
			setcookie('kudos_' . $post_id, '', time() - 5, COOKIEPATH, COOKIE_DOMAIN);
		}

		$response['status'] = 'success';
            header('Content: application/json');
            echo json_encode($response);
            die;
	}

	public function enqueue()
	{
		if(is_single()){
			//wp_enqueue_style( 'min-kudos-css', get_template_directory_uri() . '/assets/css/kudos.css', array(), '1.0');
			//wp_enqueue_script( 'min-kudos-js', get_template_directory_uri() . '/assets/js/kudos.js', array('jquery'), '1.0', true );
		}
	}

	public function printHeader()
	{
		if(is_single()){
		?>
		<script type="text/javascript">var kudos_auth = {"ajaxurl": "<?php echo esc_js(admin_url('admin-ajax.php')); ?>","action" : "kudos_action", "hash" : "<?php echo esc_js($this->hash); ?>"};</script>
		<?php
		}
	}

	public function printFooter()
	{
		global $post;
		if(is_single()){
		?>
		<script type="text/javascript">
			var postId = <?php echo $post->ID; ?>; 
			jQuery( document ).ready(function($) {
  				var scrollTimeout2;
  				$(window).scroll(function(){
      				clearTimeout(scrollTimeout2);
      				if($(window).scrollTop() > 640){
      					scrollTimeout2 = setTimeout(function(){$('figure.kudo:hidden').fadeIn();},100);
      				}else{
          					scrollTimeout2 = setTimeout(function(){$('figure.kudo:visible').fadeOut();},100);
      				}
  				});
				$("figure.kudoable").kudoable();
				<?php if ( (isset($_COOKIE['kudos_' . $post->ID])) && ($_COOKIE['kudos_' . $post->ID] == 'tybg') ) { ?>
					// make kudo already kudod
					$("figure.kudoable").removeClass("animate").addClass("complete");
				<?php } ?>
				$("figure.kudo").bind("kudo:added", function(e)
				{
					var element = $(this);
					$.post(kudos_auth.ajaxurl, {action : kudos_auth.action,hash : kudos_auth.hash,post_id : '<?php echo $post->ID; ?>', direc : 'up'}, function( response, textStatus, jqXHR ){ }, 'json');
					
				});
				$("figure.kudo").bind("kudo:removed", function(e)
				{
					var element = $(this);
					$.post(kudos_auth.ajaxurl, {action : kudos_auth.action,hash : kudos_auth.hash,post_id : '<?php echo $post->ID; ?>', direc : 'down'}, function( response, textStatus, jqXHR ){ }, 'json');
				});
			});
		</script>
		<?php
		}
	}

	public function render()
	{
		global $post;
		if(is_single()){
		$post_kudos = get_post_meta( $post->ID, 'post_kudos', true );
		if( ($post_kudos === false) || ($post_kudos === '') ){
			$post_kudos = 0;
			update_post_meta( $post->ID, 'post_kudos', 0);
		}
		?>
		<figure class="kudo kudoable" data-id="1" style="display:none">
			<a class="kudobject">
				<div class="opening"><div class="circle">&nbsp;</div></div>
			</a>
			<a href="#kudo" class="count">
				<span class="num"><?php echo (int) $post_kudos; ?></span>
				<span class="txt">Kudos</span>
			</a>
		</figure>
		<?php
		}
	}	
}
$Kudos = new Kudos();
$Kudos->init();