<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_travel_hotels() {
	return array(
		array(
			'tier'  => array( 'en' => '5-star reference', 'vi' => 'Tham khảo 5 sao' ),
			'note'  => array(
				'en' => 'Central Ho Chi Minh City. Distance to Thiskyhall should be checked before booking.',
				'vi' => 'Khu trung tâm Thành phố Hồ Chí Minh. Đại biểu tự kiểm tra thời gian tới Thiskyhall trước khi đặt phòng.',
			),
			'items' => array(
				array( 'Le Meridien Saigon', '3C Ton Duc Thang, Sai Gon Ward', '3C Tôn Đức Thắng, phường Sài Gòn', 'h5-00.jpg' ),
				array( 'Caravelle Saigon', '19–23 Lam Son Square, Sai Gon Ward', '19–23 Quảng trường Lam Sơn, phường Sài Gòn', 'h5-01.jpg' ),
				array( 'Reverie Saigon', '22–36 Nguyen Hue & 57–69F Dong Khoi, Sai Gon Ward', '22–36 Nguyễn Huệ & 57–69F Đồng Khởi, phường Sài Gòn', 'h5-02.jpg' ),
				array( 'Renaissance Riverside Hotel Saigon', '8–15 Ton Duc Thang, Sai Gon Ward', '8–15 Tôn Đức Thắng, phường Sài Gòn', 'h5-03.jpg' ),
				array( 'Sheraton Saigon Hotel & Towers', '88 Dong Khoi, Sai Gon Ward', '88 Đồng Khởi, phường Sài Gòn', 'h5-04.jpg' ),
				array( 'Park Hyatt Saigon', '2 Lam Son Square, Sai Gon Ward', '2 Quảng trường Lam Sơn, phường Sài Gòn', 'h5-05.jpg' ),
				array( 'Grand Hotel Saigon', '8 Dong Khoi, Sai Gon Ward', '8 Đồng Khởi, phường Sài Gòn', 'h5-06.jpg' ),
				array( 'Pullman Saigon Centre', '148 Tran Hung Dao, District 1', '148 Trần Hưng Đạo, Quận 1', 'h5-07.jpg' ),
				array( 'Majestic Saigon', '1 Dong Khoi, Sai Gon Ward', '1 Đồng Khởi, phường Sài Gòn', 'h5-08.jpg' ),
				array( 'Hilton Saigon', '11 Me Linh Square, Sai Gon Ward', '11 Công trường Mê Linh, phường Sài Gòn', 'h5-09.jpg' ),
				array( 'The Myst Dong Khoi', '6–8 Ho Huan Nghiep, Sai Gon Ward', '6–8 Hồ Huấn Nghiệp, phường Sài Gòn', 'h5-10.jpg' ),
				array( 'Hotel des Arts Saigon', '76–78 Nguyen Thi Minh Khai, District 3', '76–78 Nguyễn Thị Minh Khai, Quận 3', 'h5-11.jpg' ),
				array( 'New World Saigon Hotel', '76 Le Lai, District 1', '76 Lê Lai, Quận 1', 'h5-12.jpg' ),
				array( 'JW Marriott Hotel & Suites Saigon', 'Hai Ba Trung & Le Duan, Sai Gon Ward', 'Góc Hai Bà Trưng & Lê Duẩn, phường Sài Gòn', 'h5-13.jpg' ),
				array( 'Indigo Saigon the City by IHG', '9–11 Ly Tu Trong, District 1', '9–11 Lý Tự Trọng, Quận 1', 'h5-14.jpg' ),
				array( 'Somerset Chancellor Court', '21–23 Nguyen Thi Minh Khai, Sai Gon Ward', '21–23 Nguyễn Thị Minh Khai, phường Sài Gòn', 'h5-15.jpg' ),
			),
		),
		array(
			'tier'  => array( 'en' => '4-star reference', 'vi' => 'Tham khảo 4 sao' ),
			'note'  => array(
				'en' => 'Central-city references. Check travel time to Sala / Thiskyhall before booking.',
				'vi' => 'Tham khảo khu trung tâm. Kiểm tra thời gian tới Sala / Thiskyhall trước khi đặt.',
			),
			'items' => array(
				array( 'Novotel Saigon Centre', '167 Hai Ba Trung, Xuan Hoa Ward', '167 Hai Bà Trưng, phường Xuân Hòa', 'h4-00.jpg' ),
				array( 'Hotel Continental Saigon', '132–134 Dong Khoi, Sai Gon Ward', '132–134 Đồng Khởi, phường Sài Gòn', 'h4-01.jpg' ),
				array( 'Northern Hotel', '11A Thi Sach, District 1', '11A Thi Sách, Quận 1', 'h4-02.jpg' ),
				array( 'Silverland Jolie Hotel & Spa', '14–16 Le Lai, Ben Thanh Ward', '14–16 Lê Lai, phường Bến Thành', 'h4-03.jpg' ),
				array( 'Liberty Central Saigon Citypoint', '59 Pasteur, Sai Gon Ward', '59 Pasteur, phường Sài Gòn', 'h4-04.jpg' ),
				array( 'Liberty Central Saigon Riverside', '17 Ton Duc Thang, Sai Gon Ward', '17 Tôn Đức Thắng, phường Sài Gòn', 'h4-05.jpg' ),
				array( 'Alagon D\'Antique Hotel & Spa', '303–309 Ly Tu Trong, District 1', '303–309 Lý Tự Trọng, Quận 1', 'h4-06.jpg' ),
				array( 'Au Lac Charner Hotel', '87 Ho Tung Mau, District 1', '87 Hồ Tùng Mậu, Quận 1', 'h4-07.jpg' ),
				array( 'Royal Hotel Saigon', '133 Nguyen Hue, Sai Gon Ward', '133 Nguyễn Huệ, phường Sài Gòn', 'h4-08.jpg' ),
				array( 'Happy Life Grand Hotel & Sky Bar', '102–106 Le Thi Hong Gam, District 1', '102–106 Lê Thị Hồng Gấm, Quận 1', 'h4-09.jpg' ),
				array( 'Liberty Central Saigon Centre', '179 Le Thanh Ton, Ben Thanh Ward', '179 Lê Thánh Tôn, phường Bến Thành', 'h4-10.jpg' ),
				array( 'Palace Hotel Saigon', '56–66 Nguyen Hue, Sai Gon Ward', '56–66 Nguyễn Huệ, phường Sài Gòn', 'h4-11.jpg' ),
				array( 'Icon Saigon', '65–67 Hai Ba Trung, District 1', '65–67 Hai Bà Trưng, Quận 1', 'h4-12.jpg' ),
				array( 'Muong Thanh Grand Saigon Centre', '8A Mac Dinh Chi, District 1', '8A Mạc Đĩnh Chi, Quận 1', 'h4-13.jpg' ),
				array( 'The Odys Boutique Hotel', '65–69 Nguyen Thai Binh, District 1', '65–69 Nguyễn Thái Bình, Quận 1', 'h4-14.jpg' ),
				array( 'Kin Hotel Thi Sach', '11A Thi Sach, District 1', '11A Thi Sách, Quận 1', 'h4-15.jpg' ),
			),
		),
	);
}

