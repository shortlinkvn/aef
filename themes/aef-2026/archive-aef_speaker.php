<?php
get_header();
echo aef_opener(
	'AEF 2026',
	aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ),
	aef_t( array(
		'en' => 'Confirmed speakers appear here. Roles at each session include chair, keynote, welcome remarks, dialogue, presenter, moderator and panelist. Names not yet confirmed stay off this list.',
		'vi' => 'Chỉ hiện diễn giả đã xác nhận. Vai trò tại phiên gồm chủ trì, phát biểu đề dẫn, chào mừng, đối thoại, tham luận, điều phối viên và diễn giả tọa đàm. Chưa chốt thì không đưa tên lên danh sách này.',
	) ),
	aef_img( 'plenary.jpg' ),
	aef_t( array( 'en' => 'Reference image', 'vi' => 'Ảnh minh họa' ) ),
	'compact'
);
$q = new WP_Query( function_exists( 'aef_speaker_public_args' ) ? aef_speaker_public_args() : array( 'post_type' => 'aef_speaker', 'posts_per_page' => 400, 'orderby' => 'menu_order title' ) );

// Chỉ liệt kê những quốc gia THỰC SỰ có diễn giả trong lần truy vấn này — tránh
// hiện 1 danh sách quốc gia dài mà bấm vào phần lớn ra "không có kết quả".
$all_countries    = function_exists( 'aef_countries' ) ? aef_countries() : array();
$present_country  = array();
if ( $q->have_posts() ) {
	foreach ( $q->posts as $p ) {
		$code = function_exists( 'aef_country_code_from_value' ) ? aef_country_code_from_value( aef_meta( $p->ID, 'country' ) ) : '';
		if ( $code && isset( $all_countries[ $code ] ) ) {
			$present_country[ $code ] = $all_countries[ $code ];
		}
	}
	uasort(
		$present_country,
		function ( $a, $b ) {
			return strcasecmp( aef_t( $a ), aef_t( $b ) );
		}
	);
}
$total = $q->post_count;
?>
<section class="blk speaker-index"><div class="shell">
  <p class="spk-banner"><?php echo esc_html( aef_t( array(
	  'en' => 'Profiles follow roles in the Forum Project Proposal. Official names, titles and biographies are updated as the Organising Committee confirms speakers.',
	  'vi' => 'Hồ sơ dưới đây theo vai trò nêu trong Đề án tổ chức Diễn đàn. Tên, chức danh và tiểu sử chính thức được cập nhật khi Ban Tổ chức xác nhận diễn giả.',
  ) ) ); ?></p>
  <?php if ( $total > 12 ) : ?>
  <div class="spk-filter" data-spk-filter data-spk-total="<?php echo esc_attr( $total ); ?>">
    <input type="search" class="spk-search" data-spk-search-input placeholder="<?php echo esc_attr( aef_t( array( 'en' => 'Search by name, title or organisation', 'vi' => 'Tìm theo tên, chức danh hoặc tổ chức' ) ) ); ?>">
    <?php if ( $present_country ) : ?>
    <select class="spk-country" data-spk-country-select>
      <option value=""><?php echo esc_html( aef_t( array( 'en' => 'All countries', 'vi' => 'Tất cả quốc gia' ) ) ); ?></option>
      <?php foreach ( $present_country as $code => $name ) : ?>
      <option value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( aef_t( $name ) ); ?></option>
      <?php endforeach; ?>
    </select>
    <?php endif; ?>
    <p class="spk-count" data-spk-count></p>
  </div>
  <?php endif; ?>
  <div class="people" data-spk-list>
    <?php
    $i = 0;
    while ( $q->have_posts() ) :
		$q->the_post();
		$i++;
		get_template_part( 'partials/speaker', 'card', array( 'id' => get_the_ID(), 'i' => $i ) );
    endwhile;
    wp_reset_postdata();
    ?>
  </div>
  <p class="spk-empty" data-spk-empty hidden><?php echo esc_html( aef_t( array( 'en' => 'No speaker matches the current search.', 'vi' => 'Không có diễn giả phù hợp với tìm kiếm.' ) ) ); ?></p>
</div></section>
<?php get_footer();
