<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-cubes me-2"></i>Sistema de Inventario</h1>
            </div>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card p-4">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="mb-0">Crear Cuenta</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($success) && $success === 'true'): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            ¡Su cuenta ha sido creada exitosamente! Puede iniciar sesión ahora.
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if ($error === 'empty_fields'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Por favor, complete todos los campos.
                            <?php elseif ($error === 'password_mismatch'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Las contraseñas no coinciden. Por favor, inténtelo de nuevo.
                            <?php elseif ($error === 'terms_not_accepted'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Debe aceptar los términos y condiciones para registrarse.
                            <?php elseif ($error === 'invalid_email'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Por favor, ingrese un email válido.
                            <?php elseif ($error === 'user_exists'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                El nombre de usuario o email ya están registrados.
                            <?php elseif ($error === 'registration_failed'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Error al registrar la cuenta. Por favor, inténtelo de nuevo.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= BASE_URL ?>/auth/register">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="legajo" class="form-label">Número de Legajo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control" id="legajo" name="legajo" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <span class="password-toggle position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer; z-index: 5;" onclick="togglePassword('password', 'passwordToggle')">
                                            <i id="passwordToggle" class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        <span class="password-toggle position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer; z-index: 5;" onclick="togglePassword('confirmPassword', 'confirmPasswordToggle')">
                                            <i id="confirmPasswordToggle" class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="department" class="form-label">Departamento</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="" selected disabled>Seleccione Departamento</option>
                                    <option value="ventas">Ventas</option>
                                    <option value="inventario">Inventario</option>
                                    <option value="logistica">Logística</option>
                                    <option value="administracion">Administración</option>
                                    <option value="produccion">Producción</option>
                                    <option value="calidad">Control de Calidad</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Acepto los <a href="#" class="text-decoration-none">Términos y Condiciones</a></label>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>¿Ya tiene una cuenta? <a href="<?= BASE_URL ?>/auth/login">Inicie sesión aquí</a></p>
                    </div>
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
</script>