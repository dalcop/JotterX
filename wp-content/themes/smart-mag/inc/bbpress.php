<?php
/**
 * Setup BBPress compatibility for the theme
 *
 */
class Bunyad_Theme_BBPress 
{
	
	public function __construct()
	{
		// Is bbPress active?
		if (!class_exists('bbpress')) {
			return;
		}
		
		add_action('bunyad_theme_init', array($this, 'init'));	
	} 
	
	/**
	 * Setup bbPress hooks
	 */
	public function init()
	{
		// Register support
		add_theme_support('bbpress');

		add_action('wp', [$this, 'change_sidebar']);
	}

	public function change_sidebar()
	{
		if (!function_exists('is_bbpress') || !is_bbpress()) {
			return;
		}

		// Change sidebar for shop page.
		if (is_active_sidebar('smartmag-bbpress')) {
			Bunyad::registry()->sidebar = 'smartmag-bbpress';
		}
	}
}

// init and make available in Bunyad::get('blocks')
Bunyad::register('bbpress', array(
	'class' => 'Bunyad_Theme_BBPress',
	'init' => true
));