function aef_travel_city() {
	return array(
		array(
			'id'    => 'eat',
			'title' => array( 'en' => 'Restaurant', 'vi' => 'Ẩm thực' ),
			'image' => 'travel/city/eat.jpg',
			'items' => array(
				array( 'Quan An Ngon', array( 'en' => 'Vietnamese street dishes, central city', 'vi' => 'Món vỉa hè Việt, khu trung tâm' ), 'travel/city/eat.jpg' ),
				array( 'Cuc Gach Quan', array( 'en' => 'House-style Vietnamese, District 3', 'vi' => 'Cơm nhà Việt, Quận 3' ), 'travel/city/eat.jpg' ),
				array( 'The Deck Saigon', array( 'en' => 'Riverside, Thu Duc', 'vi' => 'Bờ sông, Thủ Đức' ), 'travel/city/sala.jpg' ),
				array( 'Secret Garden', array( 'en' => 'Rooftop Vietnamese, District 1', 'vi' => 'Sân thượng, Quận 1' ), 'travel/city/eat.jpg' ),
			),
		),
		array(
			'id'    => 'coffee',
			'title' => array( 'en' => 'Coffee & bar', 'vi' => 'Cà phê' ),
			'image' => 'travel/city/coffee.jpg',
			'items' => array(
				array( 'The Workshop', array( 'en' => 'Specialty coffee, District 1', 'vi' => 'Cà phê specialty, Quận 1' ), 'travel/city/coffee.jpg' ),
				array( 'L’Usine', array( 'en' => 'Cafe and store, Dong Khoi area', 'vi' => 'Cà phê và cửa hàng, khu Đồng Khởi' ), 'travel/city/coffee.jpg' ),
				array( 'Cong Caphe', array( 'en' => 'Local chain, several central sites', 'vi' => 'Chuỗi nội địa, nhiều điểm trung tâm' ), 'travel/city/coffee.jpg' ),
				array( 'Highlands Coffee', array( 'en' => 'Widely available, including the airport', 'vi' => 'Phổ biến, kể cả sân bay' ), 'travel/city/airport.jpg' ),
			),
		),
		array(
			'id'    => 'see',
			'title' => array( 'en' => 'Sightseeing', 'vi' => 'Tham quan' ),
			'image' => 'travel/city/see.jpg',
			'items' => array(
				array( 'Notre-Dame Cathedral & Central Post Office', array( 'en' => 'Colonial civic core', 'vi' => 'Khu trung tâm thời thuộc địa' ), 'travel/city/see.jpg' ),
				array( 'Independence Palace', array( 'en' => 'Reunification Palace', 'vi' => 'Dinh Độc Lập' ), 'travel/city/see.jpg' ),
				array( 'Nguyen Hue walking street', array( 'en' => 'Evening public space', 'vi' => 'Phố đi bộ buổi tối' ), 'travel/city/see.jpg' ),
				array( 'Thu Thiem / Sala waterfront', array( 'en' => 'Near the Forum venue', 'vi' => 'Gần địa điểm Diễn đàn' ), 'travel/city/sala.jpg' ),
			),
		),
	);
}

