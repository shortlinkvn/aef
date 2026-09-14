<?php
$s = aef_settings();
$pillars = array(
	array( array( 'en' => 'WEF Annual Meeting, Davos', 'vi' => 'Hội nghị thường niên WEF tại Davos' ), array( 'en' => 'January · the global agenda-setting meeting', 'vi' => 'Tháng 1 · hội nghị định hình chương trình nghị sự toàn cầu' ) ),
	array( array( 'en' => 'Annual Meeting of the New Champions', 'vi' => 'Hội nghị Thường niên các Nhà Tiên phong' ), array( 'en' => 'Mid-year · growth economies and emerging industries', 'vi' => 'Giữa năm · các nền kinh tế tăng trưởng và ngành công nghiệp mới nổi' ) ),
	array( array( 'en' => 'Autumn Economic Forum', 'vi' => 'Diễn đàn Kinh tế Mùa thu' ), array( 'en' => 'October · Ho Chi Minh City', 'vi' => 'Tháng 10 · Thành phố Hồ Chí Minh' ) ),
);
$editions = new WP_Query( array( 'post_type' => 'aef_edition', 'posts_per_page' => 12, 'orderby' => 'title', 'order' => 'DESC' ) );
?>
<section class="blk"><div class="shell split">
  <div class="body-copy">
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'The world economy is going through a deep restructuring. Supply chains are being reorganised, technology is changing competitive advantage, green standards are becoming a condition of market access, and new growth poles are becoming clearer. In that setting, the ability to connect networks, build trust and act together is itself a development resource.',
		'vi' => 'Kinh tế thế giới đang trải qua một quá trình tái cấu trúc sâu rộng. Chuỗi cung ứng được tổ chức lại, công nghệ làm thay đổi lợi thế cạnh tranh, các tiêu chuẩn xanh trở thành điều kiện tiếp cận thị trường, trong khi những cực tăng trưởng mới đang nổi lên ngày càng rõ nét. Trong bối cảnh đó, khả năng kết nối mạng lưới, xây dựng lòng tin và phối hợp hành động trở thành một nguồn lực phát triển quan trọng.',
	) ) ); ?></p>
    <p><?php echo esc_html( aef_t( array(
		'en' => 'The Autumn Economic Forum 2026 is designed as a platform for international dialogue and cooperation, where governments, localities, cities, firms, investors, international organisations and academia exchange initiatives, connect resources and promote new cooperation models. From Ho Chi Minh City, AEF 2026 aims to join a global agenda to the practical development needs of Viet Nam and the region, and to turn dialogue into initiatives, recommendations and partnerships that can continue after the Forum.',
		'vi' => 'Diễn đàn Kinh tế Mùa thu 2026 được định hướng như một nền tảng đối thoại và hợp tác quốc tế, nơi các chính phủ, địa phương, đô thị, doanh nghiệp, nhà đầu tư, tổ chức quốc tế và giới học thuật cùng trao đổi sáng kiến, kết nối nguồn lực và thúc đẩy các mô hình hợp tác mới. Từ Thành phố Hồ Chí Minh, AEF 2026 hướng tới nối kết chương trình nghị sự toàn cầu với nhu cầu phát triển thực tiễn của Việt Nam và khu vực, chuyển đối thoại thành những sáng kiến, khuyến nghị và quan hệ hợp tác có khả năng tiếp tục sau Diễn đàn.',
	) ) ); ?></p>
    <blockquote class="pullquote"><?php echo esc_html( aef_t( array(
		'en' => 'From adapting to change to building new growth engines together.',
		'vi' => 'Từ thích ứng với thay đổi đến cùng nhau kiến tạo những động lực tăng trưởng mới.',
	) ) ); ?></blockquote>
    <h3><?php echo esc_html( aef_t( array( 'en' => 'The 2026 theme', 'vi' => 'Chủ đề năm 2026' ) ) ); ?></h3>
    <p><?php echo esc_html( aef_t( array(
		'en' => 'Cooperation in a new era is not only widening existing relationships. It is the ability to identify problems together, share knowledge, connect resources and build action mechanisms that fit a world changing quickly. The 2026 theme marks a shift from reacting to volatility toward actively building partnerships. Challenges of growth, technology, climate, energy and supply chains cannot be solved by one actor alone.',
		'vi' => 'Hợp tác trong kỷ nguyên mới không chỉ là mở rộng các mối quan hệ sẵn có. Đó là khả năng cùng nhận diện vấn đề, chia sẻ tri thức, kết nối nguồn lực và xây dựng những cơ chế hành động phù hợp với một thế giới đang thay đổi nhanh chóng. Chủ đề AEF 2026 thể hiện sự chuyển dịch từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác.',
	) ) ); ?></p>
    <?php echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) ); ?>
    <figure class="figure"><img src="<?php echo esc_url( aef_img( 'visual/hcmc-dusk.jpg' ) ); ?>" alt=""><figcaption><?php echo esc_html( aef_t( array( 'en' => 'Ho Chi Minh City — host city. Illustration.', 'vi' => 'Thành phố Hồ Chí Minh — thành phố chủ nhà. Minh họa.' ) ) ); ?></figcaption></figure>
    <h3><?php echo esc_html( aef_t( array( 'en' => 'Three layers of value', 'vi' => 'Ba lớp giá trị' ) ) ); ?></h3>
    <div class="value-grid about-values">
      <article><b>01</b><h3><?php echo esc_html( aef_t( array( 'en' => 'Recognise', 'vi' => 'Nhận diện' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Read the shifts that are shaping regional and global economies.', 'vi' => 'Giải mã những chuyển dịch đang định hình kinh tế khu vực và toàn cầu.' ) ) ); ?></p></article>
      <article><b>02</b><h3><?php echo esc_html( aef_t( array( 'en' => 'Connect', 'vi' => 'Kết nối' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Create a meeting point for policy, capital, technology, knowledge and markets.', 'vi' => 'Tạo giao điểm giữa chính sách, vốn, công nghệ, tri thức và thị trường.' ) ) ); ?></p></article>
      <article><b>03</b><h3><?php echo esc_html( aef_t( array( 'en' => 'Act', 'vi' => 'Hành động' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Turn exchange into initiatives, commitments and a cooperation path after the Forum.', 'vi' => 'Chuyển trao đổi thành sáng kiến, cam kết và lộ trình hợp tác tiếp nối.' ) ) ); ?></p></article>
    </div>
    <p><a class="text-link" href="<?php echo esc_url( home_url( '/topics/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Explore the four content pillars', 'vi' => 'Khám phá bốn trụ cột nội dung' ) ) ); ?> →</a></p>
    <h3><?php echo esc_html( aef_t( array( 'en' => 'Three annual pillars', 'vi' => 'Ba trụ cột thường niên' ) ) ); ?></h3>
    <p><?php echo esc_html( aef_t( array( 'en' => 'The Forum is being positioned as the third of three annual meetings that together carry the cooperation agenda through the year.', 'vi' => 'Diễn đàn đang được định vị là trụ cột thứ ba trong ba hội nghị thường niên cùng nối chương trình hợp tác xuyên suốt năm.' ) ) ); ?></p>
    <div class="grid3" style="margin:20px 0 36px">
      <?php foreach ( $pillars as $i => $p ) : ?>
        <div class="card rv"><small>0<?php echo intval( $i + 1 ); ?></small><h3><?php echo esc_html( aef_t( $p[0] ) ); ?></h3><p><?php echo esc_html( aef_t( $p[1] ) ); ?></p></div>
      <?php endforeach; ?>
    </div>
    <h3><?php echo esc_html( aef_t( array( 'en' => 'Who does what', 'vi' => 'Ai làm gì' ) ) ); ?></h3>
    <div class="inst-grid about-inst" style="margin-top:18px">
      <div class="inst">
        <small><?php echo esc_html( aef_t( array( 'vi' => $s['host_1_role_vi'], 'en' => $s['host_1_role_en'] ) ) ); ?></small>
        <div class="inst-mark inst-mark-text">VN</div>
        <b><?php echo esc_html( aef_t( array( 'vi' => $s['host_1_name_vi'], 'en' => $s['host_1_name_en'] ) ) ); ?></b>
      </div>
      <div class="inst">
        <small><?php echo esc_html( aef_t( array( 'vi' => $s['host_2_role_vi'], 'en' => $s['host_2_role_en'] ) ) ); ?></small>
        <img src="<?php echo esc_url( aef_logo( 'ubnd.png' ) ); ?>" alt="">
        <b><?php echo esc_html( aef_t( array( 'vi' => $s['host_2_name_vi'], 'en' => $s['host_2_name_en'] ) ) ); ?></b>
      </div>
      <div class="inst">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Implementing centre', 'vi' => 'Đơn vị thực hiện' ) ) ); ?></small>
        <img src="<?php echo esc_url( aef_logo( 'c4ir.png' ) ); ?>" alt="">
        <b>HCMC C4IR</b>
      </div>
      <div class="inst">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Cooperating partner', 'vi' => 'Đối tác phối hợp' ) ) ); ?></small>
        <div class="inst-mark inst-mark-text">WEF</div>
        <b>World Economic Forum</b>
      </div>
    </div>
    <h3><?php echo esc_html( aef_t( array( 'en' => 'Explore every edition', 'vi' => 'Khám phá từng kỳ Diễn đàn' ) ) ); ?></h3>
    <div class="years" style="margin-top:18px">
      <?php while ( $editions->have_posts() ) : $editions->the_post(); ?>
        <a class="year rv" href="<?php the_permalink(); ?>">
          <b><?php echo esc_html( aef_meta( get_the_ID(), 'year', get_the_title() ) ); ?></b>
          <div><h3><?php echo esc_html( aef_bilingual_title( get_the_ID() ) ); ?></h3></div>
          <span><?php echo esc_html( aef_lang() === 'en' ? aef_meta( get_the_ID(), 'note_en' ) : aef_meta( get_the_ID(), 'note_vi' ) ); ?></span>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
  <aside class="aside">
    <dl>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Established', 'vi' => 'Khởi đầu' ) ) ); ?></dt><dd>2018</dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Editions held', 'vi' => 'Số kỳ đã tổ chức' ) ) ); ?></dt><dd><?php echo esc_html( aef_t( array( 'en' => 'Six, 2018 to 2025', 'vi' => 'Sáu kỳ, 2018 – 2025' ) ) ); ?></dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Host city', 'vi' => 'Thành phố chủ nhà' ) ) ); ?></dt><dd><?php echo esc_html( aef_t( array( 'en' => 'Ho Chi Minh City', 'vi' => 'Thành phố Hồ Chí Minh' ) ) ); ?></dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></dt><dd><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'General enquiries', 'vi' => 'Liên hệ chung' ) ) ); ?></dt><dd>contact@aef.vn</dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ) ) ); ?></dt><dd>support@aef.vn</dd>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ) ); ?></dt><dd>press@aef.vn</dd>
    </dl>
    <a class="btn btn-b" style="margin-top:22px;width:100%;justify-content:center" href="<?php echo esc_url( home_url( '/editions/2025/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'The 2025 edition', 'vi' => 'Kỳ năm 2025' ) ) ); ?></a>
  </aside>
</div></section>
