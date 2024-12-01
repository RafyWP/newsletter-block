<?php
class StagesTax {
    public function __construct() {
        add_action( 'init', array( $this, 'register_stages_taxonomy' ) );
    }

    public function register_stages_taxonomy() {
        $labels = array(
            'name'              => __( 'Stages', 'newsletter-block' ),
            'singular_name'     => __( 'Stage', 'newsletter-block' ),
            'search_items'      => __( 'Search Stages', 'newsletter-block' ),
            'all_items'         => __( 'All Stages', 'newsletter-block' ),
            'parent_item'       => __( 'Parent Stage', 'newsletter-block' ),
            'parent_item_colon' => __( 'Parent Stage:', 'newsletter-block' ),
            'edit_item'         => __( 'Edit Stage', 'newsletter-block' ),
            'update_item'       => __( 'Update Stage', 'newsletter-block' ),
            'add_new_item'      => __( 'Add New Stage', 'newsletter-block' ),
            'new_item_name'     => __( 'New Stage Name', 'newsletter-block' ),
            'menu_name'         => __( 'Stages', 'newsletter-block' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => false,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'stage' ),
            'show_in_rest'      => true,
        );

        register_taxonomy( 'nb_stage', array( 'nb_lead' ), $args );
    }
}
