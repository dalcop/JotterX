<?php 
/**
 * Partial Template for Single Post "Modern Layout" - called from single.php
 */
$props = array_replace(
	[
		'layout'         => 'modern-a',
		'header_outer'   => false,
		'centered'       => false,
		'cat_style'      => 'labels',
		'post_classes'   => [],
		'has_large_bot'  => false,
		'social_top_style' => 'a'
	],
	isset($props) ? $props : []
);
?>

<?php if ($props['header_outer']): ?>
	<?php Bunyad::core()->partial('partials/single/modern-header', $props); ?>
<?php endif; ?>

<div class="ts-row<?php echo esc_attr($props['has_large_bot'] ? ' has-s-large-bot' : ''); ?>">
	<div class="col-8 main-content">

		<?php if (!$props['header_outer']): ?>
			<?php Bunyad::core()->partial('partials/single/modern-header', $props); ?>
		<?php endif; ?>

		<div class="single-featured">
			<?php 
				Bunyad::core()->partial('partials/single/featured'); 
			?>
		</div>

		<div <?php Bunyad::markup()->attribs('the-post-wrap', [
			'class' => $props['post_classes']
		]); ?>>

			<article id="post-<?php the_ID(); ?>" class="<?php echo esc_attr(join(' ', get_post_class())); ?>">
				<?php 
					// Get post body content.
					get_template_part('partials/single/post-content'); 
				?>
			</article>

			<?php Bunyad::core()->partial('partials/single/post-footer'); ?>
			
			<div class="comments">
				<?php comments_template('', true); ?>
			</div>

		</div>
	</div>
	
	<?php Bunyad::core()->theme_sidebar(); ?>
</div>