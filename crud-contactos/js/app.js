// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const contactForm = document.getElementById('contactForm');
    const contactList = document.getElementById('contactList');
    const submitBtn = document.getElementById('submitBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const loadingIndicator = document.getElementById('loading');

    // Variable para controlar el modo (crear o editar)
    let editMode = false;

    // Cargar contactos al iniciar
    cargarContactos();

    // Event Listener para el formulario
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Mostrar indicador de carga
        toggleLoading(true);

        // Preparar datos del formulario
        const contactData = {
            nombre: document.getElementById('nombre').value,
            email: document.getElementById('email').value,
            telefono: document.getElementById('telefono').value
        };

        if (editMode) {
            // Modo actualización
            contactData.id = document.getElementById('contactId').value;
            actualizarContacto(contactData);
        } else {
            // Modo creación
            crearContacto(contactData);
        }
    });

    // Event Listener para el botón cancelar
    cancelBtn.addEventListener('click', function() {
        resetForm();
    });

    // Función para cargar la lista de contactos
    function cargarContactos() {
        toggleLoading(true);

        fetch('api/read.php')
        .then(response => response.json())
        .then(data => {
            toggleLoading(false);

            if (data.status === 'success') {
                renderizarContactos(data.data);
            } else {
                mostrarMensaje('error', data.message || 'Error al cargar contactos');
            }
        })
        .catch(error => {
            toggleLoading(false);
            mostrarMensaje('error', 'Error de conexión al servidor');
            console.error('Error:', error);
        });
    }

    // Función para crear un nuevo contacto
    function crearContacto(contactData) {
        fetch('api/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(contactData)
        })
        .then(response => response.json())
        .then(data => {
            toggleLoading(false);

            if (data.status === 'success') {
                mostrarMensaje('success', data.message);
                resetForm();
                cargarContactos();
            } else {
                mostrarMensaje('error', data.message);
            }
        })
        .catch(error => {
            toggleLoading(false);
            mostrarMensaje('error', 'Error al conectar con el servidor');
            console.error('Error:', error);
        });
    }

    // Función para actualizar un contacto existente
    function actualizarContacto(contactData) {
        fetch('api/update.php?_method=PUT', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(contactData)
        })
        .then(response => response.json())
        .then(data => {
            toggleLoading(false);

            if (data.status === 'success') {
                mostrarMensaje('success', data.message);
                resetForm();
                cargarContactos();
            } else {
                mostrarMensaje('error', data.message);
            }
        })
        .catch(error => {
            toggleLoading(false);
            mostrarMensaje('error', 'Error al conectar con el servidor');
            console.error('Error:', error);
        });
    }

    // Función para eliminar un contacto
    function eliminarContacto(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este contacto?')) {
            toggleLoading(true);
            fetch('api/delete.php?_method=DELETE', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                toggleLoading(false);

                if (data.status === 'success') {
                    mostrarMensaje('success', data.message);
                    cargarContactos();
                } else {
                    mostrarMensaje('error', data.message);
                }
            })
            .catch(error => {
                toggleLoading(false);
                mostrarMensaje('error', 'Error al conectar con el servidor');
                console.error('Error:', error);
            });
        }
    }

    // Función para renderizar la lista de contactos
    function renderizarContactos(contactos) {
        contactList.innerHTML = '';

        if (!contactos || contactos.length === 0) {
            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = '<td colspan="6" class="text-center">No hay contactos</td>';
            contactList.appendChild(emptyRow);
            return;
        }

        contactos.forEach(contacto => {
            const row = document.createElement('tr');

            // Formatear fecha
            const fecha = new Date(contacto.fecha_registro);
            const fechaFormateada = fecha.toLocaleDateString() + ' ' + fecha.toLocaleTimeString();

            row.innerHTML = `
            <td>${contacto.id}</td>
            <td>${contacto.nombre}</td>
            <td>${contacto.email}</td>
            <td>${contacto.telefono}</td>
            <td>${fechaFormateada}</td>
            <td>
            <button class="btn btn-sm btn-info btn-action edit-btn" data-id="${contacto.id}">Editar</button>
            <button class="btn btn-sm btn-danger btn-action delete-btn" data-id="${contacto.id}">Eliminar</button>
            </td>
            `;
            contactList.appendChild(row);
        });

        // Agregar event listeners a los botones de acción
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const contactId = this.getAttribute('data-id');
                cargarContactoParaEditar(contactId, contactos);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const contactId = this.getAttribute('data-id');
                eliminarContacto(contactId);
            });
        });
    }

    // Función para cargar datos de un contacto en el formulario para edición
    function cargarContactoParaEditar(id, contactos) {
        const contacto = contactos.find(c => c.id == id);

        if (contacto) {
            document.getElementById('contactId').value = contacto.id;
            document.getElementById('nombre').value = contacto.nombre;
            document.getElementById('email').value = contacto.email;
            document.getElementById('telefono').value = contacto.telefono || '';

            // Cambiar a modo edición
            editMode = true;
            submitBtn.textContent = 'Actualizar contacto';
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-primary');
            cancelBtn.classList.remove('d-none');
            contactForm.classList.add('edit-mode');

            // Desplazarse al formulario
            contactForm.scrollIntoView({ behavior: 'smooth'});
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        contactForm.reset();
        document.getElementById('contactId').value = '';
        editMode = false;
        submitBtn.textContent = 'Crear contacto';
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-success');
        cancelBtn.classList.add('d-none');
        contactForm.classList.remove('edit-mode');
    }

    // Función para mostrar/ocultar indicador de carga
    function toggleLoading(show) {
        loadingIndicator.classList.toggle('d-none', !show);
        submitBtn.disabled = show;
    }

    // Función para mostrar mensajes al usuario
    function mostrarMensaje(tipo, mensaje) {
        alert(`${tipo === 'success' ? '✓' : 'X'} ${mensaje}`);
    }
});