function aef_travel_moves() {
	return array(
		array(
			array( 'en' => 'Airport', 'vi' => 'Sân bay' ),
			array( 'en' => 'Tan Son Nhat (SGN) is the working airport. Allow 40–70 minutes to Sala / Thiskyhall in peak traffic.', 'vi' => 'Sân bay Tân Sơn Nhất (SGN). Dự trù 40–70 phút tới Sala / Thiskyhall giờ cao điểm.' ),
			'travel/city/airport.jpg',
		),
		array(
			array( 'en' => 'Ride-hailing', 'vi' => 'Ứng dụng gọi xe' ),
			array( 'en' => 'Grab, Be and Xanh SM are the usual options. Book from the marked pickup zone. A local SIM or eSIM helps.', 'vi' => 'Grab, Be và Xanh SM là lựa chọn phổ biến. Đón ở điểm ghi rõ. Nên có SIM / eSIM.' ),
			'visual/arrival.jpg',
		),
		array(
			array( 'en' => 'Taxi', 'vi' => 'Taxi' ),
			array( 'en' => 'Use a metered company from the official rank. Unmarked cars at the terminal are not recommended.', 'vi' => 'Dùng hãng có đồng hồ tại điểm chính thức. Không nên lên xe không biển tại cửa ga.' ),
			'travel/city/airport.jpg',
		),
		array(
			array( 'en' => 'Forum shuttle', 'vi' => 'Xe trung chuyển' ),
			array( 'en' => 'Confirmed delegates receive shuttle points and hotel routes before Forum week.', 'vi' => 'Đại biểu đã xác nhận nhận điểm xe và tuyến khách sạn trước tuần Diễn đàn.' ),
			'visual/forum-hall.jpg',
		),
	);
}

function aef_travel_img( $file ) {
	return aef_img( $file );
}

function aef_place_card( $img, $title, $meta, $credit = '' ) {
	ob_start();
	?>
	<article class="place-card">
		<figure>
			<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" width="720" height="480">
			<?php if ( $credit ) : ?>
				<figcaption><?php echo esc_html( $credit ); ?></figcaption>
			<?php endif; ?>
		</figure>
		<h3><?php echo esc_html( $title ); ?></h3>
		<?php if ( $meta ) : ?>
			<p><?php echo esc_html( $meta ); ?></p>
		<?php endif; ?>
	</article>
	<?php
	return ob_get_clean();
}

