<?php
/**
 * EmailBehavior class file.
 * @author Pavel Bariev <bariew@yandex.ru>
 * @copyright (c) 2014, Moqod
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace bariew\noticeModule\components;
use app\modules\main\components\MainBehavior;
use yii\db\ActiveRecord;
/**
 * sends emails after new owner model saved
 * @package application\modules\notice\components
 */
class EmailBehavior extends MainBehavior 
{
    /**
     * @var string email title
     */
    public $title;
    /**
     * @var string email content
     */    
    public $content;
    /**
     * @var string email address
     */
    public $email;
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
        $this->refresh();
        if (!$this->active) {
            return true;
        }
        $this->getFromConfig();
        $this->title = $this->prepareString($this->title);
        $this->content = $this->prepareString($this->content);
        
        return \Yii::$app->mail->compose()
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject($this->title)
            //->setTextBody($this->content)
            ->setHtmlBody($this->content)
            ->send();
    }
    /**
     * gets data from email config EmailConfig
     * @return null if no config
     */
    public function getFromConfig()
    {
        if (!$this->config) {
            return;
        }
        $this->title = $this->config->subject;
        $this->content = $this->config->content;
    }
    /**
     * prepares email content before sending
     * @param string $string email content
     * @test asd
     * @return string preapred string
     */
    private function prepareString($string)
    {
        return str_replace(array_keys($this->variables), array_values($this->variables), $string);
    }
}