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
 * Path al directorio del plugin
 */
define('VORTEX_UI_PANEL_PATH', plugin_dir_path(__FILE__));

/**
 * URL al directorio del plugin
 */
define('VORTEX_UI_PANEL_URL', plugin_dir_url(__FILE__));

/**
 * Carga las clases necesarias
 */
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-menu-manager.php';
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-admin-page.php';
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-sidebar-renderer.php';
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-tabler-icons.php';

/**
 * Clase principal del plugin
 */
class Vortex_UI_Panel {
    
    /**
     * Instancia única de esta clase
     */
    private static $instance = null;
    
    /**
     * Gestor del menú
     */
    private $menu_manager;
    
    /**
     * Página de administración
     */
    private $admin_page;
    
    /**
     * Renderer del sidebar
     */
    private $sidebar_renderer;
    
    /**
     * Inicializa el plugin
     */
    private function __construct() {
        // Inicializar componentes
        $this->menu_manager = new Vortex_Menu_Manager();
        $this->admin_page = new Vortex_Admin_Page($this->menu_manager);
        $this->sidebar_renderer = new Vortex_Sidebar_Renderer($this->menu_manager);
        
        // Registrar hooks
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_styles'));
        add_action('admin_menu', array($this->admin_page, 'register_menu_page'));
        
        // Filtros para modificar el sidebar del tema
        add_filter('wp_nav_menu_args', array($this->menu_manager, 'customize_sidebar_menu'), 10, 1);
        add_filter('get_custom_logo', array($this->menu_manager, 'customize_sidebar_logo'), 10, 1);
        
        // Acciones AJAX
        add_action('wp_ajax_vortex_get_menu', array($this->menu_manager, 'ajax_get_menu'));
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
    public function enqueue_admin_styles($hook) {
        // Solo cargar en la página del plugin
        if (strpos($hook, 'vortex-ui-panel') === false) {
            return;
        }
        
        // Registrar y encolar estilos
        wp_enqueue_style('vortex-admin-styles', VORTEX_UI_PANEL_URL . 'assets/css/admin.css', array(), VORTEX_UI_PANEL_VERSION);
        wp_enqueue_script('vortex-admin-script', VORTEX_UI_PANEL_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), VORTEX_UI_PANEL_VERSION, true);
        
        // Cargar iconos de Tabler
        Vortex_Tabler_Icons::enqueue_icons();
        
        // Cargar media uploader de WordPress
        wp_enqueue_media();
        
        // Pasar variables al script
        wp_localize_script('vortex-admin-script', 'vortexUIPanel', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('vortex_ui_panel_nonce')
        ));
    }
    
    /**
     * Registra los estilos para el frontend
     */
    public function enqueue_frontend_styles() {
        // Cargar iconos de Tabler en el frontend
        Vortex_Tabler_Icons::enqueue_icons();
    }
    
    /**
     * Devuelve el renderer del sidebar
     */
    public function get_sidebar_renderer() {
        return $this->sidebar_renderer;
    }
    
    /**
     * Activación del plugin
     */
    public static function activate() {
        // Código de activación
    }
    
    /**
     * Desactivación del plugin
     */
    public static function deactivate() {
        // Código de desactivación
    }
}

// Hooks de activación y desactivación
register_activation_hook(__FILE__, array('Vortex_UI_Panel', 'activate'));
register_deactivation_hook(__FILE__, array('Vortex_UI_Panel', 'deactivate'));

// Iniciar el plugin
function run_vortex_ui_panel() {
    return Vortex_UI_Panel::get_instance();
}
run_vortex_ui_panel();