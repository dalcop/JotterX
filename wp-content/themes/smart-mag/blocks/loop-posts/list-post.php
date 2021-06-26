<?php

namespace Bunyad\Blocks\LoopPosts;

/**
 * Overlay Loop Post Class
 */
class ListPost extends BasePost
{
	public $id = 'list';

	public function _pre_render()
	{
		// Vertically centered content.
		if ($this->props['content_vcenter']) {
			$this->props['class_wrap_add'] = join(' ', [
				$this->props['class_wrap_add'],
				'list-post-v-center'
			]);
		}

		parent::_pre_render();
	}
}