<?php

$class = 'ct-contact-info';

$contact_items = blocksy_default_akg(
	'contact_items',
	$atts,
	[
		[
			'id' => 'address',
			'enabled' => true,
			'title' => __('Address:', 'blc'),
			'content' => 'Street Name, NY 38954',
		],

		[
			'id' => 'phone',
			'enabled' => true,
			'title' => __('Phone:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],

		[
			'id' => 'mobile',
			'enabled' => true,
			'title' => __('Mobile:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],
	]
);

echo blocksy_html_tag(
	'div',
	array_merge([
		'class' => $class,
	], $attr),
	blc_get_contacts_output([
		'data' => $contact_items,
		'link_target' => blocksy_default_akg('link_target', $atts, 'no'),
		'type' => blocksy_akg('contacts_icon_shape', $atts, 'rounded'),
		'fill' => blocksy_akg('contacts_icon_fill_type', $atts, 'outline')
	])
);
