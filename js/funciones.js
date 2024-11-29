

/*----------------------------------------------
LOGIN
-----------------------------------------------*/
        function loginUsuario() {
            const nombreUsuario = document.getElementById('nombre_usuario').value;
            const email = document.getElementById('email').value;
            const contrasena = document.getElementById('contrasena').value;

            if ((nombreUsuario === "" && email === "") || contrasena === "") {
                alert("Por favor, completa todos los campos.");
                return;
            }

            // Formato de datos en JSON
            const datosUsuario = {
                nombre_usuario: nombreUsuario,
                email: email,
                contrasena: contrasena
            };

            // Verificar que el JSON sea válido
            try {
                JSON.stringify(datosUsuario);
            } catch (error) {
                alert('Error en la formación del JSON: ' + error.message);
                return;
            }

            // Realizar la solicitud POST
            fetch('./index.php?action=login', {
                method: 'POST',
				mode: 'no-cors',				
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosUsuario)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Inicio de sesión exitoso.") {
                    alert(data.message);
                    // Redirigir o realizar alguna acción post-login
                    window.location.href = 'dashboard.html'; // Cambiar 'dashboard.html' a la URL de la página de destino que corresponda					
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al iniciar sesión.');
            });
        }
/*----------------------------------------------
REGISTRARSE
-----------------------------------------------*/		

        function registrarUsuario() {
            const nombreUsuario = document.getElementById('nombre_usuario').value;
            const email = document.getElementById('email').value;
            const contrasena = document.getElementById('contrasena').value;
            const confirmarContrasena = document.getElementById('confirmar_contrasena').value;

            if (nombreUsuario === "" || email === "" || contrasena === "" || confirmarContrasena === "") {
                alert("Por favor, completa todos los campos.");
                return;
            }

            if (contrasena !== confirmarContrasena) {
                alert("Las contraseñas no coinciden.");
                return;
            }

			// Formato de datos en JSON
            const datosUsuario = {
                nombre_usuario: nombreUsuario,
                email: email,
                contrasena: contrasena
            };

            // Verificar que el JSON sea válido
            try {
                JSON.stringify(datosUsuario);
            } catch (error) {
                alert('Error en la formación del JSON: ' + error.message);
                return;
            }

            // Realizar la solicitud POST
            fetch('./index.php', {
                method: 'POST',
				mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosUsuario)
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.message);
                } else {
                    alert('Usuario registrado con éxito');
					//alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al registrar el usuario.');
            });
        }
/*----------------------------------------------
Agregar Artista
-----------------------------------------------*/

function agregarArtista() {
    const nombre = document.getElementById('nombre').value;
    const genero = document.getElementById('genero').value;

    fetch('./controllers/ArtistaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ Nombre: nombre, Genero_Musical: genero }),
    })
        .then((response) => response.text()) // Cambiado a `text` temporalmente
        .then((text) => {
            console.log('Respuesta del servidor:', text); // Muestra la respuesta cruda
            try {
                const data = JSON.parse(text); // Intenta parsear el JSON
                alert(data.message);
            } catch (error) {
                console.error('Error al parsear JSON:', error);
                alert('La respuesta del servidor no es válida.');
            }
        })
        .catch((error) => console.error('Error:', error));
}




/*----------------------------------------------
-----
-----------------------------------------------*/			