<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 
require_once 'classes/Post.php';
// GET
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        if ($id != null) {

            if (Post::delete($id)) {
                Post::redirect('./index.php?deleted');
            } else {
                Post::redirect('./index.php?error');
            }
            
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} 

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php'; 
        if (!func::checkLoginState()) 
            {
                header("location:login.php");
                exit();
            }

        ?>

    </head>
    <body>
        <!-- Header banner -->
        <?php require_once 'includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once 'includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 style="margin-top: 10px">Posts</h1>

                    <?php 
                        if (isset($_GET['updated'])) {
                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <strong>User!</strong> Updated with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        } else if (isset($_GET['deleted'])) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>User!</strong> Deleted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        } else if (isset($_GET['inserted'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>User!</strong> Inserted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        } else if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>DB Error!</strong> Something goes wrong during the database transaction. Try again!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        } 
                    ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>title</th>
                                    <th>email</th>
                                    <th></th>
                                </tr>
                            </thead>
                       
                            <tbody>
                            <?php

                                $posts=Post::get();
                            ?>  
                             <?php 
                             if (!empty($posts)) {
                             foreach ($posts["data"]["data"] as $key => $value){ ?>
                            <tr>
                                <td><?php print($value["id"]); ?></td>
                                <td>
                                    <a href="forms/post_form.php?edit_id=<?php print($value['entity']['id']); ?>">
                                        <?php echo (isset($value['document']['name']))?print($value['document']['name']):'----'; ?>
                                    </a>
                                </td>
                                <td><?php print($value['document']['description']); ?></td>
                                <td>
                                    <a class="confirmation" href="index.php?delete_id=<?php print($value['entity']['id']); ?>">
                                        <span data-feather="trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php }} else { ?>
                            <tr>
                                <td colspan="4">No record found...</td>
                            </tr>
                            <?php } ?>
                          
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            // JQuery confirmation
            $('.confirmation').on('click', function () {
                return confirm('Are you sure you want do delete this post?');
            });
        </script>
    </body>
</html>
