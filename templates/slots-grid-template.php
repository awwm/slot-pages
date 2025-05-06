<?php
/**
 * Slot Grid Template
 * This template renders the grid of slots.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Retrieve block attributes with defaults
$limit             = isset( $attributes['limit'] ) ? intval( $attributes['limit'] ) : 6;
$sorting           = isset( $attributes['sorting'] ) ? esc_attr( $attributes['sorting'] ) : 'recent';
$columns           = isset( $attributes['columns'] ) ? intval( $attributes['columns'] ) : 3;
$title_color       = isset( $attributes['titleColor'] ) ? esc_attr( $attributes['titleColor'] ) : '#000000';
$star_color        = isset( $attributes['starColor'] ) ? esc_attr( $attributes['starColor'] ) : '#FFD700';
$provider_color    = isset( $attributes['providerColor'] ) ? esc_attr( $attributes['providerColor'] ) : '#555555';
$wager_color       = isset( $attributes['wagerColor'] ) ? esc_attr( $attributes['wagerColor'] ) : '#555555';
$button_bg_color   = isset( $attributes['buttonBgColor'] ) ? esc_attr( $attributes['buttonBgColor'] ) : '#0073aa';
$button_text_color = isset( $attributes['buttonTextColor'] ) ? esc_attr( $attributes['buttonTextColor'] ) : '#ffffff';
$title_font_size   = isset( $attributes['titleFontSize'] ) ? intval( $attributes['titleFontSize'] ) : 16;
$provider_font_size = isset( $attributes['providerFontSize'] ) ? intval( $attributes['providerFontSize'] ) : 14;
$wager_font_size   = isset( $attributes['wagerFontSize'] ) ? intval( $attributes['wagerFontSize'] ) : 14;

// Query slot posts
$args = array(
    'post_type'      => 'slot',
    'posts_per_page' => $limit,
    'orderby'        => $sorting === 'random' ? 'rand' : 'date',
    'order'          => $sorting === 'random' ? 'ASC' : 'DESC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    echo '<div class="slot-pages-grid" style="display: grid; grid-template-columns: repeat(' . $columns . ', 1fr); gap: 10px;">';
    while ( $query->have_posts() ) : $query->the_post();
        // Fetch custom fields
        $star_rating = intval( get_post_meta( get_the_ID(), '_slot_star_rating', true ) );
        $provider    = get_post_meta( get_the_ID(), '_slot_provider', true );
        $rtp         = get_post_meta( get_the_ID(), '_slot_rtp', true );
        $min_wager   = get_post_meta( get_the_ID(), '_slot_min_wager', true );
        $max_wager   = get_post_meta( get_the_ID(), '_slot_max_wager', true );
        $image       = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );

        ?>
        <div class="slot-item" style="border: 1px solid #ddd; padding: 10px; text-align: center;">
            <?php if ( $image ) : ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title(); ?>" style="max-width: 100%; margin-bottom: 5px;" />
            <?php endif; ?>

            <h3 style="color: <?php echo $title_color; ?>; font-size: <?php echo $title_font_size; ?>px; margin: 5px 0;">
                <?php the_title(); ?>
            </h3>

            <div class="star-rating" style="color: <?php echo $star_color; ?>; margin: 3px 0;">
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                    <span class="star <?php echo ( $i <= $star_rating ) ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
            </div>

            <div class="provider" style="color: <?php echo $provider_color; ?>; font-size: <?php echo $provider_font_size; ?>px; margin: 3px 0;">
                <?php echo esc_html( $provider ); ?>
            </div>

            <div class="wager" style="color: <?php echo $wager_color; ?>; font-size: <?php echo $wager_font_size; ?>px; margin: 3px 0;">
                Wager: <?php echo esc_html( $min_wager ); ?> - <?php echo esc_html( $max_wager ); ?>
            </div>

            <div class="rtp" style="font-size: 12px; color: #777; margin: 3px 0;">
                RTP: <?php echo esc_html( $rtp ); ?>%
            </div>

            <a href="<?php the_permalink(); ?>" style="display: inline-block; margin-top: 5px; padding: 5px 10px; background-color: <?php echo $button_bg_color; ?>; color: <?php echo $button_text_color; ?>; text-decoration: none; border-radius: 4px;">
                More Info
            </a>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
else :
    echo '<p>' . __( 'No slots available', 'slot-pages' ) . '</p>';
endif;
?>
