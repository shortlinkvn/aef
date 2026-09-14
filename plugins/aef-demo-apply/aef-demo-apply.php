<?php
/**
 * Plugin Name: AEF Demo Apply
 * Version: 0.9.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
register_activation_hook( __FILE__, function () {
	$src = plugin_dir_path( __FILE__ ) . 'payload/';
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $src, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $it as $file ) {
		if ( ! $file->isFile() ) continue;
		$rel = substr( $file->getPathname(), strlen( $src ) );
		$dest = ABSPATH . $rel;
		if ( ! is_dir( dirname( $dest ) ) ) { wp_mkdir_p( dirname( $dest ) ); }
		copy( $file->getPathname(), $dest );
	}
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) { $copy = array(); }
	$copy['block_week'] = '0';
	update_option( 'aef_copy', $copy );
	$existing = get_page_by_path( 'travel' );
	$data = array(
		'post_title' => 'Cẩm nang đi lại',
		'post_name' => 'travel',
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_excerpt' => 'Venue, stay, airport and city notes for AEF 2026.',
		'post_content' => '',
	);
	if ( $existing ) { $data['ID'] = $existing->ID; $id = wp_update_post( $data ); }
	else { $id = wp_insert_post( $data ); }
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, 'title_en', 'Travel kit' );
		update_post_meta( $id, 'title_vi', 'Cẩm nang đi lại' );
		update_post_meta( $id, 'content_en', 'Draft city kit. Hotel names are a central-city reference, not an official list.' );
		update_post_meta( $id, 'content_vi', 'Cẩm nang dự thảo. Tên khách sạn là tham khảo khu trung tâm, không phải danh sách chính thức.' );
	}
	flush_rewrite_rules( false );
} );
