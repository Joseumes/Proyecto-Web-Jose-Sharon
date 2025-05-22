
document.addEventListener('DOMContentLoaded', function() {
    const fechaIngreso = document.getElementById('fecha_ingreso');
    const fechaSalida = document.getElementById('fecha_salida');
    
    if (fechaIngreso && fechaSalida) {
    
        const hoy = new Date().toISOString().split('T')[0];
        fechaIngreso.min = hoy;
        
        
        
        fechaIngreso.addEventListener('change', function() {
            fechaSalida.min = this.value;
            
            
            if (fechaSalida.value && fechaSalida.value < this.value) {
                fechaSalida.value = '';
            }
        });
        
        
        fechaSalida.addEventListener('change', function() {
            if (fechaIngreso.value && this.value) {
                const ingreso = new Date(fechaIngreso.value);
                const salida = new Date(this.value);
                const diffTime = Math.abs(salida - ingreso);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                
                console.log(`Estadía de ${diffDays} días - Total: Q${diffDays * 350}`);
            }
        });
    }
    

    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    if (fechaNacimiento) {
        fechaNacimiento.addEventListener('change', function() {
            const nacimiento = new Date(this.value);
            const hoy = new Date();
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const mes = hoy.getMonth() - nacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }
            
            if (edad < 18) {
                alert('Lo sentimos, el hotel solo acepta huéspedes mayores de 18 años.');
                this.value = '';
            }
        });
    }
});


function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

document.addEventListener('DOMContentLoaded', initTooltips);