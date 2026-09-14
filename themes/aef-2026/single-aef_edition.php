<?php
get_header();
the_post();
$year = aef_meta( get_the_ID(), 'year', get_post_field( 'post_name', get_the_ID() ) );

if ( '2025' === (string) $year || '2025' === get_post_field( 'post_name', get_the_ID() ) ) {
	echo aef_render_edition_2025();
	get_footer();
	return;
}

echo aef_opener(
	$year,
	aef_bilingual_title( get_the_ID() ),
	aef_lang() === 'en' ? aef_meta( get_the_ID(), 'note_en' ) : aef_meta( get_the_ID(), 'note_vi' ),
	function_exists( 'aef_edition_image' ) ? aef_edition_image( $year ) : aef_img( 'visual/hcmc-dusk.jpg' ),
	aef_illustration_credit()
);
?>
<section class="story-body">
	<div class="shell story-layout">
		<article class="body-copy">
			<figure class="figure">
				<img src="<?php echo esc_url( function_exists( 'aef_edition_image' ) ? aef_edition_image( $year ) : aef_img( 'visual/hcmc-dusk.jpg' ) ); ?>" alt="">
				<figcaption><?php echo esc_html( aef_illustration_credit() ); ?> · <?php echo esc_html( $year ); ?></figcaption>
			</figure>
			<?php echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) ); ?>
			<p><a class="text-link" href="<?php echo esc_url( home_url( '/editions/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'All editions', 'vi' => 'Mọi kỳ Diễn đàn' ) ) ); ?> →</a></p>
		</article>
		<aside class="story-aside">
			<dl>
				<dt><?php echo esc_html( aef_t( array( 'en' => 'Edition', 'vi' => 'Kỳ' ) ) ); ?></dt>
				<dd><?php echo esc_html( $year ); ?></dd>
				<dt><?php echo esc_html( aef_t( array( 'en' => 'Current Forum', 'vi' => 'Kỳ hiện tại' ) ) ); ?></dt>
				<dd>AEF 2026 · 27–28.10.2026</dd>
			</dl>
			<a class="text-link" href="<?php echo esc_url( home_url( '/editions/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'All editions', 'vi' => 'Mọi kỳ Diễn đàn' ) ) ); ?> →</a>
			<a class="text-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'About AEF', 'vi' => 'Giới thiệu' ) ) ); ?> →</a>
		</aside>
	</div>
</section>
<?php
get_footer();
