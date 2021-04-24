<?php
include_once'connectdb.php';

session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
}
include_once 'header.php';



$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_product where p_id =$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);
$id_db=$row['p_id'];
$productname_db=$row['pname'];
$category_db=$row['pcategory'];
$purchaseprice_db=$row['purchaseprice'];
$saleprice_db=$row['saleprice'];
$stock_db=$row['pstock'];
$description_db=$row['description'];

if(isset($_POST['btnupdateproduct'])){
    $productname_txt=$_POST['txtpname'];
    $category_txt=$_POST['txtselect_option'];
    $purchaseprice_txt=$_POST['txtpprice'];//$_POST[''];
    $saleprice_txt=$_POST['txtsaleprice'];
    $stock_txt=$_POST['txtstock'];
    $description_txt=$_POST['txtdescription'];
    
    $update=$pdo->prepare("update tbl_product set pname=:pname, pcategory=:pcategory, purchaseprice=:purchaseprice, saleprice=:saleprice, pstock=:pstock, description=:description where p_id=$id");
   
     $update->bindParam(':pname',$productname_txt);
    $update->bindParam(':pcategory',$category_txt);
    $update->bindParam(':purchaseprice',$purchaseprice_txt);
    $update->bindParam('saleprice',$saleprice_txt);
    $update->bindParam(':pstock',$stock_txt);
    $update->bindParam(':description',$description_txt);
    if($update->execute()){
        
        echo '<script type="text/javascript">
        
        jQuery(function validation(){
        
          swal({
          title: "  Success",
          text: " Updated succesfully",
          icon: "success",
          button: "Ok",
        });
        
        })
        
        </script>';echo 'updated suces.m..';
        
    }else{
        echo'failed';
    }
    
//continue from here
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
        <div class="box box-warning">
           <div class="box-header with-border">
               <h3 class="box-title">Edit Product</h3>
           </div>
             <div class="box-body">
              <form action="" method="post" name="formproduct">
                  <div class="col-md-6">
                  <div class="form-group">
                  <label >Product Name</label>
                  <input type="text" class="form-control" name="txtpname" value="<?php  echo $productname_db; ?>" placeholder="Enter Name" required="required">
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
                          <option <?php if($row['category']==$category_db){?>
                          selected="selected"
                          <?php } ?> >
                        <?php  echo $row['category']; ?>
                    </option>
                     <?php
                      }
                      ?>
                    
                    
                    
                  </select>
                </div>
                
                <div class="form-group">
                  <label >Purchase Price</label>
                  <input type="number" min="1" step="1"  class="form-control" name="txtpprice" value="<?php  echo $purchaseprice_db; ?>" placeholder="Enter ...." required="required">
                </div>
                <div class="form-group">
                  <label >Sale Price</label>
                  <input type="number" min="1" step="1"  class="form-control" name="txtsaleprice" value="<?php  echo $saleprice_db; ?>" placeholder="Enter ...." required="required">
                </div>
                
                 </div>
                  <div class="col-md-6">
                      
                <div class="form-group">
                  <label >Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter Stock" value="<?php  echo $stock_db; ?>" required="required">
                </div>
                 <div class="form-group">
                  <label >Description</label>
                   <textarea name="txtdescription"  class="form-control" placeholder="Description"  rows="4"><?php  echo $description_db; ?></textarea>
                    </div>
                  </div>
              
             
              <div class="box-footer">
                <button type="submit" class="btn btn-warning" name="btnupdateproduct">Update Product</button>
                
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