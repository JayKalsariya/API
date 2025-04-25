<?php
    include "config/config.php";
    $config = new Config();

    //Featch Data
    $res = $config->featchData();

    //Delete Data
    if(isset($_REQUEST['btn_delete'])){

        $id = $_REQUEST['deleted_id'];

        $res = $config->deleteData($id);

        if($res){
            $res = $config->featchData();
            echo '<div class="container pt-5"><div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success!</strong> Data Deleted Successfully....
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div></div>';
        }else{
            echo '<div class="container pt-5"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Failure!</strong> Data Deletion Failed....
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div></div>';
        }
    }

     //Edit Data
     if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $edit_data = $config->getStudentById($edit_id); // Same method as before
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $course = $_POST['course'];
    
        $config->updateStudent($id, $name, $age, $course);
        header("Location: dashboard.php");
    }

    //Upload Excel File
    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="students.csv"');
    
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Age', 'Course']); // CSV Header
    
        $res = $config->featchData(); // get student data
    
        while ($row = mysqli_fetch_assoc($res)) {
            fputcsv($output, [$row['id'], $row['name'], $row['age'], $row['course']]);
        }
    
        fclose($output);
        exit;
    }
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f5f7fa;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dashboard-cards .card {
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .dashboard-cards .card:hover {
            transform: translateY(-5px);
        }

        .table thead {
            background-color: #6f42c1;
            color: white;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6f42c1;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🎓 Student Dashboard</a>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-light btn-sm">Add Student</a>
            <a href="?export=csv" class="btn btn-success btn-sm">⬇️ Export CSV/Excel</a>
        </div>
    </div>
</nav>

<!-- ✅ Edit Data Form -->
<?php if (isset($edit_data)) { ?>
<div class="container mt-5">
    <div class="card shadow p-4 mb-5">
        <h4>✏️ Edit Student</h4>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_data['id'] ?>">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $edit_data['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Age</label>
                <input type="number" name="age" class="form-control" value="<?php echo $edit_data['age'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Course</label>
                <select name="course" class="form-control" required>
                    <option value="BCA" <?= $edit_data['course']=='BCA' ? 'selected' : '' ?>>BCA</option>
                    <option value="BSc.IT" <?= $edit_data['course']=='BSc.IT' ? 'selected' : '' ?>>BSc.IT</option>
                    <option value="MCA" <?= $edit_data['course']=='MCA' ? 'selected' : '' ?>>MCA</option>
                    <option value="MBA" <?= $edit_data['course']=='MBA' ? 'selected' : '' ?>>MBA</option>
                    <option value="B.Tech" <?= $edit_data['course']=='B.Tech' ? 'selected' : '' ?>>B.Tech</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php } ?>


<!-- ✅ Data Table -->
<div class="container mb-5">
    <div class="card shadow-3 p-4 rounded-4">
        <h5 class="mb-4">📋 Student Records</h5>
        <div class="table-responsive">
            <table id="studentTable" class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Course</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($res)) { ?>
                        <tr>
                            <td><?php echo $result['id']?></td>
                            <td><?php echo $result['name']?></td>
                            <td><?php echo $result['age']?></td>
                            <td><?php echo $result['course']?></td>
                            <td><a href="dashboard.php?edit_id=<?php echo $result['id']?>" class="btn btn-warning">Edit</a></td>
                            <td>
                                <form action="" method="GET">
                                    <input type="hidden" name="deleted_id" value="<?php echo $result['id']?>">
                                    <button class="btn btn-danger" name="btn_delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ MDB JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

<!-- ✅ jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>
