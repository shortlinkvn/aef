<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_pillars() {
	if ( ! function_exists( 'aef_topics_block_defs' ) ) {
		return array();
	}
	$out  = array();
	$defs = aef_topics_block_defs();
	foreach ( aef_topics_order() as $id ) {
		if ( ! aef_topics_block_on( $id ) ) {
			continue;
		}
		if ( ! isset( $defs[ $id ] ) ) {
			continue;
		}
		$def   = $defs[ $id ];
		$title = aef_topics_pair( $id . '_title' );
		if ( '' === trim( (string) $title['en'] ) && '' === trim( (string) $title['vi'] ) ) {
			continue;
		}
		$short  = aef_topics_pair( $id . '_short' );
		$kicker = aef_topics_pair( $id . '_kicker' );
		$card   = aef_topics_pair( $id . '_card' );
		$body   = aef_topics_pair( $id . '_body' );
		$cap    = aef_topics_pair( $id . '_still_cap' );
		$n      = trim( (string) aef_topics( $id . '_n' ) );
		if ( '' === $n ) {
			$n = $def['n'];
		}
		$qs_en = aef_topics_lines( $id . '_qs_en' );
		$qs_vi = aef_topics_lines( $id . '_qs_vi' );
		$qs    = array();
		$max   = max( count( $qs_en ), count( $qs_vi ) );
		for ( $i = 0; $i < $max; $i++ ) {
			$en = isset( $qs_en[ $i ] ) ? $qs_en[ $i ] : '';
			$vi = isset( $qs_vi[ $i ] ) ? $qs_vi[ $i ] : '';
			if ( '' === $en && '' === $vi ) {
				continue;
			}
			$qs[] = array( 'en' => $en, 'vi' => $vi );
		}
		$still_on = aef_topics_still_on( $id );
		$image    = $still_on ? $def['still'] : '';
		$image_url = '';
		if ( $still_on ) {
			$image_url = aef_topics_image( $id . '_still_id', $def['still'] );
		}
		$out[] = array(
			'id'        => $id,
			'n'         => $n,
			'slug'      => $def['slug'],
			'image'     => $image,
			'image_url' => $image_url,
			'bg'        => aef_topics_bg( $id . '_bg_id' ),
			'still_on'  => $still_on,
			'title'     => $title,
			'short'     => ( '' !== trim( (string) $short['en'] ) || '' !== trim( (string) $short['vi'] ) ) ? $short : $title,
			'kicker'    => $kicker,
			'card'      => $card,
			'body'      => $body,
			'cap'       => $cap,
			'qs'        => $qs,
		);
	}
	return $out;
}

function aef_outcomes() {
	return array(
		array(
			array( 'en' => 'Connecting and mobilising resources', 'vi' => 'Kết nối và huy động nguồn lực' ),
			array( 'en' => 'Catalysing concrete solutions, agreements and projects in investment, finance, science and technology, innovation, talent and sustainable development.', 'vi' => 'Thúc đẩy hình thành giải pháp, thỏa thuận và dự án cụ thể về đầu tư, tài chính, khoa học – công nghệ, đổi mới sáng tạo, nhân lực và phát triển bền vững.' ),
		),
		array(
			array( 'en' => 'Policy consultation and recommendations', 'vi' => 'Tham vấn và đề xuất chính sách' ),
			array( 'en' => 'Input for the outlook report on Viet Nam’s new growth engines and recommendations on innovation, digital and green transformation and the private economy.', 'vi' => 'Đầu vào cho báo cáo triển vọng về các động lực, cực tăng trưởng mới của Việt Nam và khuyến nghị về đổi mới sáng tạo, chuyển đổi số, chuyển đổi xanh, kinh tế tư nhân.' ),
		),
		array(
			array( 'en' => 'An annual dialogue platform', 'vi' => 'Nền tảng đối thoại thường niên' ),
			array( 'en' => 'Developing the Forum step by step into Viet Nam’s annual platform for international dialogue and cooperation.', 'vi' => 'Từng bước phát triển Diễn đàn thành nền tảng đối thoại và hợp tác quốc tế thường niên của Việt Nam.' ),
		),
		array(
			array( 'en' => 'Affirming a destination', 'vi' => 'Khẳng định vị thế điểm đến' ),
			array( 'en' => 'Ho Chi Minh City and Viet Nam as an attractive, transparent and dynamic investment environment — a connection point for regional and global initiatives, resources and partners.', 'vi' => 'Thành phố Hồ Chí Minh và Việt Nam — môi trường đầu tư hấp dẫn, minh bạch, năng động; điểm kết nối sáng kiến, nguồn lực và đối tác khu vực, toàn cầu.' ),
		),
	);
}

