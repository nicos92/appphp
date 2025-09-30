<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Usuario</h1>
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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Editar Información de Usuario</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if ($_GET['error'] === 'empty_fields'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Por favor, complete todos los campos obligatorios.
                            <?php elseif ($_GET['error'] === 'invalid_email'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Por favor, ingrese un email válido.
                            <?php elseif ($_GET['error'] === 'user_exists'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                El nombre de usuario o email ya están registrados.
                            <?php elseif ($_GET['error'] === 'update_failed'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Error al actualizar la información del usuario. Por favor, inténtelo de nuevo.
                            <?php elseif ($_GET['error'] === 'empty_password_fields'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Para cambiar la contraseña, debe completar ambos campos de contraseña.
                            <?php elseif ($_GET['error'] === 'password_mismatch'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Las contraseñas no coinciden. Por favor, inténtelo de nuevo.
                            <?php elseif ($_GET['error'] === 'weak_password'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                La contraseña debe tener al menos 6 caracteres.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success']) && $_GET['success'] === 'usuario_actualizado'): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            ¡La información del usuario ha sido actualizada exitosamente!
                        </div>
                    <?php endif; ?>

                    <?php if (isset($usuario)): ?>
                        <form method="POST" action="<?= BASE_URL ?>/dashboard/actualizar_usuario/<?= htmlspecialchars($usuario['id_usuario']); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= htmlspecialchars($usuario['first_name']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Apellido</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= htmlspecialchars($usuario['last_name']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($usuario['username']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="legajo" class="form-label">Número de Legajo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" class="form-control" id="legajo" name="legajo" value="<?= htmlspecialchars($usuario['legajo']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="department" class="form-label">Departamento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <select class="form-select" id="department" name="department" required>
                                        <option value="ventas" <?= $usuario['department'] === 'ventas' ? 'selected' : ''; ?>>Ventas</option>
                                        <option value="inventario" <?= $usuario['department'] === 'inventario' ? 'selected' : ''; ?>>Inventario</option>
                                        <option value="logistica" <?= $usuario['department'] === 'logistica' ? 'selected' : ''; ?>>Logística</option>
                                        <option value="administracion" <?= $usuario['department'] === 'administracion' ? 'selected' : ''; ?>>Administración</option>
                                        <option value="produccion" <?= $usuario['department'] === 'produccion' ? 'selected' : ''; ?>>Producción</option>
                                        <option value="calidad" <?= $usuario['department'] === 'calidad' ? 'selected' : ''; ?>>Control de Calidad</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="idRol" class="form-label">Rol de Usuario</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select class="form-select" id="idRol" name="idRol" required>
                                            <option value="2" <?= $usuario['id_rol'] == 2 ? 'selected' : ''; ?>>Producción (Acceso limitado)</option>
                                            <option value="3" <?= $usuario['id_rol'] == 3 ? 'selected' : ''; ?>>Jefe de Producción (Gestión de tarimas)</option>
                                            <option value="1" <?= $usuario['id_rol'] == 1 ? 'selected' : ''; ?>>Administrador (Acceso completo)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check mb-3 w-100">
                                        <input type="checkbox" class="form-check-input" id="activo" name="activo" <?= ($usuario['activo'] ?? 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="activo">Usuario Activo</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para cambio de contraseña -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                        <div class="input-group position-relative">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Dejar en blanco para mantener actual">
                                            <button type="button" class="password-toggle position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent" style="cursor: pointer; z-index: 5;" onclick="togglePassword('newPassword', 'newPasswordToggle')" aria-label="Mostrar/Ocultar contraseña">
                                                <i id="newPasswordToggle" class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                                        <div class="input-group position-relative">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Dejar en blanco para mantener actual">
                                            <button type="button" class="password-toggle position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent" style="cursor: pointer; z-index: 5;" onclick="togglePassword('confirmPassword', 'confirmPasswordToggle')" aria-label="Mostrar/Ocultar confirmación de contraseña">
                                                <i id="confirmPasswordToggle" class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0 p-0" id="passwordMatchMessage" style="display: none;">
                                <div id="passwordDivMessage" class="alert p-0 alert-info alert-danger" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span id="passwordMatchText"></span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/dashboard/usuarios" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver a Usuarios
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Usuario
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Usuario no encontrado.
                        </div>
                        <a href="<?= BASE_URL ?>/dashboard/usuarios" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Usuarios
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    // Función para verificar si las contraseñas coinciden
    function checkPasswordMatch() {
        const password = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const messageDiv = document.getElementById('passwordMatchMessage');
        const messageText = document.getElementById('passwordMatchText');
        const passwordDivMessage = document.getElementById('passwordDivMessage');

        if (confirmPassword.length > 0) { // Solo mostrar mensaje si hay algo escrito en confirm password
            if (password === confirmPassword) {
                passwordDivMessage.className = 'mb-0 p-2 alert alert-success';
                messageText.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i>Las contraseñas coinciden';
                messageDiv.style.display = 'block';
            } else {
                messageText.innerHTML = '<i class="fas fa-times-circle text-danger me-2"></i>Las contraseñas no coinciden';
                passwordDivMessage.className = 'mb-0 p-2 alert alert-danger';
                messageDiv.style.display = 'block';
            }
        } else {
            messageDiv.style.display = 'none';
        }
    }

    // Agregar eventos de escucha a los campos de contraseña
    document.getElementById('newPassword').addEventListener('input', checkPasswordMatch);
    document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);
</script>
