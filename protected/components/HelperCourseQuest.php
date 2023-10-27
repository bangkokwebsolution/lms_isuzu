<?php
class HelperCourseQuest
{
    public static function lib()
    {
        return new HelperCourseQuest;
    }

    public static function LANG_ID()
    {
        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $LANG_ID = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        } else {
            $LANG_ID = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
        }
        return $LANG_ID;
    }

    public  function label()
    {
        $label = MenuCoursequestion::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $this->LANG_ID())
        ));
        return $label;
    }

    public function labelCourse()
    {
        $labelCourse = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $this->LANG_ID())
        ));
        if (!$labelCourse) {
            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        return $labelCourse;
    }
}
