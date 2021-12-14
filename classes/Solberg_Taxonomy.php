<?php

class Solberg_Taxonomy{

    public function __construct()
    {
        add_action('init', [ $this, 'create_solberg_taxonomy' ]);

        add_action('solberg_taxonomy_add_form_fields', [ $this, 'create_solberg_taxonomy_fields' ]);

        add_action('solberg_taxonomy_edit_form_fields', [ $this, 'edit_solberg_taxonomy_fields' ]);

        add_action('created_solberg_taxonomy', [ $this, 'save_solberg_taxonomy_fields' ]);

        add_action('edited_solberg_taxonomy', [ $this, 'save_solberg_taxonomy_fields' ]);

        add_action('admin_enqueue_scripts', [ $this, 'admin_media_scripts']);
    }


    public function create_solberg_taxonomy()
    {
        $labels = array(
            'name'                       => _x( 'Solberg Taxonomy', 'taxonomy general name', '1day' ),
            'singular_name'              => _x( 'Solberg Taxonomy', 'taxonomy singular name', '1day' ),
            'search_items'               => __( 'Search Solberg Taxonomies', '1day' ),
            'popular_items'              => __( 'Popular Solberg Taxonomies', '1day' ),
            'all_items'                  => __( 'All Solberg Taxonomies', '1day' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Solberg Taxonomy', '1day' ),
            'update_item'                => __( 'Update Solberg Taxonomy', '1day' ),
            'add_new_item'               => __( 'Add New Solberg Taxonomy', '1day' ),
            'new_item_name'              => __( 'New Solberg Taxonomy Title', '1day' ),
            'separate_items_with_commas' => __( 'Separate Solberg Taxonomies with commas', '1day' ),
            'add_or_remove_items'        => __( 'Add or remove Solberg Taxonomies', '1day' ),
            'choose_from_most_used'      => __( 'Choose from the most used Solberg Taxonomies', '1day' ),
            'not_found'                  => __( 'No Solberg Taxonomies found.', '1day' ),
            'menu_name'                  => __( 'Solberg Taxonomies', '1day' ),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );

        register_taxonomy( 'solberg_taxonomy', 'post', $args );
    }


    public function create_solberg_taxonomy_fields()
    {
        ?>

        <div class="form-field">
            <label for="solberg_taxonomy_order"><?php echo esc_attr__('Order', 'solberg_plugin'); ?></label>
            <input type="number" name="solberg_taxonomy_order" id="solberg_taxonomy_order" value="0"/>
        </div>

        <div class="form-field solberg_taxonomy-img">
            <label for="solberg_taxonomy_image"><?php echo esc_attr__('Image:', 'solberg_plugin'); ?></label>
            <input type="hidden" name="solberg_taxonomy_image" id="solberg_taxonomy_image" class="solberg_taxonomy-image" value="">
            <input class="upload_image_button button" name="_add_solberg_taxonomy_image" id="_add_solberg_taxonomy_image" type="button" value="<?php echo esc_attr__('Select/Upload Image', 'solberg_plugin'); ?>" />

            <div class="img-wrap">
                <img src="" id="solberg_taxonomy-img" alt="" />
                <div class="remove-img"></div>
            </div>
        </div>
        <?php
    }

    public static function get_solberg_taxonomy_image($term_id, $size = 'thumbnail')
    {
        $solberg_taxonomy_image_id = get_term_meta($term_id, 'solberg_taxonomy_image', true) ?: '';

        if(empty($solberg_taxonomy_image_id) && $solberg_taxonomy_image_id !== 0)
            return false;

        $solberg_taxonomy_image_src = !empty($solberg_taxonomy_image_id) ? wp_get_attachment_image_url($solberg_taxonomy_image_id, $size) : '';

        if(empty($solberg_taxonomy_image_src))
            return false;

        return [ 'id' => $solberg_taxonomy_image_id, 'url' => $solberg_taxonomy_image_src ];

    }

    public function edit_solberg_taxonomy_fields($term)
    { ?>

        <?php $solberg_taxonomy_image = self::get_solberg_taxonomy_image($term->term_id); ?>
        <?php $solberg_taxonomy_order = get_term_meta($term->term_id, 'solberg_taxonomy_order', true) ?: 0; ?>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="solberg_taxonomy_order"><?php echo esc_attr__( 'Order', 'solberg_plugin' ); ?></label></th>
            <td>
                <input type="number" name="solberg_taxonomy_order" id="solberg_taxonomy_order" value="<?php echo esc_attr($solberg_taxonomy_order); ?>"/>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="solberg_taxonomy_image"><?php echo esc_attr__( 'Image', 'solberg_plugin' ); ?></label></th>
            <td>
                <input type="hidden" name="solberg_taxonomy_image" id="solberg_taxonomy_image" class="solberg_taxonomy-image" value="<?php echo $solberg_taxonomy_image !== false ? esc_url($solberg_taxonomy_image['id']) : ''; ?>">
                <input class="upload_image_button button" name="_add_solberg_taxonomy_image" id="_add_solberg_taxonomy_image" type="button" value="<?php echo esc_attr__('Select/Upload Image', 'solberg_plugin'); ?>" />
            </td>
        </tr>
        <tr class="form-field solberg_taxonomy-img">
            <th scope="row" valign="top"></th>
            <td>
                <div class="img-wrap">
                    <img src="<?php echo $solberg_taxonomy_image !== false ? esc_url($solberg_taxonomy_image['url']) : ''; ?>" id="solberg_taxonomy-img" alt="" />
                    <div class="remove-img"></div>
                </div>
            </td>
        </tr>

        <?php
    }

    public function save_solberg_taxonomy_fields($term_id)
    {
        if (isset($_POST['solberg_taxonomy_order']))
        {
            update_term_meta(
                $term_id,
                'solberg_taxonomy_order',
                sanitize_text_field($_POST['solberg_taxonomy_order'])
            );
        }

        if (isset($_POST['solberg_taxonomy_image']))
        {
            update_term_meta(
                $term_id,
                'solberg_taxonomy_image',
                sanitize_text_field($_POST['solberg_taxonomy_image'])
            );
        }
    }


    public function admin_media_scripts()
    {
        wp_enqueue_style('solberg-admin-styles', plugin_dir_url( __FILE__ ) . '../assets/css/admin.css', [], '1.0');
        wp_enqueue_script('solberg-admin-scripts', plugin_dir_url( __FILE__ ) . '../assets/js/admin.js', [], '1.0');

        wp_enqueue_media();
    }


    public static function run()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }
}