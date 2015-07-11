<?php

/**
 * Handles an ajax request.
 */

class JSON_Loader {

  public function __construct($url_key) {
    add_action('wp_ajax_get_json', array($this, 'get_json'));
  }

  protected function get_json() {
    $url = $_GET['url'];
    $topic_json = file_get_contents($url);
    echo $topic_json;
    wp_die();
  }
}