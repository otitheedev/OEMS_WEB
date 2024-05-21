@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Department</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Department</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


 <!-- Main content -->
 <section class="content">


 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



      <div class="container card p-2">

<!-- form code  start-->


<form action="{{ url('/admin/department/update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" class="form-control" name="department_id" value="{{ $department->id }}" required>

  <div class="form-group">
    <label for="formGroupDepartment">Department Name</label>
    <input type="text" class="form-control" name="department_name" placeholder="Department Name" value="{{ $department->department_name }}" required>
  </div>

  <div class="form-group">
    <label for="formGroupPhoto">Department Photo</label>
    <input type="file" class="form-control" id="formGroupPhoto" name="department_photo">
</div<>

   
  <!-- richtext editor start -->
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<script type="text/javascript" src="{{ asset('richtexteditor/rte.js') }}"></script>
<script>RTE_DefaultConfig.url_base="{{ asset('richtexteditor') }}"></script>
<script type="text/javascript" src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<style>.rte_command_insertimage, .rte_command_insertvideo{display:none;} </style>

<div class="form-group">
<label for="formGroupExampleInput3">Details</label>
	<textarea name="department_information" id="div_editor1">{!! $department->department_information !!}</textarea>
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
    <label for="formGroupExampleInput2">General Manager</label>
    <input type="text" class="form-control" id="formGroupExampleInput2" name="department_gm" value="{{ $department->department_gm }}" placeholder="General Manager Name">
  </div>

<div class="form-group">
    <label for="formGroupExampleInput2">Chairman</label>
    <input type="text" class="form-control" id="formGroupExampleInput2" name="department_director" value="{{ $department->department_director }}" placeholder="General Director Name">
</div>

<div class="form-group">
    <input type="submit" class="form-control bg-primary">
</div>


<!-- form code end -->
</form>    

      </div>
</section>

@endsection