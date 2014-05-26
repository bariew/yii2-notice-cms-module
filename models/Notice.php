<?php

namespace bariew\noticeModule\models;

use Yii;

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
class Notice extends \yii\db\ActiveRecord
{
    const TYPE_EMAIL        = 1;
    const STATUS_SUCCESS    = 0;
    const STATUS_ERROR      = 1;
    
    public $variables = [];
    
    public static function test($event)
    {
        echo $event->sender->id; exit;
    }
    
    public function setDefaulVariables()
    {
        $this->variables = [
            '{{site_url}}'  => Yii::$app->request->hostInfo,
            '{{site_name}}' => Yii::$app->id
        ];
    }
    
    public static function userRegistration(\yii\base\Event $event)
    {
        $user = $event->sender;
        if ($user->scenario == 'root') {
            return true;
        }
        $model = new self(['scenario'=>'root']);
        $model->owner_event   = $event->name;
        return $model->addUser($user)->save();
    }
    
    public function addUser($user)
    {
        $this->attributes = [
            'address'       => $user->email,
            'owner_name'    => get_class($user),
            'owner_id'      => $user->id,
            'type'          => self::TYPE_EMAIL,
            'content'       => 'test user registration content',
            'title'         => 'test user registration title',
        ];
        foreach ($user->attributes as $attribute=>$value) {
            $this->variables['{{'.$attribute.'}}'] = $value;
        }
        return $this;
    }
    
    public function getEmailConfig()
    {
        if (!$this->owner_name || !$this->owner_event) {
            return null;
        }
        return \bariew\noticeModule\models\EmailConfig::findOne([
            'owner_name' => $this->owner_name,
            'owner_event'=> $this->owner_event
        ]);
    }
    /**
     * @inheritdoc
     */
    public function behaviors() 
    {
        return array_merge(parent::behaviors(), [
            'emailBehavior' => [
                'class'     => 'bariew\noticeModule\components\EmailBehavior',
                'title'     => $this->title,
                'content'   => $this->content,
                'email'     => $this->address,
                'config'    => $this->getEmailConfig(),
                'variables' => $this->variables,
                'active'    => ($this->isNewRecord && $this->type == self::TYPE_EMAIL)
            ],
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
            [['address'], 'required'],
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
        $this->setDefaulVariables();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_notice';
    }    
}
