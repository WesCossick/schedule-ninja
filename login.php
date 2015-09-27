<!DOCTYPE html>
<html lang="en">
<head>
    <title>SB Admin - Bootstrap Admin Template</title>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php'); ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Login <small>Welcome!</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="user@example.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="••••••••">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/scripts.php'); ?>
</body>
</html>