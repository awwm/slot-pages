<?php
// includes/custom-fields.php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Slot_Pages_Custom_Fields {

    public function __construct() {
        add_action( 'init', [ $this, 'register_custom_post_type' ] );
        add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
        //add_filter( 'use_block_editor_for_post_type', [ $this, 'disable_gutenberg_for_slots' ], 10, 2 );
    }

    public function register_custom_post_type() {
        $labels = [
            'name' => __( 'Slots', 'slot-pages' ),
            'singular_name' => __( 'Slot', 'slot-pages' ),
            'add_new' => __( 'Add New Slot', 'slot-pages' ),
            'add_new_item' => __( 'Add New Slot', 'slot-pages' ),
            'edit_item' => __( 'Edit Slot', 'slot-pages' ),
            'new_item' => __( 'New Slot', 'slot-pages' ),
            'view_item' => __( 'View Slot', 'slot-pages' ),
            'search_items' => __( 'Search Slots', 'slot-pages' ),
            'not_found' => __( 'No slots found', 'slot-pages' ),
        ];

        $args = [
            'label' => __( 'Slots', 'slot-pages' ),
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'supports' => [ 'title', 'thumbnail' ],
            'rewrite' => [ 'slug' => 'slots' ],
            'show_in_rest' => true,
        ];

        register_post_type( 'slot', $args );
    }

    public function register_meta_boxes() {
        add_meta_box( 'slot_details', __( 'Slot Details', 'slot-pages' ), [ $this, 'render_meta_box' ], 'slot', 'normal', 'default' );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'save_slot_details', 'slot_details_nonce' );

        $description = get_post_meta( $post->ID, '_slot_description', true );
        $star_rating = get_post_meta( $post->ID, '_slot_star_rating', true );
        $provider = get_post_meta( $post->ID, '_slot_provider', true );
        $rtp = get_post_meta( $post->ID, '_slot_rtp', true );
        $min_wager = get_post_meta( $post->ID, '_slot_min_wager', true );
        $max_wager = get_post_meta( $post->ID, '_slot_max_wager', true );

        echo '<p><label>' . __( 'Description', 'slot-pages' ) . '</label><br />';
        echo '<textarea name="slot_description" rows="4" style="width:100%">' . esc_textarea( $description ) . '</textarea></p>';

        echo '<p><label>' . __( 'Star Rating (1-5)', 'slot-pages' ) . '</label><br />';
        echo '<input type="number" name="slot_star_rating" value="' . esc_attr( $star_rating ) . '" min="1" max="5" /></p>';

        echo '<p><label>' . __( 'Provider Name', 'slot-pages' ) . '</label><br />';
        echo '<input type="text" name="slot_provider" value="' . esc_attr( $provider ) . '" /></p>';

        echo '<p><label>' . __( 'RTP (%)', 'slot-pages' ) . '</label><br />';
        echo '<input type="text" name="slot_rtp" value="' . esc_attr( $rtp ) . '" /></p>';

        echo '<p><label>' . __( 'Minimum Wager', 'slot-pages' ) . '</label><br />';
        echo '<input type="number" name="slot_min_wager" value="' . esc_attr( $min_wager ) . '" step="0.01" /></p>';

        echo '<p><label>' . __( 'Maximum Wager', 'slot-pages' ) . '</label><br />';
        echo '<input type="number" name="slot_max_wager" value="' . esc_attr( $max_wager ) . '" step="0.01" /></p>';
    }

    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['slot_details_nonce'] ) || ! wp_verify_nonce( $_POST['slot_details_nonce'], 'save_slot_details' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && 'slot' === $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        update_post_meta( $post_id, '_slot_description', sanitize_textarea_field( $_POST['slot_description'] ) );
        update_post_meta( $post_id, '_slot_star_rating', intval( $_POST['slot_star_rating'] ) );
        update_post_meta( $post_id, '_slot_provider', sanitize_text_field( $_POST['slot_provider'] ) );
        update_post_meta( $post_id, '_slot_rtp', sanitize_text_field( $_POST['slot_rtp'] ) );
        update_post_meta( $post_id, '_slot_min_wager', floatval( $_POST['slot_min_wager'] ) );
        update_post_meta( $post_id, '_slot_max_wager', floatval( $_POST['slot_max_wager'] ) );
    }

    // public function disable_gutenberg_for_slots( $use_block_editor, $post_type ) {
    //     if ( $post_type === 'slot' ) {
    //         return false;
    //     }
    //     return $use_block_editor;
    // }
}

new Slot_Pages_Custom_Fields();