function aef_audiences() {
	return array(
		array(
			array( 'en' => 'Governments & localities', 'vi' => 'Chính phủ & địa phương' ),
			array( 'en' => 'Policy direction, institution-building, and connecting the national agenda with international cooperation.', 'vi' => 'Định hướng chính sách, kiến tạo thể chế và kết nối chương trình nghị sự quốc gia với hợp tác quốc tế.' ),
		),
		array(
			array( 'en' => 'Business & investors', 'vi' => 'Doanh nghiệp & nhà đầu tư' ),
			array( 'en' => 'Delivery capacity, market resources and concrete cooperation opportunities.', 'vi' => 'Mang tới năng lực triển khai, nguồn lực thị trường và những cơ hội hợp tác cụ thể.' ),
		),
		array(
			array( 'en' => 'International organisations & networks', 'vi' => 'Tổ chức quốc tế & mạng lưới toàn cầu' ),
			array( 'en' => 'Shared experience, partner connections and a wider reach for initiatives.', 'vi' => 'Chia sẻ kinh nghiệm, kết nối đối tác và mở rộng phạm vi của các sáng kiến.' ),
		),
		array(
			array( 'en' => 'Science & academia', 'vi' => 'Khoa học & học thuật' ),
			array( 'en' => 'Evidence, specialist knowledge and longer-term views.', 'vi' => 'Đóng góp bằng chứng, tri thức chuyên môn và những góc nhìn dài hạn.' ),
		),
		array(
			array( 'en' => 'Innovation & the next generation', 'vi' => 'Đổi mới sáng tạo & thế hệ trẻ' ),
			array( 'en' => 'New ideas, new technologies and new approaches to growth.', 'vi' => 'Đưa vào diễn đàn những ý tưởng mới, công nghệ mới và cách tiếp cận mới đối với tăng trưởng.' ),
		),
	);
}

function aef_partner_groups() {
	$uri = get_template_directory_uri() . '/assets/partners/';
	return array(
		array(
			'role'  => array( 'en' => 'Convening authority', 'vi' => 'Cơ quan chủ trì' ),
			'title' => array( 'en' => "People's Committee of Ho Chi Minh City", 'vi' => 'Ủy ban nhân dân Thành phố Hồ Chí Minh' ),
			'note'  => '',
			'items' => array(
				array( 'UBND Thành phố Hồ Chí Minh', aef_logo( 'ubnd.png' ) ),
			),
		),
		array(
			'role'  => array( 'en' => 'Accompanying organisations', 'vi' => 'Đơn vị đồng hành' ),
			'title' => array( 'en' => 'Accompanying organisations', 'vi' => 'Đơn vị đồng hành' ),
			'note'  => array(
				'en' => 'Logos are shown by organisational role. Appearance on this page does not by itself establish a sponsorship tier or brand rights.',
				'vi' => 'Logo được trình bày theo vai trò tổ chức. Việc xuất hiện trên trang không mặc nhiên xác lập thứ hạng tài trợ hoặc quyền lợi thương hiệu.',
			),
			'items' => array(
				array( 'One Mount', $uri . 'OneMount.webp' ),
				array( 'Sunwah', $uri . 'SunWah.webp' ),
				array( 'CMC', $uri . 'cmc.webp' ),
				array( 'Galaxy Holdings', $uri . 'galaxy-holding.webp' ),
				array( 'Prowtech', $uri . 'prowtech-logo.webp' ),
				array( 'Saigontel', $uri . 'saigontel-ogo.webp' ),
				array( 'Qualcomm', $uri . 'Qualcomm-Logo.webp' ),
				array( 'Trung Nguyên Legend', $uri . 'trungnguyen.webp' ),
				array( 'THACO', $uri . 'thaco-logo.webp' ),
				array( 'Đôi Dép', $uri . 'Doidep-logo.webp' ),
				array( 'Masterise Group', $uri . 'masterise-group-logo.webp' ),
				array( 'Nam A Bank', $uri . 'namabank-yellow-logo.webp' ),
			),
		),
		array(
			'role'  => array( 'en' => 'Media partners', 'vi' => 'Đối tác truyền thông' ),
			'title' => array( 'en' => 'Provisional', 'vi' => 'Dự kiến' ),
			'note'  => array(
				'en' => 'Roles and logo treatment must be confirmed before public release.',
				'vi' => 'Vai trò và cách thể hiện logo cần được xác nhận trước khi phát hành công khai.',
			),
			'items' => array(
				array( 'Ho Chi Minh City Television', $uri . 'Logo_of_Ho_Chi_Minh_Television.svg_.webp' ),
				array( 'Sài Gòn Giải Phóng', $uri . 'logo-bao-sggp.webp' ),
			),
		),
	);
}

