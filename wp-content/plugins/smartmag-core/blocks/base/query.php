<?php
namespace Bunyad\Blocks\Base;
use \WP_Query;

/**
 * Dynamic Blocks Query Class
 */
class Query
{
	protected $block;
	protected $data  = [];
	protected $props = [];

	/**
	 * @param Bunyad_Blocks_Base $block
	 */
	public function __construct($props = [], $block = null)
	{
		$this->props = $props;
		$this->block = $block;
	}

	/**
	 * Process props and setup the query
	 * 
	 * @return \WP_Query|null
	 */
	public function setup()
	{
		$props = $this->props;

		// Currently applying a filter? Set the correct term/cat.
		if ($props['filter']) {

			unset($props['cat']);

			$taxonomy = 'category';
			if ($props['filters'] === 'tag') {
				$taxonomy = 'post_tag';
			}

			// Only for shortcode yet.
			if ($props['filters_tax']) {
				$taxonomy = $props['filters_tax'];
			}

			$props = array_replace($props, [
				'query_type' => 'custom',
				'terms'      => [$props['filter']],
				'filters'    => false,
				'taxonomy'   => $taxonomy,
			]);
		}

		extract($props, EXTR_SKIP);

		// Have custom query args?
		$query_args = [];
		
		if (!$props['sticky_posts']) {
			$query_args['ignore_sticky_posts'] = 1;
		}

		if (isset($props['query_args']) && is_array($props['query_args'])) {
			$query_args = $props['query_args'];
		}
		
		$query_args = array_merge($query_args, array(
			'posts_per_page' => (!empty($posts) ? intval($posts) : 4), 
			'order'          => ($sort_order == 'asc' ? 'asc' : 'desc'),
			'post_status'    => 'publish',
			'offset'         =>  ($offset ? $offset : '')
		));

		if (!empty($props['skip_posts'])) {
			$query_args['offset'] = intval($query_args['offset']) + intval($props['skip_posts']);
		}
		
		// Add pagination if available.
		if (!empty($props['page'])) {
			$query_args['paged'] = $props['page'];
		}
		
		/**
		 * Sortng criteria
		 */
		switch ($sort_by) {
			case 'modified':
				$query_args['orderby'] = 'modified';
				break;
				
			case 'random':
				$query_args['orderby'] = 'rand';
				break;
	
			case 'comments':
				$query_args['orderby'] = 'comment_count';
				break;
				
			case 'alphabetical':
				$query_args['orderby'] = 'title';
				break;
				
			case 'rating':
				$query_args = array_replace(
					$query_args, 
					[
						'meta_key' => '_bunyad_review_overall', 
						'orderby' => 'meta_value_num'
					]
				);
				break;

			case 'jetpack_views':

				$jetpack_args = $this->get_jetpack_args();
				$query_args   = array_replace($query_args, $jetpack_args);

				break;
		}
		
		/**
		 * Setup aliases for backward compatibility
		 */

		// Main category / taxonomy term object
		$term = '';
		
		// template helper variables
		$term_id   = '';
		$main_term = '';

		// Empty link by default.
		$link      = '';
		$title     = $heading;
			
		/**
		 * Limit by custom taxonomy?
		 */
		if (!empty($taxonomy)) {
	
			$_taxonomy = $taxonomy; // preserve
			
			// get the term
			$term = get_term_by('id', (!empty($cat) ? $cat : current($terms)), $_taxonomy);
			
			// add main cat to terms list
			if (!empty($cat)) {
				array_push($terms, $cat);
			}
			
			$query_args['tax_query'] = array(array(
				'taxonomy' => $_taxonomy,
				'field' => 'id',
				'terms' => (array) $terms
			));
			
			if (empty($title)) {
				$title = $term->slug; 
			}
			
			$link = get_term_link($term, $_taxonomy);
			
		}
		else {
			
			// Terms / cats may have slug strings instead of ids.
			if (!empty($terms)) {
				$slug_terms = $this->get_slug_ids($terms);
				if ($slug_terms) {
					$terms = array_merge($terms, $slug_terms);
				}
			}
			else {
				$terms = array();
			}
		
			/**
			 * Got main category/term? Use it for filter, link, and title
			 */
			if (!empty($cat)) {
				
				// Might be an id or a slug
				$term = $category = is_numeric($cat) ? get_category($cat) : get_category_by_slug($cat);
				
				// Category is always the priority main term
				$main_term = $term;
				
				if (!empty($category)) {
					array_push($terms, $category->term_id);
						
					if (empty($title)) {
						$title = $category->cat_name;
					}
				
					if (empty($link)) {
						$link = get_category_link($category);
					}
				}
			}
			
			/**
			 * Filtering by tag(s)?
			 */
			if (!empty($tags)) {

				$tag_ids    = $tags;

				// Get ids from slugs, if any.
				$slug_terms = $this->get_slug_ids($tags, 'post_tag');
				if ($slug_terms) {
					$tag_ids = array_merge($tag_ids, $slug_terms);
				}

				if ($tag_ids) {
					$query_args['tag__in'] = $tag_ids;
				}

				// Legacy: Get the first tag for main term, assuming it's a slug.
				$tax_tag = current($tags);
				$term = get_term_by('slug', $tax_tag, 'post_tag');

				if ($term) {
					// Use the first tag as main term if a category isn't already the main term
					if (!$main_term) {
						$main_term = $term;
					}
					
					if (empty($title)) {
						$title = $term->slug; 
					}
					
					if (empty($link)) {
						$link = get_term_link($term, 'post_tag');
					}
				}
			}
			
			/**
			 * Multiple categories/terms filter
			 */
			if (count($terms)) {
				$query_args['cat'] = join(',', $terms);
				
				// No category as main and no tag either? Pick first category from multi filter
				if (!$main_term) {
					$main_term = current($terms);
				}
			}
		}

		/**
		 * By specific post IDs?
		 */
		if (!empty($post_ids)) {
			
			$ids = array_map('intval', $post_ids);
			$query_args['post__in'] = $ids;
		}

		/**
		 * Exclude posts IDs.
		 */
		if (!empty($props['exclude_ids'])) {
			$ids = array_map('intval', (array) $props['exclude_ids']);
			$query_args['post__not_in'] = $ids;
		}
		
		/**
		 * Post Formats?
		 */
		if (!empty($post_formats)) {
			
			if (!isset($query_args['tax_query'])) {
				$query_args['tax_query'] = [];
			}

			// Add post format prefix
			$formats = array_map(function($val) {
				return 'post-format-' . trim($val);
			}, $post_formats);
			
			$query_args['tax_query'][] = [
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => (array) $formats,
			];
		}

		/**
		 * Review Posts Only.
		 */
		if (!empty($props['reviews_only'])) {
			$query_args['meta_key'] = '_bunyad_review_overall';
		}
		
		/**
		 * Custom Post Types?
		 * 
		 * Legacy: Supports multiple post types
		 */
		if (!empty($post_type)) {
			$query_args['post_type'] = array_map('trim', explode(',', $post_type));
		}
		
		/**
		 * Execute the query
		 */

		// Add a filter
		$query_args  = apply_filters(
			'bunyad_block_query_args', 
			$query_args, 
			$this->block, 
			$this->props  // redundant but backward compatibility
		);

		$query = new WP_Query($query_args);
	
		// Disable title if empty
		if (empty($title) && is_object($this->block)) {
			$this->block->props['heading_type'] = 'none';
		}
		
		// Setup accessible variables
		$this->data = array_replace($this->data, array(
			'term_link'       => $link,
			'heading'         => $title,
			'query_args'      => $query_args,
			'query'           => $query,
			'term'    	      => $main_term,
			'display_filters' => [],
		));

		// Process filters
		$this->process_filters();

		return $this->data;
	}

