<h2><?php echo __('Instructions', 'blc'); ?></h2>

<p>
	<?php echo __('After installing and activating the WooCommerce Extra extension you will have these features:', 'blc') ?>
</p>

<ol class="ct-modal-list">
	<li>
		<h4><?php echo __('Product Quick View', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and enable or disable it.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ WooCommerce ➝ Product Archives ➝ Card Options ➝ Quick View', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<h4><?php echo __('Floating Cart', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and enable or disable it.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ WooCommerce ➝ Single Product ➝ Floating Cart', 'blc')
				)
			);
		?>
		</i>
	</li>
</ol>