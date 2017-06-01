<?php
class Compute{
  public $connection;
  public $week_id;
  public $team_id;
  public $competitor_id;
  public $begin;
  public $previous;
  public $current;
  public $result = array();
  public $data;
  public $json;

  public function __construct($connection){
    $this->connection = $connection;

  }

  public function get_weight_loss_competition_week($week_id){
    $this->week_id = $week_id;
    $previous = $this->get_combined_previous();
    $current = $this->get_combined_current();
    return $previous - $current;
  }

  public function get_weight_loss_competition_overall($week_id){
    $this->week_id = $week_id;
    $begin = $this->get_combined_begin();
    $current = $this->get_combined_current();
    return $begin - $current;
  }

  public function get_combined_begin(){
    $result = $this->select_weigh_in_data_week();
    return $this->get_sum_begin($result);
  }

  public function get_combined_previous(){
    $result = $this->select_weigh_in_data_week();
    return $this->get_sum_previous($result);
  }

  public function get_combined_current(){
    $result = $this->select_weigh_in_data_week();
    return $this->get_sum_current($result);
  }

  public function select_weigh_in_data_week(){
    $sql = "SELECT * FROM weigh_ins WHERE wi_week_id='$this->week_id';";
    return mysqli_query($this->connection, $sql);
  }

  public function get_sum_begin($result){
    $begin = 0;
    while($row = mysqli_fetch_assoc($result)){
      $begin += $row['wi_begin'];
    }
    return $begin;
  }

  public function get_sum_previous($result){
    $previous = 0;
    while($row = mysqli_fetch_assoc($result)){
      $previous += $row['wi_previous'];
    }
    return $previous;
  }

  public function get_sum_current($result){
    $current = 0;
    while($row = mysqli_fetch_assoc($result)){
      $current += $row['wi_current'];
    }
    return $current;
  }

  public function select_weigh_in_data(){
    $sql = "SELECT * FROM weigh_ins";
    return $result = mysqli_query($this->connection, $sql);
  }

  public function get_weekly_individual_weight_loss($week_id){
    $this->week_id = $week_id;
    $sql = $this->wiwl_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->wiwl_leaders($result);
  }

  public function wiwl_query(){
    return $sql = "SELECT * FROM results
    WHERE result_week_id='$this->week_id'
    ORDER BY result_weight_loss_pct
    DESC
    LIMIT 3;";
  }

