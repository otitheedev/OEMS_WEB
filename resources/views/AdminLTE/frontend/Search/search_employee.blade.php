@include('AdminLTE/re_usable_admin/dataTable_jQuery')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<title>@yield('title', 'Search Otithee Employees')</title>
    

 <!-- Main content -->
 <section class="container-fluid mt-4">


 @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="container card p-2">

<!-- Your DataTable HTML -->
<table id="example" class="display" style="max-width:100%; text-align:center;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Department name</th>
            <th>Phone</th>
            <th>Blood Group</th>
            <th>Date Of Birth</th>
        </tr>
    </thead>
    <tbody>
    
    @foreach ($users as $info)
        <tr>
            <td><a href="{{ url('/employee/ID/' . $info->phone_number) }}">{{ $info->name }}</a></td>
            <td><img src="{{ $info->profile_pic ? url('assets/users/' . $info->profile_pic) : url('assets/OG.png') }}" width="60px"></td>
            <td>{{ $info->department_name }}</td>
            <td>{{ $info->phone_number }}</td>
            <td>{{ $info->blood_group }}</td>
            <td>{{ $info->DOB }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            searching: true, 
        });
    });
</script>

      </div>
</section>

