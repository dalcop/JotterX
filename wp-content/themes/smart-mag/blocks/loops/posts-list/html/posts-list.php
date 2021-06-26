<?php 
/**
 * Block view called by a block object
 * 
 * CLASS: blocks/posts-list/posts-list.php
 * 
 * @see Bunyad\Blocks\Base\LoopBlock::get_default_props()
 * @see Bunyad\Blocks\Base\LoopBlock::render()
 * 
 * @var Bunyad\Blocks\Loops\Grid  $block
 */

$props = $block->get_props();

$attribs = [
	'class' => array_merge(
		[
			'loop loop-list', 
			$props['separators'] ? 'loop-sep loop-list-sep' : '',
		],
		$props['class_grid']
	)
];

// Infinite load?
if (Bunyad::options()->pagination_type == 'infinite') {
	$attribs['data-infinite'] = Bunyad::markup()->unique_id('listing-'); 
}

?>
	
	<div <?php Bunyad::markup()->attribs('loop-list', $attribs); ?>>

		<?php while ($query->have_posts()): $query->the_post(); ?>
		
			<?php
				echo $block->loop_post('list');
			?>

		<?php endwhile; ?>

	</div>

	<?php
		// Pagination from partials/pagination.php
		$block->the_pagination();
	?>
	