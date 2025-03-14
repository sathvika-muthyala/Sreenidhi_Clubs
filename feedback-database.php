<?php
  $name=$_POST['cf-name'];
  $email=$_POST['cf-email'];
  $phone=$_POST['cf-number'];
  $year_of_study=$_POST['cf-budgets'];
  $feedback=$_POST['cf-message'];
  if(!empty($name) || !empty($email) || !empty($year_of_study) || !empty($phone) || !empty($feedback))
  {
    $host="localhost";
    $dbUsername="root";
    $dbPassword="";
    $dbname="register";

    $conn=new mysqli($host,$dbUsername,$dbPassword,$dbname);

    if(mysqli_connect_error()){
        die('Connect Error('.mysqli_connect_errno.')'.mysqli_connect_error());
    }
    else{
        $SELECT= " SELECT email FROM feedback WHERE email =? Limit 1";
        $INSERT= "INSERT Into feedback (name,email,phone,year_of_study,feedback) values(?,?,?,?,?)";
        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;
        if($rnum==0)
        {
            $stmt->close();
            $stmt=$conn->prepare($INSERT);
            $stmt->bind_param("ssiss",$name,$email,$phone,$year_of_study,$feedback);
            $stmt->execute();
            echo "Thank for your feedback";

        }
        $stmt->close();
        $conn->close();
    }
  }
  else{
    echo "All fields are required";
    die();
  }
?>