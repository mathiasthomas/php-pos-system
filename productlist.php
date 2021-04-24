<?php
include_once'connectdb.php';
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
}
include_once 'header.php';

?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    Products
        
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
        <div class="box box-success">
            <div class="box-header with border">
                <div class="box-title">Products</div>
                <div class="box-body">
                    
                    <table id="tableproducts" class="table table-stripped">
                        
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>Product Name</td>
                                <td>Category</td>
                                <td>Purchase-Price</td>
                                <td>SALE PRICE</td>
                                 <td>Stock</td>
                                 <td>Description</td>
                                 <td>View</td>
                                 <td>Edit</td>
                                 <td>Delete</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            $select = $pdo->prepare("select * from tbl_product   order by p_id desc");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                                echo '
                                <tr>
                                <td>'.$row->p_id.'</td>
                                <td> '.$row->pname.' </td>
                                <td>'.$row->pcategory.'</td>
                                <td>'.$row->purchaseprice.'</td>
                                <td>'.$row->saleprice.'</td>
                                <td>'.$row->pstock.'</td>
                                <td>'.$row->description.'</td>
                                <td>
                                <a href="viewproduct.php?id='.$row->p_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff"  data-toggle="tooltip" title="view product"></span></a>
                                </td>
                                <td>
                                <a href="editproduct.php?id='.$row->p_id.'" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-edit" title="edit product"></span></a>
                                </td>
                                <td>
                                <button id='.$row->p_id.' class="btn  btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff"  data-toggle="tooltip" title="delete product"></span></button>
                                </td>
                                </tr>
                                ';
                            };
                            ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <script>
      $(document).ready( function () {
    $('#tableproducts').DataTable({
        order:[[0,"desc"]]
    });
} );
</script>
 
delete code using ajax and jquery
  <script>
      $(document).ready(function(){
          $('.btndelete').click(function(){
              var tdh =$(this);
              var id = $(this).attr("id");
              
              swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this product",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      
      
              $.ajax({
                  
                  url:'productdelete.php',
                  type:'post',
                  data:{
                  pid:id
              },
                     success:function(data){
                  tdh.parents('tr').hide();
              }
              });
      
    swal("Product Deleted", {
      icon: "success",
    });
  } else {
    swal("Delete Cancled");
  }
});
              
              
          });
      });
</script>

  <?php
include_once 'footer.php';
?>