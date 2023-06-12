$(document).ready(function() {
    // Cargar los contactos al cargar la página
    cargarContactos();

    // Agregar evento al cerrar el modal de edición para limpiar los campos
    $('#editarModal').on('hidden.bs.modal', function() {
        limpiarCamposEditar();
    });

    // Limpiar el formulario al cerrar el modal
    $(".btn-closeCrear").click(function() {
        $("#crearContactoForm")[0].reset();
        var $errorContainer = $('.error-crear');
        $errorContainer.html("");

    });

    $(".btn-closeEditar").click(function() {
        var $errorContainer = $('.error-editar');
        $errorContainer.html("");
    });

    $('.eliminarBtn').on('click', function() {
        const id = $('#editarId').val();
        // Confirmar la eliminación del contacto
        if (confirm('¿Estás seguro de eliminar este contacto?')) {
            // Realizar la solicitud AJAX para eliminar el contacto
            $.ajax({
                url: 'http://localhost:8080/api/contactos/delete/' + id,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    $('#editarModal').modal('hide');
                    cargarContactos();
                    mostrarAlertas(response.messages.success);
                },
                error: function(xhr, status, error) {
                    // Mostrar un mensaje de error en caso de fallo
                    alert('Error al eliminar el contacto.');
                    console.log(xhr.responseText);
                }
            });
        }
    });

    // Manejar el envío del formulario para crear un nuevo contacto
    $('#crearContactoForm').submit(function(e) {
        e.preventDefault();

        var nombre = $('#nombre').val();
        var apellidos = $('#apellidos').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();

        // Crear el objeto de datos en formato JSON
        var datos = {
            nombre: nombre,
            apellidos: apellidos,
            telefono: telefono,
            correo: correo
        };

        // Realizar la solicitud AJAX para crear un nuevo contacto
        $.ajax({
            url: 'http://localhost:8080/api/contactos/create',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json', // Especificar el tipo de contenido como JSON
            data: JSON.stringify(datos), // Convertir el objeto de datos a JSON
            success: function(response) {
                $('#crearModal').modal('hide');
                $('#crearContactoForm')[0].reset();       
                mostrarAlertas(response.messages.success);       
                cargarContactos();
            },
            error: function(xhr, status, error) {
                var mensajes = xhr.responseJSON.messages.error;
                var $errorContainer = $('.error-crear');
                $errorContainer.html(mensajes);
                
            }
        });
    });

    // Función para cargar los contactos desde la API
    function cargarContactos() {
        var $errorContainer = $('.error-crear');
        $errorContainer.html("");

        $.ajax({
            url: 'http://localhost:8080/api/contactos',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const contactosLista = $('#contactosLista');
                contactosLista.empty();

                //const encabezado = $('<li class="list-group-item active d-flex justify-content-between">Listado de contactos <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearModal">Crear Contacto</button></li>');
                const encabezado = $('<li class="list-group-item color-text d-flex justify-content-between align-items-center"><div class="text-end"><h4>Contactos</h4></div><div class="text-start"><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#crearModal"><i class="bi bi-person-plus-fill text-primary fs-1"></i></button></div></li>');
            // Agregar el encabezado al list-group
            contactosLista.append(encabezado);

                // Recorrer los contactos obtenidos y agregarlos al listado
                response.forEach(function(contacto) {
                    // Crear el elemento de la lista
                    const item = $('<a href="#" class="list-group-item list-group-item-action"></a>');
                    item.text(contacto.nombre);
                    item.data('id', contacto.id);
                    item.data('nombre', contacto.nombre);
                    item.data('apellidos', contacto.apellidos);
                    item.data('telefono', contacto.telefono);
                    item.data('correo', contacto.correo);

                    // Agregar eventos para abrir el modal de editar y eliminar
                    item.on('click', function() {
                        // Obtener los datos del contacto seleccionado
                        const id = $(this).data('id');
                        const nombre = $(this).data('nombre');
                        const apellidos = $(this).data('apellidos');
                        const telefono = $(this).data('telefono');
                        const correo = $(this).data('correo');

                        // Establecer los valores en el formulario de edición
                        $('#editarId').val(id);
                        $('#editarNombre').val(nombre);
                        $('#editarApellidos').val(apellidos);
                        $('#editarTelefono').val(telefono);
                        $('#editarCorreo').val(correo);

                        // Abrir el modal de edición
                        $('#editarModal').modal('show');
                    });

                    // Agregar el elemento al listado
                    contactosLista.append(item);
                });
            },
            error: function(xhr, status, error) {
                // Mostrar un mensaje de error en caso de fallo
                alert('Error al cargar los contactos.');
                console.log(xhr.responseText);
            }
        });
    }
    
    // Manejar el envío del formulario para editar un contacto
    $('#editarContactoForm').submit(function(e) {
        e.preventDefault();

        var id = $('#editarId').val();
        var nombre = $('#editarNombre').val();
        var apellidos = $('#editarApellidos').val();
        var telefono = $('#editarTelefono').val();
        var correo = $('#editarCorreo').val();

        // Crear el objeto de datos en formato JSON
        var datos = {
            id: id,
            nombre: nombre,
            apellidos: apellidos,
            telefono: telefono,
            correo: correo
        };

        // Realizar la solicitud AJAX para editar el contacto
        $.ajax({
            url: 'http://localhost:8080/api/contactos/update/' + id,
            type: 'PUT',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function(response) {
                // Mostrar un mensaje de éxito y recargar la tabla de contactos
                cargarContactos();
                mostrarAlertas(response.messages.success);
                $('#editarModal').modal('hide');
            },
            error: function(xhr, status, error) {
                var mensajes = xhr.responseJSON.messages.error;
                var $errorContainer = $('.error-editar');
                $errorContainer.html(mensajes);
            }
        });
    });

    $('#contactosTable').on('click', '.btn-editar', function() {
        var id = $(this).data('id');

        var $errorContainer = $('.error-editar');
        $errorContainer.html("");
    
        // Realizar petición GET al servidor para obtener los datos del contacto
        $.ajax({
            url: 'http://localhost:8080/api/contactos/edit/' + id,  // Ruta de la API para obtener un contacto por su ID
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Obtener los datos del contacto desde la respuesta de la API
                var contacto = response;
    
                // Establecer los valores en el formulario de edición
                $('#editarId').val(contacto.id);
                $('#editarNombre').val(contacto.nombre);
                $('#editarApellidos').val(contacto.apellidos);
                $('#editarTelefono').val(contacto.telefono);
                $('#editarCorreo').val(contacto.correo);
    
                // Abrir el modal de edición
                $('#editarModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('Error al obtener los datos del contacto:', error);
            }
        });
    });   

    // Función para limpiar los campos del formulario de edición
    function limpiarCamposEditar() {
        $('#editarId').val('');
        $('#editarNombre').val('');
        $('#editarApellidos').val('');
        $('#editarTelefono').val('');
        $('#editarCorreo').val('');
    }

    // Mostrar alertas
    function mostrarAlertas(texto) {
        var mensajeHTML = '<div class="alert alert-success" role="alert">' + texto + '</div>';
        
        // Inserta el mensaje HTML en el contenedor
        $('#mensajeAlerta').html(mensajeHTML).fadeIn();
      
        // Establece un temporizador para ocultar el mensaje después de 3 segundos (3000 ms)
        setTimeout(function() {
          $('#mensajeAlerta').fadeOut();
        }, 5000);
    }
    
});
