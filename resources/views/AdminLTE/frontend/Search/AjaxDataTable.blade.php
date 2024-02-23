<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User DataTable</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div>
        <label for="dateRange">Filter by Date Range:</label>
        <input type="date" id="startDate" name="startDate">
        <input type="date" id="endDate" name="endDate">
        <button id="applyFilter">Apply Filter</button>
    </div>

    <table id="ajaxDataTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
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
                    "url": "http://127.0.0.1:8000/api/AjaxDataTable",
                    "type": "GET",
                    "dataSrc": "data",
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "created_at"},
                    // Add other columns mapping as needed
                ]
            });

            $('#applyFilter').on('click', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                dataTable.ajax.url("http://127.0.0.1:8000/api/AjaxDataTable?dateRange[]=" + startDate + "&dateRange[]=" + endDate).load();
            });
        });
    </script>
</body>
</html>
