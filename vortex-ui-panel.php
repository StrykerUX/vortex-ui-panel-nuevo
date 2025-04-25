<?php
/**
 * Plugin Name: Vortex UI Panel
 * Plugin URI: https://github.com/StrykerUX/vortex-ui-panel-nuevo
 * Description: Plugin de WordPress para crear paneles de administración personalizados con un menú lateral estilo SaaS moderno.
 * Version: 0.1.0
 * Author: StrykerUX
 * Text Domain: vortex-ui-panel
 * Domain Path: /languages
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

/**
 * Versión actual del plugin.
 */
define('VORTEX_UI_PANEL_VERSION', '0.1.0');

/**
 * Clase principal del plugin
 */
class Vortex_UI_Panel {
    
    /**
     * Instancia única de esta clase
     */
    private static $instance = null;
    
    /**
     * Inicializa el plugin
     */
    private function __construct() {
        // Acciones y filtros irán aquí
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
    }
    
    /**
     * Singleton para obtener la instancia única
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Registra los estilos del panel de administración
     */
    public function enqueue_admin_styles() {
        // Los estilos se añadirán aquí
    }
}

// Iniciar el plugin
function run_vortex_ui_panel() {
    return Vortex_UI_Panel::get_instance();
}
run_vortex_ui_panel();
