<?php
/**
 * Clase para la personalización de estilos del tema
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Theme_Customizer {
    
    /**
     * Instancia única de esta clase
     */
    private static $instance = null;
    
    /**
     * Variables CSS por defecto
     */
    private $default_variables = array(
        // Colores
        'bs-primary' => '#4F46E5',
        'bs-secondary' => '#8B5CF6',
        'bs-success' => '#10B981',
        'bs-info' => '#3B82F6',
        'bs-warning' => '#F59E0B',
        'bs-danger' => '#EF4444',
        'bs-light' => '#F9FAFB',
        'bs-dark' => '#111827',
        
        // Tipografía
        'bs-body-font-family' => "'Inter', sans-serif",
        'bs-body-font-size' => '0.9rem',
        'bs-body-font-weight' => '400',
        'bs-body-line-height' => '1.5',
        
        // Layout
        'sidenav-width' => '260px',
        'sidenav-condensed-width' => '70px',
        'topbar-height' => '70px',
        
        // Modo oscuro
        'dark-body-color' => '#aab8c5',
        'dark-body-bg' => '#212529',
        'dark-tertiary-bg' => '#2b3035',
        'dark-card-bg' => '#262e35',
        'dark-card-border-color' => '#30373d',
    );
    
    /**
     * Categorías de variables
     */
    private $variable_categories = array(
        'colors' => array(
            'title' => 'Colores',
            'variables' => array(
                'bs-primary' => 'Color primario',
                'bs-secondary' => 'Color secundario',
                'bs-success' => 'Color de éxito',
                'bs-info' => 'Color informativo',
                'bs-warning' => 'Color de advertencia',
                'bs-danger' => 'Color de peligro/error',
                'bs-light' => 'Color claro',
                'bs-dark' => 'Color oscuro',
            )
        ),
        'typography' => array(
            'title' => 'Tipografía',
            'variables' => array(
                'bs-body-font-family' => 'Familia de fuente principal',
                'bs-body-font-size' => 'Tamaño de fuente base',
                'bs-body-font-weight' => 'Grosor de fuente base',
                'bs-body-line-height' => 'Altura de línea base',
            )
        ),
        'layout' => array(
            'title' => 'Estructura',
            'variables' => array(
                'sidenav-width' => 'Ancho de la barra lateral',
                'sidenav-condensed-width' => 'Ancho de barra lateral condensada',
                'topbar-height' => 'Altura de la barra superior',
            )
        ),
        'dark_mode' => array(
            'title' => 'Modo Oscuro',
            'variables' => array(
                'dark-body-color' => 'Color de texto (modo oscuro)',
                'dark-body-bg' => 'Color de fondo (modo oscuro)',
                'dark-tertiary-bg' => 'Color de fondo terciario (modo oscuro)',
                'dark-card-bg' => 'Color de fondo de tarjetas (modo oscuro)',
                'dark-card-border-color' => 'Color de borde de tarjetas (modo oscuro)',
            )
        ),
    );
    
    /**
     * Fuentes disponibles
     */
    private $available_fonts = array(
        "'Inter', sans-serif" => "Inter",
        "'Poppins', sans-serif" => "Poppins",
        "'Roboto', sans-serif" => "Roboto",
        "'Open Sans', sans-serif" => "Open Sans",
        "'Montserrat', sans-serif" => "Montserrat",
        "'Nunito', sans-serif" => "Nunito",
        "'Lato', sans-serif" => "Lato",
        "'Source Sans Pro', sans-serif" => "Source Sans Pro",
        "'Ubuntu', sans-serif" => "Ubuntu",
        "'Rubik', sans-serif" => "Rubik",
    );
    
    /**
     * Constructor
     */
    private function __construct() {
        // Registrar hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_css'), 999);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_vortex_save_theme_styles', array($this, 'ajax_save_theme_styles'));
        add_action('wp_ajax_vortex_reset_theme_styles', array($this, 'ajax_reset_theme_styles'));
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
     * Encolar estilos personalizados
     */
    public function enqueue_custom_css() {
        // Generar CSS personalizado
        $custom_css = $this->generate_custom_css();
        
        // Inyectar el CSS en el frontend
        if (!empty($custom_css)) {
            wp_add_inline_style('ui-panel-saas-main', $custom_css);
        }
        
        // Encolar fuentes de Google si son necesarias
        $this->enqueue_google_fonts();
    }
    
    /**
     * Generar el CSS personalizado
     */
    public function generate_custom_css() {
        // Obtener variables personalizadas
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        
        // Si no hay variables personalizadas, devolver cadena vacía
        if (empty($custom_variables)) {
            return '';
        }
        
        // Generar :root con variables
        $css = ":root {\n";
        foreach ($custom_variables as $name => $value) {
            if (!empty($value)) {
                $css .= "    --{$name}: {$value};\n";
                
                // Generar versiones RGB para colores
                if (strpos($name, 'bs-') === 0 && strpos($name, '-rgb') === false && $this->is_color($value)) {
                    $rgb = $this->hex_to_rgb($value);
                    if ($rgb) {
                        $css .= "    --{$name}-rgb: {$rgb};\n";
                    }
                }
            }
        }
        $css .= "}\n\n";
        
        // Generar variables para modo oscuro
        $css .= "[data-bs-theme=dark] {\n";
        foreach ($custom_variables as $name => $value) {
            if (strpos($name, 'dark-') === 0 && !empty($value)) {
                $new_name = str_replace('dark-', 'bs-', $name);
                $css .= "    --{$new_name}: {$value};\n";
                
                // Generar versiones RGB para colores
                if ($this->is_color($value)) {
                    $rgb = $this->hex_to_rgb($value);
                    if ($rgb) {
                        $css .= "    --{$new_name}-rgb: {$rgb};\n";
                    }
                }
            }
        }
        $css .= "}\n";
        
        return $css;
    }
    
    /**
     * Verificar si un valor es un color hexadecimal
     */
    private function is_color($value) {
        return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value);
    }
    
    /**
     * Convertir color hexadecimal a RGB
     */
    private function hex_to_rgb($hex) {
        // Remover el # si existe
        $hex = ltrim($hex, '#');
        
        // Verificar si el hex es de 3 o 6 caracteres
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        return $r . ", " . $g . ", " . $b;
    }
    
    /**
     * Encolar fuentes de Google
     */
    private function enqueue_google_fonts() {
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        
        // Verificar si hay una fuente personalizada
        if (isset($custom_variables['bs-body-font-family'])) {
            $font_family = trim($custom_variables['bs-body-font-family'], "'");
            $font_family = explode(',', $font_family)[0];
            
            // Lista de fuentes que necesitamos cargar
            $fonts_to_load = array();
            
            // Solo encolar si no es una fuente del sistema
            $system_fonts = array('Arial', 'Helvetica', 'Times New Roman', 'serif', 'sans-serif');
            if (!in_array($font_family, $system_fonts)) {
                // Reemplazar espacios con +
                $font_family_url = str_replace(' ', '+', $font_family);
                
                // Añadir a la lista de fuentes a cargar
                $fonts_to_load[] = $font_family_url . ':300,400,500,600,700';
            }
            
            // Encolar fuentes de Google
            if (!empty($fonts_to_load)) {
                $google_fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts_to_load) . '&display=swap';
                wp_enqueue_style('vortex-google-fonts', $google_fonts_url, array(), null);
            }
        }
    }
    
    /**
     * Encolar scripts de administración
     */
    public function enqueue_admin_scripts($hook) {
        // Solo cargar en la página del personalizador
        if ($hook !== 'vortex-ui-panel_page_vortex-ui-panel-theme-styles') {
            return;
        }
        
        // Encolar estilos y scripts
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery-ui-tabs');
        
        // Encolar script personalizado
        wp_enqueue_script('vortex-theme-customizer', VORTEX_UI_PANEL_URL . 'assets/js/theme-customizer.js', array('jquery', 'wp-color-picker', 'jquery-ui-tabs'), VORTEX_UI_PANEL_VERSION, true);
        
        // Pasar variables al script
        wp_localize_script('vortex-theme-customizer', 'vortexThemeCustomizer', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('vortex_theme_customizer_nonce'),
        ));
    }
    
    /**
     * Guardar estilos personalizados vía AJAX
     */
    public function ajax_save_theme_styles() {
        // Verificar nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_theme_customizer_nonce')) {
            wp_send_json_error('Invalid security token');
        }
        
        // Verificar permisos
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Obtener variables
        $custom_variables = isset($_POST['variables']) ? $_POST['variables'] : array();
        
        // Sanitizar valores
        $sanitized_variables = array();
        foreach ($custom_variables as $name => $value) {
            $name = sanitize_text_field($name);
            
            // Sanitizar según el tipo de variable
            if (strpos($name, 'color') !== false || $this->is_color($value)) {
                $value = sanitize_hex_color($value);
            } else {
                $value = sanitize_text_field($value);
            }
            
            $sanitized_variables[$name] = $value;
        }
        
        // Guardar en la base de datos
        update_option('vortex_theme_custom_variables', $sanitized_variables);
        
        // Responder con éxito
        wp_send_json_success('Estilos guardados correctamente');
    }
    
    /**
     * Resetear estilos a valores por defecto vía AJAX
     */
    public function ajax_reset_theme_styles() {
        // Verificar nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_theme_customizer_nonce')) {
            wp_send_json_error('Invalid security token');
        }
        
        // Verificar permisos
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Eliminar la opción para restablecer a los valores por defecto
        delete_option('vortex_theme_custom_variables');
        
        // Responder con éxito
        wp_send_json_success('Estilos restablecidos a valores por defecto');
    }
    
    /**
     * Obtener variables personalizadas
     */
    public function get_custom_variables() {
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        
        // Combinar con valores por defecto
        return array_merge($this->default_variables, $custom_variables);
    }
    
    /**
     * Obtener categorías de variables
     */
    public function get_variable_categories() {
        return $this->variable_categories;
    }
    
    /**
     * Obtener fuentes disponibles
     */
    public function get_available_fonts() {
        return $this->available_fonts;
    }
    
    /**
     * Obtener las variables por defecto
     */
    public function get_default_variables() {
        return $this->default_variables;
    }
}
