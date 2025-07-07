document.addEventListener('DOMContentLoaded', function () {
    const confidencialidad = document.getElementById('confidencialidad');
    const integridad = document.getElementById('integridad');
    const disponibilidad = document.getElementById('disponibilidad');
    const probabilidad = document.getElementById('probabilidad');
    const impacto = document.getElementById('impacto');

    const va = document.getElementById('va');
    const riesgo = document.getElementById('riesgo');
    const nivelRiesgo = document.getElementById('nivel_riesgo');
    const tratamiento = document.getElementById('tratamiento');

    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');

    function updateCalculations() {
        const c = parseInt(confidencialidad.value) || 0;
        const i = parseInt(integridad.value) || 0;
        const d = parseInt(disponibilidad.value) || 0;
        const vaValue = c + i + d;
        va.value = vaValue;

        const p = parseInt(probabilidad.value) || 0;
        const imp = parseInt(impacto.value) || 0;
        const riesgoValue = p * imp;
        riesgo.value = riesgoValue;

        let nivel = '';
        let tratamientoValue = '';

        if (riesgoValue >= 1 && riesgoValue <= 4) {
            nivel = 'Muy Bajo';
            tratamientoValue = 'Aceptar sin intervención';
        } else if (riesgoValue >= 5 && riesgoValue <= 8) {
            nivel = 'Bajo';
            tratamientoValue = 'Monitoreo básico';
        } else if (riesgoValue >= 9 && riesgoValue <= 12) {
            nivel = 'Moderado';
            tratamientoValue = 'Tratar en mediano plazo';
        } else if (riesgoValue >= 13 && riesgoValue <= 19) {
            nivel = 'Alto';
            tratamientoValue = 'Mitigar';
        } else if (riesgoValue >= 20 && riesgoValue <= 25) {
            nivel = 'Crítico';
            tratamientoValue = 'Intervención urgente';
        } else {
            nivel = '-';
            tratamientoValue = '';
        }

        nivelRiesgo.value = nivel;
        tratamiento.value = tratamientoValue;
    }

    [confidencialidad, integridad, disponibilidad, probabilidad, impacto].forEach(input => {
        input.addEventListener('input', updateCalculations);
    });

    updateCalculations();

    // Añadir spinner y deshabilitar botón al enviar el formulario
    const form = document.getElementById('activoForm');
    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        loadingSpinner.classList.remove('d-none');
    });
});
