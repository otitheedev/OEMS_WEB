<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Add a class to the th of the column you want to hide on mobile */
        .mobile-hide {
            display: table-cell;
        }

        @media screen and (max-width: 600px) {
            /* Hide the column when the screen width is less than 600px (adjust as needed) */
            .mobile-hide {
                display: none;
            }
        }
    </style>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

      <div class="container-fluid mt-5" >
        <div class="row mb-2">
          <div class="col-sm-12" >
            <h1 class="m-0" style="text-align:center;"><i class="fa fa-search" style="font-size:48px;"></i> Search Employees</h1>
          </div>
  
        </div>
      </div>
    </div>
 
<div class="container card p-2" style="width:100%;">

<!--    <div class="text-right">
        <label for="dateRange">Filter by Date Range:</label>
        <input type="date" id="startDate" name="startDate">
        <input type="date" id="endDate" name="endDate">
        <button id="applyFilter">Apply Filter</button>
    </div>
 -->
    <table id="ajaxDataTable" class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th> Department </th>
                <th> Gender </th>
                <th> Designation </th>
                <th>Email</th>
                <th>Phone Number</th>
                <!-- Add other columns as needed -->
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function() {
            var dataTable = $('#ajaxDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/api/AjaxDataTable",
                    "type": "GET",
                    "dataSrc": "data",
                    "beforeSend": function(xhr) {
                // Include your custom headers here
                xhr.setRequestHeader('X-Username', 'needyamin@gmail.com');
                xhr.setRequestHeader('X-Key', 'needyamin@gmail.com');
            },
                },
                "columns": [
                    {"data": "id", "className": "text-center"},
                    
                {"data": "profile_pic",
                "render": function(data, type, row) {
                    var imageUrl = data ? "{{ url('assets/users/') }}/" + data : "{{ url('assets/OG.png') }}";
                    return '<img src="' + imageUrl + '" width="60px">';
                 },
                     "orderData": [0] 
                 },

                {
               "data": name,
               "render": function(data, type, row) {
                // Assuming $users is accessible in this context
                return '<a href="{{ url("/employee/ID/") }}/' + row.phone_number + '" target="_blank">' + row.name + '</a>';
                 },"orderData": [0] 
                },
                 {"data": "department_name", "className": "mobile-hide"},
                 {"data": "gender", "className": "mobile-hide", "className": "text-center"},
                 {"data": "designation", "className": "mobile-hide"},
                 {"data": "email", "className": "mobile-hide"},
                 {"data": "phone_number"},
              ],     responsive: true
            });

            $('#applyFilter').on('click', function() {
             var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

              // Check if both startDate and endDate are not empty before making the Ajax call
              if (startDate !== '' && endDate !== '') {
              // Your Ajax call
                   dataTable.ajax.url("/api/AjaxDataTable?dateRange[]=" + startDate + "&dateRange[]=" + endDate).load();
            } else {
        alert('Please select both start date and end date.');
        }
        });


        });
    </script>



</div>
</section>

