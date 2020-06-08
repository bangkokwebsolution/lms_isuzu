<?php
$strExcelFileName="ข้อสอบ_บทเรียน_".date("YmdHis").".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<h1 style="font-family: 'TH SarabunPSK';">ชุดข้อสอบบทเรียน <?= $grouptesting->group_title; ?></h1>
	<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
		<table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="font-family: 'TH SarabunPSK'; font-size: 16pt; border-collapse:collapse">
			<thead>
				<tr>
					<th style="text-align: center; vertical-align: middle;" width="400" align="center" valign="middle"><strong>คำถาม</strong></th>
					<th style="text-align: center; vertical-align: middle;" width="100" align="center" valign="middle"><strong>ประเภท</strong></th>
					<?php 
					$num_col = 0;
					foreach ($question as $key => $value) {
						if($num_col < count($value->choices)){
							$num_col = count($value->choices);
						}
					}
					for ($i=1; $i <= $num_col; $i++) {
						?>
						<th style="text-align: center; vertical-align: middle;" align="center" valign="middle" width="200"><strong>ตัวเลือกที่ <?= $i ?></strong></th>
						<?php
					}
					 ?>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<?php 			
			foreach ($question as $key => $value_q) {
				?>
				<tr>
					<td style="text-align: center; vertical-align: middle;" align="center" valign="middle" ><?= $value_q->ques_title; ?></td>
					<?php 
					if($value_q->ques_type == 1){
						$text = "หลายคำตอบ";
					}elseif($value_q->ques_type == 2){
						$text = "คำตอบเดียว";
					}elseif($value_q->ques_type == 3){
						$text = "บรรยาย";
					}elseif($value_q->ques_type == 4){
						$text = "จับคู่";
					}elseif($value_q->ques_type == 6){
						$text = "จัดเรียง";
					}else{
						$text = $value_q->ques_type;
					}
					 ?>
					 <td style="text-align: center; vertical-align: middle;" align="center" valign="middle" ><?= $text; ?></td>
					<?php 
					foreach ($value_q->choices as $key => $value_c) {
						if($value_c->choice_answer == 1){
							$text = "font-weight:bold; background-color:yellow;";
						}else{
							$text = "";
						}
						if($value_c->reference != ""){
							$text2 = "font-weight:bold; background-color:yellow;";
						}else{
							$text2 = "";
						}
						?>
						<td style="text-align: center; vertical-align: middle; <?= $text ?> <?= $text2 ?>" align="center" valign="middle"><?= $value_c->choice_detail; ?></td>
						<?php
					}
					 ?>
				</tr>
				<?php
			}

			?>			
		</tbody>
	</table>
</div>
</body>
</html>
<script>
	window.onbeforeunload = function(){
		return false;
	};
	setTimeout(function(){
		window.close();
	}, 10000);
</script>