function aef_support_cards() {
	return array(
		array(
			'01',
			array( 'en' => 'Venue & travel', 'vi' => 'Địa điểm & di chuyển' ),
			array( 'en' => 'Venue, transfer and access information for Thiskyhall and the Forum week.', 'vi' => 'Thông tin địa điểm, đưa đón và lối vào Thiskyhall trong tuần Diễn đàn.' ),
			'/travel/',
		),
		array(
			'02',
			array( 'en' => 'Visa & entry', 'vi' => 'Thị thực & nhập cảnh' ),
			array( 'en' => 'Guidance for international delegates will follow current regulations.', 'vi' => 'Hướng dẫn dành cho đại biểu quốc tế sẽ được công bố theo quy định hiện hành.' ),
			'/2026/delegates/',
		),
		array(
			'03',
			array( 'en' => 'Delegate recognition', 'vi' => 'Công nhận đại biểu' ),
			array( 'en' => 'Access to each activity depends on the invitation and Organising Committee confirmation.', 'vi' => 'Quyền tiếp cận từng hoạt động phụ thuộc thư mời và xác nhận của Ban Tổ chức.' ),
			'/2026/delegates/how-to-register/',
		),
		array(
			'04',
			array( 'en' => 'Security & health', 'vi' => 'An ninh & y tế' ),
			array( 'en' => 'Screening, medical support and emergency contacts will be sent before the event.', 'vi' => 'Các yêu cầu kiểm soát, hỗ trợ y tế và đầu mối khẩn cấp sẽ được gửi trước sự kiện.' ),
			'/2026/support/',
		),
		array(
			'05',
			array( 'en' => 'Accessibility', 'vi' => 'Khả năng tiếp cận' ),
			array( 'en' => 'Delegates who need access support can say so during registration.', 'vi' => 'Đại biểu có nhu cầu hỗ trợ tiếp cận có thể thông báo trong quá trình đăng ký.' ),
			'/2026/delegates/',
		),
		array(
			'06',
			array( 'en' => 'Media support', 'vi' => 'Hỗ trợ truyền thông' ),
			array( 'en' => 'Journalists register separately and follow the event’s working rules.', 'vi' => 'Nhà báo cần đăng ký riêng và tuân thủ quy định tác nghiệp của sự kiện.' ),
			'/2026/support/media/',
		),
	);
}

