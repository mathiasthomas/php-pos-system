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
               <h3 class="box-title">All Orders</h3>
           </div>
            <div class="box-body">
              <div style="overflow-x: auto;">
               <table id="orderlisttable" class="table table-stripped">
                        
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <td>Customer Name</td>
                                <td>Order Date</td>
                                <td>Total</td>
                                <td>Paid</td>
                                 <td>Due</td>
                                 <td>Payment Type</td>
                                 <td>Print </td>
                                 <td>Edit</td>
                                 <td>Delete</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            $select = $pdo->prepare("select * from tbl_invoce   order by invoice_id desc");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                                echo '
                                <tr>
                                <td>'.$row->invoice_id.'</td>
                                <td> '.$row->customer_name.' </td>
                                <td>'.$row->order_date.'</td>
                                <td>'.$row->total.'</td>
                                <td>'.$row->paid.'</td>
                                <td>'.$row->due.'</td>
                                <td>'.$row->payment_type.'</td>
                                <td>
                                <a href="viewproduct.php?id='.$row->invoice_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-print" style="color:#ffffff"  data-toggle="tooltip" title="print invoice"></span></a>
                                </td>
                                <td>
                                <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-edit" title="edit order"></span></a>
                                </td>
                                <td>
                                <button id='.$row->invoice_id.' class="btn  btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff"  data-toggle="tooltip" title="delete order"></span></button>
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
   $(document).ready(function(){
     $('#orderlisttable').DataTable({
       "order":[[0,"desc"]]
     });
   });
  </script>
  <script>
  $(document).ready( function(){
    $('[data-toggle="tootip"]').tooltip();
  });
  </script>

  <?php
include_once 'footer.php';
?>