<?php

/**
 * Adds a meta-box to an admin page.
 */

class Meta_Box {

  protected $id;
  protected $title;
  protected $screen;
  protected $context;
  protected $priority;
  protected $template;
  protected $nonce_name;

  public function __construct($args) {
    add_action('add_meta_boxes', array($this, 'add_meta_box'));

    $this->id = $args['id'];
    $this->title = $args['title'];
    $this->screen = $args['screen'];
    $this->context = $args['context'];
    $this->priority = $args['priority'];
    $this->template = $args['template'];
    $this->nonce_name = $this->dashes_to_underscores($this->id);
  }

  public function add_meta_box($args) {
    add_meta_box(
      $this->id,
      $this->title,
      array($this, 'render_meta_box'),
      $this->screen,
      $this->context,
      $this->priority
    );
  }

  public function render_meta_box() {
    wp_nonce_field($this->nonce_name);
    echo $this->template;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_title() {
    return $this->title;
  }

  private function dashes_to_underscores($str) {
    return str_replace('-', '_', $str);
  }
}

