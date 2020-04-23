<!-- Include Datables -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/DataTables/datatables.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/DataTables/datatables.min.js"></script>



<?php
$titleName = 'จัดการหลักสูตร';
$formNameModel = 'CourseOnline';

$this->breadcrumbs=array($titleName);


?>

<!-- <form id="frm-example" action="/path/to/your/script" method="POST"> -->
<?php
                $form = $this->beginWidget('CActiveForm', array(
//                            'name' => 'form1',
                    'id' => 'frm-example',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
            <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
            <th>Name</th>
            <th>Email</th>
            <!-- <th>Grading</th> -->
            <?php if(!$state){ ?>
            <th>PT-Grading</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($model as $key => $userItem) {
           ?>
           <tr>
            <td><input name="chk_<?php echo $userItem->id; ?>" value="<?php echo $userItem->id; ?>" id="chk_id_<?php echo $userItem->id; ?>" type="checkbox" /></td>
            <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
            <td><?= $userItem->email ?></td>
            <?php if(!$state){ ?>
             <td><?= $userItem->grades->grade_title ?></td>
            <?php } ?>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
           <th></th>
           <th>Name</th>
           <th>Email</th>
           <!-- <th>Grading</th> -->
           <?php if(!$state){ ?>
            <th>PT-Grading</th>
            <?php } ?>
         </tr>
       </tfoot>
      </table>

      <hr>

      <p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

      <p>
      <!-- <button>Submit</button> -->
      <?php 
        echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-info btn-lg center-block btn-rigis'));
       ?>
      </p>

      <b>Data submitted to the server:</b><br>
      <pre id="example-console">
      </pre>


    </div>
  </div>
</div>
<?php 
  $this->endWidget();
?>
<!-- </form> -->

<script>
// $(document).ready(function(){
//     // var table = $('#user-list').DataTable();

//     var table = $('#user-list').DataTable({
//       'ajax': 'https://api.myjson.com/bins/1us28',
//       'columnDefs': [
//       {
//         'targets': 0,
//         'checkboxes': {
//          'selectRow': true
//        }
//      }
//      ],
//      'select': {
//        'style': 'multi'
//      },
//      'order': [[1, 'asc']]
//    });

//   });
$(document).ready(function (){   
  // location.reload();
  var list_user_ck = <?= json_encode($mtId); ?>;
   var table = $('#user-list').DataTable({
      // 'ajax': 'https://api.myjson.com/bins/1us28',  
      'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
            // return '<input type="checkbox" name="id[]" value="' 
            // + $('<div/>').text(data).html() + '">';
              console.log(data);
              var inputStr = '<input type="checkbox" ';
              if(list_user_ck.indexOf(data) > -1){
                // console.log(data);
                inputStr += 'checked';
              }
               inputStr += ' name="id[]" value="' 
                + $('<div/>').text(data).html() + '">';

                return inputStr;
         }
      }],
      'order': [1, 'asc'],
      'pageLength' : 100
   });

   // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#user-list tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control 
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });
    
   $('#frm-example').on('submit', function(e){
      var form = this;
      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element 
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         } 
      });

      // FOR TESTING ONLY
      
      // Output form data to a console
      $('#example-console').text($(form).serialize()); 
      // console.log("Form submission", $(form).serialize()); 
       
      // Prevent actual form submission
      // e.preventDefault();
      
   });
});

</script>