<?php
/*
Plugin Name: WP Directory Listing
Plugin URI: http://web-apps.ninja/
Description: An ultimate business directory WordPress plugin for managing all kind of listings
Version: 0.0.1
Author: 03Digital
Author URI: http://web-apps.ninja/
License: GPL2
*/

/**
 * Copyright (c) YEAR 03Digital (email: dev.wpress@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * WPDL_Listing class
 *
 * @class WPDL_Listing The class that holds the entire WPDL_Listing plugin
 */
class WPDL_Listing {

    /**
     * Constructor for the WPDL_Listing class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @since 0.0.1
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses is_admin()
     * @uses add_action()
     *
     * @return void [don't expect anyting]
     */
    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        // Define all constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // instantiate classes
        $this->instantiate();

        do_action( 'wpdl_loaded' );
    }

    /**
     * Initializes the WPDL_Listing() class
     *
     * Checks for an existing WPDL_Listing() instance
     * and if it doesn't find one, creates it.
     *
     * @return $instance [plugin main instance]
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPDL_Listing();
        }

        return $instance;
    }

    /**
     * Placeholder for activation function
     *
     * @return 0.0.1
     */
    public function activate() {

    }

    /**
     * Placeholder for deactivation function
     *
     * @return void
     */
    public function deactivate() {

    }

    /**
     * Define all constants
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function define_constants() {
        define( 'WPDL_LISTING_VERSION', '0.0.1' );
        define( 'WPDL_LISTING_TEXTDOMAIN', 'wpdl' );
        define( 'WPDL_LISTING_FILE', __FILE__ );
        define( 'WPDL_LISTING_PATH', dirname( WPDL_LISTING_FILE ) );
        define( 'WPDL_LISTING_INCLUDES', WPDL_LISTING_PATH . '/includes' );
        define( 'WPDL_LISTING_URL', plugins_url( '', WPDL_LISTING_FILE ) );
        define( 'WPDL_LISTING_ASSETS', WPDL_LISTING_URL . '/assets' );
    }

    /**
     * Includes all files
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function includes() {
        include dirname( WPDL_LISTING_FILE ) . '/vendor/autoload.php';
    }

    /**
     * Instantiate all necessaru classes
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function instantiate() {
        \WebApps\WPDL\Scripts::init();
    }

} // WPDL_Listing

add_action( 'plugins_loaded', 'wpdl_plugin_loaded', 90 );

function wpdl_plugin_loaded() {
    $wpdl = \WPDL_Listing::init();
}