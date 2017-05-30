<?php
if(isset($_GET['week'])){
    $week_id = $_GET['week'];
    require('../../myb4g-connect.php');
    require('./classes/Week.php');
    require('./classes/Compute.php');
    require('./classes/Team.php');
    $week                 = new Week($connection);
    $compute              = new Compute($connection);
    $team                 = new Team($connection);
    $results_posted       = $week->get_date_posted($week_id);
    $weight_loss          = $compute->get_weight_loss_competition_week($week_id);
    $overall_weight_loss  = $compute->get_weight_loss_competition_overall($week_id);
    $teams                = $team->get_teams();
    // echo('<pre>');
    // echo('Weekly Statistics From Week Ending: <strong>');
    // print_r($results_posted);
    // echo('</strong></pre><br>');
    // echo('<pre>');
    // echo('Total Weight Loss Last Week: <strong>');
    // print_r($weight_loss);
    // echo('</strong></pre><br>');
    // echo('<pre>');
    // echo('Total Overall Weight Loss Last Week: <strong>');
    // print_r($overall_weight_loss);
    // echo('</strong></pre><br>');
  }else{
      header('Location: ./index');
  }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Results</title>
  </head>
  <body>
    <div class="container">
      <header>
        <img src="./images/l2l.jpg" alt="Losing to Live Logo">
        <h2>Weekly Statistics From Week <?php echo($week_id); ?> - Ending <?php echo('<strong>'.$results_posted.'</strong>');?></h2>
        <h3>Our total weight loss from LAST week is <?php echo('<strong>'.number_format($weight_loss, 1).'</strong>'); ?> lbs</h3>
        <h3>Our overall total weight loss for the competition is <?php echo('<strong>'.number_format($overall_weight_loss, 1).'</strong>'); ?> lbs</h3>
      </header>
      <section>
        <h2>Team Names</h2>
          <ul>
            <?php foreach ($teams as $team) { ?>
              <li><?php echo($team['name'].' - ('.$team['leader'].' )'); ?></li>
            <?php  } ?>
          </ul>
        <h3>Weekly Individual Weight Loss:</h3>
        <h3>Overall Individual Weight Loss:</h3>
        <h3>Weekly Team Weight Loss:</h3>
        <h3>Overall Team Weight Loss:</h3>
        <h2>Overall Biggest Loser: <?php //echo(); ?></h2>
        <h3>Most Raw Pounds Lost:</h3>
      </section>
    </div>
  </body>
</html>

<a href="./index">Go Home</a>
