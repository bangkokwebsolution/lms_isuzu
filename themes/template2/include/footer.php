<footer class="footer">
	<div class="pt-2 pb-2 text-gray">
		<div class="container">
			<small class="text-white"> Copyright <span class="sans-font">©</span> 2021 ISUZU Motors (Thailand) Co., Ltd.</small>
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

			<small class="test-small">
				<a href="#user-report" data-toggle="modal"  style="color:white" > Report Problem  </a>
					<!-- <div id="mascot-contact">
						<img src="/lms_isuzu/themes/template2/images/mascot-report-en.png" alt="">
					</div> -->
			</small>

			
		</div>
</footer>