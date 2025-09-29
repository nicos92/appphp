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
    <?php if (isset($success) && $success === 'entity_created'): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>¡Tarima registrada correctamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
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
                <p class="text-muted mb-4">Complete los campos siguientes para registrar una nueva tarima en el sistema</p>
                
                <form method="POST" action="<?= BASE_URL ?>/tarimas/guardar">
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        <input type="number" class="form-control" id="codigoBarras" name="codigoBarras" placeholder="Código de Barras" required step="1" oninput="limitLength(this, 30)">
                        <div class="invalid-feedback">
                            El código de barras es requerido y debe tener máximo 30 dígitos.
                        </div>
                    </div>
                    
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                        <input type="number" class="form-control" id="numeroTarima" name="numeroTarima" placeholder="Número de Tarima" required step="1" oninput="limitLength(this, 6)">
                        <div class="invalid-feedback">
                            El número de tarima es requerido y debe tener máximo 6 dígitos.
                        </div>
                    </div>
                    
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="number" class="form-control" id="numeroUsuario" name="numeroUsuario" placeholder="Número de Usuario" required step="1" oninput="limitLength(this, 2)">
                        <div class="invalid-feedback">
                            El número de usuario es requerido y debe tener máximo 2 dígitos.
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                <input type="number" class="form-control" id="cantidadCajas" name="cantidadCajas" placeholder="Cantidad de Cajas" required min="1" max="999" step="1" oninput="limitLength(this, 3)">
                                <div class="invalid-feedback">
                                    La cantidad debe ser entre 1 y 999.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                <input type="number" class="form-control" id="peso" name="peso" placeholder="Peso (kg)" min="0" max="9999.99" step="0.01">
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
                                <input type="text" class="form-control" id="numeroVenta" name="numeroVenta" placeholder="25-XXXXXX" required pattern="25-\d{6}">
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
                        <div>
                            <a href="<?= BASE_URL ?>/tarimas" class="btn btn-outline-info me-2">
                                <i class="fas fa-list me-2"></i>Ver Tarimas
                            </a>
                            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                            </a>
                        </div>
                        <button type="submit" class="btn btn-submit btn-lg">
                            <i class="fas fa-save me-2"></i>Guardar Tarima
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function limitLength(input, maxLength) {
        // Get the value as a string
        let value = input.value.toString();
        
        // For number inputs, only allow digits
        value = value.replace(/[^0-9]/g, '');
        
        // For number inputs, check against max value instead of length
        if (input.id === 'numeroTarima' && value.length > maxLength) {
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
        }
        
        // Set the value back to the input
        input.value = value;
    }
    
    // Specific function for barcode formatting
    function formatBarcode(input) {
        let value = input.value.toString();
        // Only allow digits
        value = value.replace(/[^0-9]/g, '');
        
        // Enforce the specific format: 0999999xxxxxx9998xxxxxxxxxxxxx
        // This format seems to suggest a specific structure:
        // 0 + 999999 (fixed) + 6 variable digits + 9998 (fixed) + 13 variable digits = 30 total
        if (value.length > 30) {
            value = value.substring(0, 30);
        }
        
        // Ensure the fixed parts are correct
        if (value.length >= 7) {
            // Ensure positions 0-6 are "0999999"
            value = "0999999" + value.substring(7);
        }
        
        if (value.length >= 13) {
            // Ensure positions 7-12 are user-entered, then position 13-16 is "9998"
            if (value.substring(13, 17) !== "9998") {
                value = value.substring(0, 13) + "9998" + value.substring(17);
            }
        }
        
        input.value = value;
    }
    
    // Add event listeners to number inputs to enforce length limits
    document.getElementById('codigoBarras').addEventListener('input', function() {
        formatBarcode(this);
    });
    
    // Also validate on form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const codigoBarras = document.getElementById('codigoBarras').value;
        const numeroTarima = document.getElementById('numeroTarima').value;
        const numeroUsuario = document.getElementById('numeroUsuario').value;
        const cantidadCajas = document.getElementById('cantidadCajas').value;
        const peso = document.getElementById('peso').value;
        const numeroVenta = document.getElementById('numeroVenta').value;
        
        if (codigoBarras.length > 30) {
            e.preventDefault();
            alert('El código de barras no puede tener más de 30 dígitos.');
            document.getElementById('codigoBarras').focus();
            return false;
        }
        
        if (numeroTarima.length > 6) {
            e.preventDefault();
            alert('El número de tarima no puede tener más de 6 dígitos.');
            document.getElementById('numeroTarima').focus();
            return false;
        }
        
        if (numeroUsuario.length > 2) {
            e.preventDefault();
            alert('El número de usuario no puede tener más de 2 dígitos.');
            document.getElementById('numeroUsuario').focus();
            return false;
        }
        
        if (cantidadCajas.length > 3) {
            e.preventDefault();
            alert('La cantidad de cajas no puede tener más de 3 dígitos.');
            document.getElementById('cantidadCajas').focus();
            return false;
        }
        
        const pesoFloat = parseFloat(peso);
        if (pesoFloat > 9999.99) {
            e.preventDefault();
            alert('El peso no puede ser mayor a 9999.99.');
            document.getElementById('peso').focus();
            return false;
        }
        
        // Validate venta number format
        const ventaRegex = /^25-\d{6}$/;
        if (!ventaRegex.test(numeroVenta)) {
            e.preventDefault();
            alert('El número de venta debe seguir el formato 25-XXXXXX (25- seguido de 6 dígitos).');
            document.getElementById('numeroVenta').focus();
            return false;
        }
    });
    
    // Focus on barcode input when success message is shown
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'entity_created') {
            // Clear the URL parameter to avoid focus on refresh
            const cleanUrl = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, cleanUrl);
            
            // Focus on the barcode input after a short delay to allow UI to update
            setTimeout(function() {
                document.getElementById('codigoBarras').focus();
            }, 100);
        }
    });
    
    // When barcode reaches 30 characters, fill other fields with non-fixed parts
    document.getElementById('codigoBarras').addEventListener('input', function() {
        const value = this.value.toString();
        
        if (value.length === 30) {
            // Extract the variable parts:
            // Positions 7-12 (6 digits) for user input after "0999999"
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
            
            // For numeroVenta: use positions 8-9 of userPart2 (positions 25-26 of barcode) with format 25-XXXXXX
            const ventaPart = userPart2.substring(8, 10);
            document.getElementById('numeroVenta').value = "25-" + ventaPart.padEnd(6, '0');
            
            // Set focus to numeroVenta field
            document.getElementById('numeroVenta').focus();
        }
    });
</script>
