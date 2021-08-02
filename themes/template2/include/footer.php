<footer class="footer">
	<div class="pt-2 pb-2 text-gray">
		<div class="container">
			<small class="text-white"> Copyright <span class="sans-font">©</span> 2021 ISUZU Motors (Thailand) Co., Ltd.</small>
			<small class="pull-right">
					<a href="<?= $this->createUrl("dashboard/terms") ?>" class="text-white a-main">
						<?php
						if (Yii::app()->session['lang'] == 1) {
							echo "Terms & Conditions";
						} else {
							echo "ข้อกำหนด & เงื่อนไข";
						}
						?>
					</a>
			</small>
		</div>
</footer>