  public function wiwl_leaders($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'                          =>    $row['result_id'],
        'competitor_id'               =>    $row['result_competitor_id'],
        'week_id'                     =>    $row['result_week_id'],
        'team_id'                     =>    $row['result_team_id'],
        'weight_loss'                 =>    $row['result_weight_loss'],
        'weight_loss_pct'             =>    $row['result_weight_loss_pct'],
        'overall_weight_loss'         =>    $row['result_overall_weight_loss'],
        'overall_weight_loss_pct'     =>    $row['result_overall_weight_loss_pct'],
        'date_entered'                =>    $row['result_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }

  public function get_overall_individual_weight_loss($week_id){
    $this->week_id = $week_id;
    $sql = $this->oiwl_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->oiwl_leaders($result);
  }

  public function oiwl_query(){
    return $sql = "SELECT * FROM results
    WHERE result_week_id='$this->week_id'
    ORDER BY result_overall_weight_loss_pct
    DESC
    LIMIT 3;";
  }

  public function oiwl_leaders($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'                          =>    $row['result_id'],
        'competitor_id'               =>    $row['result_competitor_id'],
        'week_id'                     =>    $row['result_week_id'],
        'team_id'                     =>    $row['result_team_id'],
        'weight_loss'                 =>    $row['result_weight_loss'],
        'weight_loss_pct'             =>    $row['result_weight_loss_pct'],
        'overall_weight_loss'         =>    $row['result_overall_weight_loss'],
        'overall_weight_loss_pct'     =>    $row['result_overall_weight_loss_pct'],
        'date_entered'                =>    $row['result_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }

  public function get_team_weight_loss($week_id, $team_id){
    $this->week_id = $week_id;
    $this->team_id = $team_id;
    $sql = $this->team_weight_loss_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->team_weight_loss_leaders($result);
  }

  public function team_weight_loss_query(){
    return $sql = "SELECT * FROM team_results
    WHERE team_result_week_id='$this->week_id'
    AND team_result_team_id='$this->team_id'
    ORDER BY team_result_weight_loss_pct
    DESC LIMIT 3;";
  }

  public function team_weight_loss_leaders($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'                          =>    $row['result_id'],
        'team_id'                     =>    $row['result_team_id'],
        'week_id'                     =>    $row['result_week_id'],
        'weight_loss'                 =>    $row['result_weight_loss'],
        'weight_loss_pct'             =>    $row['result_weight_loss_pct'],
        'overall_weight_loss'         =>    $row['result_overall_weight_loss'],
        'overall_weight_loss_pct'     =>    $row['result_overall_weight_loss_pct'],
        'date_entered'                =>    $row['result_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }


  public function get_overall_team_weight_loss($week_id, $team_id){
    $this->week_id = $week_id;
    $this->team_id = $team_id;
    $sql = $this->overall_team_weight_loss_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->overall_team_weight_loss_leaders($result);
  }

  public function overall_team_weight_loss_query(){
    return $sql = "SELECT * FROM team_results
    WHERE team_result_week_id='$this->week_id'
    AND team_result_team_id='$this->team_id'
    ORDER BY team_result_overall_weight_loss_pct
    DESC LIMIT 3;";
  }

  public function overall_team_weight_loss_leaders($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'                          =>    $row['result_id'],
        'team_id'                     =>    $row['result_team_id'],
        'week_id'                     =>    $row['result_week_id'],
        'weight_loss'                 =>    $row['result_weight_loss'],
        'weight_loss_pct'             =>    $row['result_weight_loss_pct'],
        'overall_weight_loss'         =>    $row['result_overall_weight_loss'],
        'overall_weight_loss_pct'     =>    $row['result_overall_weight_loss_pct'],
        'date_entered'                =>    $row['result_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }


  public function get_biggest_loser($week_id){
    $this->week_id = $week_id;
    $sql = $this->biggest_loser_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->biggest_loser($result);
  }

  public function biggest_loser_query(){
    return $sql = "SELECT * FROM results
    WHERE result_week_id='$this->week_id'
    ORDER BY result_overall_weight_loss_pct
    DESC
    LIMIT 1;";
  }

  public function biggest_loser($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'                          =>    $row['result_id'],
        'competitor_id'               =>    $row['result_competitor_id'],
        'week_id'                     =>    $row['result_week_id'],
        'team_id'                     =>    $row['result_team_id'],
        'weight_loss'                 =>    $row['result_weight_loss'],
        'weight_loss_pct'             =>    $row['result_weight_loss_pct'],
        'overall_weight_loss'         =>    $row['result_overall_weight_loss'],
        'overall_weight_loss_pct'     =>    $row['result_overall_weight_loss_pct'],
        'date_entered'                =>    $row['result_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }

  public function compute_weigh_in_results(){
    $this->results['weight_loss']                 = $this->get_weight_loss();
    $this->results['weight_loss_percent']         = $this->get_weight_loss_percent();
    $this->results['overall_weight_loss']         = $this->get_overall_weight_loss();
    $this->results['overall_weight_loss_percent'] = $this->get_overall_weight_loss_percent();
  }

  public function get_weight_loss(){
    return number_format($this->previous - $this->current, 1);
  }
  public function get_weight_loss_percent(){
    return number_format(($this->get_weight_loss() / $this->previous) * 100, 6);;
  }
  public function get_overall_weight_loss(){
    return number_format($this->begin - $this->current, 1);
  }
  public function get_overall_weight_loss_percent(){
    return number_format(($this->get_overall_weight_loss() / $this->begin) * 100, 6);
  }

  public function compute_team_results($week_id, $team_id){
    $this->week_id  = $week_id;
    $this->team_id  = $team_id;
    // select_weigh_ins
    $sql      = $this->select_weigh_ins_query();
    $results  = mysqli_query($this->connection, $sql);
    // loop through results
    // get sums of: begin, previous, current_team
    // compute team results
    $this->compute_team_results($results);
    // insert team results into TEAM RESULTS table
    $this->insert_team_results();
  }

  public function select_weigh_ins_query(){
    return $sql = "SELECT * FROM weigh_ins
    WHERE wi_week_id='$this->week_id'
    AND wi_team_id='$this->team_id';";
  }

  public function compute_team_results($results){
      $this->data = array();
      $begin    = 0;
      $previous = 0;
      $current  = 0;
    while($row = mysqli_fetch_assoc($results)){
      $this->data[] = array(
        'id'              =>    $row['wi_id'],
        'competitor_id'   =>    $row['wi_competitor_id'],
        'week_id'         =>    $row['wi_week_id'],
        'team_id'         =>    $row['wi_team_id'],
        'begin'           =>    $row['wi_begin'],
        'previous'        =>    $row['wi_previous'],
        'current'         =>    $row['wi_current'],
        'notes'           =>    $row['wi_notes'],
        'date_entered'    =>    $row['wi_date_entered']
      );

      $begin    += $row['wi_begin'];
      $previous += $row['wi_previous'];
      $current  += $row['wi_current'];
    }

    $this->begin    = $begin;
    $this->previous = $previous;
    $this->current  = $current;
    $this->compute_weigh_in_results();
  }

}

 ?>
