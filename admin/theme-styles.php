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
?>

<div class="wrap vortex-ui-panel-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="notice notice-info">
        <p>
            <strong>Personaliza el estilo de tu tema SAAS</strong> modificando las variables CSS. Los cambios se aplicarán a todo el sitio.
        </p>
    </div>
    
    <div class="vortex-theme-styles-container">
        <div class="vortex-theme-styles-sidebar">
            <div class="vortex-panel-box">
                <h2>Previsualización</h2>
                <div class="vortex-theme-preview">
                    <div class="preview-header" style="background-color: var(--primary-color);">
                        <div class="preview-logo">T</div>
                        <div class="preview-title">Panel SAAS</div>
                    </div>
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
                        <div class="preview-card">
                            <div class="preview-card-header">Panel de control</div>
                            <div class="preview-card-body">
                                <p class="preview-text">Vista previa del estilo del tema.</p>
                                <button class="preview-button primary">Botón primario</button>
                                <button class="preview-button secondary">Botón secundario</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vortex-theme-actions">
                    <button id="vortex-reset-styles" class="button">Restablecer valores por defecto</button>
                    <button id="vortex-save-styles" class="button button-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
        
        <div class="vortex-theme-styles-content">
            <div class="vortex-panel-box">
                <form id="vortex-theme-styles-form">
                    <div id="vortex-theme-styles-tabs">
                        <ul>
                            <?php foreach ($variable_categories as $category_key => $category) : ?>
                                <li><a href="#tab-<?php echo esc_attr($category_key); ?>"><?php echo esc_html($category['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <?php foreach ($variable_categories as $category_key => $category) : ?>
                            <div id="tab-<?php echo esc_attr($category_key); ?>">
                                <h3><?php echo esc_html($category['title']); ?></h3>
                                
                                <div class="vortex-variables-grid">
                                    <?php foreach ($category['variables'] as $var_name => $var_label) : ?>
                                        <div class="vortex-variable-control">
                                            <label for="var-<?php echo esc_attr($var_name); ?>"><?php echo esc_html($var_label); ?></label>
                                            
                                            <?php if (strpos($var_name, 'color') !== false || isset($custom_variables[$var_name]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $custom_variables[$var_name])) : ?>
                                                <!-- Control para colores -->
                                                <input type="text" 
                                                       id="var-<?php echo esc_attr($var_name); ?>" 
                                                       name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                       value="<?php echo esc_attr($custom_variables[$var_name]); ?>" 
                                                       class="vortex-color-picker"
                                                       data-default-color="<?php echo esc_attr($this->theme_customizer->default_variables[$var_name]); ?>" />
                                            
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
                                            
                                            <?php else : ?>
                                                <!-- Control para otros valores -->
                                                <input type="text" 
                                                       id="var-<?php echo esc_attr($var_name); ?>" 
                                                       name="variables[<?php echo esc_attr($var_name); ?>]" 
                                                       value="<?php echo esc_attr($custom_variables[$var_name]); ?>" 
                                                       class="vortex-text-input" />
                                            <?php endif; ?>
                                            
                                            <p class="description">
                                                Valor por defecto: <code><?php echo esc_html($this->theme_customizer->default_variables[$var_name]); ?></code>
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
                <h2>Guía de uso</h2>
                
                <div class="vortex-instructions">
                    <p>El <strong>Personalizador de Estilos</strong> te permite modificar fácilmente la apariencia de tu tema SAAS sin necesidad de conocimientos avanzados de CSS.</p>
                    
                    <h3>Cómo funciona</h3>
                    <p>Este personalizador modifica las <strong>variables CSS</strong> del tema, que son los valores básicos utilizados en todo el diseño. Al cambiar estas variables, puedes personalizar completamente la apariencia de tu sitio.</p>
                    
                    <h3>Tipos de variables</h3>
                    <ul>
                        <li><strong>Colores:</strong> Define los colores principales del tema (primario, secundario, éxito, etc.)</li>
                        <li><strong>Tipografía:</strong> Configura fuentes, tamaños y estilos de texto</li>
                        <li><strong>Estructura:</strong> Ajusta dimensiones como el ancho de la barra lateral o altura de la barra superior</li>
                        <li><strong>Modo Oscuro:</strong> Personaliza los colores específicos del modo oscuro</li>
                    </ul>
                    
                    <h3>Consejos</h3>
                    <ul>
                        <li>Utiliza la previsualización para ver los cambios antes de guardarlos</li>
                        <li>Para valores de dimensiones, asegúrate de incluir la unidad (px, rem, em, etc.)</li>
                        <li>Puedes restablecer todo a los valores por defecto con el botón "Restablecer valores por defecto"</li>
                        <li>Recuerda guardar los cambios cuando estés satisfecho con el resultado</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
