<?php
/**
 * WordPress Customizer registration.
 */
class Bunyad_Theme_Customizer
{
	public $module;

	public function __construct()
	{
		require_once get_template_directory() . '/inc/core/customizer/module.php';
		$this->module = new Bunyad_Customizer_Module;

		// Register extra assets.
		add_action('customize_controls_enqueue_scripts', [$this, 'register_assets'], 9);

		// Set some sphere core features options priorities. 
		add_filter('sphere/social-follow/options', function($options) {
			$options['priority'] = 34;
			return $options;
		});

		add_filter('sphere/alp/options', function($options) {
			$options['priority'] = 33;
			return $options;
		});
	}

	public function register_assets()
	{
		wp_enqueue_script(
			'bunyad-theme-customizer', 
			get_theme_file_uri('/js/admin/customizer.js'),
			['bunyad-customizer-controls'],
			Bunyad::options()->get_config('theme_version')
		);
	}

	/**
	 * Proxy to module for backward compatibility. 
	 */
	public function __call($name, $arguments)
	{
		return call_user_func_array([$this->module, $name], $arguments);
	}
}

// Init and make available in Bunyad::get('customizer')
Bunyad::register('customizer', array(
	'class' => 'Bunyad_Theme_Customizer',
	'init' => true
));
