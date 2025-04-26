/**
 * Script para el Sistema de Personalización Avanzado
 * 
 * Permite personalizar los estilos del tema de manera coherente
 * y con una vista previa en tiempo real.
 */

(function($) {
    'use strict';
    
    // Elementos del DOM
    const $form = $('#vortex-theme-styles-form');
    const $preview = $('.vortex-theme-preview');
    const $saveButton = $('#vortex-save-styles');
    const $resetButton = $('#vortex-reset-styles');
    const $tabs = $('#vortex-theme-styles-tabs');
    const $presetItems = $('.vortex-preset-item');
    const $colorPickers = $('.vortex-color-picker');
    const $generateVariantsButtons = $('.vortex-generate-variants');
    const $previewModeButtons = $('.vortex-preview-mode-btn');
    const $previewDeviceButtons = $('.vortex-preview-device-btn');
    const $notice = $('.vortex-notice');
    const $fontSelects = $('.vortex-select');
    const $collapsibleHeaders = $('.vortex-panel-collapsible-header');
    
    /**
     * Inicialización
     */
    function init() {
        // Inicializar tabs
        $tabs.tabs();
        
        // Inicializar color pickers
        initColorPickers();
        
        // Inicializar sliders
        initSliders();
        
        // Eventos
        bindEvents();
        
        // Colapsar/expandir paneles
        initCollapsiblePanels();
        
        // Vista previa inicial
        updatePreview();
    }
    
    /**
     * Inicializar selectores de color
     */
    function initColorPickers() {
        $colorPickers.each(function() {
            $(this).wpColorPicker({
                defaultColor: $(this).data('default-color'),
                change: function(event, ui) {
                    // Actualizar vista previa cuando cambia el color
                    updatePreview();
                }
            });
        });
    }
    
    /**
     * Inicializar sliders para dimensiones
     */
    function initSliders() {
        $('.vortex-slider').each(function() {
            const $slider = $(this);
            const $input = $('#' + $slider.data('input-id'));
            const $valueDisplay = $slider.siblings('.vortex-slider-value');
            const min = parseInt($slider.data('min')) || 0;
            const max = parseInt($slider.data('max')) || 100;
            const step = parseFloat($slider.data('step')) || 1;
            const value = parseInt($slider.data('value')) || 0;
            const unit = $slider.data('unit') || 'px';
            
            $slider.slider({
                range: 'min',
                min: min,
                max: max,
                step: step,
                value: value,
                slide: function(event, ui) {
                    const displayValue = ui.value + unit;
                    $input.val(displayValue);
                    $valueDisplay.text(displayValue);
                    
                    // Actualizar vista previa
                    updatePreview();
                }
            });
        });
        
        // Sincronizar input manual con slider
        $('.vortex-dimension-input').on('input', function() {
            const $input = $(this);
            const value = parseInt($input.val()) || 0;
            const $slider = $('.vortex-slider[data-input-id="' + $input.attr('id') + '"]');
            
            if ($slider.length) {
                $slider.slider('value', value);
                $slider.siblings('.vortex-slider-value').text($input.val());
            }
            
            // Actualizar vista previa
            updatePreview();
        });
    }
    
    /**
     * Asociar eventos a los elementos
     */
    function bindEvents() {
        // Guardar cambios
        $saveButton.on('click', saveStyles);
        
        // Restablecer valores por defecto
        $resetButton.on('click', resetStyles);
        
        // Aplicar preset
        $('.vortex-apply-preset').on('click', function(e) {
            e.preventDefault();
            const preset = $(this).closest('.vortex-preset-item').data('preset');
            applyPreset(preset);
        });
        
        // Generar variantes de color
        $generateVariantsButtons.on('click', function(e) {
            e.preventDefault();
            const variableName = $(this).data('variable');
            const colorInput = $('#var-' + variableName);
            const color = colorInput.val();
            
            generateColorVariants(color, variableName);
        });
        
        // Cambiar modo de previsualización (claro/oscuro)
        $previewModeButtons.on('click', function() {
            $previewModeButtons.removeClass('active');
            $(this).addClass('active');
            const mode = $(this).data('mode');
            $preview.attr('data-theme-mode', mode);
        });
        
        // Cambiar dispositivo de previsualización
        $previewDeviceButtons.on('click', function() {
            $previewDeviceButtons.removeClass('active');
            $(this).addClass('active');
            const device = $(this).data('device');
            $preview.attr('data-device', device);
        });
        
        // Cerrar notificaciones
        $notice.find('.notice-dismiss').on('click', function() {
            $(this).parent().addClass('hidden');
        });
        
        // Cambio de fuente
        $fontSelects.on('change', function() {
            const fontFamily = $(this).val();
            $(this).siblings('.vortex-font-preview').css('font-family', fontFamily);
            updatePreview();
        });
        
        // Actualizar vista previa con cualquier cambio de formulario
        $form.find('input, select').on('change', updatePreview);
    }
    
    /**
     * Inicializar paneles colapsables
     */
    function initCollapsiblePanels() {
        $collapsibleHeaders.on('click', function() {
            const $panel = $(this).parent();
            $panel.toggleClass('open');
        });
    }
    
    /**
     * Actualizar vista previa del tema
     */
    function updatePreview() {
        // Recopilar todas las variables y sus valores actuales
        const variables = collectFormVariables();
        
        // Aplicar estilos a la vista previa
        updatePreviewStyles(variables);
    }
    
    /**
     * Recopilar todas las variables del formulario
     */
    function collectFormVariables() {
        const variables = {};
        $form.find('input, select').each(function() {
            const $input = $(this);
            const name = $input.attr('name');
            
            if (name && name.startsWith('variables[') && name.endsWith(']')) {
                // Extraer el nombre de la variable
                const key = name.replace('variables[', '').replace(']', '');
                variables[key] = $input.val();
            }
        });
        
        return variables;
    }
    
    /**
     * Actualizar los estilos de la vista previa
     */
    function updatePreviewStyles(variables) {
        // Actualizar colores
        if (variables['bs-primary']) {
            updateButtonColors('primary', variables['bs-primary'], variables['bs-primary-dark'] || generateDarkerShade(variables['bs-primary'], 20));
        }
        
        if (variables['bs-secondary']) {
            updateButtonColors('secondary', variables['bs-secondary'], variables['bs-secondary-dark'] || generateDarkerShade(variables['bs-secondary'], 20));
        }
        
        if (variables['bs-success']) {
            updateButtonColors('success', variables['bs-success'], variables['bs-success-dark'] || generateDarkerShade(variables['bs-success'], 20));
        }
        
        if (variables['bs-danger']) {
            updateButtonColors('danger', variables['bs-danger'], variables['bs-danger-dark'] || generateDarkerShade(variables['bs-danger'], 20));
        }
        
        if (variables['bs-warning']) {
            updateButtonColors('warning', variables['bs-warning'], variables['bs-warning-dark'] || generateDarkerShade(variables['bs-warning'], 20));
        }
        
        if (variables['bs-info']) {
            updateButtonColors('info', variables['bs-info'], variables['bs-info-dark'] || generateDarkerShade(variables['bs-info'], 20));
        }
        
        // Actualizar cabecera y menú lateral
        if (variables['bs-primary']) {
            $('.preview-header').css('background-color', variables['bs-primary']);
        }
        
        // Actualizar efectos 3D para botones
        if (variables['button-3d-offset']) {
            updateButtonOffset(variables['button-3d-offset'], variables['button-3d-hover-offset'] || '3px');
        }
        
        // Actualizar radio de borde para botones
        if (variables['button-border-radius']) {
            $('.btn-3d, .btn-3d-back, .preview-button').css('border-radius', variables['button-border-radius']);
        }
        
        // Actualizar tipografía
        if (variables['bs-body-font-family']) {
            $preview.css('font-family', variables['bs-body-font-family']);
        }
    }
    
    /**
     * Actualizar colores de botones
     */
    function updateButtonColors(type, backgroundColor, borderColor) {
        // Actualizar botones estándar
        $('.preview-button.' + type).css('background-color', backgroundColor);
        
        // Actualizar botones 3D
        $('.btn-3d-wrapper.' + type + ' .btn-3d').css('background-color', backgroundColor);
        $('.btn-3d-wrapper.' + type + ' .btn-3d-back').css('border-color', borderColor);
    }
    
    /**
     * Actualizar desplazamiento de botones 3D
     */
    function updateButtonOffset(offset, hoverOffset) {
        // Actualizar la posición del fondo del botón
        $('.btn-3d-back').css({
            'top': offset,
            'left': offset
        });
        
        // Actualizar efecto hover
        // Eliminamos los estilos inline previos
        $('.vortex-theme-preview').find('style').remove();
        
        // Añadimos los nuevos estilos
        $('<style>')
            .prop('type', 'text/css')
            .html(`
                .btn-3d-wrapper:hover .btn-3d {
                    transform: translate(${hoverOffset}, ${hoverOffset});
                }
                .btn-3d-wrapper:active .btn-3d {
                    transform: translate(${offset}, ${offset});
                }
            `)
            .appendTo('.vortex-theme-preview');
    }
    
    /**
     * Guardar los estilos personalizados
     */
    function saveStyles(e) {
        e.preventDefault();
        
        // Obtener todos los valores del formulario
        const variables = collectFormVariables();
        
        // Mostrar indicador de carga
        $saveButton.prop('disabled', true).text('Guardando...');
        
        // Enviar datos por AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_save_theme_styles',
                nonce: vortexThemeCustomizer.nonce,
                variables: variables
            },
            success: function(response) {
                if (response.success) {
                    showNotice('success', 'Estilos guardados correctamente. Los cambios se han aplicado a todo el sitio.');
                } else {
                    showNotice('error', 'Error al guardar los estilos. Por favor, inténtalo de nuevo.');
                }
            },
            error: function() {
                showNotice('error', 'Error de conexión. Por favor, inténtalo de nuevo.');
            },
            complete: function() {
                $saveButton.prop('disabled', false).html('<i class="ti ti-device-floppy"></i> Guardar cambios');
            }
        });
    }
    
    /**
     * Restablecer los estilos a los valores por defecto
     */
    function resetStyles(e) {
        e.preventDefault();
        
        if (!confirm('¿Estás seguro de que quieres restablecer todos los estilos a los valores por defecto? Esta acción no se puede deshacer.')) {
            return;
        }
        
        // Mostrar indicador de carga
        $resetButton.prop('disabled', true).text('Restableciendo...');
        
        // Enviar datos por AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_reset_theme_styles',
                nonce: vortexThemeCustomizer.nonce
            },
            success: function(response) {
                if (response.success) {
                    showNotice('success', 'Estilos restablecidos a los valores por defecto.');
                    
                    // Recargar la página para mostrar los valores por defecto
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotice('error', 'Error al restablecer los estilos. Por favor, inténtalo de nuevo.');
                    $resetButton.prop('disabled', false).html('<i class="ti ti-refresh"></i> Restablecer valores');
                }
            },
            error: function() {
                showNotice('error', 'Error de conexión. Por favor, inténtalo de nuevo.');
                $resetButton.prop('disabled', false).html('<i class="ti ti-refresh"></i> Restablecer valores');
            }
        });
    }
    
    /**
     * Aplicar un preset de diseño
     */
    function applyPreset(presetKey) {
        // Mostrar indicador de carga
        const $button = $(`.vortex-preset-item[data-preset="${presetKey}"] .vortex-apply-preset`);
        const originalText = $button.text();
        $button.prop('disabled', true).text('Aplicando...');
        
        // Enviar datos por AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_apply_preset',
                nonce: vortexThemeCustomizer.nonce,
                preset: presetKey
            },
            success: function(response) {
                if (response.success) {
                    showNotice('success', `Tema "${vortexThemeCustomizer.presets[presetKey].name}" aplicado correctamente.`);
                    
                    // Actualizar valores en el formulario
                    updateFormValues(response.data.variables);
                    
                    // Actualizar vista previa
                    updatePreview();
                } else {
                    showNotice('error', 'Error al aplicar el tema. Por favor, inténtalo de nuevo.');
                }
            },
            error: function() {
                showNotice('error', 'Error de conexión. Por favor, inténtalo de nuevo.');
            },
            complete: function() {
                $button.prop('disabled', false).text(originalText);
            }
        });
    }
    
    /**
     * Generar variantes de color
     */
    function generateColorVariants(color, variableName) {
        // Mostrar indicador de carga
        const $button = $(`.vortex-generate-variants[data-variable="${variableName}"]`);
        const originalText = $button.html();
        $button.prop('disabled', true).html('<i class="ti ti-loader"></i> Generando...');
        
        // Enviar datos por AJAX
        $.ajax({
            url: vortexThemeCustomizer.ajaxUrl,
            type: 'POST',
            data: {
                action: 'vortex_generate_color_variants',
                nonce: vortexThemeCustomizer.nonce,
                color: color,
                variable_name: variableName
            },
            success: function(response) {
                if (response.success) {
                    showNotice('success', 'Variantes de color generadas correctamente.');
                    
                    // Actualizar valores en el formulario
                    updateFormValues(response.data.variants);
                    
                    // Actualizar vista previa
                    updatePreview();
                    
                    // Ir a la pestaña de variantes de color
                    $tabs.tabs('option', 'active', 1); // Índice de la pestaña "Variantes de Color"
                } else {
                    showNotice('error', 'Error al generar variantes de color. Por favor, inténtalo de nuevo.');
                }
            },
            error: function() {
                showNotice('error', 'Error de conexión. Por favor, inténtalo de nuevo.');
            },
            complete: function() {
                $button.prop('disabled', false).html(originalText);
            }
        });
    }
    
    /**
     * Actualizar valores en el formulario
     */
    function updateFormValues(variables) {
        // Actualizar cada input/select con los nuevos valores
        for (const [key, value] of Object.entries(variables)) {
            const $input = $(`#var-${key}`);
            
            if ($input.length) {
                // Actualizar el valor
                $input.val(value);
                
                // Si es un color picker, actualizar el valor y el color
                if ($input.hasClass('vortex-color-picker')) {
                    $input.wpColorPicker('color', value);
                }
                
                // Si es un select, disparar el evento change para actualizar la vista previa de la fuente
                if ($input.is('select')) {
                    $input.trigger('change');
                }
                
                // Si tiene un slider asociado, actualizar el valor del slider
                const $slider = $(`.vortex-slider[data-input-id="${$input.attr('id')}"]`);
                if ($slider.length) {
                    const numericValue = parseInt(value) || 0;
                    $slider.slider('value', numericValue);
                    $slider.siblings('.vortex-slider-value').text(value);
                }
            }
        }
    }
    
    /**
     * Mostrar notificación
     */
    function showNotice(type, message) {
        $notice.removeClass('notice-info notice-success notice-warning notice-error hidden')
               .addClass(`notice-${type}`)
               .find('p')
               .text(message);
        
        // Ocultar automáticamente después de un tiempo
        setTimeout(function() {
            $notice.addClass('hidden');
        }, 5000);
    }
    
    /**
     * Generar un tono más oscuro de un color
     */
    function generateDarkerShade(hex, percent) {
        // Remover el # si existe
        hex = hex.replace('#', '');
        
        // Convertir a RGB
        let r = parseInt(hex.substring(0, 2), 16);
        let g = parseInt(hex.substring(2, 4), 16);
        let b = parseInt(hex.substring(4, 6), 16);
        
        // Convertir r, g, b a hsl
        r /= 255, g /= 255, b /= 255;
        const max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        
        if (max === min) {
            h = s = 0; // acromático
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            
            h /= 6;
        }
        
        // Oscurecer cambiando la luminosidad
        l = Math.max(0, l - percent / 100);
        
        // Convertir de nuevo a RGB
        if (s === 0) {
            r = g = b = l; // acromático
        } else {
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
            const p = 2 * l - q;
            
            r = hueToRgb(p, q, h + 1/3);
            g = hueToRgb(p, q, h);
            b = hueToRgb(p, q, h - 1/3);
        }
        
        // Convertir a HEX
        return `#${Math.round(r * 255).toString(16).padStart(2, '0')}${Math.round(g * 255).toString(16).padStart(2, '0')}${Math.round(b * 255).toString(16).padStart(2, '0')}`;
    }
    
    /**
     * Función auxiliar para convertir hue a rgb
     */
    function hueToRgb(p, q, t) {
        if (t < 0) t += 1;
        if (t > 1) t -= 1;
        if (t < 1/6) return p + (q - p) * 6 * t;
        if (t < 1/2) return q;
        if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
        return p;
    }
    
    // Inicializar cuando el DOM esté listo
    $(document).ready(init);
    
})(jQuery);
