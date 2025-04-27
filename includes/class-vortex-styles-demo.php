<?php
/**
 * Clase para la demostración de estilos de UI
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Styles_Demo {
    
    /**
     * Instancia única de esta clase
     */
    private static $instance = null;
    
    /**
     * Constructor
     */
    private function __construct() {
        // Registrar hooks
        add_action('admin_menu', array($this, 'register_menu_page'));
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
     * Registrar la página de menú en el admin
     */
    public function register_menu_page() {
        add_submenu_page(
            'vortex-ui-panel',
            'Demostración de Estilos',
            'Estilos de UI',
            'manage_options',
            'vortex-ui-styles-demo',
            array($this, 'render_styles_demo_page')
        );
    }
    
    /**
     * Encolar estilos para la página de demostración
     */
    public function enqueue_admin_styles($hook) {
        // Solo cargar en la página de demostración de estilos
        if ($hook !== 'vortex-ui-panel_page_vortex-ui-styles-demo') {
            return;
        }
        
        // Encolar estilos
        wp_enqueue_style('vortex-styles-demo', VORTEX_UI_PANEL_URL . 'assets/css/styles-demo.css', array(), VORTEX_UI_PANEL_VERSION);
        
        // Estilos para diferentes temas
        wp_enqueue_style('vortex-neo-brutalism', VORTEX_UI_PANEL_URL . 'assets/css/neo-brutalism-panel.css', array(), VORTEX_UI_PANEL_VERSION);
        wp_enqueue_style('vortex-minimalist', VORTEX_UI_PANEL_URL . 'assets/css/minimalist.css', array(), VORTEX_UI_PANEL_VERSION);
        
        // Iconos Tabler
        wp_enqueue_style('tabler-icons', 'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css', array(), '2.44.0');
        
        // Script para cambiar entre estilos
        wp_enqueue_script('vortex-styles-demo', VORTEX_UI_PANEL_URL . 'assets/js/styles-demo.js', array('jquery'), VORTEX_UI_PANEL_VERSION, true);
        
        // Pasar variables al script
        wp_localize_script('vortex-styles-demo', 'vortexStylesDemo', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('vortex_styles_demo_nonce')
        ));
    }
    
    /**
     * Renderizar la página de demostración de estilos
     */
    public function render_styles_demo_page() {
        // Obtener el tema personalizado actual
        $theme_customizer = Vortex_Theme_Customizer::get_instance();
        $custom_variables = $theme_customizer->get_custom_variables();
        $current_style = isset($custom_variables['ui-style']) ? $custom_variables['ui-style'] : 'modern';
        $design_styles = $theme_customizer->get_design_styles();
        
        // Cabecera de la página
        ?>
        <div class="wrap vortex-styles-demo-page">
            <h1><i class="ti ti-brush"></i> Demostración de Estilos UI</h1>
            
            <div class="vortex-styles-toolbar">
                <div class="vortex-styles-selector">
                    <label for="style-selector">Seleccionar Estilo:</label>
                    <select id="style-selector">
                        <?php foreach ($design_styles as $style_key => $style_name) : ?>
                            <option value="<?php echo esc_attr($style_key); ?>" <?php selected($current_style, $style_key); ?>>
                                <?php echo esc_html($style_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button id="apply-style" class="button button-primary">Aplicar Estilo</button>
                </div>
                
                <div class="vortex-theme-mode">
                    <label>Modo:</label>
                    <button id="light-mode" class="button <?php echo (isset($_COOKIE['vortex_demo_dark_mode']) && $_COOKIE['vortex_demo_dark_mode'] == '0') ? 'active' : ''; ?>">
                        <i class="ti ti-sun"></i> Claro
                    </button>
                    <button id="dark-mode" class="button <?php echo (isset($_COOKIE['vortex_demo_dark_mode']) && $_COOKIE['vortex_demo_dark_mode'] == '1') ? 'active' : ''; ?>">
                        <i class="ti ti-moon"></i> Oscuro
                    </button>
                </div>
            </div>
            
            <div class="vortex-styles-info notice notice-info">
                <p>Esta página muestra una vista previa de los diferentes estilos disponibles para la interfaz de usuario. Selecciona un estilo de la lista desplegable y haz clic en "Aplicar Estilo" para cambiar el aspecto de tu panel de control.</p>
            </div>
            
            <div class="vortex-styles-preview-wrapper">
                <div id="style-preview" class="vortex-preview-dashboard <?php echo isset($_COOKIE['vortex_demo_dark_mode']) && $_COOKIE['vortex_demo_dark_mode'] == '1' ? 'dark-mode' : ''; ?> ui-style-<?php echo esc_attr($current_style); ?>">
                    <div class="vortex-preview-sidebar">
                        <div class="vortex-preview-sidebar-header">
                            <div class="vortex-preview-logo">
                                <div class="vortex-preview-logo-image">V</div>
                                <div class="vortex-preview-logo-text">Panel SaaS</div>
                            </div>
                        </div>
                        <div class="vortex-preview-menu">
                            <div class="vortex-preview-menu-section">
                                <div class="vortex-preview-menu-section-title">Principal</div>
                                <a href="#" class="vortex-preview-menu-item active">
                                    <i class="ti ti-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="#" class="vortex-preview-menu-item">
                                    <i class="ti ti-users"></i>
                                    <span>Usuarios</span>
                                </a>
                                <a href="#" class="vortex-preview-menu-item">
                                    <i class="ti ti-chart-bar"></i>
                                    <span>Analíticas</span>
                                </a>
                                <a href="#" class="vortex-preview-menu-item">
                                    <i class="ti ti-settings"></i>
                                    <span>Configuración</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="vortex-preview-content">
                        <div class="vortex-preview-topbar">
                            <div class="vortex-preview-topbar-left">
                                <button class="vortex-preview-menu-toggle">
                                    <i class="ti ti-menu-2"></i>
                                </button>
                                <div class="vortex-preview-search">
                                    <i class="ti ti-search"></i>
                                    <input type="text" placeholder="Buscar...">
                                    <kbd>⌘K</kbd>
                                </div>
                            </div>
                            <div class="vortex-preview-topbar-right">
                                <button class="vortex-preview-icon-button">
                                    <i class="ti ti-bell"></i>
                                </button>
                                <button class="vortex-preview-icon-button">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="vortex-preview-user">
                                    <div class="vortex-preview-avatar">M</div>
                                    <span class="vortex-preview-username">Admin</span>
                                </div>
                            </div>
                        </div>
                        <div class="vortex-preview-dashboard-content">
                            <div class="vortex-preview-page-header">
                                <h1>Dashboard</h1>
                                <div class="vortex-preview-actions">
                                    <div class="vortex-preview-button-group">
                                        <button class="vortex-preview-button outline">
                                            <i class="ti ti-download"></i>
                                            Exportar
                                        </button>
                                        <button class="vortex-preview-button primary">
                                            <i class="ti ti-plus"></i>
                                            Nuevo Reporte
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Estadísticas -->
                            <div class="vortex-preview-stats-grid">
                                <div class="vortex-preview-stat-card">
                                    <div class="vortex-preview-stat-card-content">
                                        <div class="vortex-preview-stat-card-icon primary">
                                            <i class="ti ti-currency-dollar"></i>
                                        </div>
                                        <div class="vortex-preview-stat-card-info">
                                            <div class="vortex-preview-stat-card-title">Total Ingresos</div>
                                            <div class="vortex-preview-stat-card-value">$124,592.40</div>
                                            <div class="vortex-preview-stat-card-trend positive">
                                                <i class="ti ti-arrow-up"></i>
                                                <span>12.4%</span>
                                                <span class="vortex-preview-stat-card-trend-period">vs el mes pasado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vortex-preview-stat-card">
                                    <div class="vortex-preview-stat-card-content">
                                        <div class="vortex-preview-stat-card-icon success">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <div class="vortex-preview-stat-card-info">
                                            <div class="vortex-preview-stat-card-title">Usuarios Activos</div>
                                            <div class="vortex-preview-stat-card-value">4,893</div>
                                            <div class="vortex-preview-stat-card-trend positive">
                                                <i class="ti ti-arrow-up"></i>
                                                <span>17.2%</span>
                                                <span class="vortex-preview-stat-card-trend-period">vs el mes pasado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vortex-preview-stat-card">
                                    <div class="vortex-preview-stat-card-content">
                                        <div class="vortex-preview-stat-card-icon info">
                                            <i class="ti ti-chart-line"></i>
                                        </div>
                                        <div class="vortex-preview-stat-card-info">
                                            <div class="vortex-preview-stat-card-title">Tasa de Conversión</div>
                                            <div class="vortex-preview-stat-card-value">3.42%</div>
                                            <div class="vortex-preview-stat-card-trend negative">
                                                <i class="ti ti-arrow-down"></i>
                                                <span>2.1%</span>
                                                <span class="vortex-preview-stat-card-trend-period">vs el mes pasado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Chat AI -->
                            <div class="vortex-preview-chat-container">
                                <div class="vortex-preview-chat-header">
                                    <div class="vortex-preview-chat-title">
                                        <i class="ti ti-message-circle"></i> Chat AI
                                        <span class="status">ACTIVO</span>
                                    </div>
                                </div>
                                <div class="vortex-preview-chat-body">
                                    <div class="vortex-preview-message">
                                        <div class="vortex-preview-message-avatar ai">
                                            AI
                                        </div>
                                        <div class="vortex-preview-message-content">
                                            Puedo analizar tus datos de ventas recientes y proporcionar información sobre tendencias. Tus ingresos han aumentado un 12.4% en comparación con el mes pasado. ¿Te gustaría un desglose detallado?
                                        </div>
                                    </div>
                                    <div class="vortex-preview-message">
                                        <div class="vortex-preview-message-avatar user">
                                            M
                                        </div>
                                        <div class="vortex-preview-message-content">
                                            Sí, muéstrame el desglose por categoría de producto y destaca los mejores productos.
                                        </div>
                                    </div>
                                </div>
                                <div class="vortex-preview-chat-input-container">
                                    <input type="text" class="vortex-preview-chat-input" placeholder="Pregunta al asistente AI...">
                                    <button class="vortex-preview-chat-send">
                                        <i class="ti ti-send"></i> Enviar
                                    </button>
                                </div>
                                <div class="vortex-preview-chat-tokens">
                                    <span>500 tokens restantes</span>
                                    <a href="#" class="vortex-preview-chat-view-all">Ver todas las conversaciones →</a>
                                </div>
                            </div>
                            
                            <!-- Botones -->
                            <div class="vortex-preview-card">
                                <div class="vortex-preview-card-header">
                                    <h3 class="vortex-preview-card-title">Botones</h3>
                                </div>
                                <div class="vortex-preview-card-body">
                                    <h4>Botones Estándar</h4>
                                    <div class="vortex-preview-button-group" style="margin-bottom: 20px;">
                                        <button class="btn btn-primary">Primario</button>
                                        <button class="btn btn-secondary">Secundario</button>
                                        <button class="btn btn-success">Éxito</button>
                                        <button class="btn btn-danger">Peligro</button>
                                    </div>
                                    
                                    <h4>Botones 3D</h4>
                                    <div>
                                        <div class="btn-3d-wrapper primary">
                                            <div class="btn-3d-back"></div>
                                            <a href="#" class="btn-3d">Primario</a>
                                        </div>
                                        <div class="btn-3d-wrapper secondary">
                                            <div class="btn-3d-back"></div>
                                            <a href="#" class="btn-3d">Secundario</a>
                                        </div>
                                        <div class="btn-3d-wrapper success">
                                            <div class="btn-3d-back"></div>
                                            <a href="#" class="btn-3d">Éxito</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alertas -->
                            <div class="vortex-preview-card">
                                <div class="vortex-preview-card-header">
                                    <h3 class="vortex-preview-card-title">Alertas</h3>
                                </div>
                                <div class="vortex-preview-card-body">
                                    <div class="alert alert-success">
                                        <div class="alert-icon">
                                            <i class="ti ti-circle-check"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Operación exitosa</div>
                                            <div class="alert-message">Los cambios han sido guardados correctamente.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-warning">
                                        <div class="alert-icon">
                                            <i class="ti ti-alert-triangle"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Advertencia</div>
                                            <div class="alert-message">Algunos campos requieren tu atención antes de continuar.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-danger">
                                        <div class="alert-icon">
                                            <i class="ti ti-circle-x"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Error</div>
                                            <div class="alert-message">No se pudo completar la acción. Por favor, inténtalo de nuevo.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="vortex-styles-footer">
                <p>Selecciona el estilo que mejor se adapte a tus necesidades. Una vez aplicado, el estilo se utilizará en todo el panel de control.</p>
                <p><strong>Nota:</strong> El cambio de estilo afectará a todos los usuarios que accedan al panel de control.</p>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Cambiar entre modo claro y oscuro
                document.getElementById('light-mode').addEventListener('click', function() {
                    document.getElementById('style-preview').classList.remove('dark-mode');
                    document.getElementById('light-mode').classList.add('active');
                    document.getElementById('dark-mode').classList.remove('active');
                    document.cookie = "vortex_demo_dark_mode=0; path=/; max-age=86400";
                });
                
                document.getElementById('dark-mode').addEventListener('click', function() {
                    document.getElementById('style-preview').classList.add('dark-mode');
                    document.getElementById('dark-mode').classList.add('active');
                    document.getElementById('light-mode').classList.remove('active');
                    document.cookie = "vortex_demo_dark_mode=1; path=/; max-age=86400";
                });
                
                // Aplicar estilo seleccionado
                document.getElementById('apply-style').addEventListener('click', function() {
                    var styleSelector = document.getElementById('style-selector');
                    var selectedStyle = styleSelector.value;
                    
                    // Actualizar clase en la previsualización
                    var stylePreview = document.getElementById('style-preview');
                    stylePreview.className = 'vortex-preview-dashboard';
                    if (document.cookie.indexOf('vortex_demo_dark_mode=1') !== -1) {
                        stylePreview.classList.add('dark-mode');
                    }
                    stylePreview.classList.add('ui-style-' + selectedStyle);
                    
                    // Enviar solicitud AJAX para aplicar el estilo al tema
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                alert('El estilo ha sido aplicado correctamente. Los cambios se verán reflejados en todo el panel de control.');
                            }
                        }
                    };
                    xhr.send('action=vortex_apply_preset&preset=' + selectedStyle + '&nonce=<?php echo wp_create_nonce('vortex_theme_customizer_nonce'); ?>');
                });
            });
        </script>
        <?php
    }
}

// Inicializar la clase
add_action('plugins_loaded', function() {
    Vortex_Styles_Demo::get_instance();
});
