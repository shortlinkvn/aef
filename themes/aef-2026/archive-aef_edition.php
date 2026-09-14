<?php
get_header();
echo aef_opener(
	'AEF',
	aef_t( array( 'en' => 'Editions', 'vi' => 'Các kỳ Diễn đàn' ) ),
	aef_t( array(
		'en' => 'Every edition keeps its own address.',
		'vi' => 'Mỗi kỳ giữ một địa chỉ riêng.',
	) ),
	aef_img( 'bridge.jpg' ),
	aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) )
);
$q = function_exists( 'aef_editions_query' )
	? aef_editions_query()
	: new WP_Query( array( 'post_type' => 'aef_edition', 'posts_per_page' => 20, 'orderby' => 'name', 'order' => 'DESC' ) );
?>
<section class="blk edition-index"><div class="shell">
  <div class="year-grid">
    <?php
	while ( $q->have_posts() ) :
		$q->the_post();
		$eid  = get_the_ID();
		$year = aef_meta( $eid, 'year', get_the_title() );
		$note = aef_lang() === 'en' ? aef_meta( $eid, 'note_en' ) : aef_meta( $eid, 'note_vi' );
		?>
      <a class="year-card rv" href="<?php the_permalink(); ?>">
        <figure>
          <img src="<?php echo esc_url( aef_edition_image( $year ) ); ?>" alt="" width="720" height="405" loading="lazy">
        </figure>
        <div>
          <b><?php echo esc_html( $year ); ?></b>
          <h3><?php echo esc_html( aef_bilingual_title( $eid ) ); ?></h3>
          <?php if ( $note ) : ?>
            <span><?php echo esc_html( $note ); ?></span>
          <?php endif; ?>
        </div>
      </a>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
</div></section>
<?php get_footer();
