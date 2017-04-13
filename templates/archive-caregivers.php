<?php 
/*
Template Name: Portfolio
*/
get_header(); ?>
 
  <div id="page">
 
    <ul id="filters">
        <?php
            $terms = get_terms("caregiver_category");
            $count = count($terms);
                echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
            if ( $count > 0 ){
 
                foreach ( $terms as $term ) {
 
                    $termname = strtolower($term->name);
                    $termname = str_replace(' ', '-', $termname);
                    echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'">'.$term->name.'</a></li>';
                }
            }
        ?>
    </ul>
 
    <div id="caregivers">
 
       <?php 
       $args = array( 'post_type' => 'caregivers', 'posts_per_page' => -1 );
       $loop = new WP_Query( $args );
       while ( $loop->have_posts() ) : $loop->the_post(); 
 
          $terms = get_the_terms( $post->ID, 'caregiver_category' );						
          if ( $terms && ! is_wp_error( $terms ) ) : 
 
              $links = array();
 
              foreach ( $terms as $term ) {
                  $links[] = $term->name;
              }
 
              $tax_links = join( " ", str_replace(' ', '-', $links));          
              $tax = strtolower($tax_links);
          else :	
	      $tax = '';					
          endif; 
 
          echo '<div class="all caregiver-item '. $tax .'">';
          echo '<a href="'. get_permalink() .'" title="'. the_title_attribute() .'">';
          echo '<div class="thumbnail">'. the_post_thumbnail() .'</div>';
          echo '</a>';
          echo '<h2>'. the_title() .'</h2>';
          echo '<div>'. the_excerpt() .'</div>';
          echo '</div>'; 
      endwhile; ?>
 
   </div><!-- #caregivers -->
 
  </div><!-- #page -->
 
<?php get_footer(); ?>
