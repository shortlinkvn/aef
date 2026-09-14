<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$steps = array(
	array(
		'youth.jpg',
		array( 'en' => 'Accreditation', 'vi' => 'Đăng ký tác nghiệp' ),
		array(
			'en' => 'Journalists register separately from delegates. This website does not host a personal-data form.',
			'vi' => 'Nhà báo đăng ký tách khỏi đại biểu. Website này không đặt form thu dữ liệu cá nhân.',
		),
	),
	array(
		'expo.jpg',
		array( 'en' => 'On site', 'vi' => 'Tại chỗ' ),
		array(
			'en' => 'Dedicated entrance, then accreditation, the Media Centre and the press areas at Thiskyhall.',
			'vi' => 'Lối riêng, rồi nhận thẻ tác nghiệp, Trung tâm Báo chí và khu vực tác nghiệp tại Thiskyhall.',
		),
	),
	array(
		'plenary.jpg',
		array( 'en' => 'Interviews', 'vi' => 'Phỏng vấn' ),
		array(
			'en' => 'Interview requests go through the media desk. Delegate and media flows are kept separate.',
			'vi' => 'Đề nghị phỏng vấn gửi qua đầu mối truyền thông. Luồng Đại biểu và Báo chí tách riêng.',
		),
	),
);
?>
<section class="press-ops">
  <div class="shell">
    <div class="press-intro">
      <div>
        <p class="lead"><?php echo esc_html( aef_t( array(
			'en' => 'Press accreditation for AEF 2026 is separate from delegate registration. Working rules, press rooms and interview requests sit with the media desk.',
			'vi' => 'Đăng ký tác nghiệp báo chí AEF 2026 tách khỏi đăng ký đại biểu. Quy định tác nghiệp, trung tâm báo chí và đề nghị phỏng vấn nằm ở đầu mối truyền thông.',
		) ) ); ?></p>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'Main Forum days: 27–28 October 2026 at Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh. Forum-week activities: 26–29 October.',
			'vi' => 'Diễn đàn chính: 27–28 tháng 10 năm 2026 tại Thiskyhall, số 10 Mai Chí Thọ, Sala, phường An Khánh. Hoạt động trong tuần Diễn đàn: 26–29 tháng 10.',
		) ) ); ?></p>
      </div>
      <figure>
        <img src="<?php echo esc_url( aef_img( 'visual/arrival.jpg' ) ); ?>" alt="" width="720" height="480">
        <figcaption><?php echo esc_html( aef_illustration_credit() ); ?></figcaption>
      </figure>
    </div>

    <div class="press-steps">
      <?php foreach ( $steps as $i => $step ) : ?>
        <article class="press-step">
          <img src="<?php echo esc_url( aef_img( $step[0] ) ); ?>" alt="" width="720" height="405" loading="lazy">
          <div>
            <small><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></small>
            <h3><?php echo esc_html( aef_t( $step[1] ) ); ?></h3>
            <p><?php echo esc_html( aef_t( $step[2] ) ); ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="press-contact">
      <div>
        <h2><?php echo esc_html( aef_t( array( 'en' => 'Media desk', 'vi' => 'Đầu mối truyền thông' ) ) ); ?></h2>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'For accreditation and on-site working conditions, write to the Secretariat.',
			'vi' => 'Để đăng ký tác nghiệp và điều kiện làm việc tại chỗ, gửi Ban thư ký.',
		) ) ); ?></p>
      </div>
      <a class="btn btn-p" href="mailto:contact@aef.vn">contact@aef.vn</a>
    </div>
  </div>
</section>
