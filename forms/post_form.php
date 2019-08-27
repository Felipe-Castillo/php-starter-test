<?php
session_start();
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once '../classes/Post.php';


// GET
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $rowUser = Post::find($id);
   

    $rowUser=$rowUser["data"];

    
    
} else {
    $id = null;
    $rowUser = null;
}

// POST
if (isset($_POST['btn_save'])) {



    $title = strip_tags($_POST['title']);
    $description = strip_tags($_POST['description']);
    $post_id= strip_tags($_POST['post_id']);
    

    try {
        if ($id != null) {


            $arr=array("access_token"=>$_SESSION["access_token"],"title"=>$title,"description"=>$description,"id"=>$id,"post_id"=>$post_id);
            

                
            if (Post::update($arr)) {
                Post::redirect('../index.php?updated');
            } else {
                Post::redirect('../index.php?error');
            }
        } else {




                $arr=array("title"=>$title,"description"=>$description);

                $response=Post::insert($arr);

               
                        
            if ($response['status']=='ok') 
            {
                Post::redirect('../index.php?inserted');
            } else {
                Post::redirect('../index.php?error');
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
        <?php require_once '../includes/head.php'; ?>
    </head>
    <body>
        <!-- Header banner -->
        <?php require_once '../includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once '../includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 style="margin-top: 10px">Post</h1>
                    <p>Required fields are in (*).</p>
                    <form method="post">
                    <input type="hidden" name="post_id" value="<?php echo $rowUser['id']; ?>">
                        <div class="form-group">
                            <label for="title">Name *</label>
                            <input type="text" required  class="form-control" id="title" name="title" value=" <?php echo (isset($rowUser['document']['title']))? $rowUser['document']['title']:''; ?>" placeholder="title">
                        </div>  
                        <div class="form-group">
                            <label for="description">Description *</label>

                            <textarea class="form-control" required name="description"><?php echo (isset($rowUser['document']['description']))? $rowUser['document']['description']:''; ?></textarea>
                           
                        </div>  
                        <input type="submit" name="btn_save" class="btn btn-primary mb-2" value="Save">
                    </form>
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once '../includes/footer.php'; ?>
    </body>
</html>
