<?php
namespace WebApps\WPDL\Admin;

/**
* Class for loaded admin scripts
*
* @since 0.0.1
*/
class Scripts {

    /**
     * Script and style suffix
     *
     * @var string
     */
    protected $suffix;

    /**
     * Script version number
     *
     * @var integer
     */
    protected $version;

    /**
     * Load autometically when class initiate
     *
     * @since 0.0.1
     */
    public function __construct() {
        $this->suffix  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        $this->version = '20150315';

        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'admin_enqueue_scripts', [ $this, 'scripts_handler' ] );
    }

    /**
     * Initializes the Scripts() class
     *
     * @since 0.0.1
     *
     * Checks for an existing Scripts() instance
     * and if it doesn't find one, creates it.
     *
     * @return $instance [plugin main instance]
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new \WebApps\WPDL\Admin\Scripts();
        }

        return $instance;
    }

    /**
     * Hangle all scripts
     *
     * @since  0.0.1
     *
     * @return void
     */
    public function scripts_handler() {
        $this->register_scripts();
        $this->register_styles();

        $this->enqueue_scripts();
        $this->enqueue_styles();
    }

    /**
     * Initialize plugin for localization
     *
     * @since 0.0.1
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wpdl', false, dirname( plugin_dir_path( WPDL_LISTING_FILE ) ) . 'languages/' );
    }

    /**
    * Register all scripts
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function register_scripts() {
        $vendor = WPDL_LISTING_ASSETS . '/vendor';
        $js     = WPDL_LISTING_ASSETS . '/js';

        wp_register_script( 'wpdl-admin-script', $js . '/wpdl-admin' . $this->suffix . '.js', array( 'jquery', 'underscore', 'wp-util' ), $this->version, true );
    }

    /**
    * Regsiter all styles
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function register_styles() {
        $vendor = WPDL_LISTING_ASSETS . '/vendor';
        $css    = WPDL_LISTING_ASSETS . '/css';

        wp_register_style( 'wpdl-admin-styles', $css . '/admin.css', false, $this->version );
    }

    /**
    * Enqueue all scripts
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function enqueue_scripts() {
        wp_enqueue_script( 'wpdl-admin-script' );
        // $translation_array = array( 'some_string' => __( 'Some string to translate', 'wpdl' ), 'a_value' => '10' );
        // wp_localize_script( 'base-plugin-scripts', 'wpdl', $translation_array ) );
    }

    /**
    * Enqueue all styles
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function enqueue_styles() {
        wp_enqueue_style( 'wpdl-admin-styles' );
    }

}
