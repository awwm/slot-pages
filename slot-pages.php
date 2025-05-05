<?php
/**
 * Plugin Name: Slot Pages
 * Plugin URI: https://github.com/awwm/slot-pages
 * Description: This plugin provides a user-friendly way to manage and display slot information.
 * Author: Abdul Wahab
 * Author URI: https://www.linkedin.com/in/abdulwahabpk/
 * Version: 1.0.0
 * Text Domain: slot-pages
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin directory constants
define( 'SLOT_PAGES_DIR', plugin_dir_path( __FILE__ ) );
define( 'SLOT_PAGES_URL', plugin_dir_url( __FILE__ ) );

class Slot_Pages_Plugin {
    public function __construct() {
        $this->includes();
        $this->hooks();
    }

    private function includes() {
        require_once SLOT_PAGES_DIR . 'includes/custom-fields.php';
        require_once SLOT_PAGES_DIR . 'includes/admin-columns.php';
        require_once SLOT_PAGES_DIR . 'includes/blocks-loader.php';
    }

    private function hooks() {
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    }

    public function activate() {
        // Plugin activation actions, e.g., flush rewrite rules.
        flush_rewrite_rules();
    }

    public function deactivate() {
        // Plugin deactivation actions, e.g., flush rewrite rules.
        flush_rewrite_rules();
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'slot-pages-styles', SLOT_PAGES_URL . 'css/slots-pages.css', [], '1.0.0' );
    }
}

new Slot_Pages_Plugin();