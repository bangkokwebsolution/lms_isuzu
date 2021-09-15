<footer class="footer">
	<div class="pt-2 pb-2 text-gray">
		<div class="container">
			<small class="text-white copyright"> Copyright <span class="sans-font">©</span> 2021 ISUZU Motors (Thailand) Co., Ltd.</small>
			<small class="terms-con">
				<a href="<?= $this->createUrl("dashboard/terms") ?>" target="_blank" class="">
					<?php
					if (Yii::app()->session['lang'] == 1) {
						echo "Terms & Conditions";
					} else {
						echo "ข้อกำหนด & เงื่อนไข";
					}
					?>
				</a>
			</small>
			<small class="report-small">
				<a href="#user-report" data-toggle="modal" style="color:white">
					<i class="fa fa-info"></i>&nbsp;
					<?php
					if (Yii::app()->session['lang'] == 1) {
						echo "Report Problem";
					} else {
						echo "แจ้งปัญหาการใช้งาน";
					}
					?></a>
			</small>
		</div>
</footer>