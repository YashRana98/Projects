<?php

//Connecting to MYSQL database
	$servername = "sql1.njit.edu";
	$username = "sm2327";
	$password = "IVVsJ19jl";
	$db = "sm2327";

	$conn = mysqli_connect($servername, $username, $password, $db);

	if (!$conn){
		die("connection error : " . mysqli_connect_error());
	}

	//POST Get
  $posttype = $_POST['postType'];
  
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//---------------------------TEACHER PAGE QUERIES--------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
  switch($posttype){
    
    case "login":
  	  
      //if (($_POST['ucid'] && $_POST['pass'])){
	    $ucid = $_POST['ucid'];
      $pass = $_POST['pass'];
      //}
      
      //$ucid="sk2273";
	    //Viewing DB values 
	    //$sql = "SELECT * FROM Alpha WHERE UCID='$ucid'";
      
      $sql = "CALL p_SelectUser('$ucid')";
	    $result = mysqli_query($conn, $sql);
	    if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
          //echo mysqli_fetch_assoc($result);
			    $dbucid = $row["UCID"];
			    $dbpass = $row["Password"];
          $dboccu = $row["Occupation"];
			    //printf ("%s (%s)\n",$dbucid,$dbpass);
		    }
	    }

	    else {
	      //echo "0 results";
	    }

	    //POST compare to MYSQL
	    $pass1 = hash('sha256', $pass);
	    $dbresult;
	    if (strcmp($ucid, $dbucid) == 0){
		    if (strcmp($pass1, $dbpass) == 0){
			    $dbresult->db="good";
          $dbresult->occu=$dboccu;
			    //echo "1<br>";
		    }
		    else{
			    $dbresult->db="bad";
			    //echo "2<br>";
		    }
	    }
	    else{
		    $dbresult->db="bad";
		    //echo "3<br>";
	    }
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
		  //echo "post recieved! <br>";
      break;
