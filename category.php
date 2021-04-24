<?php
include_once'connectdb.php';

session_start();
if($_SESSION['useremail']==""){
    header('location:index.php');
}
include_once 'header.php';


//insert data to table tbl_category
if(isset($_POST['btnsave'])){
    $category = $_POST['txtcategory'];
    if(empty($category)){
        $error = '<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Field Empty",
          text: "Please fill category field",
          icon: "error",
          button: "Ok",
        });
        
        })
        
        </script>';
        echo $error;
    }
    if(!isset($error)){
        $insert = $pdo->prepare("insert into tbl_category(category) values(:category)");
        $insert->bindParam(':category', $category);
       
        $insert->execute();
          
        
    }
}

//end of category add code
//below strat of cat update code

if(isset($_POST['btnupdate'])){
    $category = $_POST['txtcategory'];
     $id = $_POST['txtid'];
    if(empty($category)){
        $errorupdate ='
        <script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Field Empty",
          text: "Please fill category field",
          icon: "error",
          button: "Ok",
        });
        
        })
        
        </script>
        ';
        echo  $errorupdate;
    }
    
    if(!isset($errorupdate)){
        $update=$pdo->prepare("update tbl_category set category=:category where cat_id=".$id);
        $update->bindParam(':category', $category);//prevent mysql injection
        $update->execute();
        
        if($update->execute()){
            echo '<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Success",
          text: "Category updated succesfully",
          icon: "success",
          button: "Ok",
        });
        
        })
        
        </script>';
        }else{
            
        }
    }
}
//end of category update code
//start below code of delete
if(isset($_POST['btndelete'])){
    $delete=$pdo->prepare("delete from tbl_category where cat_id=".$_POST['btndelete']);
    if( $delete->execute()){
        echo '<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Success",
          text: "Category updated succesfully",
          icon: "success",
          button: "Ok",
        });
        
        })
        
        </script>';
    }else{
        echo '<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Error",
          text: "Category not  deleted",
          icon: "error",
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
        Category
        
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
        
        
        
         <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               <form role="form" action="" method="post">
               
               <?php
                   
                   if(isset($_POST['btnedit'])){
                       $select =$pdo->prepare("select * from tbl_category where cat_id=".$_POST['btnedit']);
                       $select->execute();
                       if($select){
                           $row=$select->fetch(PDO::FETCH_OBJ);
                           echo '
                       <div class="col-md-4">
                <div class="form-group">
                  <label >Categoty</label>
                  
                 <input type="hidden" class="form-control" name="txtid" placeholder="Enter Category Name"   value="'.$row->cat_id.'">
                  <input type="text" class="form-control" name="txtcategory" placeholder="Enter Category Name"   value="'.$row->category.'">
                  
                  
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-success" name="btnupdate">Update</button>
              </div>
                </div>
                       ';
                       }
                       
                       
                   }else{
                       echo '
                       <div class="col-md-4">
                <div class="form-group">
                  <label >Categoty</label>
                  <input type="text" class="form-control" name="txtcategory" placeholder="Enter Category Name" >
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-success" name="btnsave">ADD</button>
              </div>
                </div>
                       ';
                   }
                   
                   ?>
               
                
                <div class="col-md-8">
                    <table id="tablecategory" class="table table-striped">
                        
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>CATEGORY</th>
                                <th>EDIT</th>
                                 <th>DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select=$pdo->prepare("select * from tbl_category order by cat_id desc");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                                echo '
                                <tr>
                                <td>'.$row->cat_id.'</td>
                                <td>'.$row->category.'</td>
                                <td><button type="submit" value="'.$row->cat_id.'" class="btn btn-primary" name="btnedit">EDIT</button></td>
                                <td><button type="submit" value="'.$row->cat_id.'" class="btn btn-danger" name="btndelete">DELETE</button></td>
                                </tr>
                                ';
                            }
                                
                           ?>
                        </tbody>
                    </table>
                </div>

                     
            </form>
              </div>
              <!-- /.box-body -->

            
          </div>
        
        

    </section>
   
  </div>

  <script>
      $(document).ready( function () {
    $('#tablecategory').DataTable();
} );
</script>
  
  
  

  <?php
include_once 'footer.php';
?>