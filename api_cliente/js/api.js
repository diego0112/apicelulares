async function buscarCelulares() {
    const search = document.getElementById('search').value;
    const token = document.getElementById('token').value;
    const resultadosDiv = document.getElementById('resultados');

    if (!search.trim()) {
        alert('Ingrese un IMEI, Número de Serie o Modelo para buscar.');
        return;
    }

    resultadosDiv.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Buscando celulares...</div>';

    try {
        const formData = new FormData();
        formData.append('token', token);
        formData.append('search', search);

        const response = await fetch('api_handler.php?action=buscarCelulares', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!data.status) {
            resultadosDiv.innerHTML = `<div class="error"><i class="fas fa-exclamation-triangle"></i> ${data.msg}</div>`;
            return;
        }

        if (data.data.length === 0) {
            resultadosDiv.innerHTML = '<div class="no-results"><i class="fas fa-info-circle"></i> No se encontraron celulares.</div>';
            return;
        }

        let html = '';
        data.data.forEach(celular => {
            html += `
                <div class="celular-card">
                    <div class="celular-header">
                        <div class="celular-icon"><i class="fas fa-mobile-alt"></i></div>
                        <div>
                            <h3 class="celular-marca">${celular.marca}</h3>
                            <p class="celular-modelo">${celular.modelo}</p>
                        </div>
                    </div>
                    <div class="celular-info">
                        <p><i class="fas fa-barcode"></i> IMEI: ${celular.imei}</p>
                        <p><i class="fas fa-tag"></i> Serie: ${celular.numero_serie}</p>
                        <p><i class="fas fa-microchip"></i> Procesador: ${celular.procesador || 'No especificado'}</p>
                        <p><i class="fas fa-tv"></i> Pantalla: ${celular.pantalla || 'No especificado'}</p>
                        <p><i class="fas fa-camera"></i> Cámara: ${celular.camara_principal_mpx} MP</p>
                        <p><i class="fas fa-battery-full"></i> Batería: ${celular.bateria_mah} mAh</p>
                        <p><i class="fas fa-memory"></i> RAM: ${celular.ram_gb} GB</p>
                        <p><i class="fas fa-hdd"></i> Almacenamiento: ${celular.almacenamiento_gb} GB</p>
                        <p><i class="fas fa-dollar-sign"></i> Precio: $${celular.precio_usd}</p>
                    </div>
                </div>
            `;
        });

        resultadosDiv.innerHTML = html;

    } catch (error) {
        console.error('Error:', error);
        resultadosDiv.innerHTML = '<div class="error"><i class="fas fa-exclamation-triangle"></i> Ocurrió un error al buscar los celulares.</div>';
    }
}
