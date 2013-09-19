<?php

namespace Fuel\Migrations;

class Create_cdr_content
{
    public function up()
    {
        \DBUtil::create_table('cdr_content', array(
            'id'                => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'cdr_id'            => array('constraint' => 11, 'type' => 'int'),
            'ip'                => array('constraint' => 255, 'type' => 'varchar'),
            'answer_time'       => array('type' => 'datetime'),
            'end_time'          => array('type' => 'datetime'),
            'time_band'         => array('constraint' => 255, 'type' => 'varchar'),
            'duration'          => array('constraint' => 11, 'type' => 'int'),
            'number_presented'  => array('constraint' => '255', 'type' => 'varchar'),
            'number_dialled'    => array('constraint' => '255', 'type' => 'varchar'),
            'prefix'            => array('constraint' => 11, 'type' => 'int'),
            'cost'              => array('constraint' => '7,2', 'type' => 'float'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('cdr_content');
    }
}