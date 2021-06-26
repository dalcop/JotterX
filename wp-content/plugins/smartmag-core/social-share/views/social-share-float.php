<?php
/**
 * Plugin Template: for Alternate Social share buttons on single page
 * 
 * See: inc/social-share.php for filters and caller.
 */

if (!is_single()) {
	return;
}

$props = array_replace([
	// 'active' => ['facebook', 'twitter', 'pinterest', 'email'],
	'active' => Bunyad::options()->share_float_services,
	'style'  => Bunyad::options()->share_float_style ? Bunyad::options()->share_float_style : 'a',
	'text'   => Bunyad::options()->get_or(
		'share_float_text',
		esc_html__('Share', 'bunyad')
	),
	'label' => Bunyad::options()->share_float_label,
], $props);

// Post and media URL
$services = Bunyad::get('smartmag_social')->share_services();

if (strstr($services['pinterest']['icon'], 'tsi')) {
	$services['pinterest']['icon'] = 'tsi tsi-pinterest-p';
}

$classes = [
	'post-share-float',
	'share-float-' . $props['style'],
	'is-hidden'
];

if (in_array($props['style'], ['c', 'd'])) {
	$classes[] = 'spc-social-bg';
}
else {
	$classes[] = 'spc-social-c-icon';
}

?>
<div class="<?php echo esc_attr(join(' ', $classes)); ?>">
	<div class="inner">
		<?php if ($props['label'] && $props['text']): ?>
			<span class="share-text"><?php echo esc_html($props['text']); ?></span>
		<?php endif; ?>

		<div class="services">
		
		<?php 
			foreach ((array) $props['active'] as $key): 

				if (!isset($services[$key])) {
					continue;
				}

				$service = $services[$key];
		?>
		
			<a href="<?php echo $service['url']; ?>" class="cf service s-<?php echo esc_attr($key); ?>" target="_blank" title="<?php echo esc_attr($service['label'])?>">
				<i class="<?php echo esc_attr($service['icon']); ?>"></i>
				<span class="label"><?php echo esc_html($service['label']); ?></span>
			</a>
				
		<?php endforeach; ?>
		
		</div>
	</div>		
</div>
