<?php
    include("config/config.php");

    $config = new Config();
    // $res = $config->initDB();

    // if($res){
    //     echo "DB Successfully Connnected...";
    // }
    // else{
    //     echo "Sorry DB not Connnected...";
    // }

    //Insert Student
   if(isset($_REQUEST['submit'])){
      $name = $_GET['name'];
      $age = $_GET['age'];
      $course = $_GET['course'];

      $res = $config->insertData($name, $age, $course);

      if($res){
        header("Location: dashboard.php");
        echo '<div class="container pt-5"><div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Data Inserted Successfully....
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></div>';
      }
      else{
        echo '<div class="container pt-5"><div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Failure!</strong> Data Insertion Failed....
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></div>';
      }
   }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Student Form</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

  <div class="card p-4 shadow rounded" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">Student Information Form</h3>

    <form method="GET" action="">
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required pattern="[A-Za-z\s]{3,}" title="Enter at least 3 alphabetic characters">
      </div>

      <div class="mb-3">
        <label for="age" class="form-label">Age:</label>
        <input type="number" class="form-control" id="age" name="age" required min="15" max="40" title="Enter a valid age between 15 and 40">
      </div>

      <div class="mb-4">
        <label for="course" class="form-label">Course:</label>
        <select id="course" name="course" class="form-select" required>
          <option value="">-- Select Course --</option>
          <option value="BCA">BCA</option>
          <option value="BSc.IT">BSc.IT</option>
          <option value="MCA">MCA</option>
          <option value="MBA">MBA</option>
          <option value="B.Tech">B.Tech</option>
        </select>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary " name="submit">Submit</button><br>
      </div>
      <div class="d-grid">
            <a href="dashboard.php" class="btn btn-dark btn-m">Go to Dashboard</a>
        </div>
    </form>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