//-------------------------------------------------------------------------------    
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
    case "addNewQuestion":
      
      $new_func_name=$_POST['new_func_name'];
      $new_func_desc=$_POST['new_func_desc'];
      $testcase_1q=$_POST['testcase_1q'];
      $testcase_1a=$_POST['testcase_1a'];
      $testcase_2q=$_POST['testcase_2q'];
      $testcase_2a=$_POST['testcase_2a'];
      $testcase_3q=$_POST['testcase_3q'];
      $testcase_3a=$_POST['testcase_3a'];
      $testcase_4q=$_POST['testcase_4q'];
      $testcase_4a=$_POST['testcase_4a'];
      $testcase_5q=$_POST['testcase_5q'];
      $testcase_5a=$_POST['testcase_5a'];
      $testcase_6q=$_POST['testcase_6q'];
      $testcase_6a=$_POST['testcase_6a'];
      $new_func_keyword=$_POST['new_func_keyword'];
      $new_func_topic=$_POST['new_func_topic'];
      $difficulty=$_POST['difficulty']; 
      $constraint=$_POST['constraint'];           
      
      $sql = "CALL p_AddNewQuestion('$new_func_name', '$new_func_desc', '$testcase_1q', '$testcase_1a', '$testcase_2q', '$testcase_2a', '$testcase_3q', '$testcase_3a', '$testcase_4q', '$testcase_4a', '$testcase_5q', '$testcase_5a', '$testcase_6q', '$testcase_6a', '$new_func_topic', '$difficulty', '$constraint')";
      
	    //$result = mysqli_query($conn, $sql);
      $dbresult;
      if ($conn->query($sql) === TRUE) {
        echo "success";
        //$dbresult->result="success";
        //echo "New question created successfully<br>";
      } 
      else {
        echo "failure";
        //$dbresult->result="fail";
        //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
      
      //$mysqlresult = json_encode($dbresult);
	    //echo $mysqlresult;
      break;  
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
    case "getAllQues":
    
      $sql = "CALL p_GetAllTestBank()";
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = $row['question_ID'];
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      else {
	      echo "0 questions in the bank<br>";
	    }

	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
    case "makeNewTest":
      
      $new_test_name=$_POST['new_test_name'];
      $ques_ID_1=$_POST['ques_ID_1'];
      $ques_ID_2=$_POST['ques_ID_2'];
      $ques_ID_3=$_POST['ques_ID_3'];
      $ques_ID_4=$_POST['ques_ID_4'];
      $ques_ID_5=$_POST['ques_ID_5'];
      $ques_points_1 =$_POST['ques_points_1']; 
      $ques_points_2 =$_POST['ques_points_2'];
      $ques_points_3 =$_POST['ques_points_3'];
      $ques_points_4 =$_POST['ques_points_4'];
      $ques_points_5 =$_POST['ques_points_5'];
      $tot_points =$_POST['totalPoints'];
            
      $sql = "CALL p_MakeNewTest('$new_test_name', '$ques_ID_1', '$ques_ID_2', '$ques_ID_3', '$ques_ID_4', '$ques_ID_5', '$ques_points_1', '$ques_points_2', '$ques_points_3', '$ques_points_4', '$ques_points_5', '$tot_points')";
      
	    //$result = mysqli_query($conn, $sql);

      if ($conn->query($sql) === TRUE) {
        echo "New test created successfully<br>";
      } 
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
      break;  
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
    case "getSomeQues": //getSpecificQuestions
    
      $keyword=$_POST['keyword'];
      $topic=$_POST['topic'];
      $difficulty=$_POST['difficulty'];
      $constraint=$_POST['constraint'];
      
      if (($keyword != NULL)&&($topic != NULL)&&($difficulty != NULL)){  
        $sql = "CALL p_ktdGetSpecificQuestions('$keyword', '$topic', '$difficulty', '$constraint')";
      }
      else if(($keyword != NULL)&&($topic != NULL)){
        $sql = "CALL p_ktGetSpecificQuestions('$keyword', '$topic', '$constraint')";
      }
      else if(($difficulty != NULL)&&($topic != NULL)){
        $sql = "CALL p_tdGetSpecificQuestions('$difficulty', '$topic', '$constraint')";
      }
      else if(($keyword != NULL)&&($difficulty != NULL)){
        $sql = "CALL p_kdGetSpecificQuestions('$difficulty', '$keyword', '$constraint')";
      }
      else if($keyword != NULL){
        $sql = "CALL p_kGetSpecificQuestions('$keyword', '$constraint')";
      }
      else if($topic != NULL){
        $sql = "CALL p_tGetSpecificQuestions('$topic', '$constraint')";
      }
      else if($difficulty != NULL){
        $sql = "CALL p_dGetSpecificQuestions('$difficulty', '$constraint')";
      }
      else{
        continue;
      }
      
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = $row['question_ID'];
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
     
      else {
	      echo "0 questions in the bank<br>";
	    }
         
      //$dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
    case "getGradedExam":

      $sql = "CALL p_GetGradedExam()";
 	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array();
       
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $r[] = $row;
        }
      }
      
      else {
	      echo "0 graded exams in the bank<br>";
	    }
         
      $dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

    case "getSpecificGradedExam":

      $student_UCID = $_POST['student_UCID'];
      $tt = $_POST['time'];
      $t_ID = $_POST['test_ID'];
      
      $sql = "CALL p_GetSpecificGradedExam('$student_UCID', '$tt', '$t_ID')";
 	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array();
      
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $r[] = $row;
        }
      }
      else {
	      echo "0 graded exams in the bank<br>";
	    }
         
      $dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;
      
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

