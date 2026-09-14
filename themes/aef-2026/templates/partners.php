<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$grouped = function_exists( 'aef_partners_by_tier' ) ? aef_partners_by_tier() : array();
$tiers   = function_exists( 'aef_partner_tiers' ) ? aef_partner_tiers() : array();
$skip    = array( 'convening' );
$has     = false;
foreach ( $grouped as $tier => $items ) {
	if ( in_array( $tier, $skip, true ) || empty( $items ) ) {
		continue;
	}
	$has = true;
	break;
}
echo '<div class="partners-page">';
if ( $has ) {
	foreach ( $grouped as $tier => $items ) {
		if ( in_array( $tier, $skip, true ) || empty( $items ) ) {
			continue;
		}
		$label = isset( $tiers[ $tier ] ) ? aef_t( $tiers[ $tier ] ) : $tier;
		echo '<section class="partners-block"><div class="shell">';
		echo '<h2 class="partners-block-title">' . esc_html( $label ) . '</h2>';
		echo '<div class="partner-grid">';
		foreach ( $items as $item ) {
			echo '<div class="partner-card">';
			if ( ! empty( $item['url'] ) ) {
				echo '<a href="' . esc_url( $item['url'] ) . '" rel="noopener">';
			}
			if ( ! empty( $item['logo'] ) ) {
				echo '<img src="' . esc_url( $item['logo'] ) . '" alt="' . esc_attr( $item['name'] ) . '" loading="lazy">';
			}
			echo '<small>' . esc_html( $item['name'] ) . '</small>';
			if ( ! empty( $item['url'] ) ) {
				echo '</a>';
			}
			echo '</div>';
		}
		echo '</div></div></section>';
	}
} else {
	foreach ( aef_partner_groups() as $group ) {
		$role = aef_t( $group['role'] );
		if ( false !== stripos( $role, 'chủ trì' ) || false !== stripos( $role, 'convening' ) ) {
			continue;
		}
		if ( empty( $group['items'] ) ) {
			continue;
		}
		echo '<section class="partners-block"><div class="shell">';
		echo '<h2 class="partners-block-title">' . esc_html( aef_t( $group['title'] ) ) . '</h2>';
		echo '<div class="partner-grid">';
		foreach ( $group['items'] as $item ) {
			echo '<div class="partner-card"><img src="' . esc_url( $item[1] ) . '" alt="' . esc_attr( $item[0] ) . '" loading="lazy"><small>' . esc_html( $item[0] ) . '</small></div>';
		}
		echo '</div></div></section>';
	}
}
echo '</div>';
