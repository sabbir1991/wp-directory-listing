<?php
namespace WebApps\WPDL\Admin;

/**
 * WPDL settings sections
 *
 * @since 0.0.1
 */
class Settings {

    private $settings_api;

    /**
     * Autometically load when class initiate
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function __construct() {
        $this->settings_api = new \WebApps\WPDL\Admin\Settings_API();

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'wpdl_load_menu', array($this, 'admin_menu') );
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new \WebApps\WPDL\Admin\Settings();
        }

        return $instance;
    }

    /**
     * Admin init callback
     *
     * @since  0.0.1
     *
     * @return void
     */
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
    * name
    *
    * @since 0.0.1
    *
    * @return void
    **/
    public function admin_menu() {
        add_submenu_page( 'wp-directory-listing', __( 'Settings', WPDL_LISTING_TEXTDOMAIN ), __( 'Settings', WPDL_LISTING_TEXTDOMAIN ), 'manage_options', 'wp-directory-listing-settings', array( $this, 'plugin_page' ) );
    }

    /**
     * Get all setting sections
     *
     * @since  0.0.1
     *
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wpdl_basics',
                'title' => __( 'Basic Settings', 'wedevs' )
            ),
            array(
                'id'    => 'wpdl_advanced',
                'title' => __( 'Advanced Settings', 'wedevs' )
            )
        );

        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @since 0.0.1
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wpdl_basics' => array(
                array(
                    'name'              => 'number_input',
                    'label'             => __( 'Number Input', 'wedevs' ),
                    'desc'              => __( 'Number field with validation callback `floatval`', 'wedevs' ),
                    'placeholder'       => __( '1.99', 'wedevs' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '0.01',
                    'type'              => 'number',
                    'default'           => '0',
                    'sanitize_callback' => 'floatval'
                )
            ),
            'wpdl_advanced' => array(
                array(
                    'name'    => 'color',
                    'label'   => __( 'Color', 'wedevs' ),
                    'desc'    => __( 'Color description', 'wedevs' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'name'    => 'password',
                    'label'   => __( 'Password', 'wedevs' ),
                    'desc'    => __( 'Password description', 'wedevs' ),
                    'type'    => 'password',
                    'default' => ''
                ),
                array(
                    'name'    => 'wysiwyg',
                    'label'   => __( 'Advanced Editor', 'wedevs' ),
                    'desc'    => __( 'WP_Editor description', 'wedevs' ),
                    'type'    => 'wysiwyg',
                    'default' => ''
                ),
                array(
                    'name'    => 'multicheck',
                    'label'   => __( 'Multile checkbox', 'wedevs' ),
                    'desc'    => __( 'Multi checkbox description', 'wedevs' ),
                    'type'    => 'multicheck',
                    'default' => array('one' => 'one', 'four' => 'four'),
                    'options' => array(
                        'one'   => 'One',
                        'two'   => 'Two',
                        'three' => 'Three',
                        'four'  => 'Four'
                    )
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'WP Directory Settings', WPDL_LISTING_TEXTDOMAIN ); ?></h1>

            <?php if ( isset( $_GET['page'] ) && $_GET['page'] == 'wp-directory-listing-settings' && isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ): ?>
                <div id="message" class="updated notice notice-success is-dismissible">
                    <p><?php _e( 'Settings Updated', WPDL_LISTING_TEXTDOMAIN ); ?></p>
                    <button type="button" class="notice-dismiss">
                        <span class="screen-reader-text"><?php _e( 'Dismiss this notice.', WPDL_LISTING_TEXTDOMAIN ) ?></span>
                    </button>
                </div>
            <?php endif ?>
            <?php
                $this->settings_api->show_navigation();
                $this->settings_api->show_forms();
            ?>
        </div>
        <?php
    }

    /**
     * Get all the pages
     *
     * @since 0.0.1
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}