<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons start-->
  <link rel="icon" type="image/x-icon" href="{{ url('assets/OG.png') }}"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
.list-group-item.active {
    background: #ffc107;
}
/* end common class */
.top-status ul {
    list-style: none;
    display: flex;
    justify-content: space-around;
    justify-content: center;
    flex-wrap: wrap;
    padding: 0;
    margin: 0;
}
.top-status ul li {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    border: 8px solid #ddd;
    box-shadow: 1px 1px 10px 1px #ddd inset;
    margin: 10px 5px;
}
.top-status ul li.active {
    border-color: #ffc107;
    box-shadow: 1px 1px 20px 1px #ffc107 inset;
}
/* end top status */

ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 30px;
}
ul.timeline > li:before {
    content: '\2713';
    background: #fff;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #d4d9df;
    font-size: 24px;
    border: 2px solid #d4d9df;
}
ul.timeline > li.active:before {
    content: '\2713';
    background: #28a745;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #fff;
    font-size: 30px;
    border: 2px solid #28a745;
}
/* end timeline */
.table-responsive {display: table;}
</style>

    <!-- Bootstrap CSSss -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>{{ $user->name }}</title>
</head>

<body>
    <section class="my-5">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ $user->profile_pic ? url('assets/users/' . $user->profile_pic) : url('assets/OG.png') }}"
                                        class="rounded-circle p-1" style="width:250px; max-width:300px; height:250px; border:2px solid lightgrey;">
                                
                                    <div class="mt-3"> 

    @auth                            
     @if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))         
     <a href="{{ url('/admin/users/edit/'). '/' . $user->id }}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</a>   
     @endif
  @endauth

        <h4> {{ $user->name }} 
        @if($user->email === 'needyamin@gmail.com' || $user->phone_number == '01878578504')<i class="fa fa-check-circle" aria-hidden="true" style="color:#1730fc;"></i>
        @endif 
                                    </h4>
                                        <p class="text-secondary mb-1">{{ $user->designation }}</p>
                                        <p class="text-muted font-size-sm">{{ $user->address }}</p>
                                        <p class="text-secondary mb-1"> Birthday: 
                                        {{ \Carbon\Carbon::parse($user->DOB)->format('d F, Y') }}
                                        </p>
                                        <p class="text-secondary mb-2">Account Created {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }} </p>
                                        
                                        
    @auth                            
    @if($user->phone_number === auth()->user()->phone_number || auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))

          <p class="text-muted font-size-sm">
           <span class="badge-lg badge-success p-2" style="border-radius:5px;">Basic Salary: {{ $user->normal_salary }} tk ({{ $user->pay_frequency }})</span></p>

           <p class="text-muted font-size-sm">
           <span class="badge-lg badge-info p-2" style="border-radius:5px;">Total Pay: {{ $user->totalAmount }} tk ({{ $user->pay_frequency }})</span> 
          </p>
   @endif
  @endauth

   @if($user->otherBenifitsbyPercentage->isNotEmpty())
    <table class="table table-bordered" style="width:100%; text-align:left;"> 
     <tr><td>Benefits Name </td> <td> Benefits Percentage</td> </tr>
     @foreach($user->otherBenifitsbyPercentage as $item)
     <tr><td>{{ $item['other_benifits_name'] }} </td> <td> {{ $item['other_benifits_by_percentage'] }}</td> </tr>
     @endforeach

     </table>


    
@endif



<!-- Add font awesome icons -->
@if(!empty($user->facebook_link))
    <a href="{{ $user->facebook_link }}" class="fa fa-facebook-official fa-3x"></a> 
@endif

@if(!empty($user->instagram_link))
    <a href="{{ $user->instagram_link }}" class="fa fa-instagram fa-3x"></a>
@endif

@if(!empty($user->twitter_link))
    <a href="{{ $user->twitter_link }}" class="fa fa-twitter-square fa-3x"></a>
@endif

