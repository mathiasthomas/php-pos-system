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

if(isset($_POST['btnsaveorder'])){
  $customer_name=$_POST['txtcustomer'];
  $order_date=date('Y-m-d',strtotime($_POST['orderdate']));
  $subtotal=$_POST['txtsubtotal'];
  $tax=$_POST['txttax'];
  $discount=$_POST['txtdiscount'];
  $total=$_POST['txttotal'];
  $paid=$_POST['txtpaid'];
  $due=$_POST['txtdue'];
  $payment_type=$_POST['rb'];

 
 $arr_productid=$_POST['productid'];
      $arr_productname=$_POST['productname'];
      $arr_stock=$_POST['stock'];
      $arr_qty=$_POST['qty'];
      $arr_price=$_POST['price'];
      $arr_total=$_POST['total'];


  $insert=$pdo->prepare("insert into tbl_invoce(customer_name, order_date) values(:cust, :orderdate, )");

  $insert->bindParam(':cust',$customer_name);
  $insert->bindParam(':orderdate', $order_date);
  $insert->bindParam(':stotal',$subtotal);
  $insert->bindParam(':tax',$tax);
  $insert->bindParam(':disc',$discount);
  $insert->bindParam(':total',$total);
  $insert->bindParam(':paid',$paid);
  $insert->bindParam(':due',$due);
  $insert->bindParam(':ptype',$payment_type);

  $insert->execute();

  ///insert for invoce details

 $invoice_id=$pdo->lastInsertId();
  if($invoice_id!=null){
    for($i=0; $i<count($arr_productid); $i++){


      $insert=$pdo->prepare("insert into tbl_invoce_details (invoice_id, product_id, product_name, qty,  price, order_date) values(:invid, :pid, :pname, :qty, :price, :orderdate)");

      $insert->bindParam(':invid', $invoice_id);
      $insert->bindParam(':pid', $arr_productid);
      $insert->bindParam(':pname',$arr_productname);
      $insert->bindParam(':qty',$arr_qty);
      $insert->bindParam(':price', $arr_price);
      $insert->bindParam(':orderdate', $arr_total);

      $insert->execute();

      echo "oreder created succesfully";
    }
  }

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
                  <input type="text" class="form-control" name="txtcustomer" placeholder="Enter Name" required="required">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
                </div>
                <!-- /.input group -->
              </div>
              </div>
              </div> 
            <div class="box-body">
                <div class="col-md-12">
                  <div style="overflow-x: auto;">
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
                </div>
            </div> <!-- this is for table -->
            <div class="box-body">
            
            <div class="col-md-6">
            <div class="form-group">
                  <label >SubTotal</label>
                  <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required="required" readonly>
                </div>
                <div class="form-group">
                  <label >Tax 5%</label>
                  <input type="text" class="form-control" name="txttax" id ="txttax" required="required" readonly>
                </div>   
                <div class="form-group">
                  <label >Discount</label>
                  <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required="required">
                </div> 
            </div>
            <div class="col-md-6">
            <div class="form-group">
                  <label >Total</label>
                  <input type="text" class="form-control" name="txttotal" id="txttotal" required="required" readonly>
                </div> 
                <div class="form-group">
                  <label >Paid</label>
                  <input type="text" class="form-control" name="txtpaid" id="txtpaid" required="required">
                </div> 
                <div class="form-group">
                  <label >Due</label>
                  <input type="text" class="form-control" name="txtdue" id="txtdue" required="required" readonly>
                </div> 
                <br>
                <label for="">Payment Method</label>
                <div class="form-group">
                  
                <label>
                  <input type="radio" name="rb" class="minimal " checked value="card">CARD
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="cash">CASH
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal"
                  value="cheque">CHEQUE
                  
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
        html+=' <td> <input type="number" min="1" class="form-control qty" name="qty[]" > </td>';
        html+=' <td> <input type="text" class="form-control total" name="total[]" readonly> </td>';
        html+=' <td> <button type="button" name="remove" class="btn  btn-danger btnremove" ><span class="glyphicon glyphicon-remove" ></span></button> </td>';

        $('#tableproducts').append(html);
         //Initialize Select2 Elements
    $('.productid').select2()
    $(".productid").on('change', function(e){
      var productid = this.value;
      var tr =$(this).parent().parent();
      $.ajax({
        url:"getproduct.php",
        method:"get",
        data:{id:productid},
        success:function(data){
          //console.log(data);
      tr.find(".stock").val(data["pstock"]);
      tr.find(".price").val(data["saleprice"]);
      tr.find(".qty").val(1);
      tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
      calculate(0,0);

        }
      })
    })
    })
    $(document).on('click', '.btnremove', function(){
      $(this).closest('tr').remove();//remove button
       calculate(0,0);
       $("#txtpaid").val(0);
    })
    
    //calculating total
    $("#tableproducts").delegate(".qty","keyup change", function(){

      var quantity = $(this);
      var tr =$(this).parent().parent();
    if( (quantity.val()-0)>(tr.find(".stock").val()-0) ){
      swal("WARNING", "SORRY this much of quantity is not available","warning");
      quantity.val(1);
      tr.find(".total").val(quantity.val() * tr.find(".price").val());
       calculate(0,0);

    }else{
      tr.find(".total").val(quantity.val() * tr.find(".price").val());
       calculate(0,0);

    }  

    })

     function calculate(dis,paid){
      var subtotal=0;
      var tax =0;
      var discount =dis;
      var net_total=0;
      var paid_amt=paid;
      var due=0;



      $(".total").each(function(){

        subtotal =subtotal+($(this).val()*1);

      })

      tax=0.05*subtotal;
      net_total=tax+subtotal;
      net_total=net_total-discount;
      due=net_total-paid_amt;

      $("#txtsubtotal").val(subtotal.toFixed(2));
      $("#txttax").val(tax.toFixed(2));
      $("#txttotal").val(net_total.toFixed(2));
      $("#txtdiscount").val(discount);
      $("#txtdue").val(due.toFixed(2));
     }//end of calculate function

     $("#txtdiscount").keyup(function(){
      var discount =$(this).val();
      calculate(discount,0);
     })

     $("#txtpaid").keyup(function(){
      var paid =$(this).val();
      var discount=$("#txtdiscount").val();
      calculate(discount,paid);
     })

    });
  </script>
  <!-- /.content-wrapper -->

  <?php
include_once 'footer.php';
?>
 