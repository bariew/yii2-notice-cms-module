<?php

class m140515_073531_notice_email_config extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('notice_email_config', array(
            'id'            => 'pk',
            'title'         => 'string',
            'subject'       => 'string',
            'content'       => 'text',
            'owner_name'    => 'string',
            'owner_event'   => 'string'
        ));
    }

    public function down()
    {
        return $this->dropTable('notice_email_config');
    }
}