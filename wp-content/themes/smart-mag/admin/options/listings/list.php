<?php
/**
 * Fields for List loops.
 */
$fields = [];
\Bunyad\Util\repeat_options(
	$_common['tpl_listing'],
	[
		'list' => [
			'overrides'    => [
				'loop_{key}_excerpt_length' => [
					'value'  => 20,
				]
			],
			'replacements' => [
				'{selector}' => '.loop-list',
			],
			'skip' => [
				'loop_{key}_content_center',
			]
		]
	],
	$fields,
	['replace_in' => ['css', 'group', 'context']]
);

$fields[] = [
	'name'        => 'loop_list_media_width',
	'label'       => esc_html__('Image Width %', 'bunyad-admin'),
	'value'       => '',
	'desc'        => '',
	'type'        => 'number',
	'style'       => 'inline-sm',
	'input_attrs' => ['min' => 1, 'max' => 100, 'step' => 1],
	'transport'   => 'refresh',
	'css'         => [
		'.loop-list .media' => [
			'props'     => ['width' => '%s%', 'max-width' => '85%'],
		]
	],
];

$fields[] = [
	'name'        => 'css_loop_list_media_max_width',
	'label'       => esc_html__('Max Width %', 'bunyad-admin'),
	'value'       => '',
	'desc'        => '',
	'type'        => 'slider',
	'devices'     => true,
	'classes'     => 'sep-bottom',
	'input_attrs' => ['min' => 1, 'max' => 100, 'step' => 1],
	'css'         => [
		'.loop-list .media:not(i)' => [
			'props'     => ['max-width' => '%s%'],
		]
	],
	'condition' => [['key' => 'loop_list_media_width', 'value' => '', 'compare' => '!=']]
];

return $fields;