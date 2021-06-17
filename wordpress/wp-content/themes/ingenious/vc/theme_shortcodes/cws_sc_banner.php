<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Banner', 'ingenious' ),
		"base"				=> "cws_sc_banner",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Offer', 'ingenious' ),
				"param_name"	=> "offer",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Description', 'ingenious' ),
				"param_name"	=> "descr",
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Banner Type', 'ingenious' ),
				"param_name"	=> "banner_type",
				"value"			=> array(
					esc_html__( 'Style 1', 'ingenious' )		=> 'style_1',
					esc_html__( 'Style 2', 'ingenious' )		=> 'style_2',
					esc_html__( 'Style 3', 'ingenious' )		=> 'style_3',
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Half Overlay', 'ingenious' ),
				"param_name"	=> "half_overlay",
				"value"			=> array(
					esc_html__( 'Left Overlay', 'ingenious' )		=> 'left_overlay',
					esc_html__( 'Right Overlay', 'ingenious' )		=> 'right_overlay',
				),
				"dependency"	=> array(
					"element"	=> "banner_type",
					"value"		=> array( 'style_2' , 'style_3')
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
				"param_name"	=> "bg_overlay_color",
				"value"			=> INGENIOUS_THEME_COLOR,
				"dependency"	=> array(
					"element"	=> "banner_type",
					"value"		=> array( 'style_2' , 'style_3')
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'ingenious' ) => true )
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Button Title', 'ingenious' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'ingenious' ),
				"param_name"	=> "button_url",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Open Link in New Tab', 'ingenious' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_alt",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Fill with Color', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_colors",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Edit Colors', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'ingenious' ),
				"param_name"	=> "button_font_color",
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color', 'ingenious' ),
				"param_name"	=> "button_bg_color",
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Color', 'ingenious' ),
				"param_name"	=> "button_border_color",
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_hover_colors",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Edit Hover Colors', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_font_color",
				"dependency"	=> array(
					"element"	=> "button_hover_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_bg_color",
				"dependency"	=> array(
					"element"	=> "button_hover_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_border_color",
				"dependency"	=> array(
					"element"	=> "button_hover_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Text Alignment', 'ingenious' ),
				"param_name"	=> "text_pos",
				"value"		=> array(
					esc_html__( 'Left Top', 'ingenious' ) 			=> 'a-left top',
					esc_html__( 'Center Top', 'ingenious' ) 		=> 'a-center top',
					esc_html__( 'Right Top', 'ingenious' ) 		=> 'a-right top',
					esc_html__( 'Left Center', 'ingenious' ) 		=> 'a-left center',			
					esc_html__( 'Center Center', 'ingenious' ) 	=> 'a-center center',
					esc_html__( 'Right Center', 'ingenious' ) 		=> 'a-right center',
					esc_html__( 'Left Bottom', 'ingenious' ) 		=> 'a-left bottom',
					esc_html__( 'Center Bottom', 'ingenious' ) 	=> 'a-center bottom',	
					esc_html__( 'Right Bottom', 'ingenious' ) 		=> 'a-right bottom'				
				)
			),
			array(
				"type"			=> "attach_image",
				"heading"		=> esc_html__( 'Background Image', 'ingenious' ),
				"param_name"	=> "bg_img",
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color Overlay', 'ingenious' ),
				"param_name"	=> "bg_color",
				"value"			=> 'transparent'
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Banner extends WPBakeryShortCode {
	    }
	}
?>