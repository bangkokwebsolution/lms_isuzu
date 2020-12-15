<?php

class SendMailAlertCourse extends CFormModel {

    public $news_per_page;
    public $search_name;
    public $type_employee;
    public $position_id;
    public $department_id;
    public $course_id;
    
    


    public function rules()
    {
        return array(
            // array('course_id', 'required'),
            array('news_per_page,search_name,type_employee , position_id, department_id,course_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('search_name,type_employee , position_id, department_id,course_id', 'safe', 'on'=>'search'),
        );
    }
    
    // public function relations()
    // {
    //     // NOTE: you may need to adjust the relation name and the related
    //     // class name for the relations automatically generated below.
    //     return array(
    //         'pro' => array(self::BELONGS_TO, 'Profile', 'user_id'),
    //         'mem' => array(self::BELONGS_TO, 'User', 'user_id','foreignKey' => array('user_id'=>'id')),
    //         'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
    //         'gen' => array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
    //     );
    // }

    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'course_id' => 'Course *',
            'type_employee' => 'ประเภทพนักงาน',
            'position_id' => 'ตำแหน่ง',
            'department_id' => 'แผนก',
            'search_name' => 'ชื่อ-สกุล',//, เลขบัตรประชาชน-พาสปอร์ต
            
        );
    }

}