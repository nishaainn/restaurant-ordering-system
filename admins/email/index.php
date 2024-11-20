<?php

session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>XML Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
    <div class="form" style="height: 100vh;">
        <div class="container h-100">
            <div class="row d-flex align-items-center h-100">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <?php if(isset($_SESSION['result']) && $_SESSION['result'] != '') { ?>
                            <div class="alert alert-primary" role="alert">
                                <?php echo $_SESSION['result']; ?>
                            </div>
                            <?php } unset($_SESSION['result']); ?>
                            <form action="send.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="your name" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>