case "payload":

      $test_ID=$_POST['test_ID'];
      $student_UCID=$_POST['student_UCID'];
      $time=$_POST['time'];
      $q_ID = $_POST['question_ID'];
      $name_success = $_POST['name_success'];
      $name_points_lost = $_POST['name_points_lost'];
      $colon_success = $_POST['colon_success'];
      $colon_points_lost = $_POST['colon_points_lost'];
      $constraint_success = $_POST['constraint_success'];
      $constraint_points_lost = $_POST['constraint_points_lost'];
      $testcase_1_success = $_POST['testcase_1_success'];
      $testcase_1_points_lost = $_POST['testcase_1_points_lost'];
      $testcase_2_success = $_POST['testcase_2_success'];
      $testcase_2_points_lost = $_POST['testcase_2_points_lost'];
      $testcase_3_success = $_POST['testcase_3_success'];
      $testcase_3_points_lost = $_POST['testcase_3_points_lost'];
      $testcase_4_success = $_POST['testcase_4_success'];
      $testcase_4_points_lost = $_POST['testcase_4_points_lost'];
      $testcase_5_success = $_POST['testcase_5_success'];
      $testcase_5_points_lost = $_POST['testcase_5_points_lost'];
      $testcase_6_success = $_POST['testcase_6_success'];
      $testcase_6_points_lost = $_POST['testcase_6_points_lost'];      
      $finalize="NO";
      $total_points=$_POST['grade'];

      $sql = "CALL p_GradeQuestion('$test_ID', '$student_UCID', '$time', '$q_ID', '$name_success', '$name_points_lost', '$colon_success', '$colon_points_lost', '$constraint_success', '$constraint_points_lost', '$testcase_1_success', '$testcase_1_points_lost', '$testcase_2_success', '$testcase_2_points_lost', '$testcase_3_success', '$testcase_3_points_lost', '$testcase_4_success', '$testcase_4_points_lost', '$testcase_5_success', '$testcase_5_points_lost', '$testcase_6_success', '$testcase_6_points_lost', '$finalize', '$total_points')";

	    if ($conn->query($sql) === TRUE) {
        echo "Exam question " . $q_ID . " graded successfully<br>";
      } 
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
      break; 
      
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

    case "finalizeGradedExam":

      $test_ID=$_POST['test_ID'];
      $time=$_POST['tt'];
      $student_UCID=$_POST['student_UCID'];
      $grade=$_POST['grade'];
      $finalize="YES";
      $comments=$_POST['teacher_comments'];   
      $tc_1_points=$_POST['tc_1_points'];
      $tc_2_points=$_POST['tc_2_points'];
      $tc_3_points=$_POST['tc_3_points'];
      $tc_4_points=$_POST['tc_4_points'];
      $tc_5_points=$_POST['tc_5_points'];
      $tc_6_points=$_POST['tc_6_points'];
      $q_ID = $_POST['question_ID'];
      $q_comments = $_POST['q_comments'];
      
      $sql = "CALL p_FinalizeGradedExam('$test_ID', '$time', '$student_UCID', '$grade', '$finalize', '$comments', '$tc_1_points', '$tc_2_points', '$tc_3_points', '$tc_4_points', '$tc_5_points', '$tc_6_points', '$q_ID', '$q_comments')";
      
 	    //$result = mysqli_query($conn, $sql);

      if ($conn->query($sql) === TRUE) {
        echo "Test finalized successfully<br>";
      } 
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
      break;  
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//---------------------------STUDENT PAGE QUERIES--------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

    case "getExam":      
    
      $test_ID = $_POST['test_ID'];
      $sql = "SELECT a.*, b.ques_ID_1, b.ques_1_points
              FROM tbl_ListOfQuestions a
              INNER JOIN tbl_ListOfTests b
              WHERE a.question_ID = b.ques_ID_1
              AND b.test_ID = '$test_ID';";
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = "question_1";
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      $sql = "SELECT a.*, b.ques_ID_2, b.ques_2_points
              FROM tbl_ListOfQuestions a
              INNER JOIN tbl_ListOfTests b
              WHERE a.question_ID = b.ques_ID_2
              AND b.test_ID = '$test_ID'";
	    $result = mysqli_query($conn, $sql);
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = "question_2";
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }

      $sql = "SELECT a.*, b.ques_ID_3, b.ques_3_points
              FROM tbl_ListOfQuestions a
              INNER JOIN tbl_ListOfTests b
              WHERE a.question_ID = b.ques_ID_3
              AND b.test_ID = '$test_ID'";
	    $result = mysqli_query($conn, $sql);
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = "question_3";
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
                
      $sql = "SELECT a.*, b.ques_ID_4, b.ques_4_points
              FROM tbl_ListOfQuestions a
              INNER JOIN tbl_ListOfTests b
              WHERE a.question_ID = b.ques_ID_4
              AND b.test_ID = '$test_ID'";
	    $result = mysqli_query($conn, $sql);
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = "question_4";
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      
      $sql = "SELECT a.*, b.ques_ID_5, b.ques_5_points
              FROM tbl_ListOfQuestions a
              INNER JOIN tbl_ListOfTests b
              WHERE a.question_ID = b.ques_ID_5
              AND b.test_ID = '$test_ID'";
	    $result = mysqli_query($conn, $sql);
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = "question_5";
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      
      //$dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;
      
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
      
    case "findTest":      
    
      $s_ID = $_POST['student_ID'];
      $sql = "CALL p_FindTest('$s_ID')";
      
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = $row['test_ID'];
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      else {
	      echo "0 tests in the bank<br>";
	    }

	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;	

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
      
    case "getAllFinalizedExams":      
    
      $s_ID = $_POST['student_ID'];
      $sql = "CALL p_GetAllFinalizedExam('$s_ID')";
      
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = $row['test_ID'];
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      else {
	      echo "0 tests in the bank<br>";
	    }

	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;	

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------				

      
    case "viewGradedQuestion":      
    
      $t_ID = $_POST['test_ID'];
      $s_ID = $_POST['student_UCID'];
      $t_t = $_POST['time_taken'];
      $q_ID = $_POST['question_ID'];
      $sql = "CALL p_ViewGradedQuestion('$t_ID', '$s_ID', '$t_t', '$q_ID')";
      
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $qid = $row['question_ID'];
          $desc = $row;
          $dbresult->$qid=$desc;
        }
      }
      else {
	      echo "0 questions in the bank<br>";
	    }

	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
            
      break;  

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------		
      
    case "finalizeGradedQuestion":      
    
      $t_ID = $_POST['test_ID'];
      $s_ID = $_POST['student_UCID'];
      $t_t = $_POST['time_taken'];
      $q_ID = $_POST['question_ID'];
      $sql = "CALL p_ViewGradedQuestion('$t_ID', '$s_ID', '$t_t', '$q_ID')";
      
	    if ($conn->query($sql) === TRUE) {
        echo "Question graded successfully<br>";
      } 
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
      break;  

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------		



    case "getFinalizedExam":      
    
      $student_UCID = $_POST['student_UCID']; 
      $tt = $_POST['time_taken'];
      $t_ID = $_POST['test_ID'];
      
      $sql = "CALL p_GetFinalizedExam('$student_UCID', '$t_ID', '$tt')";
    	
      $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $r[] = $row;
        }
      }
      else {
	      echo "0 questions in the bank<br>";
	    }
         
      $dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;      	
      
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

    case "submitExam":      
      //echo "hi there";

      $student_UCID = $_POST['student_UCID'];
 
      $test_ID = $_POST['test_ID'];
      $a1 = $_POST['ans_1'];
      $a2 = $_POST['ans_2'];
      $a3 = $_POST['ans_3'];
      $a4 = $_POST['ans_4'];
      $a5 = $_POST['ans_5'];      
      
      $sql = "CALL p_SubmitTest('$student_UCID', '$a1', '$a2', '$a3', '$a4', '$a5', '$test_ID')";   
      
      if ($conn->query($sql) === TRUE) {
        echo "Test submitted successfully<br>";
      } 
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
            
      break;

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

    case "gradeExam":      
      //echo "hi there";

      $student_UCID = $_POST['student_ID'];
 
      $test_ID = $_POST['test_ID'];
      //$time_taken = $_POST['time_taken'];      
      
      /*$sql = "SELECT a.test_ID, a.student_UCID, a.time_taken, a.ques_ID_1, a.ans_1, a.ques_ID_2, a.ans_2, a.ques_ID_3, a.ans_3, a.ques_ID_4, a.ans_4, a.ques_ID_5, a.ans_5, b.ques_1_points, b.ques_2_points, b.ques_3_points, b.ques_4_points, b.ques_5_points, b.total_points 
FROM tbl_ListOfCompletedTests as a 
JOIN tbl_ListOfTests as b
WHERE a.test_ID = b.test_ID
AND a.test_ID = 13
AND a.ques_ID_1 = b.ques_ID_1; "; */

            $sql = "SELECT a.test_ID, a.student_UCID, a.time_taken, a.ques_ID_1, a.ans_1, a.ques_ID_2, a.ans_2, a.ques_ID_3, a.ans_3, a.ques_ID_4, a.ans_4, a.ques_ID_5, a.ans_5, b.ques_1_points, b.ques_2_points, b.ques_3_points, b.ques_4_points, b.ques_5_points, b.total_points 
      FROM tbl_ListOfCompletedTests as a 
      JOIN tbl_ListOfTests as b
      WHERE a.test_ID = b.test_ID
      AND a.student_UCID = '$student_UCID'
      AND a.test_ID = '$test_ID'
      AND a.ques_ID_1 = b.ques_ID_1; ";   
      //AND a.time_taken = '$time_taken'
      
	    $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      //$r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $tt = $row['time_taken'];
          $desc = $row;
          $dbresult->$tt=$desc;
        }
      }
      else {
	      echo "No Such Exam Found<br>";
	    }

	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
      
    case "getQuestionInfo":      
    
      $qID = $_POST['ques_ID'];
      
      $sql = "SELECT * FROM tbl_ListOfQuestions WHERE question_ID = '$qID';";
    	
      $result = mysqli_query($conn, $sql);
      $dbresult;
	    $numRows = mysqli_num_rows($result);
      $r = array(); 
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $r[] = $row;
        }
      }
      else {
	      echo "0 questions in the bank<br>";
	    }
         
      $dbresult->table=$r;
      
	    $mysqlresult = json_encode($dbresult);
	    echo $mysqlresult;
      
      break;

    default:
      
      printf("error: improper postType<br>");
      
      break;	
  }
  
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------

	//Close MYSQL connection
	$conn->close();
?>
