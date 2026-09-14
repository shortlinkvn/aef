</main>
<footer class="footer">
  <div class="shell fg">
    <div>
      <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-bottom:18px">
        <img src="<?php echo esc_url( aef_logo( 'aef-mono-white.svg' ) ); ?>" alt="AEF 2026" class="footer-mark" width="200" height="80">
      </a>
      <p><?php echo esc_html( aef_chrome( 'footer_blurb' ) ); ?></p>
      <p style="font-family:var(--mono);font-size:12px;letter-spacing:.06em"><?php echo esc_html( aef_chrome( 'footer_contact' ) ); ?></p>
    </div>
    <div>
      <h4><?php echo esc_html( aef_chrome( 'footer_h1' ) ); ?></h4>
      <?php
		if ( ! aef_render_menu( 'footer_forum' ) ) {
			$lang = aef_lang();
			foreach ( aef_chrome_links( 'nav' ) as $item ) {
				$label = ( 'vi' === $lang && ! empty( $item['vi'] ) ) ? $item['vi'] : $item['en'];
				if ( '' === $label ) {
					continue;
				}
				echo '<a href="' . esc_url( aef_chrome_href( $item['url'] ) ) . '">' . esc_html( $label ) . '</a>';
			}
		}
		?>
    </div>
    <div>
      <h4><?php echo esc_html( aef_chrome( 'footer_h2' ) ); ?></h4>
      <?php
		if ( ! aef_render_menu( 'footer_support' ) ) {
			$lang = aef_lang();
			foreach ( aef_chrome_links( 'visit' ) as $item ) {
				$label = ( 'vi' === $lang && ! empty( $item['vi'] ) ) ? $item['vi'] : $item['en'];
				if ( '' === $label ) {
					continue;
				}
				echo '<a href="' . esc_url( aef_chrome_href( $item['url'] ) ) . '">' . esc_html( $label ) . '</a>';
			}
		}
		?>
    </div>
    <div>
      <h4><?php echo esc_html( aef_chrome( 'footer_h3' ) ); ?></h4>
      <?php
		if ( ! aef_render_menu( 'footer_follow' ) ) {
			echo '<a href="' . esc_url( home_url( '/about/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'About the Forum', 'vi' => 'Về Diễn đàn' ) ) ) . '</a>';
			echo '<a href="' . esc_url( home_url( '/editions/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Editions', 'vi' => 'Các kỳ Diễn đàn' ) ) ) . '</a>';
			echo '<a href="' . esc_url( home_url( '/2026/media/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Media Hub', 'vi' => 'Trung tâm truyền thông' ) ) ) . '</a>';
			echo '<a href="' . esc_url( home_url( '/editions/2025/' ) ) . '">AEF 2025</a>';
		}
		?>
    </div>
  </div>
  <div class="shell fb">
    <span><?php echo esc_html( aef_chrome( 'footer_copy' ) ); ?></span>
    <span class="footer-legal">
      <?php
		$lang    = aef_lang();
		$legal_n = 0;
		foreach ( aef_chrome_links( 'legal' ) as $item ) :
			$label = ( 'vi' === $lang && ! empty( $item['vi'] ) ) ? $item['vi'] : $item['en'];
			if ( '' === $label ) {
				continue;
			}
			if ( $legal_n ) {
				echo ' · ';
			}
			$legal_n++;
			?>
        <a href="<?php echo esc_url( aef_chrome_href( $item['url'] ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php
		endforeach;
		?>
    </span>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
