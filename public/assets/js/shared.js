/**
 * Shared JavaScript functions for the application
 */

/**
 * Limits the length of input and applies validation
 * @param {HTMLInputElement} input - The input element
 * @param {number} maxLength - The maximum length allowed
 */
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

// Auto-close success message after 5 seconds
function autoCloseAlerts() {
    const successAlert = document.querySelector('.alert.alert-success');
    if (successAlert) {
        setTimeout(function() {
            const alert = new bootstrap.Alert(successAlert);
            alert.close();
        }, 5000); // 5 seconds
    }
}

// Initialize auto-close alerts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    autoCloseAlerts();
});