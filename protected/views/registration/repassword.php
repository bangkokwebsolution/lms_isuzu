<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login"); ?>

<style type="text/css">
	.errorMessage {
		color: #f00;
	}

	.sa {
		width: 140px;
		height: 140px;
		padding: 26px;
		margin-left: auto;
		margin-right: auto;
		/*background-color: #fff;*/
	}

	.sa-success {
		border-radius: 50%;
		border: 4px solid #A5DC86;
		box-sizing: content-box;
		height: 80px;
		padding: 0;
		position: relative;
		background-color: #fff;
		width: 80px;
	}

	.sa-success:after,
	.sa-success:before {
		/*background: #fff;*/
		content: '';
		height: 120px;
		position: absolute;
		transform: rotate(45deg);
		width: 60px;
	}

	.sa-success:before {
		border-radius: 40px 0 0 40px;
		width: 26px;
		height: 80px;
		top: -17px;
		left: 5px;
		transform-origin: 60px 60px;
		transform: rotate(-45deg);
	}

	.sa-success:after {
		border-radius: 0 120px 120px 0;
		left: 30px;
		top: -11px;
		transform-origin: 0 60px;
		transform: rotate(-45deg);
		animation: rotatePlaceholder 4.25s ease-in;
	}

	.sa-success-placeholder {
		border-radius: 50%;
		border: 4px solid rgba(165, 220, 134, 0.25);
		box-sizing: content-box;
		height: 80px;
		left: -4px;
		position: absolute;
		top: -4px;
		width: 80px;
		z-index: 2;
	}

	.sa-success-fix {
		/*background-color: #fff;*/
		height: 90px;
		left: 28px;
		position: absolute;
		top: 8px;
		transform: rotate(-45deg);
		width: 5px;
		z-index: 1;
	}

	.sa-success-tip,
	.sa-success-long {
		background-color: #A5DC86;
		border-radius: 2px;
		height: 5px;
		position: absolute;
		z-index: 2;
	}

	.sa-success-tip {
		left: 14px;
		top: 46px;
		transform: rotate(45deg);
		width: 25px;
		animation: animateSuccessTip .75s;
	}

	.sa-success-long {
		right: 8px;
		top: 38px;
		transform: rotate(-45deg);
		width: 47px;
		animation: animateSuccessLong .75s;
	}

	@keyframes animateSuccessTip {

		0%,
		54% {
			width: 0;
			left: 1px;
			top: 19px;
		}

		70% {
			width: 50px;
			left: -8px;
			top: 37px;
		}

		84% {
			width: 17px;
			left: 21px;
			top: 48px;
		}

		100% {
			width: 25px;
			left: 14px;
			top: 45px;
		}
	}

	@keyframes animateSuccessLong {

		0%,
		65% {
			width: 0;
			right: 46px;
			top: 54px;
		}

		84% {
			width: 55px;
			right: 0;
			top: 35px;
		}

		100% {
			width: 47px;
			right: 8px;
			top: 38px;
		}
	}

	@keyframes rotatePlaceholder {

		0%,
		5% {
			transform: rotate(-45deg);
		}

		100%,
		12% {
			transform: rotate(-405deg);
		}
	}
</style>

<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-main">
			<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= Yii::app()->session['lang'] == 1 ? 'Home' : 'หน้าหลัก'; ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?= Yii::app()->session['lang'] == 1 ? 'Change password' : 'เปลี่ยนรหัสผ่าน'; ?></li>
		</ol>
	</nav>
</div>
<!-- Content -->
<section class="content" id="contact-us">
	<div class="container">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			'action' => Yii::app()->createUrl('registration/Repassword'),
		));
		?>
		<div class="well">
			<h3 class="text-center" style="margin-bottom: 3rem;"><b><?php //echo Yii::app()->session['lang'] == 1?'Change password':'เปลี่ยนรหัสผ่าน'; 
																	?><?php echo 'เปลี่ยนรหัสผ่าน / Change password'; ?></b></h3>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="form-group">
						<label for=""><?php //echo Yii::app()->session['lang'] == 1?'New password':'รหัสผ่านใหม่'; 
										?><?php echo 'รหัสผ่านใหม่ / New password'; ?></label><br>
						<?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg', 'required' => true)); ?>
						<?php echo $form->error($model, 'password'); ?>
						<br>
						<label for=""><?php //echo  Yii::app()->session['lang'] == 1?'Confirm new password':'ยืนยันรหัสผ่านใหม่'; 
										?><?php echo 'ยืนยันรหัสผ่านใหม่ / Confirm new password'; ?></label><br>
						<?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control input-lg', 'required' => true)); ?>
						<?php echo $form->error($model, 'verifyPassword'); ?>

						<?php echo $form->hiddenField($model, 'id', array('class' => 'form-control input-lg', 'hidden')); ?>
					</div>
				</div>
			</div>

			<div class="text-center">
				<!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
				<?php echo CHtml::submitButton('ยืนยัน / Confirm', array('class' => 'btn btn-warning btn-lg')); ?>
			</div>
		</div>
		<div class="row">
			<div class="form-group" style="padding-right:15px;padding-left:15px">
				ข้อแนะนำในการตั้งรหัสผ่าน<br>
				1.การเข้าใช้งานครั้งแรกให้ผู้ใช้งาน (user) ระบุชื่อผู้ใช้และรหัสผ่านตามอีเมล์ข้างต้นที่ได้รับ และระบบจะบังคับให้เปลี่ยนรหัสผ่านทันที หลังจากการเข้าใช้งานครั้งแรก<br>
				2.การตั้งรหัสผ่านควรจะมีจำนวน 6 ตัวอักษรขึ้นไป<br>
				3.ไม่ควรใช้ข้อมูลส่วนตัว หรือข้อมูลที่คาดเดาได้ง่าย เช่น วันเดือนปีเกิดหรือเลขที่บัตรประชาชน มาตั้งรหัสผ่าน<br>
				4.รายงานต่อเจ้าหน้าที่ดูแลระบบทันที เมื่อผู้ใช้งาน (user) คาดว่าชื่อผู้ใช้และรหัสผ่านของตนเองถูกผู้อื่นนำไปใช้งานโดยไม่ได้รับอนุญาต พร้อมกับเปลี่ยนรหัสผ่านโดยทันที

			</div>
		</div>
		<?php $this->endWidget();
		?>
	</div>
</section>