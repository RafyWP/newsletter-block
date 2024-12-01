<?php
class LeadsCF {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_lead_info_metabox' ) );
        add_action( 'save_post', array( $this, 'save_lead_info' ), 10, 2 );
        add_filter( 'manage_edit-nb_lead_columns', array( $this, 'add_custom_columns' ) );
        add_action( 'manage_nb_lead_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
        add_filter( 'manage_edit-nb_lead_sortable_columns', array( $this, 'make_stages_column_sortable' ) );
        add_action( 'pre_get_posts', array( $this, 'sort_by_stages' ) );
    }

    public function add_lead_info_metabox() {
        add_meta_box(
            'lead_info',
            __( 'Lead Info', 'newsletter-block' ),
            array( $this, 'render_metabox' ),
            'nb_lead',
            'normal',
            'high'
        );
    }

    public function render_metabox( $post ) {
        wp_nonce_field( 'save_lead_info', 'lead_info_nonce' );

        $nb_email = get_post_meta( $post->ID, '_nb_email', true );
        $nb_source = get_post_meta( $post->ID, '_nb_source', true );

        echo '<table class="form-table">';
        
        echo '<tr>';
        echo '<th><label for="nb_email">' . __( 'Email', 'newsletter-block' ) . '</label></th>';
        echo '<td><input type="email" id="nb_email" name="nb_email" value="' . esc_attr( $nb_email ) . '" class="regular-text" /></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th><label for="nb_source">' . __( 'Source', 'newsletter-block' ) . '</label></th>';
        echo '<td><input type="text" id="nb_source" name="nb_source" value="' . esc_attr( $nb_source ) . '" class="regular-text" /></td>';
        echo '</tr>';

        echo '</table>';
    }

    public function save_lead_info( $post_id, $post ) {
        if ( ! isset( $_POST['lead_info_nonce'] ) || ! wp_verify_nonce( $_POST['lead_info_nonce'], 'save_lead_info' ) ) {
            return $post_id;
        }

        if ( $post->post_type !== 'nb_lead' ) {
            return $post_id;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        if ( isset( $_POST['nb_email'] ) ) {
            update_post_meta( $post_id, '_nb_email', sanitize_email( $_POST['nb_email'] ) );
        }

        if ( isset( $_POST['nb_source'] ) ) {
            update_post_meta( $post_id, '_nb_source', sanitize_text_field( $_POST['nb_source'] ) );
        }
    }

    public function add_custom_columns( $columns ) {
        unset( $columns['title'] );
        
        $columns['date'] = __( 'Registration', 'newsletter-block' );
        $columns['stages'] = __( 'Stage', 'newsletter-block' );
        $columns['email'] = __( 'Email', 'newsletter-block' );
        $columns['source'] = __( 'Source', 'newsletter-block' );
        
        return $columns;
    }

    public function render_custom_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'stages':
                $stages = get_the_terms( $post_id, 'stages' );
                if ( ! empty( $stages ) ) {
                    echo esc_html( $stages[0]->name );
                }
                break;

            case 'email':
                $email = get_post_meta( $post_id, '_nb_email', true );
                echo esc_html( $email );
                break;

            case 'source':
                $source = get_post_meta( $post_id, '_nb_source', true );
                echo esc_html( $source );
                break;
        }
    }

    public function make_stages_column_sortable( $columns ) {
        $columns['stages'] = 'stages';
        return $columns;
    }

    public function sort_by_stages( $query ) {
        if ( is_admin() && $query->is_main_query() && 'nb_lead' === $query->get( 'post_type' ) ) {
            if ( 'stages' === $query->get( 'orderby' ) ) {
                $query->set( 'orderby', 'term_order' );
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'stages',
                        'field'    => 'slug',
                        'terms'    => array( 'stages' ),
                        'operator' => 'IN',
                    ),
                ));
            }
        }
    }
}
