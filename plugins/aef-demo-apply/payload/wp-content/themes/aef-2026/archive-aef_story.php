<?php
get_header();
echo aef_phero(
	array( array( 'AEF 2026', home_url( '/' ) ), array( aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ) ) ),
	aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ),
	aef_t( array(
		'en' => 'Official public content of the Forum: news, statements, photography and replay.',
		'vi' => 'Nội dung công khai chính thức: tin, thông cáo, ảnh và bản xem lại.',
	) ),
	aef_img( 'youth.jpg' )
);
$cards = array(
	array( '/2026/media/', array( 'en' => 'News', 'vi' => 'Tin tức' ), array( 'en' => 'Announcements from the Organising Committee.', 'vi' => 'Thông báo từ Ban Tổ chức.' ) ),
	array( '/2026/media/', array( 'en' => 'Press releases', 'vi' => 'Thông cáo báo chí' ), array( 'en' => 'Official statements, bilingual when published.', 'vi' => 'Thông cáo chính thức, song ngữ khi công bố.' ) ),
	array( '/2026/media/', array( 'en' => 'Photo library', 'vi' => 'Thư viện ảnh' ), array( 'en' => 'Imagery cleared for editorial use.', 'vi' => 'Ảnh được phép dùng cho mục đích báo chí.' ) ),
	array( '/2026/media/', array( 'en' => 'Video and replay', 'vi' => 'Video và xem lại' ), array( 'en' => 'Session recordings when a stream is cleared.', 'vi' => 'Bản ghi phiên khi được phép phát.' ) ),
);
?>
<div class="band"><div class="shell"><b><?php echo esc_html( aef_t( array( 'en' => 'The media library is still being completed', 'vi' => 'Kho tư liệu đang được hoàn thiện' ) ) ); ?></b><span><?php echo esc_html( aef_t( array( 'en' => 'Official files open after approval', 'vi' => 'Tài liệu chính thức mở sau phê duyệt' ) ) ); ?></span></div></div>
<section class="blk"><div class="shell">
  <div class="grid3">
    <?php foreach ( $cards as $c ) : ?>
      <a class="card rv" href="<?php echo esc_url( home_url( $c[0] ) ); ?>">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Public', 'vi' => 'Công chúng' ) ) ); ?></small>
        <h3><?php echo esc_html( aef_t( $c[1] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $c[2] ) ); ?></p>
        <span class="go"><?php echo esc_html( aef_t( array( 'en' => 'Open', 'vi' => 'Xem' ) ) ); ?> →</span>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="download-list" style="margin-top:40px">
    <button type="button" disabled><span><?php echo esc_html( aef_t( array( 'en' => 'Press identity kit', 'vi' => 'Bộ nhận diện báo chí' ) ) ); ?></span><b><?php echo esc_html( aef_t( array( 'en' => 'Coming', 'vi' => 'Sắp có' ) ) ); ?></b></button>
    <button type="button" disabled><span><?php echo esc_html( aef_t( array( 'en' => 'Press releases', 'vi' => 'Thông cáo báo chí' ) ) ); ?></span><b><?php echo esc_html( aef_t( array( 'en' => 'Coming', 'vi' => 'Sắp có' ) ) ); ?></b></button>
    <button type="button" disabled><span><?php echo esc_html( aef_t( array( 'en' => 'Photo library', 'vi' => 'Thư viện hình ảnh' ) ) ); ?></span><b><?php echo esc_html( aef_t( array( 'en' => 'Coming', 'vi' => 'Sắp có' ) ) ); ?></b></button>
    <button type="button" disabled><span><?php echo esc_html( aef_t( array( 'en' => 'Spokesperson notes', 'vi' => 'Thông tin phát ngôn' ) ) ); ?></span><b><?php echo esc_html( aef_t( array( 'en' => 'Coming', 'vi' => 'Sắp có' ) ) ); ?></b></button>
  </div>
  <p style="margin-top:28px"><a class="go" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>" style="font-family:var(--display);font-size:13px;letter-spacing:.09em;text-transform:uppercase;color:var(--blue)"><?php echo esc_html( aef_t( array( 'en' => 'Working as press at AEF', 'vi' => 'Tác nghiệp báo chí tại AEF' ) ) ); ?> →</a></p>
</div></section>
<section class="role-section">
  <div class="shell">
    <div class="role-head">
      <span><?php echo esc_html( aef_t( array( 'en' => 'Media partners', 'vi' => 'Đối tác truyền thông' ) ) ); ?></span>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Provisional', 'vi' => 'Dự kiến' ) ) ); ?></h2>
    </div>
    <div class="partner-grid">
      <?php
		$media = aef_partner_groups();
		$media = isset( $media[2]['items'] ) ? $media[2]['items'] : array();
		foreach ( $media as $item ) :
			?>
        <div class="partner-card">
          <img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>">
          <small><?php echo esc_html( $item[0] ); ?></small>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="role-note"><?php echo esc_html( aef_t( array(
		'en' => 'Roles and logo treatment must be confirmed before public release.',
		'vi' => 'Vai trò và cách thể hiện logo cần được xác nhận trước khi phát hành công khai.',
	) ) ); ?></p>
  </div>
</section>
<?php get_footer();
