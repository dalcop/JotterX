<?php

namespace Bunyad;

use Bunyad\Elementor\LoopWidget;
use Bunyad\Elementor\SectionOptions;
use \Elementor\Plugin as Plugin;
use \SmartMag_Core;

/**
 * Base Elementor Class for setup
 */
class Elementor 
{
	public function register_hooks()
	{
		// Add widgets
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

		// Add custom controls.
		add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
		
		// Register categories
		add_action('elementor/elements/categories_registered', function($manager) {
			$manager->add_category(
				'smart-mag-blocks',
				[
					'title' => esc_html__('SmartMag Blocks', 'bunyad-admin'),
					'icon'  => 'fa fa-plug'
				]
			);
		});

		// Add assets for the editor.
		add_action('elementor/editor/after_enqueue_scripts', function() {
			wp_enqueue_script(
				'bunyad-elementor-editor', 
				SmartMag_Core::instance()->path_url . 'inc/elementor/js/elementor-editor.js',
				['jquery', 'wp-api-request'], 
				SmartMag_Core::VERSION, 
				true
			);

			wp_enqueue_style(
				'bunyad-elementor-editor', 
				SmartMag_Core::instance()->path_url . 'inc/elementor/css/elementor-editor.css',
				[],
				SmartMag_Core::VERSION
			);
		});

		// Preview only assets.
		add_action('elementor/preview/enqueue_scripts', [$this, 'register_preview_assets']);

		/**
		 * Extend Section Element.
		 */

		// Add section query section after layout section.
		add_action('elementor/element/section/section_layout/after_section_end', [$this, 'add_section_query_controls'], 10, 2);

		// Add extra sections after specific existing sections.
		add_action('elementor/element/after_section_end', [$this, 'section_extra_sections'], 10, 2);

		// Add extra controls for the section element, in several sections.
		add_action('elementor/element/before_section_end', [$this, 'section_extra_controls'], 10, 2);

		// Add render attributes for gutter.
		add_action('elementor/frontend/section/before_render', [$this, 'section_gutter_attr']);

		// Modify JS template for section
		add_action('elementor/section/print_template', [$this, 'section_modify_template']);

		/**
		 * Extend Column Element.
		 */
		// Extend the section in layout section.
		add_action('elementor/element/column/layout/after_section_start', function($section) {

			$section->add_control(
				'is_sidebar',
				[
					'label'       => esc_html__('Is Sidebar?', 'bunyad-admin'),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'description' => esc_html__('Check if this column is a sidebar.', 'bunyad-admin'),
					//'separator'   => 'before',
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'main-sidebar',
					'condition'    => ['is_main' => '']
				]
			);

			$section->add_control(
				'sidebar_sticky',
				[
					'label'       => esc_html__('Sticky Sidebar', 'bunyad-admin'),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'description' => esc_html__('Check if this column is a sidebar.', 'bunyad-admin'),
					//'separator'   => 'before',
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'main-sidebar ts-sticky-col',
					'condition'    => ['is_sidebar!' => '']
				]
			);

			$section->add_control(
				'is_main',
				[
					'label'       => esc_html__('Is Main Column', 'bunyad-admin'),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'description' => esc_html__('Check if this column is adjacent to a sidebar.', 'bunyad-admin'),
					//'separator'   => 'before',
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'main-content',
					'condition'    => ['is_sidebar' => '']
				]
			);

			$section->add_control(
				'add_separator',
				[
					'label'       => esc_html__('Add Separator', 'bunyad-admin'),
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'description' => esc_html__('Add a separator line.', 'bunyad-admin'),
					//'separator'   => 'before',
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'el-col-sep',
				]
			);


			$section->add_responsive_control(
				'column_order',
				[
					'label'       => esc_html__('Column Order', 'bunyad-admin'),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'description' => esc_html__('Rearrange columns by setting order for each.', 'bunyad-admin'),
					'default'      => [],
					'selectors'    => [
						'{{WRAPPER}}' => 'order: {{VALUE}};'
					]
				]
			);
		});

		// Add extra controls for the section element, in several sections.
		add_action('elementor/element/before_section_end', [$this, 'text_editor_extra_controls'], 10, 2);

		/**
		 * Add post-content class to text widget.
		 */
		// add_filter('elementor/widget/print_template', function($content, $element) {
		// 	if ($element->get_name() !== 'text-editor') {
		// 		return $content;
		// 	}
			
		// 	return "<# view.addRenderAttribute( 'editor', 'class', ['post-content'] ); #>\n" . $content;
			
		// }, 10, 2);

		// add_action('elementor/widget/before_render_content', function($element) {
		// 	if ($element->get_name() !== 'text-editor') {
		// 		return;
		// 	}

		// 	$element->add_render_attribute(
		// 		'_wrapper', 'class', [
		// 			'elementor-widget',
		// 			'elementor-widget-text-editor',
		// 			'post-content'
		// 		]
		// 	);

		// 	// $element->add_render_attribute('editor', 'class', ['post-content']);
		// });

		/**
		 * Cleanup.
		 */
		// Cleanup templates library.
		add_filter('option_elementor_remote_info_library', function($data) {
			if (defined('ELEMENTOR_PRO_VERSION')) {
				return $data;
			}

			if (isset($data['templates'])) {
				$data['templates'] = array_filter($data['templates'], function($item) {
					return !$item['is_pro'];
				});
			}

			return $data;
		});
		
		add_filter('elementor/frontend/admin_bar/settings', function($config) {
			if (defined('ELEMENTOR_PRO_VERSION')) {
				return $config;
			}

			if (isset($config['elementor_edit_page']['children'])) {
				$config['elementor_edit_page']['children'] = array_filter(
					$config['elementor_edit_page']['children'],
					function($value) {
						return (
							empty($value['id']) 
							|| !in_array($value['id'], ['elementor_app_site_editor', 'elementor_site_settings'])
						);
					}
				);	
			}

			return $config;
		}, 999);
		
		// Ensure our kit exists.
		add_action('elementor/init', [$this, 'init_smartmag_kit']);

		// Initialize page related settings.
		new Elementor\PageSettings;

		// Unnecessary redirect on plugin activation.
		add_action('admin_init', function() {
			if (get_transient('elementor_activation_redirect')) {
				delete_transient('elementor_activation_redirect');
			}
		}, -1);

		// Dev notices, comeon. Disable.
		add_filter('elementor/core/admin/notices', function($notices) {
			foreach ($notices as $key => $notice) {
				if (is_a($notice, 'Elementor\Core\Admin\Notices\Elementor_Dev_Notice')) {
					unset($notices[$key]);
				}
			}

			return $notices;
		});

		// Check conflict with Bunyad Page Builder.
		add_action('admin_init', function() {
			if (is_plugin_active('bunyad-siteorigin-panels/bunyad-siteorigin-panels.php')) {
				add_action('admin_notices', [$this, 'notice_bunyad_builder']);
			}
		});
	}

