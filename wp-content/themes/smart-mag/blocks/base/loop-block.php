<?php
namespace Bunyad\Blocks\Base;

use \Bunyad;
use \WP_Query;

/**
 * Base Blocks Class for Loops type blocks - should be extended for other blocks
 * 
 * Note: This is not an abstract class and may be used standalone. More of template method.
 */
class LoopBlock extends Block
{
	/**
	 * @var string Block type
	 */
	public $type = 'loop';

	/**
	 * @var boolean Is the block processed yet
	 */
	public $processed = false;

	/**
	 * @var array Internal data, extended by data retrieved from Query::setup()
	 */
	public $data = [
		'unique_id' => null
	];

	/**
	 * @var \WP_Query
	 */
	public $query;

	/**
	 * @var string ID for the view file. Defaults to $this->id.
	 */
	public $view_id;

	/**
	 * @param array $props
	 */
	public function __construct($props = [])
	{
		parent::__construct($props);
		
		// Resolve aliases
		$this->props = $this->resolve_aliases($this->props);

		// Setup enqueues if any
		add_action('wp_enqueue_scripts', [$this, 'register_assets']);
	}

	/**
	 * Get props related to query.
	 *
	 * @return array
	 */
	public static function get_query_props()
	{
		$query_props = [
			'posts'        => 4,
			'offset'       => '',

			// Sticky posts generally only enabled for home/blog archives.
			'sticky_posts' => false,

			// Internal for section queries, and passed 'query' objects.
			// Different from offset: These posts are manually skipped in the loop.
			'skip_posts'   => 0,

			// Main category
			'cat'          => '',

			// Tag slugs - separated by commas. Not in 'terms' to allow limit by tags AND cats.
			'tags'         => [],

			// Categories, or custom taxonomies' term ids, or author ids.
			'terms'        => [],

			// Limit to a specific custom taxonomy
			'taxonomy'     => '',

			// Custom taxonomy IDs to use
			'tax_ids'      => [],
			'sort_order'   => '',
			'sort_by'      => '',

			// Only for JetPack views sort.
			'sort_days'    => 30,
			'post_formats' => [],

			// Multiple supported only for legacy compat. Recommended: Single value.
			'post_type'    => '',

			// Specific post IDs
			'post_ids'     => [],

			// Skip posts by ids.
			// Special: Also supported for main query.
			'exclude_ids'  => [],

			'pagination'      => '',
			'pagination_type' => 'numbers-ajax',
			'load_more_style' => '',

			// Only show review posts if enabled.
			'reviews_only'    => false,
		];

		return $query_props;
	}

	/**
	 * Default properties for the block.
	 * 
	 * @param string $type Type of props to return.
	 * @return array
	 */
	public static function get_default_props()
	{
		// Config props (not for sc)
		$props = [

			// Expected: 
			//  null|empty: Use global $wp_query or legacy $bunyad_loop, ignores all query props
			//  'custom':   Create create based on provided props.
			//  'section':  Use section query. Data must be provided in section_query.
			'query_type'      => '',

			// Forces to use the specified query.
			'query'           => null,

			// WP_Query|array Section query data.
			'section_query'   => [],

			// Whether is it called via a shortcode / builder - adds .block-sc to wrap
			'is_sc_call'      => false,

			// Style Variation for the block.
			'style'         => '',

			// Dark or normal.
			'scheme'        => '',

			// Many blocks support columns setting.
			'columns'        => '',
			'columns_main'   => '',
			'columns_medium' => '',
			'columns_small'  => '',

			'heading'           => '',
			'heading_type'      => '',
			'heading_align'     => 'left',
			'heading_link'      => '',
			'heading_more_text' => '',
			'heading_more_link' => '',
			'heading_colors'    => '',
			'heading_tag'       => 'h4',

			// Values: category, tag, or taxonomy - if empty, defaults to category 
			'filters'       => false,
			'filters_terms' => [],
			'filters_tags'  => [],

			// When using custom taxonomy
			'filters_tax'   => '',

			// Current filter to apply.
			'filter'        => '',

			// Loop specific props
			'excerpts'           => true,
			'excerpt_length'     => 0,
			'cat_labels'         => '',
			'cat_labels_pos'     => '',
			'read_more'          => '',
			'reviews'            => '',
			'show_post_formats'  => true,
			'post_formats_pos'   => '',
			'show_content'       => true,
			'content_center'     => false,

			// When empty, automatically inferred based on columns.
			'show_media'         => true,
			'force_image'        => '',
			'media_ratio'        => '',
			'media_ratio_custom' => '',

			// Only for some blocks: list, small.
			'media_width'        => '',

			// Define a parent container to get relative width from.
			'container_width' => '',

			'separators'      => false,

			// Margin below block
			'space_below'     => '',
			'column_gap'      => '',

			'meta_items_default' => true,
			'meta_above'         => [],
			'meta_below'         => [],
			'show_title'         => true,
			'title_tag'          => 'h2',
			'title_lines'        => '',

			// These meta items should not get a default value as global settings are important.
			'meta_align'         => '',
			'meta_cat_style'     => 'text',
			'meta_author_img'    => false,

			// Legacy Aliases (DEPRECATED)
			'link'         => ['alias' => 'heading_link'],
			'post_format'  => ['alias' => 'post_formats'],
			'title'        => ['alias' => 'heading'],
			'cats'         => ['alias' => 'terms'],
		];

		$props = $props + static::get_query_props();

		return $props;
	}

