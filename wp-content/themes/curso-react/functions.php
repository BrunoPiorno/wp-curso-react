<?php 
if(!function_exists('a_mime_types')){
    function a_mime_types($mimes) {
        $mimes['svg'] ='image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes','a_mime_types');
}

if(!function_exists('a_add_image_size')){
    function a_add_image_size(){
        add_image_size('custom-medium',       300,    9999);
        add_image_size('custom-tablet',       600,    9999);
        add_image_size('custom-large',        1200,   9999);
        add_image_size('custom-large-crop',   1200,   1200, true);
        add_image_size('custom-desktop',      1600,   9999);
        add_image_size('custom-full',         2560,   9999);
    }
    add_action('after_setup_theme', 'a_add_image_size');
}

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'General',
        'parent_slug'   => 'theme-general-settings',
    ));

}

if (!function_exists('a_custom_navigation_menus')) {
    function a_custom_navigation_menus() {
        $locations = array(
            'header_menu' => __('Header Menu', 'wp-curso-react'),
            'footer_menu' => __('Footer Menu', 'wp-curso-react')
        );
        register_nav_menus($locations);
    }
    add_action('init', 'a_custom_navigation_menus');
}

function theme_setup() {
    // Agregar soporte para la imagen destacada
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'theme_setup');

if (!function_exists('a_register_custom_post_types')) {
    function a_register_custom_post_types() {
        $singular_name  = __('Project', 'wp-curso-react');
        $plural_name    = __('Projects', 'wp-curso-react');
        $slug_name      = 'cpt-project';

        register_post_type($slug_name, array(
            'label'             => $singular_name,
            'public'            => true,
            'capability_type'   => 'post',
            'map_meta_cap'      => true,
            'has_archive'       => false,
            'query_var'         => $slug_name,
            'supports'          => array('title', 'thumbnail', 'revisions'), 
            'labels'            => a_register_custom_post_labels($singular_name, $plural_name),
            'menu_icon'         => 'dashicons-images-alt2',
            'show_in_rest'      => true 
        ));
    }
    add_action('init', 'a_register_custom_post_types');
}

if (!function_exists('a_register_custom_post_labels')) {
    function a_register_custom_post_labels($singular, $plural) {
        $labels = array(
            'name'               => $plural,
            'singular_name'      => $singular,
            'menu_name'          => $plural,
            'add_new'            => __('Add New', 'wp-curso-react'),
            'add_new_item'       => __('Add New ' . $singular, 'wp-curso-react'),
            'edit'               => __('Edit','wp-curso-react'),
            'edit_item'          => __('Edit ' . $singular, 'wp-curso-react'),
            'new_item'           => __('New ' . $singular, 'wp-curso-react'),
            'view_item'          => __('View ' . $singular, 'wp-curso-react'),
            'view_items'         => __('View ' . $plural, 'wp-curso-react'),
            'search_items'       => __('Search ' . $plural, 'wp-curso-react'),
            'not_found'          => __('No ' . $plural . ' found', 'wp-curso-react'),
            'not_found_in_trash' => __('No ' . $plural . ' found in Trash', 'wp-curso-react'),
            'all_items'          => __('All ' . $plural, 'wp-curso-react'),
        );

        return $labels;
    }
}