function aef_support_faq() {
	return array(
		array(
			array( 'en' => 'Who can attend AEF 2026?', 'vi' => 'Ai có thể tham dự AEF 2026?' ),
			array( 'en' => 'Attendance is by invitation and confirmation of the Organising Committee. Some activities have separate conditions.', 'vi' => 'Quyền tham dự theo thư mời và xác nhận của Ban Tổ chức. Một số hoạt động áp dụng điều kiện riêng.' ),
		),
		array(
			array( 'en' => 'Where do I find session times?', 'vi' => 'Xem giờ các phiên ở đâu?' ),
			array( 'en' => 'The Programme page lists times, rooms and access for each session. Open a session for the full note.', 'vi' => 'Trang Chương trình liệt kê giờ, phòng và quyền tiếp cận từng phiên. Mở trang phiên để đọc bối cảnh đầy đủ.' ),
		),
		array(
			array( 'en' => 'Is there an English version?', 'vi' => 'Website có phiên bản tiếng Anh không?' ),
			array( 'en' => 'Yes. English is the public default; Vietnamese is the second language. Switch with EN / VI in the header.', 'vi' => 'Có. Tiếng Anh là ngôn ngữ mặc định công khai; tiếng Việt là ngôn ngữ thứ hai. Chuyển bằng EN / VI trên đầu trang.' ),
		),
		array(
			array( 'en' => 'How do I get support?', 'vi' => 'Làm thế nào để nhận hỗ trợ?' ),
			array( 'en' => 'Write to the Secretariat at contact@aef.vn.', 'vi' => 'Liên hệ Ban thư ký qua địa chỉ contact@aef.vn.' ),
		),
		array(
			array( 'en' => 'Does the Organising Committee help with hotel booking?', 'vi' => 'Ban Tổ chức có hỗ trợ đặt phòng khách sạn không?' ),
			array( 'en' => 'The Travel guide lists a reference selection of hotels near the venue; booking and payment are the delegate’s own arrangement unless the invitation states otherwise.', 'vi' => 'Cẩm nang đi lại liệt kê danh sách khách sạn tham khảo gần địa điểm tổ chức; việc đặt phòng và thanh toán do đại biểu tự sắp xếp, trừ khi thư mời ghi khác.' ),
		),
		array(
			array( 'en' => 'Is airport transfer provided?', 'vi' => 'Có dịch vụ đưa đón sân bay không?' ),
			array( 'en' => 'The Travel guide sets out how to get from Tan Son Nhat Airport to the city and the venue. Any dedicated transfer arrangement is confirmed individually through the invitation.', 'vi' => 'Cẩm nang đi lại nêu cách di chuyển từ sân bay Tân Sơn Nhất tới trung tâm thành phố và địa điểm tổ chức. Dịch vụ đưa đón riêng (nếu có) được xác nhận theo từng thư mời.' ),
		),
		array(
			array( 'en' => 'How does press accreditation work?', 'vi' => 'Thủ tục cấp thẻ tác nghiệp báo chí như thế nào?' ),
			array( 'en' => 'International media register through the Ministry of Foreign Affairs; domestic media register through the Organising Committee. See the Media page for the current process.', 'vi' => 'Báo chí quốc tế đăng ký qua Bộ Ngoại giao; báo chí trong nước đăng ký qua Ban Tổ chức. Xem trang Báo chí để biết quy trình hiện hành.' ),
		),
		array(
			array( 'en' => 'What language is used at the Forum?', 'vi' => 'Ngôn ngữ sử dụng tại Diễn đàn là gì?' ),
			array( 'en' => 'Vietnamese and English, with interpretation for the Main Forum. This website itself defaults to English, with Vietnamese as the second language.', 'vi' => 'Tiếng Việt và tiếng Anh, có phiên dịch cho Diễn đàn chính. Website này mặc định hiển thị tiếng Anh, tiếng Việt là ngôn ngữ thứ hai.' ),
		),
	);
}

function aef_journey_days() {
	return array(
		array(
			'26',
			array( 'en' => 'Connect the ecosystem', 'vi' => 'Kết nối hệ sinh thái' ),
			array( 'en' => 'CEO 500 — TEA CONNECT opens the week: a working conversation on FDI, technology and global capital flows.', 'vi' => 'CEO 500 — TEA CONNECT mở đầu tuần lễ: đối thoại về FDI, công nghệ và dòng chảy tài chính toàn cầu.' ),
			'pre',
		),
		array(
			'27',
			array( 'en' => 'Go deeper', 'vi' => 'Đối thoại chuyên sâu' ),
			array( 'en' => 'Opening remarks by the Vice Chairman of the City People’s Committee, then 15 parallel sessions.', 'vi' => 'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố, tiếp theo là 15 phiên thảo luận chuyên đề song song.' ),
			'thematic',
		),
		array(
			'28',
			array( 'en' => 'Converge leadership', 'vi' => 'Hội tụ lãnh đạo' ),
			array( 'en' => 'High-level plenary and dialogue with the Prime Minister in the morning; in-depth presentations and ministerial dialogue in the afternoon, with the Deputy Prime Minister.', 'vi' => 'Buổi sáng: phiên toàn thể cấp cao và đối thoại cùng Thủ tướng. Buổi chiều: tham luận chuyên sâu và đối thoại cấp Bộ, có Phó Thủ tướng Chính phủ.' ),
			'high-level',
		),
	);
}