	/**
	 * Add in some values from global options.
	 */
	public function map_global_props($props)
	{
		$global = [
			'cat_labels'        => Bunyad::options()->get('cat_labels'),
			'cat_labels_pos'    => Bunyad::options()->get('cat_labels_pos'),
			'reviews'           => Bunyad::options()->get('loops_reviews'),
			'post_formats_pos'  => Bunyad::options()->get('post_formats_pos'),
			'load_more_style'   => Bunyad::options()->get('load_more_style'),
		];

		// Only set this default for listings/internal calls. Blocks/SC do not use the global
		// setting for these.
		if (empty($props['is_sc_call'])) {
			$global += [
				'show_post_formats' => Bunyad::options()->get('post_format_icons'),
			];
		}

		// Setting it as it will be frequently used by inheritance too.
		$props['meta_items_default'] = !isset($props['meta_items_default']) || $props['meta_items_default'];

		// If not known or explicitly set to default, global meta should be used.
		if ($props['meta_items_default']) {
			$global += [
				'meta_above'  => Bunyad::options()->get('post_meta_above'),
				'meta_below'  => Bunyad::options()->get('post_meta_below'),
			];
		}

		return array_replace($global, $props);
	}

	/**
	 * @inheritDoc 
	 */
	public function init()
	{
		// Setup internal props. These are not set from external call.
		$this->props += [
			'image'        => '',
			'image_props'  => [],
			'class_grid'   => ['grid'],

			// Not all support it yet.
			'class'        => [],

			// Loop wrapper div attributes. Some loops use it, not all.
			'wrap_attrs'   => [],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function setup_props(array $props) 
	{
		$props = parent::setup_props($props);

		if (isset($props['columns_main'])) {
			$props['columns'] = $props['columns_main'];
		}

		// Clean up section_query props by only using valid.
		if (isset($props['section_query'])) {
			$props['section_query'] = array_intersect_key(
				$props['section_query'],
				$this->get_query_props()
			);
		}

		return $props;
	}

	/**
	 * Set the block identifier
	 * 
	 * @return $this
	 */
	public function set_id($id) 
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * Set a single property - sets on $this->props[] array
	 * 
	 * @return $this
	 */
	public function set($key, $value) 
	{
		$this->props[$key] = $value;
		return $this;
	}

	/**
	 * Get all props.
	 * 
	 * @see $this::get_default_props()
	 * @return array
	 */
	public function get_props($original = false)
	{
		if ($original) {
			return $this->orig_props;
		}

		return $this->props;
	}

	/**
	 * Setup aliases for provided props.
	 */
	public function resolve_aliases($props)
	{
		$default = $this->get_default_props();

		foreach ($default as $key => $prop) {

			// Is not an alias? Skip
			if (!is_array($prop) OR !array_key_exists('alias', $prop)) {
				continue;
			}
			
			// Alias used here
			if (array_key_exists($key, $props)) {

				// A stray config prop, remove it
				if (!empty($props[$key]['alias'])) {

					unset($props[$key]);
					continue;
				}

				// Example: 'terms' set from $props['cats']
				$props[ $prop['alias'] ] = $props[$key];
			}
		}

		return $props;
	}

	/**
	 * Any assets to register for this block.
	 */
	public function register_assets() {}

	/**
	 * Process and setup query.
	 * 
	 * @uses \Bunyad\Blocks\Base\Query
	 */
	public function process()
	{
		$this->create_unique_id();

		// Currently applying a filter. Query type can only be custom.
		if ($this->props['filter']) {
			$this->props = array_replace($this->props, [
				'query'      => '',
				'query_type' => 'custom'
			]);
		}

		/**
		 * Determine current page based on main query or provided paged param in AJAX.
		 * Only done if pagination is enabled.
		 */
		if ($this->props['pagination']) {
			$page = (get_query_var('paged') ? get_query_var('paged') : get_query_var('page'));
			if (empty($page) && isset($_REQUEST['paged'])) {
				$this->props['page'] = intval($_REQUEST['paged']);
			}
			else {
				$this->props['page'] = intval($page);
			}
		}

		/**
		 * Query type: Global or a custom defined.
		 */
        if ($this->props['query'] instanceof WP_Query) {

			// Clone to prevent modification on original query object.
			// As it may be re-used again, modifications such as post_count below would
			// affect the object passed by ref.
			$this->query = clone $this->props['query'];

			/**
			 * Change post_count to limit to post number specified.
			 * 
			 * Required for blocks that call another block and use same query, like 
			 * news focus and highlights.
			 */
			$query = $this->query;
			
			if ($query->post_count > $this->props['posts']) {
				$query->post_count = $this->props['posts'];
			}

			// Just sets the internal pointer to skip over some posts.
			if ($this->props['skip_posts']) {
				$query->current_post = $this->props['skip_posts'] - 1;
			}

			$this->query = $query;
		}
		else {

            switch ($this->props['query_type']) {
                case 'custom':
                    // Setup the block query
                    $query = new Query($this->props, $this);
                    $this->data = array_merge($this->data, $query->setup());

                    $this->query = $this->data['query'];
                    unset($this->data['query']);

					break;
					
				case 'section':

					$query = $this->props['section_query'];
                    if (!is_object($query)) {
						$query_props = array_replace(
							$this->props,
							(array) $this->props['section_query']
						);

						// Add posts limit.
						$query_props = array_replace($query_props, [
							'posts'  => $this->props['posts'],
						]);

                        $query = new Query($query_props);
					}
					
					$this->data  = array_merge($this->data, $query->setup());
					$this->query = $this->data['query'];

					break;

                default:
                	// Note: Block data such as title, link, main_term is not available
					$this->query = !empty($GLOBALS['bunyad_loop']) ? $GLOBALS['bunyad_loop'] : $GLOBALS['wp_query'];

					// Exclude IDs can also be used on main query.
					if ($this->props['exclude_ids']) {
						$vars = &$this->query->query_vars;

						$vars['post__not_in'] = array_merge(
							isset($vars['post__not_in']) ? (array) $vars['post__not_in'] : [],
							$this->props['exclude_ids']
						);

						// Re-execute the global query.
						$this->query->query($vars);
					}

					break;
            }
		}
		
		// // Limit post count.
		// if ($this->props['posts']) {
		// 	echo 'setting - ' . $this->props['posts'];
		// 	$this->query->posts_count = intval($this->props['posts']);
		// }

		// Flag to mark processed
		$this->processed = true;
	}

	/**
	 * Render the partial view for this loop.
	 * 
	 * @uses \Bunyad_Core::partial()
	 */
	public function render($options = array())
	{
		$options = wp_parse_args($options, array(
			'block_markup' => true
		));

		/**
		 * Run an action before rendering the loop block.
		 * 
		 * @param self $this
		 */
		do_action('bunyad_blocks_loop_render', $this);

		$this->_pre_render();
		$this->setup_media_ratio();
		$this->infer_image_sizes();

		/**
		 * Filter block image before.
		 * 
		 * @param string $image Current image.
		 * @param string $id    Block id.
		 */
		$this->props['image'] = apply_filters('bunyad_blocks_loop_image', $this->props['image'], $this->id);

		if (!$this->processed) {
			$this->process();
		}

		// Render with or without block markup
		($options['block_markup'] ? $this->render_block_markup() : $this->render_view());

		// Restore post data as views will override it.
		wp_reset_postdata();

		/**
		 * Run an action after rendering the loop block.
		 * 
		 * @param self $this
		 */
		do_action('bunyad_blocks_loop_render_after', $this);
	}

	/**
	 * Checks to perform and settings to do prior to render
	 */
	public function _pre_render() {}

	/**
	 * Render the view file for this block - usually a loop
	 */
	public function render_view()
	{
		$view_id = $this->view_id ? $this->view_id : $this->id;

		Bunyad::core()->partial(
			'blocks/loops/' . $view_id . '/html/' . $view_id,
			[
				'block' => $this,
				'query' => $this->query
			]
		);
	}

	/**
	 * Output common block markup and render the specific view file.
	 * 
	 * Note: Do not call directly, use render() instead.
	 * 
	 * @uses self::render_view()
	 */
	public function render_block_markup()
	{
		$classes = [
			'block-wrap', 
			'block-' . $this->id, 
			$this->props['is_sc_call'] ? 'block-sc' : '',

			// Preset column gaps.
			$this->props['column_gap'] ? 'cols-gap-' . $this->props['column_gap'] : '',

			// Dark scheme class if active.
			$this->props['scheme'] === 'dark' ? 's-dark' : '',

			// Margins below class.
			$this->props['space_below'] ? 'mb-' . $this->props['space_below'] : '',
		];

		$attribs = [
			'class'   => $classes, 
			'data-id' => $this->data['unique_id']
		];

		/**
		 * Add block query data for dynamic pagination or blocks with filters.
		 */
		$ajax_pagination = in_array(
			$this->props['pagination_type'], 
			['load-more', 'numbers-ajax', 'infinite']
		);
		
		if ($this->props['filters'] || ($this->props['pagination'] && $ajax_pagination)) {
			$block_data = [
				'id'    => $this->id,
				'props' => $this->orig_props,
			];

			// Archive, or other main query?
			if (!in_array($this->props['query_type'], ['custom', 'section'])) {

				$term_data  = $this->query->get_queried_object();
				$block_data['props'] += [
					'post_type'    => $this->query->get('post_type'),
					'posts'        => $this->query->get('posts_per_page'),
					'sticky_posts' => !$this->query->get('ignore_sticky_posts'),
					'taxonomy'     => $term_data->taxonomy,
					'terms'        => $term_data->term_id,
				];
			}
			
			$attribs['data-block'] =  json_encode($block_data);
		}

		?>
		<section <?php 
			Bunyad::markup()->attribs(
				$this->id .'-block', 
				$attribs
			); ?>>

			<?php $this->the_heading(); ?>
	
			<div class="block-content">
				<?php $this->render_view(); ?>
			</div>

		</section>
		<?php
	}

	/**
	 * Created unique ID for the block
	 */
	protected function create_unique_id()
	{
		Bunyad::registry()->block_count++;
		$this->data['unique_id'] = Bunyad::registry()->block_count;
	}

	/**
	 * Output block heading markup
	 */
	public function the_heading()
	{
		// Custom heading HTML set progrmmatically (not via prop), use this instead.
		if (!empty($this->data['heading_custom'])) {
			echo $this->data['heading_custom']; // phpcs:ignore WordPress.Security.EscapeOutput Only settable internally programmatically. 
			return;
		}

		// This check is also performed in Heading block. Done here to save resources.
		if (empty($this->data['heading']) || $this->props['heading_type'] === 'none') {
			return;
		}

		Bunyad::blocks()->load(
			'Heading',
			[
				'heading'       => $this->data['heading'],
				'align'         => $this->props['heading_align'],
				'type'          => $this->props['heading_type'],
				'link'          => $this->props['heading_link'] ? $this->props['heading_link'] : $this->data['term_link'],
				'term'          => $this->data['term'],
				'filters'       => $this->data['display_filters'],
				'more_text'     => $this->props['heading_more_text'],
				'more_link'     => $this->props['heading_more_link'] ? $this->props['heading_more_link'] : $this->data['term_link'],
				'accent_colors' => $this->props['heading_colors'],
				'html_tag'      => $this->props['heading_tag'],
			]
		)
		->render();
	}

	/**
	 * Load a loop post class
	 * 
	 * Example: Load the loop class from inc/loop-posts/grid.php if it exists 
	 * or fallback to inc/loop-posts/base.php
	 * 
	 * @uses \Bunyad\Blocks\Helpers::load_post()
	 * 
	 * @param string $id     Loop post id
	 * @param array  $props  Props to set for loop post
	 *
	 * @return \Bunyad\Blocks\LoopPosts\BasePost
	 */
	public function loop_post($id, $props = array()) 
	{
		$props = array_replace($this->get_props(), $props);

		// Load post
		$post = Bunyad::blocks()->load_post($id, $props);
		$post->block = $this;

		return $post;
	}

	/**
	 * Get relative width for current block, based on parent column width in 
	 * relation to the whole page.
	 * 
	 * @return float Column width in percent number, example 66
	 */
	public function get_relative_width()
	{
		// Container defined in props, force it
		if (!empty($this->props['container_width'])) {
			return floatval($this->props['container_width']);
		}

		return Bunyad::blocks()->get_relative_width();
	}

	/**
	 * Set columns size based on provided columns.
	 *
	 * @param array $args Configs for columns of devices.
	 * @return void
	 */
	protected function setup_columns($args = []) 
	{
		if (empty($this->props['columns'])) {
			$this->props['columns'] = 1;
		}

		// Add the grid columns class.
		$this->props['class_grid'][] = 'grid-' . $this->props['columns'];

		$col_types = [
			'md' => 'medium', 
			'sm' => 'small', 
			'xs' => 'xsmall'
		];

		/**
		 * Add responsive column classes based on props of type columns_medium etc.
		 * OR, override via args provided.
		 */
		foreach ($col_types as $key => $columns) {

			$cols = null;
			if (!empty($this->props[ 'columns_' . $columns ])) {
				$cols = $this->props[ 'columns_' . $columns ];
			}
			else if (!empty($args[ $columns ])) {
				$cols = $args[ $columns ];
			}

			if ($cols) {
				array_push(
					$this->props['class_grid'], 
					"{$key}:grid-{$cols}"
				);
			}
		}

		 // 1/3 * 12 to get col-4
		 $column = (1 / absint($this->props['columns']) * 12);
		 $this->props['col_class'] = 'col-' . str_replace('.', '-', $column);
	}

	/**
	 * Setup media ratio if provided.
	 */
	public function setup_media_ratio()
	{
		if (empty($this->props['media_ratio'])) {
			return;
		}

		$ratio = $this->props['media_ratio'];
		if ($ratio === 'custom' && !empty($this->props['media_ratio_custom'])) {
			$ratio = $this->props['media_ratio_custom'];
		}

		$this->props['media_ratio'] = $ratio;
	}

	/**
	 * Decide the image to use for this block
	 */
	public function infer_image_sizes()
	{
		// If an image is forced, don't bother setting it
		if (!empty($this->props['image'])) {
			return;
		}

		$this->props['image'] = 'bunyad-thumb';
	}
	

	/**
	 * Render pagination for current block
	 * 
	 * @uses \Bunyad_Core::partial()
	 * @param array $props
	 */
	public function the_pagination($props = [])
	{
		if (!$this->props['pagination']) {
			return;
		}

		$props = array_merge(
			[
				'query'           => $this->query,
				'page'            => $this->props['page'],
				'pagination'      => $this->props['pagination'],
				'pagination_type' => $this->props['pagination_type'],
				'load_more_style' => $this->props['load_more_style'],
			],
			$props
		);

		Bunyad::core()->partial('partials/pagination', $props);
	}

}