<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
        }
        .validation-message {
            display: none;
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Login</h2>
        <form id="loginForm" action="/users/login" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                <div id="usernameMessage" class="validation-message">Username is required.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <div id="passwordMessage" class="validation-message">Password is required.</div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="/users/display">Register here</a></p>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission for this example
                let isValid = true;

                // Validate username
                if ($('#username').val().trim() === '') {
                    $('#usernameMessage').slideDown();
                    isValid = false;
                } else {
                    $('#usernameMessage').slideUp();
                }

                // Validate password
                if ($('#password').val().trim() === '') {
                    $('#passwordMessage').slideDown();
                    isValid = false;
                } else {
                    $('#passwordMessage').slideUp();
                }

                if (isValid) {
                    // Simulate successful login and redirect to /users/display
                    window.location.href = '/users/display'; // Redirect to display users
                }
            });

            // Hide validation messages on input
            $('#username, #password').on('input', function() {
                const messageId = $(this).attr('id') + 'Message';
                $('#' + messageId).slideUp();
            });
        });
    </script>
</body>
</html>
