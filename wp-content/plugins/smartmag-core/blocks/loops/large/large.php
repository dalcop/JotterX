<?php

namespace Bunyad\Blocks\Loops;
use \Bunyad;

/**
 * Large Block - an extension of Grid block, with small config changes.
 */
class Large extends Grid
{
	public $id = 'large';

	// Uses view from Grid bock.
	public $view_id = 'grid';

	/**
	 * Extend base props
	 */
	public static function get_default_props()
	{
		$props = parent::get_default_props();

		return array_replace($props, [
			'columns'        => 1,
			'style'          => 'lg',
			'media_embed'    => true,
		]);
	}

	public function map_global_props($props)
	{
		$props = array_replace([
			'media_ratio'        => Bunyad::options()->loop_large_media_ratio,
			'media_ratio_custom' => Bunyad::options()->loop_large_media_ratio_custom,
			'excerpts'           => Bunyad::options()->loop_large_excerpts,
			'excerpt_length'     => Bunyad::options()->loop_large_excerpt_length,
			'read_more'          => Bunyad::options()->loop_large_read_more,
		], $props);

		$props = parent::map_global_props($props);

		return $props;
	}
	
	/**
	 * @inheritDoc
	 */
	public function infer_image_sizes() 
	{
		$column_width = $this->get_relative_width();
		$image = 'bunyad-main';

		if ($column_width > 66) {
			$image = 'bunyad-main-full';
			// Scale by dividing original width of bunyad-main-featured (66%).
			// $this->props['image_props']['scale'] = $column_width / 66;
		}

		$this->props['image'] = $image;
	}

}