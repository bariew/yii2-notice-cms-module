<?php
/**
 * EmailBehavior class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Moqod
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace bariew\noticeModule\components;
use bariew\noticeModule\models\EmailConfig;
use bariew\noticeModule\models\Item;
use yii\base\Behavior;
use yii\db\ActiveRecord;
/**
 * sends emails after new owner model saved
 * @package application\modules\notice\components
 */
class EmailBehavior extends Behavior
{
    /**
     * @var integer (1/0) whether owner is active
     */
    public $active;
    /**
     * @var EmailConfig  model with hml content, title and variables
     */
    public $config = null;
    /**
     * @var array variables to replace (key is replaced by value like array('%username%'=>'Paul'))
     */
    public $variables = [];
    /**
     * @inheritdoc
     */
    public function events() 
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT   => 'sendEmail',
        ];
    }    
    /**
     * prepares and sends email content
     * @return whether email is sent
     */
    public function sendEmail()
    {
        if (($this->owner->type != Item::TYPE_EMAIL) || (!$config = $this->owner->getEmailConfig())) {
            return true;
        }
        $this->setFromConfig($config);
        return \Yii::$app->mail->compose()
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setTo($this->owner->address)
            ->setSubject($this->owner->title)
            ->setHtmlBody($this->owner->content)
            ->send()
            ? ($this->owner->status = Item::STATUS_SUCCESS)
            : ($this->owner->status = Item::STATUS_ERROR);
    }

    /**
     * gets data from email config EmailConfig
     * @param EmailConfig $config
     * @return null if no config
     */
    public function setFromConfig(EmailConfig $config)
    {
        foreach (['title', 'content', 'address'] as $attribute) {
            $this->owner->$attribute = $this->prepareString($config->$attribute);
        }
    }
    /**
     * prepares email content before sending
     * @param string $string email content
     * @test asd
     * @return string prepared string
     */
    private function prepareString($string)
    {
        return str_replace(
            array_keys($this->owner->variables),
            array_values($this->owner->variables),
            $string
        );
    }
}