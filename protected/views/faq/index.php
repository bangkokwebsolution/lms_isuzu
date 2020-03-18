<div class="header-page parallax-window">
    <div class="container">
        <h1><?= $label->label_faq ?>
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li> /
                    <li><span class="text-bc"><?= $label->label_faq ?></span></li>
                </ul>
            </small>
        </h1>
    </div>
</div>
    <!-- Content --> 
    <!-- <div class="container">
            <div class="row">   
            <div class="col-md-8"></div>
            <div class="col-md-4"> -->

          <!--form search-->
                   <!--  <form id="faqForm" class="" action="<?php echo $this->createUrl('faq/search') ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="text" placeholder="ใส่ข้อความที่ต้องการค้นหา...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">ค้นหา</button>
                                    </span>
                                </div>
                          </form> -->
            <!--end form search-->
            <!-- /div> 
            </div>  
    </div> -->

 <section class="content" id="faq">
    <div class="container">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <!--statr no loop -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="text1">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-0" aria-expanded="true" aria-controls="collapseOne">
                             <i class="fa fa-question-circle text-danger" aria-hidden="true"></i> &nbsp;<?= $faq_type[0]->faq_type_title_TH; ?>
                            <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                        </a>
                    </h4>
                </div>
                <?php if ($faq_type[0]->faq_type_id == $faq_data[0]->faq_type_id) { ?>
             <!-- show detail -->
                <div id="collapse-0" class="panel-collapse collapse in" role="tabpanel" 
                     aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="well">
                            <?= $faq_data[0]->faq_THtopic; ?>
                            <p><?php echo htmlspecialchars_decode($faq_data[0]->faq_THanswer) ?></p>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                    <div id="collapse-0" class="panel-collapse collapse in" role="tabpanel" 
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="well">
                                <?=  $label->label_noTopic ?>
                                <p><?=  $label->label_noDetail ?></p>
                            </div>
                        </div>
                    </div>
              <?php  } ?>
                <!-- end show detail -->
            </div>
            <!--end no loop-->
            <!-- start loop -->
            <?php
            $a = count($faq_type) - '1';
            $s = '1';
            $i = '1'; 

            ?>
            <?php while ($i <= $a) { ?> 
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="text1">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $i ?>" aria-expanded="true" aria-controls="collapseOne">

                                <i class="fa fa-question-circle text-danger" aria-hidden="true"></i> &nbsp;<?= $faq_type[$i]->faq_type_title_TH; ?>
                                <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                            </a>
                        </h4>
                    </div>
                <?php foreach ($faq_data as $key => $value) {
                    if ($value->faq_type_id == $faq_type[$i]->faq_type_id) { ?>
                            <div id="collapse-<?= $i ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="well" style="background-color: #fff7be;">
                                    <h4><b><?= $label->label_ques ?> : </b></h4>
                                    <?=$value->faq_THtopic ?>
                                </div>
                                <div class="well">
                                    <h4><b><?= $label->label_ans ?> : </b></h4>
                                    <p><?php echo htmlspecialchars_decode($value->faq_THanswer) ?></p>
                                </div>
                            </div>
                        </div>
                  <?php  } } ?>
                </div>
                <?php
                $i++;

            } //1
            ?>
        </div>
                <!-- end loop -->
    </div>
</section>