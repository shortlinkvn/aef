<?php
/**
 * Plugin Name: AEF 2026 Countries
 * Description: Danh mục quốc gia ISO 3166-1 (thành viên LHQ + quan sát viên) cho hồ sơ diễn giả.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_countries() {
	static $out = null;
	if ( is_array( $out ) ) {
		return $out;
	}
	$out  = array();
	$rows = explode( "\n", aef_countries_raw() );
	foreach ( $rows as $row ) {
		$row = trim( $row );
		if ( '' === $row || '#' === $row[0] ) {
			continue;
		}
		$parts = explode( "\t", $row );
		if ( count( $parts ) < 3 ) {
			continue;
		}
		$code = strtoupper( sanitize_text_field( $parts[0] ) );
		if ( 2 !== strlen( $code ) ) {
			continue;
		}
		$out[ $code ] = array(
			'en' => $parts[1],
			'vi' => $parts[2],
		);
	}
	return $out;
}

function aef_country_code_from_value( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw || '—' === $raw || '-' === $raw ) {
		return '';
	}
	$list = aef_countries();
	$up   = strtoupper( $raw );
	if ( isset( $list[ $up ] ) ) {
		return $up;
	}
	$needle = function_exists( 'mb_strtolower' ) ? mb_strtolower( $raw, 'UTF-8' ) : strtolower( $raw );
	$aliases = array(
		'vietnam'              => 'VN',
		'viet nam'             => 'VN',
		'việt nam'             => 'VN',
		'uk'                   => 'GB',
		'united kingdom'       => 'GB',
		'great britain'        => 'GB',
		'england'              => 'GB',
		'usa'                  => 'US',
		'u.s.a.'               => 'US',
		'united states'        => 'US',
		'united states of america' => 'US',
		'america'              => 'US',
		'korea'                => 'KR',
		'south korea'          => 'KR',
		'republic of korea'    => 'KR',
		'north korea'          => 'KP',
		'russia'               => 'RU',
		'russian federation'   => 'RU',
		'czech republic'       => 'CZ',
		'czechia'              => 'CZ',
		'holland'              => 'NL',
		'the netherlands'      => 'NL',
		'uae'                  => 'AE',
		'ivory coast'          => 'CI',
		'swaziland'            => 'SZ',
		'east timor'           => 'TL',
		'burma'                => 'MM',
		'macedonia'            => 'MK',
		'hong kong'            => 'HK',
		'macao'                => 'MO',
		'macau'                => 'MO',
	);
	if ( isset( $aliases[ $needle ] ) ) {
		return $aliases[ $needle ];
	}
	foreach ( $list as $code => $names ) {
		foreach ( array( 'en', 'vi' ) as $lang ) {
			$n = function_exists( 'mb_strtolower' ) ? mb_strtolower( $names[ $lang ], 'UTF-8' ) : strtolower( $names[ $lang ] );
			if ( $n === $needle ) {
				return $code;
			}
		}
	}
	return '';
}

function aef_country_label( $code, $lang = '' ) {
	$list = aef_countries();
	$code = strtoupper( (string) $code );
	if ( ! isset( $list[ $code ] ) ) {
		return '';
	}
	if ( ! $lang && function_exists( 'aef_lang' ) ) {
		$lang = aef_lang();
	}
	if ( 'vi' === $lang ) {
		return $list[ $code ]['vi'];
	}
	return $list[ $code ]['en'];
}

function aef_speaker_country( $speaker_id ) {
	$raw  = function_exists( 'aef_meta' ) ? aef_meta( $speaker_id, 'country' ) : get_post_meta( $speaker_id, 'country', true );
	$code = aef_country_code_from_value( $raw );
	if ( $code ) {
		return aef_country_label( $code );
	}
	$raw = trim( (string) $raw );
	if ( '' === $raw || '—' === $raw ) {
		return '';
	}
	return $raw;
}

/**
 * UN members + observers + HKSAR/Macao. English: UN short names (Viet Nam).
 */
