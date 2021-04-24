<?php
include_once'connectdb.php';

session_start();
include_once 'header.php';

if(isset($_POST['btnupdate'])){
    $oldpassword_txt=$_POST['txtoldpass'];
    $newpassword_txt=$_POST['txtnewpass'];
    $confpassword_txt=$_POST['txtconfpass'];
    
    
    //echo $oldpassword_txt. "-" .$newpassword_txt. "-" .$confpassword_txt;
    
    $email=$_SESSION['useremail'];
    $select =$pdo->prepare("select * from tbl_user where useremail='$email'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);
    //compare user input and database values
    $useremail_db = $row['useremail'];
    $password_db = $row['password'];
    if($oldpassword_txt==$password_db){
        if($newpassword_txt==$confpassword_txt){
           $update=$pdo->prepare("update tbl_user set password=:pass where useremail=:email");
            $update->bindParam(':pass', $confpassword_txt);
            $update->bindParam(':email', $email);
            if($update->execute()){
                 echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "Good job!",
          text: "Password Updated Succesfully",
          icon: "success",
          button: "Aww yiss!",
        });
        
        })
        
        </script>';
            }
        }
    }else{
         echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "Passwords Dont Match",
          text: "Failed",
          icon: "warning",
          button: "Ok",
        });
        
        })
        
        </script>';
    }
    
    
    
    
    
    
    
    
    
    
    
    
}

?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Dashboard
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Pasword </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="POST">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass">
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
include_once 'footer.php';
?>