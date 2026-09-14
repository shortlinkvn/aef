<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_travel_hotels() {
	return array(
		array(
			'tier'  => array( 'en' => '5-star reference', 'vi' => 'Tham khảo 5 sao' ),
			'note'  => array(
				'en' => 'Mostly central Ho Chi Minh City (around Saigon / District 1). Not measured from Thiskyhall.',
				'vi' => 'Chủ yếu khu trung tâm (phường Sài Gòn / Quận 1). Không tính khoảng cách từ Thiskyhall.',
			),
			'items' => array(
				array( 'Le Meridien Saigon', '3C Ton Duc Thang, Sai Gon Ward', '3C Tôn Đức Thắng, phường Sài Gòn' ),
				array( 'Caravelle Saigon', '19–23 Lam Son Square, Sai Gon Ward', '19–23 Quảng trường Lam Sơn, phường Sài Gòn' ),
				array( 'Reverie Saigon', '22–36 Nguyen Hue & 57–69F Dong Khoi, Sai Gon Ward', '22–36 Nguyễn Huệ & 57–69F Đồng Khởi, phường Sài Gòn' ),
				array( 'Renaissance Riverside Hotel Saigon', '8–15 Ton Duc Thang, Sai Gon Ward', '8–15 Tôn Đức Thắng, phường Sài Gòn' ),
				array( 'Sheraton Saigon Hotel & Towers', '88 Dong Khoi, Sai Gon Ward', '88 Đồng Khởi, phường Sài Gòn' ),
				array( 'Park Hyatt Saigon', '2 Lam Son Square, Sai Gon Ward', '2 Quảng trường Lam Sơn, phường Sài Gòn' ),
				array( 'Grand Hotel Saigon', '8 Dong Khoi, Sai Gon Ward', '8 Đồng Khởi, phường Sài Gòn' ),
				array( 'Pullman Saigon Centre', '148 Tran Hung Dao, District 1', '148 Trần Hưng Đạo, Quận 1' ),
				array( 'Majestic Saigon', '1 Dong Khoi, Sai Gon Ward', '1 Đồng Khởi, phường Sài Gòn' ),
				array( 'Hilton Saigon', '11 Me Linh Square, Sai Gon Ward', '11 Công trường Mê Linh, phường Sài Gòn' ),
				array( 'The Myst Dong Khoi', '6–8 Ho Huan Nghiep, Sai Gon Ward', '6–8 Hồ Huấn Nghiệp, phường Sài Gòn' ),
				array( 'Hotel des Arts Saigon', '76–78 Nguyen Thi Minh Khai, District 3', '76–78 Nguyễn Thị Minh Khai, Quận 3' ),
				array( 'New World Saigon Hotel', '76 Le Lai, District 1', '76 Lê Lai, Quận 1' ),
				array( 'JW Marriott Hotel & Suites Saigon', 'Hai Ba Trung & Le Duan, Sai Gon Ward', 'Góc Hai Bà Trưng & Lê Duẩn, phường Sài Gòn' ),
				array( 'Indigo Saigon the City by IHG', '9–11 Ly Tu Trong, District 1', '9–11 Lý Tự Trọng, Quận 1' ),
				array( 'Somerset Chancellor Court', '21–23 Nguyen Thi Minh Khai, Sai Gon Ward', '21–23 Nguyễn Thị Minh Khai, phường Sài Gòn' ),
			),
		),
		array(
			'tier'  => array( 'en' => '4-star reference', 'vi' => 'Tham khảo 4 sao' ),
			'note'  => array(
				'en' => 'Central-city references. Confirm travel time to Sala / Thiskyhall before booking.',
				'vi' => 'Tham khảo khu trung tâm. Kiểm tra thời gian tới Sala / Thiskyhall trước khi đặt.',
			),
			'items' => array(
				array( 'Novotel Saigon Centre', '167 Hai Ba Trung, Xuan Hoa Ward', '167 Hai Bà Trưng, phường Xuân Hòa' ),
				array( 'Hotel Continental Saigon', '132–134 Dong Khoi, Sai Gon Ward', '132–134 Đồng Khởi, phường Sài Gòn' ),
				array( 'Northern Hotel', '11A Thi Sach, District 1', '11A Thi Sách, Quận 1' ),
				array( 'Silverland Jolie Hotel & Spa', '14–16 Le Lai, Ben Thanh Ward', '14–16 Lê Lai, phường Bến Thành' ),
				array( 'Liberty Central Saigon Citypoint', '59 Pasteur, Sai Gon Ward', '59 Pasteur, phường Sài Gòn' ),
				array( 'Liberty Central Saigon Riverside', '17 Ton Duc Thang, Sai Gon Ward', '17 Tôn Đức Thắng, phường Sài Gòn' ),
				array( 'Alagon D\'Antique Hotel & Spa', '303–309 Ly Tu Trong, District 1', '303–309 Lý Tự Trọng, Quận 1' ),
				array( 'Au Lac Charner Hotel', '87 Ho Tung Mau, District 1', '87 Hồ Tùng Mậu, Quận 1' ),
				array( 'Royal Hotel Saigon', '133 Nguyen Hue, Sai Gon Ward', '133 Nguyễn Huệ, phường Sài Gòn' ),
				array( 'Happy Life Grand Hotel & Sky Bar', '102–106 Le Thi Hong Gam, District 1', '102–106 Lê Thị Hồng Gấm, Quận 1' ),
				array( 'Liberty Central Saigon Centre', '179 Le Thanh Ton, Ben Thanh Ward', '179 Lê Thánh Tôn, phường Bến Thành' ),
				array( 'Palace Hotel Saigon', '56–66 Nguyen Hue, Sai Gon Ward', '56–66 Nguyễn Huệ, phường Sài Gòn' ),
				array( 'Icon Saigon', '65–67 Hai Ba Trung, District 1', '65–67 Hai Bà Trưng, Quận 1' ),
				array( 'Muong Thanh Grand Saigon Centre', '8A Mac Dinh Chi, District 1', '8A Mạc Đĩnh Chi, Quận 1' ),
				array( 'The Odys Boutique Hotel', '65–69 Nguyen Thai Binh, District 1', '65–69 Nguyễn Thái Bình, Quận 1' ),
				array( 'Kin Hotel Thi Sach', '11A Thi Sach, District 1', '11A Thi Sách, Quận 1' ),
			),
		),
	);
}

