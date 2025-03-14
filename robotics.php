<?php
  $name=$_POST['name'];
  $rollnumber=$_POST['rollno'];
  $semester=$_POST['semester'];
  $phone=$_POST['phone'];
  if(!empty($name) || !empty($rollnumber) || !empty($semester) || !empty($phone))
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
        $SELECT= " SELECT rollnumber FROM robotics WHERE rollnumber =? Limit 1";
        $INSERT= "INSERT Into robotics (name,rollnumber,semester,phone) values(?,?,?,?)";
        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s",$rollnumber);
        $stmt->execute();
        $stmt->bind_result($rollnumber);
        $stmt->store_result();
        $rnum=$stmt->num_rows;
        if($rnum==0)
        {
            $stmt->close();
            $stmt=$conn->prepare($INSERT);
            $stmt->bind_param("ssii",$name,$rollnumber,$semester,$phone);
            $stmt->execute();
            header("Location: registration-success.html");

        }
        else{
            echo "Someone already registered using this rollnumber";
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