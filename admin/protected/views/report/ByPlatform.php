<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$title = 'รายงานการเข้าใช้งานผ่านอุปกรณ์ต่างๆ';
$currentModel = 'Report';

$this->breadcrumbs = array($title);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

?>
<div class="innerLR">
    <div class="widget">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $title;?></h4>
        </div>
        <div class="widget-body">
            <?php 
                 $this->widget('AGridView', array(
					'id' => 'staticDevice',
					'dataProvider' => $model->ByPlatform(),
                    'columns' => array(
                        array(
                            'header' => 'อุปกรณ์',
                            'type' => 'raw',
                            'value' => function($data) {
                                $deviceIcon = array(
                                    'Desktop' => 'fa fa-desktop',
                                    'Mobile Device' => 'fa fa-mobile',
                                    'Mobile Phone' => 'fa fa-mobile',
                                    'Tablet' => 'fa fa-table',
                                    'unknown' => 'fa fa-question-circle',
                                );
                                return '<i class="' . $deviceIcon[$data['user_device']]. '"></i> ' .$data['user_device'];
                            }
                        ),
                        array(
                            'header' => 'จำนวนผู้ใช้งาน',
                            'value' => function($data) {
                                $user_browser = Platform::model()->findAll(array(
                                    'condition' => 'user_device = "' . $data['user_device'] . '"',
                                    'group' => 'user_id'
                                ));
                                return count($user_browser);
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px;'
                            ),
                        ),
                        array(
                            'header' => 'จำนวนครั้ง',
                            'value' => function($data) {
                                $user_browser = Platform::model()->findAll(array(
                                    'condition' => 'user_device = "' . $data['user_device'] . '"',
                                ));
                                return count($user_browser);
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px;'
                            ),
                        ),
                    ),
                ));
            ?>
        </div>
        <div class="widget-body">
        <?php 
                 $this->widget('AGridView', array(
					'id' => 'staticBrowser',
					'dataProvider' => $model->ByPlatformBrowser(),
                    'columns' => array(
                        array(
                            'header' => 'บราวเซอร์',
                            'type' => 'raw',
                            'value' => function($data) {
                                $deviceIcon = array(
                                    'Chrome' => 'fa fa-chrome',
                                    'IE' => 'fa fa-internet-explorer',
                                    'Firefox' => 'fa fa-firefox',
                                    'Safari' => 'fa fa-safari',
                                    'Android'=> 'fa fa-android',
                                    'Android WebView' => 'fa fa-eye',
                                    'Default Browser' => 'fa fa-globe',
                                    'Edge' => 'fa fa-edge',
                                    'Mobile Safari UIWebView' => 'fa fa-compass',
                                    'Opera' => 'fa fa-opera',
                                );
                                return '<i class="' . $deviceIcon[$data['user_browser']]. '"></i> ' .$data['user_browser'];
                            }
                        ),
                        array(
                            'header' => 'จำนวนผู้ใช้งาน',
                            'value' => function($data) {
                                $user_browser = Platform::model()->findAll(array(
                                    'condition' => 'user_browser = "' . $data['user_browser'] . '"',
                                    'group' => 'user_id'
                                ));
                                return count($user_browser);
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px;'
                            ),
                        ),
                        array(
                            'header' => 'จำนวนครั้ง',
                            'value' => function($data) {
                                $user_browser = Platform::model()->findAll(array(
                                    'condition' => 'user_browser = "' . $data['user_browser'] . '"',
                                ));
                                return count($user_browser);
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px;'
                            ),
                        ),
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<?php $default = $_GET['Status']?>
<script type="text/javascript">
    $(function() {
        $('#selectUserName').select2({
            placeholder: 'ค้นหาผู้เรียนด้วย ชื่อ - สกุล',
            allowClear: true,
        });
        // $('#courseSelectMulti').select2();
        endDate();
        startDate();
    });
    function startDate() {
        $('#ReportStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#ReportEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#ReportEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }
</script>