function aef_travel_city() {
	return array(
		array(
			'id'    => 'eat',
			'title' => array( 'en' => 'Eat', 'vi' => 'Ăn' ),
			'items' => array(
				array( 'Quan An Ngon', array( 'en' => 'Vietnamese street dishes, central city', 'vi' => 'Món vỉa hè Việt, khu trung tâm' ) ),
				array( 'Cuc Gach Quan', array( 'en' => 'House-style Vietnamese, District 3', 'vi' => 'Cơm nhà Việt, Quận 3' ) ),
				array( 'The Deck Saigon', array( 'en' => 'Riverside, District 2 / Thu Duc', 'vi' => 'Bờ sông, Thủ Đức' ) ),
				array( 'Secret Garden', array( 'en' => 'Rooftop Vietnamese, District 1', 'vi' => 'Sân thượng, Quận 1' ) ),
			),
		),
		array(
			'id'    => 'coffee',
			'title' => array( 'en' => 'Coffee', 'vi' => 'Cà phê' ),
			'items' => array(
				array( 'The Workshop', array( 'en' => 'Specialty coffee, District 1', 'vi' => 'Cà phê specialty, Quận 1' ) ),
				array( 'L’Usine', array( 'en' => 'Cafe and store, Dong Khoi area', 'vi' => 'Cà phê và cửa hàng, khu Đồng Khởi' ) ),
				array( 'Cong Caphe', array( 'en' => 'Local chain, several central sites', 'vi' => 'Chuỗi nội địa, nhiều điểm trung tâm' ) ),
				array( 'Highlands Coffee', array( 'en' => 'Widely available, including the airport', 'vi' => 'Phổ biến, kể cả sân bay' ) ),
			),
		),
		array(
			'id'    => 'see',
			'title' => array( 'en' => 'See', 'vi' => 'Tham quan' ),
			'items' => array(
				array( 'Notre-Dame Cathedral & Central Post Office', array( 'en' => 'Colonial civic core', 'vi' => 'Khu trung tâm thời thuộc địa' ) ),
				array( 'Independence Palace', array( 'en' => 'Reunification Palace', 'vi' => 'Dinh Độc Lập' ) ),
				array( 'Nguyen Hue walking street', array( 'en' => 'Evening public space', 'vi' => 'Phố đi bộ buổi tối' ) ),
				array( 'Thu Thiem / Sala waterfront', array( 'en' => 'Near the Forum venue', 'vi' => 'Gần địa điểm Diễn đàn' ) ),
			),
		),
	);
}

