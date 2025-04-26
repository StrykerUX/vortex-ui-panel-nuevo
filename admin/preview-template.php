<?php
/**
 * Plantilla para la vista previa avanzada en el personalizador de temas
 * Esta vista previa simula un panel de administración real con varios componentes
 *
 * @package Vortex_UI_Panel
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}
?>

<div class="vortex-preview-dashboard">
    <!-- Barra lateral izquierda -->
    <div class="vortex-preview-sidebar">
        <div class="vortex-preview-sidebar-header">
            <div class="vortex-preview-logo">
                <span class="vortex-preview-logo-image">S</span>
                <span class="vortex-preview-logo-text">SAAS Panel</span>
            </div>
        </div>
        
        <div class="vortex-preview-menu">
            <div class="vortex-preview-menu-section">
                <div class="vortex-preview-menu-section-title">NAVIGACIÓN</div>
                
                <a href="#" class="vortex-preview-menu-item active">
                    <i class="ti ti-layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-message-circle"></i>
                    <span>Chat</span>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-calendar"></i>
                    <span>Calendario</span>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-mail"></i>
                    <span>Email</span>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-shopping-cart"></i>
                    <span>Ecommerce</span>
                    <i class="ti ti-chevron-right menu-arrow"></i>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-file-invoice"></i>
                    <span>Facturas</span>
                    <i class="ti ti-chevron-right menu-arrow"></i>
                </a>
            </div>
            
            <div class="vortex-preview-menu-section">
                <div class="vortex-preview-menu-section-title">COMPONENTES</div>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-box"></i>
                    <span>UI Base</span>
                    <i class="ti ti-chevron-right menu-arrow"></i>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-palette"></i>
                    <span>UI Avanzado</span>
                    <i class="ti ti-chevron-right menu-arrow"></i>
                </a>
                
                <a href="#" class="vortex-preview-menu-item">
                    <i class="ti ti-chart-pie"></i>
                    <span>Gráficos</span>
                    <i class="ti ti-chevron-right menu-arrow"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="vortex-preview-content">
        <!-- Barra superior -->
        <div class="vortex-preview-topbar">
            <div class="vortex-preview-topbar-left">
                <button class="vortex-preview-menu-toggle">
                    <i class="ti ti-menu-2"></i>
                </button>
                
                <div class="vortex-preview-search">
                    <i class="ti ti-search"></i>
                    <input type="text" placeholder="Buscar..." />
                    <kbd>⌘K</kbd>
                </div>
                
                <div class="vortex-preview-breadcrumb">
                    <span>Dashboard</span>
                </div>
            </div>
            
            <div class="vortex-preview-topbar-right">
                <button class="vortex-preview-icon-button">
                    <i class="ti ti-bell"></i>
                </button>
                
                <button class="vortex-preview-icon-button">
                    <i class="ti ti-settings"></i>
                </button>
                
                <button class="vortex-preview-icon-button">
                    <i class="ti ti-moon"></i>
                </button>
                
                <div class="vortex-preview-user">
                    <span class="vortex-preview-avatar">AS</span>
                    <span class="vortex-preview-username">Admin SAAS</span>
                    <i class="ti ti-chevron-down"></i>
                </div>
            </div>
        </div>
        
        <!-- Contenido del dashboard -->
        <div class="vortex-preview-dashboard-content">
            <div class="vortex-preview-page-header">
                <h1>Dashboard</h1>
                <div class="vortex-preview-actions">
                    <div class="vortex-preview-datepicker">
                        <i class="ti ti-calendar"></i>
                        <span>01 Abr - 30 Abr</span>
                    </div>
                    
                    <div class="vortex-preview-button-group">
                        <button class="vortex-preview-button outline">
                            <i class="ti ti-filter"></i>
                            <span>Filtrar</span>
                        </button>
                        <button class="vortex-preview-button primary">
                            <i class="ti ti-plus"></i>
                            <span>Añadir Nuevo</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Widgets de estadísticas -->
            <div class="vortex-preview-stats-grid">
                <div class="vortex-preview-stat-card">
                    <div class="vortex-preview-stat-card-content">
                        <div class="vortex-preview-stat-card-icon primary">
                            <i class="ti ti-shopping-cart"></i>
                        </div>
                        <div class="vortex-preview-stat-card-info">
                            <span class="vortex-preview-stat-card-title">Total Pedidos</span>
                            <span class="vortex-preview-stat-card-value">845.3k</span>
                            <div class="vortex-preview-stat-card-trend positive">
                                <i class="ti ti-arrow-up-right"></i>
                                <span>3.5%</span>
                                <span class="vortex-preview-stat-card-trend-period">vs mes anterior</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="vortex-preview-stat-card">
                    <div class="vortex-preview-stat-card-content">
                        <div class="vortex-preview-stat-card-icon danger">
                            <i class="ti ti-receipt-refund"></i>
                        </div>
                        <div class="vortex-preview-stat-card-info">
                            <span class="vortex-preview-stat-card-title">Devoluciones</span>
                            <span class="vortex-preview-stat-card-value">12.4k</span>
                            <div class="vortex-preview-stat-card-trend negative">
                                <i class="ti ti-arrow-down-right"></i>
                                <span>2.8%</span>
                                <span class="vortex-preview-stat-card-trend-period">vs mes anterior</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="vortex-preview-stat-card">
                    <div class="vortex-preview-stat-card-content">
                        <div class="vortex-preview-stat-card-icon success">
                            <i class="ti ti-coin"></i>
                        </div>
                        <div class="vortex-preview-stat-card-info">
                            <span class="vortex-preview-stat-card-title">Ingresos</span>
                            <span class="vortex-preview-stat-card-value">$98.3k</span>
                            <div class="vortex-preview-stat-card-trend positive">
                                <i class="ti ti-arrow-up-right"></i>
                                <span>7.2%</span>
                                <span class="vortex-preview-stat-card-trend-period">vs mes anterior</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="vortex-preview-stat-card">
                    <div class="vortex-preview-stat-card-content">
                        <div class="vortex-preview-stat-card-icon info">
                            <i class="ti ti-users"></i>
                        </div>
                        <div class="vortex-preview-stat-card-info">
                            <span class="vortex-preview-stat-card-title">Visitantes</span>
                            <span class="vortex-preview-stat-card-value">128.5k</span>
                            <div class="vortex-preview-stat-card-trend positive">
                                <i class="ti ti-arrow-up-right"></i>
                                <span>12.3%</span>
                                <span class="vortex-preview-stat-card-trend-period">vs mes anterior</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráficos y más widgets -->
            <div class="vortex-preview-charts-grid">
                <!-- Gráfico de ventas -->
                <div class="vortex-preview-card large">
                    <div class="vortex-preview-card-header">
                        <h3 class="vortex-preview-card-title">Resumen de ventas</h3>
                        <div class="vortex-preview-card-actions">
                            <button class="vortex-preview-icon-button small">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                        </div>
                    </div>
                    <div class="vortex-preview-card-body">
                        <div class="vortex-preview-chart-summary">
                            <div class="vortex-preview-chart-summary-item">
                                <span class="vortex-preview-chart-summary-label">Ingresos</span>
                                <span class="vortex-preview-chart-summary-value success">$28.5k</span>
                            </div>
                            <div class="vortex-preview-chart-summary-item">
                                <span class="vortex-preview-chart-summary-label">Gastos</span>
                                <span class="vortex-preview-chart-summary-value danger">$12.7k</span>
                            </div>
                            <div class="vortex-preview-chart-summary-item">
                                <span class="vortex-preview-chart-summary-label">Beneficio</span>
                                <span class="vortex-preview-chart-summary-value">$15.8k</span>
                            </div>
                        </div>
                        <div class="vortex-preview-chart">
                            <div class="vortex-preview-chart-placeholder">
                                <div class="vortex-preview-chart-bar" style="height: 30%;"></div>
                                <div class="vortex-preview-chart-bar" style="height: 70%;"></div>
                                <div class="vortex-preview-chart-bar" style="height: 45%;"></div>
                                <div class="vortex-preview-chart-bar" style="height: 80%;"></div>
                                <div class="vortex-preview-chart-bar" style="height: 60%;"></div>
                                <div class="vortex-preview-chart-bar" style="height: 45%;"></div>
                                <div class="vortex-preview-chart-line"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla de productos más vendidos -->
                <div class="vortex-preview-card">
                    <div class="vortex-preview-card-header">
                        <h3 class="vortex-preview-card-title">Productos más vendidos</h3>
                        <div class="vortex-preview-card-actions">
                            <button class="vortex-preview-icon-button small">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                        </div>
                    </div>
                    <div class="vortex-preview-card-body">
                        <table class="vortex-preview-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="vortex-preview-product">
                                            <div class="vortex-preview-product-icon"></div>
                                            <span>Producto Premium</span>
                                        </div>
                                    </td>
                                    <td>$99.99</td>
                                    <td>256</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="vortex-preview-product">
                                            <div class="vortex-preview-product-icon"></div>
                                            <span>Servicio Básico</span>
                                        </div>
                                    </td>
                                    <td>$59.99</td>
                                    <td>182</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="vortex-preview-product">
                                            <div class="vortex-preview-product-icon"></div>
                                            <span>Plan Empresarial</span>
                                        </div>
                                    </td>
                                    <td>$199.99</td>
                                    <td>128</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Actividad reciente -->
                <div class="vortex-preview-card">
                    <div class="vortex-preview-card-header">
                        <h3 class="vortex-preview-card-title">Actividad reciente</h3>
                        <div class="vortex-preview-card-actions">
                            <button class="vortex-preview-icon-button small">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                        </div>
                    </div>
                    <div class="vortex-preview-card-body">
                        <div class="vortex-preview-activity">
                            <div class="vortex-preview-activity-item">
                                <div class="vortex-preview-activity-icon success">
                                    <i class="ti ti-check"></i>
                                </div>
                                <div class="vortex-preview-activity-content">
                                    <div class="vortex-preview-activity-title">Nuevo pedido recibido</div>
                                    <div class="vortex-preview-activity-description">
                                        Juan Pérez ha realizado un pedido de $129.99
                                    </div>
                                    <div class="vortex-preview-activity-time">Hace 5 minutos</div>
                                </div>
                            </div>
                            <div class="vortex-preview-activity-item">
                                <div class="vortex-preview-activity-icon warning">
                                    <i class="ti ti-alert-triangle"></i>
                                </div>
                                <div class="vortex-preview-activity-content">
                                    <div class="vortex-preview-activity-title">Stock bajo</div>
                                    <div class="vortex-preview-activity-description">
                                        El producto "Plan Premium" está por debajo del nivel mínimo
                                    </div>
                                    <div class="vortex-preview-activity-time">Hace 20 minutos</div>
                                </div>
                            </div>
                            <div class="vortex-preview-activity-item">
                                <div class="vortex-preview-activity-icon info">
                                    <i class="ti ti-message-circle"></i>
                                </div>
                                <div class="vortex-preview-activity-content">
                                    <div class="vortex-preview-activity-title">Nuevo mensaje</div>
                                    <div class="vortex-preview-activity-description">
                                        María García: "Necesito ayuda con mi pedido reciente"
                                    </div>
                                    <div class="vortex-preview-activity-time">Hace 45 minutos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección de acciones -->
            <div class="vortex-preview-actions-section">
                <div class="vortex-preview-actions-grid">
                    <!-- Botón 3D primario -->
                    <div class="btn-3d-wrapper primary">
                        <div class="btn-3d-back"></div>
                        <button class="btn-3d">
                            <i class="ti ti-plus"></i>
                            <span class="btn-3d-text">Nuevo proyecto</span>
                        </button>
                    </div>
                    
                    <!-- Botón 3D secundario -->
                    <div class="btn-3d-wrapper secondary">
                        <div class="btn-3d-back"></div>
                        <button class="btn-3d">
                            <i class="ti ti-download"></i>
                            <span class="btn-3d-text">Descargar reporte</span>
                        </button>
                    </div>
                    
                    <!-- Botón 3D de éxito -->
                    <div class="btn-3d-wrapper success">
                        <div class="btn-3d-back"></div>
                        <button class="btn-3d">
                            <i class="ti ti-send"></i>
                            <span class="btn-3d-text">Enviar mensaje</span>
                        </button>
                    </div>
                    
                    <!-- Botón 3D de peligro -->
                    <div class="btn-3d-wrapper danger">
                        <div class="btn-3d-back"></div>
                        <button class="btn-3d">
                            <i class="ti ti-trash"></i>
                            <span class="btn-3d-text">Eliminar selección</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Alertas -->
            <div class="vortex-preview-alerts-section">
                <div class="alert alert-success">
                    <div class="alert-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Operación exitosa</div>
                        <p class="alert-message">Los cambios han sido guardados correctamente.</p>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <div class="alert-icon">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Advertencia</div>
                        <p class="alert-message">Algunos campos requieren tu atención antes de continuar.</p>
                    </div>
                </div>
                
                <div class="alert alert-danger">
                    <div class="alert-icon">
                        <i class="ti ti-alert-circle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Error</div>
                        <p class="alert-message">No se pudo completar la acción. Por favor, inténtalo de nuevo.</p>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <div class="alert-icon">
                        <i class="ti ti-info-circle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Información</div>
                        <p class="alert-message">Tu suscripción se renovará automáticamente el próximo mes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
