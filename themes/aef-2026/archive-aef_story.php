<?php
get_header();
echo aef_opener(
	'AEF 2026',
	aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ),
	aef_t( array(
		'en' => 'News, statements, photography and replay — including the official archive published on hef.gov.vn.',
		'vi' => 'Tin, thông cáo, ảnh và bản xem lại — gồm tư liệu chính thức đã đăng trên hef.gov.vn.',
	) ),
	aef_img( 'plenary.jpg' ),
	aef_illustration_credit()
);
$kinds  = aef_story_kinds();
$filter = isset( $_GET['kind'] ) ? sanitize_key( wp_unslash( $_GET['kind'] ) ) : '';
if ( $filter && ! isset( $kinds[ $filter ] ) ) {
	$filter = '';
}
$archive = get_post_type_archive_link( 'aef_story' );
$args    = array(
	'post_type'      => 'aef_story',
	'posts_per_page' => 12,
	'orderby'        => 'date',
	'order'          => 'DESC',
);
if ( $filter ) {
	$args['meta_key']   = 'story_kind';
	$args['meta_value'] = $filter;
}
$stories = new WP_Query( $args );
$local   = array();
if ( $stories->have_posts() ) {
	foreach ( $stories->posts as $st ) {
		$local[] = aef_story_as_media_card( $st, $kinds );
	}
}
wp_reset_postdata();

$releases = $local;
if ( ! $filter || 'news' === $filter || 'document' === $filter ) {
	foreach ( aef_hef_publications() as $pub ) {
		if ( count( $releases ) >= 8 ) {
			break;
		}
		$releases[] = $pub;
	}
}
$photos = aef_hef_photo_albums();
$videos = aef_hef_videos();
$hef_mg = aef_lang() === 'vi' ? 'https://hef.gov.vn/vi/media-gallery/' : 'https://hef.gov.vn/media-gallery';
?>
<nav class="travel-nav" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Media types', 'vi' => 'Loại tư liệu' ) ) ); ?>">
  <div class="shell travel-nav-inner">
    <a class="<?php echo '' === $filter ? 'on' : ''; ?>" href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'All', 'vi' => 'Tất cả' ) ) ); ?></a>
    <?php foreach ( $kinds as $key => $lab ) : ?>
      <a class="<?php echo $filter === $key ? 'on' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'kind', $key, $archive ) ); ?>"><?php echo esc_html( aef_t( $lab ) ); ?></a>
    <?php endforeach; ?>
    <a href="#photos"><?php echo esc_html( aef_t( array( 'en' => 'Gallery', 'vi' => 'Thư viện ảnh' ) ) ); ?></a>
    <a href="#videos"><?php echo esc_html( aef_t( array( 'en' => 'Video', 'vi' => 'Video' ) ) ); ?></a>
  </div>
</nav>

<section class="media-gallery-page" id="releases">
  <div class="shell">
    <div class="hef-sec-head">
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Press releases & publications', 'vi' => 'Báo chí & ấn phẩm' ) ) ); ?></h2>
    </div>
    <?php if ( $releases ) : ?>
    <div class="hef-news-grid">
      <?php foreach ( $releases as $card ) : ?>
        <?php echo aef_media_card_html( $card ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="media-gallery-page mist" id="photos">
  <div class="shell">
    <div class="hef-sec-head">
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Autumn Economic Forum', 'vi' => 'Diễn đàn Kinh tế Mùa thu' ) ) ); ?></p>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Gallery', 'vi' => 'Thư viện ảnh' ) ) ); ?></h2>
    </div>
    <h3 class="hef-sub"><?php echo esc_html( aef_t( array( 'en' => 'Photo gallery', 'vi' => 'Thư viện ảnh' ) ) ); ?></h3>
    <div class="hef-news-grid cols-3">
      <?php foreach ( $photos as $card ) : ?>
        <?php echo aef_media_card_html( $card ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endforeach; ?>
    </div>

    <h3 class="hef-sub" id="videos"><?php echo esc_html( aef_t( array( 'en' => 'Video gallery', 'vi' => 'Thư viện video' ) ) ); ?></h3>
    <div class="hef-news-grid">
      <?php foreach ( $videos as $video ) : ?>
        <?php echo aef_video_thumb_html( $video, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endforeach; ?>
    </div>
    <p class="hef-news-more">
      <a class="text-link" href="<?php echo esc_url( $hef_mg ); ?>" rel="noopener"><?php echo esc_html( aef_t( array( 'en' => 'Official gallery on hef.gov.vn', 'vi' => 'Thư viện chính thức trên hef.gov.vn' ) ) ); ?> →</a>
    </p>
  </div>
</section>

<section class="media-desk" id="desk">
  <div class="shell">
    <div class="media-desk-head">
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'For the press', 'vi' => 'Dành cho báo chí' ) ) ); ?></p>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Working at AEF 2026', 'vi' => 'Tác nghiệp tại AEF 2026' ) ) ); ?></h2>
    </div>
    <div class="media-desk-grid">
      <a class="media-desk-card" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>">
        <img src="<?php echo esc_url( aef_img( 'youth.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy">
        <div>
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Accreditation', 'vi' => 'Đăng ký tác nghiệp' ) ) ); ?></h3>
          <p><?php echo esc_html( aef_t( array( 'en' => 'Journalists register separately from delegates. Press rooms and interview requests sit with the media desk.', 'vi' => 'Nhà báo đăng ký tách khỏi đại biểu. Trung tâm báo chí và đề nghị phỏng vấn nằm ở đầu mối truyền thông.' ) ) ); ?></p>
        </div>
      </a>
      <a class="media-desk-card" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>">
        <img src="<?php echo esc_url( aef_img( 'visual/forum-hall.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy">
        <div>
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?></h3>
          <p><?php echo esc_html( aef_t( array( 'en' => 'Times, rooms and access for the main days and Forum-week activities.', 'vi' => 'Giờ, không gian và quyền tiếp cận cho hai ngày chính và hoạt động trong tuần Diễn đàn.' ) ) ); ?></p>
        </div>
      </a>
      <a class="media-desk-card" href="mailto:contact@aef.vn">
        <img src="<?php echo esc_url( aef_img( 'expo.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy">
        <div>
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Media desk', 'vi' => 'Đầu mối truyền thông' ) ) ); ?></h3>
          <p><?php echo esc_html( aef_t( array( 'en' => 'Write to contact@aef.vn for accreditation, statements and on-site working conditions.', 'vi' => 'Gửi contact@aef.vn cho đăng ký tác nghiệp, thông cáo và điều kiện làm việc tại chỗ.' ) ) ); ?></p>
        </div>
      </a>
    </div>
  </div>
</section>

<?php
$media_group = aef_partner_groups();
$media_items = isset( $media_group[2]['items'] ) ? $media_group[2]['items'] : array();
if ( $media_items ) :
	?>
<section class="role-section">
  <div class="shell">
    <div class="role-head">
      <span><?php echo esc_html( aef_t( array( 'en' => 'Partners', 'vi' => 'Đối tác' ) ) ); ?></span>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Media partners', 'vi' => 'Đối tác truyền thông' ) ) ); ?></h2>
    </div>
    <div class="partner-grid">
      <?php foreach ( $media_items as $item ) : ?>
        <div class="partner-card">
          <img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>">
          <small><?php echo esc_html( $item[0] ); ?></small>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php get_footer();
