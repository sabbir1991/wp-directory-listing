<?php
namespace WebApps\WPDL;

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

    }

    /**
    * Regsiter all styles
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function register_styles() {

    }

    /**
    * Enqueue all scripts
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function enqueue_scripts() {
        # code...
    }

    /**
    * Enqueue all styles
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function enqueue_styles() {

    }

}
