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
        $this->insert('notice_email_config', [
            'title'     => 'User registration email',
            'subject'   => 'Welcome to blacklists!',
            'content'   => '{{site_name}} registration test email. <br /> Hello {{username}}! '
            . '<br /> Follow this <a href="{{site_url}}/user/default/confirm?auth_key={{auth_key}}">registration link </a>',
            'owner_name'=> 'app\modules\user\models\RegisterForm',
            'owner_event'=>'afterInsert'
        ]);
    }

    public function down()
    {
        return $this->dropTable('notice_email_config');
    }
}