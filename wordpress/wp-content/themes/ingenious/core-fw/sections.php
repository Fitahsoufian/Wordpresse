<?php

function cwsfw_get_sections() {
	$l_components = cwsfw_get_local_components();
	$g_components = array();
	if (function_exists('cws_core_get_base_components')) {
		$g_components = cws_core_get_base_components();
		$g_components = cws_core_merge_components($g_components, $l_components);
	}

	$settings = array(
		'header_options' => array(
			'type' => 'section',
			'title' => esc_html__('Styling Options', 'ingenious' ),
			'icon' => array('fa', 'paint-brush'),
			'active' => true, // true by default
			'layout' => array(
				'logo' => array(
					'type' => 'tab',
					'init' => 'open',
					'icon' => array('fa', 'check-square'),
					'title' => esc_html__( 'Logo', 'ingenious' ),
					'layout' => array(
						'logo' => array(
							'title' => esc_html__( 'Dark Logo', 'ingenious' ),
							'type' => 'media',
							'url-atts' => 'readonly',
							'addrowclasses' => 'grid-col-6',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution logo', 'ingenious' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
						'light_logo' => array(
							'title' => esc_html__( 'Light Logo', 'ingenious' ),
							'type' => 'media',
							'url-atts' => 'readonly',
							'addrowclasses' => 'grid-col-6',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution Light logo', 'ingenious' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
						'header_logo_light' => array(
							'type' => 'select',
							'addrowclasses' => 'grid-col-12',
							'title' => esc_html__( 'Logo Variation', 'ingenious' ),
							'source' => array(
								'black' => array( esc_html__( 'Dark', 'ingenious' ), true),
								'white' => array( esc_html__( 'White', 'ingenious' ), false),
								'none' => array( esc_html__( 'None', 'ingenious' ), false)
							)
						),
						'logo_dims' => array(
							'title' => esc_html__( 'Dimensions (px)', 'ingenious' ),
							'type' => 'dimensions',
							'addrowclasses' => 'grid-col-4',
							'value' => array(
								'width' => array('placeholder' => esc_html__( 'Width', 'ingenious' ), 'value' => '' ),
								'height' => array('placeholder' => esc_html__( 'Height', 'ingenious' ), 'value' => '50' ),
							),
						),
						'logo_pos' => array(
							'title' => esc_html__( 'Position', 'ingenious' ),
							'type' => 'radio',
							'addrowclasses' => 'grid-col-4',
							'subtype' => 'images',
							'value' => array(
								'left' => array( esc_html__( 'Left', 'ingenious' ), 	true, '', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
								'center' =>array( esc_html__( 'Center', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
								'right' =>array( esc_html__( 'Right', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/align-right.png' ),
							),
						),
						'logo_margins' => array(
							'title' => esc_html__( 'Spacings (px)', 'ingenious' ),
							'type' => 'margins',
							'addrowclasses' => 'grid-col-4',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'ingenious' ), 'value' => '0'),
								'left' => array('placeholder' => esc_html__( 'left', 'ingenious' ), 'value' => '0'),
								'right' => array('placeholder' => esc_html__( 'Right', 'ingenious' ), 'value' => '0'),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'ingenious' ), 'value' => '0'),
								),
						),
						'mobile_logo' => array(
							'title' => esc_html__( 'Mobile Logo', 'ingenious' ),
							'type' => 'media',
							'url-atts' => 'readonly',
							'addrowclasses' => 'grid-col-6',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution Mobile logo', 'ingenious' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						),
						'sticky_logo' => array(
							'title' => esc_html__( 'Sticky Logo', 'ingenious' ),
							'type' => 'media',
							'addrowclasses' => 'grid-col-6',
							'url-atts' => 'readonly',
							'layout' => array(
								'is_high_dpi' => array(
									'title' => esc_html__( 'High-Resolution Sticky logo', 'ingenious' ),
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox'
								),
							),
						)
					)
				),
				'menu' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'list-alt' ),
					'title' => esc_html__( 'Menu', 'ingenious' ),
					'layout' => array(
						'menu_spacings' => array(
							'title' => esc_html__( 'Spacings Top, Bottom (px)', 'ingenious' ),
							'type' => 'dimensions',
							'addrowclasses' => 'grid-col-6',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'ingenious' ), 'value' => '20' ),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'ingenious' ), 'value' => '20' ),
							),
						),
						'menu_items_spacings'	=> array(
							'title'			=> esc_html__( 'Spacings between items (px)', 'ingenious' ),
							'addrowclasses' => 'grid-col-6',
							'type'			=> 'number',
							'value'			=> '20'
						),
						'menu_pos' => array(
							'title' => esc_html__( 'Position', 'ingenious' ),
							'type' => 'radio',
							'subtype' => 'images',
							'addrowclasses' => 'grid-col-12',
							'value' => array(
								'left' => array( esc_html__( 'Left', 'ingenious' ), 	false, '', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
								'center' =>array( esc_html__( 'Center', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
								'right' =>array( esc_html__( 'Right', 'ingenious' ), true, '', get_template_directory_uri() . '/img/fw_img/align-right.png' ),
							),
						),	
						'menu_opacity' => array(
							'title' 		=> esc_html__( 'Opacity', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Menu Opacity', 'ingenious' ),
								'content' => esc_html__( 'This option will apply a transparent header when set to 0. Options available from 0 to 100', 'ingenious' ),
							),								
							'type' 			=> 'number',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> " min='0' max='100'",
							'value'			=> '0'
						),
						'menu_bg_color' => array(
							'title' 		=> esc_html__( 'Background Color', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Background Color', 'ingenious' ),
								'content' => esc_html__( 'Change the background color of the menu and logo area.', 'ingenious' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> 'data-default-color="#f8f8f8"',
							'value'			=> '#f8f8f8'
						),
						'menu_font_color' => array(
							'title' 		=> esc_html__( 'Override Font Color', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Override Font Color', 'ingenious' ),
								'content' => esc_html__( 'This color is applied to the main menu only, sub-menu items will use the color which is set in Typography section.<br /> This option is very useful when menu and logo covers title area or slider.', 'ingenious' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> 'data-default-color="#fff;"',
							'value'			=> '#fff'
						),
						'menu_fw' => array(
							'title' => esc_html__( 'Disable Full-Width Menu', 'ingenious' ),
							'type' => 'checkbox',
							'atts' => 'checked',
							'addrowclasses' => 'checkbox grid-col-6'
						),
						'wmpl_menu_icon' => array(
							'title' => esc_html__( 'Show WPML icon in menu', 'ingenious' ),
							'type' => 'checkbox',
							'atts' => 'checked',
							'addrowclasses' => 'checkbox grid-col-6'
						),						
						'header_covers_slider' => array(
							'title' => esc_html__( 'Menu and logo overlays title area and homepage slider', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Menu Overlays Slider', 'ingenious' ),
								'content' => esc_html__( 'This option will force the menu and logo sections to overlay the title area. <br> It is useful when using transparent menu.', 'ingenious' ),
							),							
							'type' => 'checkbox',
							'atts' => 'checked',
							'addrowclasses' => 'checkbox grid-col-6'
						),		
						'menu_stick' => array(
							'type' => 'select',
							'addrowclasses' => 'grid-col-12',
							'title' => esc_html__( 'Sticky Menu', 'ingenious' ),
							'source' => array(
								'none' => array(esc_html__( 'None', 'ingenious' ), true),
								'smart' => array(esc_html__( 'Smart', 'ingenious' ), false),
								'standard' => array(esc_html__( 'Standard', 'ingenious' ), false),
							)
						),
					)
				),
				'header_options' => array(
					'type' => 'tab',
					'icon' => array('fa', 'header'),
					'title' => esc_html__( 'Title Area', 'ingenious' ),
					'layout' => array(
						'hide_title'	=> array(
							'title'	=> esc_html__( 'Hide Title Area', 'ingenious' ),
							'type'	=> 'checkbox',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
						'page_title_spacings' => array(
							'title' => esc_html__( 'Add Spacings (px)', 'ingenious' ),
							'type' => 'margins',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'ingenious' ), 'value' => '120'),
								'left' => array('placeholder' => esc_html__( 'left', 'ingenious' ), 'value' => '0'),
								'right' => array('placeholder' => esc_html__( 'Right', 'ingenious' ), 'value' => '0'),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'ingenious' ), 'value' => '120'),
							),
							'addrowclasses' => 'grid-col-6'
						),

						'default_header_image' => array(
							'title'	=> esc_html__( 'Add Background Image', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12 groups',
							'layout' => array(
								'image' => array(
									'title' => esc_html__( 'Background image', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'media',
								),
								'size' => array(
									'title' => esc_html__( 'Size', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'initial' =>array( esc_html__( 'Initial', 'ingenious' ), true,  '' ),
										'cover' => array( esc_html__( 'Cover', 'ingenious' ),  false, '' ),
										'contain' =>array( esc_html__( 'Contain', 'ingenious' ), false,  '' ),
									),
								),
								'repeat' => array(
									'title' => esc_html__( 'Repeat', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'no-repeat' => array( esc_html__( 'No repeat', 'ingenious' ),  false, '' ),
										'repeat' => array( esc_html__( 'Tile', 'ingenious' ),  true, '' ),
										'repeat-x' => array( esc_html__( 'Tile Horizontally', 'ingenious' ),  false, '' ),
										'repeat-y' =>array( esc_html__( 'Tile Vertically', 'ingenious' ), false,  '' ),
									),
								),
								'attachment' => array(
									'title' => esc_html__( 'Attachment', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'scroll' => array( esc_html__( 'Scroll', 'ingenious' ),  true, '' ),
										'fixed' =>array( esc_html__( 'Fixed', 'ingenious' ), false, '' ),
										'local' =>array( esc_html__( 'Local', 'ingenious' ), false, '' ),
									),
								),
								'position' => array(
									'title' => esc_html__( 'Position', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'cols' => 3,
									'type' => 'radio',
									'value' => array(
										'tl'=>	array( '', false ),
										'tc'=>	array( '', false ),
										'tr'=>	array( '', false ),
										'cl'=>	array( '', false ),
										'cc'=>	array( '', true ),
										'cr'=>	array( '', false ),
										'bl'=>	array( '', false ),
										'bc'=>	array( '', false ),
										'br'=>	array( '', false ),
									),
								),
							),
						),
						'add_pattern'	=> array(
							'title'	=> esc_html__( 'Add pattern', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'checked data-options="e:default_pattern_image;"',
							'addrowclasses' => 'checkbox alt grid-col-3'
						),
						'default_pattern_image' => array(
							'title'	=> esc_html__( 'Pattern Image', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'disable grid-col-12 groups',
							'layout' => array(
								'image' => array(
									'title' => esc_html__( 'Background image', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'media',
								),
								'size' => array(
									'title' => esc_html__( 'Size', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'initial' =>array( esc_html__( 'Initial', 'ingenious' ), true,  '' ),
										'cover' => array( esc_html__( 'Cover', 'ingenious' ),  false, '' ),
										'contain' =>array( esc_html__( 'Contain', 'ingenious' ), false,  '' ),
									),
								),
								'repeat' => array(
									'title' => esc_html__( 'Repeat', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'no-repeat' => array( esc_html__( 'No repeat', 'ingenious' ),  false, '' ),
										'repeat' => array( esc_html__( 'Tile', 'ingenious' ),  true, '' ),
										'repeat-x' => array( esc_html__( 'Tile Horizontally', 'ingenious' ),  false, '' ),
										'repeat-y' =>array( esc_html__( 'Tile Vertically', 'ingenious' ), false,  '' ),
									),
								),
								'attachment' => array(
									'title' => esc_html__( 'Attachment', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'scroll' => array( esc_html__( 'Scroll', 'ingenious' ),  true, '' ),
										'fixed' =>array( esc_html__( 'Fixed', 'ingenious' ), false, '' ),
										'local' =>array( esc_html__( 'Local', 'ingenious' ), false, '' ),
									),
								),
								'position' => array(
									'title' => esc_html__( 'Position', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'cols' => 3,
									'type' => 'radio',
									'value' => array(
										'tl'=>	array( '', false ),
										'tc'=>	array( '', false ),
										'tr'=>	array( '', false ),
										'cl'=>	array( '', false ),
										'cc'=>	array( '', true ),
										'cr'=>	array( '', false ),
										'bl'=>	array( '', false ),
										'bc'=>	array( '', false ),
										'br'=>	array( '', false ),
									),
								),
							),
						),						


						'header_font_color' => array(
							'title' 			=> esc_html__( 'Override Font Color', 'ingenious' ),
							'atts' 				=> 'data-default-color="' . INGENIOUS_THEME_HEADER_FONT_COLOR . '"',
							'type' 				=> 'text',
							'addrowclasses' 	=> 'grid-col-4',
							'value'				=> 	INGENIOUS_THEME_HEADER_FONT_COLOR
						),

						'header_overlay_type' => array(
							'title' => esc_html__( 'Overlay type', 'ingenious' ),
							'type' => 'radio',
							'addrowclasses' => 'grid-col-12',
							'value' => array(
								'color' => array( esc_html__( 'Color', 'ingenious' ), 	false, 'e:header_bg_color;d:header_bg_overlay_gradient;e:header_bg_opacity;', '' ),
								'gradient' =>array( esc_html__( 'Gradient', 'ingenious' ), true, 'd:header_bg_color;e:header_bg_overlay_gradient;e:header_bg_opacity;', '' ),
							),
						),
						'header_bg_color' => array(
							'title' 		=> esc_html__( 'Add Overlay Color', 'ingenious' ),
							'atts' 			=> 'data-default-color="' . INGENIOUS_THEME_HEADER_BG_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' 			=> 'text',
							'value'			=> INGENIOUS_THEME_HEADER_BG_COLOR
						),
						'header_bg_overlay_gradient' => array(
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12 disable box inside-box groups',
							'layout' => array(
								'c1' => array(
									'type' => 'text',
									'title' => esc_html__( 'From', 'ingenious' ),
									'atts' => 'data-default-color="#6b797f"',
									'value'	=> '#6b797f',
									'addrowclasses' => 'grid-col-6',
								),
								'op1' => array(
									'type' => 'number',
									'title' => esc_html__( 'From (Opacity %)', 'ingenious' ),
									'value' => '100',
									'addrowclasses' => 'grid-col-6',
								),				
								'c2' => array(
									'type' => 'text',
									'title' => esc_html__( 'To', 'ingenious' ),
									'atts' => 'data-default-color="#4ab769"',
									'value'	=> '#4ab769',
									'addrowclasses' => 'grid-col-6',
								),
								'op2' => array(
									'type' => 'number',
									'title' => esc_html__( 'To (Opacity %)', 'ingenious' ),
									'value' => '100',
									'addrowclasses' => 'grid-col-6',
								),
								'type' => array(
									'title' => esc_html__( 'Gradient type', 'ingenious' ),
									'type' => 'radio',
									'addrowclasses' => 'grid-col-6',
									'value' => array(
										'linear' => array( esc_html__( 'Linear', 'ingenious' ),  true, 'e:linear;d:radial' ),
										'radial' =>array( esc_html__( 'Radial', 'ingenious' ), false,  'd:linear;e:radial' ),
									),
								),
								'linear' => array(
									'title' => esc_html__( 'Linear settings', 'ingenious'  ),
									'type' => 'fields',
									'addrowclasses' => 'disable grid-col-6',
									'layout' => array(
										'angle' => array(
											'type' => 'number',
											'title' => esc_html__( 'Angle', 'ingenious' ),
											'value' => '45',
										),
									)
								),
								'radial' => array(
									'title' => esc_html__( 'Radial settings', 'ingenious'  ),
									'type' => 'fields',
									'addrowclasses' => 'disable grid-col-12',
									'layout' => array(
										'shape_type' => array(
											'title' => esc_html__( 'Shape', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'grid-col-4',
											'value' => array(
												'simple' => array( esc_html__( 'Simple', 'ingenious' ),  true, 'e:shape;d:size;d:keyword' ),
												'extended' =>array( esc_html__( 'Extended', 'ingenious' ), false, 'd:shape;e:size;e:keyword' ),
											),
										),
										'shape' => array(
											'title' => esc_html__( 'Gradient type', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'grid-col-6',
											'value' => array(
												'ellipse' => array( esc_html__( 'Ellipse', 'ingenious' ),  true ),
												'circle' =>array( esc_html__( 'Circle', 'ingenious' ), false ),
											),
										),
										'size' => array(
											'type' => 'text',
											'addrowclasses' => 'disable grid-col-4',
											'title' => esc_html__( 'Size', 'ingenious' ),
											'atts' => 'placeholder="'.esc_html__('Two space separated percent values, for example (60% 55%)', 'ingenious').'"',
										),
										'keyword' => array(
											'type' => 'select',
											'title' => esc_html__( 'Size keyword', 'ingenious' ),
											'addrowclasses' => 'disable grid-col-4',
											'source' => array(
												'closest-side' => array(esc_html__( 'Closest side', 'ingenious' ), false),
												'farthest-side' => array(esc_html__( 'Farthest side', 'ingenious' ), false),
												'closest-corner' => array(esc_html__( 'Closest corner', 'ingenious' ), false),
												'farthest-corner' => array(esc_html__( 'Farthest corner', 'ingenious' ), true),
											),
										),
									)
								),
								'custom_css' => array(
									'title' => esc_html__( 'Custom CSS rules', 'ingenious' ),
									'subtitle' => esc_html__( 'Enter styles', 'ingenious' ),
									'atts' => 'rows="10"',
									'type' => 'textarea',
									'addrowclasses' => 'grid-col-12 full_row',
								),
							),
						),
						'header_bg_opacity' => array(
							'title' => esc_html__( 'Overlay Opacity', 'ingenious' ),
							'type' => 'number',
							'atts' => " min='0' max='100'",
							'addrowclasses' => 'grid-col-4',
							'value'	=> '100',
						),

						'header_sep'	=> array(
							'title'	=> esc_html__( 'Header Separator', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'checked data-options="e:header_crop;e:header_crossing;e:header_left_overlay;e:header_right_overlay;e:header_left_layer;e:header_right_layer;"',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),
						'header_crop'	=> array(
							'title'		=> esc_html__( 'Crop Background', 'ingenious' ),
							'type'		=> 'select',
							'atts'		=> 'multiple',
							'addrowclasses' => 'grid-col-6',
							'source'		=> array(
								'left_crop'		=> array( esc_html__( 'Left Crop', 'ingenious' ), true ),
								'right_crop'	=> array( esc_html__( 'Right Crop', 'ingenious' ), true ),
								'center_crop'	=> array( esc_html__( 'Center Crop', 'ingenious' ), false ),
							)
						),	
						'header_crossing' => array(
							'title' => esc_html__( 'Crossing (in percentages)', 'ingenious' ),
							'type' => 'number',
							'atts' => " min='0' max='100'",
							'addrowclasses' => 'grid-col-6',
							'value'	=> '50',
						),	
						'header_left_overlay'	=> array(
							'title'	=> esc_html__( 'Left Triangle Overlay', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'data-options="e:header_left_overlay_color;e:header_left_overlay_opacity"',
							'addrowclasses' => 'checkbox grid-col-12'		
						),	
						'header_left_overlay_color' => array(
							'title' => esc_html__( 'Overlay Color', 'ingenious' ),
							'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
							'addrowclasses' => 'grid-col-6',
							'type' => 'text',
							'value'	=> INGENIOUS_THEME_COLOR
						),
						'header_left_overlay_opacity' => array(
							'title' => esc_html__( 'Overlay Opacity', 'ingenious' ),
							'type' => 'number',
							'atts' => " min='0' max='100'",
							'addrowclasses' => 'grid-col-6',
							'value'	=> '70',
						),	
						'header_right_overlay'	=> array(
							'title'	=> esc_html__( 'Right Triangle Overlay', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'data-options="e:header_right_overlay_color;e:header_right_overlay_opacity"',
							'addrowclasses' => 'checkbox grid-col-12'		
						),	
						'header_right_overlay_color' => array(
							'title' => esc_html__( 'Overlay Color', 'ingenious' ),
							'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
							'addrowclasses' => 'grid-col-6',
							'type' => 'text',
							'value'	=> INGENIOUS_THEME_COLOR
						),
						'header_right_overlay_opacity' => array(
							'title' => esc_html__( 'Overlay Opacity', 'ingenious' ),
							'type' => 'number',
							'atts' => " min='0' max='100'",
							'addrowclasses' => 'grid-col-6',
							'value'	=> '70',
						),	
						'header_left_layer'	=> array(
							'title'	=> esc_html__( 'Left Background Layer', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'data-options="e:header_left_layer_box;"',
							'addrowclasses' => 'checkbox grid-col-12'		
						),	
						'header_left_layer_box' => array(
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12',
							'layout' => array(
								'bg'	=> array(
									'title'		=> esc_html__( 'Background Type Color', 'ingenious' ),
									'type'		=> 'select',
									'addrowclasses' => 'grid-col-12',
									'source'		=> array(
											'color'		=> array( esc_html__( 'Color', 'ingenious' ), true, 'e:color;e:color_opacity;d:gradient_from;d:from_opacity;d:gradient_to;d:to_opacity;d:gradient_angle' ),
											'gradient'	=> array( esc_html__( 'Gradient', 'ingenious' ), false, 'd:color;d:color_opacity;e:gradient_from;e:from_opacity;e:gradient_to;e:to_opacity;e:gradient_angle' ),
									)
								),	
								'color' => array(
									'title' => esc_html__( 'Color', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),	
								'color_opacity' => array(
									'title' => esc_html__( 'Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_from' => array(
									'title' => esc_html__( 'From', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),	
								'from_opacity' => array(
									'title' => esc_html__( 'Gradient From Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_to' => array(
									'title' => esc_html__( 'To', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),
								'to_opacity' => array(
									'title' => esc_html__( 'Gradient To Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_angle' => array(
									'title' => esc_html__( 'Angle', 'ingenious' ),
									'addrowclasses' => 'grid-col-12',
									'type' => 'number',
									'atts' => " min='-360' max='360'",
									'value'	=> '45',
								),	
								'points'	=> array(
									'title'	=> esc_html__( 'Custom Points', 'ingenious' ),
									'type'	=> 'checkbox',
									'atts'	=> 'data-options="e:top_point;e:bot_point"',
									'addrowclasses' => 'checkbox grid-col-12'		
								),
								'top_point' => array(
									'title' => esc_html__( 'Top Point (in percentages)', 'ingenious' ),
									'addrowclasses' => 'grid-col-6',
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'value'	=> '50',
								),
								'bot_point' => array(
									'title' => esc_html__( 'Bottom Point (in percentages)', 'ingenious' ),
									'addrowclasses' => 'grid-col-6',
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'value'	=> '50',
								),
							)
						),
						'header_right_layer'	=> array(
							'title'	=> esc_html__( 'Right Background Layer', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'data-options="e:header_right_layer_box"',
							'addrowclasses' => 'checkbox grid-col-12'		
						),
						'header_right_layer_box' => array(
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12',
							'layout' => array(
								'bg'	=> array(
									'title'		=> esc_html__( 'Background Type Color', 'ingenious' ),
									'type'		=> 'select',
									'addrowclasses' => 'grid-col-12',
									'source'		=> array(
											'color'		=> array( esc_html__( 'Color', 'ingenious' ), true, 'e:color;e:color_opacity;d:gradient_from;d:from_opacity;d:gradient_to;d:to_opacity;d:gradient_angle' ),
											'gradient'	=> array( esc_html__( 'Gradient', 'ingenious' ), false, 'd:color;d:color_opacity;e:gradient_from;e:from_opacity;e:gradient_to;e:to_opacity;e:gradient_angle' ),
									)
								),	
								'color' => array(
									'title' => esc_html__( 'Color', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),	
								'color_opacity' => array(
									'title' => esc_html__( 'Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_from' => array(
									'title' => esc_html__( 'From', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),	
								'from_opacity' => array(
									'title' => esc_html__( 'Gradient From Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_to' => array(
									'title' => esc_html__( 'To', 'ingenious' ),
									'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
									'addrowclasses' => 'grid-col-6',
									'type' => 'text',
									'value'	=> INGENIOUS_THEME_COLOR
								),
								'to_opacity' => array(
									'title' => esc_html__( 'Gradient To Color Opacity', 'ingenious' ),
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'addrowclasses' => 'grid-col-6',
									'value'	=> '70',
								),
								'gradient_angle' => array(
									'title' => esc_html__( 'Angle', 'ingenious' ),
									'addrowclasses' => 'grid-col-12',
									'type' => 'number',
									'atts' => " min='-360' max='360'",
									'value'	=> '45',
								),		
								'points'	=> array(
									'title'	=> esc_html__( 'Custom Points', 'ingenious' ),
									'type'	=> 'checkbox',
									'atts'	=> 'data-options="e:top_point;e:bot_point"',
									'addrowclasses' => 'checkbox grid-col-12'		
								),
								'top_point' => array(
									'title' => esc_html__( 'Top Point (in percentages)', 'ingenious' ),
									'addrowclasses' => 'grid-col-6',
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'value'	=> '50',
								),
								'bot_point' => array(
									'title' => esc_html__( 'Bottom Point (in percentages)', 'ingenious' ),
									'addrowclasses' => 'grid-col-6',
									'type' => 'number',
									'atts' => " min='0' max='100'",
									'value'	=> '50',
								),	
							)
						),
					)
				),				
			'styling_options_color' => array(
					'type' => 'tab',
					'icon' => array('fa', 'calendar-plus-o'),
					'title' => esc_html__( 'Theme Color', 'ingenious' ),
					'layout' => array(
						'theme_color' => array(
							'title' => esc_html__( 'Main Color', 'ingenious' ),
							'atts' => 'data-default-color="' . INGENIOUS_THEME_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' => 'text',
							'value'	=> INGENIOUS_THEME_COLOR
						),
						'theme_helper_color' => array(
							'title' => esc_html__( 'Helper Color', 'ingenious' ),
							'atts' => 'data-default-color="' . INGENIOUS_THEME_HELPER_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' => 'text',
							'value'	=> INGENIOUS_THEME_HELPER_COLOR
						),
						'boxed_layout'	=> array(
							'title'	=> esc_html__( 'Apply Boxed Layout', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts' => 'data-options="e:url_background;"',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
						'url_background' => array(
					       'title' => esc_html__( 'Background Settings', 'ingenious' ),
					       'type' => 'info',
					       'subtype'	=> 'link',
					       'addrowclasses' => 'disable grid-col-12',
					       'value' => '<a href="'.get_admin_url(null, 'customize.php?autofocus[control]=background_image').'" target="_blank">'.esc_html__('Click this link to customize your background settings','ingenious').'</a>',
					    ),	
					),
				),
				'footer' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-book' ),
					'title' => esc_html__( 'Footer', 'ingenious' ),
					'layout' => array(
						'hide_footer'	=> array(
							'title'	=> esc_html__( 'Hide Footer', 'ingenious' ),
							'type'	=> 'checkbox',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
						'footer_bg_color'	=> array(
							'title'				=> esc_html__( 'Background Color', 'ingenious' ),
							'atts'				=> 'data-default-color="' . INGENIOUS_THEME_FOOTER_BG_COLOR . ';"',
							'addrowclasses' 	=> 'grid-col-3',
							'type'				=> 'text',
							'value'				=> INGENIOUS_THEME_FOOTER_BG_COLOR
						),
						'footer_bg_opacity' => array(
							'title' 			=> esc_html__( 'Background Opacity', 'ingenious' ),
							'type' 				=> 'number',
							'atts' 				=> " min='0' max='100'",
							'addrowclasses' 	=> 'grid-col-3',
							'value'				=> '50',
						),						
						'footer_font_color' => array(
							'title' 			=> esc_html__( 'Font color', 'ingenious' ),
							'atts' 				=> 'data-default-color="#eaeaea;"',
							'addrowclasses' 	=> 'grid-col-3',
							'type' 				=> 'text',
							'value'				=> '#b0b0b0'
						),
						'footer_title_color' => array(
							'title' 			=> esc_html__( 'Title color', 'ingenious' ),
							'atts' 				=> 'data-default-color="#fff;"',
							'addrowclasses' 	=> 'grid-col-3',
							'type' 				=> 'text',
							'value'				=> '#fff'
						),
						'default_footer_image'	=> array(
							'title'	=> esc_html__( 'Footer Image', 'ingenious' ),
							'addrowclasses' => 'grid-col-12',
							'type'	=> 'media'
						),
						'footer_sb'			=> array(
							'title'			=> esc_html__( "Footer's Sidebar", 'ingenious' ),
							'addrowclasses' => 'grid-col-12',
							'tooltip' => array(
								'title' => esc_html__( 'Footer area', 'ingenious' ),
								'content' => esc_html__( 'This options will set the default Footer widget area, unless you override it on each page', 'ingenious' ),
							),							
							'type'			=> 'select',
							'source'		=> 'sidebars'
						),						
						'copyrights_text'	=> array(
							'title'			=> esc_html__( "Copyrights content", 'ingenious' ),
							'type'			=> 'textarea',
							'addrowclasses' => 'grid-col-12',
							'atts' 			=> 'rows="5"',
							'value'			=> esc_html__( "Ingenious - Smart Home Automation WordPress Theme", 'ingenious' )
						),
						'copyrights_bg_color'	=> array(
							'title'					=> esc_html__( 'Copyrights Background Color', 'ingenious' ),
							'atts'					=> 'data-default-color="#2b2b2b;"',
							'addrowclasses' 		=> 'grid-col-4',
							'type'					=> 'text',
							'value'					=> '#2b2b2b'
						),
						'copyrights_bg_opacity' => array(
							'title' 			=> esc_html__( 'Copyrights Opacity', 'ingenious' ),
							'type' 				=> 'number',
							'atts' 				=> " min='0' max='100'",
							'addrowclasses' 	=> 'grid-col-4',
							'value'				=> '50',
						),
						'copyrights_font_color' => array(
							'title' 				=> esc_html__( 'Copyrights Font color', 'ingenious' ),
							'atts' 					=> 'data-default-color="#fff;"',
							'addrowclasses' 		=> 'grid-col-4',
							'type' 					=> 'text',
							'value'					=> '#fff'	
						),
						'footer_fixed_style'	=> array(
							'title'	=> esc_html__( 'Fixed Style', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts' => 'checked',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
					)
				)
			)
		),	// end of sections
		'layout_options' => array(
			'type' => 'section',
			'title' => esc_html__('Page Layouts', 'ingenious' ),
			'icon' => array('fa', 'th'),
			'layout'	=> array(
				'homepage_options' => array(
					'type' => 'tab',
					'init' 			=> 'open',					
					'title' => esc_html__('Home', 'ingenious' ),
					'icon' => array('fa', 'calendar-plus-o'),
					'layout' => array(
						'home_slider_type' => array(
							'title' => esc_html__('Slider', 'ingenious' ),
							'type' => 'radio',
							'value' => array(
								'none' => 	array( esc_html__('None', 'ingenious' ), true, 'd:home_slider_shortcode;d:video_section;d:static_img_section' ),
								'img_slider'=>	array( esc_html__('Image Slider', 'ingenious' ), false, 'e:home_slider_shortcode;d:video_section;d:static_img_section' ),
								'video_slider' => 	array( esc_html__('Video Slider', 'ingenious' ), false, 'd:home_slider_shortcode;e:video_section;d:static_img_section' ),
								'stat_img_slider' => 	array( esc_html__('Static image', 'ingenious' ), false, 'd:home_slider_shortcode;d:video_section;e:static_img_section' ),
							),
						),
						'home_slider_shortcode' => array(
							'title' => esc_html__( 'Slider shortcode', 'ingenious' ),
							'addrowclasses' => 'disable',
							'type' => 'text',
							'value' => '[rev_slider alias="default"]',
						),
						'video_section' => array(
							'title' => esc_html__( 'Video Slider Settings', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'disable',
							'layout' => array(
								'slider_switch' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox grid-col-12',
									'title' => esc_html__( 'Slider', 'ingenious' ),
									'atts' => 'data-options="e:slider_shortcode;d:set_video_header_height"',
								),
								'slider_shortcode' => array(
									'title' => esc_html__( 'Slider', 'ingenious' ),
									'addrowclasses' => 'disable grid-col-12 box',
									'type' => 'text',
								),
								'set_video_header_height' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox grid-col-12',
									'title' => esc_html__( 'Set Video height', 'ingenious' ),
									'atts' => 'data-options="e:video_header_height"',
								),
								'video_header_height' => array(
									'title' => esc_html__( 'Video height', 'ingenious' ),
									'addrowclasses' => 'disable grid-col-12 box',
									'type' => 'number',
									'value' => '600',
								),
								'video_type' => array(
									'title' => esc_html__('Video type', 'ingenious' ),
									'type' => 'radio',
									'addrowclasses' => 'grid-col-12 box',
									'value' => array(
										'self_hosted' => 	array( esc_html__('Self-hosted', 'ingenious' ), true, 'e:sh_source;d:youtube_source;d:vimeo_source' ),
										'youtube'=>	array( esc_html__('Youtube clip', 'ingenious' ), false, 'd:sh_source;e:youtube_source;d:vimeo_source' ),
										'vimeo' => 	array( esc_html__('Vimeo clip', 'ingenious' ), false, 'd:sh_source;d:youtube_source;e:vimeo_source' ),
									),
								),
								'sh_source' => array(
									'title' => esc_html__( 'Add video', 'ingenious' ),
									'type' => 'media',
									'addrowclasses' => 'grid-col-12 box',
								),
								'youtube_source' => array(
									'title' => esc_html__( 'Youtube video code', 'ingenious' ),
									'addrowclasses' => 'disable grid-col-12 box',
									'type' => 'text',
								),
								'vimeo_source' => array(
									'title' => esc_html__( 'Vimeo embed url', 'ingenious' ),
									'addrowclasses' => 'disable grid-col-12 box',
									'type' => 'text',
								),
								'use_pattern' => array(
									'type' => 'checkbox',
									'addrowclasses' => 'checkbox grid-col-12',
									'title' => esc_html__( 'Add pattern', 'ingenious' ),
									'atts' => 'data-options="e:pattern_image"',
								),
								'pattern_image' => array(
									'title' => esc_html__( 'Pattern image', 'ingenious' ),
									'addrowclasses' => 'disable grid-col-12 box',
									'type' => 'media',
								),
								'overlay_type' => array(
									'title' => esc_html__( 'Overlay type', 'ingenious' ),
									'type' => 'radio',
									'addrowclasses' => 'grid-col-12',
									'subtype' => 'images',
									'value' => array(
										'none' => array( esc_html__( 'None', 'ingenious' ), 	true, 'd:overlay_color;d:overlay_gradient_settings;d:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
										'color' => array( esc_html__( 'Color', 'ingenious' ), 	false, 'e:overlay_color;d:overlay_gradient_settings;e:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-left.png' ),
										'gradient' =>array( esc_html__( 'Gradient', 'ingenious' ), false, 'd:overlay_color;e:overlay_gradient_settings;e:overlay_opacity;', get_template_directory_uri() . '/img/fw_img/align-center.png' ),
									),
								),
								'overlay_color' => array(
									'title' => esc_html__( 'Overlay Color', 'ingenious' ),
									'atts' => 'data-default-color=""',
									'addrowclasses' => 'grid-col-12 box',
									'type' => 'text',
									'value'	=> ''
								),
								'overlay_opacity' => array(
									'type' => 'number',
									'addrowclasses' => 'grid-col-12 box',
									'title' => esc_html__( 'Opacity', 'ingenious' ),
									'placeholder' => esc_html__( 'In percents', 'ingenious' ),
									'value' => '40'
								),
								'overlay_gradient_settings' => array(
									'title' => esc_html__( 'Gradient settings', 'ingenious' ),
									'type' => 'fields',
									'addrowclasses' => 'disable grid-col-12 box',
									'layout' => array(
										'first_color' => array(
											'type' => 'text',
											'addrowclasses' => 'grid-col-12 box',
											'title' => esc_html__( 'From', 'ingenious' ),
											'atts' => 'data-default-color=""',
											'value'	=> ''
										),
										'second_color' => array(
											'type' => 'text',
											'addrowclasses' => 'grid-col-12 box',
											'title' => esc_html__( 'To', 'ingenious' ),
											'atts' => 'data-default-color=""',
											'value'	=> ''
										),
										'type' => array(
											'title' => esc_html__( 'Gradient type', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'grid-col-12 box',
											'value' => array(
												'linear' => array( esc_html__( 'Linear', 'ingenious' ),  true, 'e:angle;d:shape_settings' ),
												'radial' =>array( esc_html__( 'Radial', 'ingenious' ), false,  'd:angle;e:shape_settings' ),
											),
										),
										'angle' => array(
											'type' => 'number',
											'addrowclasses' => 'grid-col-12 box',
											'title' => esc_html__( 'Angle', 'ingenious' ),
											'value' => '45',
										),
										'shape_settings' => array(
											'title' => esc_html__( 'Gradient type', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'disable grid-col-12 box',
											'value' => array(
												'simple' => array( esc_html__( 'Simple', 'ingenious' ),  true, 'e:shape;d:size_keyword;d:size' ),
												'extended' =>array( esc_html__( 'Extended', 'ingenious' ), false, 'd:shape;e:size_keyword;e:size' ),
											),
										),
										'shape' => array(
											'title' => esc_html__( 'Gradient type', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'disable grid-col-12 box',
											'value' => array(
												'ellipse' => array( esc_html__( 'Ellipse', 'ingenious' ),  true ),
												'circle' =>array( esc_html__( 'Circle', 'ingenious' ), false ),
											),
										),
										'size_keyword' => array(
											'type' => 'select',
											'title' => esc_html__( 'Size keyword', 'ingenious' ),
											'addrowclasses' => 'disable grid-col-12 box',
											'source' => array(
												'closest-side' => array(esc_html__( 'Closest side', 'ingenious' ), false),
												'farthest-side' => array(esc_html__( 'Farthest side', 'ingenious' ), false),
												'closest-corner' => array(esc_html__( 'Closest corner', 'ingenious' ), false),
												'farthest-corner' => array(esc_html__( 'Farthest corner', 'ingenious' ), true),
											),
										),
										'size' => array(
											'type' => 'text',
											'addrowclasses' => 'disable grid-col-12 box',
											'title' => esc_html__( 'Size', 'ingenious' ),
											'atts' => 'placeholder="'.esc_html__( 'Two space separated percent values, for example (60% 55%)', 'ingenious' ).'"',
										),
									),
								),
							),
						),// end of video-section
						'static_img_section' => array(
							'title' => esc_html__( 'Static image', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'disable',
							'layout' => array(
								'static_img' => array(
									'title' => esc_html__( 'Select an image', 'ingenious' ),
									'type' => 'media',
									'url-atts' => 'readonly',
								),
							),
						),// end of static img slider-section
						'def-home-layout' => array(
							'title' 			=> esc_html__('Home Page Sidebar Layout', 'ingenious' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'ingenious' ), false, 'e:def-home-sidebar1;d:def-home-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'ingenious' ), false, 'e:def-home-sidebar1;d:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'ingenious' ), false, 'e:def-home-sidebar1;e:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'ingenious' ), true, 'd:def-home-sidebar1;d:def-home-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-home-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-home-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						)
					)
				),
				'page'		=> array(
					'type'			=> 'tab',
					'customizer' 	=> array( 'show' => false ),
					'icon' 			=> array( 'fa', 'calendar-plus-o' ),
					'title' 		=> esc_html__( 'Page', 'ingenious' ),
					'layout'		=> array(
						'def-page-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'ingenious' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'ingenious' ), false, 'e:def-page-sidebar1;d:def-page-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'ingenious' ), false, 'e:def-page-sidebar1;d:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'ingenious' ), false, 'e:def-page-sidebar1;e:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'ingenious' ), true, 'd:def-page-sidebar1;d:def-page-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-page-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-page-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
					)
				),
				'blog' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-book' ),
					'title' => esc_html__( 'Blog', 'ingenious' ),
					'layout' => array(
						'def-blog-layout' => array(
							'title' 			=> esc_html__('Sidebar Position', 'ingenious' ),
							'type' 				=> 'radio',
							'subtype' 			=> 'images',
							'value' 			=> array(
								'left' 				=> 	array( esc_html__('Left', 'ingenious' ), false, 'e:def-blog-sidebar1;d:def-blog-sidebar2;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' 			=> 	array( esc_html__('Right', 'ingenious' ), false, 'e:def-blog-sidebar1;d:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'both' 				=> 	array( esc_html__('Both', 'ingenious' ), false, 'e:def-blog-sidebar1;e:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/both.png' ),
								'none' 				=> 	array( esc_html__('None', 'ingenious' ), true, 'd:def-blog-sidebar1;d:def-blog-sidebar2;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'def-blog-sidebar1' => array(
							'title' 		=> esc_html__('Sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'def-blog-sidebar2' => array(
							'title' 		=> esc_html__('Right sidebar', 'ingenious' ),
							'type' 			=> 'select',
							'addrowclasses' => 'disable',
							'source' 		=> 'sidebars',
						),
						'blog_meta_position' => array(
							'title' => esc_html__('Meta position (Single)', 'ingenious' ),
							'type' => 'radio',
							'value' => array(
								'top' => 	array( esc_html__('Top', 'ingenious' ), true, '' ),
								'bottom'=>	array( esc_html__('Bottom', 'ingenious' ), false, '' ),
							),
						),
						'def_blog_layout'	=> array(
							'title'		=> esc_html__( 'Blog Layout', 'ingenious' ),
							'type'		=> 'radio',
							'subtype' 	=> 'images',
							'value' 	=> array(
								'1' 		=> array( esc_html__('Wide', 'ingenious' ), true, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'medium' 	=> array( esc_html__('Medium', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/medium.png'),
								'small' 	=> array( esc_html__('Small', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/small.png'),
								'2' 		=> array( esc_html__('2 Cols', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png'),
								'3'			=> array( esc_html__('3 Cols', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_3_columns.png'),
							),
						),
						'def_post_hide_meta'	=> array(
							'title'		=> esc_html__( 'Hide Post Meta', 'ingenious' ),
							'desc'	=> esc_html__( 'Properties specified here were hidden in post grid by default', 'ingenious' ),
							'type'	=> 'select',
							'atts'	=> 'multiple',
							'source'	=> array(
								'date'		=> array( esc_html__( 'Date', 'ingenious' ), false ),
								'post_info'	=> array( esc_html__( 'Post Info', 'ingenious' ), false ),
								'comments'	=> array( esc_html__( 'Comments', 'ingenious' ), false ),
								'read_more'	=> array( esc_html__( 'Read More', 'ingenious' ), false ),
								'terms'		=> array( esc_html__( 'Terms', 'ingenious' ), false ),
							),
						)
					)
				),
				'portfolio' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-picture-o' ),
					'title' => esc_html__( 'Portfolio', 'ingenious' ),
					'layout' => array(
						'def_portfolio_layout'	=> array(
							'title'		=> esc_html__( 'Layout', 'ingenious' ),
							'type'		=> 'radio',
							'subtype' => 'images',
							'value' => array(
								'1' => array( esc_html__('Wide', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'2' => array( esc_html__('2 Cols', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png'),
								'3' => array( esc_html__('3 Cols', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/pinterest_3_columns.png'),
								'4' => array( esc_html__('4 Cols', 'ingenious' ), true, '', get_template_directory_uri() . '/img/fw_img/pinterest_4_columns.png'),
							),
						),
						'def_portfolio_data_to_show'	=> array(
							'title'		=> esc_html__( 'Show Meta Data', 'ingenious' ),
							'type'		=> 'select',
							'atts'		=> 'multiple',
							'source'		=> array(
									'title'		=> array( esc_html__( 'Title', 'ingenious' ), true ),
									'excerpt'	=> array( esc_html__( 'Excerpt', 'ingenious' ), true ),
									'cats'		=> array( esc_html__( 'Categories', 'ingenious' ), true )
							)
						),
						'def_portfolio_chars_count' => array(
							'type' 	=> 'text',
							'title' => esc_html__( 'Excerpt chars Count (Archive)', 'ingenious' ),
							'value'	=> '200'
						),
					)
				),
				'staff' => array(
					'type' => 'tab',
					'icon' => array( 'fa', 'fa-picture-o' ),
					'title' => esc_html__( 'Staff', 'ingenious' ),
					'layout' => array(
						'def_staff_layout'	=> array(
							'title'		=> esc_html__( 'Layout', 'ingenious' ),
							'type'		=> 'radio',
							'subtype' 	=> 'images',
							'value' 	=> array(
								'1' 		=> array( esc_html__('1 Col', 'ingenious' ), false, '', get_template_directory_uri() . '/img/fw_img/large.png'),
								'2' 		=> array( esc_html__('2 Cols', 'ingenious' ), true, '', get_template_directory_uri() . '/img/fw_img/pinterest_2_columns.png')
							),
						),
						'def_staff_data_to_hide'	=> array(
							'title'		=> esc_html__( 'Hide Meta Data', 'ingenious' ),
							'type'		=> 'select',
							'atts'		=> 'multiple',
							'source'		=> array(
								'department'	=> array( esc_html__( 'Departments', 'ingenious' ), false ),
								'position'		=> array( esc_html__( 'Positions', 'ingenious' ), false )
							)
						)
					)
				),
				'sidebars' => array(
					'type' => 'tab',
					'customizer' => array('show' => false),
					'icon' => array('fa', 'calendar-plus-o'),
					'title' => esc_html__( 'Sidebars', 'ingenious' ),
					'layout' => array(
						'sidebars' => array(
							'type' => 'group',
							'addrowclasses' => 'group single_field',
							'title' => esc_html__('Sidebar generator', 'ingenious' ),
							'button_title' => esc_html__('Add new sidebar', 'ingenious' ),
							'layout' => array(
								'title' => array(
									'type' => 'text',
									'atts' => 'data-role="title"',
									'title' => esc_html__('Sidebar', 'ingenious' ),
								)
							)
						),
						'sticky_sidebars' => array(
							'title' => esc_html__( 'Sticky Sidebars', 'ingenious' ),
							'addrowclasses' => 'checkbox alt',
							'atts' => 'checked',
							'type' => 'checkbox',
					    )	
					)
				)
			)
		),
		'typography' => array(
			'type' => 'section',
			'title' => esc_html__('Typography', 'ingenious' ),
			'icon' => array('fa', 'font'),
			'layout' => array(
				'menu_font_options' => array(
					'type' => 'tab',
					'init' => 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Menu', 'ingenious' ),
					'layout' => array(
						'menu_font' => array(
							'title' => esc_html__('Menu Font', 'ingenious' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '15px',
								'line-height' => '36px',
								'color' => '#000',
								'font-family' => 'Poppins',
								'font-weight' => array( '400', '500' ),
								'font-sub' => array('latin'),
							)
						)
					)
				),
				'header_font_options' => array(
					'type' => 'tab',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Header', 'ingenious' ),
					'layout' => array(
						'header_font' => array(
							'title' => esc_html__('Header\'s Font', 'ingenious' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '28px',
								'line-height' => '39px',
								'color' => '#333333',
								'font-family' => 'Poppins',
								'font-weight' => array( '400', '500', '600' ),
								'font-sub' => array('latin'),
							),
						)
					)
				),
				'body_font_options' => array(
					'type' => 'tab',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Content', 'ingenious' ),
					'layout' => array(
						'body_font' => array(
							'title' => esc_html__('Content Font', 'ingenious' ),
							'type' => 'font',
							'font-color' => true,
							'font-size' => true,
							'font-sub' => true,
							'line-height' => true,
							'value' => array(
								'font-size' => '16px',
								'line-height' => '24px',
								'color' => '#363636',
								'font-family' => 'Roboto',
								'font-weight' => array( '300', '400', '500', '600', '700' ),
								'font-sub' => array('latin'),
							)
						)
					)
				)
			)
		), // end of sections
		'social_options' => array(
			'type' => 'section',
			'title' => esc_html__('Socials', 'ingenious' ),
			'icon' => array('fa', 'share-alt'),
			'layout' => array(
				'social_options'	=> array(
					'type' => 'tab',
					'init'	=> 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Social Options', 'ingenious' ),
					'layout' => array(
						'social_group' => array(
							'type' => 'group',
							'addrowclasses' => 'group sortable',
							'title' => esc_html__('Social Networks', 'ingenious' ),
							'button_title' => esc_html__('Add new social network', 'ingenious' ),
							'layout' => array(
								'title' => array(
									'type' => 'text',
									'atts' => 'data-role="title"',
									'title' => esc_html__('Social account title', 'ingenious' ),
								),
								'icon' => array(
									'type' => 'select',
									'addrowclasses' => 'fai',
									'source' => 'fa',
									'title' => esc_html__('Select the icon for this social contact', 'ingenious' )
								),
								'url' => array(
									'type' => 'text',
									'title' => esc_html__('Url to your account', 'ingenious' ),
								)
							)
						),
						'social_location' => array(
							'type' => 'select',
							'title' => esc_html__( 'Social Links Location', 'ingenious' ),
							'source' => array(
								'none' => array( esc_html__( 'None', 'ingenious' ), true),
								'top' => array( esc_html__( 'Top Panel', 'ingenious' ), false),
								'bottom' => array( esc_html__( 'Footer', 'ingenious' ), false),
								'both' => array( esc_html__( 'Both', 'ingenious' ), false)
							)
						)						
					)
				)
			)
		),
		'maintenance' => array(
			'type' => 'section',
			'title' => esc_html__( 'Help & Maintenance', 'ingenious' ),
			'icon' => array('fa', 'life-ring'),
			'layout' => array(
				'maintenance'	=> array(
					'type' => 'tab',
					'init'	=> 'open',
					'icon' => array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Maintenance', 'ingenious' ),
					'layout' => array(
						'show_loader'	=> array(
							'title'	=> esc_html__( 'Show Loader', 'ingenious' ),
							'type'	=> 'checkbox',
							'addrowclasses' => 'checkbox alt',
							'value'	=> '1'		
						),
						'show_breadcrumbs'	=> array(
							'title'	=> esc_html__( 'Show breadcrumbs', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts' => 'checked',
							'addrowclasses' => 'checkbox alt grid-col-12',
							'value'	=> '1'		
						),

						'scroll_to_top' => array(
							'type' => 'select',
							'addrowclasses' => 'grid-col-4',
							'title' => esc_html__( 'Scroll to Top (Arrow)', 'ingenious' ),
							'source' => array(
								'none' => array(esc_html__( 'None', 'ingenious' ), false),
								'standard' => array(esc_html__( 'Standard', 'ingenious' ), true),
								'smart' => array(esc_html__( 'Smart', 'ingenious' ), false),
							)
						),

						'portfolio_slug' => array(
							'type' 	=> 'text',
							'addrowclasses' => 'grid-col-4',
							'title' => esc_html__( 'Portfolio Slug', 'ingenious' ),
							'value'	=> 'portfolio'
						),					
						'staff_slug' => array(
							'type' 	=> 'text',
							'addrowclasses' => 'grid-col-4',
							'title' => esc_html__( 'Staff Slug', 'ingenious' ),
							'value'	=> 'staff'
						),
						'_theme_purchase_code' => array(
							'title' => esc_html__( 'Item Purchase Code', 'ingenious' ),
							'addrowclasses' => 'grid-col-12',
							'tooltip' => array(
								'title' => esc_html__( 'Item Purchase Code', 'ingenious' ),
								'content' => esc_html__( 'Fill in this field with your Item Purchase Code in order to get the demo content and further theme updates.<br/> Please note, this code is applied to the theme only, it will not register Revolution Slider or any other plugins.', 'ingenious' ),
							),													
							'type' 	=> 'text',
							'value'	=> ''
						),
					)
				),
				'help' => array(
					'type' => 'tab',
					'icon' => array('fa', 'calendar-plus-o'),
					'title' => esc_html__( 'Help', 'ingenious' ),
					'layout' => array(
						'help' => array(
					       'title' 			=> esc_html__( 'Help', 'ingenious' ),
					       'addrowclasses' => 'grid-col-12',
					       'type' 			=> 'info',
					       'subtype'		=> 'custom',
					       'value' 			=> '<a class="cwsfw_info_button" href="http://ingenious.cwsthemes.com/manual" target="_blank"><i class="fa fa-life-ring"></i>&nbsp;&nbsp;' . esc_html__( 'Online Tutorial', 'ingenious' ) . '</a>&nbsp;&nbsp;<a class="cwsfw_info_button" href="https://www.youtube.com/user/cwsvideotuts/playlists" target="_blank"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;' . esc_html__( 'Video Tutorial', 'ingenious' ) . '</a>',
					    ),
					)
				),	
				'crop' => array(
					'type' => 'tab',
					'icon' => array('fa', 'calendar-plus-o'),
					'title' => esc_html__( 'Crop Images', 'ingenious' ),
					'layout' => array(
						'crop_x' => array(
							'title' => esc_html__( 'Crop X', 'ingenious' ),
							'type' => 'radio',
							'addrowclasses' => 'grid-col-3',
							'value' => array(
								'left' => array( esc_html__( 'Left', 'ingenious' ),  false, '' ),
								'center' => array( esc_html__( 'Center', 'ingenious' ),  true, '' ),
								'right' => array( esc_html__( 'Right', 'ingenious' ),  false, '' ),
							),
						),
						'crop_y' => array(
							'title' => esc_html__( 'Crop Y', 'ingenious' ),
							'type' => 'radio',
							'addrowclasses' => 'grid-col-3',
							'value' => array(
								'top' => array( esc_html__( 'Top', 'ingenious' ),  false, '' ),
								'center' => array( esc_html__( 'Center', 'ingenious' ),  true, '' ),
								'bottom' => array( esc_html__( 'Bottom', 'ingenious' ),  false, '' ),
							),
						),

					)
				),			
			)
		)	
	);
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
		$settings['woo_options'] = array(
			'type'		=> 'section',
			'title'		=> esc_html__( 'WooCommerce', 'ingenious' ),
			'icon'		=> array('fa', 'shopping-cart'),
			'layout'	=> array(
				'woo_options' => array(
					'type' 	=> 'tab',
					'init'	=> 'open',
					'icon' 	=> array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Layout', 'ingenious' ),
					'layout' => array(
						'woo_cart_enable'	=> array(
							'title'			=> esc_html__( 'WooCommerce Cart', 'ingenious' ),
							'type'			=> 'checkbox',
							'addrowclasses'	=> 'checkbox alt'
						),
						'header_woo_logo_sel' => array(
							'type' => 'select',
							'addrowclasses' => 'grid-col-12',
							'title' => esc_html__( 'Logo Variation', 'ingenious' ),
							'source' => array(
								'black' => array( esc_html__( 'Dark', 'ingenious' ), true),
								'white' => array( esc_html__( 'White', 'ingenious' ), false),
								'none' => array( esc_html__( 'None', 'ingenious' ), false)
							)
						),						
						'woo_column' => array(
							'title' => esc_html__('Shop Layout', 'ingenious' ),
							'addrowclasses' => 'grid-col-6',
							'type' => 'select',
							'source' => array(
								'columns_1' => array(esc_html__( 'Columns 1', 'ingenious' ), false),
								'columns_2' => array(esc_html__( 'Columns 2', 'ingenious' ), false),
								'columns_3' => array(esc_html__( 'Columns 3', 'ingenious' ), true),
								'columns_4' => array(esc_html__( 'Columns 4', 'ingenious' ), false),
							),
						),
						'woo_num_products'	=> array(
							'title'			=> esc_html__( 'Products per page', 'ingenious' ),
							'addrowclasses' => 'grid-col-6',
							'type'			=> 'number',
							'value'			=> get_option( 'posts_per_page' )
						),
						'woo_related_columns' => array(
							'type' => 'select',
							'title' => esc_html__( 'Shop Related Items Layout', 'ingenious' ),
							'addrowclasses' => 'grid-col-6',
							'source' => array(
								'2' => array('Two Columns',false, ''),
								'3' => array('Three Columns',true, ''),
								'4' => array('Four Columns',false, '')
							),
						),
						'woo_related_num_products'	=> array(
							'title'			=> esc_html__( 'Related Products per Page', 'ingenious' ),
							'addrowclasses' => 'grid-col-6',
							'type'			=> 'number',
							'value'			=> get_option( 'posts_per_page' )
						),
						'woo_sb_layout' => array(
							'title' => esc_html__('Sidebar', 'ingenious' ),
							'type' => 'radio',
							'subtype' => 'images',
							'addrowclasses' => 'grid-col-6',
							'value' => array(
								'left' => 	array( esc_html__('Left', 'ingenious' ), false, 'e:woo_sidebar;',	get_template_directory_uri() . '/img/fw_img/left.png' ),
								'right' => 	array( esc_html__('Right', 'ingenious' ), true, 'e:woo_sidebar;', get_template_directory_uri() . '/img/fw_img/right.png' ),
								'none' => 	array( esc_html__('None', 'ingenious' ), false, 'd:woo_sidebar;', get_template_directory_uri() . '/img/fw_img/none.png' )
							),
						),
						'woo_sidebar' => array(
							'title' => esc_html__('Select a sidebar', 'ingenious' ),
							'type' => 'select',
							'addrowclasses' => 'disable grid-col-6',
							'source' => 'sidebars',
						),
					)
				),
				'woo_menu_options' => array(
					'type' 	=> 'tab',
					'icon' 	=> array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Menu', 'ingenious' ),
					'layout' => array(
						'woo_menu_opacity' => array(
							'title' 		=> esc_html__( 'Opacity', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Menu Opacity', 'ingenious' ),
								'content' => esc_html__( 'This option will apply a transparent header when set to 0. Options available from 0 to 100', 'ingenious' ),
							),								
							'type' 			=> 'number',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> " min='0' max='100'",
							'value'			=> '100'
						),
						'woo_menu_bg_color' => array(
							'title' 		=> esc_html__( 'Background Color', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Background Color', 'ingenious' ),
								'content' => esc_html__( 'Change the background color of the menu and logo area.', 'ingenious' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> 'data-default-color="#f8f8f8"',
							'value'			=> '#f8f8f8'
						),
						'woo_menu_font_color' => array(
							'title' 		=> esc_html__( 'Override Font Color', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Override Font Color', 'ingenious' ),
								'content' => esc_html__( 'This color is applied to the main menu only, sub-menu items will use the color which is set in Typography section.<br /> This option is very useful when menu and logo covers title area or slider.', 'ingenious' ),
							),							
							'type' 			=> 'text',
							'addrowclasses' => 'grid-col-4',
							'atts' 			=> 'data-default-color="#000;"',
							'value'			=> '#000'
						),
						'woo_header_covers_slider' => array(
							'title' => esc_html__( 'Menu and logo overlays title area and homepage slider', 'ingenious' ),
							'tooltip' => array(
								'title' => esc_html__( 'Menu Overlays Slider', 'ingenious' ),
								'content' => esc_html__( 'This option will force the menu and logo sections to overlay the title area. <br> It is useful when using transparent menu.', 'ingenious' ),
							),							
							'type' => 'checkbox',
							'addrowclasses' => 'checkbox grid-col-6'
						),		
					)
				),
				'woo_title_options' => array(
					'type' 	=> 'tab',
					'icon' 	=> array('fa', 'arrow-circle-o-up'),
					'title' => esc_html__( 'Title Area', 'ingenious' ),
					'layout' => array(
						'woo_hide_title'	=> array(
							'title'	=> esc_html__( 'Hide Title Area', 'ingenious' ),
							'type'	=> 'checkbox',
							'addrowclasses' => 'checkbox alt grid-col-12'		
						),	
						'woo_page_title_spacings' => array(
							'title' => esc_html__( 'Add Spacings (px)', 'ingenious' ),
							'type' => 'margins',
							'value' => array(
								'top' => array('placeholder' => esc_html__( 'Top', 'ingenious' ), 'value' => '60'),
								'left' => array('placeholder' => esc_html__( 'left', 'ingenious' ), 'value' => '0'),
								'right' => array('placeholder' => esc_html__( 'Right', 'ingenious' ), 'value' => '0'),
								'bottom' => array('placeholder' => esc_html__( 'Bottom', 'ingenious' ), 'value' => '60'),
							),
							'addrowclasses' => 'grid-col-6'
						),

						'woo_default_header_image' => array(
							'title'	=> esc_html__( 'Add Background Image', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12 groups',
							'layout' => array(
								'image' => array(
									'title' => esc_html__( 'Background image', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'media',
								),
								'size' => array(
									'title' => esc_html__( 'Size', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'initial' =>array( esc_html__( 'Initial', 'ingenious' ), true,  '' ),
										'cover' => array( esc_html__( 'Cover', 'ingenious' ),  false, '' ),
										'contain' =>array( esc_html__( 'Contain', 'ingenious' ), false,  '' ),
									),
								),
								'repeat' => array(
									'title' => esc_html__( 'Repeat', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'no-repeat' => array( esc_html__( 'No repeat', 'ingenious' ),  false, '' ),
										'repeat' => array( esc_html__( 'Tile', 'ingenious' ),  true, '' ),
										'repeat-x' => array( esc_html__( 'Tile Horizontally', 'ingenious' ),  false, '' ),
										'repeat-y' =>array( esc_html__( 'Tile Vertically', 'ingenious' ), false,  '' ),
									),
								),
								'attachment' => array(
									'title' => esc_html__( 'Attachment', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'scroll' => array( esc_html__( 'Scroll', 'ingenious' ),  true, '' ),
										'fixed' =>array( esc_html__( 'Fixed', 'ingenious' ), false, '' ),
										'local' =>array( esc_html__( 'Local', 'ingenious' ), false, '' ),
									),
								),
								'position' => array(
									'title' => esc_html__( 'Position', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'cols' => 3,
									'type' => 'radio',
									'value' => array(
										'tl'=>	array( '', false ),
										'tc'=>	array( '', false ),
										'tr'=>	array( '', false ),
										'cl'=>	array( '', false ),
										'cc'=>	array( '', true ),
										'cr'=>	array( '', false ),
										'bl'=>	array( '', false ),
										'bc'=>	array( '', false ),
										'br'=>	array( '', false ),
									),
								),
							),
						),
						'woo_add_pattern'	=> array(
							'title'	=> esc_html__( 'Add pattern', 'ingenious' ),
							'type'	=> 'checkbox',
							'atts'	=> 'checked data-options="e:woo_default_pattern_image;"',
							'addrowclasses' => 'checkbox alt grid-col-3'
						),
						'woo_default_pattern_image' => array(
							'title'	=> esc_html__( 'Pattern Image', 'ingenious' ),
							'type' => 'fields',
							'addrowclasses' => 'disable grid-col-12 groups',
							'layout' => array(
								'image' => array(
									'title' => esc_html__( 'Background image', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'media',
								),
								'size' => array(
									'title' => esc_html__( 'Size', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'initial' =>array( esc_html__( 'Initial', 'ingenious' ), true,  '' ),
										'cover' => array( esc_html__( 'Cover', 'ingenious' ),  false, '' ),
										'contain' =>array( esc_html__( 'Contain', 'ingenious' ), false,  '' ),
									),
								),
								'repeat' => array(
									'title' => esc_html__( 'Repeat', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'no-repeat' => array( esc_html__( 'No repeat', 'ingenious' ),  false, '' ),
										'repeat' => array( esc_html__( 'Tile', 'ingenious' ),  true, '' ),
										'repeat-x' => array( esc_html__( 'Tile Horizontally', 'ingenious' ),  false, '' ),
										'repeat-y' =>array( esc_html__( 'Tile Vertically', 'ingenious' ), false,  '' ),
									),
								),
								'attachment' => array(
									'title' => esc_html__( 'Attachment', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'type' => 'radio',
									'value' => array(
										'scroll' => array( esc_html__( 'Scroll', 'ingenious' ),  true, '' ),
										'fixed' =>array( esc_html__( 'Fixed', 'ingenious' ), false, '' ),
										'local' =>array( esc_html__( 'Local', 'ingenious' ), false, '' ),
									),
								),
								'position' => array(
									'title' => esc_html__( 'Position', 'ingenious' ),
									'addrowclasses' => 'grid-col-2',
									'cols' => 3,
									'type' => 'radio',
									'value' => array(
										'tl'=>	array( '', false ),
										'tc'=>	array( '', false ),
										'tr'=>	array( '', false ),
										'cl'=>	array( '', false ),
										'cc'=>	array( '', true ),
										'cr'=>	array( '', false ),
										'bl'=>	array( '', false ),
										'bc'=>	array( '', false ),
										'br'=>	array( '', false ),
									),
								),
							),
						),
						'woo_header_font_color' => array(
							'title' 			=> esc_html__( 'Override Font Color', 'ingenious' ),
							'atts' 				=> 'data-default-color="' . INGENIOUS_THEME_HEADER_FONT_COLOR . '"',
							'type' 				=> 'text',
							'addrowclasses' 	=> 'grid-col-4',
							'value'				=> 	INGENIOUS_THEME_HEADER_FONT_COLOR
						),
						'woo_header_overlay_type' => array(
							'title' => esc_html__( 'Overlay type', 'ingenious' ),
							'type' => 'radio',
							'addrowclasses' => 'grid-col-12',
							'value' => array(
								'color' => array( esc_html__( 'Color', 'ingenious' ), 	false, 'e:woo_header_bg_color;d:woo_header_bg_overlay_gradient;e:woo_header_bg_opacity;', '' ),
								'gradient' =>array( esc_html__( 'Gradient', 'ingenious' ), true, 'd:woo_header_bg_color;e:woo_header_bg_overlay_gradient;e:woo_header_bg_opacity;', '' ),
							),
						),
						'woo_header_bg_color' => array(
							'title' 		=> esc_html__( 'Add Overlay Color', 'ingenious' ),
							'atts' 			=> 'data-default-color="' . INGENIOUS_THEME_HEADER_BG_COLOR . '"',
							'addrowclasses' => 'grid-col-4',
							'type' 			=> 'text',
							'value'			=> INGENIOUS_THEME_HEADER_BG_COLOR
						),
						'woo_header_bg_overlay_gradient' => array(
							'type' => 'fields',
							'addrowclasses' => 'grid-col-12 disable box inside-box groups',
							'layout' => array(
								'c1' => array(
									'type' => 'text',
									'title' => esc_html__( 'From', 'ingenious' ),
									'atts' => 'data-default-color="#6b797f"',
									'value'	=> '#6b797f',
									'addrowclasses' => 'grid-col-6',
								),
								'op1' => array(
									'type' => 'number',
									'title' => esc_html__( 'From (Opacity %)', 'ingenious' ),
									'value' => '100',
									'addrowclasses' => 'grid-col-6',
								),				
								'c2' => array(
									'type' => 'text',
									'title' => esc_html__( 'To', 'ingenious' ),
									'atts' => 'data-default-color="#4ab769"',
									'value'	=> '#4ab769',
									'addrowclasses' => 'grid-col-6',
								),
								'op2' => array(
									'type' => 'number',
									'title' => esc_html__( 'To (Opacity %)', 'ingenious' ),
									'value' => '100',
									'addrowclasses' => 'grid-col-6',
								),
								'type' => array(
									'title' => esc_html__( 'Gradient type', 'ingenious' ),
									'type' => 'radio',
									'addrowclasses' => 'grid-col-6',
									'value' => array(
										'linear' => array( esc_html__( 'Linear', 'ingenious' ),  true, 'e:linear;d:radial' ),
										'radial' =>array( esc_html__( 'Radial', 'ingenious' ), false,  'd:linear;e:radial' ),
									),
								),
								'linear' => array(
									'title' => esc_html__( 'Linear settings', 'ingenious'  ),
									'type' => 'fields',
									'addrowclasses' => 'disable grid-col-6',
									'layout' => array(
										'angle' => array(
											'type' => 'number',
											'title' => esc_html__( 'Angle', 'ingenious' ),
											'value' => '45',
										),
									)
								),
								'radial' => array(
									'title' => esc_html__( 'Radial settings', 'ingenious'  ),
									'type' => 'fields',
									'addrowclasses' => 'disable grid-col-12',
									'layout' => array(
										'shape_type' => array(
											'title' => esc_html__( 'Shape', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'grid-col-4',
											'value' => array(
												'simple' => array( esc_html__( 'Simple', 'ingenious' ),  true, 'e:shape;d:size;d:keyword' ),
												'extended' =>array( esc_html__( 'Extended', 'ingenious' ), false, 'd:shape;e:size;e:keyword' ),
											),
										),
										'shape' => array(
											'title' => esc_html__( 'Gradient type', 'ingenious' ),
											'type' => 'radio',
											'addrowclasses' => 'grid-col-6',
											'value' => array(
												'ellipse' => array( esc_html__( 'Ellipse', 'ingenious' ),  true ),
												'circle' =>array( esc_html__( 'Circle', 'ingenious' ), false ),
											),
										),
										'size' => array(
											'type' => 'text',
											'addrowclasses' => 'disable grid-col-4',
											'title' => esc_html__( 'Size', 'ingenious' ),
											'atts' => 'placeholder="'.esc_html__('Two space separated percent values, for example (60% 55%)', 'ingenious').'"',
										),
										'keyword' => array(
											'type' => 'select',
											'title' => esc_html__( 'Size keyword', 'ingenious' ),
											'addrowclasses' => 'disable grid-col-4',
											'source' => array(
												'closest-side' => array(esc_html__( 'Closest side', 'ingenious' ), false),
												'farthest-side' => array(esc_html__( 'Farthest side', 'ingenious' ), false),
												'closest-corner' => array(esc_html__( 'Closest corner', 'ingenious' ), false),
												'farthest-corner' => array(esc_html__( 'Farthest corner', 'ingenious' ), true),
											),
										),
									)
								),
								'custom_css' => array(
									'title' => esc_html__( 'Custom CSS rules', 'ingenious' ),
									'subtitle' => esc_html__( 'Enter styles', 'ingenious' ),
									'atts' => 'rows="10"',
									'type' => 'textarea',
									'addrowclasses' => 'grid-col-12 full_row',
								),
							),
						),
						'woo_header_bg_opacity' => array(
							'title' => esc_html__( 'Overlay Opacity', 'ingenious' ),
							'type' => 'number',
							'atts' => " min='0' max='100'",
							'addrowclasses' => 'grid-col-4',
							'value'	=> '100',
						),
					)
				)
			)
		);
	}
	if (function_exists('cws_core_build_settings')) {
		cws_core_build_settings($settings, $g_components);
	}
	return $settings;
}

/*
	here local or overrided components can be added/changed
*/
function cwsfw_get_local_components() {
	return array();
}
?>