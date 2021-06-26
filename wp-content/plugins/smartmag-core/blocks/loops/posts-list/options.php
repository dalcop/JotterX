<?php

namespace Bunyad\Blocks\Loops;

use Bunyad\Blocks\Base\LoopOptions;

/**
 * Grid Small Block Options
 */
class PostsList_Options extends LoopOptions
{
	public $block_id = 'PostsList';
	protected $supported_columns = 2;

	/**
	 * @inheritDoc
	 */
	public function init()
	{
		parent::init();

		// Block name to be used by page builders
		$this->block_name = esc_html__('List Block', 'bunyad');

		$this->elementor_conf = [
			'title'      => $this->block_name,
			'icon'       => 'ts-ele-icon ts-ele-icon-list',
			'categories' => ['smart-mag-blocks'],
		];

		// Add to beginning of sec-layout.
		$this->options['sec-layout'] = [
			// 'style' => [
			// 	'label'       => esc_html__('Style', 'bunyad-admin'),
			// 	'type'        => 'select',
			// 	'options'     => [
			// 		''    => esc_html__('Normal', 'bunyad-admin'),
			// 		'sm'  => esc_html__('Small', 'bunyad-admin'),
			// 	],
			// 	'default'     => '',
			// ],

			'content_vcenter'  => [
				'label'        => esc_html__('Vertical Centered', 'bunyad-admin'),
				'type'         => 'switcher',
				'return_value' => '1',
				'default'      => '0',
				'position'     => ['at' => 'before', 'of' => 'show_media'],
			],

			'media_pos'  => [
				'label'       => esc_html__('Image Position', 'bunyad-admin'),
				'type'        => 'select',
				'options'     => [
					'left'    => esc_html__('Left', 'bunyad-admin'),
					'right'   => esc_html__('Right', 'bunyad-admin'),
				],
				'default'     => '',
				'position'    => ['at' => 'before', 'of' => 'show_media'],
				'condition'   => ['show_media' => '1']
			],

			'media_width' => [
				'label'       => esc_html__('Image Width %', 'bunyad-admin'),
				'type'        => 'number',
				// 'devices'     => true,
				'input_attrs' => ['min' => 1, 'max' => 85],
				'default'     => '',
				'position'    => ['at' => 'after', 'of' => 'show_media'],
				'condition'   => ['show_media' => '1'],
				'selectors'   => [
					'{{WRAPPER}} .media' => 'width: {{SIZE}}%; max-width: 85%;'
				],
			],

			'css_media_max_width' => [
				'label'       => esc_html__('Max Width', 'bunyad-admin'),
				'type'        => 'slider',
				'devices'     => true,
				'default'     => [],
				'position'    => ['at' => 'after', 'of' => 'media_width'],
				'condition'   => ['media_width!' => ''],
				'size_units'  => ['%', 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 800,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .media' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			],

		] + $this->options['sec-layout'];

		$this->options['sec-style'] += [
			'css_media_margin' => [
				'label'        => esc_html__('Media Margin/Gap', 'bunyad-admin'),
				'type'         => 'slider',
				'devices'      => true,
				'default'      => [],
				'size_units'   => ['%', 'px'],
				'selectors'    => [
					'{{WRAPPER}}' => '--list-p-media-margin: {{SIZE}}{{UNIT}};'
				],
				'condition'    => ['show_media' => '1'],
			],
		];

		$this->remove_options([
			'content_center',
		]);
		
		$this->_add_defaults();
	}
}