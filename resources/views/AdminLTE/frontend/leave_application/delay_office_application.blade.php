@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Delay Office Application</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Delay Office Application</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 
 <!-- Main content -->
 <section class="container-fluid">

 @if($leave_status->count() > 10)
 <p class="alert alert-danger"> Please contact with HR department. You already have a pending application </p>
 @else

<!-- form code  start-->
<form action="{{ url('/admin/application/store') }}" method="POST" enctype="multipart/form-data">
  @csrf

<div class="container-fulied" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
  <div class="form-group">
    <label for="formGroupDepartment">Application Type <span class="text-danger">*</span></label>
    <select class="form-control" name="application_type" required> 
       <option>Delay Office</option>
    </select>
  </div>

   
<!-- richtext editor start -->
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<script type="text/javascript" src="{{ asset('richtexteditor/rte.js') }}"></script>
<script>RTE_DefaultConfig.url_base="{{ asset('richtexteditor') }}"></script>
<script type="text/javascript" src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<style>.rte_command_insertimage, .rte_command_insertvideo, .rte_command_selectall{display:none;} </style>

<div class="form-group">
<label for="formGroupExampleInput3">Application Details</label>
	<textarea name="application_message" id="div_editor1"></textarea>
</div>
		<script>
		  var editor1 = new RichTextEditor("#div_editor1");
	    //editor1.setHTMLCode("<p><b>Why you are want leave</b></p>");
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
<input type="submit" class="btn btn-primary" value="Submit Application">
</div></div>
</form>    

@endif
</div></div>
</section>

@endsection