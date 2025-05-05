<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Slot_Pages_REST_API {
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'slot-pages/v1', '/slots', [
            'methods' => 'GET',
            'callback' => [ $this, 'get_slots' ],
            'permission_callback' => '__return_true',
        ] );
    
        register_rest_route( 'slot-pages/v1', '/latest-slot', [
            'methods' => 'GET',
            'callback' => [ $this, 'get_latest_slot' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function get_slots( $request ) {
        $args = [
            'post_type'      => 'slot',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query( $args );
        $slots = [];

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $slots[] = [
                    'id'       => get_the_ID(),
                    'title'    => get_the_title(),
                    'provider' => get_post_meta( get_the_ID(), '_slot_provider', true ),
                    'image'    => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
                ];
            }
            wp_reset_postdata();
        }

        return rest_ensure_response( $slots );
    }

    public function get_latest_slot( $request ) {
        $args = [
            'post_type'      => 'slot',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];
    
        $query = new WP_Query( $args );
        $slot = null;
    
        if ( $query->have_posts() ) {
            $query->the_post();
            $slot = [
                'id'       => get_the_ID(),
                'title'    => get_the_title(),
                'provider' => get_post_meta( get_the_ID(), '_slot_provider', true ),
                'image'    => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
                'content'  => apply_filters( 'the_content', get_the_content() ),
            ];
            wp_reset_postdata();
        }
    
        return rest_ensure_response( $slot );
    }
}
new Slot_Pages_REST_API();