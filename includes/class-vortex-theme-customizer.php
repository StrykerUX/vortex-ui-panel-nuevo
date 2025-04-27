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
        // Colores principales
        'bs-primary' => '#4F46E5',
        'bs-secondary' => '#8B5CF6',
        'bs-success' => '#10B981',
        'bs-info' => '#3B82F6',
        'bs-warning' => '#F59E0B',
        'bs-danger' => '#EF4444',
        'bs-light' => '#F9FAFB',
        'bs-dark' => '#111827',
        
        // Variantes de colores principales (generadas automáticamente)
        'bs-primary-lightest' => '#E8E7FB',
        'bs-primary-lighter' => '#C7C5F6',
        'bs-primary-light' => '#7A74EE',
        'bs-primary-dark' => '#4338CA',
        'bs-primary-darker' => '#3730A3',
        'bs-primary-darkest' => '#312E81',
        
        // Colores semánticos para estados
        'bs-success-light' => '#D1FAE5',
        'bs-success-dark' => '#065F46',
        'bs-warning-light' => '#FEF3C7',
        'bs-warning-dark' => '#92400E',
        'bs-danger-light' => '#FEE2E2',
        'bs-danger-dark' => '#B91C1C',
        'bs-info-light' => '#DBEAFE',
        'bs-info-dark' => '#1E40AF',
        
        // Tipografía
        'bs-body-font-family' => "'Inter', sans-serif",
        'bs-body-font-size' => '0.9rem',
        'bs-body-font-weight' => '400',
        'bs-body-line-height' => '1.5',
        'bs-heading-font-family' => "'Inter', sans-serif",
        'bs-heading-font-weight' => '600',
        
        // Layout
        'sidenav-width' => '260px',
        'sidenav-condensed-width' => '70px',
        'topbar-height' => '70px',
        'card-border-radius' => '8px',
        'button-border-radius' => '4px',
        'input-border-radius' => '4px',
        
        // Modo oscuro
        'dark-body-color' => '#aab8c5',
        'dark-body-bg' => '#212529',
        'dark-tertiary-bg' => '#2b3035',
        'dark-card-bg' => '#262e35',
        'dark-card-border-color' => '#30373d',
        
        // Variables de botones 3D
        'button-3d-offset' => '4px',
        'button-3d-hover-offset' => '3px',
        'button-3d-transition' => '0.1s ease-out',
        
        // Variable para controlar el estilo de diseño
        'ui-style' => 'modern',
    );
    
    /**
     * Categorías de variables
     */
    private $variable_categories = array(
        'design_style' => array(
            'title' => 'Estilo de Diseño',
            'icon' => 'ti-brush',
            'variables' => array(
                'ui-style' => 'Estilo de interfaz',
            ),
            'description' => 'Selecciona el estilo visual base para tu interfaz',
        ),
        'colors' => array(
            'title' => 'Colores Principales',
            'icon' => 'ti-palette',
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
        'color_variants' => array(
            'title' => 'Variantes de Color',
            'icon' => 'ti-adjustments',
            'variables' => array(
                'bs-primary-light' => 'Primario claro',
                'bs-primary-dark' => 'Primario oscuro',
                'bs-secondary-light' => 'Secundario claro',
                'bs-secondary-dark' => 'Secundario oscuro',
            )
        ),
        'typography' => array(
            'title' => 'Tipografía',
            'icon' => 'ti-typography',
            'variables' => array(
                'bs-body-font-family' => 'Familia de fuente principal',
                'bs-body-font-size' => 'Tamaño de fuente base',
                'bs-body-font-weight' => 'Grosor de fuente base',
                'bs-body-line-height' => 'Altura de línea base',
                'bs-heading-font-family' => 'Familia de fuente para títulos',
                'bs-heading-font-weight' => 'Grosor de fuente para títulos',
            )
        ),
        'layout' => array(
            'title' => 'Estructura',
            'icon' => 'ti-layout',
            'variables' => array(
                'sidenav-width' => 'Ancho de la barra lateral',
                'sidenav-condensed-width' => 'Ancho de barra lateral condensada',
                'topbar-height' => 'Altura de la barra superior',
                'card-border-radius' => 'Radio de borde para tarjetas',
                'button-border-radius' => 'Radio de borde para botones',
                'input-border-radius' => 'Radio de borde para inputs',
            )
        ),
        'dark_mode' => array(
            'title' => 'Modo Oscuro',
            'icon' => 'ti-moon',
            'variables' => array(
                'dark-body-color' => 'Color de texto (modo oscuro)',
                'dark-body-bg' => 'Color de fondo (modo oscuro)',
                'dark-tertiary-bg' => 'Color de fondo terciario (modo oscuro)',
                'dark-card-bg' => 'Color de fondo de tarjetas (modo oscuro)',
                'dark-card-border-color' => 'Color de borde de tarjetas (modo oscuro)',
            )
        ),
        'buttons_3d' => array(
            'title' => 'Botones 3D',
            'icon' => 'ti-click',
            'variables' => array(
                'button-3d-offset' => 'Desplazamiento 3D',
                'button-3d-hover-offset' => 'Desplazamiento al hover',
                'button-3d-transition' => 'Velocidad de transición',
            ),
            'description' => 'Los botones 3D utilizan automáticamente los colores principales del tema para mantener la coherencia visual.'
        ),
        'alerts' => array(
            'title' => 'Alertas y Estados',
            'icon' => 'ti-alert-circle',
            'variables' => array(
                'bs-success-light' => 'Fondo alerta éxito',
                'bs-success-dark' => 'Borde alerta éxito',
                'bs-warning-light' => 'Fondo alerta advertencia',
                'bs-warning-dark' => 'Borde alerta advertencia',
                'bs-danger-light' => 'Fondo alerta error',
                'bs-danger-dark' => 'Borde alerta error',
                'bs-info-light' => 'Fondo alerta información',
                'bs-info-dark' => 'Borde alerta información',
            )
        ),
    );
    
    /**
     * Estilos de diseño disponibles
     */
    private $design_styles = array(
        'modern' => 'Moderno',
        'minimalist' => 'Minimalista',
        'neo-brutalism' => 'Neo Brutalismo',
        'bold' => 'Audaz',
        'enterprise' => 'Empresarial',
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
     * Presets de diseño disponibles
     */
    private $available_presets = array(
        'modern' => array(
            'name' => 'Moderno',
            'description' => 'Diseño limpio y moderno con bordes redondeados y colores vibrantes',
            'variables' => array(
                'bs-primary' => '#4F46E5',
                'bs-secondary' => '#8B5CF6',
                'button-border-radius' => '8px',
                'button-3d-offset' => '4px',
                'ui-style' => 'modern',
            )
        ),
        'minimal' => array(
            'name' => 'Minimalista',
            'description' => 'Diseño limpio y sutil con elementos simplificados',
            'variables' => array(
                'bs-primary' => '#0EA5E9',
                'bs-secondary' => '#3B82F6',
                'button-border-radius' => '4px',
                'button-3d-offset' => '3px',
                'ui-style' => 'minimalist',
            )
        ),
        'neo-brutalism' => array(
            'name' => 'Neo Brutalismo',
            'description' => 'Estilo Neo Brutalismo con bordes marcados, sombras rectangulares y colores vibrantes',
            'variables' => array(
                'bs-primary' => '#FF596A',
                'bs-secondary' => '#8B5CF6',
                'bs-success' => '#10B981',
                'bs-info' => '#3B82F6',
                'bs-warning' => '#FBBF24',
                'bs-danger' => '#EF4444',
                'card-border-radius' => '12px',
                'button-border-radius' => '8px',
                'button-3d-offset' => '8px',
                'button-3d-hover-offset' => '4px',
                'ui-style' => 'neo-brutalism',
            )
        ),
        'bold' => array(
            'name' => 'Audaz',
            'description' => 'Elementos destacados con efectos pronunciados y colores vivos',
            'variables' => array(
                'bs-primary' => '#6366F1',
                'bs-secondary' => '#EC4899',
                'button-border-radius' => '6px',
                'button-3d-offset' => '6px',
                'ui-style' => 'bold',
            )
        ),
        'enterprise' => array(
            'name' => 'Empresarial',
            'description' => 'Apariencia profesional con colores sobrios y efectos sutiles',
            'variables' => array(
                'bs-primary' => '#2563EB',
                'bs-secondary' => '#475569',
                'button-border-radius' => '3px',
                'button-3d-offset' => '3px',
                'ui-style' => 'enterprise',
            )
        ),
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
        add_action('wp_ajax_vortex_apply_preset', array($this, 'ajax_apply_preset'));
        add_action('wp_ajax_vortex_generate_color_variants', array($this, 'ajax_generate_color_variants'));
        
        // Agregar un indicador de estilo en el frontend
        add_action('wp_footer', array($this, 'add_style_indicator'));
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
     * Agrega un indicador de estilo en el frontend
     */
    public function add_style_indicator() {
        // Solo mostrar si el usuario tiene permisos
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        $current_style = isset($custom_variables['ui-style']) ? $custom_variables['ui-style'] : $this->default_variables['ui-style'];
        $style_name = isset($this->design_styles[$current_style]) ? $this->design_styles[$current_style] : 'Moderno';
        
        // Estilos CSS para el indicador
        echo '<style>
            #theme-style-indicator {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: var(--bs-primary, #4F46E5);
                color: white;
                padding: 8px 15px;
                border-radius: 30px;
                font-size: 14px;
                z-index: 9999;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                display: flex;
                align-items: center;
                cursor: pointer;
                transition: all 0.3s ease;
                border: 2px solid var(--bs-dark, #111827);
            }
            .theme-style-icon {
                margin-right: 8px;
                font-size: 18px;
            }
            #theme-style-indicator:hover {
                transform: translateY(-5px);
            }
            #theme-style-selector {
                position: fixed;
                bottom: 70px;
                right: 20px;
                background-color: white;
                border-radius: 8px;
                padding: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                z-index: 9999;
                width: 250px;
                display: none;
                border: 2px solid var(--bs-dark, #111827);
            }
            #theme-style-selector h4 {
                margin-top: 0;
                margin-bottom: 10px;
                font-size: 16px;
                font-weight: 600;
                color: var(--bs-dark, #111827);
            }
            .style-option {
                display: flex;
                align-items: center;
                padding: 8px 10px;
                margin-bottom: 5px;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.2s ease;
            }
            .style-option:hover {
                background-color: #f5f5f5;
            }
            .style-option.active {
                background-color: var(--bs-primary-light, #7A74EE);
                color: white;
            }
            .style-option-icon {
                margin-right: 10px;
                font-size: 16px;
            }
            .style-option-name {
                font-size: 14px;
                font-weight: 500;
            }
            @media (max-width: 768px) {
                #theme-style-indicator {
                    bottom: 10px;
                    right: 10px;
                    padding: 5px 10px;
                    font-size: 12px;
                }
                #theme-style-selector {
                    bottom: 50px;
                    right: 10px;
                    width: 200px;
                }
            }
        </style>';
        
        // HTML para el indicador y selector
        echo '<div id="theme-style-indicator">
            <i class="ti ti-brush theme-style-icon"></i>
            <span class="theme-style-name">Estilo: ' . esc_html($style_name) . '</span>
        </div>';
        
        echo '<div id="theme-style-selector">
            <h4>Seleccionar Estilo</h4>';
            
        foreach ($this->design_styles as $style_key => $style_label) {
            $is_active = ($style_key === $current_style) ? ' active' : '';
            echo '<div class="style-option' . $is_active . '" data-style="' . esc_attr($style_key) . '">
                <i class="ti ti-check style-option-icon"></i>
                <span class="style-option-name">' . esc_html($style_label) . '</span>
            </div>';
        }
            
        echo '</div>';
        
        // JavaScript para el selector
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var indicator = document.getElementById("theme-style-indicator");
                var selector = document.getElementById("theme-style-selector");
                var styleOptions = document.querySelectorAll(".style-option");
                var isOpen = false;
                
                // Función para mostrar/ocultar el selector
                indicator.addEventListener("click", function() {
                    isOpen = !isOpen;
                    selector.style.display = isOpen ? "block" : "none";
                });
                
                // Ocultar selector al hacer clic fuera
                document.addEventListener("click", function(event) {
                    var isClickInside = indicator.contains(event.target) || selector.contains(event.target);
                    if (!isClickInside && isOpen) {
                        isOpen = false;
                        selector.style.display = "none";
                    }
                });
                
                // Cambiar estilo al hacer clic en una opción
                styleOptions.forEach(function(option) {
                    option.addEventListener("click", function() {
                        var style = this.getAttribute("data-style");
                        
                        // Llamar a Ajax para aplicar preset
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "' . admin_url('admin-ajax.php') . '", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                location.reload();
                            }
                        };
                        xhr.send("action=vortex_apply_preset&preset=" + style + "&nonce=' . wp_create_nonce('vortex_theme_customizer_nonce') . '");
                    });
                });
            });
        </script>';
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
        
        // Cargar el estilo UI específico
        $this->enqueue_ui_style();
    }
    
    /**
     * Cargar el estilo UI específico basado en la configuración
     */
    public function enqueue_ui_style() {
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        $current_style = isset($custom_variables['ui-style']) ? $custom_variables['ui-style'] : $this->default_variables['ui-style'];
        
        // Cargar estilos específicos para Neo Brutalism
        if ($current_style === 'neo-brutalism') {
            // Enqueue los estilos Neo Brutalism
            wp_enqueue_style('vortex-neo-brutalism', VORTEX_UI_PANEL_URL . 'assets/css/neo-brutalism-panel.css', array(), VORTEX_UI_PANEL_VERSION);
            wp_enqueue_script('vortex-neo-brutalism-script', VORTEX_UI_PANEL_URL . 'assets/js/neo-brutalism.js', array('jquery'), VORTEX_UI_PANEL_VERSION, true);
            
            // Agregar clase al body
            add_filter('body_class', function($classes) {
                $classes[] = 'neo-brutalism-style';
                return $classes;
            });
        }
        
        // Cargar estilos específicos para Minimalista
        else if ($current_style === 'minimalist') {
            wp_enqueue_style('vortex-minimalist', VORTEX_UI_PANEL_URL . 'assets/css/minimalist.css', array(), VORTEX_UI_PANEL_VERSION);
            
            add_filter('body_class', function($classes) {
                $classes[] = 'minimalist-style';
                return $classes;
            });
        }
        
        // Agregar clase general para el estilo actual
        add_filter('body_class', function($classes) use ($current_style) {
            $classes[] = 'ui-style-' . $current_style;
            return $classes;
        });
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
        $css .= "}\n\n";
        
        // Integración con botones 3D
        $css .= $this->generate_button_styles($custom_variables);
        
        // Integración con alertas y estados
        $css .= $this->generate_alert_styles($custom_variables);
        
        return $css;
    }
    
    /**
     * Generar estilos para botones 3D integrados con el tema
     */
    private function generate_button_styles($custom_variables) {
        // Los colores de los botones ahora se obtienen directamente de los colores del tema
        $offset = isset($custom_variables['button-3d-offset']) ? $custom_variables['button-3d-offset'] : $this->default_variables['button-3d-offset'];
        $hover_offset = isset($custom_variables['button-3d-hover-offset']) ? $custom_variables['button-3d-hover-offset'] : $this->default_variables['button-3d-hover-offset'];
        $transition = isset($custom_variables['button-3d-transition']) ? $custom_variables['button-3d-transition'] : $this->default_variables['button-3d-transition'];
        $border_radius = isset($custom_variables['button-border-radius']) ? $custom_variables['button-border-radius'] : $this->default_variables['button-border-radius'];
        
        // Crear CSS para botones 3D
        $css = "/* Estilos de botones 3D integrados con el tema */\n";
        
        // Variables globales para botones 3D
        $css .= ".btn-3d-wrapper, .button-3d-wrapper {\n";
        $css .= "    --button-3d-offset: {$offset};\n";
        $css .= "    --button-3d-hover-offset: {$hover_offset};\n";
        $css .= "    --button-3d-transition: {$transition};\n";
        $css .= "    --button-border-radius: {$border_radius};\n";
        $css .= "    position: relative;\n";
        $css .= "    display: inline-block;\n";
        $css .= "    margin-right: 10px;\n";
        $css .= "    margin-bottom: var(--button-3d-offset);\n";
        $css .= "}\n\n";
        
        // Parte trasera del botón
        $css .= ".btn-3d-back, .button-3d-back {\n";
        $css .= "    position: absolute;\n";
        $css .= "    top: var(--button-3d-offset);\n";
        $css .= "    left: var(--button-3d-offset);\n";
        $css .= "    width: 100%;\n";
        $css .= "    height: 100%;\n";
        $css .= "    background-color: transparent;\n";
        $css .= "    border: 1px solid rgba(0, 0, 0, 0.2);\n";
        $css .= "    border-radius: var(--button-border-radius);\n";
        $css .= "    z-index: 1;\n";
        $css .= "    box-sizing: border-box;\n";
        $css .= "}\n\n";
        
        // Botón frontal
        $css .= ".btn-3d, .button-3d {\n";
        $css .= "    display: inline-flex;\n";
        $css .= "    align-items: center;\n";
        $css .= "    justify-content: center;\n";
        $css .= "    padding: 8px 16px;\n";
        $css .= "    font-size: var(--bs-body-font-size, 14px);\n";
        $css .= "    font-weight: 500;\n";
        $css .= "    color: #fff;\n";
        $css .= "    background-color: #6c757d;\n";
        $css .= "    border: 1px solid transparent;\n";
        $css .= "    border-radius: var(--button-border-radius);\n";
        $css .= "    cursor: pointer;\n";
        $css .= "    position: relative;\n";
        $css .= "    z-index: 2;\n";
        $css .= "    text-decoration: none;\n";
        $css .= "    transition: transform var(--button-3d-transition);\n";
        $css .= "}\n\n";
        
        // Efectos hover y active
        $css .= ".btn-3d-wrapper:hover .btn-3d, .button-3d-wrapper:hover .button-3d {\n";
        $css .= "    transform: translate(var(--button-3d-hover-offset), var(--button-3d-hover-offset));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper:active .btn-3d, .button-3d-wrapper:active .button-3d {\n";
        $css .= "    transform: translate(var(--button-3d-offset), var(--button-3d-offset));\n";
        $css .= "}\n\n";
        
        // Variantes de botones referenciando directamente a las variables del tema
        $css .= ".btn-3d-wrapper.primary .btn-3d, .button-3d-wrapper.primary .button-3d {\n";
        $css .= "    background-color: var(--bs-primary);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.primary .btn-3d-back, .button-3d-wrapper.primary .button-3d-back {\n";
        $css .= "    border-color: var(--bs-primary-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.secondary .btn-3d, .button-3d-wrapper.secondary .button-3d {\n";
        $css .= "    background-color: var(--bs-secondary);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.secondary .btn-3d-back, .button-3d-wrapper.secondary .button-3d-back {\n";
        $css .= "    border-color: var(--bs-secondary-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.success .btn-3d, .button-3d-wrapper.success .button-3d {\n";
        $css .= "    background-color: var(--bs-success);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.success .btn-3d-back, .button-3d-wrapper.success .button-3d-back {\n";
        $css .= "    border-color: var(--bs-success-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.danger .btn-3d, .button-3d-wrapper.danger .button-3d {\n";
        $css .= "    background-color: var(--bs-danger);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.danger .btn-3d-back, .button-3d-wrapper.danger .button-3d-back {\n";
        $css .= "    border-color: var(--bs-danger-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.warning .btn-3d, .button-3d-wrapper.warning .button-3d {\n";
        $css .= "    background-color: var(--bs-warning);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.warning .btn-3d-back, .button-3d-wrapper.warning .button-3d-back {\n";
        $css .= "    border-color: var(--bs-warning-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.info .btn-3d, .button-3d-wrapper.info .button-3d {\n";
        $css .= "    background-color: var(--bs-info);\n";
        $css .= "    color: #fff;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.info .btn-3d-back, .button-3d-wrapper.info .button-3d-back {\n";
        $css .= "    border-color: var(--bs-info-dark, rgba(0, 0, 0, 0.2));\n";
        $css .= "}\n";
        
        // Botones con iconos
        $css .= ".btn-3d-icon, .button-3d-icon {\n";
        $css .= "    margin-left: 8px;\n";
        $css .= "}\n\n";
        
        // Tamaños de botones
        $css .= ".btn-3d-wrapper.sm .btn-3d, .button-3d-wrapper.sm .button-3d {\n";
        $css .= "    padding: 5px 10px;\n";
        $css .= "    font-size: 12px;\n";
        $css .= "}\n\n";
        
        $css .= ".btn-3d-wrapper.lg .btn-3d, .button-3d-wrapper.lg .button-3d {\n";
        $css .= "    padding: 12px 20px;\n";
        $css .= "    font-size: 16px;\n";
        $css .= "}\n\n";
        
        return $css;
    }
    
    /**
     * Generar estilos para alertas y estados
     */
    private function generate_alert_styles($custom_variables) {
        $css = "/* Estilos de alertas y estados */\n";
        
        // Sistema de alertas
        $css .= ".alert {\n";
        $css .= "    padding: 1rem;\n";
        $css .= "    margin-bottom: 1rem;\n";
        $css .= "    border-radius: var(--button-border-radius, 4px);\n";
        $css .= "    display: flex;\n";
        $css .= "    align-items: flex-start;\n";
        $css .= "    border-left-width: 4px;\n";
        $css .= "    border-left-style: solid;\n";
        $css .= "}\n\n";
        
        $css .= ".alert-icon {\n";
        $css .= "    margin-right: 0.75rem;\n";
        $css .= "    font-size: 1.25rem;\n";
        $css .= "    display: flex;\n";
        $css .= "    align-items: center;\n";
        $css .= "    justify-content: center;\n";
        $css .= "}\n\n";
        
        $css .= ".alert-content {\n";
        $css .= "    flex: 1;\n";
        $css .= "}\n\n";
        
        $css .= ".alert-title {\n";
        $css .= "    font-weight: 600;\n";
        $css .= "    margin-bottom: 0.25rem;\n";
        $css .= "}\n\n";
        
        $css .= ".alert-message {\n";
        $css .= "    margin-bottom: 0;\n";
        $css .= "}\n\n";
        
        // Variantes de alertas usando variables del tema
        $css .= ".alert-success {\n";
        $css .= "    background-color: var(--bs-success-light, #D1FAE5);\n";
        $css .= "    border-left-color: var(--bs-success, #10B981);\n";
        $css .= "    color: var(--bs-success-dark, #065F46);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-success .alert-icon {\n";
        $css .= "    color: var(--bs-success, #10B981);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-warning {\n";
        $css .= "    background-color: var(--bs-warning-light, #FEF3C7);\n";
        $css .= "    border-left-color: var(--bs-warning, #F59E0B);\n";
        $css .= "    color: var(--bs-warning-dark, #92400E);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-warning .alert-icon {\n";
        $css .= "    color: var(--bs-warning, #F59E0B);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-danger {\n";
        $css .= "    background-color: var(--bs-danger-light, #FEE2E2);\n";
        $css .= "    border-left-color: var(--bs-danger, #EF4444);\n";
        $css .= "    color: var(--bs-danger-dark, #B91C1C);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-danger .alert-icon {\n";
        $css .= "    color: var(--bs-danger, #EF4444);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-info {\n";
        $css .= "    background-color: var(--bs-info-light, #DBEAFE);\n";
        $css .= "    border-left-color: var(--bs-info, #3B82F6);\n";
        $css .= "    color: var(--bs-info-dark, #1E40AF);\n";
        $css .= "}\n\n";
        
        $css .= ".alert-info .alert-icon {\n";
        $css .= "    color: var(--bs-info, #3B82F6);\n";
        $css .= "}\n\n";
        
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
     * Generar una variante de color (más claro o más oscuro)
     */
    private function adjust_color_brightness($hex, $percent) {
        // Remover el # si existe
        $hex = ltrim($hex, '#');
        
        // Convertir a RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Ajustar brillo
        if ($percent > 0) {
            // Más claro
            $r = round($r + (255 - $r) * $percent / 100);
            $g = round($g + (255 - $g) * $percent / 100);
            $b = round($b + (255 - $b) * $percent / 100);
        } else {
            // Más oscuro
            $percent = abs($percent);
            $r = round($r * (100 - $percent) / 100);
            $g = round($g * (100 - $percent) / 100);
            $b = round($b * (100 - $percent) / 100);
        }
        
        // Convertir de nuevo a hexadecimal
        return '#' . sprintf("%02x%02x%02x", $r, $g, $b);
    }
    
    /**
     * Generar variantes de un color (claro, oscuro, etc.)
     */
    public function generate_color_variants($color) {
        return array(
            'lightest' => $this->adjust_color_brightness($color, 90),
            'lighter' => $this->adjust_color_brightness($color, 70),
            'light' => $this->adjust_color_brightness($color, 30),
            'base' => $color,
            'dark' => $this->adjust_color_brightness($color, -20),
            'darker' => $this->adjust_color_brightness($color, -40),
            'darkest' => $this->adjust_color_brightness($color, -60),
        );
    }
    
    /**
     * Encolar fuentes de Google
     */
    private function enqueue_google_fonts() {
        $custom_variables = get_option('vortex_theme_custom_variables', array());
        
        // Verificar si hay una fuente personalizada
        if (isset($custom_variables['bs-body-font-family']) || isset($custom_variables['bs-heading-font-family'])) {
            $fonts_to_load = array();
            
            // Procesar fuente del cuerpo
            if (isset($custom_variables['bs-body-font-family'])) {
                $body_font = $this->extract_font_name($custom_variables['bs-body-font-family']);
                if ($body_font && !$this->is_system_font($body_font)) {
                    $fonts_to_load[$body_font] = true;
                }
            }
            
            // Procesar fuente de títulos
            if (isset($custom_variables['bs-heading-font-family'])) {
                $heading_font = $this->extract_font_name($custom_variables['bs-heading-font-family']);
                if ($heading_font && !$this->is_system_font($heading_font)) {
                    $fonts_to_load[$heading_font] = true;
                }
            }
            
            // Cargar fuentes si es necesario
            if (!empty($fonts_to_load)) {
                $google_fonts = array();
                foreach (array_keys($fonts_to_load) as $font) {
                    $google_fonts[] = $font . ':300,400,500,600,700';
                }
                
                $google_fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $google_fonts) . '&display=swap';
                wp_enqueue_style('vortex-google-fonts', $google_fonts_url, array(), null);
            }
        }
    }
    
    /**
     * Extraer el nombre de la fuente de un valor font-family
     */
    private function extract_font_name($font_family) {
        $font_family = trim($font_family, "'");
        $parts = explode(',', $font_family);
        return trim($parts[0]);
    }
    
    /**
     * Verificar si es una fuente del sistema
     */
    private function is_system_font($font_name) {
        $system_fonts = array('Arial', 'Helvetica', 'Times New Roman', 'serif', 'sans-serif', 'monospace', 'cursive', 'fantasy');
        return in_array($font_name, $system_fonts);
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
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-slider');
        
        // Encolar script personalizado
        wp_enqueue_script('vortex-theme-customizer', VORTEX_UI_PANEL_URL . 'assets/js/theme-customizer.js', array('jquery', 'wp-color-picker', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-slider'), VORTEX_UI_PANEL_VERSION, true);
        
        // Pasar variables al script
        wp_localize_script('vortex-theme-customizer', 'vortexThemeCustomizer', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('vortex_theme_customizer_nonce'),
            'presets' => $this->available_presets,
            'designStyles' => $this->design_styles,
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
        
        // Generar CSS actualizado
        $updated_css = $this->generate_custom_css();
        
        // Responder con éxito
        wp_send_json_success(array(
            'message' => 'Estilos guardados correctamente',
            'css' => $updated_css
        ));
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
        wp_send_json_success(array(
            'message' => 'Estilos restablecidos a valores por defecto',
            'variables' => $this->default_variables
        ));
    }
    
    /**
     * Aplicar un preset de diseño vía AJAX
     */
    public function ajax_apply_preset() {
        // Verificar nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_theme_customizer_nonce')) {
            wp_send_json_error('Invalid security token');
        }
        
        // Verificar permisos
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Obtener el preset solicitado
        $preset_key = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : '';
        
        if (!isset($this->available_presets[$preset_key])) {
            wp_send_json_error('Preset not found');
        }
        
        // Obtener variables actuales
        $current_variables = get_option('vortex_theme_custom_variables', array());
        
        // Combinar con variables del preset
        $preset_variables = $this->available_presets[$preset_key]['variables'];
        $updated_variables = array_merge($current_variables, $preset_variables);
        
        // Guardar variables actualizadas
        update_option('vortex_theme_custom_variables', $updated_variables);
        
        // Responder con éxito
        wp_send_json_success(array(
            'message' => 'Preset aplicado correctamente',
            'variables' => $updated_variables
        ));
    }
    
    /**
     * Generar variantes de color vía AJAX
     */
    public function ajax_generate_color_variants() {
        // Verificar nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vortex_theme_customizer_nonce')) {
            wp_send_json_error('Invalid security token');
        }
        
        // Verificar permisos
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Obtener el color base y el nombre de la variable
        $color = isset($_POST['color']) ? sanitize_hex_color($_POST['color']) : '';
        $variable_name = isset($_POST['variable_name']) ? sanitize_text_field($_POST['variable_name']) : '';
        
        if (empty($color) || empty($variable_name)) {
            wp_send_json_error('Missing color or variable name');
        }
        
        // Generar variantes
        $variants = $this->generate_color_variants($color);
        
        // Preparar variables para guardar
        $base_name = str_replace('bs-', '', $variable_name);
        $color_variables = array();
        
        foreach ($variants as $variant => $variant_color) {
            if ($variant !== 'base') {
                $variant_name = "bs-{$base_name}-{$variant}";
                $color_variables[$variant_name] = $variant_color;
            }
        }
        
        // Obtener variables actuales
        $current_variables = get_option('vortex_theme_custom_variables', array());
        
        // Combinar con las nuevas variantes
        $updated_variables = array_merge($current_variables, $color_variables);
        
        // Guardar variables actualizadas
        update_option('vortex_theme_custom_variables', $updated_variables);
        
        // Responder con éxito
        wp_send_json_success(array(
            'message' => 'Variantes de color generadas correctamente',
            'variants' => $color_variables
        ));
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
     * Obtener presets disponibles
     */
    public function get_available_presets() {
        return $this->available_presets;
    }
    
    /**
     * Obtener estilos de diseño disponibles
     */
    public function get_design_styles() {
        return $this->design_styles;
    }
    
    /**
     * Obtener las variables por defecto
     */
    public function get_default_variables() {
        return $this->default_variables;
    }
}
