@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">


<div class="col-lg-12 col-lg-12"> 
           <!-- TO DO List -->
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  Notice Details
                </h3>
              </div>
          
       <div class="card-body" style="max-height: 350px; overflow-y: scroll;">
                
       {{ $notice_view->notice_title }}


        </div>
    </div>
</div> 


       </div>        
    </div>       
 </div>        
</div>

@endsection