function aef_travel_moves() {
	return array(
		array(
			array( 'en' => 'Airport', 'vi' => 'Sân bay' ),
			array( 'en' => 'Tan Son Nhat (SGN) is the working airport. Allow 40–70 minutes to Sala / Thiskyhall in peak traffic.', 'vi' => 'Sân bay Tân Sơn Nhất (SGN). Dự trù 40–70 phút tới Sala / Thiskyhall giờ cao điểm.' ),
		),
		array(
			array( 'en' => 'Ride-hailing', 'vi' => 'Ứng dụng gọi xe' ),
			array( 'en' => 'Grab, Be and Xanh SM are the usual options. Book from the marked pickup zone. A local SIM or eSIM helps.', 'vi' => 'Grab, Be và Xanh SM là lựa chọn phổ biến. Đón ở điểm ghi rõ. Nên có SIM / eSIM.' ),
		),
		array(
			array( 'en' => 'Taxi', 'vi' => 'Taxi' ),
			array( 'en' => 'Use a metered company from the official rank. Unmarked cars at the terminal are not recommended.', 'vi' => 'Dùng hãng có đồng hồ tại điểm chính thức. Không nên lên xe không biển tại cửa ga.' ),
		),
		array(
			array( 'en' => 'Forum shuttle', 'vi' => 'Xe trung chuyển' ),
			array( 'en' => 'Official shuttle points and hotel routes will be published when the Organising Committee confirms them.', 'vi' => 'Điểm xe và tuyến khách sạn sẽ đăng khi Ban Tổ chức chốt.' ),
		),
	);
}

