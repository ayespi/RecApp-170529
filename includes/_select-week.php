<?php
require('../../../myb4g-connect.php');
require('../classes/Week.php');
$week = new Week($connection);
$week->get_weeks();
$weeks = $week->data;
// echo('<pre>');
// print_r($weeks);
// echo('</pre>');
?>
<form class="form-choose-week" action="../result" method="get">
  Choose Week:<br>
  <select class="choose-week" name="week">
    <option value="null" selected disabled>*** SELECT ONE ***</option>
    <?php foreach ($weeks as $week) { ?>
      <?php if($week['id'] < 1 || $week['id'] > 11 || $week['description'] == 'Orientation'){ continue; } ?>
      <option value="<?php echo($week['id'] - 1); ?>"><?php echo($week['description']);?></option>
      <?php  } ?>
    </select>
    <input type="submit" name="submit_week" value="Submit Week">
  </form>
