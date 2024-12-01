<?php
class LeadsCPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register_leads_cpt' ) );
    }

    public function register_leads_cpt() {
        $labels = array(
            'name'                  => __( 'Leads', 'newsletter-block' ),
            'singular_name'         => __( 'Lead', 'newsletter-block' ),
            'menu_name'             => __( 'Leads', 'newsletter-block' ),
            'name_admin_bar'        => __( 'Lead', 'newsletter-block' ),
            'add_new'               => __( 'Add New', 'newsletter-block' ),
            'add_new_item'          => __( 'Add New Lead', 'newsletter-block' ),
            'new_item'              => __( 'New Lead', 'newsletter-block' ),
            'edit_item'             => __( 'Edit Lead', 'newsletter-block' ),
            'view_item'             => __( 'View Lead', 'newsletter-block' ),
            'all_items'             => __( 'All Leads', 'newsletter-block' ),
            'search_items'          => __( 'Search Leads', 'newsletter-block' ),
            'parent_item_colon'     => __( 'Parent Leads:', 'newsletter-block' ),
            'not_found'             => __( 'No leads found.', 'newsletter-block' ),
            'not_found_in_trash'    => __( 'No leads found in Trash.', 'newsletter-block' ),
            'featured_image'        => __( 'Lead Image', 'newsletter-block' ),
            'set_featured_image'    => __( 'Set lead image', 'newsletter-block' ),
            'remove_featured_image' => __( 'Remove lead image', 'newsletter-block' ),
            'use_featured_image'    => __( 'Use as lead image', 'newsletter-block' ),
            'archives'              => __( 'Lead Archives', 'newsletter-block' ),
            'insert_into_item'      => __( 'Insert into lead', 'newsletter-block' ),
            'uploaded_to_this_item' => __( 'Uploaded to this lead', 'newsletter-block' ),
            'filter_items_list'     => __( 'Filter leads list', 'newsletter-block' ),
            'items_list_navigation' => __( 'Leads list navigation', 'newsletter-block' ),
            'items_list'            => __( 'Leads list', 'newsletter-block' ),
        );
        
        $args = array(
            'labels'              => $labels,
            'description'         => __( 'Manage the leads collected from newsletter forms', 'newsletter-block' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_rest'        => true,
            'supports'            => array( 'title', 'editor', 'custom-fields' ),
            'hierarchical'        => false,
            'rewrite'             => array( 'slug' => 'lead' ),
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'menu_position'       => 24,
            'menu_icon'           => 'dashicons-email-alt2',
            'capability_type'     => 'post',
            'has_archive'         => true,
            'exclude_from_search' => true,
        );

        register_post_type( 'nb_lead', $args );
    }
}
