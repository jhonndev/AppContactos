<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactosTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'apellidos' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'correo' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('telefono');
        $this->forge->addUniqueKey('correo');
        $this->forge->createTable('contactos');
    }

    public function down()
    {
        $this->forge->dropTable('contactos');
    }
}
