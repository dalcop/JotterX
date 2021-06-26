<?php 
/**
 * Meta box for post reviews.
 * 
 * @var Bunyad_Admin_MetaRenderer $this
 */

include trailingslashit(__DIR__) . 'options.php';
$options = $this->options($options);

$this->default_values['_bunyad_review_overall'] = (
	isset($this->default_values['_bunyad_review_overall']) 
		? $this->default_values['_bunyad_review_overall'] 
		: ''
);

if (!isset($this->default_values['_bunyad_review_percent'])) {
	$this->default_values['_bunyad_review_percent'] = '';
}

$review_scale = intval(Bunyad::options()->review_scale);
$saved_data   = json_encode(Bunyad::reviews()->get_criteria());

?>

<div class="bunyad-meta bunyad-review cf">
<input type="hidden" name="bunyad_meta_box[]" value="<?php echo esc_attr($box_id); ?>" />

	<input type="hidden" name="_bunyad_review_percent" value="<?php echo esc_attr($this->default_values['_bunyad_review_percent']); ?>" size="3" />

<?php foreach ($options as $element): ?>
	
	<div class="option <?php echo esc_attr($element['name']); ?>">
		<span class="label"><?php echo esc_html($element['label']); ?></span>
		<span class="field">
			<?php echo $this->render($element); ?>

			<?php if (!empty($element['desc'])): ?>
			
			<p class="description"><?php echo esc_html($element['desc']); ?></p>
		
			<?php endif;?>
		</span>
	</div>
	
<?php endforeach; ?>

	<div class="option">
		<span class="label"><?php esc_html_e('Criteria', 'bunyad-admin'); ?></span>
		<div class="field criteria">
		
			<p><input type="button" class="button add-more" value="<?php esc_attr_e('Add More Criteria', 'bunyad-admin'); ?>" /></p>
			<p><?php esc_html_e('Overall rating auto-calculated:', 'bunyad-admin'); ?> <strong>
				<input type="text" name="_bunyad_review_overall" value="<?php echo esc_attr($this->default_values['_bunyad_review_overall']); ?>" size="3" />
				</strong></p>
				
			<div class="fields"></div>
		</div>
	</div>

</div>

<script type="text/html" class="bunyad-review-tpl-criteria">
	<div class="criterion">
		<span class="delete dashicons dashicons-dismiss"></span>

		<strong><?php esc_html_e('Criterion', 'bunyad-admin'); ?></strong> &mdash; 
		<?php esc_html_e('Label:', 'bunyad-admin'); ?> <input type="text" name="_bunyad_criteria_label_%number%" />
		<?php esc_html_e('Rating:', 'bunyad-admin'); ?>  <input type="text" name="_bunyad_criteria_rating_%number%" size="3" /> / <?php echo $review_scale; ?>
	</div>
</script>

<script>
jQuery(function($) {
	"use strict";
	
	var add_more = function(e, number) {

		// current count
		var tabs_count = $(this).parent().data('bunyad_tabs') || 0;
		tabs_count++;

		// get our template and modify it
		var html = $('.bunyad-review-tpl-criteria').html();
		html = html.replace(/%number%/g, number || tabs_count);
		
		$('.bunyad-review .criteria .fields').append(html);

		// update counter
		$(this).parent().data('bunyad_tabs', tabs_count);

		return false;
	};

	//$('.criteria .fields').sortable();

	var overall_rating = function() {
		var count = 0, total = 0, number = null; 
		$('.bunyad-review input[name*="criteria_rating"]').each(function() {

			number = parseFloat($(this).val());

			if (!isNaN(number)) {
				total += number;
				count++;
			}
		});

		var rating = (total/count).toFixed(1);
		$('.bunyad-review .overall-rating').html(rating);
		$('.bunyad-review input[name="_bunyad_review_overall"]').val(rating);
		$('.bunyad-review input[name="_bunyad_review_percent"]').val(Math.round(rating / <?php echo $review_scale; ?> * 100));
		
	};
	
	$('.bunyad-review .criteria .add-more').on('click', add_more);

	$('.bunyad-review .criteria').on('click', '.delete', function() {
		$(this).parents('.criterion').remove();
	});

	$('.bunyad-review .criteria').on('blur', 'input[name*="criteria_rating"]', function() {
		if ($(this).val() > <?php echo $review_scale; ?>) {
			alert("<?php printf(esc_attr__('Rating cannot be greater than %d.', 'bunyad-admin'), $review_scale); ?>");
			$(this).val(<?php echo $review_scale; ?>);
		}

		overall_rating();
	});

	// Add existing
	var saved = <?php echo $saved_data; ?>;

	if (saved.length) { 
		$.each(saved, function(i, val) {
			add_more.call($('.bunyad-review .criteria .add-more'), val.number);
			$('[name=_bunyad_criteria_label_' + val.number + ']').val(val.label);
			$('[name=_bunyad_criteria_rating_' + val.number + ']').val(val.rating);
		});

		overall_rating();
	}
	else {
		$('.criteria .add-more').trigger('click');
	}

	/**
	 * Conditional show/hide
	 */
	$('[name=_bunyad_review_schema]').on('change', function() {

		var current = $(this).val();
		const depends = [
			'item_author',
			'item_author_type',
			'item_link',
			'item_name',
		];

		const selector = depends.map(item => '._bunyad_review_' + item).join(',');
		current === 'none' ? $(selector).hide() : $(selector).show();

		return;
	})
	.trigger('change');


	/**
	 * Show / hide all options.
	 */
	const handleShow = function() {
		const checked = $(this).is(':checked');
		const elements = $(this).closest('.bunyad-review').find('.option:not(._bunyad_reviews');

		checked ? elements.show() : elements.hide();
		return;
	}

	const element = $('[name=_bunyad_reviews]');
	element.on('click', handleShow)
	handleShow.call(element);
		
	
});
</script>