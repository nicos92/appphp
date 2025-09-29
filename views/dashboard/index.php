<header class="dashboard-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-cubes me-2"></i>Sistema de Tarimas</h1>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="me-3">Bienvenido, <strong><?= htmlspecialchars($username ?? ''); ?></strong></span>
                <a href="<?= BASE_URL ?>/auth/logout" class="btn logout-btn text-white">
                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </div>
</header>

<div class="container my-5">
    <?php if (isset($success) && $success === 'entity_created'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>Tarima registrada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">Panel de Control</h2>
                    <p class="text-muted mb-0">Gestiona eficientemente la información de productos, usuarios y operaciones de inventario</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= BASE_URL ?>/tarimas/nueva_tarima" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Nueva Tarima
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="feature-icon bg-primary-light mx-auto">
                        <i class="fas fa-box fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-2">Inventario</h5>
                    <p class="text-muted">Gestiona productos y stock</p>
                    <a href="<?= BASE_URL ?>/tarimas" class="btn btn-outline-primary btn-sm">Ver más</a>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrador'): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="feature-icon bg-success-light mx-auto">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                    <h5 class="mb-2">Usuarios</h5>
                    <p class="text-muted">Administra cuentas de usuario</p>
                    <a href="<?= BASE_URL ?>/dashboard/usuarios" class="btn btn-outline-success btn-sm">Ver más</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="feature-icon bg-info-light mx-auto">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                    <h5 class="mb-2">Reportes</h5>
                    <p class="text-muted">Genera informes detallados</p>
                    <a href="#" class="btn btn-outline-info btn-sm">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="feature-icon bg-warning-light mx-auto">
                        <i class="fas fa-cog fa-2x text-warning"></i>
                    </div>
                    <h5 class="mb-2">Configuración</h5>
                    <p class="text-muted">Ajustes del sistema</p>
                    <a href="#" class="btn btn-outline-warning btn-sm">Ver más</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Estructura de Tarima</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5><i class="fas fa-hashtag me-2 text-primary"></i>Identificador</h5>
                                <p>Campo único para identificar cada entidad</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-barcode me-2 text-success"></i>Código de Barras</h5>
                                <p>Para identificación rápida y precisa</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-warehouse me-2 text-info"></i>Tarima</h5>
                                <p>Para seguimiento logístico</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-user me-2 text-warning"></i>Usuario</h5>
                                <p>Identificación del responsable</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5><i class="fas fa-boxes me-2 text-danger"></i>Cantidad de Cajas</h5>
                                <p>Para control de inventario</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-weight me-2 text-secondary"></i>Peso</h5>
                                <p>Para logística y transporte</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-tags me-2 text-dark"></i>Venta</h5>
                                <p>Para seguimiento comercial</p>
                            </div>
                            <div class="mb-3">
                                <h5><i class="fas fa-id-card me-2 text-muted"></i>Legajo</h5>
                                <p>Identificación interna de empleado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Estadísticas Recientes</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-4 fw-bold text-primary"><?= number_format($total_tarimas ?? 0); ?></div>
                        <p class="text-muted">Tarimas Registradas</p>
                    </div>
                    <?php if (isset($role) && $role === 'administrador'): ?>
                    <div class="text-center">
                        <div class="display-4 fw-bold text-info"><?= number_format($total_usuarios ?? 0); ?></div>
                        <p class="text-muted">Usuarios Registrados</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
