<?php

namespace Bunyad\Blocks\Loops;

use Bunyad\Blocks\Base\LoopOptions;

/**
 * Grid Small Block Options
 */
class Highlights_Options extends LoopOptions
{
	public $block_id = 'Highlights';
	protected $supported_columns = 2;

	/**
	 * @inheritDoc
	 */
	public function init()
	{
		parent::init();

		// Block name to be used by page builders
		$this->block_name = esc_html__('Highlights Block', 'bunyad');

		$this->elementor_conf = [
			'title'      => $this->block_name,
			'icon'       => 'ts-ele-icon ts-ele-icon-highlights',
			'categories' => ['smart-mag-blocks'],

		];

		// No pagination for this block
		$this->remove_options(['pagination', 'pagination_type']);
		
		// Remove spacings.
		$this->remove_options([
			'css_column_gap',
			'css_row_gap'
		]);

		$this->options['sec-layout'] = [
			'small_style' => [
				'label'       => esc_html__('Small Style', 'bunyad-admin'),
				'type'        => 'select',
				'options'     => [
					'a'  => esc_html__('Style A: With Thumbs', 'bunyad-admin'),
					'b'  => esc_html__('Style B: Arrows / No Thumbs', 'bunyad-admin'),
				],
				'default'     => 'a',
			]
		] + $this->options['sec-layout'];

		$this->_add_defaults();
	}
}