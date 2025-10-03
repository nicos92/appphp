<header class="form-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-warehouse me-2"></i>Nueva Tarima</h1>
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


    <?php if (isset($error) && $error === 'required_fields_missing'): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Los campos código de barras y número de tarima son obligatorios.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <h3 class="mb-4">Formulario de Nueva Tarima</h3>
                <?php if (isset($success) && $success === 'entity_created'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>¡Tarima registrada correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <p class="text-muted mb-4">Complete los campos siguientes para registrar una nueva tarima en el sistema</p>

                <form method="POST" action="<?= BASE_URL ?>/tarimas/guardar">
                    <div class="d-flex mb-2 justify-content-start">
                        <div>
                            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                            </a>
                            <a href="<?= BASE_URL ?>/tarimas" class="btn btn-outline-info me-2">
                                <i class="fas fa-list me-2"></i>Ver Tarimas
                            </a>
                        </div>

                    </div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        <input type="number" class="form-control" id="codigoBarras" name="codigoBarras" placeholder="Código de Barras" required step="1" oninput="limitLength(this, 30)">
                        <div class="invalid-feedback">
                            El código de barras es requerido y debe tener máximo 30 dígitos.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="number" class="form-control" id="numeroProducto" name="numeroProducto" placeholder="Número de Producto" required step="1" oninput="limitLength(this, 6)">
                                <div class="invalid-feedback">
                                    El número de producto es requerido y debe tener máximo 6 dígitos.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                <input type="number" class="form-control" id="numeroTarima" name="numeroTarima" placeholder="Número de Tarima" required step="1" oninput="limitLength(this, 6)">
                                <div class="invalid-feedback">
                                    El número de tarima es requerido y debe tener máximo 6 dígitos.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="number" class="form-control" id="numeroUsuario" name="numeroUsuario" placeholder="Número de Usuario" required step="1" oninput="limitLength(this, 2)">
                                <div class="invalid-feedback">
                                    El número de usuario es requerido y debe tener máximo 2 dígitos.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                <input type="number" class="form-control" id="cantidadCajas" name="cantidadCajas" placeholder="Cantidad de Cajas" required min="1" max="999" step="1" oninput="limitLength(this, 3)">
                                <div class="invalid-feedback">
                                    La cantidad debe ser entre 1 y 999.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                <input type="number" class="form-control" id="peso" name="peso" placeholder="Peso (kg)" min="0" max="9999.99" step="0.01" oninput="limitLength(this, 7)">
                                <div class="invalid-feedback">
                                    El peso debe ser entre 0 y 9999.99.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                <input type="text" class="form-control" id="numeroVenta" name="numeroVenta" placeholder="XX-XXXXXX" required pattern="25-\d{6}">
                                <div class="invalid-feedback">
                                    El número de venta debe seguir el formato 25-XXXXXX (25- seguido de 6 dígitos).
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción adicional de la tarima"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">

                        <button type="submit" class="btn btn-submit btn-lg btn-focus-animation">
                            <i class="fas fa-save me-2"></i>Guardar Tarima
                        </button>
                    </div>
                </form>
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
</script>
<script>
    // Add event listeners to number inputs to enforce length limits
    document.getElementById('codigoBarras').addEventListener('input', function() {
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

    // Add event listener to numeroVenta to enforce length limit
    document.getElementById('numeroVenta').addEventListener('input', function() {
        if (this.value.length > 9) {
            this.value = this.value.substring(0, 9);
        }
    });

    // Also validate on form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const codigoBarras = document.getElementById('codigoBarras');
        const codigoBarrasValue = codigoBarras ? codigoBarras.value : '';
        const numeroProducto = document.getElementById('numeroProducto');
        const numeroTarima = document.getElementById('numeroTarima');
        const numeroUsuario = document.getElementById('numeroUsuario');
        const cantidadCajas = document.getElementById('cantidadCajas');
        const peso = document.getElementById('peso');
        const numeroVenta = document.getElementById('numeroVenta');

        if (codigoBarrasValue.length > 30) {
            e.preventDefault();
            alert('El código de barras no puede tener más de 30 dígitos.');
            codigoBarras.focus();
            return false;
        }

        // Validate barcode structure (for 30 digit codes only)
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

        if (numeroProducto && numeroProducto.value.length > 6) {
            e.preventDefault();
            alert('El número de producto no puede tener más de 6 dígitos.');
            numeroProducto.focus();
            return false;
        }

        if (numeroTarima && numeroTarima.value.length > 6) {
            e.preventDefault();
            alert('El número de tarima no puede tener más de 6 dígitos.');
            numeroTarima.focus();
            return false;
        }

        if (numeroUsuario && numeroUsuario.value.length > 2) {
            e.preventDefault();
            alert('El número de usuario no puede tener más de 2 dígitos.');
            numeroUsuario.focus();
            return false;
        }

        if (cantidadCajas && cantidadCajas.value.length > 3) {
            e.preventDefault();
            alert('La cantidad de cajas no puede tener más de 3 dígitos.');
            cantidadCajas.focus();
            return false;
        }

        if (numeroVenta && numeroVenta.value.length > 9) {
            e.preventDefault();
            alert('El número de venta no puede tener más de 9 caracteres.');
            numeroVenta.focus();
            return false;
        }

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

    // Focus on barcode input when page loads or success message is shown
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);

        // Focus on the barcode input after a short delay to allow UI to update
        setTimeout(function() {
            document.getElementById('codigoBarras').focus();
        }, 100);
    });

    // When barcode reaches 30 characters, fill other fields with non-fixed parts
    document.getElementById('codigoBarras').addEventListener('input', function() {
        const value = this.value.toString();

        // Extract and fill the product number with digits 2-8 of the barcode
        if (value.length >= 8) {
            const numeroProducto = value.substring(1, 7); // positions 1-7 (digits 2-8)
            document.getElementById('numeroProducto').value = numeroProducto;
        }

        if (value.length === 30) {
            // Check if the barcode has the fixed parts
            if (value.charAt(0) !== '0') {
                alert('El código de barras debe iniciar con 0');
                return;
            }

            if (value.substring(13, 17) !== "9998") {
                alert('El código de barras no pertenece a una tarima');
                return;
            }

            // Extract the variable parts:
            // Positions 7-12 (6 digits) for user input after first 7 digits
            const userPart1 = value.substring(7, 13); // positions 7-12
            // Positions 17-29 (13 digits) for user input after "9998"
            const userPart2 = value.substring(17, 30); // positions 17-29

            // Fill other fields with parts of the barcode
            document.getElementById('numeroTarima').value = userPart1;

            // For numeroUsuario (2 digits max): use first 2 digits of userPart2
            document.getElementById('numeroUsuario').value = userPart2.substring(2, 4);

            // For cantidadCajas (3 digits max): use positions 4-6 of userPart2 (positions 21-23 of barcode)
            document.getElementById('cantidadCajas').value = userPart2.substring(4, 7);

            // For peso: use the last 6 digits of the barcode (positions 24-29), 4 for whole part and 2 for decimal
            const lastSixDigits = value.substring(24, 30); // positions 24-29 (last 6 digits)
            if (lastSixDigits.length === 6) {
                const wholePart = lastSixDigits.substring(0, 4); // first 4 digits
                const decimalPart = lastSixDigits.substring(4, 6); // last 2 digits
                document.getElementById('peso').value = wholePart + '.' + decimalPart;
            }

            // For numeroVenta: only set the current year (last 2 digits) with a dash, leave rest for user to enter
            const currentYear = new Date().getFullYear().toString().substr(-2);
            document.getElementById('numeroVenta').value = currentYear + "-";

            // Set focus to numeroVenta field
            document.getElementById('numeroVenta').focus();
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
