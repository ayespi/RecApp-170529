<?php
class Team{
  public $connection;
  public $id;
  public $name;
  public $leader;
  public $data;
  public $json;

  public function __construct($connection){
    $this->connection = $connection;
    $this->create_team_table();
  }

  public function create_team_table(){

  }

  public function get_teams(){
    $sql = $this->get_select_team_query();
    $result = mysqli_query($this->connection, $sql);
    return $this->get_all_teams_data($result);
  }

  public function get_select_team_query(){
    return $sql = "SELECT * FROM teams;";
  }

  public function get_all_teams_data($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
      $this->data[] = array(
        'id'            =>      $row['team_id'],
        'name'          =>      $row['team_name'],
        'leader'        =>      $row['team_leader'],
        'date_entered'  =>      $row['team_date_entered']
      );
    }
    $this->json = json_encode($this->data);
    return $this->data;
  }

  public function get_team_leader($team_id){

  }
} ?>
