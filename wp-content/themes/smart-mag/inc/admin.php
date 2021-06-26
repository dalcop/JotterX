<?php
/**
 * General Admin functionality - hooks, methods.
 *  
 * This file serves to be the functions.php for admin functionality. Any
 * non-specific functionality is contained here.
 * 
 * Also see admin/ folder in the root.
 *
 */
class Bunyad_Theme_Admin
{
	public function __construct()
	{
		// Setup plugins before init
		$this->setup_plugins();

		add_action('bunyad_theme_init', [$this, 'init']);

		/**
		 * Include relevant admin files
		 */
		
		// Dashboard, importer and editor
		include get_template_directory() . '/inc/admin/dashboard.php';
		include get_template_directory() . '/inc/admin/import.php';
		include get_template_directory() . '/inc/admin/editor.php';

		// Migrations / updates.
		require_once get_theme_file_path('inc/admin/migrations.php');

		// Packaged plugin updates
		include get_template_directory() . '/inc/admin/plugins-update.php';

		// Theme Activation / Update Hooks
		add_action('after_switch_theme', [$this, 'first_setup']);

		// Special case for v5 migrations. At correct hook.
		add_action('admin_init', function() {
			// Note: This is a required notice.
			if (get_option('smartmag_convert_from_v3')) {
				add_action('admin_notices', [$this, 'notice_must_convert_v5']);
			}
		}, 11);
	}
	
	public function init()
	{
		$this->editor_styles();
	}
	
	/**
	 * Setup and recommend plugins
	 */
	public function setup_plugins()
	{
		// Note: packaged_plugins below is only used on admin_init, so safe to ignore on non-admin.
		if (!is_admin()) {
			return;
		}
	
		// Recommended / packaged plugins
		$plugins = [
			[
				'name'     => 'Sphere Core',
				'slug'     => 'sphere-core',
				'source'   => get_template_directory() . '/lib/vendor/plugins/sphere-core.zip',
				'required' => true,
				'version'  => '1.1.8'
			],

			[
				'name'     => 'SmartMag Core',
				'slug'     => 'smartmag-core',
				'source'   => get_template_directory() . '/lib/vendor/plugins/smartmag-core.zip',
				'required' => true,
				'version'  => '1.0.6'
			],

			[
				'name'     => 'Elementor Page Builder',
				'slug'     => 'elementor',
				'required' => true,
				'version'  => '3.2.0',
			],		
			
			[
				'name'     => 'Regenerate Thumbnails (Optional)',
				'slug'     => 'regenerate-thumbnails',
				'required' => false,
			],

			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
				'optional' => true,
			],

			[
				'name'     => 'Custom sidebars',
				'slug'     => 'custom-sidebars',
				'required' => false,
				'optional' => true,
			],

			[
				'name'     => 'Self-Hosted Google Fonts',
				'slug'     => 'selfhost-google-fonts',
				'required' => false,
				'optional' => true,
			],

			[
				'name'     => 'Bunyad Instagram Widget',
				'slug'     => 'bunyad-instagram-widget',
				'source'   => get_template_directory() . '/lib/vendor/plugins/bunyad-instagram-widget.zip',
				'required' => false,
				'optional' => true,
			],
			[
				'name'         => 'Bunyad AMP',
				'slug'         => 'bunyad-amp',
				'required'     => false,
				'optional'     => true,
				'source'       => get_template_directory() . '/lib/vendor/plugins/bunyad-amp.zip', // The plugin source
				'version'      => '2.0.10',
				'external_url' => 'https://theme-sphere.com/docs/smartmag/#amp'
			],
			[
				'name'     => esc_html__('Bunyad Demo Import', 'bunyad-admin'),
				'slug'     => 'bunyad-demo-import',
				'required' => false,
				'version'  => '2.6.2',
				'source'   => get_template_directory() . '/lib/vendor/plugins/bunyad-demo-import.zip', // The plugin source
			],
		];

