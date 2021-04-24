<?php
include_once'connectdb.php';

session_start();
/* fetching all products */
function fill_product($pdo){
$output='';
$select=$pdo->prepare("select * from tbl_product order by pname asc");
$select->execute();
$result=$select->fetchAll();
foreach($result as $row){
  $output.='<option value="'.$row["p_id"].'">'.$row["pname"].'</option>';
}
return $output;
}

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
          <form action="" method="post">
           <div class="box-header with-border">
              
               <h3 class="box-title">Create  New Order</h3>
           </div>
            <div class="box-body"><!-- customer and date -->
              <div class="col-md-6">
                  <div class="form-group">
                  <label >Customer Name</label>
                  <input type="text" class="form-control" name="txtcustomername" placeholder="Enter Name" required="required">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              </div>
              </div> 
            <div class="box-body">
                <div class="col-md-12">
                   
                    <table id="tableproducts" class="table table-stripped">
                        
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Search Product </th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Enter Quantity</th>
                                 <th>Total</th>
                                 <th> <button type='button' name='add' class="btn  btn-success btnadd" ><span class="glyphicon glyphicon-plus" ></span></button></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        </tbody>
                    </table>
                    
                </div>
            </div> <!-- this is for table -->
            <div class="box-body">
            
            <div class="col-md-6">
            <div class="form-group">
                  <label >SubTotal</label>
                  <input type="text" class="form-control" name="txtsubtotal" required="required">
                </div>
                <div class="form-group">
                  <label >Tax 5%</label>
                  <input type="text" class="form-control" name="txttax" required="required">
                </div>   
                <div class="form-group">
                  <label >Discount</label>
                  <input type="text" class="form-control" name="txtdiscount" required="required">
                </div> 
            </div>
            <div class="col-md-6">
            <div class="form-group">
                  <label >Total</label>
                  <input type="text" class="form-control" name="txttotal" required="required">
                </div> 
                <div class="form-group">
                  <label >Paid</label>
                  <input type="text" class="form-control" name="txtpaid" required="required">
                </div> 
                <div class="form-group">
                  <label >Due</label>
                  <input type="text" class="form-control" name="txtdue" required="required">
                </div> 
                <br>
                <label for="">Payment Method</label>
                <div class="form-group">
                  
                <label>
                  <input type="radio" name="r1" class="minimal " checked>CARD
                </label>
                <label>
                  <input type="radio" name="r1" class="minimal">CASH
                </label>
                <label>
                  <input type="radio" name="r1" class="minimal"
                  >CHEQUE
                  
                </label>
              </div>
            </div>
            </div>    <!-- tax discount and extra -->       
           
            <div align='center'>
              <input type="submit" name='btnsaveorder' value='Save Order' class='btn btn-info'>
            </div>
            <hr>
            </form>
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  
  <script>
   //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    $(document).ready(function(){
    $(document).on('click', '.btnadd', function(){

        var html='';
        html+='<tr>';

        
        html+=' <td> <input type="hidden" class="form-control pname" name="productname[]" readonly> </td>';

        html+=' <td> <select  class="form-control productid" name="productid[]"> <option value=""> Select Option </option> <?php echo fill_product($pdo);?> </select> </td>';

        html+=' <td> <input type="text" class="form-control stock" name="stock[]" readonly> </td>';
        html+=' <td> <input type="text" class="form-control price" name="price[]" readonly> </td>';
        html+=' <td> <input type="text" class="form-control qty" name="qty[]" > </td>';
        html+=' <td> <input type="text" class="form-control total" name="total[]" readonly> </td>';
        html+=' <td> <button type="button" name="remove" class="btn  btn-danger btnremove" ><span class="glyphicon glyphicon-remove" ></span></button> </td>';

        $('#tableproducts').append(html);
         //Initialize Select2 Elements
    $('.productid').select2()
    })
    $(document).on('click', '.btnremove', function(){
      $(this).closest('tr').remove();
    })


    });
  </script>
  <!-- /.content-wrapper -->

  <?php
include_once 'footer.php';
?>