<?php
/**
 * Slot Grid Template
 * This template renders the grid of slot games.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Retrieve the block attributes
$limit = isset( $attributes['limit'] ) ? $attributes['limit'] : 6;
$sorting = isset( $attributes['sorting'] ) ? $attributes['sorting'] : 'recent';

// Query slot posts based on sorting mode and limit
$args = array(
    'post_type'      => 'slot',
    'posts_per_page' => $limit,
    'orderby'        => $sorting === 'random' ? 'rand' : 'date',
    'order'          => $sorting === 'random' ? 'ASC' : 'DESC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    echo '<div class="slot-pages-grid">';
    while ( $query->have_posts() ) : $query->the_post();
        // Display each slot
        $star_rating = get_post_meta( get_the_ID(), 'star_rating', true );
        $provider    = get_post_meta( get_the_ID(), 'provider_name', true );
        $rtp         = get_post_meta( get_the_ID(), 'rtp', true );
        $min_wager   = get_post_meta( get_the_ID(), 'min_wager', true );
        $max_wager   = get_post_meta( get_the_ID(), 'max_wager', true );
        $image        = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );

        ?>
        <div class="slot-item">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title(); ?>" />
            <h3><?php the_title(); ?></h3>
            <div class="star-rating">
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                    <span class="star <?php echo ( $i <= $star_rating ) ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
            </div>
            <p><?php echo esc_html( $provider ); ?></p>
            <p>RTP: <?php echo esc_html( $rtp ); ?>%</p>
            <p>Wager: <?php echo esc_html( $min_wager ); ?> - <?php echo esc_html( $max_wager ); ?></p>
            <a href="<?php the_permalink(); ?>">More Info</a>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
else :
    echo '<p>' . __( 'No slots available', 'slot-pages' ) . '</p>';
endif;
