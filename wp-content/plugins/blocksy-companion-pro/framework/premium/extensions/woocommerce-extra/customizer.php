<?php

$options = [
	'woocommerce_quickview_enabled' => [
		'label' => __( 'Quick View', 'blc' ),
		'type' => 'ct-switch',
		'switch' => true,
		'value' => 'yes',
		'setting' => [ 'transport' => 'postMessage' ],
		'sync' => blocksy_sync_whole_page([
			'loader_selector' => '[data-products]'
		]),
	],

	'woocommerce_quick_view_trigger' => [
		'label' => __( 'Trigger Modal On', 'blocksy' ),
		'type' => 'ct-select',
		'value' => 'button',
		'view' => 'text',
		'design' => 'inline',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => blocksy_ordered_keys(
			[
				'button' => __( 'Button click', 'blocksy' ),
				'image' => __( 'Image click', 'blocksy' ),
				'card' => __( 'Card click', 'blocksy' ),
			]
		),

		'sync' => blc_call_fn([
			'fn' => 'blocksy_sync_whole_page',
			'default' => []
		], [
			'loader_selector' => '.site-main .ct-open-quick-view'
		]),
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
	],
];