function aef_countries_raw() {
	return <<<'TXT'
AF	Afghanistan	Afghanistan
AL	Albania	Albania
DZ	Algeria	Algérie
AD	Andorra	Andorra
AO	Angola	Angola
AG	Antigua and Barbuda	Antigua và Barbuda
AR	Argentina	Argentina
AM	Armenia	Armenia
AU	Australia	Úc
AT	Austria	Áo
AZ	Azerbaijan	Azerbaijan
BS	Bahamas	Bahamas
BH	Bahrain	Bahrain
BD	Bangladesh	Bangladesh
BB	Barbados	Barbados
BY	Belarus	Belarus
BE	Belgium	Bỉ
BZ	Belize	Belize
BJ	Benin	Benin
BT	Bhutan	Bhutan
BO	Bolivia	Bolivia
BA	Bosnia and Herzegovina	Bosna và Hercegovina
BW	Botswana	Botswana
BR	Brazil	Brazil
BN	Brunei Darussalam	Brunei
BG	Bulgaria	Bulgaria
BF	Burkina Faso	Burkina Faso
BI	Burundi	Burundi
CV	Cabo Verde	Cabo Verde
KH	Cambodia	Campuchia
CM	Cameroon	Cameroon
CA	Canada	Canada
CF	Central African Republic	Cộng hòa Trung Phi
TD	Chad	Chad
CL	Chile	Chile
CN	China	Trung Quốc
CO	Colombia	Colombia
KM	Comoros	Comoros
CG	Congo	Congo
CD	Democratic Republic of the Congo	Cộng hòa Dân chủ Congo
CR	Costa Rica	Costa Rica
CI	Côte d’Ivoire	Côte d’Ivoire
HR	Croatia	Croatia
CU	Cuba	Cuba
CY	Cyprus	Síp
CZ	Czechia	Séc
DK	Denmark	Đan Mạch
DJ	Djibouti	Djibouti
DM	Dominica	Dominica
DO	Dominican Republic	Cộng hòa Dominica
EC	Ecuador	Ecuador
EG	Egypt	Ai Cập
SV	El Salvador	El Salvador
GQ	Equatorial Guinea	Guinea Xích đạo
ER	Eritrea	Eritrea
EE	Estonia	Estonia
SZ	Eswatini	Eswatini
ET	Ethiopia	Ethiopia
FJ	Fiji	Fiji
FI	Finland	Phần Lan
FR	France	Pháp
GA	Gabon	Gabon
GM	Gambia	Gambia
GE	Georgia	Georgia
DE	Germany	Đức
GH	Ghana	Ghana
GR	Greece	Hy Lạp
GD	Grenada	Grenada
GT	Guatemala	Guatemala
GN	Guinea	Guinea
GW	Guinea-Bissau	Guinea-Bissau
GY	Guyana	Guyana
HT	Haiti	Haiti
VA	Holy See	Tòa Thánh
HN	Honduras	Honduras
HK	Hong Kong SAR, China	Đặc khu Hành chính Hồng Kông (Trung Quốc)
HU	Hungary	Hungary
IS	Iceland	Iceland
IN	India	Ấn Độ
ID	Indonesia	Indonesia
IR	Iran	Iran
IQ	Iraq	Iraq
IE	Ireland	Ireland
IL	Israel	Israel
IT	Italy	Italy
JM	Jamaica	Jamaica
JP	Japan	Nhật Bản
JO	Jordan	Jordan
KZ	Kazakhstan	Kazakhstan
KE	Kenya	Kenya
KI	Kiribati	Kiribati
KP	Democratic People’s Republic of Korea	CHDCND Triều Tiên
KR	Republic of Korea	Hàn Quốc
KW	Kuwait	Kuwait
KG	Kyrgyzstan	Kyrgyzstan
LA	Lao People’s Democratic Republic	Lào
LV	Latvia	Latvia
LB	Lebanon	Li-băng
LS	Lesotho	Lesotho
LR	Liberia	Liberia
LY	Libya	Libya
LI	Liechtenstein	Liechtenstein
LT	Lithuania	Litva
LU	Luxembourg	Luxembourg
MO	Macao SAR, China	Đặc khu Hành chính Ma Cao (Trung Quốc)
MG	Madagascar	Madagascar
MW	Malawi	Malawi
MY	Malaysia	Malaysia
MV	Maldives	Maldives
ML	Mali	Mali
MT	Malta	Malta
MH	Marshall Islands	Quần đảo Marshall
MR	Mauritania	Mauritania
MU	Mauritius	Mauritius
MX	Mexico	Mexico
FM	Micronesia	Micronesia
MD	Republic of Moldova	Moldova
MC	Monaco	Monaco
MN	Mongolia	Mông Cổ
ME	Montenegro	Montenegro
MA	Morocco	Ma-rốc
MZ	Mozambique	Mozambique
MM	Myanmar	Myanmar
NA	Namibia	Namibia
NR	Nauru	Nauru
NP	Nepal	Nepal
NL	Netherlands	Hà Lan
NZ	New Zealand	New Zealand
NI	Nicaragua	Nicaragua
NE	Niger	Niger
NG	Nigeria	Nigeria
MK	North Macedonia	Bắc Macedonia
NO	Norway	Na Uy
OM	Oman	Oman
PK	Pakistan	Pakistan
PW	Palau	Palau
PS	State of Palestine	Nhà nước Palestine
PA	Panama	Panama
PG	Papua New Guinea	Papua New Guinea
PY	Paraguay	Paraguay
PE	Peru	Peru
PH	Philippines	Philippines
PL	Poland	Ba Lan
PT	Portugal	Bồ Đào Nha
QA	Qatar	Qatar
RO	Romania	Romania
RU	Russian Federation	Liên bang Nga
RW	Rwanda	Rwanda
KN	Saint Kitts and Nevis	Saint Kitts và Nevis
LC	Saint Lucia	Saint Lucia
VC	Saint Vincent and the Grenadines	Saint Vincent và Grenadines
WS	Samoa	Samoa
SM	San Marino	San Marino
ST	Sao Tome and Principe	São Tomé và Príncipe
SA	Saudi Arabia	Ả Rập Xê-út
SN	Senegal	Senegal
RS	Serbia	Serbia
SC	Seychelles	Seychelles
SL	Sierra Leone	Sierra Leone
SG	Singapore	Singapore
SK	Slovakia	Slovakia
SI	Slovenia	Slovenia
SB	Solomon Islands	Quần đảo Solomon
SO	Somalia	Somalia
ZA	South Africa	Nam Phi
SS	South Sudan	Nam Sudan
ES	Spain	Tây Ban Nha
LK	Sri Lanka	Sri Lanka
SD	Sudan	Sudan
SR	Suriname	Suriname
SE	Sweden	Thụy Điển
CH	Switzerland	Thụy Sĩ
SY	Syrian Arab Republic	Syria
TJ	Tajikistan	Tajikistan
TZ	United Republic of Tanzania	Tanzania
TH	Thailand	Thái Lan
TL	Timor-Leste	Timor-Leste
TG	Togo	Togo
TO	Tonga	Tonga
TT	Trinidad and Tobago	Trinidad và Tobago
TN	Tunisia	Tunisia
TR	Türkiye	Thổ Nhĩ Kỳ
TM	Turkmenistan	Turkmenistan
TV	Tuvalu	Tuvalu
UG	Uganda	Uganda
UA	Ukraine	Ukraina
AE	United Arab Emirates	Các Tiểu vương quốc Ả Rập Thống nhất
GB	United Kingdom	Vương quốc Anh
US	United States of America	Hoa Kỳ
UY	Uruguay	Uruguay
UZ	Uzbekistan	Uzbekistan
VU	Vanuatu	Vanuatu
VE	Venezuela	Venezuela
VN	Viet Nam	Việt Nam
YE	Yemen	Yemen
ZM	Zambia	Zambia
ZW	Zimbabwe	Zimbabwe
TXT;
}
