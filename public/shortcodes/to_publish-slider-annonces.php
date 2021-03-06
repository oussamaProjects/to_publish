<?php

add_shortcode( 'slider_annonces', 'to_publish_slider_annonces' );
function to_publish_slider_annonces( $atts ){
  global $post;
  $default = array(
    'type'      => 'post',
    'post_type' => 'annonce',
    'limit'     => 12,
    'status'    => 'publish'
  );
  $r = shortcode_atts( $default, $atts );
  extract( $r );

  if( empty($post_type) )
    $post_type = $type;

  $post_type_ob = get_post_type_object( $post_type );
  if( !$post_type_ob )
    return '<div class="warning"><p>No such post type <em>' . $post_type . '</em> found.</p></div>';


  $args = array(
    'post_type'   => $post_type,
    'numberposts' => $limit,
    'post_status' => $status,
  );
  
  $posts = get_posts( $args );
  if( count($posts) ):
    $return .= '<section>';
    $return .= '<div class="container">';
    $return .= '<div class="row">';
    $return .= '<div class="col-md-12">';
    $return .= '<div class="section_title">';
    $return .= '<div class="div">'. __("New","to_publish") .'</div>';
    $return .= '</div>';
    $return .= '<div class="section_sousTitle">';
    $return .= __("Check out the latest ads","to_publish");
    $return .= '</div>';
    $return .= '<div id="annoces_slider" class="annoces_slider owl-carousel owl-theme"> ';


    foreach( $posts as $post ): setup_postdata( $post );
      
      $image = '';
      $bedrooms  	= get_post_meta( get_the_ID(), 'submitted_bedrooms', true );
      $bathrooms  = get_post_meta( get_the_ID(), 'submitted_bathrooms', true );
      $surface  	= get_post_meta( get_the_ID(), 'submitted_surface', true );
      $price  	  = get_post_meta( get_the_ID(), 'submitted_price', true );

      $return .= '<div class="annoce_container items">';
        $return .= '<a href="' . get_the_permalink() .'" title="'. esc_attr( get_the_title() ) .'">';
          $return .= '<div class="annoce">';
          
          $images = get_post_meta( get_the_ID(), 'submitted_slides', true );  
          if($images)
            $return .= '<img src="' . esc_attr($images[0][ 'submitted_images' ]) . '" alt="" />';
            else 
              $return .= '<img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'img/ads.jpg" alt="" />';
        
            $return .= '<div class="hover"></div>';
          $return .= '</div>';
          $return .= '<div class="info_container">';
            $return .= '<div class="titre">'. get_the_title() .'</div>';
            $return .= '<div class="info">';
                            
              if( $bedrooms ): 
                $return .= '<div class="rooms">';
                $return .= '<i class="fas fa-bed"></i>';
                $return .= '<span>' . $bedrooms . '</span>';
                $return .= ' </div>';
              endif;

              if( $bathrooms ):
                $return .= '<div class="bathrooms">';
                $return .= '<i class="fas fa-shower"></i>';
                $return .= '<span>' . $bathrooms . '</span>';
                $return .= '</div>';
              endif; 

              if( $surface ):
                $return .= '<div class="surface">';
                $return .= '<img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'img/svg/superficie.svg" alt="">';
                $return .= '<span>' . $surface  .' m<sup>2</sup></span>';
                $return .= '</div>';
              endif; 

            $return .= '</div>';
  
              $return .= '<div class="excerpt">'; 
              $return .= get_the_excerpt();
              $return .= '</div>';

            if( $price ):
              $return .= '<div class="price">' . __("Price : ", "to_publish") . number_format_int($price) . ' Dhs</div>';  
            endif;  
          
          $return .= '</div>';
        $return .= '</a>';
      $return .= '</div>';

    endforeach; wp_reset_postdata();

    $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '</section>';

  else :
    $return .= '<p>' . __("No posts found.", "to_publish") .'</p>';
  endif;

  

  return $return;
}
