<?php
/**
 * Partial template for social share buttons on single page.
 * 
 * See: inc/social-share.php for filters and caller.
 */

$props = array_replace([
	'active' => [
		'facebook', 'twitter', 'pinterest', 'linkedin', 'tumblr', 'email'
	],
	'style'  => '',
], $props);

$services = Bunyad::get('smartmag_social')->share_services();

if (!$props['active']) {
	return;
}

$classes = [
	'post-share post-share-b',
	'spc-social-bg',
	(Bunyad::amp() && Bunyad::amp()->active() ? ' all' : ''),
];

if ($props['style']) {
	$classes[] = 'post-share-' . $props['style'];
}

$large_buttons = Bunyad::options()->single_share_top_large ?: 3;

?>

<div class="<?php echo esc_attr(join(' ', $classes)); ?>">
	
	<?php 
		$i = 0;
		foreach ($props['active'] as $key): 
			$i++;
			$service  = $services[$key];
			$is_large = 

			$classes = [
				'cf service s-' . $key,
				$i <= $large_buttons ? 'service-lg' : 'service-sm'
			];
	?>
	
		<a href="<?php echo esc_url($service['url']); ?>" class="<?php echo esc_attr(join(' ', $classes)); ?>" 
			title="<?php echo esc_attr($service['label_full']); ?>" target="_blank" rel="noopener">
			<i class="tsi tsi-<?php echo esc_attr($service['icon']); ?>"></i>
			<span class="label"><?php echo esc_html($service['label']); ?></span>
		</a>
			
	<?php endforeach; ?>
	
	<?php if (count($props['active']) > $large_buttons): ?>
		<a href="#" class="show-more" title="<?php esc_attr_e('Show More Social Sharing', 'bunyad'); ?>"><i class="tsi tsi-share"></i></a>
	<?php endif; ?>
	
</div>
