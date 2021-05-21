<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Budget | Dashboard</title>

@include('partials/links')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Month', 'Amount'],

      <?php
        $exp_month_arr = "";
        $today_year = date("Y");
        for($i=1;$i<=12;$i++)
        {
            $month_amount = DB::select("SELECT IFNULL(SUM(amount), 0) AS month_amount FROM `expenditure` WHERE MONTH(date)=$i AND YEAR(date)=$today_year");
            if($i==1){ $m = 'Jan'; }
            if($i==2){ $m = 'Feb'; }
            if($i==3){ $m = 'Mar'; }
            if($i==4){ $m = 'Apr'; }
            if($i==5){ $m = 'May'; }
            if($i==6){ $m = 'June'; }
            if($i==7){ $m = 'July'; }
            if($i==8){ $m = 'Aug'; }
            if($i==9){ $m = 'Sept'; }
            if($i==10){ $m = 'Oct'; }
            if($i==11){ $m = 'Nov'; }
            if($i==12){ $m = 'Dec'; }
            $exp_month_arr.="['".$m."',".$month_amount[0]->month_amount."],";
        }
        echo $exp_month_arr = rtrim($exp_month_arr, ",");
      ?>
    ]);

    var options = {
      title: 'Monthly Expenditure',
      width: window.innerWidth-450,
      height: 400,
      curveType: 'function',
      'chartArea': {'width': '80%'},
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('month_chart'));

    chart.draw(data, options);
  }
  window.onresize = callDrawChartFun;

  function callDrawChartFun() {
    drawChart();
  }
