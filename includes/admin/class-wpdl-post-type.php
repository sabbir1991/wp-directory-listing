<?php
namespace WebApps\WPDL\Admin;

/**
* Regsiter all post type and taxonomy class
*
* @since 1.0.0
*/
class Post_Type {

    /**
     * Post type name
     *
     * @var string
     */
    private $post_type = 'wpdl_listing';


    /**
     * Autometically loaded when class initiate
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', [ $this, 'load_post_type' ], 10 );
    }

    /**
     * Initializes the Admin_Menu() class
     *
     * @since 1.0.0
     *
     * Checks for an existing Admin_Menu() instance
     * and if it doesn't find one, creates it.
     *
     * @return $instance [plugin main instance]
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new \WebApps\WPDL\Admin\Post_Type();
        }

        return $instance;
    }

    /**
    * Register a post type for listing
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function load_post_type() {
        $capability = 'manage_options';

        if ( current_theme_supports( 'wpdl-listing-templates' ) ) {
            $has_archive = _x( 'wpdl-listings', 'Post type archive slug - resave permalinks after changing this', WPDL_LISTING_TEXTDOMAIN );
        } else {
            $has_archive = false;
        }

        $labels = apply_filters( 'wpdl_post_type_labels', array(
            'name'               => __( 'Listing', WPDL_LISTING_TEXTDOMAIN ),
            'singular_name'      => __( 'Listing', WPDL_LISTING_TEXTDOMAIN ),
            'menu_name'          => __( 'Listings', WPDL_LISTING_TEXTDOMAIN ),
            'add_new'            => __( 'Add Listing', WPDL_LISTING_TEXTDOMAIN ),
            'add_new_item'       => __( 'Add New Listing', WPDL_LISTING_TEXTDOMAIN ),
            'edit'               => __( 'Edit', WPDL_LISTING_TEXTDOMAIN ),
            'edit_item'          => __( 'Edit Listing', WPDL_LISTING_TEXTDOMAIN ),
            'new_item'           => __( 'New Listing', WPDL_LISTING_TEXTDOMAIN ),
            'view'               => __( 'View Listing', WPDL_LISTING_TEXTDOMAIN ),
            'view_item'          => __( 'View Listing', WPDL_LISTING_TEXTDOMAIN ),
            'search_items'       => __( 'Search Listing', WPDL_LISTING_TEXTDOMAIN ),
            'not_found'          => __( 'No Listing Found', WPDL_LISTING_TEXTDOMAIN ),
            'not_found_in_trash' => __( 'No Listing found in trash', WPDL_LISTING_TEXTDOMAIN ),
            'parent'             => __( 'Parent Listing', WPDL_LISTING_TEXTDOMAIN )
        ) );

        register_post_type( $this->post_type, array(
            'label'               => apply_filters( 'wpdl_listing_post_type_name', __( 'Listing', WPDL_LISTING_TEXTDOMAIN ) ),
            'description'         => sprintf( __( 'This is where you can create and manage listings.', WPDL_LISTING_TEXTDOMAIN ) ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'rewrite'             => array(
                                        'slug'       => _x( 'wpdl-listing', 'Listing permalink - resave permalinks after changing this', WPDL_LISTING_TEXTDOMAIN ),
                                        'feeds'      => true,
                                        'pages'      => false,
                                        'with_front' => false,
                                    ),
            'query_var'           => true,
            'has_archive'           => $has_archive,
            'supports'            => array( 'title', 'editor', 'custom-fields', 'publicize', 'thumbnail' ),
            'capabilities'        => array(
                'edit_post'          => $capability,
                'read_post'          => $capability,
                'delete_posts'       => $capability,
                'edit_posts'         => $capability,
                'edit_others_posts'  => $capability,
                'publish_posts'      => $capability,
                'read_private_posts' => $capability,
                'create_posts'       => $capability,
                'delete_post'        => $capability,
            ),
            'labels'          => $labels
        ) );
    }
}