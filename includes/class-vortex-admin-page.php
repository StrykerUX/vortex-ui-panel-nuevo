<?php
/**
 * Clase para la página de administración del plugin
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Admin_Page {
    /**
     * Instancia del gestor de menú
     */
    private $menu_manager;
    
    /**
     * Instancia del personalizador de estilos del tema
     */
    private $theme_customizer;
    
    /**
     * Slug de la página de administración
     */
    const MENU_SLUG = 'vortex-ui-panel';
    
    /**
     * Constructor
     */
    public function __construct($menu_manager, $theme_customizer = null) {
        $this->menu_manager = $menu_manager;
        $this->theme_customizer = $theme_customizer;
    }
    
    /**
     * Registra la página de administración
     */
    public function register_menu_page() {
        add_menu_page(
            'Vortex UI Panel',
            'Vortex UI Panel',
            'manage_options',
            self::MENU_SLUG,
            array($this, 'render_main_page'),
            'dashicons-layout',
            30
        );
        
        add_submenu_page(
            self::MENU_SLUG,
            'Gestor de Menú',
            'Gestor de Menú',
            'manage_options',
            self::MENU_SLUG,
            array($this, 'render_main_page')
        );
        
        add_submenu_page(
            self::MENU_SLUG,
            'Personalización del Tema',
            'Personalizar Tema',
            'manage_options',
            self::MENU_SLUG . '-theme-styles',
            array($this, 'render_theme_styles_page')
        );
        
        add_submenu_page(
            self::MENU_SLUG,
            'Configuración General',
            'Configuración',
            'manage_options',
            self::MENU_SLUG . '-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Renderiza la página principal del gestor de menú
     */
    public function render_main_page() {
        // Obtener la estructura del menú actual
        $menu_structure = $this->menu_manager->get_menu_structure();
        $available_icons = $this->menu_manager->get_available_icons();
        
        // Incluir la plantilla de la página
        include VORTEX_UI_PANEL_PATH . 'admin/menu-manager.php';
    }
    
    /**
     * Renderiza la página de configuración
     */
    public function render_settings_page() {
        // Obtener valores actuales
        $logo_url = $this->menu_manager->get_logo_url();
        $dashboard_url = $this->menu_manager->get_dashboard_url();
        
        // Incluir la plantilla de la página
        include VORTEX_UI_PANEL_PATH . 'admin/settings.php';
    }
    
    /**
     * Renderiza la página del personalizador de estilos del tema
     */
    public function render_theme_styles_page() {
        // Verificar que el personalizador está inicializado
        if (!$this->theme_customizer) {
            echo '<div class="notice notice-error"><p>Error: El personalizador de estilos no está disponible.</p></div>';
            return;
        }
        
        // Incluir la plantilla de la página
        include VORTEX_UI_PANEL_PATH . 'admin/theme-styles.php';
    }
}
