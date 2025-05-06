<?php
/**
 * Slot Grid Template
 * This template renders the grid of slots.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Retrieve the block attributes
$limit       = isset( $attributes['limit'] ) ? $attributes['limit'] : 6;
$sorting     = isset( $attributes['sorting'] ) ? $attributes['sorting'] : 'recent';
$title_color = isset( $attributes['titleColor'] ) ? esc_attr( $attributes['titleColor'] ) : '#000000';
$star_color  = isset( $attributes['starColor'] ) ? esc_attr( $attributes['starColor'] ) : '#FFD700';
$font_size   = isset( $attributes['fontSize'] ) ? intval( $attributes['fontSize'] ) : 16;
$grid_columns = isset( $attributes['gridColumns'] ) ? intval( $attributes['gridColumns'] ) : 3;  // Add the grid column attribute

// Query slot posts based on sorting mode and limit
$args = array(
    'post_type'      => 'slot',
    'posts_per_page' => $limit,
    'orderby'        => $sorting === 'random' ? 'rand' : 'date',
    'order'          => $sorting === 'random' ? 'ASC' : 'DESC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    echo '<div class="slot-pages-grid" style="display: grid; grid-template-columns: repeat(' . $grid_columns . ', 1fr); gap: 10px;">';
    while ( $query->have_posts() ) : $query->the_post();
        // Fetch custom fields
        $star_rating = get_post_meta( get_the_ID(), '_slot_star_rating', true );
        $provider    = get_post_meta( get_the_ID(), '_slot_provider', true );
        $rtp         = get_post_meta( get_the_ID(), '_slot_rtp', true );
        $min_wager   = get_post_meta( get_the_ID(), '_slot_min_wager', true );
        $max_wager   = get_post_meta( get_the_ID(), '_slot_max_wager', true );
        $image       = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );

        ?>
        <div class="slot-item" style="border: 1px solid #ddd; padding: 10px; text-align: center; font-size: <?php echo $font_size; ?>px;">
            <?php if ( $image ) : ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title(); ?>" style="max-width: 100%;" />
            <?php endif; ?>
            <h3 style="color: <?php echo $title_color; ?>;"><?php the_title(); ?></h3>
            <div class="star-rating" style="color: <?php echo $star_color; ?>;">
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                    <span class="star <?php echo ( $i <= $star_rating ) ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
            </div>
            <p><?php echo esc_html( $provider ); ?></p>
            <p>RTP: <?php echo esc_html( $rtp ); ?>%</p>
            <p>Wager: <?php echo esc_html( $min_wager ); ?> - <?php echo esc_html( $max_wager ); ?></p>
            <a href="<?php the_permalink(); ?>" style="background-color: <?php echo $title_color; ?>; color: white; padding: 5px 10px; text-decoration: none;">More Info</a>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
else :
    echo '<p>' . __( 'No slots available', 'slot-pages' ) . '</p>';
endif;
?>
