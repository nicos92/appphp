<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-warehouse me-2"></i>Editar Tarima</h1>
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
            <div class="form-card">
                <h3 class="mb-4">Formulario de Edición de Tarima</h3>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <?php if ($error === 'required_fields_missing'): ?>
                            <i class="fas fa-exclamation-triangle me-2"></i>Los campos código de barras y número de tarima son obligatorios.
                        <?php elseif ($error === 'update_failed'): ?>
                            <i class="fas fa-exclamation-triangle me-2"></i>Error al actualizar la tarima.
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error ?? 'Error desconocido al actualizar la tarima.'); ?>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success === 'tarima_actualizada'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>¡Tarima actualizada correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <?php if ($_GET['error'] === 'required_fields_missing'): ?>
                            <i class="fas fa-exclamation-triangle me-2"></i>Los campos código de barras y número de tarima son obligatorios.
                        <?php elseif ($_GET['error'] === 'update_failed'): ?>
                            <i class="fas fa-exclamation-triangle me-2"></i>Error al actualizar la tarima.
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($_GET['error'] ?? 'Error desconocido al actualizar la tarima.'); ?>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] === 'tarima_actualizada'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>¡Tarima actualizada correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($tarima)): ?>
                    <form method="POST" action="<?= BASE_URL ?>/tarimas/actualizar_tarima/<?= $tarima['id_tarima']; ?>">
                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            <input type="number" class="form-control" id="codigoBarras" name="codigoBarras" value="<?= htmlspecialchars($tarima['codigo_barras'] ?? ''); ?>" required step="1" oninput="limitLength(this, 30)">
                            <div class="invalid-feedback">
                                El código de barras es requerido y debe tener máximo 30 dígitos.
                            </div>
                        </div>

                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="number" class="form-control" id="numeroProducto" name="numeroProducto" value="<?= htmlspecialchars($tarima['numero_producto'] ?? ''); ?>" required step="1" oninput="limitLength(this, 6)">
                            <div class="invalid-feedback">
                                El número de producto es requerido y debe tener máximo 6 dígitos.
                            </div>
                        </div>

                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                            <input type="number" class="form-control" id="numeroTarima" name="numeroTarima" value="<?= htmlspecialchars($tarima['numero_tarima'] ?? ''); ?>" required step="1" oninput="limitLength(this, 6)">
                            <div class="invalid-feedback">
                                El número de tarima es requerido y debe tener máximo 6 dígitos.
                            </div>
                        </div>

                        <div class="input-group has-validation mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="number" class="form-control" id="numeroUsuario" name="numeroUsuario" value="<?= htmlspecialchars($tarima['numero_usuario'] ?? ''); ?>" required step="1" oninput="limitLength(this, 2)">
                            <div class="invalid-feedback">
                                El número de usuario es requerido y debe tener máximo 2 dígitos.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                    <input type="number" class="form-control" id="cantidadCajas" name="cantidadCajas" value="<?= htmlspecialchars($tarima['cantidad_cajas'] ?? ''); ?>" required min="1" max="999" step="1" oninput="limitLength(this, 3)">
                                    <div class="invalid-feedback">
                                        La cantidad debe ser entre 1 y 999.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    <input type="number" class="form-control" id="peso" name="peso" value="<?= htmlspecialchars($tarima['peso'] ?? ''); ?>" min="0" max="9999.99" step="0.01" oninput="limitLength(this, 7)">
                                    <div class="invalid-feedback">
                                        El peso debe ser entre 0 y 9999.99.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                    <input type="text" class="form-control" id="numeroVenta" name="numeroVenta" value="<?= htmlspecialchars($tarima['numero_venta'] ?? ''); ?>" required pattern="25-\d{6}" oninput="limitLength(this, 9)">
                                    <div class="invalid-feedback">
                                        El número de venta debe seguir el formato 25-XXXXXX (25- seguido de 6 dígitos).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción adicional de la tarima"><?= htmlspecialchars($tarima['descripcion'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/tarimas" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Inventario
                            </a>
                            <button type="submit" class="btn btn-submit btn-lg btn-focus-animation">
                                <i class="fas fa-save me-2"></i>Actualizar Tarima
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>La tarima no fue encontrada.
                    </div>
                    <a href="<?= BASE_URL ?>/tarimas" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Inventario
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Load the shared JavaScript file -->
<script src="<?= BASE_URL ?>/public/assets/js/shared.js" onerror="console.error('Failed to load shared.js');"></script>

