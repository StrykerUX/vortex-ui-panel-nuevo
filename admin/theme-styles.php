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
$default_variables = $this->theme_customizer->get_default_variables();
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
                                
                                <!-- Botones originales (ocultos) -->
                                <button class="preview-button primary">Botón primario</button>
                                <button class="preview-button secondary">Botón secundario</button>
                                
                                <!-- Nuevos botones 3D -->
                                <div class="btn-wrapper primary">
                                    <div class="btn-back"></div>
                                    <a href="#" class="btn">
                                        <span class="btn-text">Botón primario</span>
                                        <span class="btn-icon">→</span>
                                    </a>
                                </div>
                                
                                <div class="btn-wrapper secondary">
                                    <div class="btn-back"></div>
                                    <a href="#" class="btn">
                                        <span class="btn-text">Botón secundario</span>
                                        <span class="btn-icon">+</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vortex-theme-actions">
                    <!-- Botones 3D para acciones -->
                    <div class="button-3d-wrapper" id="vortex-reset-styles-wrapper">
                        <div class="button-3d-back"></div>
                        <button id="vortex-reset-styles" class="button-3d">Restablecer valores por defecto</button>
                    </div>
                    
                    <div class="button-3d-wrapper primary" id="vortex-save-styles-wrapper">
                        <div class="button-3d-back"></div>
                        <button id="vortex-save-styles" class="button-3d">Guardar cambios</button>
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
                                <li><a href="#tab-<?php echo esc_attr($category_key); ?>"><?php echo esc_html($category['title']); ?></a></li>
                            <?php endforeach; ?>
                            <li><a href="#tab-button-3d">Botones 3D</a></li>
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
                                                       data-default-color="<?php echo esc_attr($default_variables[$var_name]); ?>" />
                                            
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
                                                Valor por defecto: <code><?php echo esc_html($default_variables[$var_name]); ?></code>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Nueva pestaña para personalización de botones 3D -->
                        <div id="tab-button-3d">
                            <h3>Personalización de Botones 3D</h3>
                            
                            <div class="vortex-variables-grid">
                                <!-- Color de fondo del botón principal -->
                                <div class="vortex-variable-control">
                                    <label for="var-front-bg-color">Color de fondo del botón</label>
                                    <input type="text" 
                                           id="var-front-bg-color" 
                                           name="variables[front-bg-color]" 
                                           value="<?php echo esc_attr(isset($custom_variables['front-bg-color']) ? $custom_variables['front-bg-color'] : '#4F46E5'); ?>" 
                                           class="vortex-color-picker"
                                           data-default-color="#4F46E5" />
                                    <p class="description">
                                        Color de fondo del botón frontal
                                    </p>
                                </div>
                                
                                <!-- Color del texto -->
                                <div class="vortex-variable-control">
                                    <label for="var-front-text-color">Color del texto</label>
                                    <input type="text" 
                                           id="var-front-text-color" 
                                           name="variables[front-text-color]" 
                                           value="<?php echo esc_attr(isset($custom_variables['front-text-color']) ? $custom_variables['front-text-color'] : '#ffffff'); ?>" 
                                           class="vortex-color-picker"
                                           data-default-color="#ffffff" />
                                    <p class="description">
                                        Color del texto del botón
                                    </p>
                                </div>
                                
                                <!-- Color del borde trasero -->
                                <div class="vortex-variable-control">
                                    <label for="var-back-border-color">Color del borde trasero</label>
                                    <input type="text" 
                                           id="var-back-border-color" 
                                           name="variables[back-border-color]" 
                                           value="<?php echo esc_attr(isset($custom_variables['back-border-color']) ? $custom_variables['back-border-color'] : '#3730a3'); ?>" 
                                           class="vortex-color-picker"
                                           data-default-color="#3730a3" />
                                    <p class="description">
                                        Color del borde de la capa trasera
                                    </p>
                                </div>
                                
                                <!-- Color de fondo botón secundario -->
                                <div class="vortex-variable-control">
                                    <label for="var-secondary-front-bg-color">Color de fondo secundario</label>
                                    <input type="text" 
                                           id="var-secondary-front-bg-color" 
                                           name="variables[secondary-front-bg-color]" 
                                           value="<?php echo esc_attr(isset($custom_variables['secondary-front-bg-color']) ? $custom_variables['secondary-front-bg-color'] : '#8B5CF6'); ?>" 
                                           class="vortex-color-picker"
                                           data-default-color="#8B5CF6" />
                                    <p class="description">
                                        Color de fondo para botones secundarios
                                    </p>
                                </div>
                                
                                <!-- Color del borde trasero secundario -->
                                <div class="vortex-variable-control">
                                    <label for="var-secondary-back-border-color">Color del borde trasero secundario</label>
                                    <input type="text" 
                                           id="var-secondary-back-border-color" 
                                           name="variables[secondary-back-border-color]" 
                                           value="<?php echo esc_attr(isset($custom_variables['secondary-back-border-color']) ? $custom_variables['secondary-back-border-color'] : '#6D28D9'); ?>" 
                                           class="vortex-color-picker"
                                           data-default-color="#6D28D9" />
                                    <p class="description">
                                        Color del borde trasero para botones secundarios
                                    </p>
                                </div>
                                
                                <!-- Radio de borde -->
                                <div class="vortex-variable-control">
                                    <label for="var-border-radius">Radio de borde</label>
                                    <input type="text" 
                                           id="var-border-radius" 
                                           name="variables[border-radius]" 
                                           value="<?php echo esc_attr(isset($custom_variables['border-radius']) ? $custom_variables['border-radius'] : '4px'); ?>" 
                                           class="vortex-text-input" />
                                    <p class="description">
                                        Radio de borde de los botones (ejemplo: 4px)
                                    </p>
                                </div>
                                
                                <!-- Desplazamiento 3D -->
                                <div class="vortex-variable-control">
                                    <label for="var-offset">Desplazamiento 3D</label>
                                    <input type="text" 
                                           id="var-offset" 
                                           name="variables[offset]" 
                                           value="<?php echo esc_attr(isset($custom_variables['offset']) ? $custom_variables['offset'] : '4px'); ?>" 
                                           class="vortex-text-input" />
                                    <p class="description">
                                        Distancia entre el botón y su sombra (ejemplo: 4px)
                                    </p>
                                </div>
                                
                                <!-- Desplazamiento al pasar el ratón -->
                                <div class="vortex-variable-control">
                                    <label for="var-hover-offset">Desplazamiento al hover</label>
                                    <input type="text" 
                                           id="var-hover-offset" 
                                           name="variables[hover-offset]" 
                                           value="<?php echo esc_attr(isset($custom_variables['hover-offset']) ? $custom_variables['hover-offset'] : '3px'); ?>" 
                                           class="vortex-text-input" />
                                    <p class="description">
                                        Desplazamiento al pasar el ratón (ejemplo: 3px)
                                    </p>
                                </div>
                            </div>
                        </div>
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
                        <li><strong>Botones 3D:</strong> Personaliza el aspecto de los botones con efecto tridimensional</li>
                    </ul>
                    
                    <h3>Consejos</h3>
                    <ul>
                        <li>Utiliza la previsualización para ver los cambios antes de guardarlos</li>
                        <li>Para valores de dimensiones, asegúrate de incluir la unidad (px, rem, em, etc.)</li>
                        <li>Puedes restablecer todo a los valores por defecto con el botón "Restablecer valores por defecto"</li>
                        <li>Recuerda guardar los cambios cuando estés satisfecho con el resultado</li>
                        <li>Los botones 3D añaden profundidad visual y mejoran la experiencia de usuario</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
