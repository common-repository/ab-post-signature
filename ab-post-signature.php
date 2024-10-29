<?php

/*
   Plugin Name: AB Post Signature
   Plugin URI: http://aleksandar.bjelosevic.info/abpostsignature
   Description: Plugin allows you to add a signature after every post
   Version: 1.00
   Author: Aleksandar Bjelosevic
   Author URI: http://aleksandar.bjelosevic.info
   License: GPL2
   */

  add_action( 'admin_menu', 'ab_post_sig_menu' );
  add_action( 'admin_init', 'update_ab_post_signature_info' );
  
  function ab_post_sig_menu(){
  
    $page_title = 'AB Post Signature';
    $menu_title = 'AB Post Signature';
    $capability = 'manage_options';
    $menu_slug  = 'ab-post-signature';
    $function   = 'ab_post_signature_info_page';
    $icon_url   = 'dashicons-portfolio';
    $position   = 4;
  
    add_menu_page( $page_title,
                   $menu_title, 
                   $capability, 
                   $menu_slug, 
                   $function, 
                   $icon_url, 
                   $position );
  }
  function ab_post_signature_info_page(){
    ?>  
      <h1>AB Post Signature plugin</h1>
      <form method='post'>
      <?php
          wp_nonce_field('ab_nonce_action', 'ab_nonce_field');

          $content = get_option('ab_post_signature_msg');
          $remowe_quotes=wp_kses_post($content);
          wp_editor( $remowe_quotes, 'ab_post_signature_msg' );

          submit_button('Save', 'primary');
     ?>
   </form>
    
    <?php
    }

    function ab_post__after_post_content($content){
        if (is_single()) {  
           // $remowe_quotes=stripslashes(get_option( 'ab_post_signature_msg' ));
            $remowe_quotes=wp_kses_post(get_option( 'ab_post_signature_msg' )) ;
            $content .= $remowe_quotes;
            }
                return $content;
            }

      function update_ab_post_signature_info(){
              // check the nonce, update the option etc...
        if( isset($_POST['ab_nonce_field']) && 
            check_admin_referer('ab_nonce_action', 'ab_nonce_field')){
            
            if(isset($_POST['ab_post_signature_msg'])){

                //security input
                $value=wp_filter_post_kses($_POST['ab_post_signature_msg']);



               update_option('ab_post_signature_msg', $value);
              }
            }
            }
            


    add_filter( "the_content", "ab_post__after_post_content" );    
?>