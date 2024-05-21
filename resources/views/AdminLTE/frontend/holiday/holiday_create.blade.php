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
            <h1 class="m-0">Create Holiday</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Holiday</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 



 <!-- Main content -->
 <section class="container-fluid">


<!-- form code  start-->
<form action="{{ url('/admin/holiday/store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="container-fulied" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">

  <div class="form-group">
<label for="formGroupExampleInput3">Holiday Title <span class="text-danger">*</span></label>
	<input type="text" name="holiday_title" class="form-control" placeholder="Holiday Title" required></input>
</div>

  
  <div class="form-group">
    <label for="formGroupDepartment">Holiday Type <span class="text-danger">*</span></label>
    <select class="form-control" name="holiday_type" required> 
       <option>Regular</option>
       <option>General</option>
       <option>Important</option>
    </select>
  </div>

<div class="form-group">
<label for="formGroupExampleInput3">Holiday File</label>
	<input type="file" name="holiday_file" class="form-control"></input>
</div>
   

<div class="row col-12">
<div class="col-sm-6 form-group">
<div class="form-group">
<label for="formGroupExampleInput3">Holiday Start</label>
	<input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}"></input>
</div>
</div>

<div class="col-sm-6 form-group">
<div class="form-group">
<label for="formGroupExampleInput3">Holiday End</label>
	<input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}"></input>
</div>

</div>

</div>

  <!-- richtext editor start -->
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<script type="text/javascript" src="{{ asset('richtexteditor/rte.js') }}"></script>
<script>RTE_DefaultConfig.url_base="{{ asset('richtexteditor') }}"></script>
<script type="text/javascript" src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<style>.rte_command_insertimage, .rte_command_insertvideo{display:none;} </style>

<div class="form-group">
<label for="formGroupExampleInput3">Holiday Details</label>
	<textarea name="holiday_message" id="div_editor1"></textarea>
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

<div class="form-group">
<input type="submit" class="btn btn-primary" value="Submit Holiday">
</div>

</div>
</form>    

</div></div>
</section>

@endsection