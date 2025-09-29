<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-boxes me-2"></i>Últimas Tarimas</h1>
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
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; ">
            <h3 class="mb-0">Inventario de Tarimas</h3>
            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Volver al Panel
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th>Número de Tarima</th>
                            <th>Número de Usuario</th>
                            <th>Cantidad de Cajas</th>
                            <th>Peso (kg)</th>
                            <th>Número de Venta</th>
                            <th>Legajo Usuario</th>
                            <th>Nombre Usuario</th>
                            <th>Fecha de Registro</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tarimas)): ?>
                            <?php foreach ($tarimas as $tarima): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tarima['numero_tarima']); ?></td>
                                    <td><?= htmlspecialchars($tarima['numero_usuario']); ?></td>
                                    <td><?= htmlspecialchars($tarima['cantidad_cajas']); ?></td>
                                    <td><?= htmlspecialchars($tarima['peso']); ?></td>
                                    <td><?= htmlspecialchars($tarima['numero_venta']); ?></td>
                                    <td><?= htmlspecialchars($tarima['legajo'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($tarima['nombre_usuario'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($tarima['fecha_registro']); ?></td>
                                    <td><?= htmlspecialchars($tarima['descripcion'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No hay tarimas registradas aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
