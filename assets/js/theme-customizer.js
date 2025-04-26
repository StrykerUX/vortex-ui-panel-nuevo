/**
 * JavaScript para la página del personalizador de estilos del tema
 */
(function($) {
    'use strict';
    
    // Variables para la previsualización en vivo
    let previewUpdateTimeout;
    let customVars = {};
    
    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        // Inicializar tabs
        $('#vortex-theme-styles-tabs').tabs();
        
        // Inicializar color pickers
        $('.vortex-color-picker').wpColorPicker({
            change: function(event, ui) {
                const $input = $(this);
                const varNameMatch = $input.attr('name').match(/variables\[(.*?)\]/);
                
                if (varNameMatch && varNameMatch[1]) {
                    const varName = varNameMatch[1];
                    
                    // Actualizar variable en tiempo real
                    customVars[varName] = ui.color.toString();
                    
                    // Actualizar previsualización con retraso para evitar actualizaciones frecuentes
                    clearTimeout(previewUpdateTimeout);
                    previewUpdateTimeout = setTimeout(updatePreview, 300);
                }
            }
        });
        
        // Manejar cambios en los campos de texto
        $('.vortex-text-input, .vortex-select').on('change', function() {
            const $input = $(this);
            const varNameMatch = $input.attr('name').match(/variables\[(.*?)\]/);
            
            if (varNameMatch && varNameMatch[1]) {
                const varName = varNameMatch[1];
                
                // Actualizar variable en tiempo real
                customVars[varName] = $input.val();
                
                // Actualizar previsualización
                updatePreview();
            }
        });
        
        // Manejar evento de guardar estilos
        $('#vortex-save-styles').on('click', function(e) {
            e.preventDefault();
            saveThemeStyles();
        });
        
        // Manejar evento de resetear estilos
        $('#vortex-reset-styles').on('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas restablecer todos los estilos a los valores por defecto? Esta acción no se puede deshacer.')) {
                resetThemeStyles();
            }
        });
        
        // Inicializar la previsualización
        initializePreview();
    });
    
    /**
     * Inicializar la previsualización con los valores actuales
     */
    function initializePreview() {
        // Recopilar todas las variables de los campos
        $('#vortex-theme-styles-form').find('input, select').each(function() {
            const $input = $(this);
            const nameMatch = $input.attr('name') ? $input.attr('name').match(/variables\[(.*?)\]/) : null;
            
            if (nameMatch && nameMatch[1]) {
                const varName = nameMatch[1];
                
                // Si es un color-picker, obtenemos el valor del campo oculto
                if ($input.hasClass('vortex-color-picker')) {
                    customVars[varName] = $input.val();
                } else {
                    customVars[varName] = $input.val();
                }
            }
        });
        
        // Actualizar la previsualización inicial
        updatePreview();
    }
    
    /**
     * Actualizar la previsualización con las variables actuales
     */
    function updatePreview() {
        let styleElement = $('#vortex-preview-styles');
        
        // Crear elemento de estilo si no existe
        if (styleElement.length === 0) {
            styleElement = $('<style id="vortex-preview-styles"></style>').appendTo('head');
        }
        
        // Construir CSS con las variables personalizadas
        let css = '.vortex-theme-preview {\n';
        
        // Transformar nombres de variables para la previsualización
        Object.keys(customVars).forEach(function(varName) {
            const value = customVars[varName];
            
            // Transformar nombres de variables de bs-* a nombres simples para la previsualización
            if (varName === 'bs-primary') {
                css += '    --primary-color: ' + value + ';\n';
            } else if (varName === 'bs-secondary') {
                css += '    --secondary-color: ' + value + ';\n';
            } else if (varName === 'bs-body-font-family') {
                css += '    --body-font-family: ' + value + ';\n';
            } else if (varName === 'bs-body-color') {
                css += '    --body-color: ' + value + ';\n';
            } else if (varName === 'bs-body-bg') {
                css += '    --body-bg: ' + value + ';\n';
            } else if (varName === 'bs-card-bg') {
                css += '    --card-bg: ' + value + ';\n';
            } else if (varName === 'bs-card-border-color') {
                css += '    --card-border: ' + value + ';\n';
            }
        });
        
        css += '}\n\n';
        
        // Aplicar las variables a elementos específicos de la previsualización
        css += '.preview-header { background-color: var(--primary-color, #4F46E5); }\n';
        css += '.preview-button.primary { background-color: var(--primary-color, #4F46E5); border-color: var(--primary-color, #4F46E5); }\n';
        css += '.preview-button.secondary { background-color: var(--secondary-color, #8B5CF6); border-color: var(--secondary-color, #8B5CF6); }\n';
        css += '.preview-menu-item.active { color: var(--primary-color, #4F46E5); background-color: rgba(var(--primary-rgb, 79, 70, 229), 0.1); }\n';
        css += '.vortex-theme-preview { font-family: var(--body-font-family, "Inter", sans-serif); }\n';
        css += '.preview-card { background-color: var(--card-bg, #fff); border-color: var(--card-border, #dee2e6); }\n';
        
        // Actualizar el contenido del elemento de estilo
        styleElement.text(css);
    }
    
    /**
     * Guardar los estilos personalizados
     */
    function saveThemeStyles() {
        // Mostrar indicador de carga
        const $saveButton = $('#vortex-save-styles');
        const originalText = $saveButton.text();
        $saveButton.text('Guardando...').prop('disabled', true);
        
        // Verificar si tenemos las variables necesarias
        if (!vortexThemeCustomizer || !vortexThemeCustomizer.ajaxUrl || !vortexThemeCustomizer.nonce) {
            console.error('Error: Variables de personalización no disponibles');
            $saveButton.text(originalText).prop('disabled', false);
            showNotice('error', 'Error: No se pudieron guardar los estilos. Variables de personalización no disponibles.');
            return;
        }
        
        // Enviar solicitud AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_save_theme_styles',
                nonce: vortexThemeCustomizer.nonce,
                variables: customVars
            },
            success: function(response) {
                if (response.success) {
                    // Mostrar mensaje de éxito
                    showNotice('success', 'Estilos guardados correctamente. Refresca las páginas del sitio para ver los cambios.');
                } else {
                    // Mostrar mensaje de error
                    showNotice('error', 'Error al guardar los estilos: ' + (response.data || 'Error desconocido'));
                }
            },
            error: function(xhr, status, error) {
                // Mostrar mensaje de error
                console.error('Error AJAX:', status, error);
                showNotice('error', 'Error de conexión al guardar los estilos: ' + error);
            },
            complete: function() {
                // Restaurar botón
                $saveButton.text(originalText).prop('disabled', false);
            }
        });
    }
    
    /**
     * Resetear los estilos a valores por defecto
     */
    function resetThemeStyles() {
        // Mostrar indicador de carga
        const $resetButton = $('#vortex-reset-styles');
        const originalText = $resetButton.text();
        $resetButton.text('Restableciendo...').prop('disabled', true);
        
        // Verificar si tenemos las variables necesarias
        if (!vortexThemeCustomizer || !vortexThemeCustomizer.ajaxUrl || !vortexThemeCustomizer.nonce) {
            console.error('Error: Variables de personalización no disponibles');
            $resetButton.text(originalText).prop('disabled', false);
            showNotice('error', 'Error: No se pudieron restablecer los estilos. Variables de personalización no disponibles.');
            return;
        }
        
        // Enviar solicitud AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_reset_theme_styles',
                nonce: vortexThemeCustomizer.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Mostrar mensaje de éxito
                    showNotice('success', 'Estilos restablecidos correctamente. La página se recargará para mostrar los cambios.');
                    
                    // Recargar la página después de un breve retraso
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    // Mostrar mensaje de error
                    showNotice('error', 'Error al restablecer los estilos: ' + (response.data || 'Error desconocido'));
                    $resetButton.text(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                // Mostrar mensaje de error
                console.error('Error AJAX:', status, error);
                showNotice('error', 'Error de conexión al restablecer los estilos: ' + error);
                $resetButton.text(originalText).prop('disabled', false);
            }
        });
    }
    
    /**
     * Mostrar un aviso en la página
     */
    function showNotice(type, message) {
        // Eliminar avisos anteriores
        $('.vortex-notice').remove();
        
        // Crear nuevo aviso
        const $notice = $('<div class="notice vortex-notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
        
        // Agregar al DOM
        $('.vortex-ui-panel-wrap > h1').after($notice);
        
        // Configurar botón de cierre
        const $button = $('<button type="button" class="notice-dismiss"><span class="screen-reader-text">Descartar este aviso.</span></button>');
        $button.on('click', function() {
            $notice.fadeOut(300, function() {
                $(this).remove();
            });
        });
        $notice.append($button);
        
        // Auto-ocultar después de 5 segundos
        setTimeout(function() {
            $notice.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
})(jQuery);
