<?php

namespace bariew\noticeModule\models;

use bariew\noticeModule\helpers\ClassCrawler;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notice_email_config".
 *
 * @property integer $id
 * @property string $title
 * @property string email
 * @property string $subject
 * @property string $content
 * @property string $owner_name
 * @property string $owner_event
 */
class EmailConfig extends ActiveRecord
{
    public function variables()
    {
        $notice = new Item();
        $variables = $notice->variables;
        if ($this->owner_name) {
            $owner = new $this->owner_name(null, null, null, null, null);
            $labels = method_exists($owner, 'attributeLabels') ? $owner->attributeLabels() : [];
            $variables = array_merge($variables, $labels);
        }
        
        foreach ($variables as $label => $value) {
            $label = strpos($label, '}}') ? $label :  '{{' . $label . '}}';
            $result[] = compact('label', 'value');
        }
        return $result;
    }

    /**
     * For autocreate config from new event module items.
     * @param Event $event event model new item event.
     * @return bool
     */
    public static function createEventConfig(Event $event)
    {
        if ($event->sender->handler_class != Item::className()
            || $event->sender->handler_method != Item::HANDLER_METHOD
        ) {
            return false;
        }
        $model = new self([
            'title' => 'new config',
            'content' => 'new content',
            'subject'   => 'new subject',
            'owner_name' => $event->sender->trigger_class,
            'owner_event'=> $event->sender->trigger_event,
            'address'     => 'test@test.com'
        ]);
        $model->save();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_email_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'subject', 'owner_name', 'owner_event', 'address'], 'required'],
            [['content'], 'string'],
            [['title', 'subject', 'owner_name', 'owner_event', 'address'], 'string', 'max' => 255],
            [['content'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'address' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'owner_name' => Yii::t('app', 'Owner Name'),
            'owner_event' => Yii::t('app', 'Owner Event'),
        ];
    }

    public function eventList()
    {
        return ($this->owner_name)
            ? array_flip(ClassCrawler::getEventNames($this->owner_name))
            : [];
    }

    public static function classList()
    {
        $classes = ClassCrawler::getAllClasses();
        return array_combine($classes, $classes);
    }
}
