<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_pillars() {
	$s = function_exists( 'aef_settings' ) ? aef_settings() : array();
	return array(
		array(
			'n'      => '01',
			'slug'   => 'megacities',
			'image'  => 'visual/pillar-megacity.jpg',
			'title'  => array( 'en' => isset( $s['axis_1_en'] ) ? $s['axis_1_en'] : 'The role of megacities', 'vi' => isset( $s['axis_1_vi'] ) ? $s['axis_1_vi'] : 'Vai trò của các siêu đô thị' ),
			'kicker' => array( 'en' => 'Cities that now lead the new growth map', 'vi' => 'Những đô thị đang dẫn dắt bản đồ tăng trưởng mới' ),
			'card'   => array(
				'en' => 'Megacities are more than concentrations of people and resources. They are becoming nodes that connect capital, technology, talent and cross-border cooperation.',
				'vi' => 'Siêu đô thị không chỉ tập trung dân số và nguồn lực. Chúng đang trở thành những đầu mối kết nối vốn, công nghệ, nhân lực và sáng kiến hợp tác xuyên biên giới.',
			),
			'body'   => array(
				'en' => 'As capital, technology, knowledge and skilled people concentrate in large urban centres, megacities are emerging as growth poles whose impact reaches beyond administrative borders. They are markets and production–service hubs, and also places where policy, technology and new development models are tested. At AEF 2026 the role of megacities is approached through how growth centres can cooperate rather than only compete; how infrastructure, finance, logistics, innovation and people can be connected; and how the gains of growth can spread to a wider urban region.',
				'vi' => 'Khi các dòng vốn, công nghệ, tri thức và nhân lực chất lượng cao ngày càng tập trung tại các trung tâm đô thị lớn, siêu đô thị đang nổi lên như những cực tăng trưởng có khả năng tác động vượt ra ngoài ranh giới hành chính. Chúng vừa là thị trường, trung tâm sản xuất – dịch vụ, vừa là nơi thử nghiệm chính sách, công nghệ và các mô hình phát triển mới. Tại AEF 2026, vai trò của các siêu đô thị được tiếp cận từ câu hỏi làm thế nào các trung tâm tăng trưởng có thể hợp tác thay vì chỉ cạnh tranh; làm thế nào để kết nối hạ tầng, tài chính, logistics, đổi mới sáng tạo và nguồn nhân lực; và làm thế nào để thành quả tăng trưởng được lan tỏa tới vùng đô thị và khu vực rộng lớn hơn.',
			),
			'qs'     => array(
				array( 'en' => 'What makes a megacity competitive in an era of technology and the green transition?', 'vi' => 'Điều gì tạo nên năng lực cạnh tranh của một siêu đô thị trong kỷ nguyên công nghệ và chuyển đổi xanh?' ),
				array( 'en' => 'How can cities cooperate to form new growth corridors?', 'vi' => 'Các đô thị có thể hợp tác như thế nào để hình thành những hành lang tăng trưởng mới?' ),
				array( 'en' => 'How can urban innovation create a spreading and inclusive effect?', 'vi' => 'Làm thế nào để đổi mới sáng tạo đô thị tạo ra tác động lan tỏa và bao trùm?' ),
			),
		),
		array(
			'n'      => '02',
			'slug'   => 'frontier-tech',
			'image'  => 'visual/pillar-tech.jpg',
			'title'  => array( 'en' => isset( $s['axis_2_en'] ) ? $s['axis_2_en'] : 'Frontier technology and the innovation ecosystem', 'vi' => isset( $s['axis_2_vi'] ) ? $s['axis_2_vi'] : 'Công nghệ đột phá và hệ sinh thái đổi mới sáng tạo' ),
			'kicker' => array( 'en' => 'From frontier technology to innovation capacity', 'vi' => 'Từ công nghệ đột phá đến năng lực đổi mới' ),
			'card'   => array(
				'en' => 'Competitive advantage now depends more on the ability to absorb technology, the quality of the innovation ecosystem and the capacity to turn knowledge into value.',
				'vi' => 'Lợi thế cạnh tranh ngày càng phụ thuộc vào khả năng hấp thụ công nghệ, chất lượng hệ sinh thái đổi mới và năng lực chuyển tri thức thành giá trị.',
			),
			'body'   => array(
				'en' => 'Artificial intelligence, automation, quantum technology, data and strategic technologies are changing production, governance and competition. Technology only creates a durable advantage when it sits in an ecosystem that can connect research, firms, capital, people and policy. This pillar focuses on the gap between owning technology and mastering innovation capacity. AEF 2026 aims to connect science and technology centres, startups, research institutes, universities, firms, investors and public authorities — not only to introduce trends, but to find cooperation models that move technology from research to use, from trial to scale, and from potential to real value.',
				'vi' => 'Trí tuệ nhân tạo, tự động hóa, công nghệ lượng tử, dữ liệu và những công nghệ chiến lược đang làm thay đổi mô hình sản xuất, quản trị và cạnh tranh. Nhưng công nghệ chỉ tạo ra lợi thế bền vững khi được đặt trong một hệ sinh thái có khả năng kết nối nghiên cứu, doanh nghiệp, vốn, nhân lực và chính sách. Trụ cột này tập trung vào khoảng cách giữa sở hữu công nghệ và làm chủ năng lực đổi mới. AEF 2026 hướng tới kết nối các trung tâm khoa học – công nghệ, hệ sinh thái khởi nghiệp, viện nghiên cứu, trường đại học, doanh nghiệp, nhà đầu tư và cơ quan quản lý. Trọng tâm không chỉ là giới thiệu xu hướng, mà là tìm kiếm những mô hình hợp tác giúp công nghệ đi từ nghiên cứu tới ứng dụng, từ thử nghiệm tới quy mô, và từ tiềm năng tới giá trị thực tế.',
			),
			'qs'     => array(
				array( 'en' => 'How can firms raise their capacity to absorb and master technology?', 'vi' => 'Làm thế nào để doanh nghiệp nâng cao năng lực hấp thụ và làm chủ công nghệ?' ),
				array( 'en' => 'Which policies shorten the path from research to market?', 'vi' => 'Chính sách nào giúp rút ngắn hành trình từ nghiên cứu tới thị trường?' ),
				array( 'en' => 'How can innovation ecosystems connect across borders?', 'vi' => 'Các hệ sinh thái đổi mới có thể kết nối xuyên biên giới như thế nào?' ),
				array( 'en' => 'How does technological innovation travel with workforce development and social responsibility?', 'vi' => 'Làm thế nào để đổi mới công nghệ đi cùng phát triển nhân lực và trách nhiệm xã hội?' ),
			),
		),
		array(
			'n'      => '03',
			'slug'   => 'cooperation',
			'image'  => 'visual/pillar-cooperation.jpg',
			'title'  => array( 'en' => isset( $s['axis_3_en'] ) ? $s['axis_3_en'] : 'Cooperation models in a new era', 'vi' => isset( $s['axis_3_vi'] ) ? $s['axis_3_vi'] : 'Các mô hình hợp tác trong kỷ nguyên mới' ),
			'kicker' => array( 'en' => 'New links for a multi-layer world', 'vi' => 'Những liên kết mới cho một thế giới đa tầng' ),
			'card'   => array(
				'en' => 'A new era needs more flexible cooperation models, connecting countries, cities, firms, academia and international organisations.',
				'vi' => 'Kỷ nguyên mới đòi hỏi các mô hình hợp tác linh hoạt hơn, kết nối quốc gia, đô thị, doanh nghiệp, học thuật và tổ chức quốc tế.',
			),
			'body'   => array(
				'en' => 'International economic cooperation is widening from relations among countries to multi-layer networks in which localities, cities, firms, international organisations, universities and specialist communities all take part. Challenges such as fragmented supply chains, the energy transition, data governance, responsible technology and workforce development do not sit inside one sector or one country. AEF 2026 focuses on cooperation models that can connect a global agenda with practical development needs — among cities, between research and firms, in public–private partnerships, and in cross-border programmes on technology, investment, finance and people.',
				'vi' => 'Hợp tác kinh tế quốc tế đang mở rộng từ quan hệ giữa các quốc gia sang những mạng lưới đa tầng, nơi địa phương, đô thị, doanh nghiệp, tổ chức quốc tế, trường đại học và cộng đồng chuyên gia cùng tham gia. Những thách thức như phân mảnh chuỗi cung ứng, chuyển đổi năng lượng, quản trị dữ liệu, phát triển công nghệ có trách nhiệm hay xây dựng nguồn nhân lực không nằm gọn trong phạm vi của một ngành hoặc một quốc gia. AEF 2026 đặt trọng tâm vào các mô hình hợp tác có thể nối chương trình nghị sự toàn cầu với nhu cầu phát triển thực tiễn.',
			),
			'qs'     => array(
				array( 'en' => 'Which cooperation model fits a world that is both connected and fragmented?', 'vi' => 'Mô hình hợp tác nào phù hợp với một thế giới vừa kết nối vừa phân mảnh?' ),
				array( 'en' => 'How is trust built and benefit shared among many actors?', 'vi' => 'Làm thế nào để xây dựng lòng tin và phân bổ lợi ích giữa nhiều chủ thể?' ),
				array( 'en' => 'What mechanism lets an international initiative be delivered locally?', 'vi' => 'Cơ chế nào giúp các sáng kiến quốc tế đi vào triển khai tại địa phương?' ),
			),
		),
		array(
			'n'      => '04',
			'slug'   => 'private-sector',
			'image'  => 'visual/pillar-private.jpg',
			'title'  => array( 'en' => isset( $s['axis_4_en'] ) ? $s['axis_4_en'] : 'The pioneering role of the private sector', 'vi' => isset( $s['axis_4_vi'] ) ? $s['axis_4_vi'] : 'Vai trò tiên phong của khu vực tư nhân' ),
			'kicker' => array( 'en' => 'From participant to a force that leads growth', 'vi' => 'Từ người tham gia đến lực lượng dẫn dắt tăng trưởng' ),
			'card'   => array(
				'en' => 'Firms have a pioneering role in innovation, mobilising resources and turning policy discussions into initiatives, projects and new markets.',
				'vi' => 'Doanh nghiệp có vai trò tiên phong trong đổi mới, huy động nguồn lực và chuyển các thảo luận chính sách thành sáng kiến, dự án và thị trường mới.',
			),
			'body'   => array(
				'en' => 'The private sector is where much innovation is tested, resources are mobilised and market opportunities become products, services and jobs. That pioneering role shows in long-term investment, new business models, technology use, workforce development and new linkages. It is also the bridge between policy discussion and market practice: only when firms can deliver, measure and scale do ideas about green growth, digital transition or innovation create a real effect. AEF 2026 gives firms, investors, financial institutions and partners a space to talk directly with the public sector and specialists — to identify barriers, widen cooperation and help form initiatives that can continue after the Forum.',
				'vi' => 'Khu vực tư nhân là nơi nhiều đổi mới được thử nghiệm, nguồn lực được huy động và các cơ hội thị trường được chuyển hóa thành sản phẩm, dịch vụ và việc làm. Vai trò tiên phong ấy thể hiện ở năng lực đầu tư dài hạn, đổi mới mô hình kinh doanh, ứng dụng công nghệ, phát triển nhân lực và hình thành các chuỗi liên kết mới. AEF 2026 tạo không gian để doanh nghiệp, nhà đầu tư, định chế tài chính và các đối tác trao đổi trực tiếp với khu vực công và giới chuyên gia. Mục tiêu là nhận diện những rào cản, mở rộng cơ hội hợp tác và thúc đẩy hình thành các sáng kiến, dự án có khả năng tiếp tục sau Diễn đàn.',
			),
			'qs'     => array(
				array( 'en' => 'What conditions do firms need to invest in new growth engines?', 'vi' => 'Doanh nghiệp cần điều kiện gì để đầu tư vào những động lực tăng trưởng mới?' ),
				array( 'en' => 'How can the public and private sectors share risk, resources and delivery capacity?', 'vi' => 'Khu vực công và tư có thể chia sẻ rủi ro, nguồn lực và năng lực triển khai ra sao?' ),
				array( 'en' => 'How can Vietnamese firms go deeper into new value chains?', 'vi' => 'Làm thế nào để doanh nghiệp Việt Nam tham gia sâu hơn vào các chuỗi giá trị mới?' ),
			),
		),
	);
}

