<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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

        .user-nav {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .btn-logout {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- User Navigation with Logout and Send Email Button -->
        <div class="user-nav">
            <button class="btn btn-primary" id="sendEmailBtn" data-bs-toggle="modal" data-bs-target="#emailModal">Send Email</button>
            <a href="/users/login" class="btn btn-danger btn-logout">Logout</a>
        </div>

        <div class="table-container">
            <h4 class="text-right" style="font-size: 2.0em;">User Management</h4>
            <br>
            <div class="search-create-row">
                <div class="col-md-6">
                    <button class="btn btn-primary" id="createUserBtn">Create New Data</button>
                
                </div>
            </div>

            <table id="myTable" class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Username</th>
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
                                <td><?= htmlspecialchars($p['rrm_last_name']); ?></td>
                                <td><?= htmlspecialchars($p['rrm_first_name']); ?></td>
                                <td><?= htmlspecialchars($p['rrm_username']); ?></td>
                                <td><?= htmlspecialchars($p['rrm_email']); ?></td>
                                <td><?= htmlspecialchars($p['rrm_gender']); ?></td>
                                <td><?= htmlspecialchars($p['rrm_address']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm updateUserBtn" data-id="<?= $p['id']; ?>">Update</button>
                                    <button class="btn btn-danger btn-sm deleteUserBtn" data-id="<?= $p['id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Send an Email with Attachment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/users/send_email_action" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">Recipient's Email</label>
                            <input type="email" class="form-control" id="recipient_email" name="recipient_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="attachment" name="attachment">
                        </div>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">


    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('#myTable').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50]
            });

            // Open Create Modal
            $('#createUserBtn').on('click', function () {
                $.ajax({
                    url: '/users/create', // Replace with the actual URL for your create form
                    method: 'GET',
                    success: function (data) {
                        $('#userModal .modal-body').html(data);
                        $('#userModal').modal('show');
                    }
                });
            });

            // Open Update Modal
            $('.updateUserBtn').on('click', function () {
                const userId = $(this).data('id');
                $.ajax({
                    url: `/users/update/${userId}`, // Replace with the actual URL for your update form
                    method: 'GET',
                    success: function (data) {
                        $('#userModal .modal-body').html(data);
                        $('#userModal').modal('show');
                    }
                });
            });

            // Open Delete Confirmation Modal
            $('.deleteUserBtn').on('click', function () {
                const userId = $(this).data('id');
                $('#confirmDeleteBtn').attr('href', `/users/delete/${userId}`); // Set the delete link dynamically
                $('#deleteModal').modal('show');
            });
        });


        $('#userModal, #deleteModal, #emailModal').on('show.bs.modal', function () {
    $(this).fadeIn(500);
}).on('hide.bs.modal', function () {
    $(this).fadeOut(500);
});


// $('#myTable tbody tr').hover(
//     function () {
//         $(this).css('background-color', '#e9ecef');
//     },
//     function () {
//         $(this).css('background-color', '');
//     }
// );


$('#createUserBtn').on('click', function () {
    $(this).effect('bounce', { times: 3 }, 500);
});


// $('.table-container').hide().slideDown(1000);


// $('#emailModal form').on('submit', function (e) {
//     const emailField = $('#recipient_email').val();
//     if (!emailField || !emailField.includes('@')) {
//         e.preventDefault();
//         $('#emailModal .modal-body').effect('shake', { times: 3 }, 500);
//     }
// });

// $('.search-create-row').on('click', function () {
//     $('.table-container').slideToggle(700);
// });

function blinkLogout() {
    $('.btn-logout').fadeOut(500).fadeIn(500, blinkLogout);
}
blinkLogout();


// $('#createUserBtn').on('click', function () {
//     $('.search-create-row').slideToggle(800);
// });

$('#myTable tbody tr').hover(
    function () {
        $(this).stop().fadeTo(200, 0.5);
    },
    function () {
        $(this).stop().fadeTo(200, 1);
    }
);

$('<button id="scrollTopBtn" class="btn btn-secondary">Top</button>')
    .appendTo('body')
    .css({ position: 'fixed', bottom: '20px', right: '20px', display: 'none' });

$(window).on('scroll', function () {
    if ($(this).scrollTop() > 200) {
        $('#scrollTopBtn').fadeIn(300);
    } else {
        $('#scrollTopBtn').fadeOut(300);
    }
});

$('#scrollTopBtn').on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 1000);
});



    </script>
</body>

