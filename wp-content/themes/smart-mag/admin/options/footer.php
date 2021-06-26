<?php
/**
 * Footer settings
 */

/**
 * Fields: Upper footer
 */
$fields_upper = [
	[
		'name'    => 'footer_layout',
		'label'   => esc_html__('Select layout', 'bunyad-admin'),
		'desc'    => '',
		'value'   => 'bold',
		'type'    => 'select',
		'options' => [
			'classic' => esc_html__('Default / Classic', 'bunyad-admin'),
			'bold'    => esc_html__('Bold Style', 'bunyad-admin'),
		]
	],

	[
		'name'    => 'footer_scheme',
		'label'   => esc_html__('Color Scheme', 'bunyad-admin'),
		'desc'    => '',
		'value'   => 'dark',
		'type'    => 'select',
		'options' => [
			'dark'  => esc_html__('Dark', 'bunyad-admin'),
			'light' => esc_html__('Light', 'bunyad-admin'),
		]
	],

	[
		'name'  => 'footer_upper',
		'value' => 1,
		'label' => esc_html__('Enable Upper Footer', 'bunyad-admin'),
		'desc'  => 'If disabled, settings below do not apply.',
		'type'  => 'toggle',
		'classes' => 'sep-top',
		'style'   => 'inline-sm',
	],

	[
		'name'  => 'footer_upper_cols',
		'label' => esc_html__('Widget Columns', 'bunyad-admin'),
		'desc'  => '',
		'value' => 3,
		'type'  => 'select',
		'options' => [
			'2' => esc_html__('2 Columns', 'bunyad-admin'),
			'3' => esc_html__('3 Columns', 'bunyad-admin'),
			'4' => esc_html__('4 Columns', 'bunyad-admin'),
			'5' => esc_html__('5 Columns', 'bunyad-admin'),
			'1/2+1/4+1/4' => esc_html__('3 Columns: Half + 1/4 + 1/4', 'bunyad-admin'),
			'custom'      => esc_html__('Custom (Advanced)', 'bunyad-admin'),
		]
	],

	[
		'name'  => 'footer_upper_cols_custom',
		'value' => '1/4+1/4+1/4+1/4',
		'label' => esc_html__('Advanced: Widget Columns', 'bunyad-admin'),
		'desc'  => esc_html__('Sets the columns width and number of columns. Other examples: 1/2+1/2, 1/4+1/4+1/2, 1/2+1/4+1/4+1/4', 'bunyad-admin'),
		'type'  => 'text',
		'context' => [['key' => 'footer_upper_cols', 'value' => 'custom']]
	],

	/**
	 * Group: Block Heading Styles
	 */
	[
		'name'  => '_g_footer_heading',
		'label' => esc_html__('Widget Headings', 'bunyad-admin'),
		'desc'  => '',
		'type'  => 'group',
		'style' => 'collapsible',
	],
		[
			'name'  => 'footer_head_style',
			'label' => esc_html__('Heading Style', 'bunyad-admin'),
			'desc'  => '',
			'value' => 'b',
			'type'  => 'select',
			'options' => [
				'b'    => esc_html__('B: Simple Text', 'bunyad-admin'),
				'c'    => esc_html__('C: Accent & Border Below', 'bunyad-admin'),
				'c2'   => esc_html__('C2: Small Accent Line', 'bunyad-admin'),
				'e'    => esc_html__('E: Line on Right', 'bunyad-admin'),
				'e2'   => esc_html__('E2: Line on Right 2', 'bunyad-admin'),
				'h'    => esc_html__('H: Simple Line Below', 'bunyad-admin'),		
			],
			'group' => '_g_footer_heading',
		],

		[
			'name'  => 'css_footer_head_color',
			'label' => esc_html__('Heading Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.upper-footer .block-head .heading' => ['props' => ['color' => '%s']],
			],
			'group' => '_g_footer_heading',
		],
		[
			'name'  => 'css_footer_head_color_sd',
			'label' => esc_html__('Dark: Heading Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.upper-footer .block-head .heading' => ['props' => ['color' => '%s']],
			],
			'group' => '_g_footer_heading',
		],

		[
			'name'       => 'css_footer_head_typo',
			'label'      => esc_html__('Heading Typography', 'bunyad-admin'),
			'desc'       => '',
			'value'      => '',
			'type'       => 'group',
			'group_type' => 'typography',
			'style'      => 'edit',
			'css'        => '.upper-footer .block-head .heading',
			'group' => '_g_footer_heading',
		],

		[
			'name'  => 'css_footer_head_space_below',
			'label' => esc_html__('Space / Margin Below', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'slider',
			'css'   => [
				'.upper-footer .block-head' => ['props' => ['--space-below' => '%dpx']],
			],
			'group' => '_g_footer_heading',
		],

		[
			'name'  => 'css_footer_head_line_weight',
			'label' => esc_html__('Accent Line Weight', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'number',
			'style' => 'inline-sm',
			'css'   => [
				'.upper-footer .block-head' => ['props' => ['--line-weight' => '%dpx']],
			],
			'group' => '_g_footer_heading',
		],

		// // Only for c/c2.
		// [
		// 	'name'  => 'css_footer_head_line_width',
		// 	'label' => esc_html__('Accent Line Width', 'bunyad-admin'),
		// 	'desc'  => '',
		// 	'value' => '',
		// 	'type'  => 'number',
		// 	'style' => 'inline-sm',
		// 	'css'   => [
		// 		'.upper-footer .block-head' => ['props' => ['--c-line' => '%dpx']],
		// 	],
		// 	'group' => '_g_footer_heading',
		// ],

		[
			'name'  => 'css_footer_head_line_color',
			'label' => esc_html__('Accent Line Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.upper-footer .block-head' => ['props' => ['--c-line' => '%s']],
			],
			'group' => '_g_footer_heading',
		],
		[
			'name'  => 'css_footer_head_line_color_sd',
			'label' => esc_html__('Dark: Accent Line Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.s-dark .upper-footer .block-head' => ['props' => ['--c-line' => '%s']],
			],
			'group' => '_g_footer_heading',
		],

		[
			'name'  => 'css_footer_head_border_color',
			'label' => esc_html__('Border Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.upper-footer .block-head' => ['props' => ['--c-border' => '%s']],
			],
			'group' => '_g_footer_heading',
		],
		[
			'name'  => 'css_footer_head_border_color_sd',
			'label' => esc_html__('Dark: Border Color', 'bunyad-admin'),
			'desc'  => '',
			'value' => '',
			'type'  => 'color',
			'style' => 'inline-sm',
			'css'   => [
				'.s-dark .upper-footer .block-head' => ['props' => ['--c-border' => '%s']],
			],
			'group' => '_g_footer_heading',
		],

		[
			'name'    => 'css_footer_head_pad',
			'label'   => esc_html__('Heading Padding', 'bunyad-admin'),
			'desc'    => '',
			'value'   => '',
			'type'    => 'dimensions',
			'devices' => true,
			'css'     => [
				'.upper-footer .block-head' => ['dimensions' => 'padding'],
			],
			'group' => '_g_footer_heading',
		],
	// - End Group

	[
		'name'  => 'css_footer_upper_bg',
		'value' => '',
		'label' => esc_html__('Upper Background Color', 'bunyad-admin'),
		'desc'  => '',
		'type'  => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.main-footer .upper-footer' => ['props' => ['background-color' =>  '%s']]
		]
	],
	[
		'name'  => 'css_footer_upper_bg_sd',
		'value' => '',
		'label' => esc_html__('Dark: Background Color', 'bunyad-admin'),
		'desc'  => '',
		'type'  => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.s-dark .upper-footer' => ['props' => ['background-color' => '%s']]
		]
	],

	[
		'name'  => 'css_footer_upper_text',
		'value' => '',
		'label' => esc_html__('Text Color', 'bunyad-admin'),
		'desc'  => esc_html__('Only used for text in compatible widgets. Not used for links.', 'bunyad-admin'),
		'type' => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.upper-footer' => ['props' => ['color' => '%s']]
		],
	],
	[
		'name'  => 'css_footer_upper_text_sd',
		'value' => '',
		'label' => esc_html__('Dark: Text Color', 'bunyad-admin'),
		'desc'  => '',
		'type'  => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.s-dark .upper-footer' => ['props' => ['color' => '%s']]
		],
	],

	[
		'name'  => 'css_footer_upper_links',
		'value' => '',
		'label' => esc_html__('Links Color', 'bunyad-admin'),
		'desc'  => esc_html__('Only used for links in compatible widgets.', 'bunyad-admin'),
		'type' => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.main-footer .upper-footer' => ['props' => ['--c-links' => '%s']]
		],
	],
	[
		'name'  => 'css_footer_upper_links_sd',
		'value' => '',
		'label' => esc_html__('Dark: Links Color', 'bunyad-admin'),
		'desc'  => '',
		'type'  => 'color',
		'style' => 'inline-sm',
		'css'   => [
			'.s-dark .upper-footer' => ['props' => ['--c-links' => '%s']]
		],
	],

	[
		'name'    => 'css_footer_upper_pad',
		'label'   => esc_html__('Inner Padding', 'bunyad-admin'),
		'desc'    => '',
		'value'   => '',
		'type'    => 'dimensions',
		'devices' => true,
		'fields'  => ['top', 'bottom'],
		'css'     => [
			'.upper-footer > .wrap' => ['dimensions' => 'padding'],
		],
	],

	// [
	// 	'name'    => 'css_footer_bg',
	// 	'value'   => '',
	// 	'label'   => esc_html__('Footer Background Image', 'bunyad-admin'),
	// 	'desc'    => '',
	// 	'type'    => 'upload',
	// 	'options' => [
	// 		'type' => 'image'
	// 	],
	// 	'bg_type' => ['value' => 'cover-nonfixed'],
	// 	'css'     => [
	// 		'.main-footer .bg-wrap:before' => ['props' => ['background-image' =>  'url(%s)']]
	// 	],
	// ],
		
	// [
	// 	'name'        => 'css_footer_bg_opacity',
	// 	'label'       => esc_html__('Bg Image Opacity', 'bunyad-admin'),
	// 	'value'       => 0,
	// 	'desc'        => esc_html__('An opacity of 0.2 is recommended.', 'bunyad-admin'),
	// 	'type'        => 'slider',
	// 	'input_attrs' => ['min' => 0, 'max' => 1, 'step' => 0.1],
	// 	'css'         => [
	// 		'.main-footer .bg-wrap:before' => ['props' => ['opacity' => '%s']],
	// 	],
	// ]
];

