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
        
        // Variables globales
        let menuItems = [];
        let deleteMode = false;
        
        // Inicialización
        initFormToggle();
        initIconSelector();
        initSortable();
        initFormHandlers();
        initMediaUploader();
        initMenuItemHandlers();
        loadMenuItems();
        
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
            $('#menu-icon').on('input', function() {
                const iconClass = $(this).val();
                $('#icon-preview-i').attr('class', iconClass);
            });
        }
        
        /**
         * Inicializa la funcionalidad de ordenar arrastrando
         */
        function initSortable() {
            if ($menuStructure.length) {
                $menuStructure.sortable({
                    handle: '.menu-item-header',
                    items: '> .menu-item',
                    axis: 'y',
                    stop: function() {
                        updateMenuItemsOrder();
                        updateMenuPreview();
                    }
                });
            
                // También hacer ordenables los submenús
                $('.submenu-items').sortable({
                    handle: '.menu-item-header',
                    items: '> .menu-item',
                    axis: 'y',
                    connectWith: '.submenu-items',
                    stop: function() {
                        updateMenuItemsOrder();
                        updateMenuPreview();
                    }
                });
            }
        }
        
        /**
         * Actualiza el orden de los elementos según su posición en el DOM
         */
        function updateMenuItemsOrder() {
            let order = 1;
            
            // Ordenar elementos de nivel superior
            $menuStructure.find('> .menu-item').each(function() {
                const itemId = $(this).data('id');
                updateItemOrder(itemId, order++);
                
                // Ordenar subelementos
                $(this).find('> .submenu-items > .menu-item').each(function() {
                    const subItemId = $(this).data('id');
                    updateItemOrder(subItemId, order++);
                });
            });
        }
        
        /**
         * Actualiza el orden de un elemento específico
         */
        function updateItemOrder(itemId, order) {
            const index = menuItems.findIndex(item => item.id === itemId);
            if (index !== -1) {
                menuItems[index].order = order;
            }
        }
        
        /**
         * Inicializa los manejadores de formularios
         */
        function initFormHandlers() {
            // Añadir nuevo elemento de menú
            if ($addMenuItemForm.length) {
                $addMenuItemForm.on('submit', function(e) {
                    e.preventDefault();
                    
                    // Recoger datos del formulario
                    const formData = {
                        id: 'menu_' + Date.now(), // ID único basado en timestamp
                        title: $('#menu-title').val(),
                        type: $('#menu-type').val(),
                        url: $('#menu-url').val() || '#',
                        icon: $('#menu-icon').val(),
                        target: $('#menu-target').val(),
                        parent_id: $('#menu-parent').val(),
                        order: menuItems.length + 1,
                        roles: []
                    };
                    
                    // Recoger roles seleccionados
                    $('input[name="roles[]"]:checked').each(function() {
                        formData.roles.push($(this).val());
                    });
                    
                    // Si no hay roles seleccionados, añadir "all"
                    if (formData.roles.length === 0) {
                        formData.roles.push('all');
                    }
                    
                    // Añadir a la estructura de menú
                    menuItems.push(formData);
                    
                    // Actualizar el DOM
                    renderMenuItems();
                    updateMenuPreview();
                    
                    // Reinicializar sortable
                    initSortable();
                    
                    // Limpiar formulario
                    $addMenuItemForm[0].reset();
                    $('#icon-preview-i').attr('class', '');
                });
            }
            
            // Guardar cambios en el menú
            if ($saveMenuButton.length) {
                $saveMenuButton.on('click', function() {
                    // Enviar al servidor mediante AJAX
                    $.ajax({
                        url: vortexUIPanel.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'vortex_save_menu',
                            nonce: vortexUIPanel.nonce,
                            menu: menuItems
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
            }
            
            // Eliminar todos los elementos
            if ($eliminarTodosButton.length) {
                $eliminarTodosButton.on('click', function() {
                    if (confirm('¿Estás seguro de que deseas eliminar todos los elementos? Esta acción no se puede deshacer.')) {
                        menuItems = [];
                        renderMenuItems();
                        updateMenuPreview();
                    }
                });
            }
            
            // Modo de eliminación individual
            if ($eliminarElementosButton.length) {
                $eliminarElementosButton.on('click', function() {
                    deleteMode = !deleteMode;
                    
                    if (deleteMode) {
                        $eliminarElementosButton.text('Salir del modo de eliminación');
                        $menuStructure.addClass('delete-mode');
                    } else {
                        $eliminarElementosButton.text('Eliminar elementos uno por uno');
                        $menuStructure.removeClass('delete-mode');
                    }
                });
            }
            
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
        
        /**
         * Inicializa los manejadores para los elementos del menú
         */
        function initMenuItemHandlers() {
            // Delegación de eventos para los botones de editar y eliminar
            $menuStructure.on('click', '.button-edit', function() {
                const $menuItem = $(this).closest('.menu-item');
                const itemId = $menuItem.data('id');
                editMenuItem(itemId);
            });
            
            $menuStructure.on('click', '.button-delete', function() {
                const $menuItem = $(this).closest('.menu-item');
                const itemId = $menuItem.data('id');
                deleteMenuItem(itemId);
            });
        }
        
        /**
         * Carga los elementos del menú desde el servidor
         */
        function loadMenuItems() {
            // Si estamos en la página de gestor de menú
            if ($menuStructure.length) {
                // Hacer llamada AJAX para obtener la estructura del menú
                $.ajax({
                    url: vortexUIPanel.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'vortex_get_menu',
                        nonce: vortexUIPanel.nonce
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            menuItems = response.data;
                        } else {
                            // Si no hay elementos guardados, usar el menú por defecto
                            menuItems = getDefaultMenuItems();
                        }
                        renderMenuItems();
                        updateMenuPreview();
                    },
                    error: function() {
                        // Fallback a menú por defecto en caso de error
                        menuItems = getDefaultMenuItems();
                        renderMenuItems();
                        updateMenuPreview();
                    }
                });
            }
        }
        
        /**
         * Devuelve un menú por defecto para usar como base
         */
        function getDefaultMenuItems() {
            return [
                {
                    id: 'dashboard',
                    title: 'Dashboard',
                    url: '/',
                    icon: 'ti ti-dashboard',
                    target: '_self',
                    parent_id: 0,
                    type: 'link',
                    order: 1,
                    roles: ['all']
                },
                {
                    id: 'apps_pages',
                    title: 'Apps & Pages',
                    icon: '',
                    parent_id: 0,
                    type: 'section',
                    order: 2,
                    roles: ['all']
                },
                {
                    id: 'chat',
                    title: 'Chat',
                    url: '#',
                    icon: 'ti ti-message-filled',
                    target: '_self',
                    parent_id: 0,
                    type: 'link',
                    order: 3,
                    roles: ['all']
                },
                {
                    id: 'calendar',
                    title: 'Calendar',
                    url: '#',
                    icon: 'ti ti-calendar-filled',
                    target: '_self',
                    parent_id: 0,
                    type: 'link',
                    order: 4,
                    roles: ['all']
                },
                {
                    id: 'email',
                    title: 'Email',
                    url: '#',
                    icon: 'ti ti-inbox',
                    target: '_self',
                    parent_id: 0,
                    type: 'link',
                    order: 5,
                    roles: ['all']
                }
            ];
        }
        
        /**
         * Renderiza los elementos del menú en el DOM
         */
        function renderMenuItems() {
            if (!$menuStructure.length) return;
            
            $menuStructure.empty();
            
            // Primero ordenar elementos por el campo 'order'
            menuItems.sort((a, b) => a.order - b.order);
            
            // Renderizar elementos de nivel superior
            menuItems.forEach(function(item) {
                if (item.parent_id == 0) {
                    renderMenuItem(item, $menuStructure);
                }
            });
            
            // Actualizar opciones en el selector de padres
            updateParentOptions();
        }
        
        /**
         * Renderiza un único elemento del menú
         */
        function renderMenuItem(item, $container) {
            let typeLabel = '';
            switch (item.type) {
                case 'link':
                    typeLabel = 'Enlace';
                    break;
                case 'section':
                    typeLabel = 'Sección';
                    break;
                case 'submenu':
                    typeLabel = 'Submenú';
                    break;
            }
            
            const $menuItem = $('<li class="menu-item" data-id="' + item.id + '"></li>');
            
            const $header = $('<div class="menu-item-header"></div>');
            const $title = $('<div class="menu-item-title"></div>');
            
            if (item.icon) {
                $title.append('<i class="' + item.icon + '"></i>');
            }
            
            $title.append('<span>' + item.title + '</span>');
            $title.append('<span class="menu-item-type">' + typeLabel + '</span>');
            
            const $actions = $('<div class="menu-item-actions"></div>');
            $actions.append('<button type="button" class="button-edit" aria-label="Editar"><span class="dashicons dashicons-edit"></span></button>');
            $actions.append('<button type="button" class="button-delete" aria-label="Eliminar"><span class="dashicons dashicons-trash"></span></button>');
            
            $header.append($title);
            $header.append($actions);
            $menuItem.append($header);
            
            // Si es un submenú, añadir contenedor para elementos hijos
            if (item.type === 'submenu') {
                const $submenu = $('<ul class="submenu-items"></ul>');
                $menuItem.append($submenu);
                
                // Renderizar elementos hijos
                menuItems.forEach(function(childItem) {
                    if (childItem.parent_id === item.id) {
                        renderMenuItem(childItem, $submenu);
                    }
                });
            }
            
            $container.append($menuItem);
        }
        
        /**
         * Actualiza las opciones en el selector de elementos padre
         */
        function updateParentOptions() {
            // Limpiar opciones actuales
            $menuParentSelect.find('option').not(':first').remove();
            
            // Añadir opciones para elementos que pueden ser padres
            menuItems.forEach(function(item) {
                if (item.type === 'submenu') {
                    $menuParentSelect.append('<option value="' + item.id + '">' + item.title + '</option>');
                }
            });
        }
        
        /**
         * Edita un elemento del menú
         */
        function editMenuItem(itemId) {
            const item = menuItems.find(item => item.id === itemId);
            if (!item) return;
            
            // Crear modal de edición
            const $modal = $('<div class="menu-edit-modal"></div>');
            const $modalContent = $('<div class="menu-edit-modal-content"></div>');
            
            // Cabecera del modal
            const $modalHeader = $('<div class="menu-edit-modal-header"></div>');
            $modalHeader.append('<h2>Editar elemento de menú</h2>');
            $modalHeader.append('<span class="menu-edit-modal-close dashicons dashicons-no-alt"></span>');
            
            // Formulario de edición
            const $form = $('<form id="edit-menu-item-form"></form>');
            
            $form.append('<div class="form-group"><label for="edit-title">Título</label><input type="text" id="edit-title" name="title" value="' + item.title + '" class="regular-text" required></div>');
            
            // Select para tipo
            let typeSelect = '<div class="form-group"><label for="edit-type">Tipo</label><select id="edit-type" name="type" class="regular-text">';
            typeSelect += '<option value="link"' + (item.type === 'link' ? ' selected' : '') + '>Enlace</option>';
            typeSelect += '<option value="section"' + (item.type === 'section' ? ' selected' : '') + '>Sección</option>';
            typeSelect += '<option value="submenu"' + (item.type === 'submenu' ? ' selected' : '') + '>Submenú</option>';
            typeSelect += '</select></div>';
            $form.append(typeSelect);
            
            // Campos para enlace
            let urlVisibility = item.type !== 'link' ? ' style="display:none;"' : '';
            $form.append('<div class="form-group link-fields"' + urlVisibility + '><label for="edit-url">URL</label><input type="text" id="edit-url" name="url" value="' + item.url + '" class="regular-text"></div>');
            
            // Select para target
            let targetSelect = '<div class="form-group link-fields"' + urlVisibility + '><label for="edit-target">Abrir en</label><select id="edit-target" name="target" class="regular-text">';
            targetSelect += '<option value="_self"' + (item.target === '_self' ? ' selected' : '') + '>Misma ventana</option>';
            targetSelect += '<option value="_blank"' + (item.target === '_blank' ? ' selected' : '') + '>Nueva ventana</option>';
            targetSelect += '</select></div>';
            $form.append(targetSelect);
            
            // Campo para icono
            $form.append('<div class="form-group"><label for="edit-icon">Icono</label><input type="text" id="edit-icon" name="icon" value="' + item.icon + '" class="regular-text"></div>');
            $form.append('<div class="icon-preview"><i id="edit-icon-preview" class="' + item.icon + '"></i></div>');
            
            // Select para parent_id
            let parentSelect = '<div class="form-group"><label for="edit-parent">Elemento padre</label><select id="edit-parent" name="parent_id" class="regular-text"' + (item.type === 'section' ? ' disabled' : '') + '>';
            parentSelect += '<option value="0"' + (item.parent_id == 0 ? ' selected' : '') + '>Ninguno (nivel superior)</option>';
            
            menuItems.forEach(function(menuItem) {
                if (menuItem.type === 'submenu' && menuItem.id !== item.id) {
                    parentSelect += '<option value="' + menuItem.id + '"' + (item.parent_id == menuItem.id ? ' selected' : '') + '>' + menuItem.title + '</option>';
                }
            });
            
            parentSelect += '</select></div>';
            $form.append(parentSelect);
            
            // Botones de acción
            const $actions = $('<div class="menu-edit-modal-actions"></div>');
            $actions.append('<button type="button" class="button button-secondary modal-cancel">Cancelar</button>');
            $actions.append('<button type="submit" class="button button-primary">Guardar cambios</button>');
            
            $form.append($actions);
            $modalContent.append($modalHeader);
            $modalContent.append($form);
            $modal.append($modalContent);
            
            // Añadir modal al body
            $('body').append($modal);
            
            // Manejar eventos del modal
            $modal.find('.menu-edit-modal-close, .modal-cancel').on('click', function() {
                $modal.remove();
            });
            
            // Toggle de campos según el tipo
            $modal.find('#edit-type').on('change', function() {
                const type = $(this).val();
                
                if (type === 'section') {
                    $modal.find('.link-fields').hide();
                    $modal.find('#edit-parent').val(0);
                    $modal.find('#edit-parent').prop('disabled', true);
                } else if (type === 'submenu') {
                    $modal.find('.link-fields').hide();
                    $modal.find('#edit-parent').prop('disabled', false);
                } else {
                    $modal.find('.link-fields').show();
                    $modal.find('#edit-parent').prop('disabled', false);
                }
            });
            
            // Actualizar vista previa del icono
            $modal.find('#edit-icon').on('input', function() {
                const iconClass = $(this).val();
                $modal.find('#edit-icon-preview').attr('class', iconClass);
            });
            
            // Manejar el envío del formulario
            $form.on('submit', function(e) {
                e.preventDefault();
                
                // Actualizar elemento en el array
                const index = menuItems.findIndex(i => i.id === itemId);
                if (index !== -1) {
                    menuItems[index].title = $('#edit-title').val();
                    menuItems[index].type = $('#edit-type').val();
                    menuItems[index].url = $('#edit-url').val();
                    menuItems[index].icon = $('#edit-icon').val();
                    menuItems[index].target = $('#edit-target').val();
                    menuItems[index].parent_id = $('#edit-parent').val();
                }
                
                // Actualizar DOM
                renderMenuItems();
                updateMenuPreview();
                
                // Reinicializar sortable
                initSortable();
                
                // Cerrar modal
                $modal.remove();
            });
        }
        
        /**
         * Elimina un elemento del menú
         */
        function deleteMenuItem(itemId) {
            // Preguntar confirmación
            if (!confirm('¿Estás seguro de que deseas eliminar este elemento? Esta acción no se puede deshacer.')) {
                return;
            }
            
            // También eliminar elementos hijos
            const childrenIds = menuItems
                .filter(item => item.parent_id === itemId)
                .map(item => item.id);
            
            // Eliminar recursivamente los hijos
            childrenIds.forEach(function(childId) {
                deleteMenuItem(childId);
            });
            
            // Eliminar el elemento
            menuItems = menuItems.filter(item => item.id !== itemId);
            
            // Actualizar DOM
            renderMenuItems();
            updateMenuPreview();
        }
        
        /**
         * Actualiza la vista previa del menú
         */
        function updateMenuPreview() {
            const $preview = $('#menu-preview');
            if (!$preview.length) return;
            
            $preview.empty();
            
            // Crear un representación simplificada del menú
            const $previewMenu = $('<ul class="side-nav"></ul>');
            
            // Primero ordenar elementos por el campo 'order'
            menuItems.sort((a, b) => a.order - b.order);
            
            // Renderizar elementos de nivel superior
            menuItems.forEach(function(item) {
                if (item.parent_id == 0) {
                    renderPreviewItem(item, $previewMenu);
                }
            });
            
            $preview.append($previewMenu);
        }
        
        /**
         * Renderiza un elemento en la vista previa
         */
        function renderPreviewItem(item, $container) {
            switch (item.type) {
                case 'section':
                    $container.append('<li class="side-nav-title">' + item.title + '</li>');
                    break;
                    
                case 'submenu':
                    const $submenuItem = $('<li class="side-nav-item"></li>');
                    $submenuItem.append('<a href="#" class="side-nav-link"><span class="menu-icon"><i class="' + item.icon + '"></i></span><span class="menu-text">' + item.title + '</span><span class="menu-arrow"></span></a>');
                    
                    const $submenu = $('<ul class="sub-menu"></ul>');
                    
                    // Renderizar elementos hijos
                    menuItems.forEach(function(childItem) {
                        if (childItem.parent_id === item.id) {
                            renderPreviewItem(childItem, $submenu);
                        }
                    });
                    
                    $submenuItem.append($submenu);
                    $container.append($submenuItem);
                    break;
                    
                case 'link':
                default:
                    $container.append('<li class="side-nav-item"><a href="' + item.url + '" class="side-nav-link" target="' + item.target + '"><span class="menu-icon"><i class="' + item.icon + '"></i></span><span class="menu-text">' + item.title + '</span></a></li>');
                    break;
            }
        }
    });
})(jQuery);