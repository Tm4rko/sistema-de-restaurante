import './bootstrap';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: true
});

window.Echo.channel('pedidos')
    .subscribed(() => { 
        console.log('Suscrito al canal pedidos');
     })
    .listen('PedidoCreado', (e) => {
        console.log('Evento PedidoCreado recibido:', e); 
        // Actualizar el contador de pedidos nuevos
        let pedidosNuevosCount = document.getElementById('pedidosNuevosCount');
        if (pedidosNuevosCount) {
            pedidosNuevosCount.innerText = parseInt(pedidosNuevosCount.innerText) + 1;
        }
        // Actualizar la tabla de pedidos activos 
        actualizarTablaPedidos(e.pedido);
    });
    

function actualizarTablaPedidos(pedido) {
    const tbody = document.querySelector('#mitabla tbody');
    const tr = document.createElement('tr');

    tr.innerHTML = `
        <td style="text-align: center; vertical-align: middle;">${pedido.id}</td>
        <td style="vertical-align: middle;">${pedido.user.name}</td>
        <td style="vertical-align: middle;">${pedido.fechaPedido}</td>
        <td style="vertical-align: middle;">${pedido.procedencia}</td>
        <td style="text-align: center; vertical-align: middle;">${pedido.total}</td>
        <td style="vertical-align: middle;">${pedido.estado}</td>
        <td style="text-align: center; vertical-align: middle;"> 
        <div class="btn-group" role="group" aria-label="Basic example"> 
        <a href="${url('/admin/pedidos/' + pedido.id + '/edit')}" class="btn btn-success btn-sm">
        <i class="fas fa-pencil"></i>
        </a> 
        </div> 
        </td>
    `;
    tbody.appendChild(tr);
}

// Función para generar URL similar a Blade 
function url(path) { const baseUrl = window.location.origin + '/sistemarestaurante/public'; 
    // Ajusta la URL base según la estructura de tu aplicación 
    return `${baseUrl}${path}`; }