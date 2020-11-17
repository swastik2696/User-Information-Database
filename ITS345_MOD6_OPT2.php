<!DOCTYPE html>
<html>
<body>
<style>
table {
  border-collapse: collapse;
}
td, th {
  border: 2px solid grey;
  text-align: center;
  padding: 8px;
}
</style>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <label for="fname">Name:</label>
  <input type="text" name="name"><br><br>
  <label for="lname">Address:</label>
  <input type="text" name="address"><br><br>
  <label for="lname">Email:</label>
  <input type="text" name="email"><br><br>
  <label for="lname">Phone Number:</label>
  <input type="number" name="phoneNumber"><br><br>
  <label for="date">Date:</label>
  <input type="date" name="date"><br><br>
  <input type="submit" value="Submit" name="submit">
  <input type="submit" value="Display All" name="displayAll" style="margin-left:110px;">
</form>
<?php
$conn = new mysqli("localhost", "root", "root", "test");

function insertData($var_name, $var_address, $var_email, $var_phoneNumber, $var_date){
 global $conn;
    
 $sql = "INSERT INTO data VALUES (?, ?, ?, ?, ?);";
 
 $stmt = $conn->prepare($sql);
 if($stmt === false){
  }
  
  $SQLi_Check= $stmt->bind_param("sssss", $var_name, $var_address, $var_email, $var_phoneNumber, $var_date);
  
  if($SQLi_Check === false){
      echo "Failed to bind values: " . mysqli_error($conn);
  }
  if($stmt->execute() === true){
      echo "<script>alert('Successfully Submitted!');</script>";
  } else {
      echo "Failed to Submit: " . mysqli_error($conn);
  }
  $stmt->close();
  $conn->close();
}
function selectAll(){
    global $conn;
    $result = $conn->query("SELECT * FROM data;");
   
    echo "<table><tr><th>Name</th><th>Address</th><th>Email Address</th><th>Phone Number</th><th>Date</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row['Name']."</td><td>".$row['Address']."</td><td>".$row['Email_Address']."</td><td>".$row['Phone_Number']."</td><td>".$row['Date']."</td></tr>/";
        $conn->close();
   }
}

if($conn ->connect_error){
    echo "Connecion Failed: ".$conn->connect_error;
}

if(isset($_REQUEST['submit'])){
    $maxVar = 65535;
    $maxInt = 2147483647;
    
    $name = $_REQUEST['name'];
    $address = $_REQUEST['address'];
    $email = $_REQUEST['email'];
    $phoneNumber = $_REQUEST['phoneNumber'];
    $date = $_REQUEST['date'];
    
    if ($name < $maxVar && $address < $maxVar && $email < $maxVar && $phoneNumber < $maxInt){
    insertData($name, $address, $email, $phoneNumber, $date);
    } else {
        echo "<script>alert('One of your given Inputs is too big. Please not that only 9 digit numbers are allowed!');</script>";
    }
}
if(isset($_REQUEST['displayAll'])){
    selectAll();
}
?>
</body>
</html>
