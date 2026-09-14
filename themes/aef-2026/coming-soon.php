<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$lang   = aef_lang();
$target = aef_coming( 'coming_target' );
if ( ! $target ) {
	$target = '2026-10-27T00:00:00+07:00';
}
$year    = aef_coming( 'coming_year' );
$kicker  = aef_coming( 'coming_kicker' );
$event   = aef_coming( 'coming_event' );
$pos     = aef_coming( 'coming_pos' );
$theme   = aef_coming( 'coming_theme' );
$when    = aef_coming( 'coming_when' );
$cap     = aef_coming( 'coming_count_cap' );
$line    = aef_coming( 'coming_line' );
$status  = aef_coming( 'coming_status' );
$mail    = aef_coming( 'coming_mail' );
$title   = aef_coming( 'coming_title' );
$desc    = aef_coming( 'coming_desc' );
$og      = aef_coming( 'coming_og' );
$bg      = aef_coming_media( 'coming_bg_id', aef_img( 'visual/coming-soon.jpg' ) );
$ribbon  = aef_coming_media( 'coming_ribbon_id', aef_img( 'visual/coming-soon-ribbon.jpg' ) );
$logo    = aef_coming_media( 'coming_logo_id', aef_logo( 'aef-logo-mono-white.svg' ) );
$seal    = aef_coming_media( 'coming_seal_id', aef_logo( 'ubnd-kv.png' ) );
$fav     = aef_coming_media( 'coming_favicon_id', aef_logo( 'favicon-32.png' ) );
$show_seal   = aef_coming_on_flag( 'coming_show_seal' );
$show_logo   = aef_coming_on_flag( 'coming_show_logo' );
$show_ribbon = aef_coming_on_flag( 'coming_show_ribbon' ) && absint( aef_coming( 'coming_ribbon_id' ) );
$c4ir_mark   = aef_c4ir_mark( true );
$year_digits = preg_replace( '/\D/', '', $year ? $year : '2026' );
if ( strlen( $year_digits ) < 4 ) {
	$year_digits = '2026';
}
$y_hi = substr( $year_digits, 0, 2 );
$y_lo = substr( $year_digits, 2, 2 );
$when_lines = $when ? preg_split( '/\s*[·•|]\s*/u', $when ) : array();
if ( 'vi' === $lang && false !== stripos( $event, 'Diễn' ) ) {
	$event_lines = array( 'Diễn đàn', 'Kinh tế', 'Mùa thu' );
} else {
	$event_lines = $event ? preg_split( '/\s+/', $event ) : array();
}
$show_count  = aef_coming_on_flag( 'coming_show_count' );
$show_meta   = aef_coming_on_flag( 'coming_show_meta' );
$show_hosts  = aef_coming_on_flag( 'coming_show_hosts' );
$show_foot   = aef_coming_on_flag( 'coming_show_foot' );
$hosts = array(
	array( aef_coming( 'coming_host1_role' ), aef_coming( 'coming_host1_name' ) ),
	array( aef_coming( 'coming_host2_role' ), aef_coming( 'coming_host2_name' ) ),
	array( aef_coming( 'coming_host3_role' ), aef_coming( 'coming_host3_name' ) ),
	array( aef_coming( 'coming_host4_role' ), aef_coming( 'coming_host4_name' ) ),
);
$metas = array(
	array( aef_coming( 'coming_meta1_label' ), aef_coming( 'coming_meta1_value' ) ),
	array( aef_coming( 'coming_meta2_label' ), aef_coming( 'coming_meta2_value' ) ),
	array( aef_coming( 'coming_meta3_label' ), aef_coming( 'coming_meta3_value' ) ),
	array( aef_coming( 'coming_meta4_label' ), aef_coming( 'coming_meta4_value' ) ),
);
?><!doctype html>
<html lang="<?php echo esc_attr( $lang ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo esc_html( $title ); ?></title>
<meta name="description" content="<?php echo esc_attr( $desc ); ?>">
<meta name="theme-color" content="#1a6bff">
<meta property="og:title" content="<?php echo esc_attr( $og ? $og : $title ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $desc ); ?>">
<meta property="og:image" content="<?php echo esc_url( aef_img( 'visual/kv-2108.jpg' ) ); ?>">
<meta property="og:type" content="website">
<link rel="icon" href="<?php echo esc_url( $fav ); ?>" sizes="32x32">
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/coming-soon.css?ver=3.2.9' ); ?>">
</head>
<body class="coming-soon">
<div class="cs-stage" aria-hidden="true">
  <div class="cs-photo cs-photo-a" style="background-image:url('<?php echo esc_url( $bg ); ?>')"></div>
  <?php if ( $show_ribbon ) : ?>
  <div class="cs-photo cs-photo-b" style="background-image:url('<?php echo esc_url( $ribbon ); ?>')"></div>
  <?php endif; ?>
  <div class="cs-veil"></div>
  <div class="cs-shine"></div>
</div>

