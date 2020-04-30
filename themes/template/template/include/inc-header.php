<div class="backtotop"><span><i class="fas fa-arrow-up"></i> <small>top</small></span></div>
<a class="contact-admin" data-toggle="modal" data-target="#user-report">
    <div id="mascot-contact"></div>
</a>
<script>
    var reportMastcot = document.getElementById("mascot-contact");
    var animation = bodymovin.loadAnimation({
        container: reportMastcot,
        renderer: 'svg',
        autoplay : false,
        loop: true,
        path: 'themes/template/animation/report-contact/mascot-contact.json'
    });

    reportMastcot.addEventListener("mouseenter", function () {
    animation.play();
    });

    reportMastcot.addEventListener("mouseleave", function () {
    animation.stop();
    });
</script>

<div class="modal fade" id="user-report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> แจ้งปัญหาการใช้งาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<" method="POST" role="form" name="user-report">
                <div class="modal-body">
                    <div class="row report-row">
                        <div class="col-md-6">
                            <label for="">ชื่อ</label>
                            <input type="text" class="form-control" placeholder="ชื่อ">
                        </div>
                        <div class="col-md-6">
                            <label for="">นามสกุล</label>
                            <input type="text" class="form-control" placeholder="นามสกุล">
                        </div>
                    </div>
                    <div class="row report-row">
                        <div class="col-md-6">
                            <label for="">อีเมล์</label>
                            <input type="text" class="form-control" placeholder="อีเมล์">
                        </div>
                        <div class="col-md-6">
                            <label for="">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" placeholder="เบอร์โทรศัพท์">
                        </div>
                    </div>

                    <div class="row report-row">
                        <div class="col-md-12">
                            <label for="">ข้อความ</label>
                            <textarea name="" class="form-control" placeholder="พิมพ์ข้อความในช่องนี้" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row report-row">
                        <div class="col-md-6">
                            <label for="">อัปโหลดรูปภาพ</label>
                            <input type="file" class="form-control" multiple="">
                        </div>
                    </div>
                </div>
             
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<header>
    <div class="menu-top">

        <div class="contact-topbar">
            <span>Call: <a href="tel:02xxxxxxxx" class="calltop">02xxxxxxxx</a></span>
            <span>Email: <a href="mailto:Info@email.com" class="mailtop">Info@email.com</a></span>
        </div>

        <div class="function-topbar">
            <div class="change-language">
                <select class="selectpicker" data-width="fit">
                    <option data-content='<span class="flag-icon flag-icon-th"></span> TH'>TH</option>
                    <option data-content='<span class="flag-icon flag-icon-us"></span> EN'>EN</option>
                </select>

            </div>
        </div>

    </div>
    <!-- <form class="header-search ">
        <input type="search" placeholder="ค้นหา" aria-label="Search">
    </form> -->

    <nav class="main-header navbar navbar-expand-lg navbar-light bg-white border-bottom" id="header-main">
        <a class="navbar-brand" href="e-learning.php">
            <img src="themes/template/images/logo.png" height="80" class="pr-3" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMain" aria-controls="navbarTogglerMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerMain">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 main-menu">

                <li class="nav-item active">
                    <a class="nav-link  " href="e-learning.php">หน้าแรก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">หลักสูตร</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">เกี่ยวกับเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">วิธีการใช้งาน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ถาม-ตอบ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ติดต่อเรา</a>
                </li>


            </ul>

            <div class="btn-group-nav">

                <!-- <a class="btn btn-outline-dark btn-login" href="#" role="button"><img src="themes/template/images/btn-login.svg" alt=""> เข้าสู่ระบบ</a>
                <a class="btn btn-danger btn-register" href="#" role="button"><img src="themes/template/images/btn-register.svg" alt=""> สมัครสมาชิก</a> -->

                <div class="dropdown course-user">
                    <button class="btn" type="button" id="dropdownCourse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="group-course">
                            <span><i class="fas fa-bookmark"></i> หลักสูตรของฉัน</span>
                        </div>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownCourse">

                        <?php for ($i = 1; $i <= 3; $i++) {
                        ?>
                            <a class="dropdown-item" href="#">
                                <div class="course-list-user">
                                    <img src="themes/template/images/thumbnail-course.png" alt="">
                                </div>
                                <div class="course-title-user">
                                    <h5>
                                        หลักสูตร ดีกรีตะหงิดเบนโล สามช่าเจลติ่มซำกราวนด์แตงโม ซิตีซิตี้แดนซ์ คอร์ส
                                    </h5>
                                    <div class="progress progress-course-list">
                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>


                    </div>
                </div>

                <div class="dropdown account-user">
                    <button class="btn" type="button" id="dropdownAccountuser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="group-user">
                            <img src="themes/template/images/users.png" alt="" class="rounded-circle" height="40" width="40">
                            <span>
                                อภิวัฒน์ เอนกบุญ
                                <br><small>Web Design</small>
                            </span>
                        </div>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownAccountuser">
                        <a class="dropdown-item" href="#"><i class="fas fa-bookmark"></i>หลักสูตรของฉัน</a>
                        <a class="dropdown-item" href="status-learn.php"><i class="fas fa-tasks"></i>สถานะการเรียน</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-edit"></i>แก้ไขข้อมูลส่วนตัว</a>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt text-danger"></i>ออกจากระบบ</a>
                    </div>
                </div>

            </div>

        </div>
    </nav>
</header>