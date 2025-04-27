/**
 * Vortex UI Panel - Neo Brutalism JS
 * Funcionalidades JavaScript para mejorar los estilos Neo Brutalism
 */

(function($) {
    'use strict';

    // Aplicar clase de Neo Brutalism al body
    $('body').addClass('neo-brutalism');

    // Función para aplicar efectos de hover a elementos con Neo Brutalism
    function applyNeoBrutalismEffects() {
        // Cards y elementos con sombras
        $('.card, .stat-card, .dashboard-stat').hover(
            function() {
                $(this).css('transform', 'translateY(-5px)');
                $(this).css('box-shadow', '8px 8px 0px rgba(0, 0, 0, 0.2)');
            },
            function() {
                $(this).css('transform', '');
                $(this).css('box-shadow', '');
            }
        );

        // Botones
        $('.btn').hover(
            function() {
                $(this).css('transform', 'translateY(-2px)');
                $(this).css('box-shadow', '5px 5px 0px rgba(0, 0, 0, 0.2)');
            },
            function() {
                $(this).css('transform', '');
                $(this).css('box-shadow', '');
            }
        );

        // Elementos del menú lateral
        $('.side-nav-link').hover(
            function() {
                $(this).css('transform', 'translateX(5px)');
            },
            function() {
                $(this).css('transform', '');
            }
        );
    }

    // Detectar si se usa el tema UI Panel SAAS
    function checkThemeSupport() {
        // Si el tema tiene la clase neo-brutalism o el soporte para neo-brutalism
        if ($('body').hasClass('neo-brutalism') || $('html').attr('data-theme-support') === 'neo-brutalism') {
            applyNeoBrutalismEffects();
        }
    }

    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        checkThemeSupport();
        
        // Aplicar estilos a elementos del Chat AI
        if ($('.chat-ai-container').length) {
            $('.chat-ai-container').addClass('neo-brutalism-chat');
            $('.chat-message').addClass('neo-brutalism-message');
            $('.chat-input').addClass('neo-brutalism-input');
            $('.chat-send-button').addClass('neo-brutalism-button');
        }
        
        // Aplicar estilos a elementos del panel de control
        $('.stat-card-icon.revenue').css('background-color', '#FF596A');
        $('.stat-card-icon.users').css('background-color', '#10B981');
        $('.stat-card-icon.conversion').css('background-color', '#3B82F6');
    });

})(jQuery);
