<?php

class Solberg_Init
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [ $this, 'enqueue_sources'], 100);
        add_action('setup_theme', [ $this, 'add_thumbnails_size'], 30);
        add_action('setup_theme', [ $this, 'create_shortcode'], 30);
    }

    public function enqueue_sources()
    {
        wp_enqueue_style('solberg-front-styles', plugin_dir_url( __FILE__ ) . '../assets/css/main.css', [], '1.0');
//        wp_enqueue_script('solberg-front-scripts', plugin_dir_url( __FILE__ ) . '../assets/js/main.js', [], '1.0');
    }

    public function add_thumbnails_size()
    {
        add_image_size('Solberg Taxonomy', 200, 100, [ 'center', 'center' ]);
    }

    public function create_shortcode()
    {
        add_shortcode('solberg_shortcode', function ($atts) {

            $solberg_order = !empty($_GET['solberg_order']) ? sanitize_text_field($_GET['solberg_order']) : 'ASC';

            $subcategories = $this->get_subcategories($solberg_order);

            ob_start();

            include_once SOLBERG_PLUGIN_DIR . "/templates/shortcode.php";

            $out = ob_get_contents();
            ob_end_clean();

            return $out;
        });
    }

    private function get_subcategories($solberg_order = 'ASC')
    {
        $categories = get_terms( [
            'taxonomy' => 'solberg_taxonomy',
            'hide_empty' => false,
            'order' => $solberg_order,
            'meta_key' => 'solberg_taxonomy_order',
            'orderby' => 'meta_value_num',
        ] );

        if(is_wp_error($categories) || !is_array($categories))
            return [];

        $categories = array_filter($categories, function($category){
            return $category->parent !== 0;
        });

        return $categories;
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