	/**
	 * Setup our style kit.
	 */
	public function init_smartmag_kit()
	{
		if (!is_admin() || wp_doing_ajax() || !is_user_logged_in()) {
			return;
		}

		$kits_manager = Plugin::$instance->kits_manager;
		if (!$kits_manager || !is_callable([$kits_manager, 'get_active_kit'])) {
			return;
		}

		$active = $kits_manager->get_active_kit();
		if (!is_callable([$active, 'get_post'])) {
			return;
		}
		
		$active_kit = $active->get_post();
		if (strpos($active_kit->post_name, 'smartmag-kit') !== false) {
			return;
		}

		// Create the kit.
		if (is_callable([Plugin::$instance->documents, 'create'])) {
			$new_settings = [
				'viewport_lg' => 940,
				'container_width' => [
					'unit' => 'px',
					'size' => 1200,
					'sizes' => []
				],
				'container_width_tablet' => [
					'unit' => 'px',
					'size' => 940,
					'sizes' => []
				],
				'system_colors' => [[
					'_id' => 'smartmag-main',
					'title' => 'SmartMag Main',
					'color' => 'var(--c-main)',
				]]
			];

			$kit = Plugin::$instance->documents->create('kit', [
				'post_type'   => 'elementor_library',
				'post_title'  => 'SmartMag Kit',
				'post_name'   => 'smartmag-kit',
				'post_status' => 'publish'
			]);

			if (!$kit || !is_callable([$kit, 'get_settings'])) {
				return;
			}

			$settings = $kit->get_settings();
			$new_settings['system_colors'] = array_merge(
				$new_settings['system_colors'],
				$settings['system_colors']
			);

			// Font-families should be inherited from the theme.
			$new_settings['system_typography'] = array_map(
				function($typography) {
					foreach ($typography as $key => $value) {
						if ($key !== 'typography_font_family') {
							continue;
						}

						unset($typography[$key]);
					}

					return $typography;
				}, 
				$settings['system_typography']
			);

			if (is_callable([$kit, 'update_settings']) && is_callable([$kit, 'get_id'])) {
				$kit->update_settings($new_settings);
				update_option('elementor_active_kit', $kit->get_id());
			}
		}
	}

