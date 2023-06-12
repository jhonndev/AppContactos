<?php

// override core en language system validation or define your own en language validation message
return [
    'required'      => 'El campo {field} es obligatorio.',
    'min_length'    => 'El campo {field} no es válido.',
    'max_length'    => 'El campo {field} supera el limite permitido [{param}].',
    'valid_email'   => 'El campo {field} debe ser una dirección de correo válida.',
    'numeric'       => 'El campo {field} debe contener solo numeros.',
    'is_unique'     => 'Ya existe un contacto con ese {field}',
    'is_image'      => 'Solo se aceptan imagenes con formato .JPG',
    'max_size'      => 'El tamaño de la imagen es superior al permitido',
    'ext_in'        => 'El formato de la imagen debe ser JPG',
    'uploaded'      => 'No se ha seleccionado ninguna foto',
    'validarCorreoUnico'  => 'Ya existe un contacto con ese {field}',
    'validarTelefonoUnico' => 'Ya existe un contacto con ese {field}',
    // Agrega más mensajes de error personalizados según sea necesario
];
