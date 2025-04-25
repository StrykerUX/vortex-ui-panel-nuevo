<?php
/**
 * Plantilla para la página de configuración
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
        <div class="vortex-panel-box">
            <h2>Configuración General</h2>
            
            <form id="vortex-settings-form">
                <div class="form-group">
                    <label for="logo-url">URL del Logo</label>
                    <div class="media-field">
                        <input type="text" id="logo-url" name="logo_url" value="<?php echo esc_attr($logo_url); ?>" class="regular-text">
                        <button type="button" class="button upload-media-button">Seleccionar imagen</button>
                    </div>
                    <div class="logo-preview">
                        <?php if (!empty($logo_url)) : ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="Logo Preview">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="dashboard-url">URL del Dashboard</label>
                    <input type="text" id="dashboard-url" name="dashboard_url" value="<?php echo esc_url($dashboard_url); ?>" class="regular-text">
                    <p class="description">URL al que se redirigirá al hacer clic en el logo o en el elemento Dashboard.</p>
                </div>
                
                <button type="submit" class="button button-primary">Guardar configuración</button>
            </form>
        </div>
        
        <div class="vortex-panel-box">
            <h2>Instrucciones de uso</h2>
            
            <div class="vortex-instructions">
                <p>El Gestor de Menú UI Panel SaaS te permite personalizar el menú lateral de tu tema UI Panel SaaS.</p>
                
                <h3>Cómo usar</h3>
                <ol>
                    <li>Utiliza el formulario de la izquierda para añadir nuevos elementos al menú.</li>
                    <li>Selecciona un icono haciendo clic en la biblioteca de iconos.</li>
                    <li>Arrastra y suelta los elementos para cambiar su orden.</li>
                    <li>Haz clic en el botón "Eliminar" junto a cada elemento para eliminarlo individualmente.</li>
                    <li>Utiliza "Eliminar todos los elementos" si deseas vaciar completamente el menú.</li>
                    <li>Haz clic en "Guardar cambios" para aplicar los cambios.</li>
                </ol>
                
                <h3>Tipos de elementos</h3>
                <ul>
                    <li><strong>Enlace:</strong> Un elemento clicable que enlaza a una URL.</li>
                    <li><strong>Sección:</strong> Un título de sección no clicable.</li>
                    <li><strong>Submenú:</strong> Un elemento que puede contener subelementos.</li>
                </ul>
                
                <h3>Sugerencias</h3>
                <ul>
                    <li>Para crear un submenú, primero añade un elemento de tipo "Submenú".</li>
                    <li>Puedes restringir la visibilidad de los elementos según el rol del usuario.</li>
                    <li>Utiliza iconos para mejorar la apariencia del menú.</li>
                    <li>Si no ves iconos en la biblioteca, prueba a recargar la página.</li>
                </ul>
            </div>
        </div>
    </div>
</div>