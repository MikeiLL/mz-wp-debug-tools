<?php
get_header();

echo get_post_meta($post->ID, "_hobbies", true);
echo get_post_meta($post->ID, "_specializations", true); 

get_footer();
?>