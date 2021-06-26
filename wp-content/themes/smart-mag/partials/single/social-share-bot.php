<?php
// Bottom social share.
if (
	(is_single() || Bunyad::options()->social_icons_classic) 
	&& Bunyad::options()->single_share_bot
	&& class_exists('SmartMag_Core')
) {
	// See plugins/smartmag-core/social-share/views/social-share.php
	Bunyad::get('smartmag_social')->render(
		'social-share',
		[
			'active' => Bunyad::options()->single_share_bot_services
		]
	);
}