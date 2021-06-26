<?php
/**
 * @var array $options Provided by the Bunyad_Admin_Meta_Terms::edit_form() method.
 * @var string $context 'add' or 'edit' screen.
 */

// Don't pollute the add screen - these are mostly legacy options anyways.
if ($context !== 'edit') {
	return;
}

?>

<?php foreach ($options as $element): ?>

	<?php if ($context === 'edit'): ?>
		<tr class="form-field bunyad-meta bunyad-meta-term <?php echo esc_attr($element['name']); ?>">
			<th scope="row" valign="top">
				<label for="<?php echo esc_attr($element['name']); ?>">
					<?php echo esc_html($element['label']); ?>
				</label>
			</th>
			<td>
				<?php echo $this->render($element); // Bunyad_Admin_OptionRenderer::render(); ?>

				<?php if (!empty($element['desc'])): ?>
					<p class="description custom-meta">
						<?php echo esc_html($element['desc']); ?>
					</p>
				<?php endif; ?>
			</td>
		</tr>
	<?php else: ?>
		<div class="form-field bunyad-meta bunyad-meta-term <?php echo esc_attr($element['name']); ?>">
			<label for="<?php echo esc_attr($element['name']); ?>">
				<?php echo esc_html($element['label']); ?>
			</label>

			<?php echo $this->render($element); // Bunyad_Admin_OptionRenderer::render(); ?>

			<?php if (!empty($element['desc'])): ?>
				<p class="description custom-meta">
					<?php echo esc_html($element['desc']); ?>
				</p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php endforeach; ?>

<script>
/**
 * Conditional show/hide 
 */
jQuery(function($) {
	$('._bunyad_slider select').on('change', function() {

		var depend_default = '._bunyad_slider_tags, ._bunyad_slider_type, ._bunyad_slider_posts, ._bunyad_slider_number';

		// hide all dependents
		$(depend_default).hide();
		
		if (!['none', ''].includes($(this).val())) {
			$(depend_default).show();
		}

		return;
	});

	// On load.
	$('._bunyad_slider select').trigger('change');
		
});
</script>