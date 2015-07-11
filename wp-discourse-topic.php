<?php

/**
 * Plugin Name: WP Discourse Topic
 * Author: scossar
 * Text Domain: wp-discourse-topic
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

require plugin_dir_path(__FILE__) . 'admin/class-meta-box.php';

$input_form = <<<HTML
    <div id="discourse-message"></div>
    <div class="loading"></div>
    <label for="discourse-url">URL:</label>
    <input type="text" id="discourse-url" name="discourse-url"/>
    <button id="get-topic">Fetch Discourse Topic</button>
    <div class="topic-posts"></div>
HTML;

$meta = array(
  'id' => 'discourse-fetch',
  'title' => 'Load Discourse Topic',
  'screen' => 'post',
  'context' => 'advanced',
  'priority' => 'default',
  'template' => $input_form
);

require plugin_dir_path(__FILE__) . 'includes/class-wp-discourse-topic.php';

$plugin = WP_Discourse_Topic::get_instance();
$discourse_url_input = new Meta_Box($meta);

