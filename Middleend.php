<?php

 $jsonResponse;

  //$postType = $_POST['postType'];
  $postType = "gradeExam";
  switch($postType){
   
    case "login":
	    $ucid = $_POST['ucid'];
	    $pass = $_POST['pass'];
      $log1 = login("https://web.njit.edu/~sm2327/betaback.php","postType=$postType&ucid=$ucid&pass=$pass");  
      echo $log1;   
      break;

    case "getAllQues":
          $log2 = login("https://web.njit.edu/~sm2327/betaback.php","postType=getAllQues");
          echo $log2;
     break;
    
    case "getSomeQues":
      $keyword=$_POST['keyword'];
      $topic=$_POST['topic'];
      $difficulty=$_POST['difficulty'];
          $log3 = login("https://web.njit.edu/~sm2327/betaback.php","postType=getSomeQues&keyword=$keyword&topic=$topic&difficulty=$difficulty");
          echo $log3;
     break;
     
     case "addNewQuestion":
      $new_func_name=$_POST['new_func_name'];
      $new_func_desc=$_POST['new_func_desc'];
      $testcase_1q=$_POST['testcase_1q'];
      $testcase_1a=$_POST['testcase_1a'];
      $testcase_2q=$_POST['testcase_2q'];
      $testcase_2a=$_POST['testcase_2a'];
      $new_func_keyword=$_POST['new_func_keyword'];
      $new_func_topic=$_POST['new_func_topic'];
      $difficulty=$_POST['difficulty'];    
      $log4 = login("https://web.njit.edu/~sm2327/betaback.php","postType=addNewQuestion&new_func_name=$new_func_name&new_func_desc=$new_func_desc&testcase_1q=$testcase_1q&testcase_1a=$testcase_1a&testcase_2q=$testcase_2q&testcase_2a=$testcase_2a&new_func_keyword=$new_func_keyword&new_func_topic=$new_func_topic&difficulty=$difficulty");
      echo $log4;
     break;
      
     case "makeNewTest":
      $new_test_name=$_POST['new_test_name'];
      $ques_ID_1=$_POST['ques_ID_1'];
      $point1 = $_POST['point1'];
      $ques_ID_2=$_POST['ques_ID_2'];
      $point2 = $_POST['point2'];
      $ques_ID_3=$_POST['ques_ID_3'];
      $point3 = $_POST['point3'];
      $ques_ID_4=$_POST['ques_ID_4'];
      $point4 = $_POST['point4'];
      $ques_ID_5=$_POST['ques_ID_5'];
      $point5 = $_POST['point5'];
      $totalPoints = $_POST['totalPoints'];
     $log5 = login("https://web.njit.edu/~sm2327/betaback.php","postType=makeNewTest&new_test_name=$new_test_name&ques_ID_1=$ques_ID_1&ques_ID_2=$ques_ID_2&ques_ID_3=$ques_ID_3&ques_ID_4=$ques_ID_4&ques_ID_5=$ques_ID_5&ques_points_1=$point1&ques_points_2=$point2&ques_points_3=$point3&ques_points_4=$point4&ques_points_5=$point5&totalPoints=$totalPoints");  
     echo $log5;
     break;
     
     case "getGradedExam":
      $log6 = login("https://web.njit.edu/~sm2327/betaback.php","postType=getGradedExam");
      echo $log6;
     break;
     
     case "finalizeGradedExam":
      $test_ID=$_POST['test_ID'];
      $time=$_POST['tt'];
      $student_UCID=$_POST['student_UCID'];
      $tc_1_success=$_POST['q_1_success'];
      $tc_2_success=$_POST['q_2_success'];
      $tc_3_success=$_POST['q_3_success'];
      $tc_4_success=$_POST['q_4_success'];
      $tc_5_success=$_POST['q_5_success'];
      $grade=$_POST['grade'];
      $finalize="YES";
      $comments=$_POST['teacher_comments'];
      $log7 = login("https://web.njit.edu/~sm2327/betaback.php","postType=finalizeGradedExam&test_ID=$test_ID&tt=$time&student_UCID=$student_UCID&q_1_success=$tc_1_success&q_2_success=$tc_2_success&q_3_success=$tc_3_success&q_r_success=$tc_4_success&q_5_success=$tc_5_success&grade=$grade&finalize=YES&teacher_comments=$comments");
      echo $log7;
      break;
      
      case "getExam":
      $test_ID = $_POST['test_ID'];
      $log8 = login("https://web.njit.edu/~sm2327/betaback.php","postType=getExam&test_ID=$test_ID");
      echo $log8;
      break;
      
      case "submitExam":  
      $student_ID = $_POST['student_ID'];
      $test_ID=$_POST['test_ID']; 
      $ques_ID_1=$_POST['ques_ID_1'];
      $ans_1=$_POST['ans_1'];
      $ques_ID_2=$_POST['ques_ID_2'];
      $ans_2=$_POST['ans_2'];
      $ques_ID_3=$_POST['ques_ID_3'];
      $ans_3=$_POST['ans_3'];
      $ques_ID_4=$_POST['ques_ID_4'];
      $ans_4=$_POST['ans_4'];
      $ques_ID_5=$_POST['ques_ID_5'];
      $ans_5=$_POST['ans_5'];
      
      $log9 = login("https://web.njit.edu/~sm2327/betaback.php","postType=submitExam&student_UCID=$student_ID&test_ID=$test_ID&ans_1=$ans_1&ans_2=$ans_2&ans_3=$ans_3&ans_4=$ans_4&ans_5=$ans_5");
      echo $log9;
      break;
      
      case "gradeExam":
      $student_ID = $_POST['student_ID'];
      $test_ID=$_POST['test_ID'];
      $time_taken=$_POST['time_taken']; 
      $grade = 0;
      $maxscore = 0;
      $tgrade = 0;
      $qArray = [];
      $worth = 0;
 			//Percent Factors
			$constraintFactor      = .1;
			$fnameFactor           = .3;
			$testCaseFactor        = .5;
      $colonFactor           = .1;
      //Worth Factors
			$constraintWorth = 0;
			$fnameWorth      = 0;
			$testcaseWorth   = 0;
      $colonWorth      = 0;
      //Init Send Values
			$earnedworth  = $worth;
			$autofeedback = "";
			$dfname       = 0;
			$dconstraint  = 0;
			$dcase1       = 0;
			$dcase2       = 0;
			$dcase3       = 0;
			$dcase4       = 0;
			$dcase5       = 0;
			$dcase6       = 0;
      $dcolon       = 0;
			$srcase1      = "srcase1";
			$srcase2      = "srcase2";
			$srcase3      = "srcase3";
			$srcase4      = "srcase4";
			$srcase5      = "srcase5";
			$srcase6      = "srcase6";  
      $response = login("https://web.njit.edu/~sm2327/rcback.php","postType=gradeExam&test_ID=13&student_ID=sk2273&time_taken=2019-10-22 14:05:21");
      $decode = json_decode($response, true, 3, JSON_PRETTY_PRINT);
      foreach($decode as $key => $value){
          foreach($value as $a => $b){
            echo "$a : $b<br>";
            if($a == 'ques_1_points'){
            $ques_1_points = $b;
            }
            if($a == 'ques_2_points'){
            $ques_2_points = $b;
            }
            if($a == 'ques_3_points'){
            $ques_3_points = $b;
            }
            if($a == 'ques_4_points'){
            $ques_4_points = $b;
            }
            if($a == 'ques_5_points'){
            $ques_5_points = $b;
            }
            if($a == 'ques_6_points'){
            $ques_6_points = $b;
            }
            if($a == 'total_points'){
            $total_points = $b;
            }
            if($a == 'ans_1'){
            $s_ans_1 = $b;
            }
            if($a == 'ans_2'){
            $s_ans_2 = $b;
            }
            if($a == 'ans_3'){
            $s_ans_3 = $b;
            }
            if($a == 'ans_4'){
            $s_ans_4 = $b;
            }
            if($a == 'ans_5'){
            $s_ans_5 = $b;
            }
            if($a == 'ans_6'){
            $s_ans_6 = $b;
            }
            if($a =='ques_ID_1'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            foreach($decode2 as $key2 => $value2){
              foreach($value2 as $c => $d){
                foreach($d as $e => $f){
                  //echo "$e : $f<br>";
                  if($e == 'new_func_name'){
                  $functionName = $f;
//                  echo $functionName;
//                  echo "\n";
                  }
                  if($e == 'testcase_1q'){
                  $case1 = $f;
                  }
                  if($e == 'testcase_1a'){
                  $rcase1 = $f;
                  }
                  if($e == 'testcase_2q'){
                  $case2 = $f;
                  }
                  if($e == 'testcase_2a'){
                  $rcase2 = $f;
                  }
                  if($e == 'testcase_3q'){
                  $case3 = $f;
                  }
                  if($e == 'testcase_3a'){
                  $rcase3 = $f;
                  }
                  if($e == 'testcase_4q'){
                  $case4 = $f;
                  }
                  if($e == 'testcase_4a'){
                  $rcase4 = $f;
                  }
                  if($e == 'testcase_5q'){
                  $case5 = $f;
                  }
                  if($e == 'testcase_5a'){
                  $rcase5 = $f;
                  }
                  if($e == 'testcase_6q'){
                  $case6 = $f;
                  }
                  if($e == 'testcase_6a'){
                  $rcase6 = $f;
                  echo $rcase6;
                  echo "hello";
                  
                  }
                }
              }
                  $cases = [$case1 => $rcase1, $case2 => $rcase2, $case3 => $rcase3, $case4 => $rcase4, $case5 => $rcase5, $case6 => $rcase6];
                  //var_dump($cases);
                  //NOW CALCULATE GRADE AND PUT IN VARIABLE OR JSON
                  			//if constraint exsist then lower total value of testcases
		 if ($constraint!=''){
				$testCaseFactor  = .6;
				$constraintWorth = floor($worth*$constraintFactor);
			}
			//Floor the fname Worth Factors
			$fnameWorth = floor($worth*$fnameFactor);
      
      //Floor colonworth factors
			$colonWorth = floor($worth*$colonFactor);
      
			//Add Up Testcase
			$casecount=0;
			foreach($cases as $case=>$caseResult){
				if($case!=''){
					$casecount += 1;
				}
			}
			$testCaseFactor = $testCaseFactor/$casecount;
			
			//Floor the Testcase Worth
			$testcaseWorth = floor($worth*$testCaseFactor);
			
			//Now Calculate Balance of Worth Factors
			$leftOver = $worth - $constraintWorth - $fnameWorth - ($testcaseWorth*$casecount) - $colonWorth;
			if($leftOver%2==0 && $constraint!=''){
				//Then split between constraint and fname worth
				$splitOver = $leftOver/2;
				$constraintWorth += $splitOver;
				$fnameWorth      += $splitOver;
			}
			else{
				if ($constraint!='' && $leftOver>2){
					$constraintWorth += 1;
					$fnameWorth      += $leftOver - 1;
				}
				else{
					$fnameWorth += $leftOver;
				}
			}			
			// END OF CALCULATE
			// -------------------------------------------------------
			
			//Check for the function name
			if(checkFunctionName($studentanswer, $functionName)!=0){
				$dfname = $fnameWorth;
				$earnedworth = $earnedworth - $fnameWorth;
			}
      
      if(deductcolon($studentanswer)!=0)
      {
        $dcolon = $colonWorth;
        $earnedworth = $earnedworth - $colonWorth;
      }
      //$earnedworth = $earnedworth - $colonWorth;
			//Function Name Correction - even if its correct
			$studentanswer = correctfunctionnname($studentanswer, $functionName);
      
			//colon check - even if its correct
			$studentanswer = checkcolon($studentanswer);
			//constraint check - CHECK ONLY IF IT EXSISTS
			if($constraint!=''){
				if(checkconstraints($constraint,$studentanswer)!=0){
					$dconstraint = $constraintWorth;
					$earnedworth = $earnedworth - $constraintWorth;
				}
			}
			//Test every valid test cases - not using foreachloop
			if($case1 != ''){
				//Set result
				$srcase1 = givestudentresult($studentanswer, $case1, $rcase1);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case1, $rcase1, $output)==0){
					$dcase1      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			if($case2 != ''){
				//Set result
				$srcase2 = givestudentresult($studentanswer, $case2, $rcase2);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case2, $rcase2, $output)==0){
					$dcase2      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			if($case3 != ''){
				//Set result
				$srcase3 = givestudentresult($studentanswer, $case3, $rcase3);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case3, $rcase3, $output)==0){
					$dcase3      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			if($case4 != ''){
				//Set result
				$srcase4 = givestudentresult($studentanswer, $case4, $rcase4);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case4, $rcase4, $output)==0){
					$dcase4      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			if($case5 != ''){
				//Set result
				$srcase5 = givestudentresult($studentanswer, $case5, $rcase5);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case5, $rcase5, $output)==0){
					$dcase5      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			if($case6 != ''){
				//Set result
				$srcase6 = givestudentresult($studentanswer, $case6, $rcase6);
				//Check if answer is wrong, if YES deduct points.
				if (checkAnswer($username, $studentanswer, $case6, $rcase6, $output)==0){
					$dcase6      = $testcaseWorth;
					$earnedworth = $earnedworth - $testcaseWorth;
				}
			}
			//Add the earned worth to the tgrade
			$tgrade = $tgrade + $earnedworth;
			//Add this question to be updated
			$qArray[$questionName] = [ 'earnedpoints' => $earnedworth, 'autofeedback' => $autofeedback, 'dcase1' => $dcase1, 'dcase2' => $dcase2, 'dcase3' => $dcase3, 'dcase4' => $dcase4, 'dcase5' => $dcase5, 'dcase6' => $dcase6, 'srcase1' => $srcase1, 'srcase2' => $srcase2, 'srcase3' => $srcase3, 'srcase4' => $srcase4, 'srcase5' => $srcase5, 'srcase6' => $srcase6, 'dfname' => $dfname, 'dconstraint' => $dconstraint, 'dcolon' => $dcolon];
			//echo hello;
    $jsonObj2->curlid="updatefeedback";
		$jsonObj->testName = $testname;
		$jsonObj->userName = $username;
		$jsonObj->grade = $tgrade;
		$jsonObj->questions = $qArray;
    $jsonObj2->dbAutoUpdate = $jsonObj;
		$payload = json_encode($jsonObj2);
		sendPayLoad($payload);
            }
          }
            if($a =='ques_ID_2'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            //var_dump($decode2);
           }
            if($a =='ques_ID_3'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            //var_dump($decode2);
          }
            if($a =='ques_ID_4'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            //var_dump($decode2);
          }
            if($a =='ques_ID_5'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            //var_dump($decode2);
          }
            if($a =='ques_ID_6'){
            $response2 = login("https://web.njit.edu/~sm2327/rcback.php","postType=getQuestionInfo&ques_ID=$b");
            $decode2 = json_decode($response2, true, 4);
            //var_dump($decode2);
          }
          
                }
          }
      break;
      
      
      case "getGradedExam":
      $student_ID = $_POST['student_ID'];
      $log11 = login("https://web.njit.edu/~sm2327/betaback.php","postType=getGradedExam&student_ID=$student_ID");
      echo $log11;
      break;
      
      case "findTest":
      $student_ID = $_POST['student_ID'];
      $log12 = login("https://web.njit.edu/~sm2327/betaback.php","postType=findTest&student_ID=$student_ID");
      echo $log12;
      break;
      
      case "gradeEachQues":
      $user = $_POST['user'];
      $studentAnswer = $_POST['studentAnswer'];
      $testCase = $_POST['testCase'];
      $testCaseAnswer = $_POST['testCaseAnswer'];
      $output = $_POST['testCaseAnswer'];
      
      $filename = 'mytestcase' . '.py';
      $file = fopen($filename, 'w');
      fwrite($file, "#!/usr/bin/env python \n");
      fwrite($file, $studentAnswer);
      $testCase = "\nprint(" . $testCase . ")";
      fwrite($file, $testCase);
      fclose($file);
      $out = exec("python $filename", $answerResult, $returnVal);
      $output = $answerResult[0];
      if ($answerResult[0] == $testCaseAnswer){
        return 1; //if the answers are the same return true
      }
      else{
        return 0; //if the answers are different, return false
	    }
      break;
       
    default:
  printf("default yash<br>");
      break;   
  }