function aef_render_travel() {
	$s = aef_settings();
	$nav = array(
		array( 'venue', array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ),
		array( 'stay', array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ),
		array( 'eat', array( 'en' => 'Restaurant', 'vi' => 'Ẩm thực' ) ),
		array( 'coffee', array( 'en' => 'Coffee', 'vi' => 'Cà phê' ) ),
		array( 'see', array( 'en' => 'Sightseeing', 'vi' => 'Tham quan' ) ),
		array( 'move', array( 'en' => 'Transport', 'vi' => 'Di chuyển' ) ),
		array( 'notes', array( 'en' => 'Notes', 'vi' => 'Lưu ý' ) ),
	);
	$illu = aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) );
	ob_start();
	?>
	<div class="travel-page">
		<header class="travel-hero">
			<div class="shell">
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Ho Chi Minh City', 'vi' => 'Thành phố Hồ Chí Minh' ) ) ); ?></p>
				<h1><?php echo esc_html( aef_t( array( 'en' => 'Plan your visit', 'vi' => 'Lên kế hoạch chuyến đi' ) ) ); ?></h1>
				<p class="lead"><?php echo esc_html( aef_t( array(
					'en' => 'One page for the venue, a central-city hotel reference, how to move, and a short city list. Not a booking and not the official Organising Committee list.',
					'vi' => 'Một trang cho địa điểm, danh sách khách sạn tham khảo khu trung tâm, cách di chuyển và gợi ý thành phố. Không phải chỗ đặt phòng và không phải danh sách Ban Tổ chức.',
				) ) ); ?></p>
			</div>
		</header>

		<nav class="travel-nav" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Travel sections', 'vi' => 'Mục cẩm nang' ) ) ); ?>">
			<div class="shell travel-nav-inner">
				<?php foreach ( $nav as $item ) : ?>
					<a href="#<?php echo esc_attr( $item[0] ); ?>"><?php echo esc_html( aef_t( $item[1] ) ); ?></a>
				<?php endforeach; ?>
			</div>
		</nav>

		<section class="travel-sec" id="venue">
			<div class="shell">
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Forum venue', 'vi' => 'Địa điểm Diễn đàn' ) ) ); ?></p>
				<h2><?php echo esc_html( aef_t( array( 'en' => 'Thiskyhall, Sala', 'vi' => 'Thiskyhall, Sala' ) ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></p>
				<figure class="travel-feature">
					<img src="<?php echo esc_url( aef_img( 'travel/city/sala.jpg' ) ); ?>" alt="Sala / Thu Thiem" width="1200" height="675">
					<figcaption><?php echo esc_html( $illu ); ?> · Sala / Thủ Thiêm</figcaption>
				</figure>
				<p><?php echo esc_html( aef_t( array(
					'en' => 'Main forum 27–28 October 2026 at Thiskyhall, Sala. Forum-week activities 26–29 October in Ho Chi Minh City. Delegate and media access follow separate flows.',
					'vi' => 'Diễn đàn chính 27–28/10/2026 tại Thiskyhall, Sala. Hoạt động trong tuần Diễn đàn 26–29/10 tại Thành phố Hồ Chí Minh. Luồng Đại biểu và Báo chí tách riêng.',
				) ) ); ?></p>
			</div>
		</section>

		<section class="travel-sec" id="stay">
			<div class="shell">
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Accommodation', 'vi' => 'Lưu trú' ) ) ); ?></p>
				<h2><?php echo esc_html( aef_t( array( 'en' => 'A central-city reference', 'vi' => 'Danh sách tham khảo khu trung tâm' ) ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aef_t( array(
					'en' => 'A public central-city reference to help delegates plan. It is not an AEF booking and not a measured distance from Thiskyhall. Delegates book independently.',
					'vi' => 'Danh sách tham khảo khu trung tâm để đại biểu chủ động sắp xếp. Không phải chỗ đặt phòng AEF và không phải khoảng cách đo từ Thiskyhall. Đại biểu đặt phòng độc lập.',
				) ) ); ?></p>
				<?php foreach ( aef_travel_hotels() as $group ) : ?>
					<div class="hotel-block">
						<div class="hotel-head">
							<h3><?php echo esc_html( aef_t( $group['tier'] ) ); ?></h3>
							<p><?php echo esc_html( aef_t( $group['note'] ) ); ?></p>
						</div>
						<div class="place-grid">
							<?php
							foreach ( $group['items'] as $h ) {
								echo aef_place_card(
									aef_img( 'travel/hotels/' . $h[3] ),
									$h[0],
									aef_lang() === 'vi' ? $h[2] : $h[1]
								);
							}
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<?php foreach ( aef_travel_city() as $col ) : ?>
			<section class="travel-sec" id="<?php echo esc_attr( $col['id'] ); ?>">
				<div class="shell">
					<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'The city', 'vi' => 'Thành phố' ) ) ); ?></p>
					<h2><?php echo esc_html( aef_t( $col['title'] ) ); ?></h2>
					<p class="lead"><?php echo esc_html( aef_t( array(
						'en' => 'A short list for free hours. Not AEF partners. Opening hours change — check before you go.',
						'vi' => 'Danh sách ngắn cho thời gian rảnh. Không phải đối tác AEF. Giờ mở cửa thay đổi — kiểm tra trước khi đến.',
					) ) ); ?></p>
					<div class="place-grid">
						<?php
						foreach ( $col['items'] as $item ) {
							echo aef_place_card(
								aef_img( $item[2] ),
								$item[0],
								aef_t( $item[1] ),
								$illu
							);
						}
						?>
					</div>
				</div>
			</section>
		<?php endforeach; ?>

		<section class="travel-sec" id="move">
			<div class="shell">
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Transportation', 'vi' => 'Di chuyển' ) ) ); ?></p>
				<h2><?php echo aef_lang() === 'vi' ? 'Từ sân bay tới Sala' : 'From the airport to Sala'; ?></h2>
				<div class="place-grid move-cards">
					<?php
					foreach ( aef_travel_moves() as $m ) {
						echo aef_place_card(
							aef_img( $m[2] ),
							aef_t( $m[0] ),
							aef_t( $m[1] ),
							$illu
						);
					}
					?>
				</div>
			</div>
		</section>

		<section class="travel-sec" id="notes">
			<div class="shell travel-notes">
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Special note', 'vi' => 'Lưu ý' ) ) ); ?></p>
				<h2><?php echo esc_html( aef_t( array( 'en' => 'Before you travel', 'vi' => 'Trước khi lên đường' ) ) ); ?></h2>
				<ul>
					<li><?php echo esc_html( aef_t( array( 'en' => 'This page is a city kit for delegates. It is not a booking, a visa, or a guarantee of access.', 'vi' => 'Trang này là cẩm nang cho đại biểu. Không phải chỗ đặt phòng, thị thực hay bảo đảm quyền vào cửa.' ) ) ); ?></li>
					<li><?php echo esc_html( aef_t( array( 'en' => 'Attendance is by invitation and confirmed registration. Some activities may have their own conditions.', 'vi' => 'Tham dự theo thư mời và xác nhận đăng ký. Một số hoạt động có thể có điều kiện riêng.' ) ) ); ?></li>
					<li><?php echo esc_html( aef_t( array( 'en' => 'Peak traffic in the city is usually 07:00–09:00 and 16:30–19:00.', 'vi' => 'Giờ cao điểm thường 07:00–09:00 và 16:30–19:00.' ) ) ); ?></li>
					<li><?php echo esc_html( aef_t( array( 'en' => 'Keep a digital and a paper copy of your invitation or confirmation.', 'vi' => 'Giữ bản số và bản giấy thư mời hoặc xác nhận.' ) ) ); ?></li>
					<li><?php echo esc_html( aef_t( array( 'en' => 'Visa and entry follow current regulations. AEF cannot decide a visa.', 'vi' => 'Thị thực và nhập cảnh theo quy định hiện hành. AEF không quyết định thị thực.' ) ) ); ?></li>
					<li><?php echo esc_html( aef_t( array( 'en' => 'Press accreditation sits with Media when that desk is published. Until then write to contact@aef.vn.', 'vi' => 'Tác nghiệp báo chí sẽ nằm ở mục Truyền thông khi đầu mối được công bố. Tạm thời gửi contact@aef.vn.' ) ) ); ?></li>
				</ul>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}
