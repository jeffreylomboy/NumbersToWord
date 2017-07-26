<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Number to Words</title>
	<?php $this->load->view('vcss');?>
        <?php $this->load->view('vjs');?>
</head>
<body>

<div id="container">
   <div class="panel-group">
       <div class="panel-body">
           <div class="col-sm-12">
               <legend> <span class="glyphicon glyphicon-dashboards"></span> Numbers to words</legend>
                     <div class="row">
                         <form action="<?php echo base_url().'convert/go'; ?>" enctype="" method="post" name="test">
                             <div class="col-xs-9">
                                 <input class="input-lg" type="text" id="num_input" name="num_input" onkeypress="return NumberKeyOnly(event)" value="<?php echo set_value('num_input'); ?>" required>
                                 <input class="input-lg" type="submit" value="Convert" name="convert">
                                 <input class="input-lg" id="comma" type="submit" value="Add comma(,)" name="comma">
                             </div>                
                         </form> 
                     </div>
                
                     <div class="row">
                         <div class="col-xs-12">
                             <h3>Output:                                  
                             <?php 
                             if (!empty($output)) {                                 
                                echo $output;
                             }
                              else if(!empty($withcomma)){
                               echo $withcomma; 
                              }                             
                             ?>                                  
                             </h3>
                             
                         </div>
                     </div>
                <?php echo form_error('num_input', '<div class="alert alert-warning" role="alert">', '</div>'); ?>
           </div>
       </div>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#comma').on('click',function(event){
           // event.preventDefault();
         
            var inputRemoveComma = $('#num_input').val().replace(",","");
            var re_string = $.trim(inputRemoveComma.toLocaleString().replace(/,/g, ''));
            console.log(inputRemoveComma);
            var inputWithComma = re_string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#num_input').val(inputWithComma);

        });
                
    });
    
    function NumberKeyOnly(evt)
    {
        var charcode =(evt.which) ? evt.which:event.keycode
        if (charcode >31 && (charcode < 48 || charcode >  57))
            return false;
        
        return true;
    }
</script>
</body>
</html>