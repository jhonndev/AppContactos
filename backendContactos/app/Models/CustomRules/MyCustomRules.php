<?php

namespace App\Models\CustomRules;

use App\Models\ContactoModel;

class MyCustomRules
{       
    public function validarCorreoUnico(string $email, string $fields, array $data): bool
    {
        $contactModel = new ContactoModel();
        $contact = $contactModel->where('id', $data['id'])->first();
    
        if ($contact && $contact['correo'] === $email) {
            return true; // El correo electrónico no se modificó, es válido
        }
    
        return $contactModel->where('correo', $email)->countAllResults() === 0;
    }

    public function validarTelefonoUnico(string $telefono, string $fields, array $data): bool
    {
        $contactModel = new ContactoModel();
        $contact = $contactModel->where('id', $data['id'])->first();

        //var_dump($contact['telefono']);
    
        if ($contact && $contact['telefono'] === $telefono) {
            return true; // El correo electrónico no se modificó, es válido
        }
    
        return $contactModel->where('telefono', $telefono)->countAllResults() === 0;
    }
}