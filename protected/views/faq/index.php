<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_faq ?></li>
        </ol>
    </nav>
</div>

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