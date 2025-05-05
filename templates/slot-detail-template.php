<?php
/**
 * Slot Detail Template
 * This template renders the detailed view for a single slot.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


// Get slot metadata
$star_rating = get_post_meta( get_the_ID(), '_slot_star_rating', true );
$provider    = get_post_meta( get_the_ID(), '_slot_provider', true );
$rtp         = get_post_meta( get_the_ID(), '_slot_rtp', true );
$min_wager   = get_post_meta( get_the_ID(), '_slot_min_wager', true );
$max_wager   = get_post_meta( get_the_ID(), '_slot_max_wager', true );
$image        = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$description  = get_post_meta( get_the_ID(), '_slot_description', true );
?>

<div class="wp-block-group alignfull" style="padding-top: var(--wp--preset--spacing--60); padding-bottom: var(--wp--preset--spacing--60);">
    <div class="wp-block-group alignwide">
        <h1 class="wp-block-post-title" style="margin-bottom: var(--wp--preset--spacing--40);">
            <?php the_title(); ?>
        </h1>

        <?php if ( $image ) : ?>
            <figure class="wp-block-image alignwide" style="margin-bottom: var(--wp--preset--spacing--40);">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" />
            </figure>
        <?php endif; ?>

        <div class="wp-block-group" style="margin-bottom: var(--wp--preset--spacing--40);">
            <div class="wp-block-columns">
                <div class="wp-block-column">
                    <p><strong><?php _e( 'Provider:', 'slot-pages' ); ?></strong> <?php echo esc_html( $provider ); ?></p>
                    <p><strong><?php _e( 'RTP:', 'slot-pages' ); ?></strong> <?php echo esc_html( $rtp ); ?>%</p>
                    <p><strong><?php _e( 'Wager Range:', 'slot-pages' ); ?></strong> <?php echo esc_html( $min_wager ); ?> - <?php echo esc_html( $max_wager ); ?></p>
                </div>
                <div class="wp-block-column">
                    <p><strong><?php _e( 'Star Rating:', 'slot-pages' ); ?></strong></p>
                    <div class="slot-rating">
                        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                            <span class="star <?php echo ( $i <= $star_rating ) ? 'filled' : ''; ?>" style="color: <?php echo ( $i <= $star_rating ) ? '#f5a623' : '#ccc'; ?>;">★</span>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="wp-block-group">
            <h2 class="wp-block-heading" style="margin-bottom: var(--wp--preset--spacing--20);"><?php _e( 'Description', 'slot-pages' ); ?></h2>
            <p><?php echo esc_html( $description ); ?></p>
        </div>
    </div>
</div>
