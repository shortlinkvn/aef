<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$s      = function_exists( 'aef_settings' ) ? aef_settings() : array();
$venue  = aef_lang() === 'vi'
	? ( isset( $s['venue_vi'] ) ? $s['venue_vi'] : '' )
	: ( isset( $s['venue_en'] ) ? $s['venue_en'] : '' );
$city   = aef_lang() === 'vi'
	? ( isset( $s['city_vi'] ) ? $s['city_vi'] : '' )
	: ( isset( $s['city_en'] ) ? $s['city_en'] : '' );
$invite = isset( $s['invite_url'] ) ? trim( (string) $s['invite_url'] ) : '';
if ( $invite && ! preg_match( '#^https?://#i', $invite ) ) {
	$invite = 'https://' . ltrim( $invite, '/' );
}
$invite = $invite ? esc_url( $invite ) : '';

$steps = array(
	array(
		array( 'en' => 'Open the portal', 'vi' => 'Vào cổng đại biểu' ),
		array(
			'en' => 'Use the separate delegate portal. This website does not host a registration form and does not collect personal data.',
			'vi' => 'Dùng cổng đại biểu riêng. Website này không đặt form đăng ký và không thu dữ liệu cá nhân.',
		),
	),
	array(
		array( 'en' => 'Submit your request', 'vi' => 'Gửi hồ sơ' ),
		array(
			'en' => 'Organisation details and the sessions you wish to attend, as invited or as reviewed.',
			'vi' => 'Thông tin tổ chức và các phiên muốn tham dự, theo thư mời hoặc xét duyệt.',
		),
	),
	array(
		array( 'en' => 'Review', 'vi' => 'Xét duyệt' ),
		array(
			'en' => 'Each session request is reviewed by the Organising Committee. Access is not automatic.',
			'vi' => 'Mỗi đề nghị tham dự phiên được Ban Tổ chức xét duyệt. Quyền vào cửa không tự động.',
		),
	),
	array(
		array( 'en' => 'Receive your badge', 'vi' => 'Nhận thẻ' ),
		array(
			'en' => 'A personal badge for on-site check-in and the sessions that were confirmed. The badge is not transferable.',
			'vi' => 'Thẻ cá nhân để làm thủ tục và vào các phiên đã xác nhận. Thẻ không chuyển nhượng.',
		),
	),
);

