/**
 * JavaScript para la página de administración del plugin
 *
 * @package Vortex_UI_Panel
 */

(function($) {
    'use strict';
    
    // Cuando el DOM esté listo
    $(document).ready(function() {
        // Elementos del DOM
        const $addMenuItemForm = $('#vortex-add-menu-item');
        const $menuTypeSelect = $('#menu-type');
        const $menuParentSelect = $('#menu-parent');
        const $iconSearch = $('#icon-search');
        const $iconItems = $('.icon-item');
        const $menuStructure = $('#menu-structure');
        const $saveMenuButton = $('#save-menu-button');
        const $eliminarElementosButton = $('#eliminar-elementos-button');
        const $eliminarTodosButton = $('#eliminar-todos-button');
        const $settingsForm = $('#vortex-settings-form');
        const $logoUrlInput = $('#logo-url');
        const $logoPreview = $('.logo-preview');
        const $uploadMediaButton = $('.upload-media-button');
        
        // Inicialización
        initFormToggle();
        initIconSelector();
        initSortable();
        initFormHandlers();
        initMediaUploader();
        
        /**
         * Inicializa el toggle de campos según el tipo de menú
         */
        function initFormToggle() {
            // Mostrar/ocultar campos según el tipo de elemento
            $menuTypeSelect.on('change', function() {
                const type = $(this).val();
                
                if (type === 'section') {
                    $('.link-fields').hide();
                    $menuParentSelect.val(0);
                    $menuParentSelect.prop('disabled', true);
                } else if (type === 'submenu') {
                    $('.link-fields').hide();
                    $menuParentSelect.prop('disabled', false);
                } else {
                    $('.link-fields').show();
                    $menuParentSelect.prop('disabled', false);
                }
            });
            
            // Trigger inicial
            $menuTypeSelect.trigger('change');
        }
        
        /**
         * Inicializa el selector de iconos
         */
        function initIconSelector() {
            // Filtrar iconos al buscar
            $iconSearch.on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                
                $iconItems.each(function() {
                    const iconName = $(this).find('.icon-name').text().toLowerCase();
                    const iconClass = $(this).data('icon').toLowerCase();
                    
                    if (iconName.includes(searchTerm) || iconClass.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            // Seleccionar icono al hacer clic
            $iconItems.on('click', function() {
                const iconClass = $(this).data('icon');
                $('#menu-icon').val(iconClass);
                $('#icon-preview-i').attr('class', iconClass);
            });
            
            // Actualizar vista previa al escribir manualmente
            $('#menu-icon').on('keyup', function() {
                const iconClass = $(this).val();
                $('#icon-preview-i').attr('class', iconClass);
            });
        }
        
        /**
         * Inicializa la funcionalidad de ordenar arrastrando
         */
        function initSortable() {
            $menuStructure.sortable({
                handle: '.menu-item-header',
                items: '> .menu-item',
                axis: 'y',
                update: function() {
                    // Actualizar el orden cuando cambie
                    // Implementar lógica para actualizar órdenes
                }
            });
            
            // También hacer ordenables los submenús
            $('.submenu-items').sortable({
                handle: '.menu-item-header',
                items: '> .menu-item',
                axis: 'y',
                connectWith: '.submenu-items',
                update: function() {
                    // Actualizar el orden cuando cambie
                    // Implementar lógica para actualizar órdenes
                }
            });
        }
        
        /**
         * Inicializa los manejadores de formularios
         */
        function initFormHandlers() {
            // Añadir nuevo elemento de menú
            $addMenuItemForm.on('submit', function(e) {
                e.preventDefault();
                
                // Recoger datos del formulario
                const formData = {
                    id: 'menu_' + Math.floor(Math.random() * 100000), // ID temporal
                    title: $('#menu-title').val(),
                    type: $('#menu-type').val(),
                    url: $('#menu-url').val(),
                    icon: $('#menu-icon').val(),
                    target: $('#menu-target').val(),
                    parent_id: $('#menu-parent').val(),
                    roles: []
                };
                
                // Recoger roles seleccionados
                $('input[name="roles[]"]:checked').each(function() {
                    formData.roles.push($(this).val());
                });
                
                // Añadir a la estructura de menú
                // Aquí se implementaría la lógica para añadir el elemento
                
                // Limpiar formulario
                $addMenuItemForm[0].reset();
                $('#icon-preview-i').attr('class', '');
            });
            
            // Guardar cambios en el menú
            $saveMenuButton.on('click', function() {
                // Recoger toda la estructura del menú
                // Implementar lógica para obtener la estructura actualizada
                
                // Enviar al servidor mediante AJAX
                $.ajax({
                    url: vortexUIPanel.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'vortex_save_menu',
                        nonce: vortexUIPanel.nonce,
                        menu: [] // Aquí iría la estructura real
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Menú guardado correctamente');
                        } else {
                            alert('Error al guardar el menú: ' + response.data);
                        }
                    },
                    error: function() {
                        alert('Error de conexión al guardar el menú');
                    }
                });
            });
            
            // Eliminar todos los elementos
            $eliminarTodosButton.on('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar todos los elementos? Esta acción no se puede deshacer.')) {
                    $menuStructure.empty();
                }
            });
            
            // Modo de eliminación individual
            $eliminarElementosButton.on('click', function() {
                // Implementar lógica para activar/desactivar modo de eliminación
            });
            
            // Guardar configuración
            if ($settingsForm.length) {
                $settingsForm.on('submit', function(e) {
                    e.preventDefault();
                    
                    // Guardar logo URL
                    $.ajax({
                        url: vortexUIPanel.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'vortex_save_logo',
                            nonce: vortexUIPanel.nonce,
                            logo_url: $logoUrlInput.val()
                        },
                        success: function(response) {
                            // Guardar dashboard URL después de guardar el logo
                            $.ajax({
                                url: vortexUIPanel.ajaxUrl,
                                type: 'POST',
                                data: {
                                    action: 'vortex_save_dashboard_url',
                                    nonce: vortexUIPanel.nonce,
                                    dashboard_url: $('#dashboard-url').val()
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alert('Configuración guardada correctamente');
                                    } else {
                                        alert('Error al guardar la configuración: ' + response.data);
                                    }
                                },
                                error: function() {
                                    alert('Error de conexión al guardar la configuración');
                                }
                            });
                        },
                        error: function() {
                            alert('Error de conexión al guardar el logo');
                        }
                    });
                });
            }
        }
        
        /**
         * Inicializa el selector de medios de WordPress
         */
        function initMediaUploader() {
            if ($uploadMediaButton.length) {
                let mediaUploader;
                
                $uploadMediaButton.on('click', function(e) {
                    e.preventDefault();
                    
                    // Si ya existe el uploader, ábrelo
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    
                    // Crear el uploader
                    mediaUploader = wp.media({
                        title: 'Seleccionar Logo',
                        button: {
                            text: 'Usar este logo'
                        },
                        multiple: false
                    });
                    
                    // Cuando se seleccione un archivo
                    mediaUploader.on('select', function() {
                        const attachment = mediaUploader.state().get('selection').first().toJSON();
                        $logoUrlInput.val(attachment.url);
                        $logoPreview.html('<img src="' + attachment.url + '" alt="Logo Preview">');
                    });
                    
                    // Abrir el selector
                    mediaUploader.open();
                });
            }
        }
    });
})(jQuery);