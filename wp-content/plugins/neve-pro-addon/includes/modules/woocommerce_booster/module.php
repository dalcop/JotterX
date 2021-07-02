<?php
/**
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      2019-02-11
 *
 * @package Neve Pro
 */

namespace Neve_Pro\Modules\Woocommerce_Booster;

use Neve_Pro\Core\Abstract_Module;

/**
 * Class Module
 *
 * @package Neve_Pro\Modules\Woocommerce_Booster
 */
class Module extends Abstract_Module {

	/**
	 * Holds the base module namespace
	 * Used to load submodules.
	 *
	 * @var string $module_namespace
	 */
	private $module_namespace = 'Neve_Pro\Modules\Woocommerce_Booster';

	/**
	 * Define module properties.
	 *
	 * @access  public
	 * @return void
	 * @property string  $this->slug        The slug of the module.
	 * @property string  $this->name        The pretty name of the module.
	 * @property string  $this->description The description of the module.
	 * @property string  $this->order       Optional. The order of display for the module. Default 0.
	 * @property boolean $this->active      Optional. Default `false`. The state of the module by default.
	 *
	 * @version 1.0.0
	 */
	public function define_module_properties() {
		$this->slug              = 'woocommerce_booster';
		$this->name              = __( 'WooCommerce Booster', 'neve' );
		$this->description       = __( 'Empower your online store with awesome new features, specially designed for a smooth WooCommerce integration.', 'neve' );
		$this->documentation     = array(
			'url'   => 'https://docs.themeisle.com/article/1058-woocommerce-booster-documentation',
			'label' => __( 'Learn more', 'neve' ),
		);
		$this->order             = 2;
		$this->dependent_plugins = array(
			'woocommerce' => array(
				'path' => 'woocommerce/woocommerce.php',
				'name' => 'WooCommerce',
			),
		);
		$this->has_dynamic_style = true;
		$this->min_req_license   = 2;
		$this->options           = array(
			array(
				'label'   => __( 'Extra features', 'neve' ),
				'options' => array(
					'enable_cart_notices'       => array(
						'label'             => __( 'Enable Multi-Announcement Bars', 'neve' ),
						'type'              => 'toggle',
						'default'           => true,
						'show_in_rest'      => true,
						'sanitize_callback' => function ( $value ) {
							return is_bool( $value ) ? $value : false;
						},
					),
					'enable_variation_swatches' => array(
						'label'             => esc_html__( 'Enable variation swatches', 'neve' ),
						'type'              => 'toggle',
						'default'           => true,
						'sanitize_callback' => function ( $value ) {
							return is_bool( $value ) ? $value : false;
						},
					),
				),
			),
		);
	}

	/**
	 * Check if module should be loaded.
	 *
	 * @return bool
	 */
	public function should_load() {
		return ( $this->is_active() && class_exists( 'WooCommerce' ) );
	}

