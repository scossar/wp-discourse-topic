<?php

class WP_Discourse_Topic {

  /**
   * @var object
   * @access private
   * @since 0.0.1
   */
  protected static $instance = null;
  protected $meta_box;

  /**
   * Main plugin instance
   *
   * Ensures that only one instance of WP_Discourse_Topic is, or can be, loaded
   */
  public static function get_instance() {
    self::$instance === null && self::$instance = new self;

    return self::$instance;
  }

  public function __construct() {
    add_action('admin_enqueue_scripts', array($this, 'admin_styles'));
    add_action('wp_enqueue_scripts', array($this, 'discourse_styles'));
    add_action('admin_enqueue_scripts', array($this, 'admin_javascript'));
    add_action('wp_ajax_get_json', array($this, 'get_json'));
    add_action('wp_ajax_create_post', array($this, 'create_post'));
  }

  public function admin_styles() {
    wp_enqueue_style('admin-styles', plugins_url('../admin/css/admin-styles.css', __FILE__));
  }

  public function discourse_styles() {
    wp_enqueue_style('discourse-styles', plugins_url('css/discourse-topic-styles.css',  __FILE__));
  }

  public function admin_javascript($hook) { // $hook contains the name of the current admin page.
    if ($hook != 'post.php' && $hook != 'post-new.php') {
      return;
    }
    wp_enqueue_script('discourse-content', plugins_url('../admin/js/admin.js', __FILE__));
    // Values can be padded to 'discourse-content.js here and accessed there as properties
    // of 'ajax_object' ex. ajax_object.example_value // 'this is a test'
    wp_localize_script('discourse-content', 'ajax_object',
      array('example_value' => 'this is a test'));
  }


  protected function get_json() {
    $url = $_GET['url'];
    $topic_json = file_get_contents($url);
    echo $topic_json;
    wp_die();
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