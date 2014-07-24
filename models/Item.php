<?php

namespace bariew\noticeModule\models;

use bariew\noticeModule\components\EmailBehavior;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notice_notice".
 *
 * @property string $id
 * @property string $address
 * @property string $title
 * @property string $content
 * @property string $owner_name
 * @property string $owner_event
 * @property integer $owner_id
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 */
class Item extends ActiveRecord
{
    const TYPE_EMAIL        = 1;
    const STATUS_SUCCESS    = 0;
    const STATUS_ERROR      = 1;
    const HANDLER_METHOD = 'eventEmail';

    public $variables = [];

    
    public function setDefaultVariables()
    {
        $this->variables = [
            '{{site_url}}'  => Yii::$app->request->hostInfo,
            '{{site_name}}' => Yii::$app->id
        ];
    }
    
    public static function eventEmail(Event $event)
    {
        $model = new self(['scenario'=>'root']);
        $model->type = self::TYPE_EMAIL;
        return $model->setEvent($event)->save();
    }
    
    public function setEvent($event)
    {
        $this->owner_event   = $event->name;
        $this->owner_name = get_class($event->sender);
        $this->owner_id = $event->sender->primaryKey;
        foreach ($event->sender->attributes as $attribute => $value) {
            $this->variables['{{'.$attribute.'}}'] = $value;
        }
        return $this;
    }
    
    public function getEmailConfig()
    {
        if (!$this->owner_name || !$this->owner_event) {
            return null;
        }
        return EmailConfig::findOne([
            'owner_name' => $this->owner_name,
            'owner_event'=> $this->owner_event
        ]);
    }

    public static function statusList()
    {
        return [
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_ERROR  => 'Error'
        ];
    }

    public function getStatusName()
    {
        return self::statusList()[$this->status];
    }

    public static function typeList()
    {
        return [
            self::TYPE_EMAIL => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() 
    {
        return array_merge(parent::behaviors(), [
            EmailBehavior::className(),
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_ERROR],
            [['type'], 'default', 'value' => self::TYPE_EMAIL],
            
            [['owner_id', 'type', 'status'], 'integer', 'on'=>'root'],
            [['address', 'title', 'content', 'owner_name', 'owner_event'], 'string', 'max' => 255, 'on'=>'root'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address' => Yii::t('app', 'Address'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'owner_name' => Yii::t('app', 'Owner Name'),
            'owner_event' => Yii::t('app', 'Owner Event'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();
        $this->setDefaultVariables();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{notice_item}}';
    }    
}
