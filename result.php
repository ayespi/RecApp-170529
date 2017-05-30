<?php
if(isset($_GET['week'])){
    $week_ending = $_GET['week'];
    require('../../myb4g-connect.php');
    require('./classes/Week.php');
    require('./classes/Compute.php');
    $week                 = new Week($connection);
    $compute              = new Compute($connection);
    $results_posted       = $week->get_date_posted($week_ending + 1);
    $weight_loss          = $compute->get_weight_loss_competition_week($week_ending);
    $overall_weight_loss  = $compute->get_weight_loss_competition_overall($week_ending);
    echo('<pre>');
    echo('Weekly Statistics From Week Ending: <strong>');
    print_r($results_posted);
    echo('</strong></pre><br>');
    echo('<pre>');
    echo('Total Weight Loss Last Week: <strong>');
    print_r($weight_loss);
    echo('</strong></pre><br>');
    echo('<pre>');
    echo('Total Overall Weight Loss Last Week: <strong>');
    print_r($overall_weight_loss);
    echo('</strong></pre><br>');

  }else{
      header('Location: ./index');
  }
 ?>
<a href="./index">Go Home</a>
