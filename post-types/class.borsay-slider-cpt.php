<?php

if ( ! class_exists( 'Borsay_Slider_Post_Type' ) ) {
    class Borsay_Slider_Post_Type {
        function __construct() {
            add_action( 'init', array( $this, 'create_post_type' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'save_post', array( $this, 'save_post' ) );
            add_filter( 'manage_borsay-slider_posts_columns', array( $this, 'borsay_slider_cpt_columns' ) );
            add_action( 'manage_borsay-slider_posts_custom_column', array(
                $this,
                'borsay_slider_custom_columns'
            ), 10, 2 );
            add_filter( 'manage_edit-borsay-slider_sortable_columns', array(
                $this,
                'borsay_slider_sortable_columns'
            ) );
            //  add_filter( 'manage_edit-borsay-slider_sortable_columns', array( $this, 'borsay_slider_sortable_columns' ) );

        }

        public function create_post_type(): void {
            register_post_type(
                'borsay-slider',
                array(
                    'label'               => 'Slider',
                    'description'         => 'Sliders',
                    'labels'              => array(
                        'name'          => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public'              => true,
                    'supports'            => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'        => false,
                    'show_ui'             => true,
                    'show_in_menu'        => false,
                    'menu_position'       => 5,
                    'show_in_admin_bar'   => false,
                    'show_in_nav_menus'   => true,
                    'can_export'          => true,
                    'has_archive'         => false,
                    'exclude_from_search' => false,
                    'publicly_queryable'  => true,
                    'show_in_rest'        => false,
                    'menu_item'           => 'dashicons-images-alt2',
                    //	'register_meta_box_b' => array($this, 'add_meta_boxes')
                )
            );
        }

        public function borsay_slider_cpt_columns( $columns ) {
            $columns['borsay_slider_link_text'] = esc_html__( 'Link  Text', 'borsay_slider' );
            $columns['borsay_slider_link_url']  = esc_html__( 'Link  URL', 'borsay_slider' );

            return $columns;
        }


        public function borsay_slider_custom_columns( $column, $post_id ) {
            switch ( $column ) {
                case 'borsay_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'borsay_slider_link_text', true ) );
                    break;
                case 'borsay_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'borsay_slider_link_url', true ) );
                    break;


            }
        }

        public function borsay_slider_sortable_columns( $columns ) {
            $columns['borsay_slider_link_text'] = 'borsay_slider_link_text';

            return $columns;
        }


        public function add_meta_boxes(): void {
            add_meta_box(
                'borsay_slider_meta_box',
                'Link Options',
                array( $this, 'add_inner_meta_boxes' ),
                'borsay-slider',
                'normal',
                'high',
            );
        }

        /**
         * @param $post
         *
         * @return void
         */
        public function add_inner_meta_boxes( $post ): void {
            require_once( BORSAY_SLIDER_PATH . 'views/borsay-slider_metabox.php' );
        }

        public function save_post( $post_id ): void {
            if ( isset( $_POST['borsay_slider_nonce'] ) ) {
                if ( ! wp_verify_nonce( $_POST['borsay_slider_nonce'], 'borsay_slider_nonce' ) ) {
                    return;
                }
            }


            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            if ( isset( $_POST['post_type'] ) && $_POST['post_type'] === "borsay-slider" ) {
                if ( ! current_user_can( 'edit_page', $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                }
            }
            if ( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {
                $old_link_text = get_post_meta( $post_id, 'borsay_slider_link_text', true );
                $new_link_text = $_POST['borsay_slider_link_text'];
                $old_link_url  = get_post_meta( $post_id, 'borsay_slider_link_url', true );
                $new_link_url  = $_POST['borsay_slider_link_url'];

                update_post_meta( $post_id, 'borsay_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                if ( empty( $new_link_text ) ) {
                    update_post_meta( $post_id, 'borsay_slider_link_text', 'Add Some Text' );
                }

                update_post_meta( $post_id, 'borsay_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                if ( empty( $new_link_url ) ) {
                    update_post_meta( $post_id, 'borsay_slider_link_url', '#' );
                }


            }
        }
    }
}

