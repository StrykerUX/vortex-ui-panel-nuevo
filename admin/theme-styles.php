<?php
/**
 * Plantilla para la página del personalizador de estilos del tema
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

// Obtener variables personalizadas y categorías
$custom_variables = $this->theme_customizer->get_custom_variables();
$variable_categories = $this->theme_customizer->get_variable_categories();
$available_fonts = $this->theme_customizer->get_available_fonts();
$available_presets = $this->theme_customizer->get_available_presets();
$default_variables = $this->theme_customizer->get_default_variables();
?>

<div class="wrap vortex-ui-panel-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="vortex-page-header">
        <div class="vortex-page-header-title">
            <h2>Sistema de Personalización Avanzado</h2>
            <p class="vortex-subtitle">Personaliza tu plataforma SAAS con un sistema cohesivo de diseño</p>
        </div>
        
        <div class="vortex-actions-wrapper">
            <div class="button-3d-wrapper" id="vortex-reset-styles-wrapper">
                <div class="button-3d-back"></div>
                <button id="vortex-reset-styles" class="button-3d">
                    <i class="ti ti-refresh"></i>
                    Restablecer valores
                </button>
            </div>
            
            <div class="button-3d-wrapper primary" id="vortex-save-styles-wrapper">
                <div class="button-3d-back"></div>
                <button id="vortex-save-styles" class="button-3d">
                    <i class="ti ti-device-floppy"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
    
    <div class="vortex-notice notice-info hidden">
        <p></p>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Cerrar</span></button>
    </div>
    
    <div class="vortex-theme-styles-container">
        <div class="vortex-theme-styles-sidebar">
            <!-- Presets y Temas Predefinidos -->
            <div class="vortex-panel-box">
                <h2><i class="ti ti-palette"></i> Temas Predefinidos</h2>
                <p class="vortex-description">Selecciona un tema predefinido como punto de partida.</p>
                
                <div class="vortex-preset-grid">
                    <?php foreach ($available_presets as $preset_key => $preset): ?>
                        <div class="vortex-preset-item" data-preset="<?php echo esc_attr($preset_key); ?>">
                            <div class="vortex-preset-preview">
                                <div class="vortex-preset-preview-header" style="background-color: <?php echo esc_attr($preset['variables']['bs-primary']); ?>;">
                                    <div class="vortex-preset-logo"></div>
                                </div>
                                <div class="vortex-preset-preview-body">
                                    <div class="vortex-preset-button" style="background-color: <?php echo esc_attr($preset['variables']['bs-primary']); ?>;"></div>
                                </div>
                            </div>
                            <div class="vortex-preset-info">
                                <h4><?php echo esc_html($preset['name']); ?></h4>
                                <p><?php echo esc_html($preset['description']); ?></p>
                                <button class="vortex-apply-preset button button-small">
                                    Aplicar Tema
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Panel de Vista Previa -->
            <div class="vortex-panel-box">
                <h2><i class="ti ti-device-desktop"></i> Vista Previa</h2>
                
                <div class="vortex-preview-controls">
                    <div class="vortex-preview-mode-toggle">
                        <button class="vortex-preview-mode-btn active" data-mode="light">
                            <i class="ti ti-sun"></i> Claro
                        </button>
                        <button class="vortex-preview-mode-btn" data-mode="dark">
                            <i class="ti ti-moon"></i> Oscuro
                        </button>
                    </div>
                    
                    <div class="vortex-preview-device-toggle">
                        <button class="vortex-preview-device-btn active" data-device="desktop">
                            <i class="ti ti-device-desktop"></i>
                        </button>
                        <button class="vortex-preview-device-btn" data-device="tablet">
                            <i class="ti ti-device-tablet"></i>
                        </button>
                        <button class="vortex-preview-device-btn" data-device="mobile">
                            <i class="ti ti-device-mobile"></i>
                        </button>
                    </div>
                </div>
                
                <div class="vortex-theme-preview" data-theme-mode="light" data-device="desktop">
                    <div class="preview-header">
                        <div class="preview-logo">T</div>
                        <div class="preview-title">Panel SAAS</div>
                    </div>
                    <div class="preview-container">
                        <div class="preview-sidebar">
                            <div class="preview-menu-item active">
                                <span class="preview-icon">⬦</span>
                                <span class="preview-text">Dashboard</span>
                            </div>
                            <div class="preview-menu-item">
                                <span class="preview-icon">⬦</span>
                                <span class="preview-text">Usuarios</span>
                            </div>
                            <div class="preview-menu-item">
                                <span class="preview-icon">⬦</span>
                                <span class="preview-text">Analíticas</span>
                            </div>
                            <div class="preview-menu-item">
                                <span class="preview-icon">⬦</span>
                                <span class="preview-text">Configuración</span>
                            </div>
                        </div>
                        <div class="preview-content">
                            <!-- Tarjeta de Botones -->
                            <div class="preview-card">
                                <div class="preview-card-header">Botones</div>
                                <div class="preview-card-body">
                                    <div class="preview-section-title">Botones Estándar</div>
                                    <div class="preview-button-group">
                                        <button class="preview-button primary">Primario</button>
                                        <button class="preview-button secondary">Secundario</button>
                                        <button class="preview-button success">Éxito</button>
                                        <button class="preview-button danger">Peligro</button>
                                    </div>
                                    
                                    <div class="preview-section-title">Botones 3D</div>
                                    <div class="preview-button-group">
                                        <div class="btn-3d-wrapper primary">
                                            <div class="btn-3d-back"></div>
                                            <button class="btn-3d">
                                                <span class="btn-3d-text">Primario</span>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-3d-wrapper secondary">
                                            <div class="btn-3d-back"></div>
                                            <button class="btn-3d">
                                                <span class="btn-3d-text">Secundario</span>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-3d-wrapper success">
                                            <div class="btn-3d-back"></div>
                                            <button class="btn-3d">
                                                <span class="btn-3d-text">Éxito</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tarjeta de Alertas -->
                            <div class="preview-card">
                                <div class="preview-card-header">Alertas</div>
                                <div class="preview-card-body">
                                    <div class="alert alert-success">
                                        <div class="alert-icon">
                                            <i class="ti ti-circle-check"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Operación exitosa</div>
                                            <p class="alert-message">Los cambios han sido guardados correctamente.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-warning">
                                        <div class="alert-icon">
                                            <i class="ti ti-alert-triangle"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Advertencia</div>
                                            <p class="alert-message">Algunos campos requieren tu atención antes de continuar.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-danger">
                                        <div class="alert-icon">
                                            <i class="ti ti-alert-circle"></i>
                                        </div>
                                        <div class="alert-content">
                                            <div class="alert-title">Error</div>
                                            <p class="alert-message">No se pudo completar la acción. Por favor, inténtalo de nuevo.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="vortex-theme-styles-content">
            <div class="vortex-panel-box">
                <form id="vortex-theme-styles-form">
                    <div id="vortex-theme-styles-tabs">
                        <ul>
                            <?php foreach ($variable_categories as $category_key => $category) : ?>
                                <li>
                                    <a href="#tab-<?php echo esc_attr($category_key); ?>">
                                        <?php if (!empty($category['icon'])) : ?>
                                            <i class="<?php echo esc_attr($category['icon']); ?>"></i>
                                        <?php endif; ?>
                                        <?php echo esc_html($category['title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <?php foreach ($variable_categories as $category_key => $category) : ?>
                            <div id="tab-<?php echo esc_attr($category_key); ?>">
                                <div class="tab-header">
                                    <h3><?php echo esc_html($category['title']); ?></h3>
                                    <?php if (!empty($category['description'])) : ?>
                                        <p class="vortex-description"><?php echo esc_html($category['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="vortex-variables-grid">
                                    <?php foreach ($category['variables'] as $var_name => $var_label) : ?>
                                        <div class="vortex-variable-control">
                                            <label for="var-<?php echo esc_attr($var_name); ?>">
                                                <?php echo esc_html($var_label); ?>
                                                <span class="vortex-tooltip" title="<?php echo esc_attr($var_label); ?>">
                                                    <i class="ti ti-info-circle"></i>
                                                </span>
                                            </label>
                                            
                                            <?php if (strpos($var_name, 'color') !== false || (isset($custom_variables[$var_name]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $custom_variables[$var_name])) || strpos($var_name, 'bs-') === 0) : ?>
                                                <!-- Control para colores -->
                                                <div class="vortex-color-control">
                                                    <input type="text" 
                                                           id="var-<?php echo esc_attr($var_name); ?>" 
                                                           name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                           value="<?php echo esc_attr($custom_variables[$var_name]); ?>" 
                                                           class="vortex-color-picker"
                                                           data-default-color="<?php echo esc_attr($default_variables[$var_name]); ?>" />
                                                    
                                                    <?php if (in_array($var_name, array('bs-primary', 'bs-secondary', 'bs-success', 'bs-info', 'bs-warning', 'bs-danger'))) : ?>
                                                        <button type="button" class="vortex-generate-variants button button-small" data-variable="<?php echo esc_attr($var_name); ?>">
                                                            <i class="ti ti-color-swatch"></i> Generar variantes
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif (strpos($var_name, 'font-family') !== false) : ?>
                                                <!-- Control para fuentes -->
                                                <select id="var-<?php echo esc_attr($var_name); ?>" 
                                                        name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                        class="vortex-select">
                                                    <?php foreach ($available_fonts as $font_value => $font_label) : ?>
                                                        <option value="<?php echo esc_attr($font_value); ?>" <?php selected($custom_variables[$var_name], $font_value); ?>>
                                                            <?php echo esc_html($font_label); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="vortex-font-preview" style="font-family: <?php echo esc_attr($custom_variables[$var_name]); ?>">
                                                    Aa Bb Cc Dd Ee Ff Gg Hh Ii Jj Kk Ll Mm Nn Oo Pp Qq Rr Ss Tt Uu Vv Ww Xx Yy Zz 0123456789
                                                </div>
                                            <?php elseif (strpos($var_name, 'size') !== false || strpos($var_name, 'width') !== false || strpos($var_name, 'height') !== false || strpos($var_name, 'radius') !== false || strpos($var_name, 'offset') !== false) : ?>
                                                <!-- Control con slider para dimensiones -->
                                                <div class="vortex-dimension-control">
                                                    <input type="text" 
                                                           id="var-<?php echo esc_attr($var_name); ?>" 
                                                           name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                           value="<?php echo esc_attr($custom_variables[$var_name]); ?>" 
                                                           class="vortex-dimension-input" />
                                                    
                                                    <?php
                                                    // Extraer valor numérico y unidad
                                                    $value = $custom_variables[$var_name];
                                                    $numeric_value = (int)preg_replace('/[^0-9]/', '', $value);
                                                    $unit = preg_replace('/[0-9]/', '', $value);
                                                    
                                                    // Definir rangos según tipo de dimensión
                                                    $min = 0;
                                                    $max = 100;
                                                    $step = 1;
                                                    
                                                    if (strpos($var_name, 'radius') !== false) {
                                                        $max = 20;
                                                    } elseif (strpos($var_name, 'width') !== false) {
                                                        $max = 500;
                                                    } elseif (strpos($var_name, 'offset') !== false) {
                                                        $max = 10;
                                                    }
                                                    ?>
                                                    
                                                    <div class="vortex-slider-container">
                                                        <div class="vortex-slider" 
                                                             data-input-id="var-<?php echo esc_attr($var_name); ?>"
                                                             data-min="<?php echo esc_attr($min); ?>"
                                                             data-max="<?php echo esc_attr($max); ?>"
                                                             data-step="<?php echo esc_attr($step); ?>"
                                                             data-value="<?php echo esc_attr($numeric_value); ?>"
                                                             data-unit="<?php echo esc_attr($unit); ?>">
                                                        </div>
                                                        <span class="vortex-slider-value"><?php echo esc_html($value); ?></span>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <!-- Control para otros valores -->
                                                <input type="text" 
                                                       id="var-<?php echo esc_attr($var_name); ?>" 
                                                       name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                       value="<?php echo esc_attr($custom_variables[$var_name]); ?>" 
                                                       class="vortex-text-input" />
                                            <?php endif; ?>
                                            
                                            <p class="description">
                                                Valor por defecto: <code><?php echo esc_html($default_variables[$var_name]); ?></code>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>
            
            <div class="vortex-panel-box">
                <div class="vortex-panel-collapsible">
                    <h3 class="vortex-panel-collapsible-header">
                        <i class="ti ti-book"></i> Guía de personalización
                        <span class="vortex-panel-collapsible-toggle">
                            <i class="ti ti-chevron-down"></i>
                        </span>
                    </h3>
                    <div class="vortex-panel-collapsible-content">
                        <div class="vortex-instructions">
                            <p>El <strong>Sistema de Personalización Avanzado</strong> te permite modificar todos los aspectos visuales de tu plataforma SAAS de manera coherente y organizada.</p>
                            
                            <h4><i class="ti ti-bulb"></i> Consejos rápidos</h4>
                            <ul>
                                <li>Comienza seleccionando un <strong>tema predefinido</strong> para establecer una base para tu diseño.</li>
                                <li>El color primario define la identidad visual de tu plataforma y se aplica automáticamente a elementos clave.</li>
                                <li>Utiliza la función <strong>Generar variantes</strong> para crear automáticamente tonos claros y oscuros del color seleccionado.</li>
                                <li>Para botones 3D, puedes ajustar el desplazamiento y el radio para crear diferentes efectos de profundidad.</li>
                                <li>Observa los cambios en tiempo real en el panel de vista previa antes de guardar.</li>
                            </ul>
                            
                            <h4><i class="ti ti-palette"></i> Sistema de color</h4>
                            <p>El sistema de color se basa en variables que se propagan por toda la interfaz:</p>
                            <ul>
                                <li><strong>Color primario:</strong> Botones principales, enlaces y elementos destacados.</li>
                                <li><strong>Color secundario:</strong> Elementos complementarios y alternativos.</li>
                                <li><strong>Colores semánticos:</strong> Éxito (verde), advertencia (amarillo), peligro (rojo), información (azul).</li>
                                <li><strong>Variantes claras y oscuras:</strong> Versiones más claras para fondos sutiles y más oscuras para bordes y hover.</li>
                            </ul>
                            
                            <h4><i class="ti ti-click"></i> Botones 3D</h4>
                            <p>Los botones 3D añaden profundidad y distinción a tu interfaz:</p>
                            <ul>
                                <li>Utilizan automáticamente los colores principales del tema para mantener coherencia.</li>
                                <li>El <strong>desplazamiento</strong> controla la profundidad del efecto 3D.</li>
                                <li>El <strong>desplazamiento al hover</strong> define cuánto se eleva el botón al pasar el cursor.</li>
                                <li>El <strong>radio de borde</strong> afecta tanto a los botones como a otros elementos de la interfaz.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
