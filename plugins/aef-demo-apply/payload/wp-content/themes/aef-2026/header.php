<!doctype html>
<html lang="<?php echo esc_attr( aef_lang() ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#app"><?php echo esc_html( aef_t( array( 'en' => 'Skip to content', 'vi' => 'Bỏ qua đến nội dung chính' ) ) ); ?></a>
<div class="draft-ribbon" role="status">
  <span><?php echo esc_html( aef_t( array( 'en' => 'INTERNAL DRAFT', 'vi' => 'DỰ THẢO NỘI BỘ' ) ) ); ?></span>
  <p><?php echo esc_html( aef_t( array(
	'en' => 'Programme updated 13.08.2026 · Information may change',
	'vi' => 'Chương trình cập nhật 13.08.2026 · Thông tin có thể được điều chỉnh',
  ) ) ); ?></p>
  <a href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Details', 'vi' => 'Chi tiết' ) ) ); ?></a>
</div>
<div class="util">
  <div class="shell">
    <nav>
      <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><span class="util-full"><?php echo esc_html( aef_t( array( 'en' => 'HCMC C4IR', 'vi' => 'Trung tâm C4IR TP.HCM' ) ) ); ?></span><span class="util-short">C4IR</span></a>
      <a href="<?php echo esc_url( home_url( '/2026/partners/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Partners', 'vi' => 'Đối tác' ) ) ); ?></a>
    </nav>
    <div class="lang" role="group" aria-label="Language">
      <a href="<?php echo aef_lang_link( 'en' ); ?>" <?php echo aef_lang() === 'en' ? 'aria-pressed="true"' : 'aria-pressed="false"'; ?>>EN</a>
      <a href="<?php echo aef_lang_link( 'vi' ); ?>" <?php echo aef_lang() === 'vi' ? 'aria-pressed="true"' : 'aria-pressed="false"'; ?>>VI</a>
    </div>
  </div>
</div>
<header class="header">
  <div class="shell head">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Autumn Economic Forum 2026">
      <img class="brand-mark" src="<?php echo esc_url( aef_logo( 'aef-logo-mono-white.svg' ) ); ?>" alt="AEF 2026" width="200" height="80">
    </a>
    <button class="burger" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Menu', 'vi' => 'Menu' ) ) ); ?>" aria-expanded="false" aria-controls="aef-primary-nav" type="button"><?php echo esc_html( aef_t( array( 'en' => 'Menu', 'vi' => 'Menu' ) ) ); ?></button>
    <nav class="nav" id="aef-primary-nav" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Primary', 'vi' => 'Chính' ) ) ); ?>">
      <?php aef_primary_nav(); ?>
      <a class="cta nav-cta" href="<?php echo esc_url( home_url( aef_settings()['register_path'] ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Register', 'vi' => 'Đăng ký' ) ) ); ?></a>
    </nav>
    <a class="cta head-cta" href="<?php echo esc_url( home_url( aef_settings()['register_path'] ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Register', 'vi' => 'Đăng ký' ) ) ); ?></a>
  </div>
  <?php aef_mega_bar(); ?>
</header>
<main id="app" tabindex="-1">
