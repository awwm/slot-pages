<?php
/**
 * Blocks Loader Class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Slot_Pages_Blocks_Loader {

    public function __construct() {
        add_action( 'init', [ $this, 'register_blocks' ] );
    }

    public function register_blocks() {
        // Register Slots Grid Block
        wp_register_script(
            'slots-grid-block',
            SLOT_PAGES_URL . 'src/slots-grid.js',
            [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ],
            '1.0.0',
            true
        );

        register_block_type( 'slot-pages/slots-grid', [
            'editor_script' => 'slots-grid-block',
            'render_callback' => [ $this, 'render_slots_grid' ],
        ] );

        // Register Slot Detail Block
        wp_register_script(
            'slot-detail-block',
            SLOT_PAGES_URL . 'src/slot-detail.js',
            [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ],
            '1.0.0',
            true
        );

        register_block_type( 'slot-pages/slot-detail', [
            'editor_script' => 'slot-detail-block',
            'render_callback' => [ $this, 'render_slot_detail' ],
        ] );
    }

    public function render_slots_grid( $attributes ) {
        ob_start();
        include SLOT_PAGES_DIR . 'templates/slots-grid-template.php';
        return ob_get_clean();
    }

    public function render_slot_detail( $attributes ) {
        ob_start();
        include SLOT_PAGES_DIR . 'templates/slot-detail-template.php';
        return ob_get_clean();
    }
}

new Slot_Pages_Blocks_Loader();