	/**
	 * Register assets only for the Elementor preview.
	 */
	public function register_preview_assets()
	{
		// Registered a bit later.
		add_action('bunyad_register_assets', function() {
			// Make slick slider always available.
			wp_enqueue_script('smartmag-slick');
		});

		// Register front-end script for widgets.
		wp_enqueue_script(
			'bunyad-elementor-preview',
			SmartMag_Core::instance()->path_url . 'js/elementor/preview.js',
			['elementor-frontend', 'smartmag-theme'],
			SmartMag_Core::VERSION, 
			true
		);
	}

	/**
	 * Register blocks as widgets for Elementor
	 */
	public function register_widgets()
	{
		// Load the class map to prevent unnecessary autoload to save resources
		include_once SmartMag_Core::instance()->path . 'inc/elementor/classmap-widgets.php';

		// Widgets to load
		$blocks = apply_filters('bunyad_elementor_widgets', []);
		
		foreach ($blocks as $block) {
			
			$class = 'Bunyad\Blocks\\' . $block . '_Elementor';

			\Elementor\Plugin::instance()->widgets_manager
				->register_widget_type(
					new $class
				);
		}
	}

	public function register_controls()
	{
		$manager = \Elementor\Plugin::$instance->controls_manager;
		$manager->register_control(
			'bunyad-selectize',
			new Elementor\Controls\Selectize
		);
	}

	public function add_section_query_controls($section, $args)
	{
		// This is required class.
		if (!class_exists('\Bunyad\Blocks\Base\LoopOptions')) {
			return;
		}

		$options_obj = new SectionOptions;
		$sections    = [
			'sec-query' => [
				'label' => esc_html__('Section Query', 'bunyad-admin'),
				'tab'   => $args['tab']
			]
		];

		LoopWidget::do_register_controls($section, $options_obj, $sections);
	}

	/**
	 * Add extra sections after other sections.
	 *
	 * @param \Elementor\Element_Base $section
	 * @param string $section_id
	 * @return void
	 */
	public function section_extra_sections($section, $section_id)
	{
		if (!method_exists($section, 'get_type') || $section->get_type() !== 'section') {
			return;
		}

		/**
		 * Dark Background section.
		 */
		if ($section_id === 'section_background') {

			$section->start_controls_section(
				'section_background_sd',
				[
					'label' => esc_html__('Dark Mode: Background', 'bunyad-admin'),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$section->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  => 'background_sd',
					'types' => ['classic', 'gradient'],
					'fields_options' => [
						'background' => [
							'frontend_available' => true,
						],
					],
					'selector' => '.s-dark {{WRAPPER}}',
				]
			);

			$section->end_controls_section();
		}

		/**
		 * Dark Border section.
		 */
		if ($section_id === 'section_border') {

			$section->start_controls_section(
				'section_border_sd',
				[
					'label' => esc_html__('Dark Mode: Border', 'bunyad-admin'),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$section->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name'     => 'border_sd',
					'selector' => '.s-dark {{WRAPPER}}',
				]
			);

			$section->end_controls_section();
		}
	}

