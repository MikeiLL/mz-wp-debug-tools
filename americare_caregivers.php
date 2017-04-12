<?php
use lexweb\AMERICARE;
/* This file contains main plugin class and, defines and plugin loader.
 *
 * Match caregivers with clients based on specific criteris using Isotope.
 *
 * @package LWDCAREGIVER
 *
 * Plugin Name: Caregiver Match
 * Description: 	Match caregivers with clients based on specific criteris using Isotope
 * Version: 		1.0.0
 * Author: 			LexWebDev.com
 * Author URI: 		http://www.lexwebdev.com
 * Plugin URI: 		http://www.lexwebdev.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 	americareny
 * Domain Path: 	/languages
 * */

if ( !defined( 'WPINC' ) ) {
    die;
}

require __DIR__ . "/src/Autoload.php";
spl_autoload_register( [ new Loader\Autoload( 'lexweb', __DIR__ . '/src/' ), 'load' ] );

add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'register_post_type' ), 0 );
add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'register_tags' ), 0 );
add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'register_categories' ), 0 );
add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'edit_columns' ), 0 );
add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'custom_display' ), 0 );
add_action( 'init', array( 'lexweb\\AMERICARE\\LWD_Caregivers', 'tax_filters' ), 0 );

?>
