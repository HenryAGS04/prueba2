// Referencia al contenedor del menú lateral
const sidebar = document.getElementById('sidebar');

// Lista de entidades
const entities = [
    "artista", "auditoria", "permisos", "rol_permiso", "roles", 
    "sesiones", "usuario_rol", "usuarios", "concierto", 
    "escala_tecnica", "local", "programa_concierto", 
    "realizacion_escala"
];

// Generar elementos del menú
entities.forEach(entity => {
    const menuItem = document.createElement('div');
    menuItem.className = 'menu-item';
    menuItem.innerText = entity.charAt(0).toUpperCase() + entity.slice(1);
    menuItem.onclick = toggleMenu;

    const subMenu = document.createElement('div');
    subMenu.className = 'sub-menu';
    subMenu.innerHTML = `
        <a href="#" onclick="showContent('views/listar_${entity}.html')">Listar ${entity.charAt(0).toUpperCase() + entity.slice(1)}</a>
        <a href="#" onclick="showContent('views/agregar_${entity}.html')">Agregar ${entity.charAt(0).toUpperCase() + entity.slice(1)}</a>
    `;

    menuItem.appendChild(subMenu);
    sidebar.appendChild(menuItem);
});

// Función para alternar la visualización del submenú
function toggleMenu(event) {
    const items = document.querySelectorAll('.sub-menu');
    items.forEach(item => {
        item.style.display = 'none';
    });

    const subMenu = event.currentTarget.querySelector('.sub-menu');
    subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
}

// Mostrar contenido en el área principal
function showContent(filePath) {
    fetch(filePath)
        .then(response => response.text())
        .then(content => {
            document.getElementById('main-content').innerHTML = content;
        })
        .catch(error => {
            console.error('Error al cargar el contenido:', error);
            document.getElementById('main-content').innerHTML = '<p>Error al cargar la página.</p>';
        });
}

// Función de cierre de sesión (placeholder)
function logout() {
    alert("Cerrando sesión...");
}
