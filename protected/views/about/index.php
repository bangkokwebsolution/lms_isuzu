<!-- <div class="header-page parallax-window">
  <div class="container">
    <h1><?php echo $label->label_about; ?>
    <small class="pull-right">
    <ul class="list-inline list-unstyled">
      <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li><strong style="font-weight: 700"> /</strong>
      <li><span class="text-bc"><?php echo $label->label_about; ?></span></li>
    </ul>
    </small>
    </h1>
  </div>
</div> -->
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $label->label_about ?></li>
    </ol>
  </nav>
</div>



<section class="content" id="about-us">
  <div class="container">
    <div class="well">
      <div class="detail">
        <?php echo $about_data->about_detail ;?>
      </div>      
    </div>    
  </div>
</section>