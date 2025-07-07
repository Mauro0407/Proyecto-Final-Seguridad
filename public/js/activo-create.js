document.addEventListener('DOMContentLoaded', function () {
    // Elementos del formulario
    const confidencialidad = document.getElementById('confidencialidad');
    const integridad = document.getElementById('integridad');
    const disponibilidad = document.getElementById('disponibilidad');
    const probabilidad = document.getElementById('probabilidad');
    const impacto = document.getElementById('impacto');

    // Elementos de resultados calculados
    const va = document.getElementById('va');
    const vaInterpretacion = document.getElementById('va_interpretacion');
    const vaAccion = document.getElementById('va_accion');
    const riesgo = document.getElementById('riesgo');
    const nivelRiesgo = document.getElementById('nivel_riesgo');
    const tratamiento = document.getElementById('tratamiento');

    // Formulario y botón de envío
    const form = document.getElementById('activoForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');

    /**
     * Calcula el Valor del Activo (VA) basado en confidencialidad, integridad y disponibilidad
     * @param {number} c - Valor de confidencialidad (1-5)
     * @param {number} i - Valor de integridad (1-5)
     * @param {number} d - Valor de disponibilidad (1-5)
     * @returns {Object} Objeto con VA, interpretación y acción recomendada
     */
    function calcularVA(c, i, d) {
        const valor = c + i + d;
        let interpretacion = 'Bajo';
        let accion = 'Revisión anual';

        if (valor > 6 && valor <= 10) {
            interpretacion = 'Medio';
            accion = 'Monitoreo periódico y controles básicos';
        } else if (valor > 10 && valor <= 12) {
            interpretacion = 'Alto';
            accion = 'Prioridad en análisis de riesgos';
        } else if (valor > 12) {
            interpretacion = 'Crítico';
            accion = 'Alta prioridad - Acción inmediata requerida';
        }
        return { va: valor, interpretacion, accion };
    }

    /**
     * Calcula el riesgo basado en probabilidad e impacto
     * @param {number} prob - Valor de probabilidad (1-5)
     * @param {number} imp - Valor de impacto (1-5)
     * @returns {Object} Objeto con nivel de riesgo, tratamiento y valor de riesgo
     */
    function calcularRiesgo(prob, imp) {
        const riesgoVal = prob * imp;
        let nivel = '';
        let tratamientoVal = '';
        let riskClass = '';

        if (riesgoVal <= 3) {
            nivel = 'Muy Bajo';
            tratamientoVal = 'Aceptar sin intervención';
            riskClass = 'risk-low';
        } else if (riesgoVal <= 6) {
            nivel = 'Bajo';
            tratamientoVal = 'Monitoreo básico';
            riskClass = 'risk-low';
        } else if (riesgoVal <= 9) {
            nivel = 'Medio';
            tratamientoVal = 'Monitoreo regular';
            riskClass = 'risk-medium';
        } else if (riesgoVal <= 12) {
            nivel = 'Medio-Alto';
            tratamientoVal = 'Tratar en mediano plazo';
            riskClass = 'risk-medium';
        } else if (riesgoVal <= 16) {
            nivel = 'Alto';
            tratamientoVal = 'Mitigar';
            riskClass = 'risk-high';
        } else if (riesgoVal <= 20) {
            nivel = 'Muy Alto';
            tratamientoVal = 'Intervención urgente';
            riskClass = 'risk-high';
        } else if (riesgoVal <= 24) {
            nivel = 'Crítico';
            tratamientoVal = 'Intervención urgente';
            riskClass = 'risk-critical';
        } else {
            nivel = 'Extremo';
            tratamientoVal = 'Medidas extremas';
            riskClass = 'risk-critical';
        }

        return { nivel, tratamiento: tratamientoVal, riesgo: riesgoVal, riskClass };
    }

    /**
     * Actualiza todos los campos calculados basados en los valores actuales
     */
    function updateCalculations() {
        const c = parseInt(confidencialidad.value) || 0;
        const i = parseInt(integridad.value) || 0;
        const d = parseInt(disponibilidad.value) || 0;
        const prob = parseInt(probabilidad.value) || 0;
        const imp = parseInt(impacto.value) || 0;

        // Calcular VA y actualizar inputs
        const vaCalc = calcularVA(c, i, d);
        va.value = vaCalc.va;
        vaInterpretacion.value = vaCalc.interpretacion;
        vaAccion.value = vaCalc.accion;

        // Calcular Riesgo y actualizar inputs
        const riesgoCalc = calcularRiesgo(prob, imp);
        riesgo.value = riesgoCalc.riesgo;
        nivelRiesgo.value = riesgoCalc.nivel;
        tratamiento.value = riesgoCalc.tratamiento;

        // Aplicar clase de riesgo al elemento nivelRiesgo
        nivelRiesgo.className = 'form-control calculated-value risk-indicator ' + riesgoCalc.riskClass;
    }

    // Event listeners para campos editables
    [confidencialidad, integridad, disponibilidad, probabilidad, impacto].forEach(input => {
        input.addEventListener('input', updateCalculations);
        input.addEventListener('change', updateCalculations);
    });

    // Manejo del envío del formulario
    if (form) {
        form.addEventListener('submit', function (e) {
            // Validación adicional antes de enviar
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Mostrar mensaje de error si es necesario
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger mt-3 fade-in';
                errorAlert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Por favor complete todos los campos requeridos.';
                form.insertBefore(errorAlert, form.firstChild);
                
                // Desplazarse al primer campo con error
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                submitBtn.disabled = true;
                loadingSpinner.classList.remove('d-none');
                submitBtn.querySelector('i').classList.add('d-none');
            }
        });
    }

    // Inicializar cálculos al cargar la página
    updateCalculations();

    // Tooltips para campos importantes
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Validación en tiempo real para campos numéricos
    const numericFields = [confidencialidad, integridad, disponibilidad, probabilidad, impacto];
    numericFields.forEach(field => {
        field.addEventListener('blur', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 5;

            if (isNaN(value) || value < min || value > max) {
                this.classList.add('is-invalid');
                const feedback = this.nextElementSibling;
                if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                    const div = document.createElement('div');
                    div.className = 'invalid-feedback';
                    div.textContent = `Por favor ingrese un valor entre ${min} y ${max}`;
                    this.parentNode.appendChild(div);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        });
    });
});