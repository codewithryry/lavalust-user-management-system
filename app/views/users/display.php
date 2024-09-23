<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Read</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .table-container {
            max-width: 100%;
        }

        .search-create-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="table-container">
        <h4 class="text-right" style="font-size: 2.0em;"><?= $name; ?></h4>
            <br>
            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
                <div class="alert alert-success">Deleted successfully!</div>
            <?php endif; ?>

            <?php if (isset($_GET['updated']) && $_GET['updated'] == 'true'): ?>
    <div class="alert alert-success">Updated successfully!</div>
<?php endif; ?>


            <div class="search-create-row">
                <div class="col-md-6">
                    <a href="/users/create" class="btn btn-primary">Create New Data</a>
                </div>
            </div>

            <table id="myTable" class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($prod)): ?>
                        <tr>
                            <td colspan="7" class="text-center">No users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($prod as $p): ?>
                            <tr>
                                <td><?= $p['id']; ?></td>
                                <td><?= $p['rrm_last_name']; ?></td>
                                <td><?= $p['rrm_first_name']; ?></td>
                                <td><?= $p['rrm_email']; ?></td>
                                <td><?= $p['rrm_gender']; ?></td>
                                <td><?= $p['rrm_address']; ?></td>
                                <td>
                                    <a href="/users/update/<?= $p['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="/users/delete/<?= $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#myTable').DataTable({
                "pageLength": 5, 
                "lengthMenu": [5, 10, 25, 50] 
            });
        });
    </script>
</body>

</html>
