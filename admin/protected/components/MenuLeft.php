<?php
Class MenuLeft extends Controller
{
	public static function SetSubMenu($Name = array(),$Set=true)
	{
		/*=============================================
		=             Check submenuOptions	          =
		=============================================*/
		$Sum = 0;
		foreach ($Name as $value)
		{
			if(strtolower(Yii::app()->controller->id) == strtolower($value))
			{
				$Sum = $Sum+1;
			}
		}

		if($Set == true)
		{
			if($Sum >= 1) $check = ' in collapse ' ; else $check = ' collapse ';
		}
		else
		{
			if($Sum >= 1) $check = true ; else $check = false;
		}

		return $check;
	}

//	public static function PermissionsMenu( $menu = array() )
//	{
//		/*=============================================
//		=             Check Permissions	             =
//		=============================================*/
//		$sum = 0;
//		$countArray = count($menu);
//		if($countArray != 0)
//		{
//			foreach ($menu as $key => $value)
//			{
//				if(Yii::app()->user->checkAccess($value) === true)
//				{
//					$sum = $sum+1;
//				}
//			}
//		}
//
//		if($sum >= 1) $check = true; else $check = false;
//
//		return $check;
//	}

	public static function PermissionsMenu( $menu = array() )
	{
		/*=============================================
		=             Check Permissions	             =
		=============================================*/
		$sum = 0;
		$countArray = count($menu);
		$return = false;        

		if($countArray != 0)
		{
			foreach ($menu as $key => $value)
			{
				$val = explode('.',$value);
				$controller_name = strtolower($val[0]);

				// if($controller_name == "monthcheck"){
				// 	var_dump($val);
				// 	exit();
				// }
				$action_name = strtolower($val[1]);
				$check = AccessControl::check_access_action(strtolower($controller_name),strtolower($action_name));
				if($check){
					$return = true;
				}else{
					$return = false;
				}
			}
		}

		// if($controller_name == "monthcheck"){
		// 			var_dump($check);
		// 			exit();
		// 		}
		return $return;
	}

	public static function Menu()
	{
		$lang = Language::model()->findByAttributes(1);
		$mainLang = $lang->language;

		return array(
			array(
				'label'=>'<i></i><span>หน้าหลัก</span>',
				'url'=>array('/site/index'),
				'itemOptions' => array('class' => 'glyphicons home'),
			),
			array(
				/*====== Check Permissions Language (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Language.*',
					'Language.admin',
					'Language.Create'
				)),
				'label'=>'<i></i><span>ภาษา</span>',
				'url'=>'#Language',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Language') ), 'id' => 'Language'),
				'active' => self::SetSubMenu( array('Language') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Position (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Language.*',
							'Language.Create'
						)),
						'label'=>'เพิ่มภาษา',
						'url'=>array('//Language/create')
					),
					array(
						'visible'=>self::PermissionsMenu(array(
							'Language.*',
							'Language.admin'
						)),
						'label'=>'จัดการภาษา',
						'url'=>array('//Language/admin')
					),
				)
			),
			array(
				/*====== Check Permissions MainMenu (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'MainMenu.*',
					'MainMenu.admin',
					'MainMenu.Create'
				)),
				'label'=>'<i></i><span>เมนู</span>',
				'url'=>'#MainMenu',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('MainMenu') ), 'id' => 'MainMenu'),
				'active' => self::SetSubMenu( array('MainMenu') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Position (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'MainMenu.*',
							'MainMenu.Create'
						)),
						'label'=>'เพิ่มเมนู'." (ภาษา ".$mainLang." )",
						'url'=>array('//MainMenu/create')
					),
					array(
						'visible'=>self::PermissionsMenu(array(
							'MainMenu.*',
							'MainMenu.admin'
						)),
						'label'=>'จัดการเมนู',
						'url'=>array('//MainMenu/admin')
					),
				)
			),
			// array(
			// 	'label'=>'<i></i><span>สถิติการใช้งาน</span>',
			// 	'url'=>array('/analytics/index'),
			// 	'itemOptions' => array('class' => 'glyphicons stats'),
			// ),
	        //====== END Menu Site ======//



//			array(
//				/*====== Check Permissions Page (2) ======*/
//				'visible'=>self::PermissionsMenu(array(
//					'Page.*',
//					'Page.Index',
//					'Page.Create'
//				)),
//				'label'=>'<i></i><span>ระบบจำนวนการแสดงผล</span>',
//				'url'=>'#Page',
//				'linkOptions' => array('data-toggle' => 'collapse'),
//				'itemOptions' => array('class' => 'hasSubmenu glyphicons show_thumbnails_with_lines'),
//				'submenuOptions' => array('class' => self::SetSubMenu( array('Page') ), 'id' => 'Page'),
//				'active' => self::SetSubMenu( array('Page') ,false),
//				'items'=>array(
//					array(
//						/*====== Check Permissions Sup-Page (1) ======*/
//						'visible'=>self::PermissionsMenu(array(
//							'Page.*',
//							'Page.Create'
//						)),
//						'label'=>'เพิ่มจำนวนการแสดงผล',
//						'url'=>array('//Page/create')
//					),
//					array(
//						/*====== Check Permissions Sup-Page (2) ======*/
//						'visible'=>self::PermissionsMenu(array(
//							'Page.*',
//							'Page.Index'
//						)),
//						'label'=>'จัดการจำนวนการแสดงผล',
//						'url'=>array('//Page/index')
//					),
//				)
//			),
			//====== END Menu Page ======//

			// array(
			// 	/*====== Check Permissions Setting (1)  ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Setting.*',
			// 		'Setting.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ตั้งค่าระบบพื้นฐาน</span>',
			// 	'url'=>'#Setting',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Setting') ) , 'id' => 'Setting'),
			// 	'active' => self::SetSubMenu(array('Setting'),false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-Setting (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Setting.*',
			// 				'Setting.Create'
			// 			)),
			// 			'label'=>'ตั้งค่าระบบพื้นฐาน',
			// 			'url'=>array('//Setting/create')
			// 		),
			// 	)
			// ),


			// array(
			// 	/*====== Check Permissions About (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'About.*',
			// 		'About.index'
			// 	)),
			// 	'label'=>'<i></i><span>เกี่ยวกับเรา</span>',
			// 	'url'=>'#About',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('About') ), 'id' => 'About'),
			// 	'active' => self::SetSubMenu( array('About') ,false),
			// 	'items'=>array(

					// array(
					// 	/*====== Check Permissions Sup-About (2) ======*/
					// 	'visible'=>self::PermissionsMenu(array(
					// 		'About.*',
					// 		'About.index'
					// 	)),
					// 	'label'=>'จัดการเกี่ยวกับเรา',
					// 	'url'=>array('//About/index/')
					// ),
					// array(
					// 	/*====== Check Permissions Sup-About (2) ======*/
					// 	'visible'=>self::PermissionsMenu(array(
					// 		'About.*',
					// 		'About.index'
					// 	)),
					// 	'label'=>'จัดการเกี่ยวกับเรา',
					// 	'url'=>array('//About/index/')
					// ),
					// array(
					// 	/*====== Check Permissions Sup-About (2) ======*/
					// 	'visible'=>self::PermissionsMenu(array(
					// 		'About.*',
					// 		'About.Create'
					// 	)),
					// 	'label'=>'เพิ่มเกี่ยวกับบริษัท',
					// 	'url'=>array('//About/Create/')
					// ),
			// 	)
			// ),
			//====== END Menu About ======//


			array(
				/*====== Check Permissions Conditions (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Conditions.*',
					'Conditions.index'
				)),
				'label'=>'<i></i><span>เงื่อนไขการใช้งาน</span>',
				'url'=>'#Conditions',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Conditions') ), 'id' => 'Conditions'),
				'active' => self::SetSubMenu( array('Conditions') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Conditions (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Conditions.*',
							'Conditions.index'
						)),
						'label'=>'แก้ไขเงื่อนไขการใช้งาน',
						'url'=>array('//Conditions/index')
					),
					array(
						/*====== Check Permissions Sup-Conditions (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Terms.*',
							'Terms.index'
						)),
						'label'=>'ข้อกำหนด&เงื่อนไขการใช้งาน',
						'url'=>array('//Terms/index')
					),
				)
			),
			array(
				/*====== Check Permissions PopUp (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'PopUp.*',
					'PopUp.admin',
					'PopUp.Create'
				)),
				'label'=>'<i></i><span>ระบบจัดการป๊อปอัพ</span>',
				'url'=>'#PopUp',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('PopUp') ), 'id' => 'PopUp'),
				'active' => self::SetSubMenu( array('PopUp') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-PopUp (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'PopUp.*',
							'PopUp.Create'
						)),
						'label'=>'เพิ่มป๊อปอัพ'." (ภาษา ".$mainLang." )",
						'url'=>array('//PopUp/create')
					),
					array(
						/*====== Check Permissions Sup-PopUp (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'PopUp.*',
							'PopUp.admin'
						)),
						'label'=>'จัดการป๊อปอัพ',
						'url'=>array('//PopUp/admin')
					),
				)
			),
			//====== END Menu PopUp ======//
			//====== END Menu Conditions ======//


			// array(
			// 	/*====== Check Permissions Contactus (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Contactus.*',
			// 		'Contactus.Index'
			// 	)),
			// 	'label'=>'<i></i><span>ติดต่อเรา</span>',
			// 	'url'=>'#Contactus',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons adress_book'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Contactus') ), 'id' => 'Contactus'),
			// 	'active' => self::SetSubMenu( array('Contactus') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-Contactus (2) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Contactus.*',
			// 				'Contactus.Index'
			// 			)),
			// 			'label'=>'ดูรายละเอียดติดต่อเรา',
			// 			'url'=>array('//Contactus/index')
			// 		),
			// 	)
			// ),
				array(
				/*====== Check Permissions Contactus (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'ContactusNew.*',
					'ContactusNew.admin'
				)),
				'label'=>'<i></i><span>ติดต่อเรา</span>',
				'url'=>'#ContactusNew',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons adress_book'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('ContactusNew') ), 'id' => 'ContactusNew'),
				'active' => self::SetSubMenu( array('ContactusNew') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-PopUp (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'ContactusNew.*',
							'ContactusNew.Create'
						)),
						'label'=>'เพิ่มผู้ติดต่อ',
						'url'=>array('//ContactusNew/create')
					),
					array(
						/*====== Check Permissions Sup-Contactus (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'ContactusNew.*',
							'ContactusNew.admin'
						)),
						'label'=>'จัดการติดต่อเรา',
						'url'=>array('//ContactusNew/admin')
					),
				)
			),
			//====== END Menu Contactus ======//


			array(
				/*====== Check Permissions News (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'News.*',
					'News.Index',
				)),
				'label'=>'<i></i><span>ระบบจัดการเนื้อหาเว็บไซต์ (ข่าวสาร)</span>',
				'url'=>'#News',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('News') ), 'id' => 'News'),
				'active' => self::SetSubMenu( array('News') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-News (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'News.*',
							'News.Create'
						)),
						'label'=>'เพิ่มข่าวสารและกิจกรรม'." (ภาษา ".$mainLang." )",
						'url'=>array('//News/create')
					),
					array(
						/*====== Check Permissions Sup-News (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'News.*',
							'News.Index'
						)),
						'label'=>'จัดการข่าวสารและกิจกรรม',
						'url'=>array('//News/index')
					),
				)
			),
			//====== END Menu News ======//

			// array(
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'CourseType.*',
			// 	)),
			// 	'label'=>'<i></i><span> ประเภทหลักสูตร</span>',
			// 	'url'=>'#CourseType',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons book'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('CourseType') ), 'id' => 'CourseType'),
			// 	'active' => self::SetSubMenu( array('CourseType') ,false),
			// 	'items'=>array(
			// 		// array(
			// 		// 	'visible'=>self::PermissionsMenu(array(
			// 		// 		'CourseType.*',
			// 		// 		'CourseType.Create'
			// 		// 	)),
			// 		// 	'label'=>'เพิ่ม '."(ภาษา ".$mainLang." )",
			// 		// 	'url'=>array('//CourseType/create')
			// 		// ),
			// 		array(
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'CourseType.*',
			// 				'CourseType.Index'
			// 			)),
			// 			'label'=>'จัดการ',
			// 			'url'=>array('//CourseType/index')
			// 		),
			// 	)
			// ),

			array(
				/*====== Check Permissions Category (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Category.*',
					'Category.Index',
					'Category.Create'
				)),
				'label'=>'<span class="label label-primary">1</span> <i></i><span>ระบบหมวดหลักสูตร</span>',
				'url'=>'#Category',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Category') ), 'id' => 'Category'),
				'active' => self::SetSubMenu( array('Category') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Category (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Category.*',
							'Category.Create'
						)),
						'label'=>'เพิ่มหมวดหลักสูตร'." (ภาษา ".$mainLang." )",
						'url'=>array('//Category/create')
					),
					array(
						/*====== Check Permissions Sup-Category (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Category.*',
							'Category.Index'
						)),
						'label'=>'จัดการหมวดหลักสูตร',
						'url'=>array('//Category/index')
					),
				)
			),
			//====== END Menu Category ======//

			array(
				/*====== Check Permissions CourseOnline (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'CourseOnline.*',
					'CourseOnline.Index',
					'CourseOnline.Create'
				)),
				'label'=>'<span class="label label-primary">2</span> <i></i><span>ระบบจัดการหลักสูตร</span>',
				'url'=>'#CourseOnline',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('CourseOnline') ), 'id' => 'CourseOnline'),
				'active' => self::SetSubMenu( array('CourseOnline') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-CourseOnline (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline.*',
							'CourseOnline.Create'
						)),
						'label'=>'เพิ่ม'." (ภาษา ".$mainLang." )",
						'url'=>array('//CourseOnline/create')
					),
					array(
						/*====== Check Permissions Sup-CourseOnline (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'CourseOnline.*',
							'CourseOnline.Index'
						)),
						'label'=>'จัดการ',
						'url'=>array('//CourseOnline/index')
					),
				)
			),
			//====== END Menu CourseOnline ======//

			array(
				/*====== Check Permissions Lesson (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Lesson.*',
					'Lesson.Index',
					'Lesson.Create',
//	        		'Scorm.*',
//	        		'Scorm.Index',
//	        		'Scorm.Create',
				)),
				'label'=>'<span class="label label-primary">3</span> <i></i><span>ระบบจัดการเนื้อหาบทเรียน</span>',
				'url'=>'#Lesson',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons imac'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Lesson', 'File') ), 'id' => 'Lesson'),
				'active' => self::SetSubMenu( array('Lesson', 'File') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Lesson (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Lesson.*',
							'Lesson.Create'
						)),
						'label'=>'เพิ่มบทเรียน'." (ภาษา ".$mainLang." )",
						'url'=>array('//Lesson/create')
					),
					array(
						/*====== Check Permissions Sup-Lesson (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Lesson.*',
							'Lesson.Index'
						)),
						'label'=>'จัดการบทเรียน',
						'url'=>array('//Lesson/index')
					),
				)
			),
			//====== END Menu Lesson ======//

			array(
				/*====== Check Permissions Grouptesting (2) ======*/
				'visible'=>self::PermissionsMenu(array(
					'Grouptesting.*',
					'Grouptesting.Index',
					'Grouptesting.Create',
					'Coursegrouptesting.Index',
					'Coursegrouptesting.Create'
				)),
				'label'=>'<span class="label label-primary">4</span> <i></i><span>ข้อสอบ</span>',
				'url'=>'#Grouptesting',
				'linkOptions' => array('data-toggle' => 'collapse'),
				'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
				'submenuOptions' => array('class' => self::SetSubMenu( array('Grouptesting', 'Coursegrouptesting') ), 'id' => 'Grouptesting'),
				'active' => self::SetSubMenu( array('Grouptesting', 'Coursegrouptesting') ,false),
				'items'=>array(
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Grouptesting.*',
							'Grouptesting.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบ',
						'url'=>array('//Grouptesting/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Grouptesting.*',
							'Grouptesting.Index'
						)),
						'label'=>'จัดการชุดข้อสอบ',
						'url'=>array('//Grouptesting/index')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (1) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Coursegrouptesting.*',
							'Coursegrouptesting.Create'
						)),
						'label'=>'เพิ่มชุดข้อสอบหลักสูตร',
						'url'=>array('//Coursegrouptesting/create')
					),
					array(
						/*====== Check Permissions Sup-Grouptesting (2) ======*/
						'visible'=>self::PermissionsMenu(array(
							'Coursegrouptesting.*',
							'Coursegrouptesting.Index'
						)),
						'label'=>'จัดการชุดข้อสอบหลักสูตร',
						'url'=>array('//Coursegrouptesting/index')
					),
				)
			),
			//====== END Menu Grouptesting ======//



            //array(
			/*====== Check Permissions FormSurveyGroup (2) ======*/
	        	/*'visible'=>self::PermissionsMenu(array(
	        		'Questionnaire.*',
	        		'Questionnaire.Index',
	        		'Questionnaire.Create'
	        	)),
	            'label'=>' <span class="label label-primary">5</span> <i></i><span>ระบบแบบสอบถาม</span>',
	            'url'=>'#Questionnaire',
	            'linkOptions' => array('data-toggle' => 'collapse'),
	            'itemOptions' => array('class' => 'hasSubmenu glyphicons notes'),
	            'submenuOptions' => array('class' => self::SetSubMenu( array('Questionnaire') ), 'id' => 'Questionnaire'),
	            'active' => self::SetSubMenu( array('Questionnaire') ,false),
	            'items'=>array(
	            array(*/
	            	/*====== Check Permissions Sup-Questionnaire (1) ======*/
	                	/*'visible'=>self::PermissionsMenu(array(
	                		'Questionnaire.*',
	                		'Questionnaire.Create'
	                	)),
	                	'label'=>'เพิ่มแบบสอบถาม',
	                	'url'=>array('//Questionnaire/create')
	                ),
	                array(*/
	                	/*====== Check Permissions Sup-Questionnaire (2) ======*/
	                	/*'visible'=>self::PermissionsMenu(array(
	                		'Questionnaire.*',
	                		'Questionnaire.Index'
	                	)),
	                	'label'=>'จัดการแบบสอบถาม',
	                	'url'=>array('//Questionnaire/index')
	                ),
	            )
	        ),*/

	        array(
	        	/*====== Check Permissions FormSurveyGroup (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Questionnaireout.*',
	        		'Questionnaireout.Index',
	        		'Questionnaireout.Create'
	        	)),
	        	/*'label'=>' <i></i><span>ระบบแบบสอบถาม (ไม่ผูกบทเรียน)</span>',*/
	        	'label'=>' <span class="label label-primary">5</span> <i></i><span>แบบประเมินผลการฝึกอบรม</span>',
	        	'url'=>'#Questionnaireout',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons notes'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Questionnaireout') ), 'id' => 'Questionnaireout'),
	        	'active' => self::SetSubMenu( array('Questionnaireout') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Questionnaireout (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Questionnaireout.*',
	        				'Questionnaireout.Create'
	        			)),
	        			'label'=>'เพิ่มแบบสอบถาม',
	        			'url'=>array('//Questionnaireout/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Questionnaireout (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Questionnaireout.*',
	        				'Questionnaireout.Index'
	        			)),
	        			'label'=>'จัดการแบบสอบถาม',
	        			'url'=>array('//Questionnaireout/index')
	        		),
	        	)
	        ),
	         array(
	        	/*====== Check Permissions AuthitemAccess (1) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'OrgChart.*',
	        		'OrgChart.Index',
	        	)),
	        	'label'=>'<span class="label label-primary">6</span><i></i><span>ระบบจัดการระดับชั้นการเรียน (Organization)</span>',
	        	'url'=>'#OrgChart',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons eye_open'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('OrgChart') ), 'id' => 'OrgChart'),
	        	'active' => self::SetSubMenu( array('OrgChart') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-AuthitemAccess (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'OrgChart.*',
	        				'OrgChart.Index'
	        			)),
						// 'label'=>'Organization chart',
	        			'label'=>'จัดการกลุ่มหลักสูตร',

	        			'url'=>array('//OrgChart/index')
	        		),
	        	)
	        ),
	         array(
               /*====== Check Permissions AuthitemAccess (1) ======*/
                'visible'=>self::PermissionsMenu(array(
                   'VirtualClassroom.*',
                   'VirtualClassroom.Index',
                )),
                'label'=>'<i></i><span>ห้องเรียนออนไลน์</span>',
                                'url'=>'#VirtualClassroom',
                'linkOptions' => array('data-toggle' => 'collapse'),
                'itemOptions' => array('class' => 'hasSubmenu glyphicons eye_open'),
                'submenuOptions' => array('class' => self::SetSubMenu( array('VirtualClassroom') ), 'id' => 'VirtualClassroom'),
                'active' => self::SetSubMenu( array('VirtualClassroom') ,false),
                'items'=>array(
                    array(
                        /*====== Check Permissions Sup-AuthitemAccess (1) ======*/
                        'visible'=>self::PermissionsMenu(array(
                            'VirtualClassroom.*',
                            'VirtualClassroom.Create'
                        )),
                        'label'=>'เพิ่ม',
                        'url'=>array('//VirtualClassroom/create')
                    ),
                    array(
	                	/*====== Check Permissions Sup-User (1) ======*/
	                	'visible'=>self::PermissionsMenu(array(
	                		'VirtualClassroom.*',
	                		'VirtualClassroom.Index'
	                	)),
	                	'label'=>'จัดการ',
	                	'url'=>array('//VirtualClassroom/index')
	                ),
	                //    array(
	                // 	/*====== Check Permissions Sup-User (1) ======*/
	                // 	'visible'=>self::PermissionsMenu(array(
	                // 		'VirtualClassroom.*',
	                // 		'VirtualClassroom.Logmeeting'
	                // 	)),
	                // 	'label'=>'Logmeeting',
	                // 	'url'=>array('//VirtualClassroom/logmeeting')
	                // ),

               )
            ),
	         // array(
          //      /*====== Check Permissions AuthitemAccess (1) ======*/
          //       'visible'=>self::PermissionsMenu(array(
          //          'LogStartcourse.*',
          //          'LogStartcourse.Index',
          //       )),
          //       'label'=>'<i></i><span>ระบบส่งเมลล์แจ้งเตือนผู้เรียน</span>',
          //                       'url'=>'#LogStartcourse',
          //       'linkOptions' => array('data-toggle' => 'collapse'),
          //       'itemOptions' => array('class' => 'hasSubmenu glyphicons envelope'),
          //       'submenuOptions' => array('class' => self::SetSubMenu( array('LogStartcourse') ), 'id' => 'LogStartcourse'),
          //       'active' => self::SetSubMenu( array('LogStartcourse') ,false),
          //       'items'=>array(
                 //    array(
	                // 	/*====== Check Permissions Sup-User (1) ======*/
	                // 	'visible'=>self::PermissionsMenu(array(
	                // 		'LogStartcourse.*',
	                // 		'LogStartcourse.Index'
	                // 	)),
	                // 	'label'=>'สมัครเข้าเรียนแล้ว',
	                // 	'url'=>array('//LogStartcourse/index')
	                // ),
	                //  array(
	                // 	/*====== Check Permissions Sup-User (1) ======*/
	                // 	'visible'=>self::PermissionsMenu(array(
	                // 		'LogStartcourse.*',
	                // 		'LogStartcourse.SendOrgChart'
	                // 	)),
	                // 	'label'=>'จัดการส่งเมลล์แจ้งเตือนผู้เรียน',
	                // 	'url'=>array('//LogStartcourse/SendOrgChart')
	                // ),
	                //    array(
	                // 	/*====== Check Permissions Sup-User (1) ======*/
	                // 	'visible'=>self::PermissionsMenu(array(
	                // 		'VirtualClassroom.*',
	                // 		'VirtualClassroom.Logmeeting'
	                // 	)),
	                // 	'label'=>'Logmeeting',
	                // 	'url'=>array('//VirtualClassroom/logmeeting')
	                // ),

            //    )
            // ),
   //          array(
				
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'CheckLecture.*',
			// 		// 'CheckLecture.update',
			// 	)),
			// 	'label'=>'<i></i><span>ระบบตรวจข้อสอบบรรยาย</span>',
			// 	'url'=>'#CheckLecture',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('CheckLecture') ), 'id' => 'CheckLecture'),
			// 	'active' => self::SetSubMenu( array('CheckLecture') ,false),
			// 	'items'=>array(
			// 		array(
						
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'CheckLecture.*',
			// 				'CheckLecture.index'
			// 			)),
			// 			'label'=>'ตรวจข้อสอบบรรยายบทเรียน',
			// 			'url'=>array('//CheckLecture/index')
			// 		),
			// 		array(
						
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Signature.*',
			// 				'Signature.update'
			// 			)),

			// 			'label'=>'ตรวจข้อสอบบรรยายหลักสูตร',
			// 			'url'=>array('//CheckLecture/coureCheck')
			// 		),
			// 	)
			// ),
             array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Certificate.*',
	        	)),
	        	'label'=>'<i></i><span>ระบบใบประกาศนียบัตร</span>',
	        	'url'=>'#Certificate',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Certificate', 'Signature') ), 'id' => 'Certificate'),
	        	'active' => self::SetSubMenu( array('Certificate', 'Signature') ,false),
	        	'items'=>array(
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Certificate.*',
	        				'Certificate.index'
	        			)),
	        			'label'=>'จัดการประกาศนียบัตร',
	        			'url'=>array('//Certificate/index')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Signature.*',
	        				'Signature.index'
	        			)),
	        			'label'=>'จัดการลายเซนต์',
	        			'url'=>array('//Signature/index')
	        		),
	        	)
	        ),
			 array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Captcha.*',
	        	)),
	        	'label'=>'<i></i><span>ระบบ Captcha</span>',
	        	'url'=>'#Captcha',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Captcha') ), 'id' => 'Captcha'),
	        	'active' => self::SetSubMenu( array('Captcha') ,false),
	        	'items'=>array(
					//set new menu
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Captcha.*',
	        			)),
	        			'label'=>'ตั้งค่าแคปช่า',
	        			'url'=>array('//Captcha/index')
	        		),
	        	)
	        ),
			 array(
	        	/*====== Check Permissions PopUp (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Reset.*',
					// 'Reset.admin',
					// 'Reset.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบรีเซ็ทผลการเรียนการสอบ</span>',
	        	'url'=>array('//LearnReset/ResetUser'),
				//'url'=>array('//Reset/index'),
				//'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons refresh'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Reset') ), 'id' => 'Reset'),
	        	'active' => self::SetSubMenu( array('Reset') ,false),
	        ),
			//====== END Menu PopUp ======//



			// array(
			// 	/*====== Check Permissions Position (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Problem_type.*',
			// 		'Problem_type.admin',
			// 		'Problem_type.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ประเภทปัญหาการใช้งาน</span>',
			// 	'url'=>'#Problem_type',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Problem_type') ), 'id' => 'Problem_type'),
			// 	'active' => self::SetSubMenu( array('Problem_type') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Position (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Problem_type.*',
			// 				'Problem_type.Create'
			// 			)),
			// 			'label'=>'เพิ่มประเภท',
			// 			'url'=>array('//Problem_type/create')
			// 		),
			// 		array(
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Problem_type.*',
			// 				'Problem_type.index'
			// 			)),
			// 			'label'=>'จัดการประเภท',
			// 			'url'=>array('//Problem_type/index')
			// 		),
			// 	)
			// ),
			//====== END Menu Position ======//

			//====== END Menu division ======//

	        // array(
	        // 	/*====== Check Permissions featuredlinks (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'FeaturedLinks.*',
	        // 		'FeaturedLinks.admin',
	        // 		'FeaturedLinks.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบจัดการหน่วยงานที่เกี่ยวข้อง</span>',
	        // 	'url'=>'#FeaturedLinks',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('FeaturedLinks') ), 'id' => 'FeaturedLinks'),
	        // 	'active' => self::SetSubMenu( array('FeaturedLinks') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-FeaturedLinks (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'FeaturedLinks.*',
	        // 				'FeaturedLinks.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มลิงค์แนะนำ',
	        // 			'url'=>array('//FeaturedLinks/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-FeaturedLinks (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'FeaturedLinks.*',
	        // 				'FeaturedLinks.admin'
	        // 			)),
	        // 			'label'=>'จัดการลิงค์แนะนำ',
	        // 			'url'=>array('//FeaturedLinks/admin')
	        // 		),
	        // 	)
	        // ),
			//====== END Menu FeaturedLinks ======//
			

	        array(
	        	/*====== Check Permissions Usability (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Usability.*',
	        		'Usability.Index',
	        		'Usability.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบวิธีการใช้งาน</span>',
	        	'url'=>'#Usability',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons wallet'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Usability') ), 'id' => 'Usability'),
	        	'active' => self::SetSubMenu( array('Usability') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Usability (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Usability.*',
	        				'Usability.Create'
	        			)),
	        			'label'=>'เพิ่มวิธีการใช้งาน'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//Usability/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Usability (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Usability.*',
	        				'Usability.Index'
	        			)),
	        			'label'=>'จัดการวิธีการใช้งาน',
	        			'url'=>array('//Usability/index')
	        		),
	        	)
	        ),
			//====== END Menu Usability ======//

	        array(
	        	/*====== Check Permissions Group Contactus (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'ReportProblem.*',
	        		'ReportProblem.index',
	        	)),
	        	'label'=>'<i></i><span>ระบบปัญหาการใช้งาน</span>',
	        	'url'=>'#ReportProblem',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons adress_book'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('ReportProblem','Maildetail') ), 'id' => 'ReportProblem'),
	        	'active' => self::SetSubMenu( array('ReportProblem','Maildetail') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Contactus (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'ReportProblem.*',
	        				'ReportProblem.index'
	        			)),
	        			'label'=>'จัดการปัญหาการใช้งาน',
	        			'url'=>array('//ReportProblem/index')
	        		),
	        	)
	        ),


	        array(
	        	/*====== Check Permissions FAQ (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Faq.*',
	        		'Faq.Index',
	        		'Faq.Create'
					// 'Faqtype.*',
					// 'Faqtype.Index',
					// 'Faqtype.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบคำถามที่พบบ่อย</span>',
	        	'url'=>'#Faq',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons no-js circle_question_mark'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Faq') ), 'id' => 'Faq'),
	        	'active' => self::SetSubMenu( array('Faq') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions FAQ (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'faqType.*',
	        				'faqType.Index'
	        			)),
	        			'label'=>'หมวดคำถาม'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//faqType/index')
	        		),
	        		array(
	        			/*====== Check Permissions FAQ (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'Faq.*',
	        				'Faq.index'
	        			)),
	        			'label'=>'คำถามที่พบบ่อย',
	        			'url'=>array('//Faq/index')
	        		)
	        	)
	        ),
			//====== END Menu FAQ ======//

			//====== END Menu Rights ======//
	        array(
	        	/*====== Check Permissions Category (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'Document.*',
	        		'Document.Index',
	        		'Document.Create',
	        		'Document.CreateType', 
	        	)),
	        	'label'=>'<i></i><span>เอกสาร</span>',
	        	'url'=>'#Document',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Document') ), 'id' => 'Document'),
	        	'active' => self::SetSubMenu( array('Document') ,false),
	        	'items'=>array(

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.CreateType'
	        			)),
	        			'label'=>'เพิ่มประเภทเอกสาร'." (ภาษา ".$mainLang." )",
	                	'url'=>array('//Document/createtype')//ชื่อ action
	                ),

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Index_type'
	        			)),
	        			'label'=>'จัดการประเภทเอกสาร',
	        			'url'=>array('//Document/Index_type')
	        		),

	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Create'
	        			)),
	        			'label'=>'เพิ่มเอกสาร'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//Document/create')
	        		),


	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'Document.*',
	        				'Document.Index'
	        			)),
	        			'label'=>'จัดการเอกสาร',
	        			'url'=>array('//Document/index')
	        		),
	        	)
	        ),

	        array(
	        	//////// VDO ////////
	        	'visible'=>self::PermissionsMenu(array(
	        		'vdo.*',
	        		'vdo.Index',
	        		'vdo.Create'
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>VDO</span>',
	        	'url'=>'#vdo',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons facetime_video'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('vdo') ), 'id' => 'vdo'),
	        	'active' => self::SetSubMenu( array('vdo') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Category (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'vdo.*',
	        				'vdo.Create'
	        			)),
	        			'label'=>'เพิ่มวีดีโอ'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//vdo/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Category (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'vdo.*',
	        				'vdo.Index'
	        			)),
	        			'label'=>'จัดการวีดีโอ',
	        			'url'=>array('//vdo/index')
	        		),
	        	)
	        ),

	        array(
	        	/*====== Check Permissions Rights (6) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'adminUser.*',
	        		'adminUser.Create',
	        	)) || 
	        	self::PermissionsMenu(array(
	        		'pGroup.*',
	        		'pGroup.Create',
	        	)) ||
	        	self::PermissionsMenu(array(
	        		'pController.*',
	        		'pController.Create',
	        	)),
	        	'label'=>'<i></i><span>ระบบการกำหนดสิทธิการใช้งาน</span>',
	        	'url'=>'#Rights',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons magic'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('authItem','assignment','Level') ), 'id' => 'Rights'),
	        	'active' => self::SetSubMenu( array('authItem','assignment','Level') ,false),
	        	'items'=>array(
					// array(
					// 	/*====== Check Permissions Sup-Rights (3) ======*/
					// 	'visible'=>Yii::app()->user->isSuperuser===true,
					// 	'label'=>Rights::t('core', 'Assignments'),
					// 	'url'=>array('//rights/assignment/view')
					// ),
	        		array(
	        			/*====== Check Permissions Sup-Rights (3) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'adminUser.*',
	        				'adminUser.Create'
	        			)),
	        			'label'=>'ข้อมูลผู้ดูแลระบบ',
	        			'url'=>array('//adminUser/index')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Rights (3) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'pGroup.*',
	        				'pGroup.Create'
	        			)),
	        			'label'=>'กลุ่มผู้ใช้งาน',
	        			'url'=>array('//pGroup/index')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Rights (3) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'pController.*',
	        				'pController.Create'
	        			)),
	        			'label'=>'เพิ่ม controller',
	        			'url'=>array('//pController/index')
	        		),
	        	)
	        ),

	        
	         array(
	        	/*====== Check Permissions User (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'admin.*',
	        		// 'admin.admin',
	        		// 'admin.Create',
	        	)),
	        	'label'=>'<i></i><span>ระบบจัดการสมาชิก (สมาชิก)</span>',
	        	'url'=>'#admin',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('admin') ) , 'id' => 'admin'),
	        	'active' => self::SetSubMenu( array('admin') ,false),
	        	'items'=>array(
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.membership_personal'
	        		// 	)),
	        		// 	'label'=>'อนุมัติการตรวจสอบการสมัครสำหรับบุคคลทั่วไป',
	        		// 	'url'=>array('//user/admin/membership_personal')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Membership'
	        		// 	)),
	        		// 	'label'=>'อนุมัติการตรวจสอบการสมัครสมาชิกสำหรับคนประจำเรือ',
	        		// 	'url'=>array('//user/admin/membership')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (1) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Approve'
	        		// 	)),
	        		// 	'label'=>'อนุมัติยืนยันการสมัคร',
	        		// 	'url'=>array('//user/admin/approve')
	        		// ),

	        		array(
	        			/*====== Check Permissions Sup-User (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'admin.*',
	        				'admin.Create'
	        			)),
	        			'label'=>'เพิ่มสมาชิก',
	        			'url'=>array('//user/admin/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-User (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'admin.*',
	        				'admin.Excel'
	        			)),
	        			'label'=>'เพิ่มสมาชิกจาก Excel',
	        			'url'=>array('//user/admin/excel')
	        		),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (2) ======*/
	        		// 	'visible'=>true,
	        		// 	'label'=>'รายชื่อสมาชิก(ผู้ดูแลระบบ)',
	        		// 	'url'=>array('//user/admin/admin')
	        		// ),
	        		array(
	        			/*====== Check Permissions Sup-User (2) ======*/
	        			'visible'=>true,
	        			'label'=>'รายชื่อสมาชิก',
	        			'url'=>array('//user/admin/employee')
	        		),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (2) ======*/
	        		// 	'visible'=>true,
	        		// 	'label'=>'รายชื่อสมาชิก(พนักงานประจำเรือ)',
	        		// 	'url'=>array('//user/admin/employeeShip')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (2) ======*/
	        		// 	'visible'=>true,
	        		// 	'label'=>'รายชื่อสมาชิก(สมาชิกทั่วไป)',
	        		// 	'url'=>array('//user/admin/General')
	        		// ),
	        		// array(
	        		// 	/*====== Check Permissions Sup-User (2) ======*/
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'admin.*',
	        		// 		'admin.Access'
	        		// 	)),
	        		// 	'label'=>'ระบบตรวจสอบการเข้าใช้งาน',
	        		// 	'url'=>array('//user/admin/access')
	        		// ),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'admin.*',
	        				'admin.Status',
	        			)),
	        			'label'=>'รายงานสถานะของสมาชิก',
	        			'url'=>array('//user/admin/Status')
	        		),
	        	)
	        ),

	        //  array(
	        // 	//////// print ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'monthCheck.*',
	        // 		// 'monthCheck.admin',
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบตรวจสอบการใช้งาน</span>',
	        // 	'url'=>'#monthCheck',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_open'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('monthCheck') ), 'id' => 'monthCheck'),
	        // 	'active' => self::SetSubMenu( array('monthCheck') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'monthCheck.*',
	        // 				'monthCheck.admin'
	        // 			)),
	        // 			'label'=>'กำหนดระยะเวลาในการเข้าใช้งานคนประจำเรือ',
	        // 			'url'=>array('//monthCheck/admin')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'monthCheck.*',
	        // 				'monthCheck.approve'
	        // 			)),
	        // 			'label'=>'กำหนดระยะเวลาในการเข้าใช้งานบุคคลทั่วไป',
	        // 			'url'=>array('//monthCheck/personal')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-User (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'admin.*',
	        // 				'admin.Access'
	        // 			)),
	        // 			'label'=>'ระบบตรวจสอบการเข้าใช้งานคนประจำเรือ',
	        // 			'url'=>array('//user/admin/access')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-User (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'admin.*',
	        // 				'admin.AccessPersonal'
	        // 			)),
	        // 			'label'=>'ระบบตรวจสอบการเข้าใช้งานคนบุคคลทั่วไป',
	        // 			'url'=>array('//user/admin/accessPersonal')
	        // 		),
	        // 	)
	        // ),
            array(
	        	//////// SlideImg ////////
	        	'visible'=>self::PermissionsMenu(array(
	        		'imgslide.*',
	        		'imgslide.Index',
	        		'imgslide.Create'
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>ระบบป้ายประชาสัมพันธ์</span>',
	        	'url'=>'#imgslide',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons bullhorn'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('imgslide') ), 'id' => 'imgslide'),
	        	'active' => self::SetSubMenu( array('imgslide') ,false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-Category (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'imgslide.*',
	        				'imgslide.Create'
	        			)),
	        			'label'=>'เพิ่มป้ายประชาสัมพันธ์'." (ภาษา ".$mainLang." )",
	        			'url'=>array('//imgslide/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-Category (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'imgslide.*',
	        				'imgslide.Index'
	        			)),
	        			'label'=>'จัดการป้ายประชาสัมพันธ์',
	        			'url'=>array('//imgslide/index')
	        		),
	        	)
	        ),

	        // array(
	        // 	//////// GalleryType ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'GalleryType.*',
	        // 		'GalleryType.Index',
	        // 		'GalleryType.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>ประเภทแกลลอรี่</span>',
	        // 	'url'=>'#GalleryType',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('GalleryType') ), 'id' => 'GalleryType'),
	        // 	'active' => self::SetSubMenu( array('GalleryType') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryType.*',
	        // 				'GalleryType.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มประเภทแกลลอรี่',
	        // 			'url'=>array('//GalleryType/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryType.*',
	        // 				'GalleryType.Index'
	        // 			)),
	        // 			'label'=>'จัดการประเภทแกลลอรี่',
	        // 			'url'=>array('//GalleryType/index')
	        // 		),
	        		
	        // 	)
	        // ),
	       

	        // array(
	        // 	//////// Gallery ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Gallery.*',
	        // 		'Gallery.Index',
	        // 		'Gallery.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>แกลลอรี่</span>',
	        // 	'url'=>'#Gallery',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Gallery') ), 'id' => 'Gallery'),
	        // 	'active' => self::SetSubMenu( array('Gallery') ,false),
	        // 	'items'=>array(

	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Gallery.*',
	        // 				'Gallery.create'
	        // 			)),
	        // 			'label'=>'เพิ่มแกลลอรี่',
	        // 			'url'=>array('//Gallery/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Gallery.*',
	        // 				'Gallery.Index'
	        // 			)),
	        // 			'label'=>'จัดการแกลลอรี่',
	        // 			'url'=>array('//Gallery/Index')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	//////// Gallery ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'GalleryGroup.*',
	        // 		'GalleryGroup.Index',
	        // 		'GalleryGroup.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>แกลลอรี่</span>',
	        // 	'url'=>'#GalleryGroup',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('GalleryGroup') ), 'id' => 'GalleryGroup'),
	        // 	'active' => self::SetSubMenu( array('GalleryGroup') ,false),
	        // 	'items'=>array(

	        // 		// array(
	        // 		// 	'visible'=>self::PermissionsMenu(array(
	        // 		// 		'GalleryGroup.*',
	        // 		// 		'GalleryGroup.create'
	        // 		// 	)),
	        // 		// 	'label'=>'เพิ่มแกลลอรี่',
	        // 		// 	'url'=>array('//GalleryGroup/create')
	        // 		// ),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'GalleryGroup.*',
	        // 				'GalleryGroup.Index'
	        // 			)),
	        // 			'label'=>'จัดการแกลลอรี่',
	        // 			'url'=>array('//GalleryGroup/Index')
	        // 		),
	        // 	)
	        // ),

	        array(
	        	'visible'=>self::PermissionsMenu(array(
	        		'LibraryType.*',
	        		'LibraryFile.*',
	        	)),
	        	'label'=>'<span class="label label-primary"></span> <i></i><span>ห้องสมุด</span>',
	        	'url'=>'#LibraryType',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons posterous_spaces'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('LibraryType', 'LibraryFile') ), 'id' => 'LibraryType'),
	        	'active' => self::SetSubMenu( array('LibraryType', 'LibraryFile') ,false),
	        	'items'=>array(
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'LibraryType.Index'
	        			)),
	        			'label'=>'จัดการประเภทห้องสมุด',
	        			'url'=>array('//LibraryType/index')
	        		),
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'LibraryFile.Index'
	        			)),
	        			'label'=>'จัดการห้องสมุด',
	        			'url'=>array('//LibraryFile/index')
	        		),
	        		array(
	        			'visible'=>self::PermissionsMenu(array(
	        				'LibraryFile.download'
	        			)),
	        			'label'=>'จัดการการอนุมัติการดาวน์โหลด',
	        			'url'=>array('//LibraryFile/download')
	        		),
	        		
	        	)
	        ),
	        

	        // array(
	        // 	//////// MainImage ////////
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Mainimage.*',
	        // 		'Mainimage.Index',
	        // 		'Mainimage.Create'
	        // 	)),
	        // 	'label'=>'<span class="label label-primary"></span> <i></i><span>รูปภาพโฆษณา</span>',
	        // 	'url'=>'#Mainimage',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons bullhorn'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Mainimage') ), 'id' => 'Mainimage'),
	        // 	'active' => self::SetSubMenu( array('Mainimage') ,false),
	        // 	'items'=>array(

	        // 		array(
	        // 			/*====== Check Permissions Sup-Category (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Mainimage.*',
	        // 				'Mainimage.Index'
	        // 			)),
	        // 			'label'=>'จัดการรูปภาพโฆษณา',
	        // 			'url'=>array('//Mainimage/index')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	/*====== Check Permissions Rights (6) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Privatemessage.*',
	        // 		'Privatemessage.update',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบข้อความส่วนตัว</span>',
	        // 	'url'=>'#privatemessage',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons wallet'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('privatemessage') ), 'id' => 'privatemessage'),
	        // 	'active' => self::SetSubMenu( array('privatemessage') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-Rights (3) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Privatemessage.*',
	        // 			)),
	        // 			'label'=>'ข้อความส่วนตัว',
	        // 			'url'=>array('//Privatemessage/index')
	        // 		),
	        // 	)
	        // ),



			// array(
			// 	/*====== Check Permissions User (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Generation.*',
			// 		'Generation.Create',
			// 		'Generation.index',
			// 	)),
			// 	'label'=>'<i></i><span>ระบบจัดการรุ่นสมาชิก</span>',
			// 	'url'=>'#generation',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('generation') ) , 'id' => 'generation'),
			// 	'active' => self::SetSubMenu( array('generation') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-User (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Generation.*',
			// 				'Generation.Create'
			// 			)),
			// 			'label'=>'สร้างรุ่น',
			// 			'url'=>array('//Generation/create')
			// 		),
			// 		array(
			// 			/*====== Check Permissions Sup-User (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Generation.*',
			// 				'Generation.index'
			// 			)),
			// 			'label'=>'จัดการรุ่น',
			// 			'url'=>array('//Generation/index')
			// 		),
			// 	)
			// ),

			// array(
			// 	/*====== Check Permissions Teacher (2) ======*/
			// 	'visible'=>self::PermissionsMenu(array(
			// 		'Teacher.*',
			// 		'Teacher.Index',
			// 		'Teacher.Create'
			// 	)),
			// 	'label'=>'<i></i><span>ระบบรายชื่อวิทยากร</span>',
			// 	'url'=>'#Teacher',
			// 	'linkOptions' => array('data-toggle' => 'collapse'),
			// 	'itemOptions' => array('class' => 'hasSubmenu glyphicons old_man'),
			// 	'submenuOptions' => array('class' => self::SetSubMenu( array('Teacher') ), 'id' => 'Teacher'),
			// 	'active' => self::SetSubMenu( array('Teacher') ,false),
			// 	'items'=>array(
			// 		array(
			// 			/*====== Check Permissions Sup-Teacher (1) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Teacher.*',
			// 				'Teacher.Create'
			// 			)),
			// 			'label'=>'เพิ่มรายชื่อวิทยากร',
			// 			'url'=>array('//Teacher/create')
			// 		),
			// 		array(
			// 			/*====== Check Permissions Sup-Teacher (2) ======*/
			// 			'visible'=>self::PermissionsMenu(array(
			// 				'Teacher.*',
			// 				'Teacher.Index'
			// 			)),
			// 			'label'=>'จัดการรายชื่อวิทยากร',
			// 			'url'=>array('//Teacher/index')
			// 		),
			// 	)
			// ),
			//====== END Menu Teacher ======//

			//====== END Menu Group Contactus ======//
			
	        array(
	        	/*====== Check Permissions Setting (1)  ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'courseNotification.*',
	        		'courseNotification.Create'
	        	)),
	        	'label'=>'<i></i><span>ระบบตั้งค่าการแจ้งเตือนบทเรียน</span>',
	        	'url'=>'#courseNotification',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons cogwheel'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('courseNotification') ) , 'id' => 'courseNotification'),
	        	'active' => self::SetSubMenu(array('courseNotification'),false),
	        	'items'=>array(
	        		array(
	        			/*====== Check Permissions Sup-courseNotification (1) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'courseNotification.*',
	        				'courseNotification.Create'
	        			)),
	        			'label'=>'สร้างระบบแจ้งเตือนบทเรียน',
	        			'url'=>array('//courseNotification/create')
	        		),
	        		array(
	        			/*====== Check Permissions Sup-courseNotification (2) ======*/
	        			'visible'=>self::PermissionsMenu(array(
	        				'courseNotification.*',
	        				'courseNotification.index'
	        			)),
	        			'label'=>'จัดการระบบแจ้งเตือนบทเรียน',
	        			'url'=>array('//courseNotification/index')
	        		),
	        	)
	        ),
	         
         //    array(
	        // 	/*====== Check Permissions Department (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Department.*',
	        // 		'Department.admin',
	        // 		'Department.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>แผนก</span>',
	        // 	'url'=>'#Department',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Department') ), 'id' => 'Department'),
	        // 	'active' => self::SetSubMenu( array('Department') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Position (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Department.*',
	        // 				'Department.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มแผนก',
	        // 			'url'=>array('//Department/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Department.*',
	        // 				'Department.admin'
	        // 			)),
	        // 			'label'=>'จัดการแผนก',
	        // 			'url'=>array('//Department/admin')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	/*====== Check Permissions Position (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Position.*',
	        // 		'Position.admin',
	        // 		'Position.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ตำแหน่ง</span>',
	        // 	'url'=>'#Position',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Position') ), 'id' => 'Position'),
	        // 	'active' => self::SetSubMenu( array('Position') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Position (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Position.*',
	        // 				'Position.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มตำแหน่ง',
	        // 			'url'=>array('//Position/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Position.*',
	        // 				'Position.index'
	        // 			)),
	        // 			'label'=>'จัดการตำแหน่ง',
	        // 			'url'=>array('//Position/index')
	        // 		),
	        // 	)
	        // ),

	        // array(
	        // 	/*====== Check Permissions Position (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Branch.*',
	        // 		'Branch.admin',
	        // 		'Branch.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>Level(ตำแหน่ง office)</span>',
	        // 	'url'=>'#Branch',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Branch') ), 'id' => 'Branch'),
	        // 	'active' => self::SetSubMenu( array('Branch') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Branch (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Branch.*',
	        // 				'Branch.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มLevel',
	        // 			'url'=>array('//Branch/create')
	        // 		),
	        // 		array(
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Branch.*',
	        // 				'Branch.index'
	        // 			)),
	        // 			'label'=>'จัดการLevel',
	        // 			'url'=>array('//Branch/index')
	        // 		),
	        // 	)
	        // ),
	         array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Passcours.*',
	        	)),
	        	'label'=>'<i></i><span>ระบบพิมพ์ใบประกาศนียบัตร</span>',
	        	'url'=>'#Passcours',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Passcours') ), 'id' => 'Passcours'),
	        	'active' => self::SetSubMenu( array('Passcours') ,false),
	        	'items'=>array(
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Passcours.*',
	        				'Passcours.index',
	        			)),
	        			'label'=>'รายงานผู้ผ่านการเรียน',
	        			'url'=>array('//Passcours/index')
	        		),
	        	    array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Passcours.*',
	        				'Passcours.PasscoursLog',
	        			)),
	        			'label'=>'รายงานสถิติจำนวนผู้พิมพ์ใบประกาศฯ',
	        			'url'=>array('//Passcours/PasscoursLog')
	        		),
	        		
	        	)
	        ),
            //====== END Menu FormSurveyGroup ======//
	        array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Report.*',
	        	)),
	        	'label'=>'<i></i><span>ระบบ ติดตามผู้เรียน</span>',
	        	'url'=>'#ReportFollow',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Report') ), 'id' => 'ReportFollow'),
	        	'active' => self::SetSubMenu( array('Report') ,false),
	        	'items'=>array(
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'1.) ข้อมูลการฝึกอบรมของพนักงานรายบุคคล',
	        			'url'=>array('//Report/Status')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'2.) ค้นหาโดยใช้หลักสูตร',
	        			'url'=>array('//Report/ByCourse')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'3.) ค้นหาโดยใช้บทเรียน',
	        			'url'=>array('//Report/ByLesson')
	        		),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Report.*',
	        		// 	)),
	        		// 	'label'=>'4.) รายงานติดตามผู้เรียนรายบุคคล',
	        		// 	'url'=>array('//Report/ByUser')
	        		// ),
	        		// array(
	        		// 	
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Report.*',
	        		// 	)),
	        		// 	'label'=>'5.) รายงานผู้ประเมินระดับผู้เรียนรายบุคคล',
	        		// 	'url'=>array('//Report/Individual')
	        		// 	//'url'=>array('//Report/score')
	        		// ),

	        	)
	        ),


	        // array(	        	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'ReportAuthority.*'
	        // 	)),
	        // 	'label'=>'<i></i><span>กำหนดสิทธิ์ Report หน้าบ้าน</span>',
	        // 	'url'=>'#ReportAuthority',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons user_add'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('ReportAuthority', ) ), 'id' => 'ReportAuthority'),
	        // 	'active' => self::SetSubMenu( array('ReportAuthority', ) ,false),
	        // 	'items'=>array(
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.Board',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้บริหาร',
	        // 			'url'=>array('//ReportAuthority/Board')
	        // 		),
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.DivisionManager',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้จัดการฝ่าย',
	        // 			'url'=>array('//ReportAuthority/DivisionManager')
	        // 		),
	        // 		array(	        			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'ReportAuthority.DepartmentManager',
	        // 			)),
	        // 			'label'=>'จัดการ ผู้จัดการแผนก',
	        // 			'url'=>array('//ReportAuthority/DepartmentManager')
	        // 		),
	        // 	)
	        // ),


	        array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'Report.*'
	        	)),
	        	'label'=>'<i></i><span>ระบบ Report</span>',
	        	'url'=>'#Report',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('Report', 'Questionnaire') ), 'id' => 'Report'),
	        	'active' => self::SetSubMenu( array('Report', 'Questionnaire') ,false),
	        	'items'=>array(
					//set new menu	
					// array(
	        			
	    //     			'visible'=>self::PermissionsMenu(array(
					// 		'Report.*',
	    //     			)),
	    //     			'label'=>'1.) รายงานภาพรวมการสมัครสมาชิก',
	    //     			'url'=>array('//Report/logAllRegister')
					// ),			
	    //     		array(
	        			
	    //     			'visible'=>self::PermissionsMenu(array(
	    //     				'admin.*',
	    //     			)),
	    //     			'label'=>'2.) รายงานผลการสมัครสมาชิก (ผู้เรียน)',
	    //     			'url'=>array('//user/admin/Status')
	    //     		),

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'1.) รายงานภาพรวมของหลักสูตร',
	        			'url'=>array('//Report/AttendPrint')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'2.) รายงานการฝึกอบรมหลักสูตร',
	        			'url'=>array('//Report/ByCourseDetail')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'3.) รายงานติดตามผู้เรียน',
	        			'url'=>array('//Report/ByUser')
	        		),

	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
							'Report.*',
	        			)),
	        			'label'=>'4.) รายงานแบบสอบถามสำหรับหลักสูตร',
	        			'url'=>array('//Report/logQuestioncourse')
					),
					array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
							'Report.*',
	        			)),
	        			'label'=>'5.) รายงานภาพรวมแบบสอบถาม',
	        			'url'=>array('//Report/logQuestionall')
					),
					array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'Report.*',
	        			)),
	        			'label'=>'6.) รายงานการรีเซตหลักสูตร',
	        			'url'=>array('//Report/logReset')
					),

	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Report.*',
	        		// 	)),
	        		// 	'label'=>'3.) รายงานผลสอบ',
	        		// 	'url'=>array('//Report/BeforAndAfter')
	        		// ),
	        		// array(
	        		// 	
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Passcours.*',
	        		// 	)),
	        		// 	'label'=>'4.) รายงานผู้ผ่านการเรียน',
	        		// 	'url'=>array('//Passcours/index')
	        		// ),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Passcours.*',
	        		// 	)),
	        		// 	'label'=>'5.) รายงานสถิติจำนวนผู้พิมพ์ใบประกาศฯ',
	        		// 	'url'=>array('//Passcours/PasscoursLog')
	        		// ),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'Questionnaire.*',
	        		// 	)),
	        		// 	'label'=>'6.) รายงานแบบสอบถามสำหรับใช้ภายนอก',
	        		// 	'url'=>array('//Questionnaire/Report_list')
	        		// ),
					
					// array(
	        			
	    //     			'visible'=>self::PermissionsMenu(array(
					// 		'Report.*',
	    //     			)),
	    //     			'label'=>'9.) รายงานการสมัครสมาชิก',
	    //     			'url'=>array('//Report/logRegister')
					// ),
					
	        	)
	        ),
    //         array(
	   //      	/*====== Check Permissions PopUp (2) ======*/
	   //      	'visible'=>self::PermissionsMenu(array(
	   //      		'LogEmail.*',
	   //      		'LogEmail.email'
	   //      	)),
	   //      	'label'=>'<i></i><span>web service</span>',
	   //      	'url'=>array(),
				// //'linkOptions' => array('data-toggle' => 'collapse'),
	   //      	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	   //      	'submenuOptions' => array('class' => self::SetSubMenu( array('LogEmail') ), 'id' => 'LogEmail'),
	   //      ),
			//====== END Menu Information ======//
	       

	        // array(
	        // 	
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Captcha.*',
	        // 		'Captcha.update',
	        // 	)),
	        // 	'label'=>'<i></i><span>ระบบ ตั้งค่า Captcha</span>',
	        // 	'url'=>'#Captcha',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Captcha') ), 'id' => 'Captcha'),
	        // 	'active' => self::SetSubMenu( array('Captcha') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Captcha.*',
	        // 				'Captcha.update'
	        // 			)),
	        // 			'label'=>'ตั้งค่า Captcha',
	        // 			'url'=>array('//Captcha/index')
	        // 		)
	        // 	)
			// ),

	        // array(
	        // 	/*====== Check Permissions Company (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Company.*',
	        // 		'Company.admin',
	        // 		'Company.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>ฝ่าย</span>',
	        // 	'url'=>'#Company',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Company') ), 'id' => 'Company'),
	        // 	'active' => self::SetSubMenu( array('Company') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Company.*',
	        // 				'Company.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มฝ่าย'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//Company/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Company.*',
	        // 				'Company.admin'
	        // 			)),
	        // 			'label'=>'จัดการฝ่าย',
	        // 			'url'=>array('//Company/admin')
	        // 		),
	        // 	)
	        // ),
	        // array(
	        // 	/*====== Check Permissions Company (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'Station.*',
	        // 		'Station.admin',
	        // 		'Station.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>สถานี</span>',
	        // 	'url'=>'#Station',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('Station') ), 'id' => 'Station'),
	        // 	'active' => self::SetSubMenu( array('Station') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Station.*',
	        // 				'Station.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มสถานี'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//Station/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions Sup-PopUp (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'Station.*',
	        // 				'Station.admin'
	        // 			)),
	        // 			'label'=>'จัดการสถานี',
	        // 			'url'=>array('//Station/admin')
	        // 		),
	        // 	)
	        // ),
	        // array(
	        // 	/*====== Check Permissions division (2) ======*/
	        // 	'visible'=>self::PermissionsMenu(array(
	        // 		'division.*',
	        // 		'division.admin',
	        // 		'division.Create'
	        // 	)),
	        // 	'label'=>'<i></i><span>กอง</span>',
	        // 	'url'=>'#division',
	        // 	'linkOptions' => array('data-toggle' => 'collapse'),
	        // 	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        // 	'submenuOptions' => array('class' => self::SetSubMenu( array('division') ), 'id' => 'division'),
	        // 	'active' => self::SetSubMenu( array('division') ,false),
	        // 	'items'=>array(
	        // 		array(
	        // 			/*====== Check Permissions division (1) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'division.*',
	        // 				'division.Create'
	        // 			)),
	        // 			'label'=>'เพิ่มกอง'." (ภาษา ".$mainLang." )",
	        // 			'url'=>array('//division/create')
	        // 		),
	        // 		array(
	        // 			/*====== Check Permissions division (2) ======*/
	        // 			'visible'=>self::PermissionsMenu(array(
	        // 				'division.*',
	        // 				'division.admin'
	        // 			)),
	        // 			'label'=>'จัดการกอง',
	        // 			'url'=>array('//division/admin')
	        // 		),
	        // 	)
	        // ),
			//====== END Menu Company ======//

	        array(
	        	/*====== Check Permissions PopUp (2) ======*/
	        	'visible'=>self::PermissionsMenu(array(
	        		'LogEmail.*',
	        		'LogEmail.email'
	        	)),
	        	'label'=>'<i></i><span>ระบบการส่งผลการเรียนผ่านทางระบบอัตโนมัติ</span>',
	        	'url'=>array('//LogEmail/email'),
				//'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons folder_new'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('LogEmail') ), 'id' => 'LogEmail'),
	        ),

	        array(
	        	
	        	'visible'=>self::PermissionsMenu(array(
	        		'LogAdmin.*',
	        		// 'LogAdmin.update',
	        	)),
	        	'label'=>'<i></i><span>ระบบเก็บ Log การใช้งานระบบ</span>',
	        	'url'=>'#LogAdmin',
	        	'linkOptions' => array('data-toggle' => 'collapse'),
	        	'itemOptions' => array('class' => 'hasSubmenu glyphicons print'),
	        	'submenuOptions' => array('class' => self::SetSubMenu( array('LogAdmin') ), 'id' => 'LogAdmin'),
	        	'active' => self::SetSubMenu( array('LogAdmin') ,false),
	        	'items'=>array(
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'LogAdmin.*',
	        				'LogAdmin.users'
	        			)),
	        			'label'=>'Log การใช้งานผู้เรียน',
	        			'url'=>array('//logAdmin/users')
	        		),
	        		array(
	        			
	        			'visible'=>self::PermissionsMenu(array(
	        				'LogAdmin.*',
	        				'LogAdmin.index'
	        			)),
	        			'label'=>'Log การใช้งานผู้ดูแลระบบ',
	        			'url'=>array('//logAdmin/index')
	        		),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'LogAdmin.*',
	        		// 		'LogAdmin.approve'
	        		// 	)),
	        		// 	'label'=>'Log การยืนยันสมัครสมาชิก',
	        		// 	'url'=>array('//logAdmin/approve')
	        		// ),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'LogAdmin.*',
	        		// 		'LogAdmin.approvePersonal'
	        		// 	)),
	        		// 	'label'=>'Log การยืนยันสมัครสมาชิกบุคคลทั่วไป',
	        		// 	'url'=>array('//logAdmin/approvePersonal')
	        		// ),
	        		// array(
	        			
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'LogAdmin.*',
	        		// 		'LogAdmin.register'
	        		// 	)),
	        		// 	'label'=>'Log การตรวจสอบการสมัครสมาชิก',
	        		// 	'url'=>array('//logAdmin/register')
	        		// ),
	        		// array(
	        		// 	
	        		// 	'visible'=>self::PermissionsMenu(array(
	        		// 		'LogAdmin.*',
	        		// 		'LogAdmin.api'
	        		// 	)),
	        		// 	'label'=>'Log การส่งข้อมูล API',
	        		// 	'url'=>array('//logAdmin/api')
	        		// )
	        	)
	        ),


	    );



}
}
