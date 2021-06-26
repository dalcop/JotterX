<?php
/**
 * Element: Trending Ticker
 */
$fields = [
	[
		'name'    => 'header_ticker_posts',
		'label'   => esc_html__('Number of Posts', 'bunyad-admin'),
		'desc'    => '',
		'value'   => 8,
		'type'    => 'number',
	],

	[
		'name'     => 'header_ticker_tags',
		'label'    => esc_html__('Limit to Tags', 'bunyad-admin'),
		'desc'     => 'Tag slugs separated by comma. Leave empty for no limit.',
		'value'    => '',
		'type'     => 'text',
	],

	[
		'name'     => 'header_ticker_heading',
		'label'    => esc_html__('Ticker Label', 'bunyad-admin'),
		'desc'     => 'Tag slugs separated by comma. Leave empty for no limit.',
		'value'    => '',
		'placeholder' => esc_html__('Trending', 'bunyad'),
		'type'     => 'text',
	],

	[
		'name'    => 'css_header_ticker_label_typo',
		'label'   => esc_html__('Label Typography', 'bunyad-admin'),
		'desc'    => '',
		'value'   => '',
		'type'    => 'group',
		'group_type' => 'typography',
		'style'   => 'edit',
		'css'     => '.trending-ticker .heading'
	],

	[
		'name'    => 'css_header_ticker_typo',
		'label'   => esc_html__('Titles Typography', 'bunyad-admin'),
		'desc'    => '',
		'value'   => '',
		'type'    => 'group',
		'group_type' => 'typography',
		'style'   => 'edit',
		'css'     => '.trending-ticker .post-link'
	],
];

return $fields;