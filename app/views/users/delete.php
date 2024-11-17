<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="form-container text-center">
        <h2 class="mb-4">Delete User</h2>

        <?php if (isset($user) && !empty($user)): ?>
            <div class="alert alert-warning">
                <strong>Warning!</strong> Are you sure you want to delete the user <strong><?php echo htmlspecialchars($user['rrm_first_name'] . ' ' . $user['rrm_last_name']); ?></strong>?
            </div>

            <!-- Button to open modal for delete confirmation -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
                Delete
            </button>
            <a href="users/display" class="btn btn-secondary">Cancel</a>
        <?php else: ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> User not found.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the user <strong><?php echo isset($user) ? htmlspecialchars($user['rrm_first_name'] . ' ' . $user['rrm_last_name']) : 'the selected user'; ?></strong>?<br><br>
                
                <form action="/users/delete/<?php echo isset($user) ? $user['id'] : ''; ?>" method="POST">
                    <div class="form-group">
                        <label for="password">Enter Password to Confirm:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
