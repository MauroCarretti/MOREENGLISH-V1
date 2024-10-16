<?php

if( ! function_exists( 'edublink_root_css_variables' ) ) :
	function edublink_root_css_variables() {
		$primary_color = edublink_set_value( 'eb_primary_color', '#1ab69d' );
		$primary_color_alt = edublink_set_value( 'eb_primary_color_alter', '#31b978' );
		$secondary_color = edublink_set_value( 'eb_secondary_color', '#ee4a62' );
		$body_color = edublink_set_value( 'eb_body_color', '#808080' );
		$heading_color = edublink_set_value( 'eb_heading_color', '#181818' );

		$body_typo_array = edublink_set_value( 'theme_body_typo' );
		$heading_typo_array = edublink_set_value( 'theme_heading_typo' );
		$body_font_family = 'Poppins';
		$heading_font_family = 'Spartan';
		$body_font_size = '15px';

		if ( isset( $body_typo_array['font-family'] ) && ! empty( $body_typo_array['font-family'] ) ) :
			$body_font_family = $body_typo_array['font-family'];
		endif;

		if ( isset( $body_typo_array['font-size'] ) && ! empty( $body_typo_array['font-size'] ) ) :
			$body_font_size = $body_typo_array['font-size'];
		endif;

		if ( isset( $heading_typo_array['font-family'] ) && ! empty( $heading_typo_array['font-family'] ) ) :
			$heading_font_family = $heading_typo_array['font-family'];
		endif;

		$css_root = ":root {
			--edublink-color-primary: {$primary_color};
			--edublink-color-primary-alt: {$primary_color_alt};
			--edublink-color-secondary: {$secondary_color};
			--edublink-color-textSecondary: #ff5b5c;
			--edublink-color-tertiary: #f8b81f;
			--edublink-color-dark: #231F40;
			--edublink-color-body: {$body_color};
			--edublink-color-heading: {$heading_color};
			--edublink-color-white: #ffffff;
			--edublink-color-shade: #F5F5F5;
			--edublink-color-border: #e5e5e5;
			--edublink-color-black: #000000;
			--edublink-color-off-white: #bababa;
			--edublink-color-lighten01: #f0f4f5;
			--edublink-color-lighten02: #edf5f8;
			--edublink-color-lighten03: #f5f1eb;
			--edublink-color-lighten04: #f7f5f2;
			--edublink-color-extra01: #0ecd73;
			--edublink-color-extra02: #8e56ff;
			--edublink-color-extra03: #f92596;
			--edublink-color-extra04: #5866eb;
			--edublink-color-extra05: #f8941f;
			--edublink-color-extra06: #39c0fa;
			--edublink-color-extra07: #da04f8;
			--edublink-color-extra08: #4664e4;
			--edublink-color-extra09: #525151;
			--edublink-color-extra10: #404040;
			--edublink-color-extra11: #22272e;
			--edublink-dark-primary: #1c242f;
			--edublink-dark-secondary: #111822;
			--edublink-dark-primary-alt: #020b17;
			--edublink-dark-secondary-alt: #282f3a;
			--edublink-gradient-primary: linear-gradient(-90deg, var(--edublink-color-primary-alt) 0%, var(--edublink-color-primary) 100%);
			--edublink-gradient-primary-alt: linear-gradient(-90deg, var(--edublink-color-primary) 0%, var(--edublink-color-primary-alt) 100%);
			--edublink-radius-small: 5px;
			--edublink-radius: 10px;
			--edublink-radius-big: 16px;
			--edublink-p-light: 300;
			--edublink-p-regular: 400;
			--edublink-p-medium: 500;
			--edublink-p-semi-bold: 600;
			--edublink-p-bold: 700;
			--edublink-p-extra-bold: 800;
			--edublink-p-black: 900;
			--edublink-shadow-darker: 0px 10px 50px 0px rgba(26,46,85,0.1);
			--edublink-shadow-darker2: 0px 20px 50px 0px rgba(26,46,85,0.1);
			--edublink-shadow-dark: 0px 10px 30px 0px rgba(20,36,66,0.15);
			--edublink-shadow-darkest: 0px 10px 30px 0px rgba(0,0,0,0.05);
			--edublink-shadow-darker3: 0px 4px 50px 0px rgba(0, 0, 0, 0.1);
			--edublink-shadow-darker4: 0px 20px 70px 0px rgba(15, 107, 92, 0.2);
			--edublink-transition: 0.3s;
			--edublink-transition-2: 0.5s;
			--edublink-transition-transform: transform .65s cubic-bezier(.23,1,.32,1);
			--edublink-font-primary: '{$body_font_family}', sans-serif;
			--edublink-font-secondary: '{$heading_font_family}', sans-serif;
			--edublink-font-size-b1: {$body_font_size};
			--edublink-font-size-b2: 13px;
			--edublink-font-size-b3: 14px;
			--edublink-font-size-b4: 12px;
			--edublink-line-height-b1: 1.73;
			--edublink-line-height-b2: 1.85;
			--edublink-line-height-b3: 1.6;
			--edublink-line-height-b4: 1.3;
			--edublink-h1: 50px;
			--edublink-h2: 36px;
			--edublink-h3: 28px;
			--edublink-h4: 20px;
			--edublink-h5: 18px;
			--edublink-h6: 16px;
			--edublink-h1-lineHeight: 1.2;
			--edublink-h2-lineHeight: 1.39;
			--edublink-h3-lineHeight: 1.43;
			--edublink-h4-lineHeight: 1.4;
			--edublink-h5-lineHeight: 1.45;
			--edublink-h6-lineHeight: 1.62;
		}";

		$global_breadcrumb_type   = edublink_set_value( 'global_breadcrumb_bg_type', 'image' );
		if ( 'image' === $global_breadcrumb_type ) :
			$global_breadcrumb_overlay   = edublink_set_value( 'global_breadcrumb_bg_image_overlay' );
			if ( $global_breadcrumb_overlay ) :
				$opacity = $global_breadcrumb_overlay/100;
				$css_root .= "
					.edublink-page-title-area.edublink-breadcrumb-has-bg:before {
						background:rgba(0,0,0,{$opacity});
					}
				";
			endif;
		endif;

		$css_root = apply_filters( 'edublink_custom_color_style_css', $css_root );   

		return $css_root;
	}
endif;

if( ! function_exists( 'edublink_custom_color_styles' ) ) :
	function edublink_custom_color_styles() {   
	    wp_add_inline_style( 'edublink-main', html_entity_decode( edublink_root_css_variables(), ENT_QUOTES ) );
	}
endif;
add_action( 'wp_enqueue_scripts', 'edublink_custom_color_styles' );