		if (Bunyad::options()->legacy_mode) {
			$plugins[] = [
				'name'     	=> '(Legacy) Bunyad Shortcodes', // The plugin name
				'slug'     	=> 'bunyad-shortcodes', // The plugin slug (typically the folder name)
				'source'   	=> get_template_directory() . '/lib/vendor/plugins/bunyad-shortcodes.zip', // The plugin source
				'required' 	=> false,
				'version'   => '1.1.0'
			];
		}
		
		// Set for update checking.
		Bunyad::registry()->set('packaged_plugins', $plugins);

		// Only load and register if in admin (checked above), or if user has permissions.
		if (current_user_can('install_plugins')) {
			// Load the plugin activation class and our enhancements.
			require_once get_template_directory() . '/lib/vendor/class-tgm-plugin-activation.php';
			require_once get_template_directory() . '/inc/admin/dash-plugins.php';

			tgmpa($plugins, [
				'parent_slug' => 'sphere-dash',
				'id'          => 'smartmag_tgmpa'
			]);
		}
	}

	/**
	 * Add editor styles.
	 *
	 * @return void
	 */
	public function editor_styles()
	{

		// Add editor styles
		$styles = [get_stylesheet_uri()];
		$skin   = Bunyad::get('theme')->get_style();
		
		// Add skin css second
		if (isset($skin['css'])) {
			array_push($styles, get_template_directory_uri() . '/css/' . $skin['css'] . '.css');
		}
		
		$styles = array_merge($styles, [
			get_template_directory_uri() . '/css/admin/editor-style.css',
			Bunyad::get('theme')->get_fonts_enqueue()
		]);

		if (!empty($skin['local_fonts'])) {
			foreach ((array) $skin['local_fonts'] as $font) {
				$styles[] = get_theme_file_uri('css/fonts/' . $font . '.css');
			}
		}

		add_editor_style($styles);
	}

	/**
	 * Admin notice for the compulsory migration tool for v5.0 to prevent fatal errors 
	 * and missing data.
	 */
	public function notice_must_convert_v5()
	{
		?>
		<div class="notice error">
			<h2>SmartMag Data Conversion Required!</h2>
			<p>Since v5+ was a rewrite and a lot of data has changed, the converter tool has to run.</p>

		<?php if (!class_exists('SmartMag_Core')): ?>
			<p>
				<strong>SmartMag Core</strong> plugin is required to convert data from old SmartMag to the new one. Please install it 
				from SmartMag > Install Plugins.
			</p>
			<p>Once installed, convert from SmartMag > Covert to v5.</p>

		<?php elseif (!\SmartMag_Core::instance()->did_init): ?>

			<p>SmartMag Core is activated but is conflicting with another plugin. Please disable the conflicting plugins such as Bunyad Widgets or another theme's Core plugin.</p>

		<?php else: ?>

			
			<p>
				Please run the conversion tool from 
				<a href="<?php echo esc_url(admin_url('admin.php?page=sphere-dash-convert-v5')); ?>">SmartMag > Convert to v5</a>.

			</p>
		<?php endif; ?>
			<p>
		</div>
		<?php 
	}

	/**
	 * Setup elementor configs for better compatibility, on theme activation.
	 */
	public function first_setup()
	{
		// update_option('elementor_container_width', '1200');
		// update_option('elementor_page_title_selector', '.the-page-heading');
		// update_option('elementor_viewport_lg', '940');
		update_option('elementor_disable_color_schemes', 'yes');
		update_option('elementor_disable_typography_schemes', 'yes');
		update_option('elementor_experiment-e_dom_optimization', 'active');
		update_option('elementor_experiment-e_optimized_assets_loading', 'active');
	}
}

// init and make available in Bunyad::get('admin')
Bunyad::register('admin', [
	'class' => 'Bunyad_Theme_Admin',
	'init'  => true
]);