<?php
include_once'connectdb.php';

session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
}

   
include_once 'header.php';

$id =$_GET['id'];
$delete =$pdo->prepare("delete from tbl_user where user_id=".$id);
if($delete->execute()){
    echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: " Deleted",
          text: "deleted succesfully",
          icon: "success",
          button: "Ok",
        });
        
        })
        
        </script>';
}
else{
}

if(isset($_POST['btnsave'])){

$username = $_POST['txtname'];
$useremail = $_POST['txtemail'];
$password = $_POST['txtpassword'];
$userrole = $_POST['txtselect_option'];

//echo $username ."_". $useremail ."_". $password ."_". $userrole;
    
if(isset($_POST['txtemail'])){
    $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");
    $select->execute();
    if($select->rowCount() > 0){
        echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: " Email Already Exists",
          text: "Failed",
          icon: "warning",
          button: "Ok",
        });
        
        })
        
        </script>';
    }else{
        
        $insert = $pdo->prepare("insert into tbl_user(username,useremail,password,role ) values(:name,:email, :pass,:role)");

    $insert->bindParam(':name',$username);
    $insert->bindParam(':email',$useremail);
    $insert->bindParam(':pass',$password);
    $insert->bindParam(':role',$userrole);
 
    if($insert->execute()){
        echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "Good job!",
          text: "User Added Succesfully",
          icon: "success",
          button: "Ok!",
        });
        
        })
        
        </script>';
    }else{
        echo 'data failed to insert';
    }
        
    }
}
    

};

?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add User
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

     <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="col-md-4">
                <div class="form-group">
                  <label >Name</label>
                  <input type="text" class="form-control" name="txtname" placeholder="Enter Name" required="required">
                </div>
                 <div class="form-group">
                  <label >Email address</label>
                  <input type="email" class="form-control" name = "txtemail" placeholder="Enter email" required="required">
                </div>
                <div class="form-group">
                  <label >Password</label>
                  <input type="password" class="form-control" name="txtpassword" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="txtselect_option" required="required">
                   <option value="" disabled selected>Select Role</option>
                    <option>Admin</option>
                    <option>User</option>
                    
                  </select>
                </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-striped">
                        
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>NAME</td>
                                <td>EMAIL</td>
                                <td>PASSWORD</td>
                                <td>ROLE</td>
                                 <td>DELETE</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select = $pdo->prepare("select * from tbl_user   order by user_id desc");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                                echo '
                                <tr>
                                <td>'.$row->user_id.'</td>
                                <td> '.$row->username.' </td>
                                <td>'.$row->useremail.'</td>
                                <td>'.$row->password.'</td>
                                <td>'.$row->role.'</td>
                                <td>
                                <a href="registration.php?id='.$row->user_id.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                                </td>
                                </tr>
                                ';
                            };
                            ?>
                        </tbody>
                    </table>
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-info" name="btnsave">ADD</button>
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
<div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>