$sections = [
	[
		'id'     => 'footer-upper',
		'title'  => esc_html__('General & Upper Footer', 'bunyad-admin'),
		'fields' => $fields_upper
	], // section
	
	[
		'id'     => 'footer-lower',
		'title'  => esc_html__('Lower Footer', 'bunyad-admin'),
		'fields' => [
	
			[
				'name'  => 'footer_lower',
				'label' => esc_html__('Enable Lower Footer', 'bunyad-admin'),
				'desc'  => '',
				'value' => 1,
				'type'  => 'toggle'
			],
			
			[
				'name'  => 'footer_copyright',
				'label' => esc_html__('Copyright Message', 'bunyad-admin'),
				'desc'  => '',
				'value' => '{copy} {year} ThemeSphere. Designed by <a href="https://theme-sphere.com">ThemeSphere</a>.', // Example copyright message in Customizer
				'type'  => 'textarea'
			],

			[
				'name'    => 'footer_logo',
				'value'   => '',
				'label'   => esc_html__('Footer Logo', 'bunyad-admin'),
				'desc'    => '',
				'type'    => 'upload',
				'options' => [
					'type' => 'image'
				],
				'context' => [['key' => 'footer_layout', 'value' => ['bold']]],
			],
			
			[
				'name'    => 'footer_logo_2x',
				'value'   => '',
				'label'   => esc_html__('Footer Logo Retina (2x)', 'bunyad-admin'),
				'desc'    => '',
				'type'    => 'upload',
				'options' => [
					'type' => 'image'
				],
				'context' => [['key' => 'footer_layout', 'value' => ['bold']]],
			],
			
			[
				'name'    => 'footer_social',
				'label'   => esc_html__('Footer Social Icons', 'bunyad-admin'),
				'desc'    => sprintf(
					esc_html__('NOTE: Configure these icons URLs from %1$sSocial Media Links%2$s.', 'bunyad-admin'),
					'<a href="#" class="focus-link is-with-nav" data-section="bunyad-misc-social">',
					'</a>'
				),
				'value'   => ['facebook', 'twitter', 'instagram', 'pinterest'],
				'type'    => 'checkboxes',
				'style'   => 'sortable',
				'context' => [['key' => 'footer_layout', 'value' => ['bold']]],
				'options' => $_common['social_services'],
			],

			[
				'name'  => 'css_footer_lower_bg',
				'label' => esc_html__('Background Color', 'bunyad-admin'),
				'desc'  => '',
				'value' => '',
				'type'  => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.main-footer .lower-footer' => ['props' => ['background-color' => '%s']]
				],
			],
			[
				'name'  => 'css_footer_lower_bg_sd',
				'label' => esc_html__('Dark: Background Color', 'bunyad-admin'),
				'desc'  => '',
				'value' => '',
				'type'  => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.s-dark .lower-footer' => ['props' => ['background-color' => '%s']]
				],
			],

			[
				'name'  => 'css_footer_lower_text',
				'value' => '',
				'label' => esc_html__('Text Color', 'bunyad-admin'),
				'desc'  => esc_html__('Only used for text in compatible widgets. Not used for links.', 'bunyad-admin'),
				'type' => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.lower-footer' => ['props' => ['color' => '%s']]
				],
			],
			[
				'name'  => 'css_footer_lower_text_sd',
				'value' => '',
				'label' => esc_html__('Dark: Text Color', 'bunyad-admin'),
				'desc'  => '',
				'type'  => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.s-dark .lower-footer' => ['props' => ['color' => '%s']]
				],
			],

			[
				'name'  => 'css_footer_lower_links',
				'value' => '',
				'label' => esc_html__('Links Color', 'bunyad-admin'),
				'desc'  => esc_html__('Only used for links in compatible widgets.', 'bunyad-admin'),
				'type' => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.main-footer .lower-footer' => ['props' => [
						'--c-links' => '%s',
						'--c-foot-menu' => '%s'
					]]
				],
			],
			[
				'name'  => 'css_footer_lower_links_sd',
				'value' => '',
				'label' => esc_html__('Dark: Links Color', 'bunyad-admin'),
				'desc'  => '',
				'type'  => 'color',
				'style' => 'inline-sm',
				'css'   => [
					'.s-dark .lower-footer' => ['props' => [
						'--c-links' => '%s',
						'--c-foot-menu' => '%s'
					]]
				],
			],

			[
				'name'    => 'css_footer_lower_pad',
				'label'   => esc_html__('Inner Padding', 'bunyad-admin'),
				'desc'    => '',
				'value'   => '',
				'type'    => 'dimensions',
				'devices' => true,
				'css'     => [
					'.lower-footer .inner' => ['dimensions' => 'padding'],
				],
			],
	
		], // fields
	], // section
];

$options['footer'] = [
	'title'    => esc_html__('Footer Settings', 'bunyad-admin'),
	'id'       => 'footer',
	'desc'     => esc_html__('Middle footer is activated by adding an instagram widget.', 'bunyad-admin'),
	'sections' => $sections
];

return $options;