function login($url,$data){
 $shreena = curl_init();
 curl_setopt($shreena, CURLOPT_TIMEOUT, 40000);
 curl_setopt($shreena, CURLOPT_RETURNTRANSFER, TRUE);
 curl_setopt($shreena, CURLOPT_URL, $url);
 curl_setopt($shreena, CURLOPT_FOLLOWLOCATION, TRUE);
 curl_setopt($shreena, CURLOPT_POST, TRUE);
 curl_setopt($shreena, CURLOPT_POSTFIELDS, $data);
 $userdata = curl_exec($shreena);
 //echo $userdata;
 if (strpos($userdata, 'good') !== false){
 	$jsonResponse->db="good";
    					 }
 else {
 	$jsonResponse->db="bad";
      }
  if (strpos($userdata, 'Student') !== false){
 	$jsonResponse->occu="Student";
    					 }
  else if (strpos($userdata, 'Teacher') !== false){
 	$jsonResponse->occu="Teacher";
    					 }
 $shreenaiscool = json_encode($jsonResponse);
 return $userdata;
}

function givestudentresult($studentAnswer, $testCase, $testCaseAnswer){
    $pyfile = 'studentresult' . '.py';
    $file = fopen($pyfile, 'w');
    fwrite($file, "#!/usr/bin/env python \n");
    fwrite($file, $studentAnswer);
    $testCase = "\nprint(" . $testCase . ")";
    fwrite($file, $testCase);
    fclose($file);
    $out = exec("python $pyfile", $answerResult, $returnVal);
    $output = $answerResult[0];
    return $output;
}

