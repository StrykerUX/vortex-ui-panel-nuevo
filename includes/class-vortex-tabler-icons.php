<?php
/**
 * Clase para gestionar los iconos de Tabler
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}

class Vortex_Tabler_Icons {
    /**
     * La URL base donde se encuentran los iconos de Tabler
     */
    const TABLER_ICONS_BASE_URL = 'https://cdn.jsdelivr.net/npm/@tabler/icons@latest/icons/';
    
    /**
     * Enqueue el CSS de los iconos de Tabler
     */
    public static function enqueue_icons() {
        wp_enqueue_style(
            'tabler-icons',
            'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.30.0/tabler-icons.min.css',
            array(),
            '2.30.0'
        );
    }
    
    /**
     * Obtiene la lista de iconos de Tabler disponibles
     * @return array Array asociativo de iconos
     */
    public static function get_icons_list() {
        $icons = array(
            // Iconos de navegación
            'ti ti-dashboard' => 'Dashboard',
            'ti ti-home' => 'Home',
            'ti ti-layout-dashboard' => 'Layout Dashboard',
            'ti ti-category' => 'Category',
            'ti ti-apps' => 'Apps',
            
            // Iconos comunes
            'ti ti-user' => 'User',
            'ti ti-users' => 'Users',
            'ti ti-user-circle' => 'User Circle',
            'ti ti-settings' => 'Settings',
            'ti ti-settings-filled' => 'Settings Filled',
            'ti ti-adjustments' => 'Adjustments',
            'ti ti-search' => 'Search',
            'ti ti-menu' => 'Menu',
            
            // Iconos de archivos y documentos
            'ti ti-file' => 'File',
            'ti ti-file-text' => 'File Text',
            'ti ti-file-upload' => 'File Upload',
            'ti ti-file-download' => 'File Download',
            'ti ti-folder' => 'Folder',
            'ti ti-folder-filled' => 'Folder Filled',
            'ti ti-archive' => 'Archive',
            'ti ti-trash' => 'Trash',
            
            // Iconos de comunicación
            'ti ti-mail' => 'Mail',
            'ti ti-mail-filled' => 'Mail Filled',
            'ti ti-inbox' => 'Inbox',
            'ti ti-message' => 'Message',
            'ti ti-message-filled' => 'Message Filled',
            'ti ti-messages' => 'Messages',
            'ti ti-phone' => 'Phone',
            'ti ti-bell' => 'Bell',
            'ti ti-bell-filled' => 'Bell Filled',
            'ti ti-notification' => 'Notification',
            
            // Iconos de calendario y tiempo
            'ti ti-calendar' => 'Calendar',
            'ti ti-calendar-filled' => 'Calendar Filled',
            'ti ti-calendar-event' => 'Calendar Event',
            'ti ti-clock' => 'Clock',
            'ti ti-clock-filled' => 'Clock Filled',
            'ti ti-hourglass' => 'Hourglass',
            'ti ti-history' => 'History',
            
            // Iconos de e-commerce
            'ti ti-shopping-cart' => 'Shopping Cart',
            'ti ti-basket' => 'Basket',
            'ti ti-basket-filled' => 'Basket Filled',
            'ti ti-tag' => 'Tag',
            'ti ti-tags' => 'Tags',
            'ti ti-receipt' => 'Receipt',
            'ti ti-discount' => 'Discount',
            'ti ti-cash' => 'Cash',
            'ti ti-credit-card' => 'Credit Card',
            
            // Iconos de gráficos
            'ti ti-chart-bar' => 'Chart Bar',
            'ti ti-chart-line' => 'Chart Line',
            'ti ti-chart-pie' => 'Chart Pie',
            'ti ti-chart-area' => 'Chart Area',
            'ti ti-chart-donut' => 'Chart Donut',
            'ti ti-presentation' => 'Presentation',
            'ti ti-report' => 'Report',
            'ti ti-trending-up' => 'Trending Up',
            'ti ti-trending-down' => 'Trending Down',
            
            // Iconos de navegación
            'ti ti-map' => 'Map',
            'ti ti-map-pin' => 'Map Pin',
            'ti ti-map-pin-filled' => 'Map Pin Filled',
            'ti ti-compass' => 'Compass',
            'ti ti-world' => 'World',
            'ti ti-location' => 'Location',
            
            // Iconos de medios
            'ti ti-photo' => 'Photo',
            'ti ti-camera' => 'Camera',
            'ti ti-video' => 'Video',
            'ti ti-music' => 'Music',
            'ti ti-player-play' => 'Player Play',
            'ti ti-player-pause' => 'Player Pause',
            'ti ti-player-stop' => 'Player Stop',
            'ti ti-volume' => 'Volume',
            
            // Iconos de dispositivos
            'ti ti-device-desktop' => 'Desktop',
            'ti ti-device-laptop' => 'Laptop',
            'ti ti-device-tablet' => 'Tablet',
            'ti ti-device-mobile' => 'Mobile',
            'ti ti-printer' => 'Printer',
            'ti ti-bluetooth' => 'Bluetooth',
            'ti ti-wifi' => 'Wifi',
            
            // Iconos de acciones
            'ti ti-plus' => 'Plus',
            'ti ti-minus' => 'Minus',
            'ti ti-x' => 'X',
            'ti ti-check' => 'Check',
            'ti ti-filter' => 'Filter',
            'ti ti-sort-ascending' => 'Sort Ascending',
            'ti ti-sort-descending' => 'Sort Descending',
            'ti ti-refresh' => 'Refresh',
            'ti ti-rotate' => 'Rotate',
            'ti ti-edit' => 'Edit',
            'ti ti-pencil' => 'Pencil',
            'ti ti-copy' => 'Copy',
            'ti ti-clipboard' => 'Clipboard',
            'ti ti-link' => 'Link',
            'ti ti-unlink' => 'Unlink',
            'ti ti-download' => 'Download',
            'ti ti-upload' => 'Upload',
            'ti ti-share' => 'Share',
            'ti ti-arrow-up' => 'Arrow Up',
            'ti ti-arrow-down' => 'Arrow Down',
            'ti ti-arrow-left' => 'Arrow Left',
            'ti ti-arrow-right' => 'Arrow Right',
            
            // Iconos de UI
            'ti ti-eye' => 'Eye',
            'ti ti-eye-filled' => 'Eye Filled',
            'ti ti-eye-off' => 'Eye Off',
            'ti ti-lock' => 'Lock',
            'ti ti-lock-open' => 'Lock Open',
            'ti ti-key' => 'Key',
            'ti ti-star' => 'Star',
            'ti ti-star-filled' => 'Star Filled',
            'ti ti-heart' => 'Heart',
            'ti ti-heart-filled' => 'Heart Filled',
            'ti ti-thumb-up' => 'Thumb Up',
            'ti ti-thumb-down' => 'Thumb Down',
            'ti ti-bookmark' => 'Bookmark',
            'ti ti-bookmark-filled' => 'Bookmark Filled',
            'ti ti-alert-triangle' => 'Alert Triangle',
            'ti ti-alert-circle' => 'Alert Circle',
            'ti ti-info-circle' => 'Info Circle',
            'ti ti-help' => 'Help',
            'ti ti-circle-check' => 'Circle Check',
            'ti ti-circle-x' => 'Circle X',
            
            // Iconos sociales
            'ti ti-brand-facebook' => 'Facebook',
            'ti ti-brand-twitter' => 'Twitter',
            'ti ti-brand-instagram' => 'Instagram',
            'ti ti-brand-linkedin' => 'LinkedIn',
            'ti ti-brand-youtube' => 'YouTube',
            'ti ti-brand-github' => 'GitHub',
            'ti ti-brand-google' => 'Google',
            
            // Iconos abstractos/otros
            'ti ti-dots' => 'Dots',
            'ti ti-dots-vertical' => 'Dots Vertical',
            'ti ti-menu-2' => 'Menu 2',
            'ti ti-code' => 'Code',
            'ti ti-terminal' => 'Terminal',
            'ti ti-bug' => 'Bug',
            'ti ti-rocket' => 'Rocket',
            'ti ti-puzzle' => 'Puzzle',
            'ti ti-palette' => 'Palette',
            'ti ti-shield' => 'Shield',
            'ti ti-trophy' => 'Trophy',
            'ti ti-gift' => 'Gift',
            'ti ti-lightbulb' => 'Lightbulb',
            'ti ti-bulb' => 'Bulb',
            'ti ti-flag' => 'Flag',
            'ti ti-pin' => 'Pin',
            'ti ti-crown' => 'Crown',
            'ti ti-building' => 'Building',
            'ti ti-home-2' => 'Home 2',
            'ti ti-cube' => 'Cube',
            'ti ti-3d-cube-sphere' => '3D Cube',
            'ti ti-atom' => 'Atom',
            'ti ti-aperture' => 'Aperture',
            'ti ti-infinity' => 'Infinity'
        );
        
        return $icons;
    }
    
    /**
     * Obtiene el HTML para un icono específico
     *
     * @param string $icon_class Clase CSS del icono (ej: 'ti ti-dashboard')
     * @param array $attributes Atributos adicionales para el icono (opcional)
     * @return string HTML del icono
     */
    public static function get_icon_html($icon_class, $attributes = array()) {
        $attr_string = '';
        foreach ($attributes as $attr => $value) {
            $attr_string .= ' ' . esc_attr($attr) . '="' . esc_attr($value) . '"';
        }
        
        return '<i class="' . esc_attr($icon_class) . '"' . $attr_string . '></i>';
    }
}
