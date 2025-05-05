<?php
// Display custom fields in wp-admin all slots table

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Slot_Pages_Admin_Columns {

    public function __construct() {
        add_filter( 'manage_slot_posts_columns', [ $this, 'add_custom_columns' ] );
        add_action( 'manage_slot_posts_custom_column', [ $this, 'render_custom_columns' ], 10, 2 );
        add_filter( 'manage_edit-slot_sortable_columns', [ $this, 'make_columns_sortable' ] );
    }

    public function add_custom_columns( $columns ) {
        $new_columns = [
            'cb' => $columns['cb'],
            'thumbnail' => __( 'Thumbnail', 'slot-pages' ),
            'id' => __( 'ID', 'slot-pages' ),            
            'title' => $columns['title'],
            'star_rating' => __( 'Star Rating', 'slot-pages' ),
            'rtp' => __( 'RTP (%)', 'slot-pages' ),
            'min_wager' => __( 'Min Wager', 'slot-pages' ),
            'max_wager' => __( 'Max Wager', 'slot-pages' ),
            'date' => $columns['date'],
        ];
        return $new_columns;
    }

    public function render_custom_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'id':
                echo $post_id;
                break;
            case 'thumbnail':
                echo get_the_post_thumbnail( $post_id, [50, 50] );
                break;
            case 'star_rating':
                echo esc_html( get_post_meta( $post_id, '_slot_star_rating', true ) );
                break;
            case 'rtp':
                echo esc_html( get_post_meta( $post_id, '_slot_rtp', true ) );
                break;
            case 'min_wager':
                echo esc_html( get_post_meta( $post_id, '_slot_min_wager', true ) );
                break;
            case 'max_wager':
                echo esc_html( get_post_meta( $post_id, '_slot_max_wager', true ) );
                break;
        }
    }

    public function make_columns_sortable( $columns ) {
        $columns['id'] = 'ID';
        $columns['star_rating'] = 'star_rating';
        $columns['rtp'] = 'rtp';
        $columns['min_wager'] = 'min_wager';
        $columns['max_wager'] = 'max_wager';
        return $columns;
    }
}

new Slot_Pages_Admin_Columns();