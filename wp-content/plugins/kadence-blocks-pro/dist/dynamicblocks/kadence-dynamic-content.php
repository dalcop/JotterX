<?php
/**
 * Enqueue JS for Custom Icons and build admin for icons.
 *
 * @since   1.4.0
 * @package Kadence Blocks Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue JS for Custom Icons and build admin for icons.
 *
 * @category class
 */
class Kadence_Blocks_Pro_Dynamic_Content {
	/**
	 * Instance of this class
	 *
	 * @var null
	 */
	private static $instance = null;

	const POST_GROUP = 'post';

	const ARCHIVE_GROUP = 'archive';

	const AUTHOR_GROUP = 'author';

	const SITE_GROUP = 'site';

	const COMMENTS_GROUP = 'comments';

	const MEDIA_GROUP = 'media';

	const OTHER_GROUP = 'other';

	const TEXT_CATEGORY = 'text';

	const NUMBER_CATEGORY = 'number';

	const IMAGE_CATEGORY = 'image';

	const DATE_CATEGORY = 'date';

	const AUDIO_CATEGORY = 'audio';

	const VIDEO_CATEGORY = 'video';

	const URL_CATEGORY = 'url';

	const HTML_CATEGORY = 'html';

	const EMBED_CATEGORY = 'embed';

	const VALUE_SEPARATOR = '#+*#';

	const CUSTOM_POST_TYPE_REGEXP = '/"(custom_post_type\|[^\|]+\|\d+)"/';

	const SHORTCODE = 'kb-dynamic';

	/**
	 * The post group field options.
	 *
	 * @var array
	 */
	private static $post_group = array(
		'post_title',
		'post_url',
		'post_content',
		'post_excerpt',
		'post_id',
		'post_date',
		'post_date_modified',
		'post_type',
		'post_status',
		'post_custom_field',
		'post_featured_image',
	);

