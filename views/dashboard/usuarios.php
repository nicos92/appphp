<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-users me-2"></i>Usuarios del Sistema</h1>
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
            <h3 class="mb-0">Lista de Usuarios</h3>
            <div>
                <a href="<?= BASE_URL ?>/auth/register" class="btn btn-light me-2">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                </a>
                <a href="<?= BASE_URL ?>/dashboard" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Email</th>
                            <th>Nombre Completo</th>
                            <th>Legajo</th>
                            <th>Departamento</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                                    <td><?= htmlspecialchars($usuario['username']); ?></td>
                                    <td><?= htmlspecialchars($usuario['email']); ?></td>
                                    <td><?= htmlspecialchars($usuario['first_name'] . ' ' . $usuario['last_name']); ?></td>
                                    <td><?= htmlspecialchars($usuario['legajo']); ?></td>
                                    <td><?= htmlspecialchars($usuario['department']); ?></td>
                                    <td>
                                        <span class="badge <?= $usuario['nombre_rol'] === 'administrador' ? 'bg-danger' : 'bg-success'; ?>">
                                            <?= htmlspecialchars($usuario['nombre_rol'] ?? 'produccion'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($usuario['activo'] ?? 1): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($usuario['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No hay usuarios registrados aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>