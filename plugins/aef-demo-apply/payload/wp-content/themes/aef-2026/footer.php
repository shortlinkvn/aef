</main>
<footer class="footer">
  <div class="shell fg">
    <div>
      <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-bottom:18px">
        <img src="<?php echo esc_url( aef_logo( 'aef-mono-white.svg' ) ); ?>" alt="AEF 2026" class="footer-mark" width="200" height="80">
      </a>
      <p><?php echo esc_html( aef_t( array(
        'en' => 'Ho Chi Minh City’s annual platform for international dialogue and cooperation, convened with the World Economic Forum.',
        'vi' => 'Nền tảng đối thoại và hợp tác quốc tế thường niên của Thành phố Hồ Chí Minh, tổ chức cùng Diễn đàn Kinh tế Thế giới.',
      ) ) ); ?></p>
      <p style="font-family:var(--mono);font-size:12px;letter-spacing:.06em">aef.vn · contact@aef.vn</p>
    </div>
    <div>
      <h4><?php echo esc_html( aef_t( array( 'en' => 'The Forum', 'vi' => 'Diễn đàn' ) ) ); ?></h4>
      <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'About', 'vi' => 'Giới thiệu' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/topics/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Four pillars', 'vi' => 'Bốn trụ cột' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/speakers/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/editions/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Past editions', 'vi' => 'Các kỳ đã diễn ra' ) ) ); ?></a>
    </div>
    <div>
      <h4><?php echo esc_html( aef_t( array( 'en' => 'Support', 'vi' => 'Hỗ trợ' ) ) ); ?></h4>
      <a href="<?php echo esc_url( home_url( '/2026/support/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Support Centre', 'vi' => 'Trung tâm Hỗ trợ' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/delegates/how-to-register/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/travel/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Travel kit', 'vi' => 'Cẩm nang đi lại' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Media support', 'vi' => 'Hỗ trợ báo chí' ) ) ); ?></a>
    </div>
    <div>
      <h4><?php echo esc_html( aef_t( array( 'en' => 'Follow', 'vi' => 'Theo dõi' ) ) ); ?></h4>
      <a href="<?php echo esc_url( home_url( '/2026/media/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/2026/partners/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Partners', 'vi' => 'Đối tác' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">HCMC C4IR</a>
      <a href="<?php echo esc_url( home_url( aef_settings()['register_path'] ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ) ) ); ?></a>
    </div>
  </div>
  <div class="shell fb">
    <span>© 2026 Autumn Economic Forum · HCMC C4IR</span>
    <span><?php echo esc_html( aef_t( array(
      'en' => 'Terms of use · Personal data protection · Cookie policy',
      'vi' => 'Điều khoản sử dụng · Bảo vệ dữ liệu cá nhân · Chính sách cookie',
    ) ) ); ?></span>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
