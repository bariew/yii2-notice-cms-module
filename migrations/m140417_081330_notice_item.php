<?php

class m140417_081330_notice_item extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('notice_item', array(
            'id'            => 'pk',
            'address'       => 'string',
            'title'         => 'string',
            'content'       => 'string',
            'owner_name'    => 'string',
            'owner_event'   => 'string',
            'owner_id'      => 'integer',
            'type'          => 'integer',
            'status'        => 'integer',
            'created_at'    => 'integer',
        ));
    }

    public function down()
    {
        return $this->dropTable('notice_item');
    }
}