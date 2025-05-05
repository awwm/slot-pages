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
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_assets' ] ); 
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
        wp_enqueue_style( 
            'slot-pages-styles', // Handle plugin styles
            SLOT_PAGES_URL . 'css/slots-pages.css', [], 
            '1.0.0' // Version
        );
    }

    // Function to enqueue block scripts for the block editor
    public function enqueue_block_assets() {
        wp_enqueue_script(
            'slot-pages-blocks',  // Handle for the block script
            SLOT_PAGES_URL . 'build/index.js', // Path to the compiled JavaScript
            [ 'wp-blocks', 'wp-element', 'wp-editor' ], // Dependencies
            filemtime( SLOT_PAGES_DIR . 'build/index.js' ), // Versioning based on file modification time
            true // Load in footer
        );

        wp_enqueue_style(
            'slot-pages-blocks-editor-style',  // Handle for block editor styles
            SLOT_PAGES_URL . 'css/blocks-editor-style.css', // Block editor CSS (optional)
            [],
            '1.0.0'  // Version
        );
    }
}

new Slot_Pages_Plugin();