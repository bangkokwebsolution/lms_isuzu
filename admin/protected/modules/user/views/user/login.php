<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class="ie gt-ie8"> <![endif]-->
<!--[if !IE]><!--><html><!-- <![endif]-->
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- Meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    
    <?php
    $clientScript = Yii::app()->clientScript;
    ////////// CSS //////////
    //Bootstrap
    $clientScript->registerCssFile($this->assetsBase.'/bootstrap/css/bootstrap.css');
    $clientScript->registerCssFile($this->assetsBase.'/bootstrap/css/responsive.css');
    //Glyphicons Font Icons
    $clientScript->registerCssFile($this->assetsBase.'/theme/css/glyphicons.css');
    //Main Theme Stylesheet :: CSS
    $clientScript->registerCssFile($this->assetsBase.'/theme/css/style.min.css');
    $clientScript->registerCssFile($this->assetsBase.'/sweetalert/dist/sweetalert.css');
    ////////// JS //////////
    //JQuery
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/system/jquery.min.js', CClientScript::POS_END);
    //JQueryUI
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/system/jquery-ui/js/jquery-ui-1.9.2.custom.min.js', CClientScript::POS_END);
    //JQueryUI Touch Punch
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js', CClientScript::POS_END);
    //Modernizr
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/system/modernizr.js', CClientScript::POS_END);
    //Bootstrap
    $clientScript->registerScriptFile($this->assetsBase.'/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);
    //SlimScroll Plugin
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/other/jquery-slimScroll/jquery.slimscroll.min.js', CClientScript::POS_END);
    //Common Demo Script
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/demo/common.js', CClientScript::POS_END);
    //Holder Plugin
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/other/holder/holder.js', CClientScript::POS_END);
    //Uniform Forms Plugin
    $clientScript->registerScriptFile($this->assetsBase.'/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js', CClientScript::POS_END);
    //$clientScript->registerScript('basePath', "var basePath = '';");
    //
    //Sweet ALert
    $clientScript->registerScriptFile($this->assetsBase.'/sweetalert/dist/sweetalert.min.js',CClientScript::POS_END);
    ?>
</head>
<body class="login">
    <?php
    $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
    $this->breadcrumbs=array( UserModule::t("Login") );
    ?>
    <!-- Wrapper -->
    <div id="login">
        <!-- Box -->
        <div class="form-signin">
            <h3>Sign in to Your Account</h3>
            <!-- Row -->
            <div class="row-fluid row-merge">
                <!-- Column -->
                <?php echo CHtml::beginForm(); ?>
                <div class="span7">
                    <div class="inner">
                       <!--  <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
                            <div class="success">
                                <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                            </div>
                        <?php endif; ?>
                        <?php echo CHtml::activeLabelEx($model,'username', array(
                            'class' => 'strong'));?>
                        <?php echo CHtml::activeTextField($model,'username', array(
                            'class' => 'input-block-level',
                            'placeholder' => 'Your Username',
                            ));?>
                            <?php echo CHtml::error($model,'username',array('class'=>'label label-important')); ?>
                            <label class="strong">Password</label>
                            <?php echo CHtml::activePasswordField($model,'password', array(
                                'class' => 'input-block-level',
                                'placeholder' => 'Your Password',
                                ));?>
                                <?php echo CHtml::error($model,'password',array('class'=>'label label-important')); ?>
                                <br><br>
                                <div class="row-fluid">
                                    <div class="span5 center">
                                        <?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btn-block btn-danger')); ?>
                                    </div>
                                </div> -->
                                <div class="loginwith" id="customBtn">
                                  <a class="btn btn-block btn-danger">
                                    <i class="fa fa-google-plus" aria-hidden="true"></i>  &nbsp;&nbsp;Login with Google
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <?php $form = new CForm(array(
                        'elements'=>array(
                            'username'=>array(
                                'type'=>'text',
                                'maxlength'=>32,
                            ),
                            'password'=>array(
                                'type'=>'password',
                                'maxlength'=>32,
                            ),
                            'rememberMe'=>array(
                                'type'=>'checkbox',
                            )),
                        'buttons'=>array(
                            'login'=>array(
                                'type'=>'submit',
                                'label'=>'Login',
                            ),
                        ),
                        ), $model); ?>
                    </div>
                    <div class="ribbon-wrapper"><div class="ribbon danger">Admin</div></div>
                </div>
            </div>

            <script src="https://apis.google.com/js/api:client.js"></script>
            <script>
                var googleUser = {};
                var startApp = function() {
                    gapi.load('auth2', function(){
                        auth2 = gapi.auth2.init({
                            client_id: '1064112749813-6gko5159s9sbkkva1jppnfsrbou43tgo.apps.googleusercontent.com',
                            cookiepolicy: 'single_host_origin',
                        });
                        attachSignin(document.getElementById('customBtn'));
                    });
                };

                function attachSignin(element) {
                    auth2.attachClickHandler(element, {},
                        function(googleUser) {
                            onGoogleSignIn(googleUser);
                        });
                }
            </script>
            <script>
                function onGoogleSignIn(googleUser) {
                    var response = googleUser.getAuthResponse(true);
                    var accessToken = response.access_token;
                    $.ajax({
                        type: "POST",
                        url: "<?= Yii::app()->createUrl('user/login/LoginGoogle') ?>",
                        dataType:"json",
                        data: {
                            token:accessToken
                        },
                        success: function (result) {
                            location.reload();
                            //alert
                            if (result.result == true) {
                             swal({
                              position: 'top-end',
                              type: 'success',
                              title: result.msg,
                              showConfirmButton: true,
                          },
                          function(isConfirm) {
                           if (isConfirm) {
                            location.reload();
                        }
                    });
                         } else {
                            swal({
                              position: 'top-end',
                              type: 'warning',
                              title: result.msg,
                              showConfirmButton: true
                          },
                          function(isConfirm) {
                           if (isConfirm) {
                            location.reload();
                        }
                    });
                        }
                        //alert end
                    }
                });
                }

                function logout(){
                    gapi.auth2.getAuthInstance().disconnect();
                    window.location.href = "<?=  $this->createUrl('login/logout'); ?>";
                }
            </script>
            <script>startApp();</script>
        </body>
        </html>