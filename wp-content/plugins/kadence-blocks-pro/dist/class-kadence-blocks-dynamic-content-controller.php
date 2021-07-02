<?php

class Kadence_Blocks_Dynamic_Content_Controller extends WP_REST_Controller {

	/**
	 * Type property name.
	 */
	const PROP_ID = 'id';

	/**
	 * Type property name.
	 */
	const PROP_SOURCE = 'source';

	/**
	 * Query property name.
	 */
	const PROP_GROUP = 'group';
	/**
	 * Query property name.
	 */
	const PROP_FIELD = 'field';
	/**
	 * Query property name.
	 */
	const PROP_CUSTOM = 'custom';

	/**
	 * Query property name.
	 */
	const PROP_KEY = 'key';

	/**
	 * Query property name.
	 */
	const PROP_FORCE_STRING = 'force_string';

	/**
	 * Query property name.
	 */
	const PROP_BEFORE = 'before';

	/**
	 * Query property name.
	 */
	const PROP_AFTER = 'after';

	/**
	 * Query property name.
	 */
	const PROP_FALLBACK = 'fallback';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = 'kbp-dynamic/v1';
		$this->base = 'render';
		$this->image_base = 'image-render';
	}

	/**
	 * Registers the routes for the objects of the controller.
	 *
	 * @see register_rest_route()
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_render_content' ),
					'permission_callback' => array( $this, 'get_permission_check' ),
					'args'                => $this->get_render_params(),
				),
			)
		);
		// register_rest_route(
		// 	$this->namespace,
		// 	'/' . $this->image_base,
		// 	array(
		// 		array(
		// 			'methods'             => WP_REST_Server::READABLE,
		// 			'callback'            => array( $this, 'get_image_items' ),
		// 			'permission_callback' => array( $this, 'get_items_permission_check' ),
		// 			'args'                => $this->get_image_params(),
		// 		),
		// 	)
		// );
	}

	/**
	 * Checks if a given request has access to search content.
	 *
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return true|WP_Error True if the request has search access, WP_Error object otherwise.
	 */
	public function get_permission_check( $request ) {
		return current_user_can( 'edit_posts' );
	}
	/**
	 * Retrieves a collection of objects.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_render_content( $request ) {
		$item_id       = $request->get_param( self::PROP_ID );
		$group         = $request->get_param( self::PROP_GROUP );
		$source        = $request->get_param( self::PROP_SOURCE );
		$field         = $request->get_param( self::PROP_FIELD );
		$custom        = $request->get_param( self::PROP_CUSTOM );
		$key           = $request->get_param( self::PROP_KEY );
		$force_string  = $request->get_param( self::PROP_FORCE_STRING );
		$before        = $request->get_param( self::PROP_BEFORE );
		$after         = $request->get_param( self::PROP_AFTER );
		$fallback      = $request->get_param( self::PROP_FALLBACK );

		if ( empty( $field ) ) {
			return rest_ensure_response( esc_html__( 'No Content', 'kadence-blocks-pro' ) );
		}
		$field_split = explode( '|', $field, 2 );
		if ( isset( $field_split[0] ) && isset( $field_split[1] ) ) {
			$args = array(
				'id'    => ( $item_id ? $item_id : 'current' ),
				'type'  => 'text',
				'field' => $field_split[1],
				'group' => $field_split[0],
			);
		}
		$dynamic_class = Kadence_Blocks_Pro_Dynamic_Content::get_instance();
		$response      = $dynamic_class->get_content( $args );
		return rest_ensure_response( $response );
	}
	/**
	 * Retrieves the query params for the search results collection.
	 *
	 * @return array Collection parameters.
	 */
	public function get_render_params() {
		$query_params  = parent::get_collection_params();
		$query_params[ self::PROP_ID ] = array(
			'description' => __( 'The source id.', 'kadence-blocks-pro' ),
			'type' => 'string',
			'default' => 'current',
		);

		$query_params[ self::PROP_SOURCE ] = array(
			'description' => __( 'The source of the content.', 'kadence-blocks-pro' ),
			'type'        => 'string',
			'default' => 'core',
		);

		$query_params[ self::PROP_GROUP ] = array(
			'description' => __( 'The group for source.', 'kadence-blocks-pro' ),
			'type'        => 'string',
			'default' => 'post',
		);

		$query_params[ self::PROP_FIELD ] = array(
			'description' => __( 'The dynamic field', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);

		$query_params[ self::PROP_CUSTOM ] = array(
			'description' => __( 'The custom field setting.', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);
		$query_params[ self::PROP_KEY ] = array(
			'description' => __( 'The custom field Key.', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);
		$query_params[ self::PROP_FORCE_STRING ] = array(
			'description' => __( 'For a string return', 'kadence-blocks-pro' ),
			'type'        => 'boolean',
			'default'     => false,
		);
		$query_params[ self::PROP_BEFORE ] = array(
			'description' => __( 'Text Before Item.', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);
		$query_params[ self::PROP_AFTER ] = array(
			'description' => __( 'Text After Item.', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);
		$query_params[ self::PROP_FALLBACK ] = array(
			'description' => __( 'Fallback.', 'kadence-blocks-pro' ),
			'type'        => 'string',
		);

		return $query_params;
	}
}
