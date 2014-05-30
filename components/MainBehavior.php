<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\noticeModule\components;

use yii\base\Behavior;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MainBehavior extends Behavior
{
    /**
     * gets name of the behavior, listing its owner behaviors
     * and comparing ro itself
     * @return string name of this behavior
     */
    public function getName()
    {
        return array_search($this, $this->owner->getBehaviors());
    }
    /**
     * gets owner attribute value by given owner attribute name in behavior attribute value
     * @param string $attributeName this attribute name
     * @return mixed owner attribute value
     */
    public function a($attributeName)
    {
        return $this->owner->{$this->$attributeName};
    }
    /**
     * refreshes its attributes from owner behavior method data
     * @return \ActiveRecordBehavior this
     */
    public function refresh()
    {
        $behaviors = $this->owner->behaviors();
        $settings = $behaviors[$this->getName()];
        foreach ($settings as $attribute=>$value) {
            if (in_array($attribute, array('class'))) {
                continue;
            }
            $this->$attribute = $value;
        }
        return $this;
    }
}