<!-- Fallback: include the function directly if external script fails -->
<script>
    // Check if function exists, if not define it as fallback
    if (typeof limitLength === 'undefined') {
        function limitLength(input, maxLength) {
            // Get the value as a string
            let value = input.value.toString();

            // For number inputs, only allow digits
            if (input.type === 'number') {
                value = value.replace(/[^0-9]/g, '');
            }

            // For text inputs like numeroVenta, allow digits and hyphen
            if (input.id === 'numeroVenta') {
                value = value.replace(/[^0-9\-]/g, '');
            }

            // For number inputs, check against max value instead of length
            if (input.id === 'numeroProducto' && value.length > maxLength) {
                value = value.substring(0, maxLength);
            } else if (input.id === 'numeroTarima' && value.length > maxLength) {
                value = value.substring(0, maxLength);
            } else if (input.id === 'numeroUsuario' && value.length > maxLength) {
                value = value.substring(0, maxLength);
            } else if (input.id === 'cantidadCajas' && value.length > maxLength) {
                value = value.substring(0, maxLength);
            } else if (input.id === 'peso') {
                // For peso, also ensure it doesn't exceed 9999.99
                const numValue = parseFloat(value);
                if (!isNaN(numValue) && numValue > 9999.99) {
                    value = '9999.99';
                }
            } else if (input.id === 'numeroVenta' && value.length > maxLength) {
                value = value.substring(0, maxLength);
            }

            // Set the value back to the input
            input.value = value;
        }
    }

    // Add event listeners to number inputs to enforce length limits (for consistency with nueva_tarima.php)
    document.getElementById('codigoBarras') && document.getElementById('codigoBarras').addEventListener('input', function() {
        let value = this.value.toString();
        // Only allow digits
        value = value.replace(/[^0-9]/g, '');

        // Check if input is longer than 30 digits
        if (value.length > 30) {
            value = value.substring(0, 30);
        }

        // Update the input value
        this.value = value;
    });

    // Also validate on form submission (similar to nueva_tarima.php)
    document.querySelector('form') && document.querySelector('form').addEventListener('submit', function(e) {
        const codigoBarras = document.getElementById('codigoBarras');
        if (codigoBarras) {
            const codigoBarrasValue = codigoBarras.value;

            if (codigoBarrasValue.length > 30) {
                e.preventDefault();
                alert('El código de barras no puede tener más de 30 dígitos.');
                codigoBarras.focus();
                return false;
            }

            // Validate barcode structure (similar to nueva_tarima.php)
            if (codigoBarrasValue.length === 30) {
                if (codigoBarrasValue.charAt(0) !== '0') {
                    e.preventDefault();
                    alert('El código de barras debe iniciar con 0');
                    codigoBarras.focus();
                    return false;
                }

                if (codigoBarrasValue.substring(13, 17) !== "9998") {
                    e.preventDefault();
                    alert('El código de barras no pertenece a una tarima (debe tener "9998" en posiciones 14-17)');
                    codigoBarras.focus();
                    return false;
                }
            }
        }

        const numeroProducto = document.getElementById('numeroProducto');
        if (numeroProducto && numeroProducto.value.length > 6) {
            e.preventDefault();
            alert('El número de producto no puede tener más de 6 dígitos.');
            numeroProducto.focus();
            return false;
        }

        const numeroTarima = document.getElementById('numeroTarima');
        if (numeroTarima && numeroTarima.value.length > 6) {
            e.preventDefault();
            alert('El número de tarima no puede tener más de 6 dígitos.');
            numeroTarima.focus();
            return false;
        }

        const numeroUsuario = document.getElementById('numeroUsuario');
        if (numeroUsuario && numeroUsuario.value.length > 2) {
            e.preventDefault();
            alert('El número de usuario no puede tener más de 2 dígitos.');
            numeroUsuario.focus();
            return false;
        }

        const cantidadCajas = document.getElementById('cantidadCajas');
        if (cantidadCajas && cantidadCajas.value.length > 3) {
            e.preventDefault();
            alert('La cantidad de cajas no puede tener más de 3 dígitos.');
            cantidadCajas.focus();
            return false;
        }

        const numeroVenta = document.getElementById('numeroVenta');
        if (numeroVenta && numeroVenta.value.length > 9) {
            e.preventDefault();
            alert('El número de venta no puede tener más de 9 caracteres.');
            numeroVenta.focus();
            return false;
        }

        const peso = document.getElementById('peso');
        if (peso) {
            const pesoFloat = parseFloat(peso.value);
            if (pesoFloat > 9999.99) {
                e.preventDefault();
                alert('El peso no puede ser mayor a 9999.99.');
                peso.focus();
                return false;
            }
        }

        // Validate venta number format
        if (numeroVenta) {
            const ventaRegex = /^25-\d{6}$/;
            if (!ventaRegex.test(numeroVenta.value)) {
                e.preventDefault();
                alert('El número de venta debe seguir el formato 25-XXXXXX (25- seguido de 6 dígitos).');
                numeroVenta.focus();
                return false;
            }
        }
    });

    // Auto-close success message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert.alert-success');
        if (successAlert) {
            setTimeout(function() {
                const alert = new bootstrap.Alert(successAlert);
                alert.close();
            }, 5000); // 5 seconds
        }
    });
</script>
<style>
    .btn-focus-animation {
        transition: box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-focus-animation:focus {
        box-shadow: 0 0 0 0.5rem rgba(13, 110, 253, 0.25), 0 0 15px rgba(13, 110, 253, 0.5) !important;
        outline: none;
    }

    .btn-focus-animation:hover {
        box-shadow: 0 0 0 0.5rem rgba(13, 110, 253, 0.25), 0 0 15px rgba(13, 110, 253, 0.5);
    }

    .btn-focus-animation:active {
        box-shadow: 0 0 0 0.5rem rgba(13, 110, 253, 0.25), 0 0 8px rgba(13, 110, 253, 0.7) !important;
    }
</style>
