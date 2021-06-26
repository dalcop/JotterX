<?php
/**
 * Fields for Grid Listings.
 */
$fields = [];
\Bunyad\Util\repeat_options(
	$_common['tpl_listing'],
	[
		'grid' => [
			'overrides'    => [
				'css_loop_{key}_title_typo' => [
					'css'   => '.loop-grid-base .post-title'
				]
			],
			'replacements' => [
				'{selector}' => '.loop-grid',
			],
			'skip' => [
				'loop_{key}_separators',
			]
		]
	],
	$fields,
	['replace_in' => ['css', 'group', 'context']]
);

$fields[] = [
	'name'       => 'css_loop_grid_title_sm_typo',
	'label'      => esc_html__('Small Style: Titles', 'bunyad-admin'),
	'value'      => '',
	'desc'       => 'Post titles typography for the small variation of grid posts.',
	'type'       => 'group',
	'devices'    => true,
	'group_type' => 'typography',
	'style'      => 'edit',
	'css'        => '.loop-grid-sm .post-title',
	// 'controls'   => ['spacing', 'transform', 'weight', 'style'],
];

return $fields;