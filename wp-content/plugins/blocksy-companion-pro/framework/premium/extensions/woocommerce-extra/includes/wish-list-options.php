<?php

$all_pages = get_posts([
	'post_type' => 'page',
	'numberposts' => -1
]);

$pages_choices = [
	'' => __('Select a page', 'blc')
];

foreach ($all_pages as $page) {
	$pages_choices[$page->ID] = $page->post_title;
}

$options = [

	'woocommerce_wish_list' => [
		'title' => __('Products Wishlist', 'blc'),
		'container' => [
			'priority' => 3,
		],
		'options' => [

			'woo_wish_list_section_options' => [
				'type' => 'ct-options',
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					blocksy_rand_md5() => [
						'title' => __( 'General', 'blc' ),
						'type' => 'tab',
						'options' => [

							'product_wishlist_display_for' => [
								'label' => __('Show Wishlist For', 'blc'),
								'type' => 'ct-radio',
								'value' => 'logged_users',
								'view' => 'text',
								'design' => 'block',
								'choices' => [
									'logged_users' => __( 'Logged Users', 'blc' ),
									'all_users' => __( 'All Users', 'blc' ),
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'product_wishlist_display_for' => 'all_users' ],
								'options' => [

									'woocommerce_wish_list_page' => [
										'label' => __('Wish List Page', 'blc'),
										'type' => 'ct-select',
										'value' => '',
										'view' => 'text',
										'design' => 'inline',
										'divider' => 'top',
										'desc' => __('The page you select here will display the wish list for your logged out users.', 'blc'),
										'choices' => blocksy_ordered_keys($pages_choices)
									]

								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-title',
								'label' => __( 'Display Wishlist Button On', 'blc' ),
							],

							'has_archive_wishlist' => [
								'label' => __( 'Archive Pages', 'blc' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'sync' => blocksy_sync_whole_page([
									'loader_selector' => '[data-products]'
								]),
							],

							'has_single_wishlist' => [
								'label' => __( 'Single Product Pages', 'blc' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'sync' => blocksy_sync_whole_page([
									'loader_selector' => '.type-product .product-entry-wrapper'
								]),
							],

							'has_quick_view_wishlist' => [
								'label' => __( 'Quick View Modal', 'blc' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'sync' => blocksy_sync_whole_page([
									'loader_selector' => '[data-products]'
								]),
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							'has_wishlist_ajax_add_to_cart' => [
								'label' => __('AJAX Add To Cart', 'blc'),
								'type' => 'ct-switch',
								'value' => 'no',
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'product_wishlist_display_for' => 'all_users' ],
								'options' => [

									blocksy_get_options('single-elements/post-share-box', [
										'prefix' => 'single_page',
										'has_share_box_type' => false,
										'has_share_box_location1' => false,
										'has_bottom_share_box_spacing' => false,
										'has_share_items_border' => false,

										'general_tab_end' => [
											'wish_list_share_box_icons_size' => [
												'label' => __( 'Icons Size', 'blc' ),
												'type' => 'ct-slider',
												'min' => 5,
												'max' => 50,
												'value' => 15,
												'responsive' => true,
												'divider' => 'top',
												'setting' => [ 'transport' => 'postMessage' ],
											],

											'wish_list_share_box_icons_spacing' => [
												'label' => __( 'Icons Spacing', 'blc' ),
												'type' => 'ct-slider',
												'min' => 0,
												'max' => 50,
												'value' => 10,
												'responsive' => true,
												'divider' => 'top',
												'setting' => [ 'transport' => 'postMessage' ],
											],
										]
									])

								],
							],

						],
					],

					blocksy_rand_md5() => [
						'title' => __( 'Design', 'blc' ),
						'type' => 'tab',
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'has_archive_wishlist' => 'yes' ],
								'options' => [

									blocksy_rand_md5() => [
										'type' => 'ct-title',
										'label' => __( 'Archive Button', 'blc' ),
									],

									'archive_wishlist_button_icon_color' => [
										'label' => __( 'Icon Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [

											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Initial', 'blc' ),
												'id' => 'default',
												'inherit' => 'var(--color)',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => '#ffffff',
											],
										],
									],

									'archive_wishlist_button_background_color' => [
										'label' => __( 'Background Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'divider' => 'top',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Initial', 'blc' ),
												'id' => 'default',
												'inherit' => '#ffffff',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => 'var(--paletteColor1)',
											],
										],
									],

								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'has_single_wishlist' => 'yes' ],
								'options' => [

									blocksy_rand_md5() => [
										'type' => 'ct-title',
										'label' => __( 'Single Product Button', 'blc' ),
									],

									'single_wishlist_button_icon_color' => [
										'label' => __( 'Icon Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Initial', 'blc' ),
												'id' => 'default',
												'inherit' => '#ffffff',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => '#ffffff',
											],
										],
									],

									'single_wishlist_button_background_color' => [
										'label' => __( 'Background Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'divider' => 'top',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Default', 'blc' ),
												'id' => 'default',
												'inherit' => 'var(--paletteColor1)',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => 'var(--paletteColor1)',
											],
										],
									],

								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'has_quick_view_wishlist' => 'yes' ],
								'options' => [

									blocksy_rand_md5() => [
										'type' => 'ct-title',
										'label' => __( 'Quick View Modal Button', 'blc' ),
									],

									'quick_view_wishlist_button_icon_color' => [
										'label' => __( 'Icon Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Default', 'blc' ),
												'id' => 'default',
												'inherit' => '#ffffff',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => '#ffffff',
											],
										],
									],

									'quick_view_wishlist_button_background_color' => [
										'label' => __( 'Background Color', 'blc' ),
										'type'  => 'ct-color-picker',
										'design' => 'block:right',
										'divider' => 'top',
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'default' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],

											'hover' => [
												'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
											],
										],

										'pickers' => [
											[
												'title' => __( 'Default', 'blc' ),
												'id' => 'default',
												'inherit' => 'var(--paletteColor1)',
											],

											[
												'title' => __( 'Hover/Active', 'blc' ),
												'id' => 'hover',
												'inherit' => 'var(--paletteColor1)',
											],
										],
									],

								],
							],
						],
					],

				],
			],
		],
	],
];
