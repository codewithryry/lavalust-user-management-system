<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="form-container">
        <h2 class="mb-4">Update User</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="/users/update/<?php echo $user['id']; ?>" method="POST" class="row g-3">

            <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['rrm_last_name']; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['rrm_first_name']; ?>" required>
            </div>

                       <!-- Username Field -->
                       <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['rrm_username']; ?>" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['rrm_email']; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="Male" <?php echo $user['rrm_gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $user['rrm_gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo $user['rrm_gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $user['rrm_address']; ?></textarea>
            </div>
            <div class="col-12">
                <label for="password" class="form-label">Password (Optional)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if not changing">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/users/display" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