	/**
	 * Run WooCommerce Booster Module
	 */
	public function run_module() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'change_iframe_preview' ), 30 );

		$submodules = array(
			$this->module_namespace . '\Rest\Server',
			$this->module_namespace . '\Views\Shop_Page',
			$this->module_namespace . '\Views\Shop_Product',
			$this->module_namespace . '\Views\Wish_List',
			$this->module_namespace . '\Views\Quick_View',
			$this->module_namespace . '\Views\Single_Product_Video',
			$this->module_namespace . '\Views\Single_Product',
			$this->module_namespace . '\Views\Cart_Page',
			$this->module_namespace . '\Views\Checkout_Page',
			$this->module_namespace . '\Views\Payment_Icons',
		);

		if ( get_theme_mod( 'neve_shop_pagination_type' ) === 'infinite' ) {
			$submodules[] = $this->module_namespace . '\Views\Infinite_Scroll';
		}

		$mods = array();
		foreach ( $submodules as $index => $mod ) {
			if ( class_exists( $mod ) ) {
				$mods[ $index ] = new $mod();
				$mods[ $index ]->register_hooks();
			}
		}

		add_filter( 'neve_pro_filter_customizer_modules', array( $this, 'add_customizer_classes' ) );
		add_filter( 'neve_header_presets', array( $this, 'add_header_presets' ) );

		$is_cn_enabled = get_option( 'nv_pro_enable_cart_notices', true );
		if ( $is_cn_enabled ) {
			$this->register_cart_notices();
		}

		$is_variation_enabled = get_option( 'nv_pro_enable_variation_swatches', true );
		if ( $is_variation_enabled ) {
			$this->register_variation_swatches();
		}
	}

	/**
	 * Add header presets.
	 *
	 * @param array $presets header presets array.
	 *
	 * @return array
	 */
	public function add_header_presets( $presets ) {
		return array_merge(
			$presets,
			array(
				array(
					'label' => 'Two Row Search Cart',
					'image' => NEVE_PRO_INCLUDES_URL . 'modules/woocommerce_booster/assets/img/TwoRowSearchCart.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"},{\"x\":4,\"y\":1,\"width\":6,\"height\":1,\"id\":\"header_search\"},{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_cart_icon\"}],\"bottom\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","primary-menu_component_align":"left"}',
				),
				array(
					'label' => 'Search Menu Cart',
					'image' => NEVE_PRO_INCLUDES_URL . 'modules/woocommerce_booster/assets/img/SearchMenuCart.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":3,\"height\":1,\"id\":\"logo\"},{\"x\":3,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"},{\"x\":6,\"y\":1,\"width\":5,\"height\":1,\"id\":\"primary-menu\"},{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_cart_icon\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","primary-menu_component_align":"right"}',
				),
				array(
					'label' => 'Two Row Search Cart',
					'image' => NEVE_PRO_INCLUDES_URL . 'modules/woocommerce_booster/assets/img/TwoRowSearchCart2.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_cart_icon\"}],\"main\":[{\"x\":0,\"y\":1,\"width\":2,\"height\":1,\"id\":\"logo\"},{\"x\":2,\"y\":1,\"width\":6,\"height\":1,\"id\":\"primary-menu\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"header_search\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","header_cart_icon_component_align":"right"}',
				),
			)
		);
	}

	/**
	 * Add customizer classes.
	 *
	 * @param array $classes loaded classes.
	 *
	 * @return array
	 */
	public function add_customizer_classes( $classes ) {
		return array_merge(
			array(
				'Modules\Woocommerce_Booster\Customizer\Single_Product',
				'Modules\Woocommerce_Booster\Customizer\Cart_Page',
				'Modules\Woocommerce_Booster\Customizer\Checkout_Page',
				'Modules\Woocommerce_Booster\Customizer\Shop_Page',
				'Modules\Woocommerce_Booster\Customizer\Payment_Icons',
				'Modules\Woocommerce_Booster\Customizer\Cart_Icon',
				'Modules\Woocommerce_Booster\Customizer\Typography',
			),
			$classes
		);
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {

		$this->rtl_enqueue_style( 'neve-pro-addon-woo-booster', NEVE_PRO_INCLUDES_URL . 'modules/woocommerce_booster/assets/style.min.css', array(), NEVE_PRO_VERSION );

		wp_register_script( 'neve-pro-addon-woo-booster', NEVE_PRO_INCLUDES_URL . 'modules/woocommerce_booster/assets/js/build/script.js', array( 'jquery', 'woocommerce', 'wc-cart-fragments' ), NEVE_PRO_VERSION, true );

		global $wp_query;
		$url = wc_get_endpoint_url( 'nv-wish-list', '', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );

		wp_localize_script(
			'neve-pro-addon-woo-booster',
			'neveWooBooster',
			array(
				'relatedSliderStatus'    => $this->get_theme_mod_status( 'neve_enable_product_related_slider' ),
				'gallerySliderStatus'    => $this->get_theme_mod_status( 'neve_enable_product_gallery_thumbnails_slider' ),
				'recentlyViewedStatus'   => $this->get_theme_mod_status( 'neve_enable_related_viewed' ),
				'labelsAsPlaceholders'   => $this->get_theme_mod_status( 'neve_checkout_labels_placeholders' ),
				'relatedSliderPerCol'    => get_theme_mod( 'neve_single_product_related_columns' ),
				'galleryLayout'          => $this->get_gallery_layout(),
				'modalContentEndpoint'   => rest_url( NEVE_PRO_REST_NAMESPACE . '/products/post/' ),
				'wishListUpdateEndpoint' => rest_url( NEVE_PRO_REST_NAMESPACE . '/update_wishlist/' ),
				'userWishlist'           => get_user_meta( get_current_user_id(), 'wish_list_products', true ),
				'infiniteScrollQuery'    => wp_json_encode( $wp_query->query ),
				'nonce'                  => wp_create_nonce( 'wp_rest' ),
				'loggedIn'               => is_user_logged_in(),
				'i18n'                   => apply_filters(
					'neve_wishlist_strings',
					array(
						/* translators: %s - url */
						'wishListNoticeTextAdd'    => sprintf( esc_html__( 'This product has been added to your %s.', 'neve' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( $url ), esc_html__( 'wish list', 'neve' ) ) ),
						/* translators: %s - url */
						'wishListNoticeTextRemove' => sprintf( esc_html__( 'This product has been removed from your %s.', 'neve' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( $url ), esc_html__( 'wish list', 'neve' ) ) ),
						'emptyWishList'            => esc_html__( 'You don\'t have any products in your wish list yet.', 'neve' ),
						'wishlistError'            => esc_html__( 'There was an error while trying to update the wishlist.', 'neve' ),
					)
				),
			)
		);

		wp_script_add_data( 'neve-pro-addon-woo-booster', 'async', true );
		wp_enqueue_script( 'neve-pro-addon-woo-booster' );
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}

	/**
	 * Scripts to change the iframe preview.
	 */
	public function change_iframe_preview() {
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function($) {
				wp.customize.section( 'neve_cart_page_layout', function(section) {
					section.expanded.bind( function(isExpanded) {
						if ( isExpanded ) {
							wp.customize.previewer.previewUrl.set( '<?php echo esc_js( wc_get_page_permalink( 'cart' ) ); ?>' )
						}
					} );
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Get status of a theme mod.
	 *
	 * @param string $mod Theme mod name.
	 *
	 * @return string
	 */
	private function get_theme_mod_status( $mod ) {
		$status = get_theme_mod( $mod, false );

		if ( false === $status ) {
			return 'disabled';
		}

		return 'enabled';
	}

	/**
	 * Get gallery layout.
	 *
	 * @return string
	 */
	private function get_gallery_layout() {
		return get_theme_mod( 'neve_single_product_gallery_layout', 'normal' );
	}

	/**
	 * Register cart notices classes.
	 */
	private function register_cart_notices() {
		$class    = $this->module_namespace . '\Cart_Notices\Cart_Notices';
		$instance = new $class();
		$instance->init();
	}

	/**
	 * Register variation swatches classes.
	 */
	private function register_variation_swatches() {
		$variation_swatches_admin = $this->module_namespace . '\Variation_Swatches\Variation_Swatches';
		$admin_instance           = new $variation_swatches_admin();
		$admin_instance->init();

		$variation_swatches_public = $this->module_namespace . '\Views\Variation_Swatches';
		$public_instance           = new $variation_swatches_public();
		$public_instance->init();
	}
}