function aef_tag_i18n() {
	return array(
		'AI'                           => 'AI',
		'AI công nghiệp'               => 'Industrial AI',
		'ASEAN'                        => 'ASEAN',
		'An ninh mạng'                 => 'Cybersecurity',
		'Bền vững'                     => 'Sustainability',
		'Chiến lược doanh nghiệp'      => 'Corporate strategy',
		'Chuỗi giá trị'                => 'Value chains',
		'Chính sách'                   => 'Policy',
		'Công nghiệp lưỡng dụng'       => 'Dual-use industry',
		'Công nghệ chiến lược'         => 'Strategic technology',
		'Công nghệ lượng tử'           => 'Quantum technology',
		'Doanh nghiệp'                 => 'Business',
		'Dòng vốn'                     => 'Capital flows',
		'Dữ liệu'                      => 'Data',
		'ESG'                          => 'ESG',
		'Hạ tầng AI'                   => 'AI infrastructure',
		'Hệ sinh thái'                 => 'Ecosystem',
		'Hệ sinh thái giá trị'         => 'Value ecosystem',
		'Kinh tế số'                   => 'Digital economy',
		'Kinh tế toàn cầu'             => 'Global economy',
		'Kinh tế tuần hoàn'            => 'Circular economy',
		'Kinh tế tầm thấp'             => 'Low-altitude economy',
		'Logistics'                    => 'Logistics',
		'Lãnh đạo trẻ'                 => 'Young leaders',
		'Nguồn nhân lực'               => 'Workforce',
		'Ngành kinh tế mới'            => 'New economic sectors',
		'Nhà máy'                      => 'Factories',
		'Nhân lực'                     => 'People',
		'Nông nghiệp thông minh'       => 'Smart agriculture',
		'Năng lực cạnh tranh'          => 'Competitiveness',
		'Năng suất'                    => 'Productivity',
		'Quản trị'                     => 'Governance',
		'Siêu đô thị'                  => 'Megacities',
		'Sovereign AI'                 => 'Sovereign AI',
		'Sản xuất'                     => 'Manufacturing',
		'Sản xuất thông minh'          => 'Smart manufacturing',
		'Sản xuất tiên tiến'           => 'Advanced manufacturing',
		'Thể chế'                      => 'Institutions',
		'Thể chế thử nghiệm'           => 'Policy sandbox',
		'Thị trường'                   => 'Markets',
		'Tiêu dùng xanh'               => 'Green consumption',
		'Trung tâm Tài chính Quốc tế'  => 'International Financial Centre',
		'Tài chính'                    => 'Finance',
		'Tương lai toàn cầu'           => 'Global futures',
		'Đổi mới'                      => 'Innovation',
	);
}

function aef_tag_label( $tag ) {
	$tag = trim( (string) $tag );
	if ( '' === $tag || 'vi' === aef_lang() ) {
		return $tag;
	}
	$map = aef_tag_i18n();
	return isset( $map[ $tag ] ) ? $map[ $tag ] : $tag;
}

function aef_session_tags( $post_id ) {
	$raw = aef_meta( $post_id, 'tags' );
	if ( ! $raw ) {
		return array();
	}
	$parts = array_map( 'trim', explode( ',', $raw ) );
	return array_values( array_filter( $parts ) );
}

function aef_session_questions( $post_id ) {
	$lang = aef_lang();
	$raw  = aef_meta( $post_id, 'questions_' . $lang );
	if ( ! $raw ) {
		$raw = aef_meta( $post_id, 'vi' === $lang ? 'questions_en' : 'questions_vi' );
	}
	if ( ! $raw ) {
		return array();
	}
	$decoded = json_decode( $raw, true );
	if ( is_array( $decoded ) ) {
		return $decoded;
	}
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ) ) );
}

function aef_session_short( $post_id ) {
	$lang = aef_lang();
	$v    = aef_meta( $post_id, 'short_' . $lang );
	if ( $v ) {
		return $v;
	}
	$v = aef_meta( $post_id, 'vi' === $lang ? 'short_en' : 'short_vi' );
	if ( $v ) {
		return $v;
	}
	return wp_strip_all_tags( aef_bilingual_content( $post_id ) );
}

function aef_session_long( $post_id ) {
	$lang = aef_lang();
	$v    = aef_meta( $post_id, 'long_' . $lang );
	if ( $v ) {
		return $v;
	}
	$v = aef_meta( $post_id, 'vi' === $lang ? 'long_en' : 'long_vi' );
	if ( $v ) {
		return $v;
	}
	return aef_bilingual_content( $post_id );
}