function checkFunctionName($answer, $fName){
	$x = strpos($answer, $fName);
	if(!$x){
		//FAILED
		return 1;
	}
	else{
		//SUCCEED
		return 0;
	}
}
function questionvalue($w, $pointDivide){
  $temp = $w*$pointDivide;
  return $temp;
}
function correctfunctionnname($answer, $fName){
  $v=strpos($answer, $fName);
  if($v===0){                         //find student's functionname and swap the string
    return $answer;
  }
  else{
    $defFirstIdx=stripos($answer, "def ");
    $parensFirstIdx  =stripos($answer, "(");
    $answerFuncNameStartIdx = $defFirstIdx + 4;
    $answerFuncNameLen = $parensFirstIdx - $answerFuncNameStartIdx;
    
    $correctfunc = substr_replace($answer, $fName, $answerFuncNameStartIdx, $answerFuncNameLen);
    return $correctfunc;
    
  }
}

function sendPayLoad($payload){
	$curlInit = curl_init();
	$post = [ 'data' => "$payload" ];

	curl_setopt($curlInit, CURLOPT_URL,  "https://web.njit.edu/~sm2327/rcback.php");
	curl_setopt($curlInit, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt($curlInit, CURLOPT_POST, 1);
	curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curlInit);
  //echo $response;
	//DB Response
	curl_close($curlInit);
}