	/**
	 * Instance Control
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Class Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'on_init' ) );

	}
	/**
	 * On init
	 */
	public function on_init() {
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'script_enqueue' ), 30 );
		}

		//add_shortcode( self::SHORTCODE, array( $this, 'dynamic_shortcode_render' ) );
		//add_filter( 'render_block', array( $this, 'render_blocks' ), 10, 2 );
	}
	/**
	 * Add the dynamic content to blocks.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block info.
	 */
	public function render_blocks( $block_content, $block ) {
		if ( is_admin() ) {
			return $block_content;
		}
		if ( 'kadence/advancedheading' === $block['blockName'] ) {
			if ( isset( $block['attrs'] ) && is_array( $block['attrs'] ) ) {
				$blockattr = $block['attrs'];
				if ( isset( $blockattr['kadenceDynamic'] ) && is_array( $blockattr['kadenceDynamic'] ) && isset( $blockattr['kadenceDynamic'][0] ) && is_array( $blockattr['kadenceDynamic'][0] ) && isset( $blockattr['kadenceDynamic'][0]['enable'] ) && $blockattr['kadenceDynamic'][0]['enable'] ) {
					$dynamic_settings = $blockattr['kadenceDynamic'][0];
					$has_link = false;
					if ( isset( $blockattr['kadenceDynamic'] ) && is_array( $blockattr['kadenceDynamic'] ) && isset( $blockattr['kadenceDynamic'][1] ) && isset( $blockattr['kadenceDynamic'][1]['enable'] ) && $blockattr['kadenceDynamic'][1]['enable'] ) {
						$has_link = true;
						$link_args = array();
						$link_args['id'] = ( isset( $blockattr['kadenceDynamic'][1]['id'] ) && ! empty( $blockattr['kadenceDynamic'][1]['id'] ) ? $blockattr['kadenceDynamic'][1]['id'] : 'current' );
						$link_args['source'] = ( isset( $blockattr['kadenceDynamic'][1]['source'] ) && ! empty( $blockattr['kadenceDynamic'][1]['source'] ) ? $blockattr['kadenceDynamic'][1]['source'] : 'core' );
						$link_field = ( isset( $blockattr['kadenceDynamic'][1]['field'] ) && ! empty( $blockattr['kadenceDynamic'][1]['field'] ) ? $blockattr['kadenceDynamic'][1]['field'] : 'post|post_url' );
						$link_field_split = explode( '|', $link_field, 2 );
						$link_args['group']  = ( isset( $link_field_split[0] ) && ! empty( $link_field_split[0] ) ? $link_field_split[0] : 'post' );
						$link_args['field']  = ( isset( $link_field_split[1] ) && ! empty( $link_field_split[1] ) ? $link_field_split[1] : '' );
						$link_args['custom'] = ( isset( $blockattr['kadenceDynamic'][1]['custom'] ) && ! empty( $blockattr['kadenceDynamic'][1]['custom'] ) ? $blockattr['kadenceDynamic'][1]['custom'] : '' );
						$link_args['key'] = ( isset( $blockattr['kadenceDynamic'][1]['key'] ) && ! empty( $blockattr['kadenceDynamic'][1]['key'] ) ? $blockattr['kadenceDynamic'][1]['key'] : '' );
						$link_args['type']   = 'link';
						$the_link = $this->get_content( $link_args );
					}
					$tag_level = ( isset( $blockattr['level'] ) && ! empty( $blockattr['level'] ) ? $blockattr['level'] : '2' );
					$tag_name = ( isset( $blockattr['htmlTag'] ) && ! empty( $blockattr['htmlTag'] ) && 'heading' !== $blockattr['htmlTag'] ? $blockattr['htmlTag'] : 'h' . $tag_level );
					$anchor = ( isset( $blockattr['anchor'] ) && ! empty( $blockattr['anchor'] ) ? $blockattr['anchor'] : false );
					$anchor = ( isset( $blockattr['anchor'] ) && ! empty( $blockattr['anchor'] ) ? $blockattr['anchor'] : false );
					$reveal_animation = ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) && ( 'reveal-left' === $blockattr['kadenceAnimation'] || 'reveal-right' === $blockattr['kadenceAnimation'] || 'reveal-up' === $blockattr['kadenceAnimation'] || 'reveal-down' === $blockattr['kadenceAnimation'] ) ? true : false );
					$animation_settings = ( isset( $blockattr['kadenceAOSOptions'] ) && is_array( $blockattr['kadenceAOSOptions'] ) && isset( $blockattr['kadenceAOSOptions'][0] ) && is_array( $blockattr['kadenceAOSOptions'][0] ) ? $blockattr['kadenceAOSOptions'][0] : false );
					$classes = [];
					$block_content = '';
					if ( $reveal_animation ) {
						$block_content .= '<div class="kb-adv-heading-wrap' . esc_attr( $blockattr['uniqueID'] ) . ' kadence-advanced-heading-wrapper kadence-heading-clip-animation' . esc_attr( $blockattr['className'] ? ' ' . $blockattr['className'] : '' ) . '">';
					}
					$block_content .= '<' . esc_attr( $tag_name ) . ' ' . ( $anchor ? 'id="' . esc_attr( $anchor ) . '" ' : '' ) . 'class="' . esc_attr( implode( ' ', $classes ) ) . '" data-kb-block="kb-adv-heading' . esc_attr( $blockattr['uniqueID'] ) . '"' . ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) ? ' data-aos="' . esc_attr( $blockattr['kadenceAnimation'] ) . '"' : '' ) . ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) && $animation_settings && isset( $animation_settings['duration'] ) && ! empty( $animation_settings['duration'] ) ? ' data-aos-duration="' . esc_attr( $animation_settings['duration'] ) . '"' : '' ) . ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) && $animation_settings && isset( $animation_settings['delay'] ) && ! empty( $animation_settings['delay'] ) ? ' data-aos-delay="' . esc_attr( $animation_settings['delay'] ) . '"' : '' ) . ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) && $animation_settings && isset( $animation_settings['easing'] ) && ! empty( $animation_settings['easing'] ) ? ' data-aos-easing="' . esc_attr( $animation_settings['easing'] ) . '"' : '' ) . ( isset( $blockattr['kadenceAnimation'] ) && ! empty( $blockattr['kadenceAnimation'] ) && $animation_settings && isset( $animation_settings['once'] ) && ! empty( $animation_settings['once'] ) ? ' data-aos-once="' . esc_attr( $animation_settings['once'] ) . '"' : '' ) . '>';
					if ( $has_link && $the_link ) {
						$block_content .= '<a href="' . esc_url( $the_link ) . '" class="kb-dynamic-link">';
					}
					$args = array();
					$args['id'] = ( isset( $blockattr['kadenceDynamic'][0]['id'] ) && ! empty( $blockattr['kadenceDynamic'][0]['id'] ) ? $blockattr['kadenceDynamic'][0]['id'] : 'current' );
					$args['source'] = ( isset( $blockattr['kadenceDynamic'][0]['source'] ) && ! empty( $blockattr['kadenceDynamic'][0]['source'] ) ? $blockattr['kadenceDynamic'][0]['source'] : 'core' );
					$field = ( isset( $blockattr['kadenceDynamic'][0]['field'] ) && ! empty( $blockattr['kadenceDynamic'][0]['field'] ) ? $blockattr['kadenceDynamic'][0]['field'] : 'post|post_url' );
					$field_split = explode( '|', $field, 2 );
					$args['group']  = ( isset( $field_split[0] ) && ! empty( $field_split[0] ) ? $field_split[0] : 'post' );
					$args['field']  = ( isset( $field_split[1] ) && ! empty( $field_split[1] ) ? $field_split[1] : '' );
					$args['custom'] = ( isset( $blockattr['kadenceDynamic'][0]['custom'] ) && ! empty( $blockattr['kadenceDynamic'][0]['custom'] ) ? $blockattr['kadenceDynamic'][0]['custom'] : '' );
					$args['key'] = ( isset( $blockattr['kadenceDynamic'][0]['key'] ) && ! empty( $blockattr['kadenceDynamic'][0]['key'] ) ? $blockattr['kadenceDynamic'][0]['key'] : '' );
					$block_content .= $this->get_content( $args );
					if ( $has_link && $the_link ) {
						$block_content .= '</a>';
					}
					$block_content .= '</' . esc_attr( $tag_name ) . '>';
					if ( $reveal_animation ) {
						$block_content .= '</div>';
					}
				}
			}
		}
		return $block_content;
	}
	/**
	 * Enqueue Script for Meta options
	 */
	public function script_enqueue() {
		wp_localize_script(
			'kadence-blocks-pro-js',
			'kadenceDynamicParams',
			array(
				'textFields' => $this->get_text_fields(),
				'linkFields' => $this->get_link_fields(),
				'dynamicRenderEndpoint' => '/kbp-dynamic/v1/render',
			)
		);
	}
	/**
	 * On init
	 */
	public function get_text_fields() {
		$options = array(
			array(
				'label' => __( 'Post', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::POST_GROUP . '|post_title',
						'label' => esc_attr__( 'Post Title', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_url',
						'label' => esc_attr__( 'Post URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_excerpt',
						'label' => esc_attr__( 'Post Excerpt', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_id',
						'label' => esc_attr__( 'Post ID', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_date',
						'label' => esc_attr__( 'Post Date', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_date_modified',
						'label' => esc_attr__( 'Post Last Modified Date', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_featured_image',
						'label' => esc_attr__( 'Featured Image URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_type',
						'label' => esc_attr__( 'Post Type', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_status',
						'label' => esc_attr__( 'Post Status', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_custom_field',
						'label' => esc_attr__( 'Post Custom Field', 'kadence-blocks-pro' ),
					),
				),
			),
			array(
				'label' => __( 'Archive', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::ARCHIVE_GROUP . '|archive_title',
						'label' => esc_attr__( 'Archive Title', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::ARCHIVE_GROUP . '|archive_url',
						'label' => esc_attr__( 'Archive URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::ARCHIVE_GROUP . '|archive_description',
						'label' => esc_attr__( 'Archive Description', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::ARCHIVE_GROUP . '|archive_custom_field',
						'label' => esc_attr__( 'Archive Custom Field', 'kadence-blocks-pro' ),
					),
				),
			),
			array(
				'label' => __( 'Site', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::SITE_GROUP . '|site_title',
						'label' => esc_attr__( 'Site Title', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::SITE_GROUP . '|site_tagline',
						'label' => esc_attr__( 'Site Tagline', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::SITE_GROUP . '|site_url',
						'label' => esc_attr__( 'Site URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::SITE_GROUP . '|page_title',
						'label' => esc_attr__( 'Page Title', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::SITE_GROUP . '|user_info',
						'label' => esc_attr__( 'User Info', 'kadence-blocks-pro' ),
					),
				),
			),
			// self::MEDIA_GROUP => array(
			// 	'label' => __( 'Media', 'kadence-blocks-pro' ),
			// ),
			array(
				'label' => __( 'Author', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::AUTHOR_GROUP . '|author_info',
						'label' => esc_attr__( 'Author Info', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::AUTHOR_GROUP . '|author_custom_field',
						'label' => esc_attr__( 'Author Custom Field', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::AUTHOR_GROUP . '|author_name',
						'label' => esc_attr__( 'Author Name', 'kadence-blocks-pro' ),
					),
				),
			),
			// self::COMMENTS_GROUP => array(
			// 	'label' => __( 'Comments', 'kadence-blocks-pro' ),
			// ),
		);
		return apply_filters( 'kadence_block_pro_dynamic_text_fields_options', $options );
	}
	/**
	 * On init
	 */
	public function get_link_fields() {
		$options = array(
			array(
				'label' => __( 'Post', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::POST_GROUP . '|post_url',
						'label' => esc_attr__( 'Post URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_featured_image',
						'label' => esc_attr__( 'Featured Image URL', 'kadence-blocks-pro' ),
					),
					array(
						'value' => self::POST_GROUP . '|post_custom_field',
						'label' => esc_attr__( 'Post Custom Field', 'kadence-blocks-pro' ),
					),
				),
			),
			array(
				'label' => __( 'Archive', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::ARCHIVE_GROUP . '|archive_url',
						'label' => esc_attr__( 'Archive URL', 'kadence-blocks-pro' ),
					),
				),
			),
			array(
				'label' => __( 'Site', 'kadence-blocks-pro' ),
				'options' => array(
					array(
						'value' => self::SITE_GROUP . '|site_url',
						'label' => esc_attr__( 'Site URL', 'kadence-blocks-pro' ),
					),
				),
			),
			// self::MEDIA_GROUP => array(
			// 	'label' => __( 'Media', 'kadence-blocks-pro' ),
			// ),
			// self::AUTHOR_GROUP => array(
			// 	'label' => __( 'Author', 'kadence-blocks-pro' ),
			// ),
			// self::COMMENTS_GROUP => array(
			// 	'label' => __( 'Comments', 'kadence-blocks-pro' ),
			// ),
		);
		return apply_filters( 'kadence_block_pro_dynamic_link_fields_options', $options );
	}
	/**
	 * Render the dynamic content.
	 *
	 * @param array $args the content args
	 */
	public function get_content( $args ) {
		$defaults = array(
			'id'           => 'current',
			'source'       => 'core',
			'group'        => 'post',
			'type'         => 'text',
			'field'        => '',
			'custom'       => '',
			'key'          => '',
			'force-string' => false,
			'before'       => null,
			'after'        => null,
			'fallback'     => null,
		);
		$args    = wp_parse_args( $args, $defaults );
		$item_id = apply_filters( 'kadence_dynamic_item_id', $args['id'], $args['source'], $args['group'], $args['field'], $args['custom'], $args['key'] );
		$output  = $this->get_field_content( $item_id, $args['source'], $args['group'], $args['field'], $args['custom'], $args['key'] );
		if ( $args['force-string'] && is_array( $output ) ) {
			if ( 'first' === $args['force-string'] ) {
				$output = reset( $output );
			}
			if ( is_array( $output ) ) {
				$output = implode( ',', $output );
			}
		}
		if ( ! $output && null !== $args['fallback'] ) {
			return $args['fallback'];
		}
		return $output;
	}
	/**
	 * Get the content output.
	 *
	 * @param object $post the post.
	 * @param string $source the source for the content.
	 * @param string $group the group of the content.
	 * @param string $field the field of the content.
	 */
	public function get_field_content( $item_id, $source, $group, $field, $custom, $key ) {
		if ( 'core' === $source ) {
			// Render Core.
			if ( self::POST_GROUP === $group ) {
				if ( 'current' === $item_id || '' === $item_id ) {
					$item_id = get_the_ID();
				} else {
					$item_id = intval( $item_id );
				}
				$post = get_post( $item_id );
				if ( $post && is_object( $post ) && 'publish' === $post->post_status && empty( $post->post_password ) ) {
					switch ( $field ) {
						case 'post_title':
							$output = wp_kses_post( get_the_title( $post ) );
							break;
						case 'post_date':
							$output = get_the_date( '', $post );
							break;
						case 'post_date_modified':
							$output = get_the_modified_date( '', $post );
							break;
						case 'post_type':
							$output = get_post_type( $post );
							break;
						case 'post_status':
							$output = get_post_status( $post );
							break;
						case 'post_id':
							$output = $post->ID;
							break;
						case 'post_url':
							$output = get_permalink( $post );
							break;
						case 'post_excerpt':
							$output = get_the_excerpt( $post );
							break;
						case 'post_content':
							$output = get_the_content( $post );
							break;
						case 'post_custom_field':
							$output = '';
							if ( ! empty( $key ) ) {
								$output = get_post_meta( $post->ID, $key, true );
							}
							break;
						case 'post_featured_image':
							$output = get_the_post_thumbnail_url( $post );
							break;
						default:
							$output = apply_filters( 'kadence_dynamic_content_core_post_{$field}_render', '', $item_id, $source, $group, $field, $custom, $key );
							break;
					}
				} else {
					$output = apply_filters( 'kadence_dynamic_content_core_post_{$field}_render', '', $item_id, $source, $group, $field, $custom, $key );
				}
			} if ( self::ARCHIVE_GROUP === $group ) {
				if ( 'current' === $item_id || '' === $item_id ) {
					$item_id = get_queried_object_id();
				} else {
					$item_id = intval( $item_id );
				}
				switch ( $field ) {
					case 'archive_title':
						// This needs updated, won't get anything but the current archive title.
						$output = wp_kses_post( get_the_archive_title() );
						break;
					case 'archive_description':
						// This needs updated, won't get anything but the current archive title.
						$output = wp_kses_post( get_the_archive_description() );
						break;
					case 'archive_url':
						$output = get_the_permalink( $item_id );
						break;
					case 'archive_custom_field':
						$output = '';
						if ( ! empty( $key ) ) {
							$output = get_term_meta( $item_id, $key, true );
						}
						break;
					default:
						$output = apply_filters( 'kadence_dynamic_content_core_archive_{$field}_render', '', $item_id, $source, $group, $field, $custom, $key );
						break;
				}
			} elseif ( self::SITE_GROUP === $group ) {
				switch ( $field ) {
					case 'site_title':
						$output = wp_kses_post( get_bloginfo( 'name' ) );
						break;
					case 'site_tagline':
						$output = wp_kses_post( get_bloginfo( 'description' ) );
						break;
					case 'site_url':
						$output = get_home_url();
						break;
					case 'page_title':
						$output = wp_kses_post( $this->get_the_title() );
						break;
					case 'user_info':
						$user = wp_get_current_user();
						if ( 0 === $user->ID ) {
							$output = '';
							break;
						}
						if ( empty( $custom ) ) {
							$output = isset( $user->display_name ) ? $user->display_name : '';
							break;
						}
						switch ( $custom ) {
							case 'id':
								$output = isset( $user->ID ) ? $user->ID : '';
								break;
							case 'username':
								$output = isset( $user->user_login ) ? $user->user_login : '';
								break;
							case 'first_name':
								$output = isset( $user->first_name ) ? $user->first_name : '';
								break;
							case 'last_name':
								$output = isset( $user->last_name ) ? $user->last_name : '';
								break;
							case 'bio':
								$output = isset( $user->description ) ? $user->description : '';
								break;
							case 'email':
								$output = isset( $user->user_email ) ? $user->user_email : '';
								break;
							case 'website':
								$output = isset( $user->user_url ) ? $user->user_url : '';
								break;
							case 'meta':
								if ( ! empty( $key ) ) {
									$output = get_user_meta( $user->ID, $key, true );
								} else {
									$output = '';
								}
								break;
							default:
								// display name.
								$output = isset( $user->display_name ) ? $user->display_name : '';
								break;
						}
						break;
					default:
						$output = apply_filters( 'kadence_dynamic_content_core_site_{$field}_render', '', $item_id, $source, $group, $field, $custom, $key );
						break;
				}
			}
		} else {
			$output = apply_filters( 'kadence_dynamic_content_{$source}_render', $item_id, $source, $group, $field, $custom, $key );
		}
		return apply_filters( 'kadence_dynamic_content_render', $output, $item_id, $source, $group, $field, $custom, $key );
	}
	/**
	 * Get the title output.
	 */
	public function get_the_title() {
		$output = '';
		if ( is_404() ) {
			$output = esc_html_e( 'Oops! That page can&rsquo;t be found.', 'kadence-blocks-pro' );
		} elseif ( is_home() && ! have_posts() ) {
			$output = esc_html_e( 'Nothing Found', 'kadence-blocks-pro' );
		} elseif ( is_home() && ! is_front_page() ) {
			$output = single_post_title();
		} elseif ( is_search() ) {
			$output = sprintf(
				/* translators: %s: search query */
				esc_html__( 'Search Results for: %s', 'kadence-blocks-pro' ),
				'<span>' . get_search_query() . '</span>'
			);
		} elseif ( is_archive() || is_home() ) {
			$output = get_the_archive_title();
		}
		return $output;
	}
	/**
	 * Render the dynamic shortcode.
	 *
	 * @param array $attributes the shortcode attributes.
	 */
	public function dynamic_shortcode_render( $attributes ) {
		$atts = shortcode_atts(
			array(
				'id'           => 'current',
				'source'       => 'core',
				'group'        => 'post',
				'type'         => 'text',
				'field'        => '',
				'custom'       => '',
				'key'          => '',
				'force-string' => false,
				'before'       => null,
				'after'        => null,
				'fallback'     => null,
			),
			$attributes
		);

		// Sanitize Attributes.
		$item_id  = sanitize_text_field( $atts['id'] );
		$source   = sanitize_text_field( $atts['source'] );
		$group    = sanitize_text_field( $atts['group'] );
		$custom   = sanitize_text_field( $atts['custom'] );
		$key      = sanitize_text_field( $atts['key'] );
		$field    = sanitize_text_field( $atts['field'] );
		$before   = sanitize_text_field( $atts['before'] );
		$after    = sanitize_text_field( $atts['after'] );
		$fallback = sanitize_text_field( $atts['fallback'] );

		$item_id = apply_filters( 'kadence_dynamic_item_id', $item_id, $source, $group, $field, $custom, $key );
		$output  = $this->get_field_content( $item_id, $source, $group, $field, $custom, $key );
		if ( $atts['force-string'] && is_array( $output ) ) {
			if ( 'first' === $atts['force-string'] ) {
				$output = reset( $output );
			}
			if ( is_array( $output ) ) {
				$output = implode( ',', $output );
			}
		}
		if ( ! $output && null !== $fallback ) {
			return $fallback;
		}
		return $output;
	}
}
Kadence_Blocks_Pro_Dynamic_Content::get_instance();