<header class="cs-top">
  <div class="cs-lock-l">
    <?php if ( $show_logo ) : ?>
    <img class="cs-logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( aef_coming( 'coming_logo_alt' ) ); ?>" width="200" height="80">
    <?php endif; ?>
  </div>
  <div class="cs-lock-c">
    <img class="cs-seal" src="<?php echo esc_url( $seal ); ?>" alt="<?php echo esc_attr( aef_coming( 'coming_seal_alt' ) ); ?>" width="120" height="88">
  </div>
  <div class="cs-lock-r">
    <img class="cs-c4ir" src="<?php echo esc_url( $c4ir_mark ); ?>" alt="Viet Nam Centre for the Fourth Industrial Revolution" width="190" height="105">
    <div class="cs-lang" role="group" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Language', 'vi' => 'Ngôn ngữ' ) ) ); ?>">
      <a href="<?php echo esc_url( add_query_arg( 'lang', 'en' ) ); ?>" <?php echo 'en' === $lang ? 'aria-pressed="true"' : ''; ?>>EN</a>
      <a href="<?php echo esc_url( add_query_arg( 'lang', 'vi' ) ); ?>" <?php echo 'vi' === $lang ? 'aria-pressed="true"' : ''; ?>>VI</a>
    </div>
  </div>
</header>

<main class="cs-main">
  <div class="cs-hero">
    <section class="cs-col">
      <?php if ( $event_lines ) : ?>
      <h1 class="cs-event"><?php foreach ( $event_lines as $el ) : ?><span><?php echo esc_html( $el ); ?></span><?php endforeach; ?></h1>
      <?php endif; ?>
      <div class="cs-yrow">
        <div class="cs-y" aria-hidden="true"><b><?php echo esc_html( $y_hi ); ?></b><b><?php echo esc_html( $y_lo ); ?></b></div>
        <div class="cs-yd">
          <?php foreach ( $when_lines as $wl ) : if ( '' === trim( $wl ) ) { continue; } ?>
          <span><?php echo aef_pretty_break( $wl ); ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <?php if ( $pos ) : ?>
      <p class="cs-pos"><?php
		$pos_lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $pos ) : array( $pos );
		foreach ( $pos_lines as $pl ) :
			?><span><?php echo esc_html( $pl ); ?></span><?php
		endforeach;
		?></p>
      <?php endif; ?>
      <?php if ( $theme ) : ?><p class="cs-theme"><?php echo aef_pretty_break( $theme ); ?></p><?php endif; ?>
    </section>
  </div>

  <?php if ( $show_count ) : ?>
  <div class="cs-count" data-target="<?php echo esc_attr( $target ); ?>" aria-live="polite">
    <div><b data-u="d">—</b><span><?php echo esc_html( aef_coming( 'coming_label_d' ) ); ?></span></div>
    <div><b data-u="h">—</b><span><?php echo esc_html( aef_coming( 'coming_label_h' ) ); ?></span></div>
    <div><b data-u="m">—</b><span><?php echo esc_html( aef_coming( 'coming_label_m' ) ); ?></span></div>
    <div><b data-u="s">—</b><span><?php echo esc_html( aef_coming( 'coming_label_s' ) ); ?></span></div>
  </div>
  <?php if ( $cap ) : ?><p class="cs-count-cap"><?php echo esc_html( $cap ); ?></p><?php endif; ?>
  <?php endif; ?>

  <?php if ( $show_meta ) : ?>
  <dl class="cs-meta">
    <?php foreach ( $metas as $row ) : if ( '' === $row[0] && '' === $row[1] ) { continue; } ?>
    <div><dt><?php echo aef_pretty_break( $row[0] ); ?></dt><dd><?php echo aef_pretty_break( $row[1] ); ?></dd></div>
    <?php endforeach; ?>
  </dl>
  <?php endif; ?>

  <?php if ( $show_hosts ) : ?>
  <ul class="cs-hosts">
    <?php foreach ( $hosts as $h ) : if ( '' === $h[0] && '' === $h[1] ) { continue; } if ( function_exists( 'aef_marks_wef' ) && ( aef_marks_wef( $h[0] ) || aef_marks_wef( $h[1] ) ) ) { continue; } ?>
    <li><small><?php echo aef_pretty_break( $h[0] ); ?></small><b><?php echo aef_pretty_break( $h[1] ); ?></b></li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</main>

<?php if ( $show_foot ) : ?>
<footer class="cs-foot">
  <?php if ( $line ) : ?><p><?php echo aef_pretty_break( $line ); ?></p><?php endif; ?>
  <?php if ( $status ) : ?><p class="cs-status"><?php echo esc_html( $status ); ?></p><?php endif; ?>
  <?php if ( $mail ) : ?><p class="cs-mail"><a href="mailto:<?php echo esc_attr( $mail ); ?>"><?php echo esc_html( $mail ); ?></a></p><?php endif; ?>
</footer>
<?php endif; ?>
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/coming-soon.js?ver=2.2.1' ); ?>"></script>
</body>
</html>
