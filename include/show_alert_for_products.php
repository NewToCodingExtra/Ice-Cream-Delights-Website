<?php 
if(!empty($success_msg)) {
    foreach($success_msg as $msg) {
        if(isset($redirect_after_delete) && $redirect_after_delete) {
            // Redirect after delete
            echo '<script>
                swal("'.$msg.'", "", "success")
                .then(() => {
                    window.location.href = "view_products.php";
                });
            </script>';
        } else {
            // No redirect
            echo '<script>swal("'.$msg.'", "", "success");</script>';
        }
    }
}
?>