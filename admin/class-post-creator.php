<?php

/**
 * Handles an ajax request to create a new post
 */

class Post_Creator{
  public function __construct() {
    add_action('wp_ajax_create_post', array($this, 'create_post'));
  }

  protected function create_post() {
    $post_data = array(
      'post_content' => $_POST['content'],
      'post_name' => $_POST['slug'],
      'post_title' => $_POST['title'],
      'post_status' => $_POST['post_status'],
      'post_type' => $_POST['post_type'],
    );
    if (array_key_exists('category', $_POST)) {
      $post_data['post_category'] = $_POST['category'];
    }
    $new_post_ID = wp_insert_post($post_data);
    add_metadata('post', $new_post_ID, 'discourse_order', $_POST['order']);
    wp_die();
  }

}