@if(!empty($user->linkedin_link))
    <a href="{{ $user->linkedin_link }}" class="fa fa-linkedin-square fa-3x"></a>
@endif


                                    </div>
                                </div>

                                <div class="list-group list-group-flush text-center mt-4">
                                    <a href="#" class="list-group-item list-group-item-action border-0 active">
                                        Profile Informaton
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action border-0">Address Book</a>
                                    <a href="#" class="list-group-item list-group-item-action border-0">All Activity</a>
                                    <h4><hr> QR Code </h4>
                            <img src="https://quickchart.io/chart?cht=qr&chs=400x400&chl={{ url('/employee/ID/'). '/' .$user->phone_number }}" class="img-responsive" style="border:1px solid lightgrey">
                                </div>

           
                            </div>
                        </div>
                    </div>


                  <!-- Family Members -->
                    <div class="col-lg-8">

                    
                    @if($user->academicRecords->isNotEmpty())
                        <div class="card p-1">
                        <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Educational Information</h4>
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Institute/College Name</th>
                                            <th scope="col">Degree</th>
                                            <th scope="col">Starting Year</th>
                                            <th scope="col">Pass Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($user->academicRecords as $record)
                                        <tr>
                                            <td>{{ $record->degree_information }} </td>
                                            <td>{{ $record->degree }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->join_year)->format('d F, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->pass_year)->format('d F, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif


                        @if($user->professional_certificate->isNotEmpty())
                        <div class="card mt-2 p-1">
                            <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0"><i class="fa fa-certificate" aria-hidden="true"></i> Professional Courses</h4>
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Certificate</th>
                                            <th scope="col">Organization</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($user->professional_certificate as $certificates)
                                        <tr>
                                            <td>{{ $certificates->certificate_name }} </td>
                                            <td>{{ $certificates->organization_name }}</td>
                                            <td><span class="">{{ \Carbon\Carbon::parse($user->start_date)->format('d F, Y') }}</span></td>
                                            <td><span class="">{{ \Carbon\Carbon::parse($user->end_date)->format('d F, Y') }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif


                <div class="card mt-2 p-1">
                     <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0"><i class="fa fa-child" aria-hidden="true"></i> Family Information</h4>

                         <table class="table mb-0" style="text-align:left;">
                                <thead>
                              <tr>
                                <th scope="col">Parents Name</th>
                                <th scope="col">Age</th>
                                <th scope="col">Occupation</th>
                                </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <tr>
                                <td>{{ $user->father_name }}</td>
                                
                                <td>
                                   {{ \Carbon\Carbon::parse($user->father_birthday)->format('d F, Y') }}
                                    <span class="text-secondary">(@php
                                     $birthDate = \Carbon\Carbon::parse($user->father_birthday);
                                     $currentDate = \Carbon\Carbon::now();
                                     $age = $currentDate->diffInYears($birthDate);
                                     echo $age . ' years';
                                    @endphp)</span>
                                  </td>

                                <td>{{ $user->father_occupation }}</td>
                                </tr>
                                <tr>
                                <td>{{ $user->mother_name }}</td>
                               
        <td>
        {{ \Carbon\Carbon::parse($user->mother_birthday)->format('d F, Y') }}
        <span class="text-secondary">(@php
        $birthDate = \Carbon\Carbon::parse($user->mother_birthday);
        $currentDate = \Carbon\Carbon::now();
        $age = $currentDate->diffInYears($birthDate);
        echo $age . ' years';
        @endphp)</span>
       </td>
                                <td>{{ $user->mother_occupation }}</td>
                                </tr>
                            </tbody>
                        </table>
                                </div>
                                

                                <div class="table-responsive">
                                <table class="table mb-0" style="text-align:left;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Children's Name</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Age</th>
                                        </tr>
                                    </thead>

                                  <tbody>
                                      @foreach ($user->child_info as $child)
                                        <tr>
                                            <td>{{ $child->child_name }} </td>
                                            <td>{{ $child->child_gender }} </td>
      <td>
        {{ \Carbon\Carbon::parse($user->child_birthday)->format('d F, Y') }}
        <span class="text-secondary">(@php
        $birthDate = \Carbon\Carbon::parse($user->child_birthday);
        $currentDate = \Carbon\Carbon::now();
        $age = $currentDate->diffInYears($birthDate);
        echo $age . ' years';
        @endphp)</span>
        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>






              <div class="card mt-2 p-1">
                            <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0"><i class="fa fa-ambulance" aria-hidden="true"></i> Emergency Contact</h4>
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Contact Name</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Contact Relation</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    
                                        <tr>
                                            <td>{{ $user->emergency_contact_name_1 }}</td>
                                            <td>{{ $user->emergency_contact_number_1 }}</td>
                                            <td>{{ $user->emergency_contact_relationship_1 }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>{{ $user->emergency_contact_name_2 }}</td>
                                            <td>{{ $user->emergency_contact_number_2 }}</td>
                                            <td>{{ $user->emergency_contact_relationship_2 }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>





                    @if($user->professional_certificate->isNotEmpty() || $user->academicRecords->isNotEmpty())
                        <div class="card mt-2">
                            <div class="card-body">
                                <h4><i class="fa fa-list" aria-hidden="true"></i> Timeline</h4>
                                    <ul class="timeline">

                                      @foreach ($user->professional_certificate as $certificates)
                                        <li class="active">
                                            <h6>{{ \Carbon\Carbon::parse($certificates->start_date)->format('Y') }} - {{ \Carbon\Carbon::parse($certificates->end_date)->format('Y') }}</h6>
                                            <p class="mb-0 text-muted">{{ $certificates->certificate_name }} From {{ $certificates->organization_name }}</p>
                                            <o class="text-muted">{{ \Carbon\Carbon::parse($user->end_date)->format('d F, Y') }}</p>
                                        </li>
                                        @endforeach

                                        @foreach ($user->academicRecords as $record)
                                        <li class="active">
                                            <h6>{{ \Carbon\Carbon::parse($record->join_year)->format('Y') }} - {{ \Carbon\Carbon::parse($record->pass_year)->format('Y') }}</h6>
                                            <p class="mb-0 text-muted">{{ $record->degree }} from {{ $record->degree_information }}</p>
                                            <o class="text-muted">{{ \Carbon\Carbon::parse($user->pass_year)->format('d F, Y') }}</p>
                                        </li>
                                        @endforeach

<!-- 
                                        <li class="active">
                                            <h6>PICKED</h6>
                                            <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque Lorem ipsum dolor</p>
                                            <o class="text-muted">21 March, 2014</p>
                                        </li>
                                        <li>
                                            <h6>PICKED</h6>
                                            <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque</p>
                                            <o class="text-muted">21 March, 2014</p>
                                        </li> -->

                                       
                                    </ul>
                            </div>
                        </div>
                        @endif



            @if($user->hobbies->isNotEmpty())
                 <div class="card mt-2 p-1">
                 <div class="card-body p-0 table-responsive">
                  <h4 class="p-3 mb-0"><i class="fa fa-houzz" aria-hidden="true"></i> Hobbies</h4>
                  @foreach ($user->hobbies as $record)
                  {!! "<span class='btn btn-sm btn-success mt-2'>" . $record->hobbies . '</span>' !!}
                  @endforeach
                    </div>
                </div>
                @endif

                @if($user->medicalHistory->isNotEmpty())
                <div class="card mt-2 p0">
                    <div class="card-header">
                  <h4 class="p-3 mb-0"><i class="fa fa-user-md" aria-hidden="true"></i> Medical History</h4>
                 </div>
                  <div class="card-body p-0 table-responsive">
                  @foreach ($user->medicalHistory as $recordi)
                  {!! "<span class='btn btn-sm btn-success mt-2'>" . $recordi->medical_history . '</span>' !!}
                  @endforeach
                    </div>
                </div>
                @endif


                    </div>
                </div>
            </div>
        </div>

        
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>





        
</body>

</html>