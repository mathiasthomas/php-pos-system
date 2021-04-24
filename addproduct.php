<?php
include_once'connectdb.php';#
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
  header('location:index.php');
}
include_once 'header.php';

if(isset($_POST['btnaddproduct'])){
    $productname=$_POST['txtpname'];
    $category=$_POST['txtselect_option'];
    $purchaseprice=$_POST['txtpprice'];//$_POST[''];
    $saleprice=$_POST['txtsaleprice'];
    $stock=$_POST['txtstock'];
    $description=$_POST['txtdescription'];
    
    $select=$pdo->prepare("select pname from tbl_product where pname='$productname'");
    $select->execute();
    if($select->rowCount() > 0){
        echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: " Product Already Exists",
          text: "Failed",
          icon: "warning",
          button: "Ok",
        });
        
        })
        
        </script>';
    }else{
        
        
    if(empty($productname)){
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
        $insert = $pdo->prepare("insert into tbl_product(pname, pcategory, purchaseprice, saleprice, pstock, description) values(:pname, :pcategory, :purchaseprice, :saleprice, :pstock, :description)");
        $insert->bindParam(':pname', $productname);
        $insert->bindParam(':pcategory', $category);
        $insert->bindParam(':purchaseprice', $purchaseprice);
        $insert->bindParam(':saleprice', $saleprice );
        $insert->bindParam(':pstock', $stock);
        $insert->bindParam(':description', $description );
       
        $insert->execute();
        
        echo'<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "Good job!",
          text: "Product Added ",
          icon: "success",
          button: "Ok!",
        });
        
        })
        
        </script>';
          
        
    }
    }
    
    
    
    
    
}

?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <section class="content-header">

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <div class="container">
        <div><a href="productlist.php"><button type="submit" class="btn btn-primary" name="btnsave">Back To Product List</button></a></div>
    </div>
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box box-success">
            <div class="box-header with-border">
              
              <h3 class="box-title">Add Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
              <form action="" method="post" name="formproduct">
                  <div class="col-md-6">
                  <div class="form-group">
                  <label >Product Name</label>
                  <input type="text" class="form-control" name="txtpname" placeholder="Enter Name" required="required">
                </div>
                 <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="txtselect_option" required="required">
                   <option value="" disabled selected>Select Category</option>
                   <?php
                      $select = $pdo->prepare("select * from tbl_category order by cat_id desc");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_ASSOC)){
                          extract($row);
                          ?>
                          <option>
                        <?php  echo $row['category']; ?>
                    </option>
                     <?php
                      }
                      ?>
                    
                    
                    
                  </select>
                </div>
                
                <div class="form-group">
                  <label >Purchase Price</label>
                  <input type="number" min="1" step="1"  class="form-control" name="txtpprice" placeholder="Enter ...." required="required">
                </div>
                <div class="form-group">
                  <label >Sale Price</label>
                  <input type="number" min="1" step="1"  class="form-control" name="txtsaleprice" placeholder="Enter ...." required="required">
                </div>
                
                 </div>
                  <div class="col-md-6">
                      
                <div class="form-group">
                  <label >Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter Stock" required="required">
                </div>
                 <div class="form-group">
                  <label >Description</label>
                   <textarea name="txtdescription"  class="form-control" placeholder="Description"  rows="4"></textarea>
                    </div>
                  </div>
              
             
              <div class="box-footer">
                <button type="submit" class="btn btn-success" name="btnaddproduct">ADD PRODUCT</button>
                
              </div>
              </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
include_once 'footer.php';
?>