function aef_session_kind( $post_id ) {
	$lang = aef_lang();
	$v    = aef_meta( $post_id, 'kind_' . $lang );
	if ( ! $v ) {
		$v = aef_meta( $post_id, 'kind' );
	}
	if ( $v && 'en' === $lang ) {
		$map = array(
			'Chiêu đãi chính thức'           => 'Official reception',
			'Giao lưu và kết nối'            => 'Networking',
			'Gặp gỡ cấp cao'                 => 'High-level meeting',
			'Kết nối doanh nghiệp'           => 'Business networking',
			'Phiên bế mạc'                   => 'Closing session',
			'Phiên toàn thể cấp cao'         => 'High-level plenary',
			'Phiên chuyên đề'                => 'Thematic session',
			'Phát biểu kết thúc'             => 'Closing remarks',
			'Phát biểu mở đầu'               => 'Opening remarks',
			'Phát biểu khai mạc'             => 'Opening remarks',
			'Phiên thảo luận chuyên đề'      => 'Thematic sessions',
			'Tham luận chuyên sâu'           => 'In-depth panel',
			'Trình diễn công nghệ'           => 'Technology showcase',
			'Đối thoại chính sách'           => 'Policy dialogue',
			'Đối thoại cấp cao'              => 'High-level dialogue',
			'Đối thoại và kết nối đầu tư'    => 'Investment dialogue',
			'Sự kiện bên lề'                 => 'Side event',
			'Sự kiện'                        => 'Event',
		);
		if ( isset( $map[ $v ] ) ) {
			return $map[ $v ];
		}
	}
	if ( $v ) {
		return $v;
	}
	return aef_t( array( 'en' => 'Session', 'vi' => 'Phiên' ) );
}

function aef_home_agenda() {
	$tabs = array(
		array(
			'key'     => '26',
			'slug'    => 'pre',
			'weekday' => array( 'en' => 'Monday', 'vi' => 'Thứ Hai' ),
			'when'    => '26',
			'month'   => array( 'en' => '10 / 2026', 'vi' => '10 / 2026' ),
		),
		array(
			'key'     => '27',
			'slug'    => 'thematic',
			'weekday' => array( 'en' => 'Tuesday', 'vi' => 'Thứ Ba' ),
			'when'    => '27',
			'month'   => array( 'en' => '10 / 2026', 'vi' => '10 / 2026' ),
		),
		array(
			'key'     => '28',
			'slug'    => 'high-level',
			'weekday' => array( 'en' => 'Wednesday', 'vi' => 'Thứ Tư' ),
			'when'    => '28',
			'month'   => array( 'en' => '10 / 2026', 'vi' => '10 / 2026' ),
		),
		array(
			'key'     => '29',
			'slug'    => 'side',
			'weekday' => array( 'en' => 'Thursday', 'vi' => 'Thứ Năm' ),
			'when'    => '29',
			'month'   => array( 'en' => '10 / 2026', 'vi' => '10 / 2026' ),
		),
	);
	foreach ( $tabs as &$tab ) {
		$term = get_term_by( 'slug', $tab['slug'], 'aef_day' );
		$tab['items'] = array();
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$q = new WP_Query( array(
			'post_type'      => 'aef_session',
			'posts_per_page' => 40,
			'tax_query'      => array( array( 'taxonomy' => 'aef_day', 'field' => 'term_id', 'terms' => $term->term_id ) ),
			'orderby'        => 'meta_value',
			'meta_key'       => 'time',
			'order'          => 'ASC',
		) );
		while ( $q->have_posts() ) {
			$q->the_post();
			$id   = get_the_ID();
			$tags = aef_session_tags( $id );
			$room = function_exists( 'aef_place_label' ) ? aef_place_label( aef_meta( $id, 'room' ) ) : aef_meta( $id, 'room' );
			$tab['items'][] = array(
				'id'    => $id,
				'time'  => aef_meta( $id, 'time' ),
				'title' => aef_bilingual_title( $id ),
				'room'  => $room,
				'tag'   => $tags ? aef_tag_label( $tags[0] ) : aef_session_kind( $id ),
				'url'   => get_permalink( $id ),
			);
		}
		wp_reset_postdata();
	}
	unset( $tab );
	return $tabs;
}

function aef_featured_sessions( $limit = 3 ) {
	$slugs = array( 'ceo-500-tea-connect', 'rising-star-arena', 'high-level-plenary' );
	$posts = array();
	foreach ( $slugs as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			$posts[] = $p;
		}
		if ( count( $posts ) >= $limit ) {
			break;
		}
	}
	return $posts;
}
