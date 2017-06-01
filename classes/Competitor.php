<?php
class Competitor{
  public $connection;
  public $id;
  public $email;
  public $firstname;
  public $lastname;
  public $begin_weight;
  public $phone;
  public $team_id;

  public function __construct($connection){
    $this->connection = $connection;
  }

  public function get_competitor($id){
    $this->id = $id;
    $sql      = $this->get_competitor_query();
    $result   = mysqli_query($this->connection, $sql);
    return $this->get_competitor_name($result);
  }

  public function get_competitor_query(){
    return $sql = "SELECT * FROM competitors WHERE competitor_id='$this->id';";
  }

  public function get_competitor_name($result){
    $row = mysqli_fetch_assoc($result);
    return $row['competitor_firstname'].' '.$row['competitor_lastname'];
  }
}
 ?>
