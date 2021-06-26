<?php
namespace Bunyad\Blocks\Loops;

/**
 * Grid Small Block Options
 */
class Overlay_Options extends Grid_Options
{
	public $block_id = 'Overlay';

	/**
	 * @inheritDoc
	 */
	public function init($type = '')
	{
		parent::init($type);

		// Block name to be used by page builders
		$this->block_name = esc_html__('Overlay Block', 'bunyad');

		$this->elementor_conf = [
			'title'      => $this->block_name,
			'icon'       => 'ts-ele-icon ts-ele-icon-overlay',
			'categories' => ['smart-mag-blocks'],
		];

		$this->options['sec-style'] += [
			'css_overlay_padding' => [
				'label'       => esc_html__('Overlay Paddings', 'bunyad-admin'),
				'type'        => 'dimensions',
				'devices'     => true,
				'size_units'  => ['%', 'px'],
				'selectors'   => [
					'{{WRAPPER}} .grid-overlay .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'default'     => [],
			],

			'css_media_height' => [
				'label'        => esc_html__('Forced Media Height', 'bunyad-admin'),
				'description'  => 'Not Recommended: By default media will change its height based on chosen aspect ratio.',
				'type'         => 'slider',
				'range'        => [
					'px' => ['min' => 100, 'max' => 1500, 'step' => 1]
				],
				'devices'      => true,
				'size_units'   => ['px'],
				'selectors'    => [
					'{{WRAPPER}} .media' => 'height: {{SIZE}}px;',
				],
			],
		];

		$options = &$this->options['sec-layout']['cat_labels_pos']['options'];
		$options = array_intersect_key($options, array_flip(['', 'top-left', 'top-right']));

		$this->options['sec-layout']['show_media']['type'] = 'hidden';

		$this->remove_options([
			'scheme', 
			'read_more',
			'excerpts',
			'numbers',
			
			'content_center',
			'css_content_pad',
			// Inherited from Grid, but not applicable.
			'media_location',
			'style',
			'large_style',
			'media_embed',
		]);
		
		$this->_add_defaults();
	}
}