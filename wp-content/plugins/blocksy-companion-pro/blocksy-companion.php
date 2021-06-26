<?php

/*
Plugin Name: Blocksy Companion (Premium)
Description: This plugin is the companion for the Blocksy theme, it runs and adds its enhacements only if the Blocksy theme is installed and active.
Version: 1.8.6.1
Author: CreativeThemes
Author URI: https://creativethemes.com
Text Domain: blc
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

@fs_premium_only /framework/premium/
*/

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}


if ( function_exists( 'blc_fs' ) ) {
    blc_fs()->set_basename( true, __FILE__ );
} else {
    
    if ( !function_exists( 'blc_fs' ) ) {
        global  $blc_fs ;
        
        if ( !isset( $blc_fs ) ) {
            class BlocksyFsNull {

                public function is_registered() {
                    return true;
                }

                public function is__premium_only() {
                    return true;
                }

                public function is_plan() {
                    return true;
                }

                public function is_activation_mode() {
                    return true;
                }

                public function is_anonymous() {
                    return;
                }

                public function is_network_upgrade_mode() {
                    return;
                }

                public function connect_again() {
                    return;
                }

                public function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
                    add_filter( $tag, $function_to_add, $priority, $accepted_args );
                }

                public function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
                    add_action( $tag, $function_to_add, $priority, $accepted_args );
                }
            }

            $blc_fs = new BlocksyFsNull();

            function blc_fs()
            {
                global $blc_fs ;
                return $blc_fs;
            }
            
            blc_fs();
            do_action( 'blc_fs_loaded' );
        }
    
    }
    
    define( 'BLOCKSY__FILE__', __FILE__ );
    define( 'BLOCKSY_PLUGIN_BASE', plugin_basename( BLOCKSY__FILE__ ) );
    define( 'BLOCKSY_PATH', plugin_dir_path( BLOCKSY__FILE__ ) );
    define( 'BLOCKSY_URL', plugin_dir_url( BLOCKSY__FILE__ ) );
    add_action( 'init', function () {
        /**
         * Load Blocksy textdomain.
         *
         * Load gettext translate for Blocksy text domain.
         */
        load_plugin_textdomain( 'blc', false, dirname( BLOCKSY_PLUGIN_BASE ) . '/languages' );
    } );
    
    if ( !version_compare( PHP_VERSION, '7.0', '>=' ) ) {
        add_action( 'admin_notices', 'blc_fail_php_version' );
    } elseif ( !version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
        add_action( 'admin_notices', 'blc_fail_wp_version' );
    } else {
        require BLOCKSY_PATH . 'plugin.php';
    }
    
    /**
     * Blocksy admin notice for minimum PHP version.
     *
     * Warning when the site doesn't have the minimum required PHP version.
     */
    function blc_fail_php_version()
    {
        /* translators: %s: PHP version */
        $message = sprintf( esc_html__( 'Blocksy requires PHP version %s+, plugin is currently NOT RUNNING.', 'blc' ), '7.0' );
        $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
        echo  wp_kses_post( $html_message ) ;
    }
    
    /**
     * Blocksy admin notice for minimum WordPress version.
     *
     * Warning when the site doesn't have the minimum required WordPress version.
     */
    function blc_fail_wp_version()
    {
        /* translators: %s: WordPress version */
        $message = sprintf( esc_html__( 'Blocksy requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'blc' ), '5.0' );
        $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
        echo  wp_kses_post( $html_message ) ;
    }

}
