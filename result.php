<?php
if(isset($_GET['week'])){
    $week_id = $_GET['week'];
    require('../../myb4g-connect.php');
    require('./classes/Week.php');
    require('./classes/Compute.php');
    require('./classes/Team.php');
    require('./classes/Competitor.php');
    $week                 = new Week($connection);
    $compute              = new Compute($connection);
    $current_team         = new Team($connection);
    $competitor           = new Competitor($connection);
    // echo('<pre>');
    // print_r($current_team);
    // echo('</pre>');
    $results_posted       = $week->get_date_posted($week_id);
    $weight_loss          = $compute->get_weight_loss_competition_week($week_id);
    $overall_weight_loss  = $compute->get_weight_loss_competition_overall($week_id);
    $teams                = $current_team->get_teams();
    $wiwl_leaders         = $compute->get_weekly_individual_weight_loss($week_id);
    $oiwl_leaders         = $compute->get_overall_individual_weight_loss($week_id);
    $biggest_loser        = $compute->get_biggest_loser($week_id);
    // $select_team          = $current_team ->get_team(1);
    // $team_name            = $select_team[0]['name'];
    // echo('<pre>');
    // print_r($select_team[0]['name']);
    // echo('</pre>');
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
        <ul>
          <?php foreach ($wiwl_leaders as $leader) { ?>
            <li><?php
            $competitor_name      = $competitor->get_competitor($leader['competitor_id']);
            $select_team          = $current_team ->get_team($leader['team_id']);
            $team_name            = $select_team[0]['name'];
            echo($competitor_name.' - '.$team_name.' ( '.$leader['weight_loss'].'lbs ) '.$leader['weight_loss_pct'].'%');
            ?></li>
          <?php  } ?>
        </ul>
        <h3>Overall Individual Weight Loss:</h3>
        <ul>
          <?php foreach ($oiwl_leaders as $leader) { ?>
            <li><?php
            $competitor_name      = $competitor->get_competitor($leader['competitor_id']);
            $select_team          = $current_team ->get_team($leader['team_id']);
            $team_name            = $select_team[0]['name'];
            echo($competitor_name.' - '.$team_name.' ( '.$leader['overall_weight_loss'].'lbs ) '.$leader['overall_weight_loss_pct'].'%'); ?></li>
          <?php  } ?>
        </ul>
        <h3>Weekly Team Weight Loss:</h3>
        <h3>Overall Team Weight Loss:</h3>
        <h2>Overall Biggest Loser: <?php
        $competitor_name      = $competitor->get_competitor($biggest_loser[0]['competitor_id']);
        echo($competitor_name);
        ?></h2>
        <ul>
          <?php foreach ($biggest_loser as $loser) { ?>
            <li><?php
            $competitor_name      = $competitor->get_competitor($loser['competitor_id']);
            $select_team          = $current_team ->get_team($leader['team_id']);
            $team_name            = $select_team[0]['name'];
            echo($competitor_name.' - '.$team_name.' ( '.$loser['overall_weight_loss'].'lbs ) '.$loser['overall_weight_loss_pct'].'%'); ?></li>
          <?php  } ?>
        </ul>
        <h3>Most Raw Pounds Lost:</h3>
      </section>
    </div>
  </body>
</html>

<a href="./index">Go Home</a>
