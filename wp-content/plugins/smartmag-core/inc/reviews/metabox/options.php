<?php
/**
 * Fields to show for page meta box
 */

$options = array(
	array(
		'label' => esc_html__('Enable Review?', 'bunyad-admin'),
		'name'  => 'reviews', 
		'type'  => 'checkbox',
		'value' => 0,
	),

	array(
		'label' => esc_html__('Display Position', 'bunyad-admin'),
		'name'  => 'review_pos',
		'type'  => 'select',
		'options' => array(
			'none' => esc_html__('Do not display - Disabled', 'bunyad-admin'), 
			'top'  => esc_html__('Top', 'bunyad-admin'),
			'bottom' => esc_html__('Bottom', 'bunyad-admin')
		)
	),
	
	array(
		'label' => esc_html__('Show Rating As', 'bunyad-admin'),
		'name'  => 'review_type',
		'type'  => 'radio',
		'options' => array(
			'percent' => esc_html__('Percentage', 'bunyad-admin'),
			'points'  => esc_html__('Points', 'bunyad-admin'),
			'stars'   => esc_html__('Stars', 'bunyad-admin'),
		), 
		'value' => 'points',
	),


	array(
		'label'  => esc_html__('Review Type/Schema', 'bunyad-admin'),
		'name'   => 'review_schema',
		'type'   => 'select',
		'options' => array(
			''                   => 'Default (Product)',
			'none'               => 'Disabled',
			// 'Book'               => 'Book',
			'Course'             => 'Course',
			'CreativeWorkSeason' => 'CreativeWorkSeason',
			'CreativeWorkSeries' => 'CreativeWorkSeries',
			'Episode'            => 'Episode',
			// 'Event'              => 'Event',
			'Game'               => 'Game',
			// 'HowTo'              => 'HowTo',
			'LocalBusiness'      => 'LocalBusiness',
			'MediaObject'        => 'MediaObject',
			'Movie'              => 'Movie',
			'MusicPlaylist'      => 'MusicPlaylist',
			'MusicRecording'     => 'MusicRecording',
			'Organization'       => 'Organization',
			'Product'            => 'Product',
			'Recipe'             => 'Recipe',
			// 'SoftwareApplication' => 'SoftwareApplication',
		)
	),

	array(
		'label' => esc_html__('Schema: Author / Brand / Org', 'bunyad-admin'),
		'desc'  => 'Note: For schema "Product", this field should have brand/company of product. For CreativeWorks and Books it can be Author/Publisher.',
		'name'  => 'review_item_author',
		'type'  => 'text',
	),

	array(
		'label' => esc_html__('Schema: Author Type', 'bunyad-admin'),
		'name'  => 'review_item_author_type',
		'type'  => 'select',
		'options' => [
			'organization' => 'Organization',
			'person'       => 'Person',
		]
	),
	
	array(
		'label' => esc_html__('Schema: Official Link', 'bunyad-admin'),
		'name'  => 'review_item_link',
		'desc'  => 'Required for: Movie - Optional for other types. Link to the Wikipedia/official website/item site.',
		'type'  => 'text',
	),

	array(
		'label' => esc_html__('Schema: Item Name (Optional)', 'bunyad-admin'),
		'name'  => 'review_item_name',
		'type'  => 'text',
	),
	
	array(
		'label' => esc_html__('Heading (Optional)', 'bunyad-admin'),
		'name'  => 'review_heading',
		'type'  => 'text',
	),
	
	array(
		'label' => esc_html__('Verdict', 'bunyad-admin'),
		'name'  => 'review_verdict',
		'type'  => 'text',
		'value' => '',
	),
	
	array(
		'label' => esc_html__('Verdict Summary', 'bunyad-admin'),
		'name'  => 'review_verdict_text',
		'type'  => 'textarea',
		'options' => array('rows' => 5, 'cols' => 90),
		'value' => '',
	),
	
);