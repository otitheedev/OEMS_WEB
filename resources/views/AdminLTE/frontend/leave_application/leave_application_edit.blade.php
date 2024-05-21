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
            <h1 class="m-0">Edit Leave Application</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Leave Application</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 



 <!-- Main content -->
 <section class="container-fluid">


<!-- form code  start-->
<form action="{{ url('/admin/application/update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <input type="hidden" class="form-control" name="leave_id" value="{{ $leave->id }}" required>

  <div class="container-fulied" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">

  @auth                            
  @if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))     
  <div class="form-group">
    <label for="formGroupDepartment">Status <span class="text-danger">*</span></label>
    <select class="form-control" name="status" style="background:#fffdc9; font-weight:bold;" required> 
    <option value="0" {{ $leave->status == 0 ? 'selected' : '' }}>Pending</option>
    <option value="1" {{ $leave->status == 1 ? 'selected' : '' }}>Approved</option>
    <option value="2" {{ $leave->status == 2 ? 'selected' : '' }}>Rejected</option>
    <option value="3" {{ $leave->status == 3 ? 'selected' : '' }}>Contact HR Department</option>
    <option value="4" {{ $leave->status == 4 ? 'selected' : '' }}>Delay Office</option>

    </select>
  </div>
  @endif
  @endauth


  <div class="form-group">
    <label for="formGroupDepartment">Application Type <span class="text-danger">*</span></label>
    <select class="form-control" name="application_type" required> 
      <option selectd>{{ $leave->application_type }}</option>
       <option>Sick leave</option>
       <option>Annual leave</option>
       <option>Maternity/paternity leave</option>
       <option>Bereavement leave</option>
       <option>Personal leave</option>
       <option>Jury duty leave</option>
       <option>Study leave</option>
       <option>Special leave</option>
       <option>Unpaid leave</option>
       <option>Emergency leave</option>
       <option>Compassionate leave</option>
       <option>Sabbatical leave</option>
    </select>
  </div>


 <div class="row mt-1 mb-2">
  <div class="col-sm-6">
   <label for="start_date"><i class="fa-regular fa-user"></i> Start From </label>
   <input type="date" class="form-control" name="application_start_date" value="{{ substr($leave->application_start_date, 0, 10) }}">
 </div>

 <div class="col-sm-6">
 <label for="end_date"><i class="fa-regular fa-user"></i> End Date </label>
   <input type="date" class="form-control" name="application_end_date" value="{{ substr($leave->application_end_date, 0, 10) }}">
 </div>
 </div>
   

  <!-- richtext editor start -->
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<script type="text/javascript" src="{{ asset('richtexteditor/rte.js') }}"></script>
<script>RTE_DefaultConfig.url_base="{{ asset('richtexteditor') }}"></script>
<script type="text/javascript" src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<style>.rte_command_insertimage, .rte_command_insertvideo{display:none;} </style>

<div class="form-group">
<label for="formGroupExampleInput3">Application Details</label>
	<textarea name="application_message" id="div_editor1"> {!! $leave->application_message !!}</textarea>
</div>
		<script>
		  var editor1 = new RichTextEditor("#div_editor1");
	 
			function btngetHTMLCode() {
				alert(editor1.getHTMLCode())
			}
			function btnsetHTMLCode() {
				editor1.setHTMLCode("<h1>editor1.setHTMLCode() sample</h1><p>You clicked the setHTMLCode button at " + new Date() + "</p>")
			}
			function btngetPlainText() {
				alert(editor1.getPlainText())
			}
		</script>
<!-- richtext editor end -->

@if ($leave->file_applications)
<a href="{{ url('assets/leave/' . $leave->file_applications) }}
">{{ url('assets/leave/' . $leave->file_applications) }}</a>
@endif
<div class="col-sm-12">
 <label for="end_date"><i class="fa-regular fa-user"></i>UPLOAD FILE<span class="text-danger">*</span></label>
   <input type="file" class="form-control" name="file_applications">
</div></div>






<div class="form-group">
<input type="submit" class="btn btn-primary" value="Submit Application">
</div>

</div>
</form>    

</div></div>
</section>

@endsection