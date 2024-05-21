@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Notice View</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
              <li class="breadcrumb-item active">Notice View</li>
            </ol>
          </div>
        </div>
      </div>
    </div>



    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">


<div class="col-lg-12 col-lg-12"> 
           <!-- TO DO List -->
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  {{ $notice_view->notice_type }} Notice
                </h3>
              </div>
          
        <div class="card-header">{{ $notice_view->notice_title }}</div> 
       <div class="card-body">{!! $notice_view->notice_message !!}</div>

        <div class="card-footer"><a href="{{ url('assets/notice/' . $notice_view->notice_file) }}">{{ $notice_view->notice_file }}</a></div>

    </div>
</div> 


       </div>        
    </div>       
 </div>        
</div>

@endsection
