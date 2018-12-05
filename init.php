<?php 
/*
Plugin Name:  HelpNinja
Plugin URI:   http://helpninja.com/
Description:  With your whole team on board, the answer to any complex query is just                       a mention away
version:      1.0.1
Author:       Ragupathi
Author URI:   https://github.com/rrpathi
*/
if ( ! defined( 'WPINC' ) ) {
    die;
}

class WP_Helpninja{
	 public function __construct(){
        $this->init();
    }
	public function init(){
		$this->constants();
		$this->hooks();
		$this->add_action();
	}

	public function constants(){
        define( 'WP_HELPNINJA_SHORTCODE', 'ninja_form' );
        define( 'WP_HELPNINJA_REMOTE_URL', 'https://webhook.site/48cf5c58-7619-405a-ab41-16312132e770' );
        define( 'WP_HELPNINJA_SCRIPT_URL', 'https://static.optinchat.com/optinchat.js' );
        define( 'WP_HELPNINJA_SCRIPT_ID', 'oc_script' );
        define( 'WP_HELPNINJA_BEACON_ID', get_option('ninja_beacon_id'));
        define('WP_HELPNINJA_PLUGIN_DIR_URL',plugin_dir_url(__FILE__));
        define('WP_HELPNINJA_PLUGIN_DIR_PATH',plugin_dir_path(__FILE__));
	}
	public function hooks(){
        // require_once WP_HELPNINJA_PLUGIN_DIR_PATH . '/includes/core.php';
        register_activation_hook(__FILE__,array($this,'activation'));
        register_deactivation_hook(__FILE__,array($this,'deactivation'));
        add_shortcode(WP_HELPNINJA_SHORTCODE,array($this,'wp_ninja_contact_form'));

    }

     public function activation(){
        add_option('ninja_beacon_id','');
        add_option('ninja_beacon_enable','0');
    }

    public function deactivation(){
        delete_option('ninja_beacon_id');
        delete_option('ninja_beacon_enable');
    }

    public function add_action(){
    	add_action('init',array($this,'wp_send_ninja_contact_values'));
        add_action('admin_menu',array($this,'wp_ninja_options'));
        add_action('wp_head',array($this,'wp_ninja_custom_js'));
        add_action('admin_enqueue_scripts',array($this,'script'));
        add_action('wp_ajax_update_beacon_values',array($this,'wp_update_beacon_values'));
    }

    public  function wp_ninja_options(){
        add_options_page('HelpNinja Setting', 'HelpNinja', 'manage_options', 'help-ninja-setting',array($this,'wp_help_ninja_setting'));
    }

    public function wp_help_ninja_setting(){ 
        require_once WP_HELPNINJA_PLUGIN_DIR_PATH.'admin/view/ninja_setting_form.php';
     }
    public function script(){
        add_action('wp_head',array($this,'wp_ninja_custom_js'));
    	wp_enqueue_script('jquery');
        wp_enqueue_script('setting-js',WP_HELPNINJA_PLUGIN_DIR_URL.'admin/js/setting.js');
    } 

    public function wp_update_beacon_values(){
    	update_option('ninja_beacon_enable',$_POST['beacon_enable']);
        update_option('ninja_beacon_id',$_POST['beaconId']);
        $i = 1;
        if($i==1){
            add_action('admin_notices',array($this,'admin_notice_success'));
            echo json_encode(array('status'=>'1'));
            wp_die();
        }
    }

    public function wp_ninja_custom_js(){
        if(get_option( 'ninja_beacon_enable')=='1'){
            echo '<script src='.WP_HELPNINJA_SCRIPT_URL.' id='.WP_HELPNINJA_SCRIPT_ID.' convid='.WP_HELPNINJA_BEACON_ID.'></script>';
        }
    }
    public function wp_send_ninja_contact_values(){
        if(isset($_POST['send_ninja'])){
           $json_value = array( 'email' => $_POST['ninja_email'], 'message' => $_POST['ninja_message'],'beaconId'=>WP_HELPNINJA_BEACON_ID); 
        $response = wp_remote_post(WP_HELPNINJA_REMOTE_URL, array(
        'method' => 'POST',
        'headers'   => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' =>  json_encode($json_value)));
        header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public function wp_ninja_contact_form(){
    	 $result = "Email:<input type='email' name='ninja_email'>"."<br />";
        $result .="Message:<textarea name='ninja_message'></textarea>"."<br />";
        ob_start();
        echo "<form action='#' method='POST' >
        $result.<br /><input type='submit' name='send_ninja'>
        </form>";
        return ob_get_clean();
    	
	}


}
$obj = new WP_Helpninja();
// class helpNinja{
// 	public $ninja_short_code = 'ninja_form';
// 	public $ninja_url = 'http://localhost/ninja_remote/';
// 	function __construct(){
// 		$this->initial();
// 	}
// 	function initial(){
// 		$this->ninjaShortcode();
// 		$this->ninjaAction();
// 	}

// 	function ninjaShortcode(){
// 		add_shortcode($this->ninja_short_code,array($this,'ninja_contact_form'));
// 	}

// 	function ninja_contact_form(){
// 		$result = "Email:<input type='email' name='ninja_email'>"."<br />";
// 		$result .="Message:<textarea name='ninja_message'></textarea>"."<br />";
// 		ob_start();
// 		echo "<form action='#' method='POST' >
// 		$result.<br /><input type='submit' name='send_ninja'>
// 		</form>";
// 		return ob_get_clean();
// 	}

// 	function ninjaAction(){
// 		add_action('init',array($this,'send_ninja_values'));
// 	}

// 	function send_ninja_values(){
// 		if(isset($_POST['send_ninja'])){
// 		$response = wp_remote_post( $this->ninja_url, array(
// 		'method' => 'POST',
// 		'body' => array( 'email' => $_POST['ninja_email'], 'message' => $_POST['ninja_message'],'beaconId'=>'Hello')));
// 		}
// 	}


// }

// $obj = new helpNinja();


// ?>