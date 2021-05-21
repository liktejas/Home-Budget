<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Budget | Exp & Bills Types</title>

@include('partials/links')
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
            <a href="{{url('/expNBills')}}" class="nav-link active">
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
            <h1 class="m-0">Expenditure & Bills Types</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expenditure & Bills Types</li>
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
            <span id="msg"></span>
            {!! session('db_change_status') !!}
            
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addExpType"><i class="fas fa-plus-circle"></i> Add Expenditure Type</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addExpNBills"><i class="fas fa-plus-circle"></i> Add Bills Type</button>
                </div>
            </div>
      
            <!-- Add Expenditure Type Modal -->
            <div class="modal fade" id="addExpType" tabindex="-1" aria-labelledby="addExpTypeLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addExpTypeLabel">Add Expenditure Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/addExpType" method="post">
                    <div class="modal-body">
                      @csrf
                      <div class="form-group">
                        <label for="expenditure_type">Add Expenditure Type:</label>
                        <input type="text" class="form-control" name="expenditure_type" id="expenditure_type" placeholder="Enter Expenditure Type" required autocomplete="off">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" id="add_exp_type_btn" value="Add Expenditure Type" class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Add Bill Type Modal -->
            <div class="modal fade" id="addExpNBills" tabindex="-1" aria-labelledby="addExpNBillsLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addExpNBillsLabel">Add Bill Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/addBillType" method="post">
                    <div class="modal-body">
                      @csrf
                      <div class="form-group">
                        <label for="bill_type">Add Bill Type:</label>
                        <input type="text" class="form-control" name="bills_type" id="bills_type" placeholder="Enter Bill Type" required autocomplete="off">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" id="add_bill_type_btn" value="Add Bill Type" class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Edit Expenditure Type Modal -->
            <div class="modal fade" id="edit_exp_type_modal" tabindex="-1" aria-labelledby="edit_exp_type_modal_Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="edit_exp_type_modal_Label">Edit Expenditure Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/editExpType" method="post">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="edit_expenditure_type">Edit Expenditure Type:</label>
                        <input type="text" class="form-control" name="edit_expenditure_type" id="edit_expenditure_type" required autocomplete="off">
                        <input type="hidden" name="edit_exp_id" id="edit_exp_id">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Edit Expenditure Type">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Edit Bill Type Modal -->
            <div class="modal fade" id="edit_bill_type_modal" tabindex="-1" aria-labelledby="edit_bill_type_modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="edit_bill_type_modalLabel">Edit Bill Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/editBillType" method="post">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="edit_bill_type">Edit Bill Type:</label>
                        <input type="text" class="form-control" name="edit_bill_type" id="edit_bill_type" required autocomplete="off">
                        <input type="hidden" name="edit_bill_id" id="edit_bill_id">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Edit Bill Type">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive mb-4">
                        <table class="table" id="exp_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Expenditure Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($getexp_type as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->exp_type}}</td>
                                    <td><a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_exp_type_modal" data-exp_type_id="{{$row->id}}" data-edit_expenditure_type="{{$row->exp_type}}"><i class="fas fa-edit"></i></a></td>
                                    <td><a href="/delete_exp_type/{{$row->id}}" class="btn btn-danger btn-sm" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                                    <script type="text/javascript">
                                        function confirmDelete() {
                                        return confirm('Are you sure you want to delete this Expenditure Type?')
                                        }
                                    </script>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive mb-4">
                        <table class="table" id="bills_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Bill Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($getbills_type as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->bills_type}}</td>
                                    <td><a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_bill_type_modal" data-edit_bill_id="{{$row->id}}" data-edit_bill_type="{{$row->bills_type}}"><i class="fas fa-edit"></i></a></td>
                                    <td><a href="/delete_bill_type/{{$row->id}}" class="btn btn-danger btn-sm" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i></a>
                                    <script type="text/javascript">
                                        function confirmDelete() {
                                        return confirm('Are you sure you want to delete this Bill Type?')
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
<script>
$(document).ready( function () {
    var exp_table = $('#exp_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel','print'],
        "pageLength": 30,
        "aaSorting": [0,'asc']
    });
    var bills_table = $('#bills_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel','print'],
        "pageLength": 30,
        "aaSorting": [0,'asc']
    });

    $('#edit_exp_type_modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var exp_type_id = button.data('exp_type_id') // Extract info from data-* attributes
      var edit_expenditure_type = button.data('edit_expenditure_type')
      
      var modal = $(this)
      modal.find('.modal-body #edit_exp_id').val(exp_type_id)
      modal.find('.modal-body #edit_expenditure_type').val(edit_expenditure_type)
    });
    
    $('#edit_bill_type_modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var edit_bill_id = button.data('edit_bill_id') // Extract info from data-* attributes
      var edit_bill_type = button.data('edit_bill_type')
      
      var modal = $(this)
      modal.find('.modal-body #edit_bill_id').val(edit_bill_id)
      modal.find('.modal-body #edit_bill_type').val(edit_bill_type)
    });

});
</script>
</body>
</html>
