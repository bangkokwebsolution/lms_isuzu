<?php

class LogAnsLesson extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogAnsLesson the static model class
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
		return '{{log_ansques_l}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, lesson_id, user_id, gen_id,temp_id, quest_id', 'numerical', 'integerOnly' => true),
			array('id, lesson_id, user_id, answer_choice, temp_id, number, status, create_date', 'safe', 'on' => 'search'),
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
		$criteria->compare('lesson_id', $this->lesson_id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('gen_id', $this->gen_id, true);
		$criteria->compare('quest_id', $this->quest_id, true);
		$criteria->compare('answer_choice', $this->answer_choice, true);
		$criteria->compare('temp_id', $this->temp_id, true);
		$criteria->compare('number', $this->number);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('create_date', $this->create_date);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
