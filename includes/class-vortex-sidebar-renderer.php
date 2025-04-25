<?php
/**
 * Clase para renderizar el menú lateral personalizado
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Sidebar_Renderer {
    /**
     * Instancia del gestor de menú
     */
    private $menu_manager;
    
    /**
     * Constructor
     */
    public function __construct($menu_manager) {
        $this->menu_manager = $menu_manager;
    }
    
    /**
     * Renderiza el menú lateral personalizado
     */
    public function render_sidebar() {
        // Obtener la estructura del menú
        $menu_structure = $this->menu_manager->get_menu_structure();
        $dashboard_url = $this->menu_manager->get_dashboard_url();
        $logo_url = $this->menu_manager->get_logo_url();
        
        // Iniciar buffer de salida
        ob_start();
        ?><!-- Sidenav Menu Start -->
<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="<?php echo esc_url($dashboard_url); ?>" class="logo">
        <span class="logo-light">
            <?php if (!empty($logo_url)) : ?>
                <span class="logo-lg"><img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo get_bloginfo('name'); ?>"></span>
                <span class="logo-sm text-center"><?php echo esc_html(substr(get_bloginfo('name'), 0, 2)); ?></span>
            <?php else : ?>
                <span class="logo-lg"><?php echo get_bloginfo('name'); ?></span>
                <span class="logo-sm text-center"><?php echo esc_html(substr(get_bloginfo('name'), 0, 2)); ?></span>
            <?php endif; ?>
        </span>

        <span class="logo-dark">
            <?php if (!empty($logo_url)) : ?>
                <span class="logo-lg"><img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo get_bloginfo('name'); ?>"></span>
                <span class="logo-sm text-center"><?php echo esc_html(substr(get_bloginfo('name'), 0, 2)); ?></span>
            <?php else : ?>
                <span class="logo-lg"><?php echo get_bloginfo('name'); ?></span>
                <span class="logo-sm text-center"><?php echo esc_html(substr(get_bloginfo('name'), 0, 2)); ?></span>
            <?php endif; ?>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>
        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <?php $this->render_menu_items($menu_structure); ?>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Sidenav Menu End -->
        <?php
        return ob_get_clean();
    }
    
    /**
     * Renderiza los elementos del menú lateral
     */
    private function render_menu_items($items, $parent_id = 0) {
        // Ordenar elementos por el campo 'order'
        usort($items, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        // Filtrar elementos visibles según el rol del usuario
        $current_user = wp_get_current_user();
        $user_roles = $current_user->roles;
        
        foreach ($items as $item) {
            // Solo procesar elementos del nivel actual (filtrado por parent_id)
            if ($item['parent_id'] != $parent_id) {
                continue;
            }
            
            // Verificar si el usuario tiene permiso para ver este elemento
            if (!in_array('all', $item['roles']) && !array_intersect($user_roles, $item['roles'])) {
                continue;
            }
            
            // Renderizar según el tipo de elemento
            switch ($item['type']) {
                case 'section':
                    $this->render_section_item($item);
                    break;
                    
                case 'submenu':
                    $this->render_submenu_item($item, $items);
                    break;
                    
                case 'link':
                default:
                    $this->render_link_item($item);
                    break;
            }
        }
    }
    
    /**
     * Renderiza un elemento tipo sección (título)
     */
    private function render_section_item($item) {
        echo '<li class="side-nav-title">' . esc_html($item['title']) . '</li>';
    }
    
    /**
     * Renderiza un elemento tipo enlace
     */
    private function render_link_item($item) {
        $icon = !empty($item['icon']) ? $item['icon'] : 'ti ti-link';
        $url = !empty($item['url']) ? $item['url'] : '#';
        $target = !empty($item['target']) ? $item['target'] : '_self';
        
        echo '<li class="side-nav-item">';
        echo '<a href="' . esc_url($url) . '" class="side-nav-link" target="' . esc_attr($target) . '">';
        echo '<span class="menu-icon"><i class="' . esc_attr($icon) . '"></i></span>';
        echo '<span class="menu-text">' . esc_html($item['title']) . '</span>';
        echo '</a>';
        echo '</li>';
    }
    
    /**
     * Renderiza un elemento tipo submenú (desplegable)
     */
    private function render_submenu_item($item, $all_items) {
        $icon = !empty($item['icon']) ? $item['icon'] : 'ti ti-folder';
        $submenu_id = 'sidebar-' . sanitize_title($item['id']);
        
        echo '<li class="side-nav-item">';
        echo '<a data-bs-toggle="collapse" href="#' . esc_attr($submenu_id) . '" aria-expanded="false" aria-controls="' . esc_attr($submenu_id) . '" class="side-nav-link">';
        echo '<span class="menu-icon"><i class="' . esc_attr($icon) . '"></i></span>';
        echo '<span class="menu-text">' . esc_html($item['title']) . '</span>';
        echo '<span class="menu-arrow"></span>';
        echo '</a>';
        
        echo '<div class="collapse" id="' . esc_attr($submenu_id) . '">';
        echo '<ul class="sub-menu">';
        // Renderizar elementos hijos
        $this->render_menu_items($all_items, $item['id']);
        echo '</ul>';
        echo '</div>';
        echo '</li>';
    }
}