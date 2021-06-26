<?php

namespace Bunyad\Blocks\Loops;

use \Bunyad;
use Bunyad\Blocks\Base\CarouselTrait;

/**
 * Overlay grid Block
 */
class Overlay extends Grid
{
	use CarouselTrait;

	public $id = 'overlay';

	/**
	 * Extend base props
	 */
	public static function get_default_props()
	{
		$props = parent::get_default_props();

		return array_replace($props, [
			'excerpts'   => false,
			'meta_cat_style' => 'labels',
		]);
	}

	public function map_global_props($props)
	{
		$props = array_replace([
			'media_ratio'        => Bunyad::options()->loop_overlay_media_ratio,
			'media_ratio_custom' => Bunyad::options()->loop_overlay_media_ratio_custom,
			'content_center'     => Bunyad::options()->loop_grid_content_center,
			'excerpts'           => false,
			// 'excerpt_length'  => Bunyad::options()->loop_overlay_excerpt_length,
			'read_more'          => '',
			'column_gap'         => 'sm',
		], $props);

		$props = parent::map_global_props($props);

		return $props;
	}

	/**
	 * @inheritDoc
	 */
	public function init()
	{
		parent::init();

		// Will be added on wrap_attrs by parent in pre_render.
		$this->props['class'] = ['loop loop-overlay'];
	}

	/**
	 * @inheritDoc
	 */
	public function _pre_render()
	{
		parent::_pre_render();

		// Only top-left and top-right supported.
		if ($this->props['cat_labels']) {
			if (!in_array($this->props['cat_labels_pos'], ['top-left', 'top-right'])) {
				$this->props['cat_labels_pos'] = 'top-left';
			}
		}
	}

	/**
	 * @inheritDoc
	 */
	public function infer_image_sizes() 
	{
		$column_width = $this->get_relative_width() / $this->props['columns'];
		$image = 'bunyad-overlay';

		if ($column_width > 40) {
			// Scale by dividing original width of bunyad-overlay (31%).
			$this->props['image_props']['scale'] = $column_width / 31;
		}

		$this->props['image'] = $image;
	}
}