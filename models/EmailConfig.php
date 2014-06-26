<?php

namespace bariew\noticeModule\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notice_email_config".
 *
 * @property integer $id
 * @property string $title
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
            $owner = new $this->owner_name;
            $variables = array_merge($variables, $owner->attributeLabels());
        }
        
        foreach ($variables as $label => $value) {
            $label = strpos($label, '}}') ? $label :  '{{' . $label . '}}';
            $result[] = compact('label', 'value');
        }
        return $result;
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
            [['title', 'content', 'subject', 'owner_name', 'owner_event'], 'required'],
            [['content'], 'string'],
            [['title', 'subject', 'owner_name', 'owner_event'], 'string', 'max' => 255],
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
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'owner_name' => Yii::t('app', 'Owner Name'),
            'owner_event' => Yii::t('app', 'Owner Event'),
        ];
    }
}