	/**
	 * Get term IDs given term slugs of a taxonomy.
	 * 
	 * Note: Numeric slugs will be ignored.
	 * 
	 * @param array $slugs
	 * @param string $taxonomy
	 * @return array
	 */
	protected function get_slug_ids(array $slugs, $taxonomy = 'category')
	{
		$terms      = [];
		$slug_terms = [];

		// Ignore numeric slugs.
		foreach ((array) $slugs as $term) {
			if (!is_numeric($term)) {
				array_push($slug_terms, $term);
			}
		}
		
		// If we have slug terms, get their ids and add.
		if ($slug_terms) {
			$results = get_terms($taxonomy, [
				'slug'         => $slug_terms, 
				'hide_empty'   => false, 
				'hierarchical' => false
			]);

			if ($results) {
				$terms = wp_list_pluck($results, 'term_id');
			}
		}

		return $terms;
	}

	/**
	 * Get query args to fetch posts based on Jetpack Views Counters sort.
	 * 
	 * @uses \stats_get_csv()
	 * @return array Query args to add.
	 */
	public function get_jetpack_args()
	{
		if (!function_exists('\stats_get_csv')) {
			return false;
		}

		/**
		 * Get posts by views from Jetpack stat module (wordpress.com stats)
		 */
		$post_views = \stats_get_csv('postviews', [
			'days'  => absint($this->props['sort_days']),
			'limit' => 100
		]);

		$post_ids   = array_filter(wp_list_pluck((array) $post_views, 'post_id'));
		$query_args = [];

		// No posts found to be sorted by views.
		if (!$post_ids || !count($post_ids)) {

			// Fallback to comment count.
			$query_args['orderby'] = 'comment_count';
		}
		else {
		
			// Use specific posts to get if available.
			$query_args += [
				'offset'   => 0,
				'post__in' => $post_ids, 
				'orderby'  => 'post__in'
			];
		}

		return $query_args;
	}

	/**
	 * Process block filters to be used later in the heading.
	 */
	public function process_filters()
	{
		$props = $this->props;

		if (empty($props['filters']) || !is_object($this->block)) {
			return;
		}

		$display_filters = array();

		/**
		 * Process display filters - supports ids or slugs
		 */
		
		$filters_terms = $props['filters_terms'];
		if (!empty($props['filters_tags'])) {
			$filters_terms = $props['filters_tags'];
		}
		
		// Which taxonomy? Default to category
		$tax = 'category';

		if ($props['filters'] == 'tag') {
			$tax = 'post_tag';	
		}
		// Not implemented in Elementor yet. Shortcode only.
		else if ($props['filters'] == 'taxonomy' && !empty($props['filters_tax'])) {
			$tax = $props['filters_tax'];
		}
		
		// Auto-select 3 sub-cats for category if terms are missing
		if ($tax == 'category' && empty($filters_terms) && is_object($this->data['term'])) {

			$filters_terms = wp_list_pluck(
				get_categories(array(
					'child_of' => $this->data['term']->term_id, 
					'number'   => 3, 
					'hierarchical' => false
				)),
				'term_id'
			);
		}
		
		// Still no filter terms? 
		if (empty($filters_terms)) {
			return;
		}
		
		foreach ($filters_terms as $id) {
			
			// Supports slugs
			if (!is_numeric($id)) {
				$term = get_term_by('slug', $id, $tax);
			}
			else {
				$term = get_term($id);
			}
			
			if (!is_object($term)) {
				continue;
			}
			
			$link = get_term_link($term);
			$display_filters[] = '<li><a href="'. esc_url($link)  .'" data-id="' . esc_attr($term->term_id) . '">'. esc_html($term->name) .'</a></li>';
		}

		return ($this->data['display_filters'] = $display_filters);

	}

}