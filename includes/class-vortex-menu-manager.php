<?php
/**
 * Clase para gestionar el menú lateral personalizado
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Menu_Manager {
    /**
     * Opción de WordPress donde se almacena la configuración del menú
     */
    const MENU_OPTION_NAME = 'vortex_ui_panel_menu';
    
    /**
     * Opción de WordPress donde se almacena la configuración del logo
     */
    const LOGO_OPTION_NAME = 'vortex_ui_panel_logo';
    
    /**
     * Opción de WordPress donde se almacena la URL del dashboard
     */
    const DASHBOARD_URL_OPTION_NAME = 'vortex_ui_panel_dashboard_url';
    
    /**
     * Constructor
     */
    public function __construct() {
        // Registrar hooks de AJAX
        add_action('wp_ajax_vortex_save_menu', array($this, 'ajax_save_menu'));
        add_action('wp_ajax_vortex_save_logo', array($this, 'ajax_save_logo'));
        add_action('wp_ajax_vortex_save_dashboard_url', array($this, 'ajax_save_dashboard_url'));
    }
    
    /**
     * Obtiene la estructura del menú personalizado
     */
    public function get_menu_structure() {
        $menu = get_option(self::MENU_OPTION_NAME, array());
        
        if (empty($menu)) {
            // Menú por defecto si no hay nada guardado
            $menu = $this->get_default_menu();
        }
        
        return $menu;
    }
    
    /**
     * Guarda la estructura del menú personalizado
     */
    public function save_menu_structure($menu_data) {
        return update_option(self::MENU_OPTION_NAME, $menu_data);
    }
    
    /**
     * Obtiene la URL del logo personalizado
     */
    public function get_logo_url() {
        return get_option(self::LOGO_OPTION_NAME, '');
    }
    
    /**
     * Guarda la URL del logo personalizado
     */
    public function save_logo_url($logo_url) {
        return update_option(self::LOGO_OPTION_NAME, $logo_url);
    }
    
    /**
     * Obtiene la URL del dashboard personalizado
     */
    public function get_dashboard_url() {
        return get_option(self::DASHBOARD_URL_OPTION_NAME, home_url('/'));
    }
    
    /**
     * Guarda la URL del dashboard personalizado
     */
    public function save_dashboard_url($dashboard_url) {
        return update_option(self::DASHBOARD_URL_OPTION_NAME, $dashboard_url);
    }
    
    /**
     * Modifica el menú de sidebar del tema
     */
    public function customize_sidebar_menu($args) {
        // Solo modificar si es el menú del sidebar
        if (isset($args['theme_location']) && $args['theme_location'] === 'sidebar') {
            // Aquí se implementará la lógica para reemplazar el menú
            // con nuestra versión personalizada
        }
        
        return $args;
    }
    
    /**
     * Modifica el logo del sidebar
     */
    public function customize_sidebar_logo($html) {
        $logo_url = $this->get_logo_url();
        
        if (!empty($logo_url)) {
            // Reemplazar el logo con nuestra versión personalizada
            $blog_name = get_bloginfo('name');
            $html = '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($blog_name) . '" class="custom-logo">';
        }
        
        return $html;
    }
    
    /**
     * Obtiene una lista de los iconos disponibles (Tabler Icons)
     */
    public function get_available_icons() {
        // Lista básica de iconos Tabler comunes
        return array(
            'ti ti-dashboard' => 'Dashboard',
            'ti ti-home' => 'Home',
            'ti ti-user' => 'User',
            'ti ti-settings' => 'Settings',
            'ti ti-file' => 'File',
            'ti ti-folder' => 'Folder',
            'ti ti-mail' => 'Mail',
            'ti ti-calendar' => 'Calendar',
            'ti ti-chart-bar' => 'Chart Bar',
            'ti ti-basket' => 'Basket/Shop',
            'ti ti-message' => 'Message',
            'ti ti-bell' => 'Notification',
            'ti ti-map' => 'Map',
            'ti ti-photo' => 'Image',
            'ti ti-users' => 'Users',
            'ti ti-tag' => 'Tag',
            'ti ti-search' => 'Search',
            'ti ti-lock' => 'Lock',
            'ti ti-star' => 'Star',
            'ti ti-heart' => 'Heart'
        );
    }
    
    /**
     * Maneja la solicitud AJAX para guardar el menú
     */
    public function ajax_save_menu() {
        // Verificar nonce y permisos
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_ui_panel_nonce')) {
            wp_send_json_error('Nonce inválido');
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permisos insuficientes');
        }
        
        // Obtener y sanitizar datos
        $menu_data = isset($_POST['menu']) ? $_POST['menu'] : array();
        
        // Validar y sanitizar la estructura del menú recibida
        // Implementar validación aquí...
        
        // Guardar en la base de datos
        $result = $this->save_menu_structure($menu_data);
        
        if ($result) {
            wp_send_json_success('Menú guardado correctamente');
        } else {
            wp_send_json_error('Error al guardar el menú');
        }
    }
    
    /**
     * Maneja la solicitud AJAX para guardar el logo
     */
    public function ajax_save_logo() {
        // Verificar nonce y permisos
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_ui_panel_nonce')) {
            wp_send_json_error('Nonce inválido');
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permisos insuficientes');
        }
        
        // Obtener y sanitizar URL
        $logo_url = isset($_POST['logo_url']) ? esc_url_raw($_POST['logo_url']) : '';
        
        // Guardar en la base de datos
        $result = $this->save_logo_url($logo_url);
        
        if ($result) {
            wp_send_json_success('Logo guardado correctamente');
        } else {
            wp_send_json_error('Error al guardar el logo');
        }
    }
    
    /**
     * Maneja la solicitud AJAX para guardar la URL del dashboard
     */
    public function ajax_save_dashboard_url() {
        // Verificar nonce y permisos
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_ui_panel_nonce')) {
            wp_send_json_error('Nonce inválido');
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permisos insuficientes');
        }
        
        // Obtener y sanitizar URL
        $dashboard_url = isset($_POST['dashboard_url']) ? esc_url_raw($_POST['dashboard_url']) : home_url('/');
        
        // Guardar en la base de datos
        $result = $this->save_dashboard_url($dashboard_url);
        
        if ($result) {
            wp_send_json_success('URL del dashboard guardada correctamente');
        } else {
            wp_send_json_error('Error al guardar la URL del dashboard');
        }
    }
    
    /**
     * Devuelve un menú por defecto para usar como base
     */
    private function get_default_menu() {
        return array(
            array(
                'id' => 'dashboard',
                'title' => 'Dashboard',
                'url' => home_url('/'),
                'icon' => 'ti ti-dashboard',
                'target' => '_self',
                'parent_id' => 0,
                'type' => 'link',
                'order' => 1,
                'roles' => array('all')
            ),
            array(
                'id' => 'apps_pages',
                'title' => 'Apps & Pages',
                'icon' => '',
                'parent_id' => 0,
                'type' => 'section',
                'order' => 2,
                'roles' => array('all')
            ),
            array(
                'id' => 'chat',
                'title' => 'Chat',
                'url' => '#',
                'icon' => 'ti ti-message-filled',
                'target' => '_self',
                'parent_id' => 0,
                'type' => 'link',
                'order' => 3,
                'roles' => array('all')
            ),
            array(
                'id' => 'calendar',
                'title' => 'Calendar',
                'url' => '#',
                'icon' => 'ti ti-calendar-filled',
                'target' => '_self',
                'parent_id' => 0,
                'type' => 'link',
                'order' => 4,
                'roles' => array('all')
            ),
            array(
                'id' => 'email',
                'title' => 'Email',
                'url' => '#',
                'icon' => 'ti ti-inbox',
                'target' => '_self',
                'parent_id' => 0,
                'type' => 'link',
                'order' => 5,
                'roles' => array('all')
            )
        );
    }
}