<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send an Email with Attachment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 6px;
        }
<<<<<<< HEAD
        #sentEmailsMessage {
            display: none;
            margin-top: 15px;
        }
=======
>>>>>>> 13cd77ddc9ff41c3efe2173f3aaaae3c35372bea
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Send an Email with Attachment</h2>
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
<<<<<<< HEAD
                <button type="button" id="viewEmailsButton" class="btn btn-secondary ms-2">View Sent Emails</button>
            </form>
            <div id="sentEmailsMessage" class="alert alert-info">
                Redirecting to view sent emails...
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle "View Sent Emails" button click
            $('#viewEmailsButton').on('click', function() {
                // Fade in the message
                $('#sentEmailsMessage').fadeIn(500, function() {
                    // After message fades in, wait 1 second and fade out
                    setTimeout(function() {
                        $('#sentEmailsMessage').fadeOut(500, function() {
                            // Redirect to the /users/display route after fade out
                            window.location.href = "/users/display";
                        });
                    }, 1000);
                });
            });
        });
=======
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check for query parameter 'success'
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'true') {
            alert('Email sent successfully!');
        }
>>>>>>> 13cd77ddc9ff41c3efe2173f3aaaae3c35372bea
    </script>
</body>
</html>
