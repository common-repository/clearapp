<?php 
/* 
  A php class to allow the adding of a sidebar widget (for the login and user details)
  
  Note that the widget will output exactly the same content as <?php fb_og_put_sidebar(); ?>
*/

// Helpers
require_once("helpers.php");

// The FB sidebar widget
class Clearapp_Sidebar_Widget extends WP_Widget {

  function __construct() {

    // Create widget
    parent::__construct(
      'clearapp-sidebar', 
      __('Clearapp', 
      'clearapp-sidebar-widget'), 
      array(
        'classname' => 'widget_clearapp_sidebar', 
        'description' => __('Use this to run apps from Clearapp in your sidebar.', 'clearapp-sidebar-widget')
      )
    );

    // Add helpers
    $this->helpers = new Clearapp_Helpers;

  }

  function update($new_instance, $old_instance) {
    $instance = array();
    $instance['app'] = ( ! empty( $new_instance['app'] ) ) ? strip_tags( $new_instance['app'] ) : '';
    return $instance;
  }

  function widget($args, $instance) { 
    $attributes = $instance;
    $attributes["id"] = "sidebar";
    echo $this->helpers->generate_wrapper_div($attributes);
  }

  public function form( $instance ) {
    $app = (isset($instance["app"])) ? $instance["app"] : "";
    include(CLEARAPP_PLUGIN_PATH . "views/sidebar-admin.php");
  }

}