</script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <a href="/logout" class="btn btn-danger">Logout <i class="fas fa-sign-out-alt"></i></a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light" style="font-family: 'Galada', cursive;">Home Budget</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/users')}}/{{session()->get('USER_IMAGE')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{session()->get('USER_NAME')}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-rupee-sign"></i>
              <p>Expenditure</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/expNBills')}}" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Add Exp & Bills Types</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/bydate')}}" class="nav-link">
                  <i class="fas fa-calendar-day nav-icon"></i>
                  <p>By Date</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/bymonth')}}" class="nav-link">
                  <i class="fas fa-calendar-alt nav-icon"></i>
                  <p>By Month</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/bymonthexp')}}" class="nav-link">
                  <i class="fas fa-money-bill nav-icon"></i>
                  <p>By Monthly Expenditure</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Expenditure</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expenditure</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="container">
            

            <div class="row">
              <div class="col-md-12">
                <div class="mb-5" id="month_chart"></div>
              </div>
            </div>
            
            {!! session('db_change_status') !!}

            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addExpenditure"><i class="fas fa-plus-circle"></i> Add Expenditure</button>
      
            <!-- Add Expenditure Modal -->
            <div class="modal fade" id="addExpenditure" tabindex="-1" aria-labelledby="addExpenditureLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addExpenditureLabel">Add Expenditure</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" action="/addExp">
                    <div class="modal-body">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="expenditure">Expenditure</label>
                            <select class="custom-select" name="expenditure" id="expenditure" onchange="checkBill()" required>
                              <option value="">---Select Expenditure---</option>
                              @foreach($getexp_type as $row)
                              <option value="{{$row->id}},{{$row->exp_type}}">{{$row->exp_type}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="bill_group">
                              <label for="bill">Bill</label>
                              <select class="custom-select" name="bill" id="bill">
                                <option value="">---Select Bill---</option>
                                @foreach($getbill_type as $row)
                                <option value="{{$row->id}},{{$row->bills_type}}">{{$row->bills_type}}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" id="date" name="date" placeholder="Enter Date" autocomplete="off" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description (if any)"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" id="add_dept_btn" value="Add Expenditure" class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Edit Expenditure Modal -->
            <div class="modal fade" id="edit_exp_modal" tabindex="-1" aria-labelledby="edit_exp_modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="edit_exp_modalLabel">Edit Expenditure</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/editExp" method="post">
                    <div class="modal-body">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <input type="hidden" name="exp_type_id" id="exp_type_id">
                            <input type="hidden" name="bill_type_id" id="bill_type_id">
                            <label for="edit_expenditure">Expenditure</label>
                            <select class="custom-select" name="edit_expenditure" id="edit_expenditure" onchange="editCheckBill()" required>
                              <option value="">---Select Expenditure---</option>
                              @foreach($getexp_type as $row)
                              <option value="{{$row->id}},{{$row->exp_type}}">{{$row->exp_type}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="edit_bill_group">
                              <label for="edit_bill">Bill</label>
                              <select class="custom-select" name="edit_bill" id="edit_bill">
                                <option value="">---Select Bill---</option>
                                @foreach($getbill_type as $row)
                                <option value="{{$row->id}},{{$row->bills_type}}">{{$row->bills_type}}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="text" class="form-control" id="edit_date" name="edit_date" placeholder="Enter Date" autocomplete="off" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="edit_amount">Amount</label>
                            <input type="number" class="form-control" id="edit_amount" name="edit_amount" placeholder="Enter Amount" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="edit_description" rows="3" placeholder="Enter Description (if any)"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Edit Expenditure">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="table-responsive mb-4">
              <table class="table table-striped table-hover" id="dept_table">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Expenditure Type</th>
                    <th>Bill Type</th>
                    <th>Amount</th>
                    <th>Desc</th>
                    <th>Added By</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody id="emp_tbody">
                <?php $i=1?>
                  @foreach($getexp as $row)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$row->id}}</td>
                    <td>{{$row->exp}}</td>
                    <td>{{$row->bills}}</td>
                    <td>{{$row->amount}}</td>
                    <td>{{$row->desc}}</td>
                    <td>{{$row->added_by}}</td>
                    <td>{{$row->date}}</td>
                    <td><a href="#" onclick="checkBillId({{$row->bill_type_id}})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit_exp_modal" data-edit_id="{{$row->id}}" data-exp_type_id="{{$row->exp_type_id}}" data-bill_type_id="{{$row->bill_type_id}}" data-edit_exp="{{$row->exp}}" data-edit_bills="{{$row->bills}}" data-edit_desc="{{$row->desc}}" data-edit_amount="{{$row->amount}}" data-edit_date="{{$row->date}}"><i class="fas fa-edit"></i></a></td>
                    <td><a href="/delete_exp/{{$row->id}}" class="btn btn-sm btn-danger" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                    <script type="text/javascript">
                        function confirmDelete() {
                          return confirm('Are you sure you want to delete this expenditure?')
                        }
                    </script>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  @include('partials/footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('partials/scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready( function () {
  $('#bill_group').hide();
  $('#edit_bill_group').hide();
    var dept_table = $('#dept_table').DataTable({
        dom: 'Bfrtip',
        "pageLength": 50,
        buttons: ['copy','excel','print'],
        "aaSorting": [0,'asc']
    });

    $('input[name="date"]').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        locale:{
            cancelLabel: 'Clear'
        }
    });

    $('input[name="date"]').on('apply.daterangepicker', function(ev, picker){
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });

    $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker){
        $(this).val('');
    });

    $('input[name="edit_date"]').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        locale:{
            cancelLabel: 'Clear'
        }
    });

    $('input[name="edit_date"]').on('apply.daterangepicker', function(ev, picker){
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });

    $('input[name="edit_date"]').on('cancel.daterangepicker', function(ev, picker){
        $(this).val('');
    });

    window.checkBill = () => {
      let bill_data = document.querySelector('#expenditure').value;
      var n = bill_data.search("Bills");
      if(n > 0)
      {
        $('#bill_group').show();
        $("#expenditure").attr("required", "true");
      }
      else
      {
        $('#bill_group').hide();
      }
    }

    window.editCheckBill = () => {
      let bill_data = document.querySelector('#edit_expenditure').value;
      var n = bill_data.search("Bills");
      if(n > 0)
      {
        $('#edit_bill_group').show();
        $("#edit_expenditure").attr("required", "true");
        console.log('bill exists');
        $('#bill_type_id').val('yes');
      }
      else
      {
        $('#edit_bill_group').hide();
        $("#bill_type_id").val("");
        console.log('bill does not exists');
      }
    }

    window.checkBillId = (bill_type_id) =>{
      if(bill_type_id > 0)
      {
        $('#edit_bill_group').show();
        console.log('has bill type id');
      }
      else
      {
        $('#edit_bill_group').hide();
        console.log('dont have bill type id');
      }
    }

    $('#edit_exp_modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var edit_id = button.data('edit_id') // Extract info from data-* attributes
      var exp_type_id = button.data('exp_type_id')
      var bill_type_id = button.data('bill_type_id')
      var edit_exp = button.data('edit_exp')
      var edit_bills = button.data('edit_bills')
      var edit_desc = button.data('edit_desc')
      var edit_amount = button.data('edit_amount')
      var edit_date = button.data('edit_date')
      
      var modal = $(this)
      modal.find('.modal-body #edit_id').val(edit_id)
      modal.find('.modal-body #exp_type_id').val(exp_type_id)
      modal.find('.modal-body #bill_type_id').val(bill_type_id)
      modal.find('.modal-body #edit_expenditure').val(exp_type_id+','+edit_exp)
      modal.find('.modal-body #edit_bill').val(bill_type_id+','+edit_bills)
      modal.find('.modal-body #edit_amount').val(edit_amount)
      modal.find('.modal-body #edit_description').val(edit_desc)
      modal.find('.modal-body #edit_date').val(edit_date)
      });
 
});
</script>
</body>
</html>