$related_slugs = array(
	'eligibility'      => array( 'en' => 'Who can attend', 'vi' => 'Đối tượng tham dự' ),
	'visa'             => array( 'en' => 'Visa & entry', 'vi' => 'Thị thực và nhập cảnh' ),
	'badge-collection' => array( 'en' => 'Badge collection', 'vi' => 'Nhận thẻ đại biểu' ),
);
$related = array();
foreach ( $related_slugs as $slug => $label ) {
	$page = get_page_by_path( 'delegates/' . $slug );
	if ( $page instanceof WP_Post ) {
		$related[] = array(
			'url'   => get_permalink( $page ),
			'label' => aef_t( $label ),
		);
	}
}
?>
<section class="register-page">
  <div class="shell">
    <div class="register-layout">
      <div class="register-copy body-copy">
        <p class="lead"><?php echo esc_html( aef_t( array(
			'en' => 'Attendance at AEF 2026 is by invitation and Organising Committee review. This website does not collect personal data.',
			'vi' => 'Tham dự AEF 2026 theo thư mời và xét duyệt của Ban Tổ chức. Website này không thu dữ liệu cá nhân.',
		) ) ); ?></p>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'Applications go through a separate delegate portal. Do not send passports, identity numbers or other personal files to aef.vn.',
			'vi' => 'Hồ sơ gửi qua cổng đại biểu riêng. Không gửi hộ chiếu, số giấy tờ tùy thân hay hồ sơ cá nhân khác về aef.vn.',
		) ) ); ?></p>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'Main forum: 27–28 October 2026. Forum-week side activities: 26–29 October 2026.',
			'vi' => 'Diễn đàn chính: 27–28 tháng 10 năm 2026. Hoạt động trong tuần Diễn đàn: 26–29 tháng 10 năm 2026.',
		) ) ); ?></p>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'Who may attend: leaders of public institutions, international organisations, enterprises, research institutes, universities and the start-up and innovation ecosystem — by invitation of the Organising Committee.',
			'vi' => 'Đối tượng: lãnh đạo cơ quan nhà nước, tổ chức quốc tế, doanh nghiệp, viện nghiên cứu, trường đại học, hệ sinh thái khởi nghiệp và đổi mới sáng tạo — theo thư mời của Ban Tổ chức.',
		) ) ); ?></p>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'Fee: by invitation. Deadline: to be announced. Media accreditation: Ministry of Foreign Affairs (international press) and the Organising Committee (domestic press).',
			'vi' => 'Chi phí: theo thư mời. Hạn đăng ký: sẽ được công bố. Báo chí: Bộ Ngoại giao (quốc tế) và Ban Tổ chức (trong nước).',
		) ) ); ?></p>
      </div>
      <aside class="register-facts">
        <dl>
          <dt><?php echo esc_html( aef_t( array( 'en' => 'Main days', 'vi' => 'Ngày chính' ) ) ); ?></dt>
          <dd>27–28.10.2026</dd>
          <?php if ( $venue ) : ?>
          <dt><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></dt>
          <dd><?php echo esc_html( $venue . ( $city ? ', ' . $city : '' ) ); ?></dd>
          <?php endif; ?>
          <dt><?php echo esc_html( aef_t( array( 'en' => 'Access', 'vi' => 'Quyền tham dự' ) ) ); ?></dt>
          <dd><?php echo esc_html( aef_t( array( 'en' => 'Invitation and confirmation', 'vi' => 'Thư mời và xác nhận' ) ) ); ?></dd>
        </dl>
        <?php if ( $invite ) : ?>
          <a class="btn btn-b" href="<?php echo $invite; ?>" rel="noopener noreferrer"><?php echo esc_html( aef_t( array( 'en' => 'Open the delegate portal', 'vi' => 'Mở cổng đại biểu' ) ) ); ?></a>
        <?php else : ?>
          <p class="register-pending"><?php echo esc_html( aef_t( array(
				'en' => 'The portal button appears on this page when the Organising Committee publishes the address.',
				'vi' => 'Nút cổng đại biểu hiện trên trang này khi Ban Tổ chức công bố địa chỉ.',
			) ) ); ?></p>
        <?php endif; ?>
      </aside>
    </div>

    <ol class="register-steps">
      <?php foreach ( $steps as $i => $step ) : ?>
        <li class="step">
          <b><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></b>
          <h3><?php echo esc_html( aef_t( $step[0] ) ); ?></h3>
          <p><?php echo esc_html( aef_t( $step[1] ) ); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <ul class="register-notes">
      <li><?php echo esc_html( aef_t( array(
			'en' => 'Access to each session depends on confirmation. A confirmed badge does not open every room.',
			'vi' => 'Quyền vào từng phiên phụ thuộc xác nhận. Thẻ đã cấp không mở mọi phòng.',
		) ) ); ?></li>
      <li><?php echo esc_html( aef_t( array(
			'en' => 'Visa and entry follow current regulations. AEF does not decide a visa.',
			'vi' => 'Thị thực và nhập cảnh theo quy định hiện hành. AEF không quyết định thị thực.',
		) ) ); ?></li>
      <li><?php echo esc_html( aef_t( array(
			'en' => 'Keep a copy of the invitation or confirmation for check-in.',
			'vi' => 'Giữ bản thư mời hoặc xác nhận để làm thủ tục.',
		) ) ); ?></li>
    </ul>

    <?php if ( $related ) : ?>
    <nav class="register-related" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Related', 'vi' => 'Liên quan' ) ) ); ?>">
      <?php foreach ( $related as $item ) : ?>
        <a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>
  </div>
</section>
