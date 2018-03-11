<?php
  session_start();
  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  if(isset($_POST['submit'])){

     $username = $_SESSION['logged_in_user']['username'];
    $title = $title_keyword;
    $department = $department_keyword;
    $company = $company_keyword;

     $procedure_params['username'] = $_SESSION['logged_in_user']['username'];
    $procedure_params['title'] = $title;
    $procedure_params['department'] = $department_keyword;
    $procedure_params['company'] = $company_keyword;

    for($i = 0; $i < sizeof($_POST); $i++){
      if(isset($_POST['question'. $i ]) && isset($_POST['answer' . $i])){
        $question = intval($_POST['question'. $i ]);
        $answer = $_POST['answer' . $i];
        $procedure_params['question'] = $question;
        $procedure_params['answer'] = $answer;

  
        $procedure_passed_params = array(
        array(&$procedure_params['username'], SQLSRV_PARAM_IN),
        array(&$procedure_params['title'], SQLSRV_PARAM_IN),
        array(&$procedure_params['department'], SQLSRV_PARAM_IN),
        array(&$procedure_params['company'], SQLSRV_PARAM_IN),
        array(&$procedure_params['question'], SQLSRV_PARAM_IN),
        array(&$procedure_params['answer'], SQLSRV_PARAM_IN),
        );

        $sql_save = 'exec Save_Score @username = ?, @title = ?, @department = ?, @company = ?, @question = ?, @answer = ?';
        $stmt_save = sqlsrv_prepare($conn, $sql_save, $procedure_passed_params);

        
        if(!$stmt_save){
          var_dump($stmt_save);
          die( print_r( sqlsrv_errors(), true));
        }

        if(sqlsrv_execute($stmt_save)) {
        while($res = sqlsrv_next_result($stmt_save)) {/* pass */};
        
        }

      }

    }
    //edited
    header('Location: seeker_view_status.php?status=done');
    //
    die();

  }
  
  //if(isset($_POST['apply'])){
    $questions = array();

    $sql_pk = "select j.department, j.company from Jobs j, Departments d, Companies c where c.name = '" 
    . $company_keyword . "' and d.name = '" 
    . $department_keyword. "' and j.title = '" 
    . $title_keyword . "' and d.code = j.department and c.email = j.company";

    $stmt_pk = sqlsrv_query($conn, $sql_pk);

    if(!$stmt_pk) {
      die( print_r( sqlsrv_errors(), true));

    }

    $pk = sqlsrv_fetch_array($stmt_pk, SQLSRV_FETCH_ASSOC);
      
    $username = $_SESSION['logged_in_user']['username'];
    $title = $title_keyword;
    if(!empty($pk)){
      $department = $pk['department'];
      $company = $pk['company'];
    }

    $procedure_params['username'] = $_SESSION['logged_in_user']['username'];
    $procedure_params['title'] = $title;
    $procedure_params['department'] = $department_keyword;
    $procedure_params['company'] = $company_keyword;

    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['title'], SQLSRV_PARAM_IN),
      array(&$procedure_params['department'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
    );

    $sql_view = "EXEC View_Questions @username = ?, @job = ?, @department = ?, @company = ?";
    
    $stmt_view = sqlsrv_prepare($conn, $sql_view, $procedure_passed_params);

    if(!$stmt_view) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($stmt_view)) {
      while($row = sqlsrv_fetch_array($stmt_view, SQLSRV_FETCH_ASSOC)) {
      array_push($questions, $row);
      }
    }
  /*}else{
    die( print_r( sqlsrv_errors(), true));
  }*/

?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?>
</head>

<body>

  <?php include_once 'templates/navbar.tpl.php';?>

    <?php if(isset($flash_message)): ?>
    <div class="container">
      <div class = "row">
        <div class="col-sm-12">
         <?php echo $flash_message; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if(isset($questions)): ?>
    <form action="<?php echo "seeker_job_questions.php?company_keyword=".$company_keyword."&department_keyword=".$department_keyword."&title_keyword=".$title_keyword ?>" method="POST" class="form-group container">
      <?php for($i=0; $i<sizeof($questions); $i++): ?>
        <div>
          <label><strong><?php echo $questions[$i]['question'] ?></strong></label>
          <input type = 'hidden' name = "<?php echo 'question'. $i?>" value = "<?php echo $questions[$i]['number'] ?>">
          <div class="form-group">
          <select class="form-control" id="sel1" name = "<?php echo 'answer'. $i?>">
            <option value="True">Yes</option>
            <option value="False">No</option>
          </select>
        </div>
        </div>
      <?php endfor; ?>
      <button class="btn btn-primary" type="submit" name = "submit">Submit Answers</button>

    </form>
  <?php endif; ?>

  <?php include_once 'includes/scripts.php';?>

</body>
</html> 