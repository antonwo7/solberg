<?php
/**
 * Plugin Name:       Solberg Categories
 * Description:       The plugin display subcategories
 * Version:           1.0.0
 * Author:            Anton
 * Author URI:        https://anton.com
 */

defined( 'ABSPATH' ) || exit;

define('SOLBERG_PLUGIN_DIR', __DIR__);

class Solberg_Plugin {
    public function __construct()
    {
        register_activation_hook(__FILE__, [$this, 'activation']);
        register_deactivation_hook(__FILE__, [$this, 'deactivation']);

        $this->load();
    }

    public function activation(){}

    public function deactivation(){}

    public function load()
    {
        require_once __DIR__ . '/classes/Solberg_Taxonomy.php';
        require_once __DIR__ . '/classes/Solberg_Init.php';

        Solberg_Taxonomy::run();
        Solberg_Init::run();
    }

    public static function init()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }
}

Solberg_Plugin::init();
