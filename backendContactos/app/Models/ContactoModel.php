<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table = 'contactos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'apellidos', 'telefono', 'correo', 'foto'];

    // Configracion de API

    protected $returnType = 'array';
}
