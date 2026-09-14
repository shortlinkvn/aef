<?php
get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		echo aef_opener(
			'AEF 2026',
			aef_bilingual_title( get_the_ID() ),
			wp_strip_all_tags( get_the_excerpt() ),
			aef_img( 'hall.jpg' ),
			aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) )
		);
		echo '<section class="blk"><div class="shell body-copy">';
		echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) );
		echo '</div></section>';
	}
}
get_footer();
