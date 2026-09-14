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
$q = new WP_Query( function_exists( 'aef_speaker_public_args' ) ? aef_speaker_public_args() : array( 'post_type' => 'aef_speaker', 'posts_per_page' => 80, 'orderby' => 'menu_order title' ) );
?>
<section class="blk speaker-index"><div class="shell">
  <p class="spk-banner"><?php echo esc_html( aef_t( array(
	  'en' => 'Profiles follow roles in the Forum Project Proposal. Official names, titles and biographies are updated as the Organising Committee confirms speakers.',
	  'vi' => 'Hồ sơ dưới đây theo vai trò nêu trong Đề án tổ chức Diễn đàn. Tên, chức danh và tiểu sử chính thức được cập nhật khi Ban Tổ chức xác nhận diễn giả.',
  ) ) ); ?></p>
  <div class="people">
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
</div></section>
<?php get_footer();
