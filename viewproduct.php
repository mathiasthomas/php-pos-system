<?php
include_once'connectdb.php';

session_start();
include_once 'header.php';

?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       View Product
        
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
               <h3 class="box-title">Product Details</h3>
           </div>
            <div class="box-body">
                <?php
                $id = $_GET['id'];
                $select=$pdo->prepare("select * from tbl_product where p_id=$id");
                $select->execute();
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                    echo '
                    
                    <div class="col-md-6">
                    <ul class="list-group">
  <li class="list-group-item list-group-item-info"><b>ID </b><span class="label label-info pull-right">'.$row->p_id.'</span></li>
  <li class="list-group-item list-group-item-success"><b>Product Name </b> <span class="label label-info pull-right">'.$row->pname.'</span></li>
  <li class="list-group-item list-group-item-success"><b>Product Category </b><span class="label label-info pull-right">'.$row->pcategory.'</span></li>
  <li class="list-group-item list-group-item-danger"><b>Product Description </b><span >:- '.$row->description.'</span></li>
</ul>
</ul>
                    </div>
                     <div class="col-md-6">
                    <ul class="list-group">
  <li class="list-group-item list-group-item-info"><b>Purchase Price </b><span class="label label-info pull-right">KSH '.$row->purchaseprice.'</span></li>
  <li class="list-group-item list-group-item-success"><b>Sale Price</b> <span class="label label-info pull-right">KSH '.$row->saleprice.'</span></li>
  <li class="list-group-item list-group-item-success"><b>Profit</b> <span class="label label-info pull-right">KSH '.($row->saleprice-$row->purchaseprice).'</span></li>
  <li class="list-group-item list-group-item-danger"><b>Available Stock </b><span class="label label-info pull-right">'.$row->pstock.'</span></li>
</ul>
</ul>
                    </div>
                    
                    
                    ';
                }
                
                
                ?>
                
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
include_once 'footer.php';
?>