function checkconstraints($constraints,$answer){
  
  if ($constraints=="forloop"){
    		if (preg_match("/\s*for\s*.*:/", $answer)){
				  return 0;
		    }
		    else {
          return 1;
        }
    	}
 	else if ($constraints=="whileloop"){
    		if (preg_match("/\s*while\s*\(.*\).*:/", $answer)){
   			  return 0;
    		}
    		else {
          return 1;
        }
    	}
  else if ($constraints=="print"){
    		if (preg_match("/\s*print\s*\(.*\)/", $answer)){
   			  return 0;
    		}
    		else {
          return 1;
        }
    	}
  else
  {
        return 0;
  }
}

function checkcolon($ans){
  if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b/", $ans)){
    //for where there is a for, if , else etc.... check to see if there is a colon at the end of the line
    
    $separator = "\r\n";
    $line = strtok($ans, $separator);
    $line1 = "";
    while ($line !== false) {
        if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b|\belif\b/", $line)){
          //check if it ends with a colon
          if (preg_match('/:$/', $line)) {
            
            $line1 .= $line . $separator;
          }
          else{
            //$dcolon=$colonWorth;
            //add the colon at the end of the line
            $line1 .= $line . ":" . $separator; 
          }
        }
        else {
          $line1 .= $line . $separator;
        }
        $line = strtok( $separator );
    }
    $ans = $line1;
    return $ans;
 }
}
function checkAnswer($user, $studentAnswer, $testCase, $testCaseAnswer, &$output){
    $filename = 'ztestcase' . '.py';
    $file = fopen($filename, 'w');
    
    fwrite($file, "#!/usr/bin/env python \n");
    fwrite($file, $studentAnswer);
    $testCase = "\nprint(" . $testCase . ")";
    fwrite($file, $testCase);
    fclose($file);
    $out = exec("python $filename", $answerResult, $returnVal);
    $output = $answerResult[0];
    //echo $output;
    if ($answerResult[0] == $testCaseAnswer){
      return 1;
    }
    else{
      return 0;
	  }
}
function deductcolon($ans){
  
  if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b/", $ans)){
    //for where there is a for, if , else etc.... check to see if there is a colon at the end of the line
    
    $separator = "\r\n";
    $line = strtok($ans, $separator);
    $line1 = "";
    while ($line !== false) {
        if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b|\belif\b/", $line)){
          //check if it ends with a colon
          if (preg_match('/:$/', $line)) {
            return 0;
            $line1 .= $line . $separator;
          }
          else{
            return 1;
            //add the colon at the end of the line
            //$line1 .= $line . ":" . $separator; 
          }
        }
        else {
          //return 0;
          $line1 .= $line . $separator;
        }
        $line = strtok( $separator );
    }
    $ans = $line1;
    return 1;
 }
 else{
   return 1;
 }
}