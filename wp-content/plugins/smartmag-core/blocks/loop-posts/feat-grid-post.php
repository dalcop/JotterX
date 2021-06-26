<?php

namespace Bunyad\Blocks\LoopPosts;

/**
 * Grid Loop Post Class
 */
class FeatGridPost extends BasePost
{
	public $id = 'feat-grid';

	/**
	 * Default props for this post
	 * 
	 * @return array
	 */
	public function get_default_props()
	{
		$props = parent::get_default_props();

		return array_replace($props, [
			'show_excerpts' => false,
			'class_wrap'    => 'grid-overlay overlay-post grid-overlay-a',
			'meta_props'    => [
				'add_class' => 'meta-contrast',
			],
			'content_wrap'  => true,
		]);
	}

	/**
	 * @inheritDoc
	 */
	public function _pre_render()
	{
		// Unsupported post format positions.
		if (in_array($this->props['post_formats_pos'], ['bot-left', 'bot-right'])) {
			$this->props['post_formats_pos'] = 'top-right';
		}

		parent::_pre_render();
	}
}