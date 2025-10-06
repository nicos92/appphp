<header class="form-header no-print">
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

<style>
    @media print {

        /* Estilos para vista de impresión */
        body * {
            visibility: hidden;
        }

        /* Mostrar solo el contenido de la tabla y encabezados */
        .container.my-5,
        .container.my-5 *,
        .table-responsive,
        .table,
        .table thead,
        .table tbody,
        .table tr,
        .table th,
        .table td,
        .print-filters {
            visibility: visible;
        }

        /* Estilo para body durante la impresión */
        body {
            visibility: visible;
            background: white;
            margin: 0;
            padding: 0;
        }

        /* Posicionar la tabla en la parte superior del documento impreso */
        .container.my-5 {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            min-width: 100% !important;
            margin: 0 !important;
            padding: 15mm !important;
        }

        .table-responsive {
            overflow: visible !important;
            width: 100% !important;
            min-width: 100% !important;
            display: block !important;
        }

        /* Asegurar formato A4 */
        @page {
            size: A4;
            margin: 1mm;
        }

        /* Estilos de tabla para impresión */
        table {
            width: 100% !important;
            min-width: 100% !important;
            border-collapse: collapse;
            font-size: 8pt;
            table-layout: auto;
            /* Changed from fixed to auto for better column distribution */
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 6px 4px !important;
            text-align: left;
            word-wrap: break-word;
            vertical-align: top;
            width: auto !important;
            /* Allow columns to adjust automatically */
        }

        /* Ocultar botones de acciones en impresión */
        .btn,
        button,
        [class*="btn"],
        .card-body.border-bottom,
        .card-body:not(.p-0),
        .d-none.d-md-block .card .btn {
            display: none !important;
        }

        /* Mostrar solo información específica en impresión */
        .card-header {
            display: block !important;
            border: 1px solid #000 !important;
        }

        /* Mostrar el badge con la información de tarimas del día */
        .card-header .badge {
            display: block !important;
            background: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #000 !important;
        }

        /* Cabecera con estilos */
        thead tr {
            background-color: #667eea !important;
            color: white !important;
        }

        /* Mostrar solo la tabla principal */
        .card,
        .card-body {
            box-shadow: none !important;
            border: none !important;
            background: white !important;
            padding: 0 !important;
            width: 100% !important;
            min-width: 100% !important;
        }

        /* Show card elements during printing */
        .d-none.d-xl-block {
            display: block !important;
        }

        .d-none.d-xl-block .row {
            display: block !important;
        }

        .d-none.d-xl-block .table-responsive {
            display: table !important;
            width: 100% !important;
        }

        .d-xl-none .row {
            display: block !important;
        }

        .d-xl-none .col-12,
        .d-xl-none .col-sm-12,
        .d-xl-none .col-md-4,
        .d-xl-none .col-lg-3 {
            display: block !important;
            width: 100% !important;
            margin-bottom: 15px;
        }

        .d-xl-none .card {
            display: block !important;
            border: 1px solid #000 !important;
        }

        /* Ajustar el ancho de las columnas */
        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Ocultar elementos que no deben imprimirse */
        .no-print,
        .no-print * {
            display: none !important;
        }

        .d-xl-none {
            display: none !important;
        }
    }

    /* Mostrar filtros aplicados en la impresión */
    @media print {
        .print-filters {
            visibility: visible;
            position: static;
            font-size: 8pt;
            margin-bottom: 8px;
            padding: 8px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            width: 100% !important;
        }

        .print-filters h4 {
            margin: 0 0 10px 0;
            font-size: 8pt;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .print-filters ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .print-filters li {
            margin: 3px 0;
        }
    }
</style>

<div class="container my-5">
    <!-- Mostrar filtros aplicados en vista de impresión -->
    <div class="print-filters" style="display: none;">
        <h4>Filtros Aplicados:</h4>
        <ul>
            <?php if (!empty($filtros['numero_producto'])): ?>
                <li><strong>Producto:</strong> <?= htmlspecialchars($filtros['numero_producto']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['numero_tarima'])): ?>
                <li><strong>Tarima:</strong> <?= htmlspecialchars($filtros['numero_tarima']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['numero_usuario'])): ?>
                <li><strong>Usuario:</strong> <?= htmlspecialchars($filtros['numero_usuario']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['numero_venta'])): ?>
                <li><strong>Venta:</strong> <?= htmlspecialchars($filtros['numero_venta']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['fecha_registro'])): ?>
                <li><strong>Fecha de Registro:</strong> <?= htmlspecialchars($filtros['fecha_registro']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['legajo'])): ?>
                <li><strong>Legajo</strong> <?= htmlspecialchars($filtros['legajo']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['nombre_usuario'])): ?>
                <li><strong>Nombre Usuario:</strong> <?= htmlspecialchars($filtros['nombre_usuario']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['cantidad_cajas_min'])): ?>
                <li><strong>Cant. Cajas:</strong> <?= htmlspecialchars($filtros['cantidad_cajas_min']); ?></li>
            <?php endif; ?>
            <?php if (!empty($filtros['peso_min'])): ?>
                <li><strong>Peso:</strong> <?= htmlspecialchars($filtros['peso_min']); ?></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-column align-items-start no-print" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; ">
            <div class="d-flex justify-content-between w-100 align-items-center">
                <h3 class="mb-0">Inventario de Tarimas</h3>
                <div>
                    <a href="<?= BASE_URL ?>/tarimas/nueva_tarima" class="btn btn-light me-2 m-2">
                        <i class="fas fa-plus me-2"></i>Nueva Tarima
                    </a>
                    <a href="<?= BASE_URL ?>/dashboard" class="btn btn-light m-2">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                    </a>
                    <button type="button" class="btn btn-light m-2" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Imprimir
                    </button>
                </div>
            </div>
            <div class="mt-2 d-flex flex-wrap gap-2">
                <span class="badge text-bg-warning">Tarimas ingresadas hoy: <strong><?= htmlspecialchars($tarimas_hoy ?? 0); ?></strong></span>
                <span class="badge text-bg-info">Tarimas mostradas: <strong><?= count($tarimas ?? []); ?></strong></span>
            </div>
        </div>

        <!-- Sección de filtrado -->
        <div class="card-body border-bottom no-print">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
            <form id="filtroTarimas" method="GET" action="<?= BASE_URL ?>/tarimas">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="numero_producto" class="form-label">Producto</label>
                        <input type="number" class="form-control" id="numero_producto" name="numero_producto" value="<?= htmlspecialchars($filtros['numero_producto'] ?? ''); ?>" placeholder="Buscar por producto" maxlength="6">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_tarima" class="form-label">Tarima</label>
                        <input type="number" class="form-control" id="numero_tarima" name="numero_tarima" value="<?= htmlspecialchars($filtros['numero_tarima'] ?? ''); ?>" placeholder="Buscar por número">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_usuario" class="form-label">Usuario</label>
                        <input type="number" class="form-control" id="numero_usuario" name="numero_usuario" value="<?= htmlspecialchars($filtros['numero_usuario'] ?? ''); ?>" placeholder="Buscar por usuario">
                    </div>
                    <div class="col-md-3">
                        <label for="numero_venta" class="form-label">Venta</label>
                        <input type="text" class="form-control" id="numero_venta" name="numero_venta" value="<?= htmlspecialchars($filtros['numero_venta'] ?? ''); ?>" placeholder="Buscar por venta">
                    </div>

                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                        <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?= htmlspecialchars($filtros['fecha_registro'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="legajo" class="form-label">Legajo</label>
                        <input type="number" class="form-control" id="legajo" name="legajo" value="<?= htmlspecialchars($filtros['legajo'] ?? ''); ?>" placeholder="Buscar por legajo">
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_usuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($filtros['nombre_usuario'] ?? ''); ?>" placeholder="Buscar por nombre">
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad_cajas_min" class="form-label">Cajas </label>
                        <input type="number" class="form-control" id="cantidad_cajas_min" name="cantidad_cajas_min" value="<?= htmlspecialchars($filtros['cantidad_cajas_min'] ?? ''); ?>" placeholder="Mínimo">
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="peso_min" class="form-label">Peso</label>
                        <input type="number" step="0.01" class="form-control" id="peso_min" name="peso_min" value="<?= htmlspecialchars($filtros['peso_min'] ?? ''); ?>" placeholder="Mínimo">
                    </div>
                </div>
                <div class="row g-3 mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary m-2">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-secondary m-2" onclick="limpiarFiltros()">
                            <i class="fas fa-eraser me-2"></i>Limpiar Filtros
                        </button>
                        <a href="<?= BASE_URL ?>/tarimas?all=1" class="btn btn-success">
                            <i class="fas fa-list me-2"></i>Ver Últimas 1000 Tarimas
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <!-- Table view for large and extra large screens -->
            <div class="table-responsive d-none d-xl-block">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th>Producto</th>
                            <th>Tarima</th>
                            <th>Usuario</th>
                            <th>Cajas</th>
                            <th>Peso</th>
                            <th>Venta</th>
                            <th>Legajo</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <?php if (isset($role) && $role === 'administrador'): ?>
                                <th class="no-print">Acciones</th>
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
                                        <td class="no-print">
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

            <!-- Card view for smaller screens -->
            <div class="d-xl-none">
                <?php if (!empty($tarimas)): ?>
                    <div class="row g-3 p-3">
                        <?php foreach ($tarimas as $tarima): ?>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="card-title">
                                                <span class="badge bg-primary">Tarima: <?= htmlspecialchars($tarima['numero_tarima']); ?></span>
                                            </h5>
                                            <?php if (isset($role) && ($role === 'administrador' || $role === 'jefe_produccion')): ?>
                                                <a href="<?= BASE_URL ?>/tarimas/editar_tarima/<?= $tarima['id_tarima']; ?>" class="btn btn-sm btn-outline-warning no-print" title="Editar tarima">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-text">
                                            <p class="mb-1"><strong>Producto:</strong> <?= htmlspecialchars($tarima['numero_producto'] ?? ''); ?></p>
                                            <p class="mb-1"><strong>Usuario:</strong> <?= htmlspecialchars($tarima['numero_usuario']); ?></p>
                                            <p class="mb-1"><strong>Cajas:</strong> <?= htmlspecialchars($tarima['cantidad_cajas']); ?></p>
                                            <p class="mb-1"><strong>Peso:</strong> <?= htmlspecialchars($tarima['peso']); ?></p>
                                            <p class="mb-1"><strong>Venta:</strong> <?= htmlspecialchars($tarima['numero_venta']); ?></p>
                                            <p class="mb-1"><strong>Legajo:</strong> <?= htmlspecialchars($tarima['legajo'] ?? 'N/A'); ?></p>
                                            <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($tarima['nombre_usuario'] ?? 'N/A'); ?></p>
                                            <p class="mb-1"><strong>Fecha:</strong> <?= htmlspecialchars($tarima['fecha_registro']); ?></p>
                                            <p class="mb-1"><strong>Descripción:</strong> <?= htmlspecialchars($tarima['descripcion'] ?? ''); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-3">
                        <p class="text-center text-muted">No hay tarimas registradas aún.</p>
                    </div>
                <?php endif; ?>
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