function aef_render_travel() {
	$s = aef_settings();
	$nav = array(
		array( 'venue', array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ),
		array( 'stay', array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ),
		array( 'move', array( 'en' => 'Move', 'vi' => 'Di chuyển' ) ),
		array( 'city', array( 'en' => 'City', 'vi' => 'Thành phố' ) ),
		array( 'notes', array( 'en' => 'Notes', 'vi' => 'Lưu ý' ) ),
	);
	ob_start();
	?>
	<nav class="travel-nav" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Travel sections', 'vi' => 'Mục cẩm nang' ) ) ); ?>">
		<div class="shell travel-nav-inner">
			<?php foreach ( $nav as $item ) : ?>
				<a href="#<?php echo esc_attr( $item[0] ); ?>"><?php echo esc_html( aef_t( $item[1] ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</nav>

	<section class="travel-sec" id="venue">
		<div class="shell travel-split">
			<div>
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Forum venue', 'vi' => 'Địa điểm Diễn đàn' ) ) ); ?></p>
				<h2><?php echo esc_html( aef_t( array( 'en' => 'Thiskyhall, Sala', 'vi' => 'Thiskyhall, Sala' ) ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></p>
				<p><?php echo esc_html( aef_t( array(
					'en' => 'Main forum 27–28 October. Forum week 25–30 October. Floor plans, entrances and shuttle points replace this note after approval.',
					'vi' => 'Diễn đàn chính 27–28/10. Tuần lễ 25–30/10. Sơ đồ, lối vào và điểm xe sẽ thay ghi chú này sau khi duyệt.',
				) ) ); ?></p>
			</div>
			<ol class="travel-steps">
				<li><b>01</b><span><?php echo esc_html( aef_t( array( 'en' => 'Drop-off → security → check-in → badge → approved session', 'vi' => 'Trả khách → an ninh → check-in → nhận thẻ → phiên đã duyệt' ) ) ); ?></span></li>
				<li><b>02</b><span><?php echo esc_html( aef_t( array( 'en' => 'Media use a separate entrance and the Media Centre', 'vi' => 'Báo chí đi lối riêng và Trung tâm Báo chí' ) ) ); ?></span></li>
			</ol>
		</div>
	</section>

	<section class="travel-sec mist" id="stay">
		<div class="shell">
			<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ) ); ?></p>
			<h2><?php echo aef_lang() === 'vi' ? 'Danh sách tham khảo<br>khu trung tâm' : 'A central-city<br>reference list'; ?></h2>
			<p class="lead"><?php echo esc_html( aef_t( array(
				'en' => 'Names and addresses follow a public Ho Chi Minh City travel guide. This is not an AEF booking, not an official hotel, and not “3–5 km from Thiskyhall”. The Organising Committee list will replace it.',
				'vi' => 'Tên và địa chỉ theo cẩm nang thành phố công khai. Đây không phải chỗ đặt phòng AEF, không phải khách sạn chính thức, và không phải “cách Thiskyhall 3–5 km”. Danh sách Ban Tổ chức sẽ thay thế.',
			) ) ); ?></p>
			<?php foreach ( aef_travel_hotels() as $group ) : ?>
				<div class="hotel-block">
					<div class="hotel-head">
						<h3><?php echo esc_html( aef_t( $group['tier'] ) ); ?></h3>
						<p><?php echo esc_html( aef_t( $group['note'] ) ); ?></p>
					</div>
					<div class="hotel-list">
						<?php foreach ( $group['items'] as $h ) : ?>
							<div class="hotel-row">
								<b><?php echo esc_html( $h[0] ); ?></b>
								<span><?php echo esc_html( aef_lang() === 'vi' ? $h[2] : $h[1] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="travel-sec" id="move">
		<div class="shell">
			<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Move', 'vi' => 'Di chuyển' ) ) ); ?></p>
			<h2><?php echo aef_lang() === 'vi' ? 'Từ sân bay<br>tới Sala' : 'From the airport<br>to Sala'; ?></h2>
			<div class="move-grid">
				<?php foreach ( aef_travel_moves() as $m ) : ?>
					<article>
						<h3><?php echo esc_html( aef_t( $m[0] ) ); ?></h3>
						<p><?php echo esc_html( aef_t( $m[1] ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="travel-sec mist" id="city">
		<div class="shell">
			<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'The city', 'vi' => 'Thành phố' ) ) ); ?></p>
			<h2><?php echo aef_lang() === 'vi' ? 'Ăn, cà phê,<br>tham quan' : 'Eat, coffee,<br>see'; ?></h2>
			<p class="lead"><?php echo esc_html( aef_t( array(
				'en' => 'A short city list for free hours. Not AEF partners. Opening hours change — check before you go.',
				'vi' => 'Danh sách ngắn cho thời gian rảnh. Không phải đối tác AEF. Giờ mở cửa thay đổi — kiểm tra trước khi đến.',
			) ) ); ?></p>
			<div class="city-cols">
				<?php foreach ( aef_travel_city() as $col ) : ?>
					<div>
						<h3><?php echo esc_html( aef_t( $col['title'] ) ); ?></h3>
						<ul>
							<?php foreach ( $col['items'] as $item ) : ?>
								<li><b><?php echo esc_html( $item[0] ); ?></b><span><?php echo esc_html( aef_t( $item[1] ) ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="travel-sec" id="notes">
		<div class="shell travel-notes">
			<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Notes', 'vi' => 'Lưu ý' ) ) ); ?></p>
			<ul>
				<li><?php echo esc_html( aef_t( array( 'en' => 'This page is a draft city kit. It is not a booking, a visa, or a guarantee of access.', 'vi' => 'Trang này là cẩm nang dự thảo. Không phải chỗ đặt phòng, thị thực hay bảo đảm quyền vào cửa.' ) ) ); ?></li>
				<li><?php echo esc_html( aef_t( array( 'en' => 'Peak traffic in the city is usually 07:00–09:00 and 16:30–19:00.', 'vi' => 'Giờ cao điểm thường 07:00–09:00 và 16:30–19:00.' ) ) ); ?></li>
				<li><?php echo esc_html( aef_t( array( 'en' => 'Keep a digital and a paper copy of your invitation or confirmation.', 'vi' => 'Giữ bản số và bản giấy thư mời hoặc xác nhận.' ) ) ); ?></li>
				<li><?php echo esc_html( aef_t( array( 'en' => 'Visa and entry follow current regulations. AEF cannot decide a visa.', 'vi' => 'Thị thực và nhập cảnh theo quy định hiện hành. AEF không quyết định thị thực.' ) ) ); ?></li>
			</ul>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
