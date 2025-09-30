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
            <div>
                <a href="<?= BASE_URL ?>/tarimas/nueva_tarima" class="btn btn-light me-2 m-2">
                    <i class="fas fa-plus me-2"></i>Nueva Tarima
                </a>
                <a href="<?= BASE_URL ?>/dashboard" class="btn btn-light m-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                </a>
            </div>
        </div>

        <!-- Sección de filtrado -->
        <div class="card-body border-bottom">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
            <form id="filtroTarimas" method="GET" action="<?= BASE_URL ?>/tarimas">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="numero_producto" class="form-label">Número de Producto</label>
                        <input type="text" class="form-control" id="numero_producto" name="numero_producto" value="<?= htmlspecialchars($filtros['numero_producto'] ?? ''); ?>" placeholder="Buscar por producto" maxlength="6">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_tarima" class="form-label">Número de Tarima</label>
                        <input type="text" class="form-control" id="numero_tarima" name="numero_tarima" value="<?= htmlspecialchars($filtros['numero_tarima'] ?? ''); ?>" placeholder="Buscar por número">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_usuario" class="form-label">Número de Usuario</label>
                        <input type="text" class="form-control" id="numero_usuario" name="numero_usuario" value="<?= htmlspecialchars($filtros['numero_usuario'] ?? ''); ?>" placeholder="Buscar por usuario">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_venta" class="form-label">Número de Venta</label>
                        <input type="text" class="form-control" id="numero_venta" name="numero_venta" value="<?= htmlspecialchars($filtros['numero_venta'] ?? ''); ?>" placeholder="Buscar por venta">
                    </div>

                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                        <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?= htmlspecialchars($filtros['fecha_registro'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="legajo" class="form-label">Legajo Usuario</label>
                        <input type="text" class="form-control" id="legajo" name="legajo" value="<?= htmlspecialchars($filtros['legajo'] ?? ''); ?>" placeholder="Buscar por legajo">
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_usuario" class="form-label">Nombre Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($filtros['nombre_usuario'] ?? ''); ?>" placeholder="Buscar por nombre">
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad_cajas_min" class="form-label">Cajas Mínimas</label>
                        <input type="number" class="form-control" id="cantidad_cajas_min" name="cantidad_cajas_min" value="<?= htmlspecialchars($filtros['cantidad_cajas_min'] ?? ''); ?>" placeholder="Mínimo">
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="peso_min" class="form-label">Peso Mínimo (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="peso_min" name="peso_min" value="<?= htmlspecialchars($filtros['peso_min'] ?? ''); ?>" placeholder="Mínimo">
                    </div>
                </div>
                <div class="row g-3 mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                            <i class="fas fa-eraser me-2"></i>Limpiar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th>Número de Producto</th>
                            <th>Número de Tarima</th>
                            <th>Número de Usuario</th>
                            <th>Cantidad de Cajas</th>
                            <th>Peso (kg)</th>
                            <th>Número de Venta</th>
                            <th>Legajo Usuario</th>
                            <th>Nombre Usuario</th>
                            <th>Fecha de Registro</th>
                            <th>Descripción</th>
                            <?php if (isset($role) && $role === 'administrador'): ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tarimas)): ?>
                            <?php foreach ($tarimas as $tarima): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tarima['numero_producto'] ?? ''); ?></td>
                                    <td><?= htmlspecialchars($tarima['numero_tarima']); ?></td>
                                    <td><?= htmlspecialchars($tarima['numero_usuario']); ?></td>
                                    <td><?= htmlspecialchars($tarima['cantidad_cajas']); ?></td>
                                    <td><?= htmlspecialchars($tarima['peso']); ?></td>
                                    <td><?= htmlspecialchars($tarima['numero_venta']); ?></td>
                                    <td><?= htmlspecialchars($tarima['legajo'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($tarima['nombre_usuario'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($tarima['fecha_registro']); ?></td>
                                    <td><?= htmlspecialchars($tarima['descripcion'] ?? ''); ?></td>
                                    <?php if (isset($role) && ($role === 'administrador' || $role === 'jefe_produccion')): ?>
                                        <td>
                                            <a href="<?= BASE_URL ?>/tarimas/editar_tarima/<?= $tarima['id_tarima']; ?>" class="btn btn-sm btn-outline-warning" title="Editar tarima">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?php echo (isset($role) && ($role === 'administrador' || $role === 'jefe_produccion')) ? 11 : 10; ?>" class="text-center text-muted">No hay tarimas registradas aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function limpiarFiltros() {
        // Limpiar todos los campos de filtro
        document.getElementById('numero_producto').value = '';
        document.getElementById('numero_tarima').value = '';
        document.getElementById('numero_usuario').value = '';
        document.getElementById('numero_venta').value = '';
        document.getElementById('fecha_registro').value = '';
        document.getElementById('legajo').value = '';
        document.getElementById('nombre_usuario').value = '';
        document.getElementById('cantidad_cajas_min').value = '';
        document.getElementById('peso_min').value = '';

        // Enviar el formulario para actualizar la lista sin filtros
        document.getElementById('filtroTarimas').submit();
    }
</script>
