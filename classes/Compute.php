<?php
class Compute{
  public $connection;
  public $week_id;
  public $team_id;
  public $competitor_id;
  public $begin;
  public $previous;
  public $current;
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

}

 ?>
