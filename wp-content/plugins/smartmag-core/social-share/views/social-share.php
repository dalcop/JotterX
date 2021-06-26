<?php
/**
 * Partial template for social share buttons on single page.
 * 
 * See: inc/social-share.php for filters and caller.
 */

$props = array_replace([
	'active' => [
		'facebook', 'twitter', 'pinterest', 'linkedin', 'tumblr', 'email'
	]
], $props);

$services = Bunyad::get('smartmag_social')->share_services();

if (!$props['active']) {
	return;
}

?>

<?php if ((is_single() OR Bunyad::options()->social_icons_classic) && Bunyad::options()->single_share_bot): ?>
	
	<div class="post-share-bot">
		<span class="info"><?php esc_html_e('Share.', 'bunyad'); ?></span>
		
		<span class="share-links spc-social-bg">

			<?php 
				foreach ($props['active'] as $key): 
					$service = $services[$key];
			?>

				<a href="<?php echo esc_url($service['url']); ?>" class="service s-<?php echo esc_attr($key); ?> <?php echo esc_attr($service['icon']); ?>" 
					title="<?php echo esc_attr($service['label_full']); ?>" target="_blank" rel="noopener">
					<span class="visuallyhidden"><?php echo esc_html($service['label']); ?></span>
				</a>
					
			<?php endforeach; ?>

		</span>
	</div>
	
<?php endif; ?>
