<?php
/**
 * Script de desinstalación para el plugin Vortex UI Panel
 *
 * Este archivo se ejecuta cuando el plugin se desinstala.
 * Se eliminan todas las opciones, tablas personalizadas y datos creados por el plugin.
 *
 * @link https://github.com/StrykerUX/vortex-ui-panel-nuevo
 * @since 0.1.0
 */

// Si no se llama desde WordPress, salir
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Eliminar opciones del plugin
delete_option('vortex_ui_panel_options');
delete_option('vortex_ui_panel_version');

// Eliminar opciones transitorias
delete_transient('vortex_ui_panel_cache');

// Si hay tablas de base de datos personalizadas, eliminarlas aquí
// global $wpdb;
// $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}vortex_ui_panel_data");

// Eliminar metadatos personalizados
// $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'vortex_ui_panel_%'");
