<?php
class Week{
  public $connection;
  public $id;
  public $date_started;
  public $description;
  public $results_posted;
  public $data;
  public $json;

  public function __construct($connection){
    $this->connection = $connection;
    $this->create_weeks_table();
  }

  public function get_weeks(){
    $result     = $this->get_weeks_result();
    $this->get_weeks_data($result);
    return $this->data;
  }

  public function get_weeks_result(){
    $sql = "SELECT * FROM weeks;";
    return mysqli_query($this->connection, $sql);
  }

  public function get_weeks_data($result){
    $this->data = array();
    while($row = mysqli_fetch_assoc($result)){
          $this->data[] = array(
            'id'              =>    $row['week_id'],
            'date_started'    =>    $row['week_date_started'],
            'description'     =>    $row['week_description'],
            'results_posted'  =>    $row['week_results_posted']
          );
    }
    $this->json = json_encode($this->data);
  }

  public function get_date_posted($id){
    $this->id = $id + 1;
    $result   = $this->get_date_posted_result();
    return $this->get_date($result);
  }

  public function get_date_posted_query(){
    return $sql = "SELECT * FROM weeks WHERE week_id='$this->id';";
  }

  public function get_date_posted_result(){
    $sql            = $this->get_date_posted_query();
    return $result  = mysqli_query($this->connection, $sql);
  }

  public function get_date($result){
    $row            = mysqli_fetch_assoc($result);
    $results_posted = $row['week_results_posted'];
    return $date    = $results_posted;
  }

  public function create_weeks_table(){
    $sql = "CREATE TABLE IF NOT EXISTS `mybod4god`.`weeks` (
       `week_id` INT NOT NULL AUTO_INCREMENT ,
        `week_date_started` VARCHAR(20) NOT NULL ,
         `week_description` VARCHAR(20) NOT NULL ,
          `week_results_posted` VARCHAR(20) NOT NULL ,
           PRIMARY KEY (`week_id`)
         ) ENGINE = InnoDB;";
         mysqli_query($this->connection, $sql);
  }

}

// INSERT INTO `weeks` (`week_id`, `week_date_started`, `week_description`, `week_results_posted`) VALUES (NULL, 'January 12th', 'Orientation', ''), (NULL, 'January 19th', 'Week 1', 'January 26th');
 ?>
