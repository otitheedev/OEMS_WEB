@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Activity Logs</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Logs</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 
 <!-- Main content -->
 <section class="container-fluid">

 @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container-fluid card p-2">

<!-- Your DataTable HTML -->
<table id="example" class="table-responsive" style="max-width:100%">
    <thead>
        <tr>
            <th>Sr.</th>
            <th>User_ID</th>
            <th>Description</th>
            <th>Ip Address</th>
            <th>Time</th>
            <th style="width:30%">Browser_Agent</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('activitylogsAJAX') }}", 
           // searching: false, // Disable search bar
           // lengthChange: false, // Disable show entries dropdown
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user_name', name: 'user_name' },
                { 
                    data: 'description', 
                    name: 'description',
                    render: function(data, type, row) {
                        // Return the data as HTML
                        return $('<div/>').html(data).text();
                    }
                },
                { data: 'ip_address', name: 'ip_address' },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function(data, type, row) {
                        // Format the date
                        const date = new Date(data);
                        const options = { 
                            year: 'numeric', 
                            month: 'short', 
                            day: '2-digit', 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        };
                        return date.toLocaleDateString('en-US', options);
                    }
                },
                { data: 'browser_agent', name: 'browser_agent' }
            ]
        });
    });
</script>

</div>
</section>
@endsection