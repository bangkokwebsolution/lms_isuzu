<?php
//var_dump($profile);
//var_dump($user);

?>
<form>
	<div class="well">

              <!--   <div class="row box-img-center mb-2 bb-1">
                    <div class="col-sm-4">
                        <div class="upload-img">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 180px; max-height: 240px;">
                                    <div class="mt-2">
                                 
                                        <?php
                                        if ($User->pic_user == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                            $registor = new RegistrationForm;
                                            $registor->id = $users->id;
                                            $img = Yii::app()->baseUrl . '/uploads/user/' . $User->id . '/thumb/' . $User->pic_user;
                                        }
                                        ?>
                                        <img src="<?= $img ?>" alt="">
                                    </div>
                                </div>
                       
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center select-profile mg-0">
                    <div class="form-group">
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_user" id="accept" value="1" <?php if ($profile->type_user == 1) : ?> checked="checked" <?php endif ?>>
                            <label for="accept" class="bg-success text-black">
                                <?php echo $label->label_general_public; ?> </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="type_user" id="reject" value="3" <?php if ($profile->type_user == 3) : ?> checked="checked" <?php endif ?>>
                                <label for="reject" class="bg-danger text-black"><?php echo $label->label_personnel; ?> </label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-1 id_employee" >
                        <div class="col-sm-4">
                            <div class="form-group" >
                           
                                <label for=""><?php echo $label->label_employee_id ; ?></label>
                             
                                <input type="text" class="form-control" id="" placeholder="" value="<?php echo $Users->username ?>">                   
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <h4 class="topic-register form_name"><i class="fas fa-user-edit"></i> <?= Yii::app()->session['lang'] == 1?'Basic information ':'ข้อมูลพื้นฐาน'; ?></h4> -->



        <!-- <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th  width="10%"><center>เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /></center></th>
                        <th  width="40%"><center>ชื่อหลักสูตร</center></th>
                        <th  width="40%"><center>ชื่อบทเรียน</center></th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td width="10%" class="text-center"><center></center></td>
                            <td><center>    
                                </center></td>
                                
                                <td>
                                    <ul style='list-style-type: none;'>
                          
                                </ul>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div> -->
    </form>