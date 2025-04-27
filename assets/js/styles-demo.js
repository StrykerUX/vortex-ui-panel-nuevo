/**
 * JavaScript para la página de demostración de estilos UI
 */

(function($) {
    'use strict';

    // Cuando el DOM esté cargado
    $(document).ready(function() {
        // Elementos del DOM
        var $styleSelector = $('#style-selector');
        var $applyStyleBtn = $('#apply-style');
        var $lightModeBtn = $('#light-mode');
        var $darkModeBtn = $('#dark-mode');
        var $stylePreview = $('#style-preview');
        
        // Inicializar modo según cookie
        var isDarkMode = getCookie('vortex_demo_dark_mode') === '1';
        if (isDarkMode) {
            $stylePreview.addClass('dark-mode');
            $darkModeBtn.addClass('active');
            $lightModeBtn.removeClass('active');
        } else {
            $stylePreview.removeClass('dark-mode');
            $lightModeBtn.addClass('active');
            $darkModeBtn.removeClass('active');
        }
        
        // Cambiar entre modo claro y oscuro
        $lightModeBtn.on('click', function() {
            $stylePreview.removeClass('dark-mode');
            $lightModeBtn.addClass('active');
            $darkModeBtn.removeClass('active');
            setCookie('vortex_demo_dark_mode', '0', 1); // Cookie por 1 día
        });
        
        $darkModeBtn.on('click', function() {
            $stylePreview.addClass('dark-mode');
            $darkModeBtn.addClass('active');
            $lightModeBtn.removeClass('active');
            setCookie('vortex_demo_dark_mode', '1', 1); // Cookie por 1 día
        });
        
        // Cambiar vista previa al seleccionar estilo
        $styleSelector.on('change', function() {
            var selectedStyle = $(this).val();
            updatePreviewStyle(selectedStyle);
        });
        
        // Aplicar estilo al hacer clic en el botón
        $applyStyleBtn.on('click', function() {
            var selectedStyle = $styleSelector.val();
            applyStyleToTheme(selectedStyle);
        });
        
        // Función para actualizar la vista previa del estilo
        function updatePreviewStyle(styleKey) {
            // Remover todas las clases de estilo existentes
            $stylePreview.removeClass(function(index, className) {
                return (className.match(/(^|\s)ui-style-\S+/g) || []).join(' ');
            });
            
            // Agregar la nueva clase de estilo
            $stylePreview.addClass('ui-style-' + styleKey);
            
            // Si es modo oscuro, mantenerlo
            if (isDarkMode) {
                $stylePreview.addClass('dark-mode');
            }
        }
        
        // Función para aplicar el estilo al tema mediante AJAX
        function applyStyleToTheme(styleKey) {
            $applyStyleBtn.prop('disabled', true).text('Aplicando...');
            
            $.ajax({
                url: vortexStylesDemo.ajaxurl,
                type: 'POST',
                data: {
                    action: 'vortex_apply_preset',
                    preset: styleKey,
                    nonce: vortexStylesDemo.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showSuccessMessage('El estilo se ha aplicado correctamente. Los cambios se reflejarán en todo el panel de control.');
                    } else {
                        showErrorMessage('Error al aplicar el estilo. Por favor, inténtalo de nuevo.');
                    }
                },
                error: function() {
                    showErrorMessage('Error de conexión. Por favor, inténtalo de nuevo.');
                },
                complete: function() {
                    $applyStyleBtn.prop('disabled', false).text('Aplicar Estilo');
                }
            });
        }
        
        // Mostrar mensaje de éxito
        function showSuccessMessage(message) {
            var $messageEl = $('<div class="notice notice-success is-dismissible"><p>' + message + '</p><button type="button" class="notice-dismiss"></button></div>');
            $('.vortex-styles-info').after($messageEl);
            
            // Auto-cerrar después de 5 segundos
            setTimeout(function() {
                $messageEl.fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);
            
            // Cerrar al hacer clic en el botón
            $messageEl.find('.notice-dismiss').on('click', function() {
                $messageEl.remove();
            });
        }
        
        // Mostrar mensaje de error
        function showErrorMessage(message) {
            var $messageEl = $('<div class="notice notice-error is-dismissible"><p>' + message + '</p><button type="button" class="notice-dismiss"></button></div>');
            $('.vortex-styles-info').after($messageEl);
            
            // Auto-cerrar después de 5 segundos
            setTimeout(function() {
                $messageEl.fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);
            
            // Cerrar al hacer clic en el botón
            $messageEl.find('.notice-dismiss').on('click', function() {
                $messageEl.remove();
            });
        }
        
        // Función para establecer cookie
        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }
        
        // Función para obtener cookie
        function getCookie(name) {
            var nameEQ = name + '=';
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
        
        // Efectos interactivos para la demostración
        function addInteractiveEffects() {
            // Hover en tarjetas de estadísticas
            $('.vortex-preview-stat-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-5px)');
                },
                function() {
                    $(this).css('transform', '');
                }
            );
            
            // Hover en botones
            $('.vortex-preview-button').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', '');
                }
            );
            
            // Hover en botones 3D
            $('.btn-3d-wrapper').hover(
                function() {
                    $(this).find('.btn-3d').css('transform', 'translate(3px, 3px)');
                },
                function() {
                    $(this).find('.btn-3d').css('transform', '');
                }
            );
        }
        
        // Inicializar efectos interactivos
        addInteractiveEffects();
    });
})(jQuery);
