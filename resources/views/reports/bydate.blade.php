<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Budget | Report By Date</title>

@include('partials/links')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
            <a href="{{url('/dashboard')}}" class="nav-link">
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
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/bydate')}}" class="nav-link active">
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
            <h1 class="m-0">Report : By Date</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report : By Date</li>
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
          <?php $date_count = DB::select("SELECT COUNT(date) as date_count FROM `expenditure`"); ?>
          @if($date_count[0]->date_count == 0)
            <h4 class="text-center text-danger">No Entries Made, Please Add Expenditure to View Report</h4>
          @else
            <form action="/bydate" method="post">
                @csrf
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" name="date" placeholder="Enter Date" autocomplete="off" required>
                        <input type="submit" value="Submit" name="submit" class="btn btn-success mt-3">
                    </div>
                </div>
            </form>
            @endif
            @if(!empty($getdatabydate))
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-hover" id="reportbydate_table">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Expenditure</th>
                            <th>Bill</th>
                            <th>Amount</th>
                            <th>Desc</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach($getdatabydate as $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->exp}}</td>
                                <td>{{$row->bills}}</td>
                                <td>{{$row->amount}}</td>
                                <td>{{$row->desc}}</td>
                                <td>{{$row->date}}</td>
                            </tr>
                            @endforeach
                            @if($total_amount[0]->total_amount != "")
                            <tr class="bg-success">
                                <td colspan=3 class="text-center text-bold">Total Amount</td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                                <td class="text-bold">{{$total_amount[0]->total_amount}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php $report_date = $row->date;?>
                            @else
                            <?php $report_date="";?>
                            @endif
                        </tbody>
                    </table>
                </div>
            @else
            <?php $report_date="";?>
            @endif
            
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
    var date = "<?php echo $report_date ?>";
    console.log(date);
    var reportbydate_table = $('#reportbydate_table').DataTable({
        dom: 'Bfrtip',
        "pageLength": 50,
        buttons: ['copy',{extend:'excel', title: 'Expenditure of Date: '+date},{extend:'print', title: 'Expenditure of Date: '+date}],
        "aaSorting": [0,'asc'],
        "language": {
          "emptyTable": "No Records Found"
        }
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

});
</script>
</body>
</html>
