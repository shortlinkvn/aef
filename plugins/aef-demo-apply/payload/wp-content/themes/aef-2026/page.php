<?php
get_header();
the_post();
$slug = get_post_field( 'post_name', get_the_ID() );
$img_map = array(
	'about' => 'visual/hcmc-dusk.jpg',
	'topics' => 'visual/pillar-megacity.jpg',
	'support' => 'visual/arrival.jpg',
	'media-support' => 'visual/arrival.jpg',
	'delegates' => 'visual/arrival.jpg',
	'partners' => 'visual/pillar-private.jpg',
	'travel' => 'visual/arrival.jpg',
	'venue' => 'visual/forum-hall.jpg',
	'hotels' => 'visual/arrival.jpg',
	'transport' => 'visual/arrival.jpg',
);
$img = isset( $img_map[ $slug ] ) ? $img_map[ $slug ] : 'visual/forum-hall.jpg';
echo aef_phero(
	array( array( 'AEF 2026', home_url( '/' ) ), array( aef_bilingual_title( get_the_ID() ) ) ),
	aef_bilingual_title( get_the_ID() ),
	wp_strip_all_tags( get_the_excerpt() ),
	aef_img( $img )
);

if ( 'about' === $slug ) {
	get_template_part( 'templates/about' );
} elseif ( 'topics' === $slug ) {
	get_template_part( 'templates/topics' );
} elseif ( 'support' === $slug ) {
	get_template_part( 'templates/support' );
} elseif ( 'partners' === $slug ) {
	get_template_part( 'templates/partners' );
} elseif ( 'delegates' === $slug ) {
	get_template_part( 'templates/delegates' );
} elseif ( in_array( $slug, array( 'travel', 'venue', 'hotels', 'transport' ), true ) ) {
	echo aef_render_travel();
} else {
	echo '<section class="blk"><div class="shell body-copy">';
	echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) );
	echo '</div></section>';
	if ( 'media-support' === $slug ) {
		echo aef_travel_kit();
	}
}

get_footer();
