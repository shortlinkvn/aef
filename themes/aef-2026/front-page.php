<?php
get_header();
foreach ( aef_home_order() as $block_id ) {
	aef_render_home_block( $block_id );
}
get_footer();
