<style>
    header,
    footer {
        display: none;
    }
</style>

<body class="body-login">
    <div class="container">
        <div class="login-group row justify-content-center align-items-center">
            <div class="col-sm-6 col-md-5 text-center">
                <div class="logo-head">
                    <a href="">
                        <img src="../themes/template2/images/logo-imct.png" width="250px" class="logo-login">
                    </a>
                </div>
                <div class="login-content">
                    <div class="login-form">
                        <h3> เข้าสู่ระบบ </h3>
                        <div class="form-group">
                            <label for=""><?= $label->label_header_username ?></label>
                            <input type="text" class="form-control" placeholder='<?= $label->label_header_username ?>' name="UserLogin[username]" value="<?php echo Yii::app()->request->cookies['cookie_name']->value; ?>" required>
                        </div>


                        <div class="form-group password-group">
                            <label for=""><?= $label->label_header_password ?></label>
                            <input type="password" id="password-field" class="form-control" placeholder='<?= $label->label_header_password ?>' name="UserLogin[password]" required>
                            <span toggle="#password-field" class="field-icon toggle-password"></span>
                            <!-- <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> -->
                        </div>

                        <div class="login-btn">
                            <button type="submit" class="btn btn-submit login-main" id="submit" name="submit"><?= $label->label_header_yes ?>Login</button>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="pull-right" style="margin-top: 5px">
                                <a class="btn-forgot" href="<?php echo $this->createUrl('Forgot_password/index') ?>"><?= $label->label_header_forgotPass ?>ลืมรหัสผ่าน</a>
                                <!-- <a href="< ?php echo $this->createUrl('/registration/ShowForm'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?></a> -->
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>