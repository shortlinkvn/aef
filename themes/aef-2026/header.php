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
<?php if ( function_exists( 'aef_chrome_on' ) && aef_chrome_on( 'ribbon_on' ) ) : ?>
<div class="draft-ribbon" role="status">
  <span><?php echo esc_html( aef_chrome( 'ribbon_tag' ) ); ?></span>
  <p><?php echo esc_html( aef_chrome( 'ribbon_text' ) ); ?></p>
  <a href="<?php echo esc_url( aef_chrome_href( aef_chrome( 'ribbon_link' ) ) ); ?>"><?php echo esc_html( aef_chrome( 'ribbon_cta' ) ); ?></a>
</div>
<?php endif; ?>
<?php if ( function_exists( 'aef_chrome_on' ) && aef_chrome_on( 'util_on' ) ) : ?>
<div class="util">
  <div class="shell">
    <nav>
      <a href="<?php echo esc_url( aef_chrome_href( aef_chrome( 'util_url' ) ) ); ?>"><span class="util-full"><?php echo esc_html( aef_chrome( 'util_label' ) ); ?></span><span class="util-short"><?php echo esc_html( aef_chrome( 'util_short' ) ); ?></span></a>
    </nav>
    <div class="lang" role="group" aria-label="Language">
      <a href="<?php echo aef_lang_link( 'en' ); ?>" <?php echo aef_lang() === 'en' ? 'aria-pressed="true"' : 'aria-pressed="false"'; ?>>EN</a>
      <a href="<?php echo aef_lang_link( 'vi' ); ?>" <?php echo aef_lang() === 'vi' ? 'aria-pressed="true"' : 'aria-pressed="false"'; ?>>VI</a>
    </div>
  </div>
</div>
<?php endif; ?>
<header class="header">
  <div class="shell head">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Autumn Economic Forum 2026">
      <img class="brand-mark" src="<?php echo esc_url( aef_logo( 'aef-logo-brand-palette.svg' ) ); ?>" alt="AEF 2026" width="200" height="80">
    </a>
    <nav class="nav" id="aef-primary-nav" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Primary', 'vi' => 'Chính' ) ) ); ?>">
      <?php aef_primary_nav(); ?>
      <?php if ( function_exists( 'aef_chrome_on' ) && aef_chrome_on( 'cta_on' ) ) : ?>
      <a class="cta nav-cta" href="<?php echo esc_url( aef_chrome_href( aef_chrome( 'cta_url' ) ) ); ?>"><?php echo esc_html( aef_chrome( 'cta_label' ) ); ?></a>
      <?php endif; ?>
    </nav>
    <?php if ( function_exists( 'aef_chrome_on' ) && aef_chrome_on( 'cta_on' ) ) : ?>
    <a class="cta head-cta" href="<?php echo esc_url( aef_chrome_href( aef_chrome( 'cta_url' ) ) ); ?>"><?php echo esc_html( aef_chrome( 'cta_label' ) ); ?></a>
    <?php endif; ?>
    <button class="burger" aria-label="<?php echo esc_attr( aef_chrome( 'menu_label' ) ); ?>" aria-expanded="false" aria-controls="aef-primary-nav" type="button" data-open="<?php echo esc_attr( aef_chrome( 'menu_label' ) ); ?>" data-close="<?php echo esc_attr( aef_chrome( 'close_label' ) ); ?>">
      <span class="burger-bars" aria-hidden="true"><i></i><i></i><i></i></span>
      <span class="burger-txt"><?php echo esc_html( aef_chrome( 'menu_label' ) ); ?></span>
    </button>
  </div>
</header>
<div class="nav-scrim" id="aef-nav-scrim" hidden></div>
<main id="app" tabindex="-1">
