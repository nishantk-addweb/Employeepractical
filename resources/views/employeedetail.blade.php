\
<!DOCTYPE html>
<html>
<head>
    <title>Employee Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
  <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>Employee Details</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a>
    <table class="table table-bordered" id="user-table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>image</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart form-data">
                   <input type="hidden" name="employee_id" id="employee_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Emoloyee Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="empname" name="empname" placeholder="Enter Employee Name" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <textarea id="email" name="email" required="" placeholder="Enter email" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">contact</label>
                        <div class="col-sm-12">
                            <textarea id="contact" name="contact" required="" placeholder="Enter contact" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-12">
                            <input id="image" type="file" name="image" required="" class="form-control"></textarea>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
<script type="text/javascript">
  $(function() {
      
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'}, 
            {data: 'empname', name: 'empname'},
            {data: 'email', name: 'email'},
            {data: 'contact', name: 'contact'},

            {data: 'image', name: 'image',

            render:function(data,type,full,meta){
              return "<img src={{ asset('/empimages/') }}/" +data + " width='70' class='img-thumbnail'/>";
              },
              orderable:false
            },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#createNewEmployee').click(function () {
        $('#saveBtn').val("create-employee");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
          var fd = new FormData($('#productForm')[0]);

        $.ajax({
          data: fd,
          url: "{{ route('employeecontroller') }}",
          type: "POST",
          contentType:false,
          cache:false,
          processData:false,
          // enctype:"multipart form-data",
          dataType: 'json',
          success: function (data) {
     
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });

        $('body').on('click', '.editProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('edit') }}" +'/' + employee_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Employeeloyee");
          $('#saveBtn').val("edit-employee");
          $('#ajaxModel').modal('show');
          $('#employee_id').val(data.id);
          $('#empname').val(data.empname);
          $('#email').val(data.email);
          $('#contact').val(data.contact);
      })
   });
    });

  });
</script>    

</html>
