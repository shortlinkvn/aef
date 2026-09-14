<?php
get_header();
the_post();
$id      = get_the_ID();
$kind    = aef_meta( $id, 'story_kind', 'news' );
$kinds   = aef_story_kinds();
$k_label = isset( $kinds[ $kind ] ) ? aef_t( $kinds[ $kind ] ) : aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) );
$excerpt = aef_lang() === 'vi' ? aef_meta( $id, 'excerpt_vi' ) : aef_meta( $id, 'excerpt_en' );
if ( ! $excerpt ) {
	$excerpt = has_excerpt() ? get_the_excerpt() : '';
}
$archive = get_post_type_archive_link( 'aef_story' );
$video   = aef_video_html( aef_meta( $id, 'video_url' ), aef_meta( $id, 'video_file_id' ) );
$pdf_l   = aef_lang() === 'vi' ? aef_meta( $id, 'pdf_label_vi' ) : aef_meta( $id, 'pdf_label_en' );
$pdf     = aef_pdf_html( aef_meta( $id, 'pdf_id' ), $pdf_l ? $pdf_l : 'PDF' );
$img     = aef_story_image( $id );
$related = new WP_Query(
	array(
		'post_type'      => 'aef_story',
		'posts_per_page' => 3,
		'post__not_in'   => array( $id ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
?>
<header class="story-head">
  <div class="shell">
    <p class="eyebrow"><a href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ) ); ?></a></p>
    <p class="story-kicker"><?php echo esc_html( $k_label . ' · ' . get_the_date() ); ?></p>
    <h1><?php echo esc_html( aef_bilingual_title( $id ) ); ?></h1>
    <?php if ( $excerpt ) : ?>
      <p class="lead"><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p>
    <?php endif; ?>
  </div>
</header>
<figure class="story-cover">
  <div class="shell">
    <?php if ( $video ) : ?>
      <?php echo $video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    <?php else : ?>
      <img src="<?php echo esc_url( $img ); ?>" alt="" width="1300" height="732">
    <?php endif; ?>
    <figcaption><?php echo esc_html( aef_illustration_credit() ); ?></figcaption>
  </div>
</figure>
<section class="story-body">
  <div class="shell story-layout">
    <article class="body-copy">
      <?php echo apply_filters( 'the_content', aef_bilingual_content( $id ) ); ?>
      <?php if ( $pdf ) : ?>
        <?php echo $pdf; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endif; ?>
    </article>
    <aside class="story-aside">
      <dl>
        <dt><?php echo esc_html( aef_t( array( 'en' => 'Published', 'vi' => 'Ngày đăng' ) ) ); ?></dt>
        <dd><?php echo esc_html( get_the_date() ); ?></dd>
        <dt><?php echo esc_html( aef_t( array( 'en' => 'Type', 'vi' => 'Loại tư liệu' ) ) ); ?></dt>
        <dd><?php echo esc_html( $k_label ); ?></dd>
        <dt><?php echo esc_html( aef_t( array( 'en' => 'Forum', 'vi' => 'Diễn đàn' ) ) ); ?></dt>
        <dd>AEF 2026 · 27–28.10.2026</dd>
      </dl>
      <a class="text-link" href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'All media', 'vi' => 'Mọi tin' ) ) ); ?> →</a>
      <a class="text-link" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?> →</a>
      <a class="text-link" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Working as press', 'vi' => 'Tác nghiệp báo chí' ) ) ); ?> →</a>
    </aside>
  </div>
</section>
<?php if ( $related->have_posts() ) : ?>
<section class="story-more">
  <div class="shell">
    <h2><?php echo esc_html( aef_t( array( 'en' => 'More from the media desk', 'vi' => 'Thêm từ đầu mối truyền thông' ) ) ); ?></h2>
    <div class="media-grid">
      <?php
		while ( $related->have_posts() ) :
			$related->the_post();
			$sid  = get_the_ID();
			$sk   = aef_meta( $sid, 'story_kind', 'news' );
			$lab  = isset( $kinds[ $sk ] ) ? aef_t( $kinds[ $sk ] ) : get_the_date();
			$deck = aef_lang() === 'vi' ? aef_meta( $sid, 'excerpt_vi' ) : aef_meta( $sid, 'excerpt_en' );
			?>
        <a class="media-card" href="<?php the_permalink(); ?>">
          <figure>
            <img src="<?php echo esc_url( aef_story_image( $sid, 'medium_large' ) ); ?>" alt="" width="720" height="405" loading="lazy">
          </figure>
          <small><?php echo esc_html( $lab . ' · ' . get_the_date() ); ?></small>
          <h3><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></h3>
          <?php if ( $deck ) : ?>
            <p><?php echo esc_html( $deck ); ?></p>
          <?php endif; ?>
        </a>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php
get_footer();
