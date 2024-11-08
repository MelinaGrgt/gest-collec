<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableLikes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'auto_increment'=> true
            ],
            'id_user'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> false
            ],
            'id_comment'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> false
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user','TableUser','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_comment', 'comment', 'id','CASCADE','CASCADE');
        $this->forge->addUniqueKey('id_user', 'id_comment');
        $this->forge->createTable('likes');
    }

    public function down()
    {
        $this->forge->dropTable('likes');
    }
}