function aef_outcomes() {
	return array(
		array(
			array( 'en' => 'Knowledge & policy', 'vi' => 'Tri thức & chính sách' ),
			array( 'en' => 'Identify new growth engines and poles; contribute recommendations on innovation, digital and green transition, and competitiveness.', 'vi' => 'Nhận diện các động lực và cực tăng trưởng mới; đóng góp khuyến nghị cho đổi mới sáng tạo, chuyển đổi số, chuyển đổi xanh và năng lực cạnh tranh.' ),
		),
		array(
			array( 'en' => 'Development resources', 'vi' => 'Nguồn lực phát triển' ),
			array( 'en' => 'Connect capital, technology, knowledge, people and governing experience with the development needs of Viet Nam and Ho Chi Minh City.', 'vi' => 'Kết nối vốn, công nghệ, tri thức, nhân lực và kinh nghiệm quản trị với những nhu cầu phát triển của Việt Nam và Thành phố Hồ Chí Minh.' ),
		),
		array(
			array( 'en' => 'Partnerships', 'vi' => 'Quan hệ hợp tác' ),
			array( 'en' => 'Widen links among governments, cities, firms, investors, international organisations and academia.', 'vi' => 'Mở rộng liên kết giữa chính phủ, đô thị, doanh nghiệp, nhà đầu tư, tổ chức quốc tế và giới học thuật.' ),
		),
		array(
			array( 'en' => 'Follow-on initiatives', 'vi' => 'Sáng kiến tiếp nối' ),
			array( 'en' => 'Create the conditions for ideas that meet the bar to become programmes, agreements or concrete projects.', 'vi' => 'Tạo điều kiện để những ý tưởng đủ điều kiện được phát triển thành chương trình, thỏa thuận hoặc dự án cụ thể.' ),
		),
		array(
			array( 'en' => 'An annual platform', 'vi' => 'Nền tảng thường niên' ),
			array( 'en' => 'Step by step, build a continuous space for international dialogue and cooperation in Viet Nam.', 'vi' => 'Từng bước xây dựng một không gian đối thoại và hợp tác quốc tế có tính liên tục tại Việt Nam.' ),
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
			'title' => array( 'en' => 'Tiers pending confirmation', 'vi' => 'Phân hạng đang chờ xác nhận' ),
			'note'  => array(
				'en' => 'A logo on this page does not establish sponsorship, a tier, or brand rights. The list is a working file pending Organising Committee approval.',
				'vi' => 'Việc logo xuất hiện không mặc nhiên xác lập tư cách tài trợ, thứ hạng hoặc quyền lợi thương hiệu. Danh sách là tệp làm việc, chờ Ban Tổ chức duyệt.',
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
			array( 'en' => 'Venue, shuttle and map details go live when operations are confirmed.', 'vi' => 'Thông tin cụ thể về địa điểm, phương án đưa đón và bản đồ sẽ được cập nhật khi chốt vận hành.' ),
			'/2026/travel/',
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
			array( 'en' => 'Attendance is expected to be managed by invitation and confirmed registration. Some activities may have their own conditions.', 'vi' => 'Quyền tham dự dự kiến được quản lý theo thư mời và xác nhận đăng ký. Một số hoạt động có thể áp dụng điều kiện riêng.' ),
		),
		array(
			array( 'en' => 'Is the programme official?', 'vi' => 'Chương trình đã chính thức chưa?' ),
			array( 'en' => 'Not yet. The timetable is a draft compiled from the 13 August 2026 framework and organisation plan.', 'vi' => 'Chưa. Lịch trình trên website là bản dự kiến tổng hợp từ khung chương trình và dự thảo kế hoạch ngày 13/8/2026.' ),
		),
		array(
			array( 'en' => 'Is there an English version?', 'vi' => 'Website có phiên bản tiếng Anh không?' ),
			array( 'en' => 'Yes. English is the public default; Vietnamese is the second language. Switch with EN / VI in the header.', 'vi' => 'Có. Tiếng Anh là ngôn ngữ mặc định công khai; tiếng Việt là ngôn ngữ thứ hai. Chuyển bằng EN / VI trên đầu trang.' ),
		),
		array(
			array( 'en' => 'How do I get support?', 'vi' => 'Làm thế nào để nhận hỗ trợ?' ),
			array( 'en' => 'Email and helpline contacts will be added when the Organising Committee publishes them. Until then write to contact@aef.vn.', 'vi' => 'Đầu mối email và đường dây hỗ trợ sẽ được bổ sung khi Ban Tổ chức công bố chính thức. Tạm thời gửi contact@aef.vn.' ),
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
			array( 'en' => 'Eighteen parallel sessions in three rooms, plus the Rising Star Arena, run through the four content pillars.', 'vi' => 'Mười tám phiên song song tại ba phòng, cùng Rising Star Arena, đi xuyên bốn trụ cột nội dung.' ),
			'thematic',
		),
		array(
			'28',
			array( 'en' => 'Converge leadership', 'vi' => 'Hội tụ lãnh đạo' ),
			array( 'en' => 'The high-level day: plenary, global trends, ministerial dialogue, the Prime Minister, and the forward agenda.', 'vi' => 'Ngày cấp cao: phiên toàn thể, xu hướng toàn cầu, đối thoại Bộ trưởng, Thủ tướng và định hướng tiếp theo.' ),
			'high-level',
		),
	);
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
	if ( $v ) {
		return $v;
	}
	$v = aef_meta( $post_id, 'kind' );
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
			$tab['items'][] = array(
				'id'    => $id,
				'time'  => aef_meta( $id, 'time' ),
				'title' => aef_bilingual_title( $id ),
				'room'  => aef_meta( $id, 'room' ),
				'tag'   => $tags ? $tags[0] : aef_session_kind( $id ),
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
