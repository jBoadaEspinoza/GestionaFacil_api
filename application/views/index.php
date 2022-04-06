<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo $template["lang"];?>">
<head>
  <meta http-equiv="Content-type" value="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="<?php echo $template["toolbarcolor"];?>" />
  <meta name="msapplication-navbutton-color" content="<?php echo $template["toolbarcolor"];?>"/>
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/public/recursos/maabi_logo.ico">
  <title><?php echo $template["title"];?></title>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  
  <!--fonts google -->
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <!--end fonts google -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.min.css<?php echo '?'.mt_rand(); ?>"> 
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-dropdownhover.min.css<?php echo '?'.mt_rand(); ?>">
  <!-- end Bootstrap CSS -->

  <!--font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <!--end font awesome -->

  <!-- moment-->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/es.js"></script>
  <!-- end moment-->
  
  <!-- chart.js-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <!-- end chart.js-->
  
  <!-- datepicker -->
  <link href="<?php echo base_url();?>assets/css/datepicker.css<?php echo '?'.mt_rand(); ?>" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js<?php echo '?'.mt_rand(); ?>"></script>
  <script src="<?php echo base_url();?>assets/js/locales/bootstrap-datepicker.<?php echo $template["lang"];?>.js<?php echo '?'.mt_rand(); ?>"></script>
  <!--end datepicker-->
  
  <!-- js -->
  
  <!--DateTimePicker -->
  <link href="<?php echo base_url();?>assets/css/jquery.datetimepicker.css<?php echo '?'.mt_rand(); ?>" rel="stylesheet" />
  <!--End DateTimePicker-->
  
  <!--activity-->
  <link href="<?php echo base_url();?>assets/css/activity.css<?php echo '?'.mt_rand(); ?>" rel="stylesheet">
  <!-- end activity-->
  
  <!--Confirm-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <!--end confirm--->
  
  <!-- styles -->
  <link href="<?php echo base_url();?>assets/css/index.css<?php echo '?'.mt_rand(); ?>" rel="stylesheet" />
  <link href="<?php echo base_url();?>assets/css/star-rating-svg.css<?php echo '?'.mt_rand(); ?>" rel="stylesheet" />
  <?php 
    for($i=0;$i<count($template["lib"]['css']);$i++){
      echo '<link href="'.base_url().'assets/css/'.$template['lib']["css"][$i].'.css?'.mt_rand().'" rel="stylesheet" />';
    }
  ?>
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
  <!--confirm--->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!--end confirm-->
  <!--activity-->
  <script src="<?php echo base_url();?>assets/js/jquery-activity.js<?php echo '?'.mt_rand(); ?>"></script>
  <!-- end activity--> 
  <!-- loading-->
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.4/dist/loadingoverlay.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
  
  <script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.js<?php echo '?'.mt_rand(); ?>"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.full.min.js<?php echo '?'.mt_rand(); ?>"></script>
  
  <script src="<?php echo base_url();?>assets/js/loading.js<?php echo '?'.mt_rand(); ?>"></script>

  <script src="<?php echo base_url();?>assets/js/bootstrap-dropdownhover.min.js<?php echo '?'.mt_rand(); ?>"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.star-rating-svg.min.js<?php echo '?'.mt_rand(); ?>"></script>
  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
></script>
  <?php 
    for($i=0;$i<count($template["lib"]['js']);$i++){
      echo '<script src="'.base_url().'assets/js/'.$template['lib']["js"][$i].'.js?'.mt_rand().'"></script>';
    }
  ?>
  <style type="text/css"> 
    body,html{
      height:100%;
      width;100%;
      min-height:100%;
      font-family: 'Ubuntu', sans-serif; 
      background-color: <?php echo $template["bgbody"];?>;
      background:<?php echo $template["bgbody"];?>;
      <?php echo $template["bgimagefull"];?>
    } 
    ::-webkit-scrollbar {
        display: none;
    }
  </style>
  <script type="text/javascript">
      $( document ).ready(function() {
          $('form').each(function(){
              $(this).find('button').on('click',function(){
                show_loadingOverlay(this,[255,255,255,0,0.6]);
              });
          });
          $('a').find('.submit-loading').each(function(){
              $(this).on('click',function(){
                show_loadingOverlay(this,[255,255,255,0,0.6]);
              });
          });
      });
  </script>
</head>
<body>
  <?php echo $template["content"];?>
  <script type="text/javascript">
    var BASE_URL="<?php echo base_url();?>";
  </script>
</body>
</html>
