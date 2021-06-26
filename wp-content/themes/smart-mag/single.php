<?php 
/**
 * The single post template is selected based on your global Theem Settings or the post 
 * setting. 
 * 
 * Template files for the post layouts are as follows:
 * 
 * Classic: Uses content.php
 * Post Cover: partials/single/layout-cover.php
 * Modern: partials/single/layout-modern.php
 */

$template        = Bunyad::posts()->meta('layout_template');
$spacious_style  = Bunyad::posts()->meta('layout_spacious');
$post_classes    = [
	'the-post',
	$template ? 's-post-' . $template : ''
];

// Spacious style at full width.
if ($spacious_style && Bunyad::core()->get_sidebar() === 'none') {
	$post_classes[] = 'the-post-modern';
	// Bunyad::core()->add_body_class('has-spacious-full');
}

// Legacy: No longer with -b.
if ($template === 'modern-b') {
	$template = 'modern';
}
else if (!$template || strpos($template, 'classic') !== false) {
	$template = 'classic';
	$partial  = 'content';
}

if (empty($partial)) {
	$partial  = 'partials/single/layout-' . $template;
}

Bunyad::core()->add_body_class('post-layout-' . $template);

// Something is wrong.
if (!have_posts()) { 
	return;
}
?>

<?php get_header(); ?>
<?php Bunyad::blocks()->load('Breadcrumbs')->render(); ?>

<?php the_post(); // Setup the post data. ?>

<div <?php Bunyad::markup()->attribs('main'); ?>>

	<?php if (!in_array($template, ['classic'])):  ?>
		<?php
			Bunyad::core()->partial($partial, ['post_classes' => $post_classes]);
		?>
	
	<?php else: // Only for classic template, below. ?>
	
		<div class="ts-row">
			<div class="col-8 main-content">		
				<div <?php Bunyad::markup()->attribs('the-post-wrap', ['class' => $post_classes]); ?>>

					<?php get_template_part($partial, 'single'); ?>
						
					<div class="comments">
						<?php comments_template('', true); ?>
					</div>
		
				</div>
			</div>
			
			<?php Bunyad::core()->theme_sidebar(); ?>
		
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>