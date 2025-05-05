<?php
/**
 * Slot Detail Template
 * This template renders the detailed view for a single slot.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get slot metadata
$star_rating = get_post_meta( get_the_ID(), 'star_rating', true );
$provider    = get_post_meta( get_the_ID(), 'provider_name', true );
$rtp         = get_post_meta( get_the_ID(), 'rtp', true );
$min_wager   = get_post_meta( get_the_ID(), 'min_wager', true );
$max_wager   = get_post_meta( get_the_ID(), 'max_wager', true );
$image        = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$description  = get_the_content();

?>
<div class="slot-detail">
    <h1><?php the_title(); ?></h1>
    <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title(); ?>" />
    <div class="slot-rating">
        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
            <span class="star <?php echo ( $i <= $star_rating ) ? 'filled' : ''; ?>">★</span>
        <?php endfor; ?>
    </div>
    <p><strong><?php _e( 'Provider:', 'slot-pages' ); ?></strong> <?php echo esc_html( $provider ); ?></p>
    <p><strong><?php _e( 'RTP:', 'slot-pages' ); ?></strong> <?php echo esc_html( $rtp ); ?>%</p>
    <p><strong><?php _e( 'Wager:', 'slot-pages' ); ?></strong> <?php echo esc_html( $min_wager ); ?> - <?php echo esc_html( $max_wager ); ?></p>
    <div class="slot-description">
        <h2><?php _e( 'Description', 'slot-pages' ); ?></h2>
        <p><?php echo esc_html( $description ); ?></p>
    </div>
</div>
