<?php
/**
 * Plantilla para la página del gestor de menú
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap vortex-ui-panel-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="vortex-ui-panel-container">
        <div class="vortex-ui-panel-sidebar">
            <div class="vortex-panel-box">
                <h2>Añadir nuevo elemento</h2>
                
                <form id="vortex-add-menu-item">
                    <div class="form-group">
                        <label for="menu-title">Título</label>
                        <input type="text" id="menu-title" name="title" class="regular-text" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="menu-type">Tipo</label>
                        <select id="menu-type" name="type" class="regular-text">
                            <option value="link">Enlace</option>
                            <option value="section">Sección</option>
                            <option value="submenu">Submenú</option>
                        </select>
                    </div>
                    
                    <div class="form-group link-fields">
                        <label for="menu-url">URL</label>
                        <input type="text" id="menu-url" name="url" class="regular-text">
                    </div>
                    
                    <div class="form-group link-fields">
                        <label for="menu-target">Abrir en</label>
                        <select id="menu-target" name="target" class="regular-text">
                            <option value="_self">Misma ventana</option>
                            <option value="_blank">Nueva ventana</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="menu-icon">Icono</label>
                        <div class="icon-selector">
                            <input type="text" id="menu-icon" name="icon" class="regular-text">
                            <button type="button" class="button icon-browser-button">
                                <span class="dashicons dashicons-search"></span>
                            </button>
                        </div>
                        <div class="icon-preview">
                            <i id="icon-preview-i" class=""></i>
                        </div>
                        <p class="description">Selecciona un icono de la biblioteca o escribe manualmente un código de icono.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="menu-parent">Elemento padre</label>
                        <select id="menu-parent" name="parent_id" class="regular-text">
                            <option value="0">Ninguno (nivel superior)</option>
                            <?php 
                            // Generar opciones para elementos que pueden ser padres
                            foreach ($menu_structure as $item) {
                                if ($item['type'] === 'submenu') {
                                    echo '<option value="' . esc_attr($item['id']) . '">' . esc_html($item['title']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Restringir a roles</label>
                        <div class="role-selector">
                            <?php 
                            // Obtener todos los roles
                            $roles = get_editable_roles();
                            echo '<div class="role-item"><label><input type="checkbox" name="roles[]" value="all" checked> Todos los usuarios</label></div>';
                            
                            foreach ($roles as $role_id => $role) {
                                echo '<div class="role-item"><label><input type="checkbox" name="roles[]" value="' . esc_attr($role_id) . '"> ' . esc_html($role['name']) . '</label></div>';
                            }
                            ?>
                        </div>
                        <p class="description">Deja en blanco para permitir a todos los usuarios.</p>
                    </div>
                    
                    <button type="submit" class="button button-primary">Añadir elemento</button>
                </form>
            </div>
            
            <div class="vortex-panel-box">
                <h2>Biblioteca de iconos</h2>
                <div class="icon-search">
                    <input type="text" id="icon-search" placeholder="Buscar iconos..." class="regular-text">
                </div>
                
                <div class="icons-container">
                    <?php foreach ($available_icons as $icon_class => $icon_name) : ?>
                    <div class="icon-item" data-icon="<?php echo esc_attr($icon_class); ?>">
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        <span class="icon-name"><?php echo esc_html($icon_name); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="vortex-ui-panel-content">
            <div class="vortex-panel-box">
                <h2>Estructura del menú</h2>
                
                <p class="description">Arrastra y suelta los elementos para cambiar su orden.</p>
                
                <div id="menu-structure-container">
                    <ul id="menu-structure" class="menu-items-list">
                        <?php $this->render_menu_items($menu_structure); ?>
                    </ul>
                </div>
                
                <div class="menu-actions">
                    <button id="save-menu-button" class="button button-primary">Guardar cambios</button>
                    <button id="eliminar-elementos-button" class="button button-secondary">Eliminar elementos uno por uno</button>
                    <button id="eliminar-todos-button" class="button button-link-delete">Eliminar todos los elementos</button>
                </div>
            </div>
            
            <div class="vortex-panel-box">
                <h2>Vista previa</h2>
                <div id="menu-preview" class="menu-preview">
                    <!-- Aquí se mostrará una previsualización del menú -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="menu-item-template">
    <li class="menu-item" data-id="{{id}}">
        <div class="menu-item-header">
            <div class="menu-item-title">
                <i class="{{icon}}"></i>
                <span>{{title}}</span>
                <span class="menu-item-type">{{type_label}}</span>
            </div>
            <div class="menu-item-actions">
                <button type="button" class="button-edit" aria-label="Editar"><span class="dashicons dashicons-edit"></span></button>
                <button type="button" class="button-delete" aria-label="Eliminar"><span class="dashicons dashicons-trash"></span></button>
            </div>
        </div>
        <div class="menu-item-content" style="display: none;">
            <!-- Aquí irá el formulario de edición -->
        </div>
    </li>
</script>

<?php
/**
 * Función auxiliar para renderizar los elementos del menú
 */
function render_menu_items($items, $parent_id = 0) {
    foreach ($items as $item) {
        if ($item['parent_id'] == $parent_id) {
            $type_label = '';
            switch ($item['type']) {
                case 'link':
                    $type_label = 'Enlace';
                    break;
                case 'section':
                    $type_label = 'Sección';
                    break;
                case 'submenu':
                    $type_label = 'Submenú';
                    break;
            }
            
            echo '<li class="menu-item" data-id="' . esc_attr($item['id']) . '">';
            echo '<div class="menu-item-header">';
            echo '<div class="menu-item-title">';
            if (!empty($item['icon'])) {
                echo '<i class="' . esc_attr($item['icon']) . '"></i> ';
            }
            echo '<span>' . esc_html($item['title']) . '</span>';
            echo '<span class="menu-item-type">' . esc_html($type_label) . '</span>';
            echo '</div>';
            echo '<div class="menu-item-actions">';
            echo '<button type="button" class="button-edit" aria-label="Editar"><span class="dashicons dashicons-edit"></span></button>';
            echo '<button type="button" class="button-delete" aria-label="Eliminar"><span class="dashicons dashicons-trash"></span></button>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="menu-item-content" style="display: none;">';
            // Aquí iría el formulario de edición
            echo '</div>';
            
            // Renderizar hijos si es un submenú
            if ($item['type'] === 'submenu') {
                echo '<ul class="submenu-items">';
                render_menu_items($items, $item['id']);
                echo '</ul>';
            }
            
            echo '</li>';
        }
    }
}
?>