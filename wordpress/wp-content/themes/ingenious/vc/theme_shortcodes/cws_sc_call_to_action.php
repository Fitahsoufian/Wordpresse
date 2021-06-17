<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Call To Action', 'ingenious' ),
		"base"				=> "cws_sc_call_to_action",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Callout Type', 'ingenious' ),
				"param_name"	=> "type",
				"value"		=> array(
					esc_html__( 'Style 1', 'ingenious' ) => 'style_1',
					esc_html__( 'Style 2', 'ingenious' ) => 'style_2',
					esc_html__( 'Style 3', 'ingenious' ) => 'style_3',					
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "call_anim",
				"value"			=> array( esc_html__( 'Add Animation', 'ingenious' ) => true ),
			),			
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Offer', 'ingenious' ),
				"param_name"	=> "offer",
				"dependency"	=> array(
					"element"	=> "type",
					"value"	=> array('style_3')
				),
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Offer Description', 'ingenious' ),
				"param_name"	=> "offer_descr",
				"dependency"	=> array(
					"element"	=> "type",
					"value"	=> array('style_3')
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_offer_color",
				"value"			=> array( esc_html__( 'Edit Offer Color', 'ingenious' ) => true ),
				"dependency"	=> array(
					"element"	=> "type",
					"value"	=> array('style_3')
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'ingenious' ),
				"param_name"	=> "font_offer_color",
				"dependency"	=> array(
					"element"	=> "customize_offer_color",
					"not_empty"	=> true
				),
				"value"			=> "#fff"
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
					"element"	=> "type",
					"value"		=> array( 'style_2' , 'style_3')
				),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
				"param_name"	=> "overlay_bg",
				"value"		=> array(
					esc_html__( 'Color', 'ingenious' ) 	=> 'color',
					esc_html__( 'Gradient', 'ingenious' ) 	=> 'gradient',					
					esc_html__( 'None', 'ingenious' ) 		=> 'none',					
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
				"param_name"	=> "overlay_color",
				"value"			=> INGENIOUS_THEME_COLOR,
				"dependency"	=> array(
					"element"	=> "overlay_bg",
					"value"		=> array( 'color' )
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Overlay Gradient Color From', 'ingenious' ),
				"param_name"	=> "overlay_gradient_from",
				"value"			=> INGENIOUS_THEME_COLOR,
				"dependency"	=> array(
					"element"	=> "overlay_bg",
					"value"		=> array( 'gradient' )
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Overlay Gradient Color To', 'ingenious' ),
				"param_name"	=> "overlay_gradient_to",
				"value"			=> INGENIOUS_THEME_COLOR,
				"dependency"	=> array(
					"element"	=> "overlay_bg",
					"value"		=> array( 'gradient' )
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Gradient Angle', 'ingenious' ),
				"param_name"	=> "overlay_gradient_angle",
				"value"			=> "180",
				"dependency"	=> array(
					"element"	=> "overlay_bg",
					"value"		=> array( 'gradient' )
				),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Text Alignment', 'ingenious' ),
				"param_name"	=> "text_align",
				"value"		=> array(
					esc_html__( 'Left', 'ingenious' ) => 'left',
					esc_html__( 'Center', 'ingenious' ) => 'center',
					esc_html__( 'Right', 'ingenious' ) => 'right',					
				),
				"dependency"	=> array(
					"element"	=> "type",
					"value"	=> array('style_1')
				),
			),	
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'ingenious' ) => true )
			),	
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Description', 'ingenious' ),
				"param_name"	=> "content",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_bg_img",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Add Background Image', 'ingenious' ) => true )
			),
			array(
				"type"			=> "attach_image",
				"param_name"	=> "bg_img",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Size', 'ingenious' ),
				"param_name"	=> "bg_size",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'Auto', 'ingenious' ) => 'auto',
					esc_html__( 'Cover', 'ingenious' ) => 'cover',
					esc_html__( 'Contain', 'ingenious' ) => 'contain',					
				)
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Repeat', 'ingenious' ),
				"param_name"	=> "bg_repeat",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'No Repeat', 'ingenious' ) 	=> 'repeat',
					esc_html__( 'Repeat', 'ingenious' ) 		=> 'no-repeat'				
				)
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Background Image Position', 'ingenious' ),
				"param_name"	=> "bg_pos",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "use_bg_img",
					"not_empty"	=> true
				),
				"value"		=> array(
					esc_html__( 'Left Top', 'ingenious' ) 		=> 'left top',
					esc_html__( 'Top Center', 'ingenious' ) 		=> 'top center',
					esc_html__( 'Top Right', 'ingenious' ) 		=> 'top right',
					esc_html__( 'Left Center', 'ingenious' ) 	=> 'left center',			
					esc_html__( 'Center Center', 'ingenious' ) 	=> 'center center',
					esc_html__( 'Right Center', 'ingenious' ) 	=> 'right center',
					esc_html__( 'Left Bottom', 'ingenious' ) 	=> 'left bottom',
					esc_html__( 'Bottom Center', 'ingenious' ) 	=> 'bottom center',	
					esc_html__( 'Right Bottom', 'ingenious' ) 	=> 'right bottom'				
				)
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"heading"		=> esc_html__( 'Top and Bottom Spacings (px)', 'ingenious' ),
				"param_name"	=> "paddings",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "color_over_img",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Use Color Overlay', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color', 'ingenious' ),
				"param_name"	=> "bg_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "color_over_img",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "button_text",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'ingenious' ),
				"param_name"	=> "button_url",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Open Link in New Tab', 'ingenious' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_alt",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Fill with Color', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Size', 'ingenious' ),
				"param_name"	=> "button_size",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array(
					esc_html__( 'Small', 'ingenious' )		=> 'small',
					esc_html__( 'Regular', 'ingenious' )	=> 'regular',
					esc_html__( 'Large', 'ingenious' )		=> 'large'
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_colors",
				"group"			=> esc_html__( "Button", "ingenious" ),
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
				"group"			=> esc_html__( "Button", "ingenious" ),
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
				"group"			=> esc_html__( "Button", "ingenious" ),
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
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_font_color",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_bg_color",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Hover Color', 'ingenious' ),
				"param_name"	=> "button_hover_border_color",
				"group"			=> esc_html__( "Button", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "button_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
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
	    class WPBakeryShortCode_CWS_Sc_Call_To_Action extends WPBakeryShortCode {
	    }
	}
?>