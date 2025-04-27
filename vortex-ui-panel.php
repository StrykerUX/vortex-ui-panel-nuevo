<?php
/**
 * Plugin Name: Vortex UI Panel
 * Plugin URI: https://github.com/StrykerUX/vortex-ui-panel-nuevo
 * Description: Plugin de WordPress para crear paneles de administración personalizados con un menú lateral estilo SaaS moderno.
 * Version: 0.3.0
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
define('VORTEX_UI_PANEL_VERSION', '0.3.0');

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
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-theme-customizer.php';
require_once VORTEX_UI_PANEL_PATH . 'includes/class-vortex-styles-demo.php';

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
     * Personalizador de estilos del tema
     */
    private $theme_customizer;
    
    /**
     * Inicializa el plugin
     */
    private function __construct() {
        // Inicializar componentes
        $this->menu_manager = new Vortex_Menu_Manager();
        $this->theme_customizer = Vortex_Theme_Customizer::get_instance();
        $this->admin_page = new Vortex_Admin_Page($this->menu_manager, $this->theme_customizer);
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
     * Inicializa el personalizador de estilos del tema
     */
    public function get_theme_customizer() {
        return $this->theme_customizer;
    }
    
    /**
     * Registra los estilos del panel de administración
     */
    public function enqueue_admin_styles($hook) {
        // Para todas las páginas del plugin
        if (strpos($hook, 'vortex-ui-panel') !== false) {
            // Estilos generales
            wp_enqueue_style('vortex-admin-styles', VORTEX_UI_PANEL_URL . 'assets/css/admin.css', array(), VORTEX_UI_PANEL_VERSION);
            
            // Cargar iconos de Tabler
            Vortex_Tabler_Icons::enqueue_icons();
        }
        
        // Para la página del gestor de menú
        if (strpos($hook, 'vortex-ui-panel') === 0 && strpos($hook, 'vortex-ui-panel-theme-styles') === false && strpos($hook, 'vortex-ui-panel-settings') === false) {
            wp_enqueue_script('vortex-admin-script', VORTEX_UI_PANEL_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), VORTEX_UI_PANEL_VERSION, true);
            
            // Cargar media uploader de WordPress
            wp_enqueue_media();
            
            // Pasar variables al script
            wp_localize_script('vortex-admin-script', 'vortexUIPanel', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('vortex_ui_panel_nonce')
            ));
        }
        
        // Para la página del personalizador de estilos
        if (strpos($hook, 'vortex-ui-panel-theme-styles') !== false) {
            // Estilos específicos para el personalizador
            wp_enqueue_style('vortex-theme-customizer-styles', VORTEX_UI_PANEL_URL . 'assets/css/theme-customizer.css', array(), VORTEX_UI_PANEL_VERSION);
        }
    }
    
    /**
     * Registra los estilos para el frontend
     */
    public function enqueue_frontend_styles() {
        // Cargar iconos de Tabler en el frontend
        Vortex_Tabler_Icons::enqueue_icons();
        
        // Obtener el estilo de UI actual
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        $current_style = isset($custom_variables['ui-style']) ? $custom_variables['ui-style'] : 'modern';
        
        // Cargar estilos específicos según el estilo seleccionado
        switch ($current_style) {
            case 'neo-brutalism':
                wp_enqueue_style('vortex-neo-brutalism', VORTEX_UI_PANEL_URL . 'assets/css/neo-brutalism-panel.css', array(), VORTEX_UI_PANEL_VERSION);
                wp_enqueue_script('vortex-neo-brutalism-script', VORTEX_UI_PANEL_URL . 'assets/js/neo-brutalism.js', array('jquery'), VORTEX_UI_PANEL_VERSION, true);
                break;
                
            case 'minimalist':
                wp_enqueue_style('vortex-minimalist', VORTEX_UI_PANEL_URL . 'assets/css/minimalist.css', array(), VORTEX_UI_PANEL_VERSION);
                break;
                
            // Otros estilos pueden ser agregados aquí
        }
        
        // Agregar clase del estilo actual al body
        add_filter('body_class', function($classes) use ($current_style) {
            $classes[] = 'ui-style-' . $current_style;
            return $classes;
        });
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
