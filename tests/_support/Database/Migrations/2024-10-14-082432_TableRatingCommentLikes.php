<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableRatingCommentLikes extends Migration
{
    public function up()
    {
        //Création de la table rating
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
            'id_item'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> false
            ],
            'rating'=>[
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'null' => false,
                'check' => 'rating >= 0 AND rating <= 5'
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user','TableUser','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_item','item','id','CASCADE','CASCADE');
        $this->forge->createTable('rating');

        //Création de la table comments
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_comment_parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'entity_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'entity_type' => [
                'type' => 'ENUM',
                'constraint' => ['item','collection'],
                'default' => 'item',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user', 'TableUser', 'id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('id_comment_parent', 'comment', 'id','CASCADE','SET NULL');
        $this->forge->createTable('comment');

        // Creation de la table likes
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
        $this->forge->createTable('likes');
    }

    public function down()
    {
        $this->forge->dropTable('likes');
        $this->forge->dropTable('comments');
        $this->forge->dropTable('rating');
    }
}
