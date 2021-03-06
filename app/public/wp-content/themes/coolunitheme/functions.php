<?php
  
  function cool_uni_resources() {
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);}
    wp_enqueue_style('roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i"');
    wp_enqueue_style('styles', get_theme_file_uri('./build/style-index.css'));
    wp_enqueue_style('additional-styles', get_theme_file_uri('./build/index.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  add_action('wp_enqueue_scripts', 'cool_uni_resources');

  function universityFeatures() {
    add_theme_support('title_tag');
  }
 
  add_action('after_setup_theme', 'universityFeatures');
  
  function queryAdjust($query) {
    if(!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
      $query->set('orderby', 'title');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', -1);
    }

    if(!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
      $today = date('Ymd');
      $query->set('meta_key', 'event_date');
      $query->set('orderby', 'meta_value_num');
      $query->set('order', 'ASC');
      $query->set('meta_query', array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      ));
    }
  } 

  add_action('pre_get_posts', 'queryAdjust');
?>