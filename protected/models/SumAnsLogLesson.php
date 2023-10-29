<?php

/**
 * This is the model class for table "{{bank}}".
 *
 * The followings are the available columns in table '{{bank}}':
 * @property integer $bank_id
 * @property string $bank_user
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class SumAnsLogLesson extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumAnsLogLesson the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sum_answer_lessonlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, course_id, lesson_id, user_id, gen_id, quest_id,score_id', 'numerical', 'integerOnly' => true),
			array('id, course_id, lesson_id, user_id, gen_id, status,score_id, create_date', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('score_id', $this->score_id);
		$criteria->compare('course_id', $this->course_id, true);
		$criteria->compare('lesson_id', $this->lesson_id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('gen_id', $this->gen_id, true);
		$criteria->compare('quest_id', $this->quest_id, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('create_date', $this->create_date);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
