<?php if (isset($_SESSION['username'])): ?>
    <header class="form-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0"><i class="fas fa-cubes me-2"></i>Sistema de Inventario</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="me-3">Bienvenido, <strong><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></strong></span>
                    <a href="<?= BASE_URL ?>/auth/logout" class="btn logout-btn text-white">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>
<?php else: ?>
    <header class="form-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0"><i class="fas fa-cubes me-2"></i>Sistema de Inventario</h1>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <div class="card-header text-center">
                    <h3 class="mb-0 text-dark">Iniciar Sesión</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if ($error === 'invalid_credentials'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Credenciales incorrectas. Por favor, verifique su nombre de usuario y contraseña.
                            <?php elseif ($error === 'empty_fields'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Por favor, complete todos los campos.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/auth/login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group position-relative">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="password-toggle position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent" style="cursor: pointer; z-index: 5;" onclick="togglePassword('password', 'toggleIcon')">
                                    <i id="toggleIcon" class="fas fa-eye-slash"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>

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
