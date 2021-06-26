<?php

namespace Bunyad\Elementor;

/**
 * The base loop widget.
 */
class LoopWidget extends BaseWidget
{
	protected function _process_settings()
	{
		$settings = parent::_process_settings();
		
		// Default to custom query.
		if (!isset($settings['query_type'])) {
			$settings['query_type'] = 'custom';
		}

		// Section query if section_data available. Checking for query_type as section_query data
		// is only needed when the section query is used.
		if (isset($settings['section_data']) && $settings['query_type'] === 'section') {
			$settings['section_query'] = $settings['section_data'];
		}

		return $settings;
	}
}