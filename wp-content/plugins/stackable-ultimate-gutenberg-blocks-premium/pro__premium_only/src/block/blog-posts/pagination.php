<?php
/**
 * Pagination for the `ugb/blog-posts` block.
 *
 * @package Stackable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Stackable_Blog_Posts_Block_Pagination' ) ) {
	class Stackable_Blog_Posts_Block_Pagination {
        function __construct() {
			// Register the rest route to get the succeeding pages.
			add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );

			// Keep note of the block attributes since these will be used to generate the next page.
			add_action( 'stackable/blog-posts/render', array( $this, 'remember_block_attributes' ), 10, 2 );
		}

		/**
		 * Validate string used by rest endpoint.
		 */
		public static function validate_string( $value = '', $request, $param ) {
			if ( ! is_string( $value ) ) {
				return new WP_Error( 'invalid_param', sprintf( esc_html__( '%s must be a string.', STACKABLE_I18N ), $param ) );
			}
			return true;
		}

		/**
		 * Save the attributes of the blog post block, we'll reference this during the ajax call.
		 */
		public function remember_block_attributes( $attributes, $content ) {
			set_transient( 'stackable_posts_' . $attributes[ 'uniqueClass' ], json_encode( $attributes ), DAY_IN_SECONDS );
		}

		/**
		 * Register our pagination endpoint.
		 */
		public function register_rest_route() {
			register_rest_route( 'wp/v2', '/blog_posts_pagination', array(
				'methods' => 'GET',
				'callback' => array( $this, 'get_next_page' ),
				'permission_callback' => '__return_true',
				'args' => array(
					'id' => array(
						'validate_callback' => __CLASS__ . '::validate_string',
					),
					'page' => array(
						'sanitize_callback' => 'absint',
					),
					'num' => array(
						'sanitize_callback' => 'absint',
					),
				),
			) );
		}

		/**
		 * Get the next set of posts.
		 */
		public function get_next_page( $request ) {
			$id = $request->get_param( 'id' );
			$page = absint( $request->get_param( 'page' ) );
			$num = absint( $request->get_param( 'num' ) );

			// Get the block's attributes.
			$attributes = get_transient( 'stackable_posts_' . $id );
			if ( empty( $attributes ) ) {
				return '';
			}
			$attributes = json_decode( $attributes );

			// Don't remember the block attributes to save render.
			remove_action( 'stackable/blog-posts/render', array( $this, 'remember_block_attributes' ) );

			// Get total number of posts. (Do this first)
			$post_query = stackable_blog_posts_post_query( (array) $attributes );
			$the_query = new WP_Query( $post_query );
			$total_posts = $the_query->found_posts - $attributes->postOffset;

			// Default number of posts to get is the same as num of items.
			$num = $num ? $num : $attributes->numberOfItems;

			// Get the next posts.
			$new_attrs = $attributes;
			$new_attrs->postOffset = $attributes->postOffset + $attributes->numberOfItems + $num * ( $page - 2 );
			$new_attrs->numberOfItems = $num;
			$posts = stackable_render_blog_posts_block( $new_attrs, true );

			$response = new WP_REST_Response( $posts, 200 );
			$response->set_headers( [ 'X-UGB-Total-Posts' => $total_posts ] );
			return $response;
		}
	}

	new Stackable_Blog_Posts_Block_Pagination();
}
