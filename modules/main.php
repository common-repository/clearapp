<?php


// Data layer
require_once(CLEARAPP_PLUGIN_PATH . "lib/data_layer/data_layer.php");

// Helpers
require_once("helpers.php");

// Sidebar widgets
require_once("widget.php");

// API
require_once("api.php");



class Clearapp_Main {

    /**
     * Construct.
     *
     */
    public function __construct() {

        $this->models = array(
            "data_layer" =>  new Wordpress_Data_Layer_Model
        );

        $this->helpers = new Clearapp_Helpers;

        $this->api = new Clearapp_API;

        // Load scripts in front-end.
        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 999 );

        // Add the Clearapp container and data layer
        add_action( 'wp_head', array($this, 'add_container_and_data_layer'));

        // Create admin menu
        add_action( 'admin_menu', array($this, 'admin_create_menu'));

        // Setup shortcodes for wrappers
        add_shortcode('clearapp', array($this, "setup_shortcode"));

        // Add sidebar widgets
        add_action('widgets_init', array($this, 'setup_sidebar_widget'));

        // Add pre/post wrappers to the_content()
        add_filter('the_content', array($this, 'add_pre_post_wrappers'));

        // Show admin CSS
        add_action( 'admin_enqueue_scripts', array($this, "admin_enqueue") );

        // Get ajax to work front end
        add_action( 'wp_ajax_clearapp_ajax_hook', array($this->api, 'handler'));
        add_action( 'wp_ajax_nopriv_clearapp_ajax_hook', array($this->api, 'handler')); // need this to serve non logged in users
    }

    /**
     * Ensure jquery is loaded.
     *
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_localize_script( 'jquery', 'clearapp_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    /**
     * Load code into the head. (should be after enqueue_scripts i.e. jQuery has loaded)
     *
     */
    public function add_container_and_data_layer() {
        $data_layer = $this->models["data_layer"]->get();
        $container_id = get_option("clearapp_container_id");
        include(CLEARAPP_PLUGIN_PATH."views/head.php");
    }


    /**
     * Setup the shortcodes, to be used in posts and pages. Used for 
     * adding the Clearapp div wrappers for in-page content
     *
     */
    public function setup_shortcode($attributes) {
        return $this->helpers->generate_wrapper_div($attributes);
    }

    public function setup_sidebar_widget() {
        if ( !is_blog_installed() ) return;
        register_widget('Clearapp_Sidebar_Widget');
    }

    /**
     * Setup the shortcodes, to be used in posts and pages. Used for 
     * adding the Clearapp div wrappers for in-page content
     *
     */
    public function add_pre_post_wrappers($content) {
        $pre_html = $this->helpers->generate_wrapper_div(array(
            "app" => "pre-content"
        ));
        $post_html = $this->helpers->generate_wrapper_div(array(
            "app" => "post-content"
        ));
        return $pre_html . $content . $post_html;
    }


    /**
     * Add settings menu
     *
     */
    public function admin_create_menu() {
        add_menu_page("", "Clearapp", 'administrator', 'clearapp', array($this, 'admin_settings'), CLEARAPP_PLUGIN_URL.'assets/images/favicon.ico'); 
    }

    /**
     * The settings page
     *
     */
    public function admin_settings() {
        if (!empty($_POST) and $_POST["action"] == "update" and $_POST["clearapp_container_id"]) {
            update_option("clearapp_container_id", $_POST["clearapp_container_id"]);
            $updated = true;
        }
        if (get_option("clearapp_container_id")) {
            $installed = true;
        } else {
            $installed = false;
        }
        include(CLEARAPP_PLUGIN_PATH."views/admin.php");
    }

    /**
     *
     *
     */
    public function admin_enqueue() {
        if (isset($_GET["page"]) and $_GET["page"] === "clearapp") {
            wp_enqueue_script( 'clearapp_admin_js', CLEARAPP_PLUGIN_URL . 'assets/js/admin.js', 'jquery' );
            wp_register_style( 'clearapp_admin_css', CLEARAPP_PLUGIN_URL . 'assets/css/admin-style.css', false, '1.0.0' );
            wp_enqueue_style( 'clearapp_admin_css' );
        }
    }

    /**
     * Register the form options
     *
     */
    public function admin_register_settings() {
        register_setting( 'clearapp-settings-group', 'clearapp_container_id' );
    }

}