	/**
	 * Add extra controls to the sections.
	 *
	 * @param \Elementor\Element_Base $section
	 * @param string $section_id
	 * @return void
	 */
	public function section_extra_controls($section, $section_id)
	{
		if (!method_exists($section, 'get_type') || $section->get_type() !== 'section') {
			return;
		}

		/**
		 * Layout section controls.
		 * 
		 * @todo Move to SectionsOptions class where possible.
		 */
		if ($section_id === 'section_layout') {
			$section->add_control(
				'is_full_xs',
				[
					'label'       => esc_html__('Full-width on Mobile?', 'bunyad-admin'),
					'description' => '',
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'is-full-xs',
				],
				[
					'position'    => [
						'at' => 'before',
						'of' => 'gap'
					]
				]
			);

			$section->add_control(
				'gutter',
				[
					'label'       => esc_html__('Space Between Columns (Vertical)', 'bunyad-admin'),
					'type'        => 'select',
					'description' => esc_html__('This is different from Gap as it only applies vertically between columns excluding the left-most and right-most column.. Gap applies in both directions and also at beginning and end..', 'bunyad-admin'),
					'options'     => [
						'default' => esc_html__('Default Spacing', 'bunyad-admin'),
						'none'    => esc_html__('None', 'bunyad-admin'),
						'sm'      => esc_html__('Small Spacing', 'bunyad-admin'),
						'lg'      => esc_html__('Large Spacing', 'bunyad-admin'),
						'xlg'     => esc_html__('Wide Spacing', 'bunyad-admin'),
					],
					'label_block' => true,
					//'separator'   => 'before',
	
					// Keeping default to none for elementor imports.
					'default'     => 'none',
				],
				[
					'position'    => [
						'at' => 'before', 
						'of' => 'gap'
					]
				]
			);
		}
	}

	/**
	 * Hook Callback: Add gutter attributes for section
	 * 
	 * @param \Elementor\Element_Section $section
	 */
	public function section_gutter_attr($section) 
	{

		if (!is_callable([$section, 'add_render_attribute'])) {
			return;
		}

		$spacing = $section->get_settings('gutter');
		if ($spacing && $spacing !== 'none') {
			$section->add_render_attribute(
				'_wrapper',
				'class',
				[
					'has-el-gap',
					'el-gap-' . $spacing,
				]
			);
		}
	}

	/**
	 * Hook Callback: Modify the content_template output for section
	 */
	public function section_modify_template($content)
	{
		ob_start();
		?>
			<# 
			if (view && view.$el) {
				view.$el.removeClass('has-el-gap el-gap-default el-gap-sm el-gap-lg el-gap-xlg');

				if (settings.gutter && settings.gutter !== 'none') {
					view.$el.addClass('has-el-gap el-gap-' + settings.gutter);
				}
			}
			#>
		<?php

		return ob_get_clean() . $content;
	}

	/**
	 * Add extra controls to the text editor widget.
	 *
	 * @param \Elementor\Element_Base $section
	 * @param string $section_id
	 * @return void
	 */
	public function text_editor_extra_controls($element, $section_id)
	{
		if (!method_exists($element, 'get_name') || $element->get_name() !== 'text-editor') {
			return;
		}

		/**
		 * Add extra controls.
		 */
		if ($section_id === 'section_editor') {
			$element->add_control(
				'theme_content_style',
				[
					'label'       => esc_html__('Theme Content Style', 'bunyad-admin'),
					'description' => '',
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'prefix_class' => '',
					'return_value' => 'post-content',
				],
				[
					'position' => [
						'at' => 'after',
						'of' => 'editor'
					]
				]
			);
		}

		if ($section_id === 'section_style') {
			$element->add_control(
				'text_color_sd',
				[
					'label' => esc_html__('Dark: Text Color', 'bunyad-admin'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'.s-dark {{WRAPPER}}' => 'color: {{VALUE}};',
					],
				],
				[
					'position' => [
						'at' => 'after',
						'of' => 'text_color'
					]
				]
			);	
		}
	}

	/**
	 * Admin notice for bunyad builder conflict.
	 */
	public function notice_bunyad_builder()
	{
		$message = 'As of SmartMag v5+, <strong>Bunyad Page Builder</strong> is no longer needed and conflicts with Elementor. Please deactivate.';
		printf(
			'<div class="notice notice-error"><h3>Important:</h3><p>%1$s</p></div>',
			wp_kses_post($message)
		);
	}
}