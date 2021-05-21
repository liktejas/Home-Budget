<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Budget | Report By Month</title>

@include('partials/links')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@if(!empty($databymonth))
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ["Expenditure", "Expenditure Count", { role: 'style' }],
        <?php
        $exp_data_arr = "";
        foreach($exp_type as $row)
        {
          $exp_type_data = DB::select("SELECT *, COUNT(*) AS exp_count FROM `expenditure` WHERE MONTH(date)=$month AND YEAR(date)=$year AND exp='$row->exp_type'");
          $exp_data_arr.="['".$row->exp_type."',".$exp_type_data[0]->exp_count.", 'gold'],";
        }
        echo $exp_data_arr = rtrim($exp_data_arr, ",");
        ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0,
                        { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" },
                        1]);
        var options = {
          title: "Monthly Expenditure Report",
          width: window.innerWidth-450,
          height: 400,
          bar: {groupWidth: "50%"},
          legend: { position: "bottom" },
          'chartArea': {'width': '80%'},
          // colors: ['purple'],
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("expenditure_chart"));
        chart.draw(view, options);
    }
    window.onresize = callDrawChartFun;

    function callDrawChartFun() {
      drawChart();
    }
  </script>
@endif
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
                <a href="{{url('/bydate')}}" class="nav-link">
                  <i class="fas fa-calendar-day nav-icon"></i>
                  <p>By Date</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/bymonth')}}" class="nav-link active">
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
            <h1 class="m-0">Report : By Month</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report : By Month</li>
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
            
            <form action="/bymonth" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="year">Select Year</label>
                            <select class="custom-select" id="year" name="year" required>
                                <option value="">--- Select Year ---</option>
                                @for($i=$minmonthyear[0]->min_year; $i<=$minmonthyear[0]->max_year; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month">Select Month</label>
                            <select class="custom-select" id="month" name="month" required>
                                <option value="">--- Select Month ---</option>
                                <option value="01">1 - January</option>
                                <option value="02">2 - Febraury</option>
                                <option value="03">3 - March</option>
                                <option value="04">4 - April</option>
                                <option value="05">5 - May</option>
                                <option value="06">6 - June</option>
                                <option value="07">7 - July</option>
                                <option value="08">8 - August</option>
                                <option value="09">9 - September</option>
                                <option value="10">10 - October</option>
                                <option value="11">11 - November</option>
                                <option value="12">12 - December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Submit" name="submit" class="btn btn-success my-4">
                    </div>
                </div>
            </form>

            @if(empty($databymonthcount))
            <?php $month = ""; $year = ""; $date = ""; $time= "";$report_month = "";?>
            @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-5" id="expenditure_chart"></div>
                  </div>
                </div>

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
                            @foreach($databymonth as $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->exp}}</td>
                                <td>{{$row->bills}}</td>
                                <td>{{$row->amount}}</td>
                                <td>{{$row->desc}}</td>
                                <td>{{$row->date}}</td>
                                <?php $date = $row->date;?>
                            </tr>
                            @endforeach
                            @if($total_amount[0]->total_amount != "")
                            <tr class="bg-success">
                                <td colspan="3" class="text-center text-bold">Total Amount</td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                                <td class="text-bold">{{$total_amount[0]->total_amount}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            <?php $date = "";?>
                            @endif
                        </tbody>
                    </table>
                </div>
                <?php
                $time=strtotime($date);
                $report_month=date("F",$time);
                ?>
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
    var report_month = "<?php echo $report_month ?>";
    var year = "<?php echo $year ?>";
    var reportbydate_table = $('#reportbydate_table').DataTable({
        dom: 'Bfrtip',
        "pageLength": 50,
        buttons: ['copy',{extend:'excel', title: 'Expenditure for the month of '+report_month+' - '+year},{extend:'print', title: 'Expenditure for the month of '+report_month+' - '+year}],
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
