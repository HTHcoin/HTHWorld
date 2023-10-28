<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
if (isset($_POST['create_volunteer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $expertise = $_POST['expertise'];
    
    // Initialize a message variable
    $volunteerMsg = "";

    try {
        $insertQuery = "INSERT INTO volunteers (name, email, phone, expertise) VALUES (:name, :email, :phone, :expertise)";
        $insertStatement = $dbh->prepare($insertQuery);
        $insertStatement->bindParam(':name', $name, PDO::PARAM_STR);
        $insertStatement->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStatement->bindParam(':phone', $phone);
        $insertStatement->bindParam(':expertise', $expertise);
        $insertStatement->execute();

        // Set a success message
        $volunteerMsg = "Volunteer created successfully.";

    } catch (PDOException $e) {
        // Handle database-related errors
        $volunteerMsg = "Error: " . $e->getMessage();
    }
}

// Fetch volunteers and users with the "volunteer" designation
$volunteers = array();

try {
    $volunteerSql = "SELECT id, name, email, phone, expertise FROM volunteers WHERE designation = 'Volunteer'
                UNION
                SELECT id, name, email, mobile AS phone, '' AS expertise FROM users WHERE designation LIKE '%Volunteer%'";

    $volunteerQuery = $dbh->prepare($volunteerSql);
    $volunteerQuery->execute();

    while ($volunteer = $volunteerQuery->fetch(PDO::FETCH_ASSOC)) {
        $volunteers[] = $volunteer;
    }
} catch (PDOException $e) {
    // Handle database-related errors when fetching volunteers
    $volunteerMsg = "Error: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Manage Volunteers</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/volunteers.css">
    <script type="text/javascript" src="../vendor/countries.js"></script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #dd3d36;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #5cb85c;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Manage Volunteers</h3>
                        <div class="row">
                            <!-- "Menu Form" -->
                            <div class="col-md-15">
                                <h4>Create New Volunteer</h4>
                                <!-- "Create New Volunteer" form -->
                                <div class="create-volunteer-form">
                                    <form method="post">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" required>

                                        <label for="email">Email</label>
                                        <input class="form-control" type="email" name="email" required>

                                        <label for="phone">Phone</label>
                                        <input class="form-control" type="text" name="phone">

                                        <label for="expertise">Expertise</label>
                                        <textarea class="form-control" name="expertise"></textarea>

                                        <button type="submit" name="create_volunteer" class="btn btn-primary">Create Volunteer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </br>
                        </br>
                        <!-- "Volunteers List" -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($volunteerMsg)) : ?>
                                    <div class="errorWrap">
                                        <?php echo $volunteerMsg; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($volunteers)) : ?>
                                    <h4>Volunteers List</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($volunteers as $volunteer) : ?>
                                                <tr>
                                                    <td><?php echo $volunteer['name']; ?></td>
                                                    <td><?php echo $volunteer['email']; ?></td>
                                                    <td><?php echo $volunteer['phone']; ?></td>
                                                    <td>
                                                        <button class="btn btn-primary" onclick="showVolunteerDetails('<?php echo $volunteer['name']; ?>', '<?php echo $volunteer['email']; ?>', '<?php echo $volunteer['phone']; ?>', '<?php echo $volunteer['expertise']; ?>')">View Details</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No volunteers found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Volunteer Details Modal -->
    <div class="modal fade" id="volunteerDetailsModal" tabindex="-1" role="dialog" aria-labelledby="volunteerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="volunteerDetailsModalLabel">Volunteer Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalVolunteerName"></span></p>
                    <p><strong>Email:</strong> <span id="modalVolunteerEmail"></span></p>
                    <p><strong>Phone:</strong> <span id="modalVolunteerPhone"></span></p>
                    <p><strong>Expertise:</strong> <span id="modalVolunteerExpertise"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(function () {
                $('.succWrap').slideUp("slow");
            }, 3000);
        });

        // Function to show volunteer details in the modal
        function showVolunteerDetails(name, email, phone, expertise) {
            document.getElementById("modalVolunteerName").textContent = name;
            document.getElementById("modalVolunteerEmail").textContent = email;
            document.getElementById("modalVolunteerPhone").textContent = phone;
            document.getElementById("modalVolunteerExpertise").textContent = expertise;

            $('#volunteerDetailsModal').modal('show');
        }
    </script>
</body>
</html>
<?php } ?>