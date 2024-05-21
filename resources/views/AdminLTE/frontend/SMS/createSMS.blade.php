@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Send SMS')
@section('content')



  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Send SMS</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Send SMS</a></li>
              <li class="breadcrumb-item active">OEMS</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


 <!-- Main content -->
<section class="content">

@if(session('success'))
   <div class="alert alert-success" role="alert">
       {{ session('success') }}
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
@endif

@if($errors->any())
   <div class="alert alert-danger" role="alert">
       <ul>
           @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
@endif



<div class="container-fluid card p-2">


<form action="{{ url('admin/sms/') }}" type="get">
<div class="row">

<div class="col-6">
  <img class="form-right img-thumbnail" style="width:400px;" src="{{ url('assets/OG.png') }}">
  </div>


<div class="col-6">
    <div class="col-sm-12 form-group">
      <label for="certName">Phone Number</label>

      <div class="input-group">
            <span class="input-group-text">+88</span>
            <input type="number" name="phone_number" class="form-control" placeholder="Enter your phone number" aria-describedby="basic-addon2">
        </div>

    </div>

    <div class="col-sm-12 form-group">
      <label for="certName">Message</label>
      <textarea type="text" name="message" class="form-control" rows="5" placeholder="Type Your SMS Here"></textarea>
    </div>

    <div class="col-sm-12 form-group">
      <input type="submit" class="bg-primary form-control" value="Send SMS">
    </div>
</form>
 </div>

  </div>
</div>



</div>


</section>

@endsection