<?php
/* This file contains main plugin class and, defines and plugin loader.
 *
 * Shorthand tools for viewing data in WP development.
 *
 * @package MZDEBUG
 *
 * Plugin Name: MZ Debug Tools
 * Description: 	Shorthand tools for viewing data in WP development
 * Version: 		1.0.0
 * Author: 			mZoo.org
 * Author URI: 		http://www.mZoo.org/
 * Plugin URI: 		http://www.mzoo.org/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 	mz-debug-tools
 * Domain Path: 	/languages
 * */

if ( ! function_exists( 'mZ_write_to_file' ) ) {
	/**
	 * Write message out to file
	 * @param  String/Array  $message		What we want to examine
	 * @param  String $file_path		A valid file path, default: file in WP_CONTENT_DIR
	 */

	function mZ_write_to_file($message, $file_path='')
	{
			$file_path = ( ($file_path == '') || !file_exists($file_path) ) ? WP_CONTENT_DIR . '/mbo_debug_log.txt' : $file_path;
			$header = date('l dS \o\f F Y h:i:s A', strtotime("now")) . " \nMessage:\t ";

			if (is_array($message)) {
					$header = "\nMessage is array.\n";
					$message = print_r($message, true);
			}
			$message .= "\n";
			file_put_contents(
					$file_path,
					$header . $message,
					FILE_APPEND | LOCK_EX
			);
	}
}

if ( ! function_exists( 'mz_pr' ) ) {
	/**
	 * Write message out to file
	 * @param  String/Array  $message		What we want to examine in browser
	 */
	function mz_pr($message) {
		echo "<pre>";
		print_r($message);
		echo "</pre>";
	}
}

add_shortcode('view-in-a-page', 'view_in_a_page');

function view_in_a_page() {

	// BOF Output for debugging CPT
// Does out Post Type exist?
foreach ( get_post_types( '', 'names' ) as $post_type ) {
   echo '<p>' . $post_type . '</p>';
}


//let's look at our CPT: 
$type = 'classes';   
$type_obj = get_post_type_object($type);
    mz_pr($type_obj);

    // Even if the archive page is working, we can see if our CPT is returning anything

$args=array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts'=> 1);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : 
    $my_query->the_post(); 
    ?>

    <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to         <?php the_title_attribute(); ?>"><?php the_title(); ?> </a></p>

    <?php

    endwhile;

} // list of yoga-event items
    // See what the CPT thinks the post archive link is (if anything)
mz_pr(get_post_type_archive_link( 'yoga-event' ));

//Format arrays for display in development
if ( ! function_exists( 'mz_pr' ) ) {
    function mz_pr($message) {
        echo "<pre>";
        print_r($message);
        echo "</pre>";
    }
}
    //EOF Output for debugging CPT 
	
	
	$type = 'keel-pets';
	$args=array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts'=> 1);

	$query = null;
	$query = new WP_Query($args);

			//mz_pr($query);
			/*
			// from https://wp-mix.com/view-all-wp-post-variables/
			global $wp_query;
var_dump($wp_query->query_vars);
echo var_export($GLOBALS['post'], TRUE);
*/
	if( $query->have_posts() ) {
			while ($query->have_posts()) :
			$query->the_post();

			?>
<?php
  global $post;
	// Variables
	$options = keel_pet_listings_get_theme_options(); // Pet Listings options
	$details = get_post_meta( $post->ID, 'keel_pet_listings_pet_details', true ); // Details for this pet
	$imgs = get_post_meta( $post->ID, 'keel_pet_listings_pet_imgs', true ); // Images for this pet
?>
<form><select name="">


</select></form>
<?php


?>
<?php if (get_the_title() == 'Duchess') : ?>
	<article class="container">

		<header>
			<h1 class="no-margin-bottom"><?php the_title(); ?></h1>
			<aside><p><a href="<?php echo get_post_type_archive_link( 'keel-pets' ); ?>">&larr; <?php _e( 'Back to All Pets', 'keel' ); ?></a></p></aside>
		</header>

		<?php
			// Pet images
			if ( !empty( $imgs ) ) {
				echo $imgs;
			}
		?>

		<?php
			// Key pet info
		?>
		<ul class="list-unstyled">
			<li><strong><?php _e( 'Size', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['size'] ); ?></li>
			<li><strong><?php _e( 'Age', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['age'] ); ?></li>
			<li><strong><?php _e( 'Gender', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['gender'] ); ?></li>
			<li><strong><?php _e( 'Breeds', 'keel' ); ?>:</strong> <?php echo esc_attr( $details['breeds'] ); ?></li>
			<?php echo ( empty( $details['options']['multi'] ) ? '' : '<li><em>' . esc_attr( $details['options']['multi'] ) . '</em></li>' ); ?>
			<?php echo ( empty( $details['options']['special_needs'] ) ? '' : '<li><em>' . esc_attr( $details['options']['special_needs'] ) . '</em></li>' ); ?>
		</ul>

		<?php
			// Adoption application button
			echo ( $options['adoption_form_url'] ? '<p><a class="btn" href="' . esc_url( $options['adoption_form_url'] ) . '">' . esc_attr( $options['adoption_form_text'] ) . '</a></p>' : '' );
		?>

		<?php
			// The page or post content
			the_content( '<p>' . __( 'Read More...', 'keel' ) . '</p>' );
		?>

	</article>

  <?php endif; ?>

    <?php

    endwhile;

	}
	wp_reset_postdata();
}
?>
