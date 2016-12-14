<?php
namespace WebApps\WPDL\Admin;

/**
* Handle all admin menu
*
* @since 0.0.1
*/
class Admin_Menu {

    /**
     * Autometically loaded when class initiate
     *
     * @since 0.0.1
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 99 );
    }

    /**
     * Initializes the Admin_Menu() class
     *
     * @since 0.0.1
     *
     * Checks for an existing Admin_Menu() instance
     * and if it doesn't find one, creates it.
     *
     * @return $instance [plugin main instance]
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new \WebApps\WPDL\Admin\Admin_Menu();
        }

        return $instance;
    }


    /**
    * Register all menu
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function admin_menu() {
        $position = apply_filters( 'wpdl_menu_position', 27 );

        add_menu_page( __( 'WP Directory', WPDL_LISTING_TEXTDOMAIN ), __( 'WP Directory', WPDL_LISTING_TEXTDOMAIN ), 'manage_options', 'wp-directory-listing', array( $this, 'directory' ), 'dashicons-feedback', $position );

        add_submenu_page( 'wp-directory-listing', __( 'Forms', WPDL_LISTING_TEXTDOMAIN ), __( 'Forms', WPDL_LISTING_TEXTDOMAIN ), 'manage_options', 'wp-directory-listing-forms', array( $this, 'form_page' ) );
        // add_submenu_page( 'erp-company', __( 'Tools', WPDL_LISTING_TEXTDOMAIN ), __( 'Tools', WPDL_LISTING_TEXTDOMAIN ), 'manage_options', 'erp-tools', array( $this, 'tools_page' ) );
        do_action( 'wpdl_load_menu', $position );
    }

    /**
    * WP Directory listing menu cb
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function directory() {
        echo 'Hello Directory main page';
    }

    /**
    * Forms page callback
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function form_page() {
        $sections = !empty( $_GET['section'] ) ? $_GET['section'] : '';

        switch ( $sections ) {
            case 'form-builder':
                include WPDL_LISTING_VIEWS . '/forms/builder.php';
                break;

            default:
                include WPDL_LISTING_VIEWS . '/forms/listing.php';
                break;
        }
    }

    /**
    * Settings page cb
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function settings_page() {
        $settings = \WebApps\WPDL\Admin\Settings::init();
        $settings->plugin_page();
    }
}