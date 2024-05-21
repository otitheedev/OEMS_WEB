@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

<style> 
.hidden { display: none;}
#preview-container {position: relative;}
#image-preview {max-width: 180px;max-height: 220px;min-width: 180px;min-height: 220px;cursor: pointer;float:right; border:1px solid lightgrey;}
#file-input {position: absolute;left: 0;opacity: 0;width: 100%;height: 100%;cursor: pointer;}
.alertify-notifier .ajs-message.ajs-error{background: #d50707 !important;color:white;border-radius: 6px;} 
.alertify-notifier .ajs-message.ajs-success{background: #779d77 !important;color:white;border-radius: 6px;} 
/* input added required colorinput[required]{content:"*";color: red;} */
</style>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0"><i class="fa-solid fa-user"></i> Add Employee </h5>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Employee</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

 <!-- Main content -->
 <section class="content">
    <div class="container card p-2">
         
<!-- form code  start-->
<div class="container">
  <form action="{{ url('/admin/users/store') }}" id="create_users_form" method="POST" enctype="multipart/form-data">
  @csrf

<div class="row jumbotron box" style="padding:8px !important; border-radius:5px;">
<div class="col-sm-6 form-group"></div>
<div class="col-sm-6 form-group">

<div id="preview-container">
    <img id="image-preview" alt="Image Preview" src="http://via.placeholder.com/300x350" onclick="openFileInput()">
    <input id="file-input" class="form-control form-control-sm" name="profile_pic" type="file" onchange="previewImage()">
  </div>
<script>
  function openFileInput() {document.getElementById('file-input').click();}
    function previewImage() {
      var fileInput = document.getElementById('file-input');
      var previewContainer = document.getElementById('preview-container');
      var imagePreview = document.getElementById('image-preview');
      var file = fileInput.files[0];
      if (file) {var reader = new FileReader();reader.onload = function (e) {imagePreview.src = e.target.result;};
      reader.readAsDataURL(file);previewContainer.style.display = 'block';} else {previewContainer.style.display = 'none';imagePreview.src = '';}}
  </script>


</div>


<div class="container" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
     <div class="row col-12">
     <div class="col-12"> <h4><i class="fa-solid fa-book"></i> Employee Information </h4><hr></div>

     <div class="col-sm-12 form-group">
        <label for="name-f"><i class="fa-regular fa-user"></i> Attendance_uid <span class="text-danger">*</span></label>
        <input type="number" class="form-control" name="attendance_uid" placeholder="attendance_uid" required>
      </div>
      

      <div class="col-sm-6 form-group">
        <label for="name-f"><i class="fa-regular fa-user"></i> Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="demo" required>
      </div>


      <div class="col-sm-6 form-group">
      <label for="email"><i class="fa-regular fa-envelope"></i> Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email." value="demo@demo.com" required>
      </div>
      <div class="col-sm-6 form-group">
        <label for="designation"><i class="fa-solid fa-signs-post"></i> Designation <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="demo" required>
      </div>
      <div class="col-sm-6 form-group">
        <label for="address"><i class="fa-regular fa-address-book"></i> Address <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="demo" required>
      </div>
      


<!-- Department -->
      <div class="row col-12">
      <div class="col-sm-6 form-group">
        <label for="department_name"><i class="fa-regular fa-building"></i> Department Name <span class="text-danger">*</span></label>
        <select class="form-control custom-select browser-default" name="department_name">
        @foreach ($department as $depart)
          <option>{{ $depart->department_name }}</option>
          @endforeach
        </select>
      </div>
     
  <div class="col-sm-3 form-group">
        <label for="otithee_joining_date"><i class="fa-solid fa-calendar-days"></i>  Joining Date <span class="text-danger">*</span></label>
        <input type="Date" name="otithee_joining_date" class="form-control" value="{{ now()->format('Y-m-d') }}" value="{{ now()->format('d/m/Y') }}" required>
      </div>

      <div class="col-sm-3 form-group">
        <label for="blood_group"><i class="fa-solid fa-droplet"></i> Blood Group</label>
       
        <select class="form-control" name="blood_group" id="blood_group"> 
          <option disabled selected>Select Blood Group</option>
          <option>A+</option>
          <option>A-</option>
          <option>B+</option>
          <option>B-</option>
          <option>AB+</option>
          <option>AB-</option>
          <option>O+</option>
          <option>O-</option>
  


        </select>
      </div>
   </div>



      <div class="col-sm-6 form-group">
        <label for="Country"><i class="fa-solid fa-globe"></i> Country <span class="text-danger">*</span></label>
        <select class="form-control custom-select browser-default" name="nationality_country">
          <option value="Afghanistan">Afghanistan</option>
          <option value="Åland Islands">Åland Islands</option>
          <option value="Albania">Albania</option>
          <option value="Algeria">Algeria</option>
          <option value="American Samoa">American Samoa</option>
          <option value="Andorra">Andorra</option>
          <option value="Angola">Angola</option>
          <option value="Anguilla">Anguilla</option>
          <option value="Antarctica">Antarctica</option>
          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
          <option value="Argentina">Argentina</option>
          <option value="Armenia">Armenia</option>
          <option value="Aruba">Aruba</option>
          <option value="Australia">Australia</option>
          <option value="Austria">Austria</option>
          <option value="Azerbaijan">Azerbaijan</option>
          <option value="Bahamas">Bahamas</option>
          <option value="Bahrain">Bahrain</option>
          <option value="Bangladesh" selected>Bangladesh</option>
          <option value="Barbados">Barbados</option>
          <option value="Belarus">Belarus</option>
          <option value="Belgium">Belgium</option>
          <option value="Belize">Belize</option>
          <option value="Benin">Benin</option>
          <option value="Bermuda">Bermuda</option>
          <option value="Bhutan">Bhutan</option>
          <option value="Bolivia">Bolivia</option>
          <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
          <option value="Botswana">Botswana</option>
          <option value="Bouvet Island">Bouvet Island</option>
          <option value="Brazil">Brazil</option>
          <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
          <option value="Brunei Darussalam">Brunei Darussalam</option>
          <option value="Bulgaria">Bulgaria</option>
          <option value="Burkina Faso">Burkina Faso</option>
          <option value="Burundi">Burundi</option>
          <option value="Cambodia">Cambodia</option>
          <option value="Cameroon">Cameroon</option>
          <option value="Canada">Canada</option>
          <option value="Cape Verde">Cape Verde</option>
          <option value="Cayman Islands">Cayman Islands</option>
          <option value="Central African Republic">Central African Republic</option>
          <option value="Chad">Chad</option>
          <option value="Chile">Chile</option>
          <option value="China">China</option>
          <option value="Christmas Island">Christmas Island</option>
          <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
          <option value="Colombia">Colombia</option>
          <option value="Comoros">Comoros</option>
          <option value="Congo">Congo</option>
          <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
          <option value="Cook Islands">Cook Islands</option>
          <option value="Costa Rica">Costa Rica</option>
          <option value="Cote D'ivoire">Cote D'ivoire</option>
          <option value="Croatia">Croatia</option>
          <option value="Cuba">Cuba</option>
          <option value="Cyprus">Cyprus</option>
          <option value="Czech Republic">Czech Republic</option>
          <option value="Denmark">Denmark</option>
          <option value="Djibouti">Djibouti</option>
          <option value="Dominica">Dominica</option>
          <option value="Dominican Republic">Dominican Republic</option>
          <option value="Ecuador">Ecuador</option>
          <option value="Egypt">Egypt</option>
          <option value="El Salvador">El Salvador</option>
          <option value="Equatorial Guinea">Equatorial Guinea</option>
          <option value="Eritrea">Eritrea</option>
          <option value="Estonia">Estonia</option>
          <option value="Ethiopia">Ethiopia</option>
          <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
          <option value="Faroe Islands">Faroe Islands</option>
          <option value="Fiji">Fiji</option>
          <option value="Finland">Finland</option>
          <option value="France">France</option>
          <option value="French Guiana">French Guiana</option>
          <option value="French Polynesia">French Polynesia</option>
          <option value="French Southern Territories">French Southern Territories</option>
          <option value="Gabon">Gabon</option>
          <option value="Gambia">Gambia</option>
          <option value="Georgia">Georgia</option>
          <option value="Germany">Germany</option>
          <option value="Ghana">Ghana</option>
          <option value="Gibraltar">Gibraltar</option>
          <option value="Greece">Greece</option>
          <option value="Greenland">Greenland</option>
          <option value="Grenada">Grenada</option>
          <option value="Guadeloupe">Guadeloupe</option>
          <option value="Guam">Guam</option>
          <option value="Guatemala">Guatemala</option>
          <option value="Guernsey">Guernsey</option>
          <option value="Guinea">Guinea</option>
          <option value="Guinea-bissau">Guinea-bissau</option>
          <option value="Guyana">Guyana</option>
          <option value="Haiti">Haiti</option>
          <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
          <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
          <option value="Honduras">Honduras</option>
          <option value="Hong Kong">Hong Kong</option>
          <option value="Hungary">Hungary</option>
          <option value="Iceland">Iceland</option>
          <option value="India">India</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
          <option value="Iraq">Iraq</option>
          <option value="Ireland">Ireland</option>
          <option value="Isle of Man">Isle of Man</option>
          <option value="Israel">Israel</option>
          <option value="Italy">Italy</option>
          <option value="Jamaica">Jamaica</option>
          <option value="Japan">Japan</option>
          <option value="Jersey">Jersey</option>
          <option value="Jordan">Jordan</option>
          <option value="Kazakhstan">Kazakhstan</option>
          <option value="Kenya">Kenya</option>
          <option value="Kiribati">Kiribati</option>
          <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
          <option value="Korea, Republic of">Korea, Republic of</option>
          <option value="Kuwait">Kuwait</option>
          <option value="Kyrgyzstan">Kyrgyzstan</option>
          <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
          <option value="Latvia">Latvia</option>
          <option value="Lebanon">Lebanon</option>
          <option value="Lesotho">Lesotho</option>
          <option value="Liberia">Liberia</option>
          <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
          <option value="Liechtenstein">Liechtenstein</option>
          <option value="Lithuania">Lithuania</option>
          <option value="Luxembourg">Luxembourg</option>
          <option value="Macao">Macao</option>
          <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
          <option value="Madagascar">Madagascar</option>
          <option value="Malawi">Malawi</option>
          <option value="Malaysia">Malaysia</option>
          <option value="Maldives">Maldives</option>
          <option value="Mali">Mali</option>
          <option value="Malta">Malta</option>
          <option value="Marshall Islands">Marshall Islands</option>
          <option value="Martinique">Martinique</option>
          <option value="Mauritania">Mauritania</option>
          <option value="Mauritius">Mauritius</option>
          <option value="Mayotte">Mayotte</option>
          <option value="Mexico">Mexico</option>
          <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
          <option value="Moldova, Republic of">Moldova, Republic of</option>
          <option value="Monaco">Monaco</option>
          <option value="Mongolia">Mongolia</option>
          <option value="Montenegro">Montenegro</option>
          <option value="Montserrat">Montserrat</option>
          <option value="Morocco">Morocco</option>
          <option value="Mozambique">Mozambique</option>
          <option value="Myanmar">Myanmar</option>
          <option value="Namibia">Namibia</option>
          <option value="Nauru">Nauru</option>
          <option value="Nepal">Nepal</option>
          <option value="Netherlands">Netherlands</option>
          <option value="Netherlands Antilles">Netherlands Antilles</option>
          <option value="New Caledonia">New Caledonia</option>
          <option value="New Zealand">New Zealand</option>
          <option value="Nicaragua">Nicaragua</option>
          <option value="Niger">Niger</option>
          <option value="Nigeria">Nigeria</option>
          <option value="Niue">Niue</option>
          <option value="Norfolk Island">Norfolk Island</option>
          <option value="Northern Mariana Islands">Northern Mariana Islands</option>
          <option value="Norway">Norway</option>
          <option value="Oman">Oman</option>
          <option value="Pakistan">Pakistan</option>
          <option value="Palau">Palau</option>
          <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
          <option value="Panama">Panama</option>
          <option value="Papua New Guinea">Papua New Guinea</option>
          <option value="Paraguay">Paraguay</option>
          <option value="Peru">Peru</option>
          <option value="Philippines">Philippines</option>
          <option value="Pitcairn">Pitcairn</option>
          <option value="Poland">Poland</option>
          <option value="Portugal">Portugal</option>
          <option value="Puerto Rico">Puerto Rico</option>
          <option value="Qatar">Qatar</option>
          <option value="Reunion">Reunion</option>
          <option value="Romania">Romania</option>
          <option value="Russian Federation">Russian Federation</option>
          <option value="Rwanda">Rwanda</option>
          <option value="Saint Helena">Saint Helena</option>
          <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
          <option value="Saint Lucia">Saint Lucia</option>
          <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
          <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
          <option value="Samoa">Samoa</option>
          <option value="San Marino">San Marino</option>
          <option value="Sao Tome and Principe">Sao Tome and Principe</option>
          <option value="Saudi Arabia">Saudi Arabia</option>
          <option value="Senegal">Senegal</option>
          <option value="Serbia">Serbia</option>
          <option value="Seychelles">Seychelles</option>
          <option value="Sierra Leone">Sierra Leone</option>
          <option value="Singapore">Singapore</option>
          <option value="Slovakia">Slovakia</option>
          <option value="Slovenia">Slovenia</option>
          <option value="Solomon Islands">Solomon Islands</option>
          <option value="Somalia">Somalia</option>
          <option value="South Africa">South Africa</option>
          <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
          <option value="Spain">Spain</option>
          <option value="Sri Lanka">Sri Lanka</option>
          <option value="Sudan">Sudan</option>
          <option value="Suriname">Suriname</option>
          <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
          <option value="Swaziland">Swaziland</option>
          <option value="Sweden">Sweden</option>
          <option value="Switzerland">Switzerland</option>
          <option value="Syrian Arab Republic">Syrian Arab Republic</option>
          <option value="Taiwan, Province of China">Taiwan, Province of China</option>
          <option value="Tajikistan">Tajikistan</option>
          <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
          <option value="Thailand">Thailand</option>
          <option value="Timor-leste">Timor-leste</option>
          <option value="Togo">Togo</option>
          <option value="Tokelau">Tokelau</option>
          <option value="Tonga">Tonga</option>
          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
          <option value="Tunisia">Tunisia</option>
          <option value="Turkey">Turkey</option>
          <option value="Turkmenistan">Turkmenistan</option>
          <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
          <option value="Tuvalu">Tuvalu</option>
          <option value="Uganda">Uganda</option>
          <option value="Ukraine">Ukraine</option>
          <option value="United Arab Emirates">United Arab Emirates</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="United States">United States</option>
          <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
          <option value="Uruguay">Uruguay</option>
          <option value="Uzbekistan">Uzbekistan</option>
          <option value="Vanuatu">Vanuatu</option>
          <option value="Venezuela">Venezuela</option>
          <option value="Viet Nam">Viet Nam</option>
          <option value="Virgin Islands, British">Virgin Islands, British</option>
          <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
          <option value="Wallis and Futuna">Wallis and Futuna</option>
          <option value="Western Sahara">Western Sahara</option>
          <option value="Yemen">Yemen</option>
          <option value="Zambia">Zambia</option>
          <option value="Zimbabwe">Zimbabwe</option>
        </select>
      </div>

      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-solid fa-cake-candles"></i> Date Of Birth <span class="text-danger">*</span></label>
        <input type="Date" name="DOB" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
      </div>

      </div>
    
    
    <!-- Start Other Information section-->      
     <div class="row col-12">

     
  
      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-solid fa-address-card"></i> NID Information <span class="text-danger">*</span></label>
        <input type="number" name="nid_Information" class="form-control" id="nid_Information" placeholder="NID Number (Must Be matched with Candidate Age)" value="100" required>
      </div>
 


      <div class="col-sm-2 form-group">
        <label for="height">Height (inch) </label>
        <input type="text" name="height" class="form-control" value="8.9'" placeholder="Height">
      </div>
      
      <div class="col-sm-2 form-group">
        <label for="Weight"> Weight (KG) </label>
        <input type="text" name="weight" class="form-control" value="Weight (KG)" placeholder="Weight (KG)">
      </div>

      <div class="col-sm-2 form-group">
        <label for="Date"><i class="fa-solid fa-language"></i> Spoken Language</label>
        <input type="text" name="language" class="form-control" value="bangla" placeholder="Language">
      </div>

      
      
      <div class="col-sm-2 form-group">
        <label for="cod"><i class="fa-solid fa-flag"></i> Country code <span class="text-danger">*</span></label>
        <select class="form-control browser-default custom-select" name="phoneCountry" >
          <option data-countryCode="US" value="1" selected>USA (+1)</option>
          <option data-countryCode="GB" value="44">UK (+44)</option>

          <option disabled="disabled">Other Countries</option>
          <option data-countryCode="DZ" value="213">Algeria (+213)</option>
          <option data-countryCode="AD" value="376">Andorra (+376)</option>
          <option data-countryCode="AO" value="244">Angola (+244)</option>
          <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
          <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
          <option data-countryCode="AR" value="54">Argentina (+54)</option>
          <option data-countryCode="AM" value="374">Armenia (+374)</option>
          <option data-countryCode="AW" value="297">Aruba (+297)</option>
          <option data-countryCode="AU" value="61">Australia (+61)</option>
          <option data-countryCode="AT" value="43">Austria (+43)</option>
          <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
          <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
          <option data-countryCode="BH" value="973">Bahrain (+973)</option>
          <option data-countryCode="BD" value="880" selected>Bangladesh (+880)</option>
          <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
          <option data-countryCode="BY" value="375">Belarus (+375)</option>
          <option data-countryCode="BE" value="32">Belgium (+32)</option>
          <option data-countryCode="BZ" value="501">Belize (+501)</option>
          <option data-countryCode="BJ" value="229">Benin (+229)</option>
          <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
          <option data-countryCode="BT" value="975">Bhutan (+975)</option>
          <option data-countryCode="BO" value="591">Bolivia (+591)</option>
          <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
          <option data-countryCode="BW" value="267">Botswana (+267)</option>
          <option data-countryCode="BR" value="55">Brazil (+55)</option>
          <option data-countryCode="BN" value="673">Brunei (+673)</option>
          <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
          <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
          <option data-countryCode="BI" value="257">Burundi (+257)</option>
          <option data-countryCode="KH" value="855">Cambodia (+855)</option>
          <option data-countryCode="CM" value="237">Cameroon (+237)</option>
          <option data-countryCode="CA" value="1">Canada (+1)</option>
          <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
          <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
          <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
          <option data-countryCode="CL" value="56">Chile (+56)</option>
          <option data-countryCode="CN" value="86">China (+86)</option>
          <option data-countryCode="CO" value="57">Colombia (+57)</option>
          <option data-countryCode="KM" value="269">Comoros (+269)</option>
          <option data-countryCode="CG" value="242">Congo (+242)</option>
          <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
          <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
          <option data-countryCode="HR" value="385">Croatia (+385)</option>
          <option data-countryCode="CU" value="53">Cuba (+53)</option>
          <option data-countryCode="CY" value="90">Cyprus - North (+90)</option>
          <option data-countryCode="CY" value="357">Cyprus - South (+357)</option>
          <option data-countryCode="CZ" value="420">Czech Republic (+420)</option>
          <option data-countryCode="DK" value="45">Denmark (+45)</option>
          <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
          <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
          <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
          <option data-countryCode="EC" value="593">Ecuador (+593)</option>
          <option data-countryCode="EG" value="20">Egypt (+20)</option>
          <option data-countryCode="SV" value="503">El Salvador (+503)</option>
          <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
          <option data-countryCode="ER" value="291">Eritrea (+291)</option>
          <option data-countryCode="EE" value="372">Estonia (+372)</option>
          <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
          <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
          <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
          <option data-countryCode="FJ" value="679">Fiji (+679)</option>
          <option data-countryCode="FI" value="358">Finland (+358)</option>
          <option data-countryCode="FR" value="33">France (+33)</option>
          <option data-countryCode="GF" value="594">French Guiana (+594)</option>
          <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
          <option data-countryCode="GA" value="241">Gabon (+241)</option>
          <option data-countryCode="GM" value="220">Gambia (+220)</option>
          <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
          <option data-countryCode="DE" value="49">Germany (+49)</option>
          <option data-countryCode="GH" value="233">Ghana (+233)</option>
          <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
          <option data-countryCode="GR" value="30">Greece (+30)</option>
          <option data-countryCode="GL" value="299">Greenland (+299)</option>
          <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
          <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
          <option data-countryCode="GU" value="671">Guam (+671)</option>
          <option data-countryCode="GT" value="502">Guatemala (+502)</option>
          <option data-countryCode="GN" value="224">Guinea (+224)</option>
          <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
          <option data-countryCode="GY" value="592">Guyana (+592)</option>
          <option data-countryCode="HT" value="509">Haiti (+509)</option>
          <option data-countryCode="HN" value="504">Honduras (+504)</option>
          <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
          <option data-countryCode="HU" value="36">Hungary (+36)</option>
          <option data-countryCode="IS" value="354">Iceland (+354)</option>
          <option data-countryCode="IN" value="91">India (+91)</option>
          <option data-countryCode="ID" value="62">Indonesia (+62)</option>
          <option data-countryCode="IQ" value="964">Iraq (+964)</option>
          <option data-countryCode="IR" value="98">Iran (+98)</option>
          <option data-countryCode="IE" value="353">Ireland (+353)</option>
          <option data-countryCode="IL" value="972">Israel (+972)</option>
          <option data-countryCode="IT" value="39">Italy (+39)</option>
          <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
          <option data-countryCode="JP" value="81">Japan (+81)</option>
          <option data-countryCode="JO" value="962">Jordan (+962)</option>
          <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
          <option data-countryCode="KE" value="254">Kenya (+254)</option>
          <option data-countryCode="KI" value="686">Kiribati (+686)</option>
          <option data-countryCode="KP" value="850">Korea - North (+850)</option>
          <option data-countryCode="KR" value="82">Korea - South (+82)</option>
          <option data-countryCode="KW" value="965">Kuwait (+965)</option>
          <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
          <option data-countryCode="LA" value="856">Laos (+856)</option>
          <option data-countryCode="LV" value="371">Latvia (+371)</option>
          <option data-countryCode="LB" value="961">Lebanon (+961)</option>
          <option data-countryCode="LS" value="266">Lesotho (+266)</option>
          <option data-countryCode="LR" value="231">Liberia (+231)</option>
          <option data-countryCode="LY" value="218">Libya (+218)</option>
          <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
          <option data-countryCode="LT" value="370">Lithuania (+370)</option>
          <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
          <option data-countryCode="MO" value="853">Macao (+853)</option>
          <option data-countryCode="MK" value="389">Macedonia (+389)</option>
          <option data-countryCode="MG" value="261">Madagascar (+261)</option>
          <option data-countryCode="MW" value="265">Malawi (+265)</option>
          <option data-countryCode="MY" value="60">Malaysia (+60)</option>
          <option data-countryCode="MV" value="960">Maldives (+960)</option>
          <option data-countryCode="ML" value="223">Mali (+223)</option>
          <option data-countryCode="MT" value="356">Malta (+356)</option>
          <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
          <option data-countryCode="MQ" value="596">Martinique (+596)</option>
          <option data-countryCode="MR" value="222">Mauritania (+222)</option>
          <option data-countryCode="YT" value="269">Mayotte (+269)</option>
          <option data-countryCode="MX" value="52">Mexico (+52)</option>
          <option data-countryCode="FM" value="691">Micronesia (+691)</option>
          <option data-countryCode="MD" value="373">Moldova (+373)</option>
          <option data-countryCode="MC" value="377">Monaco (+377)</option>
          <option data-countryCode="MN" value="976">Mongolia (+976)</option>
          <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
          <option data-countryCode="MA" value="212">Morocco (+212)</option>
          <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
          <option data-countryCode="MN" value="95">Myanmar (+95)</option>
          <option data-countryCode="NA" value="264">Namibia (+264)</option>
          <option data-countryCode="NR" value="674">Nauru (+674)</option>
          <option data-countryCode="NP" value="977">Nepal (+977)</option>
          <option data-countryCode="NL" value="31">Netherlands (+31)</option>
          <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
          <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
          <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
          <option data-countryCode="NE" value="227">Niger (+227)</option>
          <option data-countryCode="NG" value="234">Nigeria (+234)</option>
          <option data-countryCode="NU" value="683">Niue (+683)</option>
          <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
          <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
          <option data-countryCode="NO" value="47">Norway (+47)</option>
          <option data-countryCode="OM" value="968">Oman (+968)</option>
          <option data-countryCode="PK" value="92">Pakistan (+92)</option>
          <option data-countryCode="PW" value="680">Palau (+680)</option>
          <option data-countryCode="PA" value="507">Panama (+507)</option>
          <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
          <option data-countryCode="PY" value="595">Paraguay (+595)</option>
          <option data-countryCode="PE" value="51">Peru (+51)</option>
          <option data-countryCode="PH" value="63">Philippines (+63)</option>
          <option data-countryCode="PL" value="48">Poland (+48)</option>
          <option data-countryCode="PT" value="351">Portugal (+351)</option>
          <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
          <option data-countryCode="QA" value="974">Qatar (+974)</option>
          <option data-countryCode="RE" value="262">Reunion (+262)</option>
          <option data-countryCode="RO" value="40">Romania (+40)</option>
          <option data-countryCode="RU" value="7">Russia (+7)</option>
          <option data-countryCode="RW" value="250">Rwanda (+250)</option>
          <option data-countryCode="SM" value="378">San Marino (+378)</option>
          <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
          <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
          <option data-countryCode="SN" value="221">Senegal (+221)</option>
          <option data-countryCode="CS" value="381">Serbia (+381)</option>
          <option data-countryCode="SC" value="248">Seychelles (+248)</option>
          <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
          <option data-countryCode="SG" value="65">Singapore (+65)</option>
          <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
          <option data-countryCode="SI" value="386">Slovenia (+386)</option>
          <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
          <option data-countryCode="SO" value="252">Somalia (+252)</option>
          <option data-countryCode="ZA" value="27">South Africa (+27)</option>
          <option data-countryCode="ES" value="34">Spain (+34)</option>
          <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
          <option data-countryCode="SH" value="290">St. Helena (+290)</option>
          <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
          <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
          <option data-countryCode="SR" value="597">Suriname (+597)</option>
          <option data-countryCode="SD" value="249">Sudan (+249)</option>
          <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
          <option data-countryCode="SE" value="46">Sweden (+46)</option>
          <option data-countryCode="CH" value="41">Switzerland (+41)</option>
          <option data-countryCode="SY" value="963">Syria (+963)</option>
          <option data-countryCode="TW" value="886">Taiwan (+886)</option>
          <option data-countryCode="TJ" value="992">Tajikistan (+992)</option>
          <option data-countryCode="TH" value="66">Thailand (+66)</option>
          <option data-countryCode="TG" value="228">Togo (+228)</option>
          <option data-countryCode="TO" value="676">Tonga (+676)</option>
          <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
          <option data-countryCode="TN" value="216">Tunisia (+216)</option>
          <option data-countryCode="TR" value="90">Turkey (+90)</option>
          <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
          <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
          <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
          <option data-countryCode="UG" value="256">Uganda (+256)</option>
          <option data-countryCode="UA" value="380">Ukraine (+380)</option>
          <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
          <option data-countryCode="UY" value="598">Uruguay (+598)</option>
          <option data-countryCode="UZ" value="998">Uzbekistan (+998)</option>
          <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
          <option data-countryCode="VA" value="379">Vatican City (+379)</option>
          <option data-countryCode="VE" value="58">Venezuela (+58)</option>
          <option data-countryCode="VN" value="84">Vietnam (+84)</option>
          <option data-countryCode="VG" value="1">Virgin Islands - British (+1)</option>
          <option data-countryCode="VI" value="1">Virgin Islands - US (+1)</option>
          <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
          <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
          <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
          <option data-countryCode="ZM" value="260">Zambia (+260)</option>
          <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
        </select>
      </div>

      <div class="col-sm-4 form-group">
        <label for="tel"><i class="fa-solid fa-phone-volume"></i> Phone <span class="text-danger">*</span></label>
        <input type="number" name="phone_number" class="form-control" id="tel" placeholder="Enter Your Contact Number." value="01878578504" required>
      </div>

      <div class="col-sm-3 form-group">
        <label for="sex"><i class="fa-solid fa-venus-mars"></i> Gender <span class="text-danger">*</span></label>
        <select id="sex" name="gender" class="form-control browser-default custom-select">
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="unspesified">Unspecified</option>
        </select>
      </div>

<div class="col-sm-3 form-group">
  <label for="sex"><i class="fa-solid fa-people-roof"></i> Marital Status</label>
  <select id="maritalStatus" name="marital_status" class="form-control browser-default custom-select">
    <option value="single">Single</option>
    <option value="married">Married</option>
    <option value="unspecified">Unspecified</option>
  </select>
</div>

<div class="container" id="newUserForm" style="display: none;">
  <div class="row">
  <div class="col-sm-6 form-group">
  <label> <i class="fa-solid fa-hand-holding-heart"></i> Spouse name</label>
  <input type="text" name="spouse_name" class="form-control" placeholder="Spouse Name">
  </div>


  <div class="col-sm-6 form-group">
  <label><i class="fa-solid fa-cake-candles"></i> Spouse Birthday</label>
  <input type="date" name="spouse_birthday" class="form-control">
  </div>

  <div class="col-sm-6 form-group">
  <label> <i class="fa-solid fa-id-card"></i> Spouse NID</label>
  <input type="text" name="spouse_nid" class="form-control" placeholder="Spouse NID Number">
  </div>


  <div class="col-sm-6 form-group">
  <label><i class="fa-solid fa-cake-candles"></i> Anniversary</label>
  <input type="date" name="spouse_anniversary" class="form-control">
  </div>


  </div>
  
</div>

<script>
document.getElementById('maritalStatus').addEventListener('change', toggleNewUserForm);
function toggleNewUserForm() {
var maritalStatus = document.getElementById('maritalStatus');
var newUserForm = document.getElementById('newUserForm');
if (maritalStatus && maritalStatus.value === 'married') {newUserForm.style.display = 'block';} else {newUserForm.style.display = 'none';}}
</script>


      <div class="col-sm-6 form-group">
        <label for="pass"><i class="fa-solid fa-key"></i> Password</label>
        <input type="password" name="password" class="form-control" id="pass" placeholder="Enter your password." value="123456" required>
      </div>
      <div class="col-sm-6 form-group">
        <label for="pass2"><i class="fa-solid fa-key"></i> Confirm Password</label>
        <input type="password" name="cnf-password" class="form-control" id="pass2" placeholder="Re-enter your password." value="123456" required>
      </div>
<!-- End Other Information section-->
</div></div>


    
   <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
     <div class="row col-12 ">
     <div class="col-12"> <h4><i class="fa-solid fa-book"></i> Salary Information </h4><hr></div>
 

      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-solid fa-money-bill"></i> Basic Salary <span class="text-danger">*</span></label>
        <input type="number" name="normal_salary" class="form-control" id="text" placeholder="Basic Salary" value="500" required>
      </div>

      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-regular fa-clock"></i> Pay Frequency</label>
      
        <select name="pay_frequency" class="form-control" > 
          <option>Daily</option>
          <option selected> Monthly</option>
          <option> Yearly </option>
        </select>
      </div>


      <!-- new added Shuvo bhai 18-2-2024 -->
<div class="row col-12" style="background: rgb(255, 253, 250); border: 1px solid lightgray; border-radius: 15px; padding: 15px;">
      <div class="col-12"> <h5> Other Benifits (Increment by %.) </h5><hr></div>
     
      <div class="col-sm-4 form-group">
        <label for="Date"> Bonus Information <i class="fa-solid fa-percent"></i></label>
        <input type="number" name="bonus_information" class="form-control" id="text" placeholder="Bonus Information" value="0">
      </div>

      <div class="col-sm-4 form-group">
        <label for="Date"><i class="fa-solid fa-heart-circle-plus"></i> Healthcare Insurance <i class="fa-solid fa-percent"></i></label>
        <input type="number" name="healthcare_insurance" class="form-control" id="text" placeholder="Healthcare Insurance" value="0">
      </div>

      <div class="col-sm-4 form-group">
        <label for="Date"> Provident Fund <i class="fa-solid fa-percent"></i></label>
        <input type="number" name="providend_fund" class="form-control" id="text" placeholder="Healthcare Insurance" value="0">
      </div>

</div>   

<div class="col-sm-12 form-group"><div id="dynamic-form-fields_percentage"></div> 
  <div class="text-center"> <button type="button" style="width:100%" class="btn-sm btn-primary mt-2" onclick="addBonusFormFields()">Add More Benifits</button></div>
  </div>

<!-- script for array -->
<script>
    var bfpercentage = 1;
  var bf_amapercentage = 1;

  function addBonusFormFields() {
    var container = document.getElementById('dynamic-form-fields_percentage');
    var newRowpercentage = document.createElement('div');
    newRowpercentage.className = 'row mt-2';
    newRowpercentage.style.background = '#fffdfa';
    newRowpercentage.style.border = '1px solid lightgray';
    newRowpercentage.style.borderRadius = '15px';
    newRowpercentage.style.padding = '15px';
    newRowpercentage.classList.add('percentage-input');

    newRowpercentage.innerHTML = '<div class="col-sm-6 form-group">' +
      '<label for="Date"><i class="fa-solid fa-home"></i> Other Benifits Name ' + bfpercentage++ +' </label>' +
      '<input type="text" name="other_benifits_name[]" class="form-control" id="text" placeholder="Benifits Name">' +
      '</div>' +

    '<div class="col-sm-6 form-group">' +
      '<label for="Date"><i class="fa-solid fa-heart-circle-plus"></i> Other Benifits <i class="fa-solid fa-percent"></i></label>' +
      '<input type="number" name="other_benifits_by_percentage[]" class="form-control" id="text" placeholder="Benifits %" onchange="calculateTotalAmount()">' +
      '</div>' +

      '<div class="col-sm-4 form-group">' +
      '<button type="button" class="btn-sm btn-danger" onclick="removeFormFieldsBF(this)">Remove</button>' +
      '</div>';

    container.appendChild(newRowpercentage);
  }
</script>




<!-- Payment information -->
<div class="row col-12 mt-3" style="background: rgb(255, 253, 250); border: 1px solid lightgray; border-radius: 15px; padding: 15px;">
    <div class="col-12"> <h5><i class="fa fa-plus-circle" aria-hidden="true"></i> Payment Information</h5><hr></div>

      <div class="col-sm-6 form-group">
        <label for="bank"><i class="fa-solid fa-money-bill"></i> Bank Account Number</label>
        <input type="number" name="bank_account_number_official" class="form-control" placeholder="Bank Account Number" value="0000000">
      </div>

      <div class="col-sm-6 form-group">
        <label for="bank"><i class="fa-solid fa-money-check"></i> bKash Number</label>
        <input type="number" name="bkash_account_number" class="form-control" placeholder="bKash Number" value="0000000">
      </div>

      <div class="col-sm-6 form-group">
        <label for="bank"><i class="fa-solid fa-money-check"></i> Nogod Number</label>
        <input type="number" name="nogod_account_number" class="form-control" placeholder="Nogod Number" value="0000000">
      </div>

      <div class="col-sm-6 form-group">
        <label for="bank"><i class="fa-solid fa-mobile"></i> Rocket Number</label>
        <input type="number" name="rocket_account_number" class="form-control" placeholder="Rocket Number" value="0000000">
      </div>
      
</div>






<div class="row col-12 mt-3" style="background: rgb(255, 253, 250); border: 1px solid lightgray; border-radius: 15px; padding: 15px;">
    <div class="col-12"> <h5> Extra Benifits (For example: Mobile bill, Incentive..)</h5><hr></div>


      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-solid fa-hand-holding-heart"></i> Extra Other Benefits</label>
        <input type="number" name="extra_benefits" class="form-control" placeholder="Extra Benefits" value="0">
      </div>

      <div class="col-sm-6 form-group">
        <label for="Date"><i class="fa-solid fa-mobile"></i> Mobile Bill</label>
        <input type="number" name="mobile_bill" class="form-control" placeholder="Mobile Bill" value="0">
      </div>
  </div>



<div class="col-sm-12 form-group"><div id="dynamic-form-fields_benifits"></div> 
  <div class="text-center"> <button type="button" style="width:100%" class="btn-sm btn-primary mt-2" onclick="addbenifitsFormFields()">Add More Extra Benifits</button></div>
  </div>


  <div class="col-12 form-group">
    <label for="totalAmount"> Total Salary <i class="fa-solid fa-bangladeshi-taka-sign"></i></label> 
    <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly>
    
    <!-- Hidden input to store the value -->
     <input type="hidden" name="totalAmount" id="totalAmountstore" class="form-control">
</div>


<script>
  var bf = 1;
  var bf_ama = 1;

  function addbenifitsFormFields() {
    var container = document.getElementById('dynamic-form-fields_benifits');
    var newRow = document.createElement('div');
    newRow.className = 'row mt-2';
    newRow.style.background = '#fffdfa';
    newRow.style.border = '1px solid lightgray';
    newRow.style.borderRadius = '15px';
    newRow.style.padding = '15px';


    newRow.innerHTML = '<div class="col-6 form-group">' +
      '<label for="Date">Extra Benifits Name ' + bf++ + '</label>' +
      '<input type="text" name="benifits_name[]" class="form-control" placeholder="Extra Benifits Name">' +
      '</div>' +

      '<div class="col-6 form-group">' +
      '<label for="pass">Amount ' + bf_ama++ + '</label>' +
      '<input type="number" name="benifits_amount[]" class="form-control" onchange="calculateTotalAmount()">' +
      '</div>' +

      '<div class="col-12 mb-2">' +
      '<button type="button" class="btn-sm btn-danger" onclick="removeFormFieldsBF(this)">Remove</button>' +
      '</div>';

    container.appendChild(newRow);
    calculateTotalAmount();
  }

 function removeFormFieldsBF(button) {
    var rowToRemove = button.parentNode.parentNode;
    rowToRemove.parentNode.removeChild(rowToRemove);
    calculateTotalAmount();
  }



  function calculateTotalAmount() {
    var basicSalary = parseFloat(document.getElementsByName('normal_salary')[0].value) || 0;

    function getPercentageValue(fieldName) {
        return parseFloat(document.getElementsByName(fieldName)[0].value) || 0;
    }

    // Multiple Array  // needyamin
    function getMultiPercentageValue(fieldName) {
    var elements = document.getElementsByName(fieldName); 
    var total = 0; for (var i = 0; i < elements.length; i++) {total += parseFloat(elements[i].value) || 0;} 
    return total;
    }  

    function calculatePercentageAmount(percentage) {
        return (basicSalary * percentage) / 100;
    }

    // Get percentage values from input fields
    var healthcareInsurancePercentage = getPercentageValue("healthcare_insurance");
    var providendFundPercentage = getPercentageValue("providend_fund");
    var bonusInformationPercentage = getPercentageValue("bonus_information");
    var percentageInputsPercentage = getMultiPercentageValue("other_benifits_by_percentage[]");  // needyamin

    // Calculate amounts based on percentages
    var healthcareInsurance = calculatePercentageAmount(healthcareInsurancePercentage);
    var providendFund = calculatePercentageAmount(providendFundPercentage);
    var bonusInformation = calculatePercentageAmount(bonusInformationPercentage);
    var percentageInputInformation = calculatePercentageAmount(percentageInputsPercentage); // needyamin

    var mobileBill = parseFloat(document.getElementsByName('mobile_bill')[0].value) || 0;
    var extraBenefits = parseFloat(document.getElementsByName('extra_benefits')[0].value) || 0;

    // BeifitsAmount
    var benifitsAmountFields = document.getElementsByName('benifits_amount[]');
    var totalBenifitsAmount = 0;
    for (var i = 0; i < benifitsAmountFields.length; i++) {
        totalBenifitsAmount += parseFloat(benifitsAmountFields[i].value) || 0;
    }
    
    // Get PerCentage Loop
    var totalAmount = basicSalary + healthcareInsurance + percentageInputInformation + providendFund + bonusInformation + extraBenefits + mobileBill + totalBenifitsAmount;

    document.getElementById('totalAmount').value = totalAmount.toFixed(2) + ' BDT';
    document.getElementById('totalAmountstore').value = totalAmount.toFixed(2);
}


    document.addEventListener('DOMContentLoaded', function() {
        var numberInputFields = document.querySelectorAll('input[type="number"]');
        numberInputFields.forEach(function (input) {
            input.addEventListener('input', calculateTotalAmount);
        });
    });
</script>

</div></div>


      <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px; border: 1px solid lightgray;">
      <h4><i class="fa-solid fa-school"></i> Education Section</h4> <hr>
        <!-- Academic Qualifications 1 (static) -->
        <div class="row col-12 mt-1" style="border: 1px solid lightgray;padding: 5px;border-radius:7px;">
            <div class="col-sm-3 form-group">
                <label for="degree1">Degree name</label>
                <input type="text" class="form-control" name="degree[]" placeholder="Degree name 1" value="Degree" required>
            </div>

            <div class="col-sm-3 form-group">
                <label for="degree">Institute/College Name</label>
                <input type="text" class="form-control" name="degree_information[]" placeholder="Institute/College Name" value="Institute/College Name" required>
            </div>

            <div class="col-sm-3 form-group">
                <label for="joiningYear">Joining Year</label>
                <input type="date" name="joining_year[]" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <div class="col-sm-3 form-group">
                <label for="passingYear">Passing Year</label>
                <input type="date" name="passing_year[]" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
        </div>

        <!-- Dynamic Academic Qualifications (to be added/removed) -->
        <div id="academicFieldsContainer"></div>
      
        <div class="text-right">
        <button type="button" class="btn-sm btn-primary mt-1" onclick="addAcademicField()">Add More</button>
        <button type="button" class="btn-sm btn-danger mt-1" onclick="removeAcademicField()">Remove Last</button>
        </div>
</div>


<script>
    let countDegree = 1;
    let countInstitute = 1;
    let academicFieldIndex = 2; // Initial index for additional academic fields

    function addAcademicField() {
        const container = document.getElementById('academicFieldsContainer');

        const academicField = document.createElement('div');
        academicField.className = 'row col-12 mt-1';
        academicField.style = 'border: 1px solid lightgray;padding: 5px;border-radius:7px;';

        const degreeNameInput = createInputField('text', 'form-control', `degree[]`, `Degree Name`+ countDegree++);
        const degreeInput = createInputField('text', 'form-control', `degree_information[]`, `Institute/College Name `+ countInstitute++);
        const joiningYearInput = createInputField('date', 'form-control', `joining_year[]`, `Joining Year`, '{{ now()->format('Y-m-d') }}');
        const passingYearInput = createInputField('date', 'form-control', `passing_year[]`, `Passing Year`, '{{ now()->format('Y-m-d') }}');

        academicField.appendChild(degreeNameInput);
        academicField.appendChild(degreeInput);
        academicField.appendChild(joiningYearInput);
        academicField.appendChild(passingYearInput);

        container.appendChild(academicField);

        academicFieldIndex++;
    }

    function createInputField(type, className, name, placeholder, value = '') {
        const div = document.createElement('div');
        div.className = 'col-sm-3 form-group';

        const label = document.createElement('label');
        label.setAttribute('for', name);
        label.textContent = placeholder;

        const input = document.createElement('input');
        input.type = type;
        input.className = className;
        input.name = name;
        input.placeholder = placeholder;
        input.value = value;

        div.appendChild(label);
        div.appendChild(input);

        return div;
    }

    function removeAcademicField() {
        if (academicFieldIndex > 2) {
            academicFieldIndex--;
            const container = document.getElementById('academicFieldsContainer');
            container.removeChild(container.lastChild);
        }
    }

</script>

      
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
      <h4><i class="fa-solid fa-people-group"></i> Family Information </h4> <hr>
      <div class="row col-12" style="border: 1px solid lightgray; border-radius:7px; padding:5px;">
      <div class="col-sm-6 form-group">
        <label for="Date">Father Name</label>
      <div class="col-sm-12 form-group">
        <input type="text" name="father_name" class="form-control" placeholder="Father Name" value="My Father  Name">
      </div>


      <label for="Date">Father Birthday</label>
      <div class="col-sm-12 form-group">
        <input type="date" name="father_birthday" value="{{ now()->format('Y-m-d') }}"  class="form-control">
      </div>
        
     <div class="col-sm-12 form-group">
        <label for="father_occupation">Father's Occupation</label>
    <select name="father_occupation" class="form-control">
        <option disabled selected>Select One</option>
        <option value="accountant">Accountant</option>
        <option value="govt_employee">Govt Employee</option>
        <option value="actor">Actor</option>
        <option value="architect">Architect</option>
        <option value="artist">Artist</option>
        <option value="chef">Chef</option>
        <option value="dentist">Dentist</option>
        <option value="engineer">Engineer</option>
        <option value="firefighter">Firefighter</option>
        <option value="graphic_designer">Graphic Designer</option>
        <option value="hair_stylist">Hair Stylist</option>
        <option value="journalist">Journalist</option>
        <option value="lawyer">Lawyer</option>
        <option value="mechanic">Mechanic</option>
        <option value="pharmacist">Pharmacist</option>
        <option value="pilot">Pilot</option>
        <option value="police_officer">Police Officer</option>
        <option value="professor">Professor</option>
        <option value="software_developer">Software Developer</option>
        <option value="teacher">Teacher</option>
        <option value="veterinarian">Veterinarian</option>
        <option value="others">others</option>
         <!-- Add more options as needed -->
         </select>
     </div>
      </div>
      

      <div class="col-sm-6 form-group">

     <label for="Date">Mother Name</label>
      <div class="col-sm-12 form-group">
        <input type="text" name="mother_name" class="form-control" placeholder="Mother Name" value="My Mother name"></div>
      <div class="col-sm-12 form-group">
      
      <label for="Date">Mother Birthday</label>
      <div class="col-sm-12 form-group">
        <input type="date" name="mother_birthday" value="{{ now()->format('Y-m-d') }}"  class="form-control">
      </div>

        <label for="mother_occupation">Mother's Occupation</label>
        <select name="mother_occupation" class="form-control">
        <option disabled selected>Select One</option>
        <option value="housewife">Housewife</option>
        <option value="accountant">Accountant</option>
        <option value="actor">Actor</option>
        <option value="architect">Architect</option>
        <option value="artist">Artist</option>
        <option value="chef">Chef</option>
        <option value="dentist">Dentist</option>
        <option value="engineer">Engineer</option>
        <option value="firefighter">Firefighter</option>
        <option value="graphic_designer">Graphic Designer</option>
        <option value="hair_stylist">Hair Stylist</option>
        <option value="journalist">Journalist</option>
        <option value="lawyer">Lawyer</option>
        <option value="mechanic">Mechanic</option>
        <option value="nurse">Nurse</option>
        <option value="pharmacist">Pharmacist</option>
        <option value="pilot">Pilot</option>
        <option value="police_officer">Police Officer</option>
        <option value="professor">Professor</option>
        <option value="software_developer">Software Developer</option>
        <option value="teacher">Teacher</option>
        <option value="veterinarian">Veterinarian</option>
         <!-- Add more options as needed -->
         </select>

       </div>
      </div>
  
      </div>
      </div>

      <!-- 1-->
      <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
      <h4 class="mt-0"><i class="fa-solid fa-truck-medical"></i> Emergency Contact </h4> <hr>
      <div class="row col-12 mt-1">
      <div class="col-sm-4 form-group">
        <label for="pass">Emergency Contact Name 1</label>
        <input type="text" name="emergency_contact_name_1" class="form-control" value="Md. Hafiz Uddain" placeholder="Emergency Contact Name" required>
      </div>

      <div class="col-sm-4 form-group">
        <label for="pass2">Emergency Contact Number 1</label>
        <input type="number" name="emergency_contact_number_1" value="01878578504" class="form-control" placeholder="Emergency Contact Number" required>
      </div>


      <div class="col-sm-4 form-group">
        <label for="pass">Emergency Contact Relation 1</label>
        <input type="text" name="emergency_contact_relationship_1" class="form-control" value="Father" placeholder="Emergency Contact Name" required>
      </div>
      </div>


      <!-- 2-->
      <div class="row col-12 mt-1">
      <div class="col-sm-4 form-group">
        <label for="pass">Emergency Contact Name 2</label>
        <input type="text" name="emergency_contact_name_2" class="form-control" value="Md. Hafiz Uddain" placeholder="Emergency Contact Name" required>
      </div>

      <div class="col-sm-4 form-group">
        <label for="pass2">Emergency Contact Number 2</label>
        <input type="number" name="emergency_contact_number_2" value="01878578504" class="form-control" placeholder="Emergency Contact Number" required>
      </div>


      <div class="col-sm-4 form-group">
        <label for="pass">Emergency Contact Relation 2</label>
        <input type="text" name="emergency_contact_relationship_2" class="form-control" value="Father" placeholder="Emergency Contact Name" required>
      </div>
      </div><hr>
      </div>

      <!-- CV upload -->
      <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
    
      <div class="row col-12"><h4><i class="fa-regular fa-file"></i> Upload Resume <span class="text-danger">*</span></h4><hr></div>
        <input type="file" accept=".doc, .docx, .pdf" name="curriculum_vita_cv" class="form-control" required>
  

      </div>
      </div>

   
    
    <div class="container">

    <!-- Child Information Form -->
    <div id="childForm" class="col-12 hidden">
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
        <h4><i class="fa-solid fa-child-combatant"></i> Child Information</h4> <hr>

   <!-- start loop -->
  <div class="row">
    <div class="col-4 form-group">
      <label for="pass">Child Name 1</label>
      <input type="text" name="child_name[]" class="form-control" placeholder="Child Name">
    </div>

    <div class="col-4 form-group">
      <label for="pass2">Gender</label>
      <select class="form-control custom-select browser-default" name="child_gender[]" >
          <option>Male</option>
          <option>Female</option>
        </select>
    </div>

    <div class="col-4 form-group">
      <label for="pass2">Child Birthday</label>
      <input type="date" name="child_birthday[]" value="{{ now()->format('Y-m-d') }}" class="form-control">
    </div>
  </div>

  
  <div id="dynamic-form-fields"></div>  </div>
  <div class="text-right"> <button type="button" class="btn-sm btn-primary mt-2" onclick="addFormFields()">Add More</button></div>
  </div>


<script>
   var Y=2;
  function addFormFields() {
    var container = document.getElementById('dynamic-form-fields');
    var newRow = document.createElement('div');
    newRow.className = 'row mt-2';
    newRow.style.background = '#fffdfa';
    newRow.style.border = '1px solid lightgray';
    newRow.style.borderRadius = '15px';
    newRow.style.padding = '15px';

    newRow.innerHTML = '<div class="col-4 form-group mt-2">' +
      '<label for="pass">Child Name ' + Y++ + '</label>' +
      '<input type="text" name="child_name[]" class="form-control" placeholder="Child Name">' +
      '</div>' +

      '<div class="col-4 form-group">' +
      '<label for="pass2">Gender</label>'+
      '<select class="form-control custom-select browser-default" name="child_gender[]" >' +
       '<option>Male</option>' +
       '<option>Female</option>' +
       '</select>' +
       '</div></div>'+

      '<div class="col-4 form-group">' +
      '<label for="pass2">Child Birthday</label>' +
      '<input type="date" name="child_birthday[]" class="form-control" value="{{ now()->format('Y-m-d') }}">' +
      '</div>' +
      '<div class="col-12 mb-2">' +
      '<button type="button" class="btn-sm btn-danger" onclick="removeFormFields(this)">Remove</button>' +
      '</div>';
    container.appendChild(newRow);
  }

  function removeFormFields(button) {
    var rowToRemove = button.parentNode.parentNode;
    rowToRemove.parentNode.removeChild(rowToRemove);
  }
</script>

</div>
   
    <!-- Professional Certificate Form -->
    <div id="certificateForm" class="col-12 hidden">
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
        <h4><i class="fa-solid fa-certificate"></i> Professional Certificate</h4> <hr>
       <div class="row">
    <div class="col-sm-3 form-group">
      <label for="certName">Certificate Name 1</label>
      <input type="text" name="cert_name[]" class="form-control" placeholder="Certificate Name">
    </div>

    <div class="col-sm-3 form-group">
      <label for="certName">Organization Name</label>
      <input type="text" name="cert_org_name[]" class="form-control" placeholder="Organization Name">
    </div>


    <div class="col-sm-3 form-group">
      <label for="certDate">Start Date</label>
      <input type="date" name="cert_start_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">
    </div>

    <div class="col-sm-3 form-group">
      <label for="certDate">End Date</label>
      <input type="date" name="cert_end_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">
    </div>
  </div> 

  <div id="dynamic-cert-fields"></div></div>

  <div class="text-right">
  <button type="button" class="btn btn-primary mt-2" onclick="addCertificateFields()">Add More Certificates</button>
  </div> 
</div>




    <!-- Job Exprience Certificate Form -->
    <div id="jobexprienceForm" class="col-12 hidden">
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
        <h4><i class="fa-solid fa-briefcase"></i> Job Exprience</h4> <hr>
       <div class="row">
    <div class="col-sm-3 form-group">
      <label for="certName">Designation 1</label>
      <input type="text" name="job_designation_name[]" class="form-control" placeholder="Designation Name">
    </div>

    <div class="col-sm-3 form-group">
      <label for="certName">Organization Name</label>
      <input type="text" name="job_org_name[]" class="form-control" placeholder="Organization Name">
    </div>


    <div class="col-sm-3 form-group">
      <label for="certDate">Start Date</label>
      <input type="date" name="job_start_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">
    </div>

    <div class="col-sm-3 form-group">
      <label for="certDate">End Date</label>
      <input type="date" name="job_end_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">
    </div>
  </div> 

  <div id="dynamic-job-fields"></div></div>
  <div class="text-right">
  <button type="button" class="btn btn-primary mt-2" onclick="addJobExprienceFields()">Add More Job Exprience</button>
  </div> 
</div>



<script>
  // Professonal Certificates
  var i = 2;
  function addCertificateFields() {
    var container = document.getElementById('dynamic-cert-fields');

    var newCertificateRow = document.createElement('div');
    newCertificateRow.className = 'row mt-2';
    newCertificateRow.style.background = '#fffdfa';
    newCertificateRow.style.border = '1px solid lightgray';
    newCertificateRow.style.borderRadius = '15px';
    newCertificateRow.style.padding = '15px';

    newCertificateRow.innerHTML = '<div class="col-sm-3 form-group">' +
      '<label for="certName">Certificate Name ' + i++ +'</label>'+
      '<input type="text" name="cert_name[]" class="form-control" placeholder="Certificate Name">' +
      '</div>' +
      '<div class="col-sm-3 form-group">' +
      '<label for="certName">Organization Name</label>' +
      '<input type="text" name="cert_org_name[]" class="form-control" placeholder="Certificate Name">' +
      '</div>' +

      '<div class="col-sm-3 form-group">' +
      '<label for="certDate">Start Date</label>' +
      '<input type="date" name="cert_start_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">' +
      '</div>' +

      '<div class="col-sm-3 form-group">' +
      '<label for="certDate">End Date</label>' +
      '<input type="date" name="cert_end_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">' +
      '</div>' +

      '<div class="col-12 mb-2">' +
      '<button type="button" class="btn btn-danger" onclick="removeCertificateFields(this)">Remove</button>' +
      '</div>';

    container.appendChild(newCertificateRow);
  }

  function removeCertificateFields(button) {
    var certificateRowToRemove = button.parentNode.parentNode;
    certificateRowToRemove.parentNode.removeChild(certificateRowToRemove);
  }

  // Job Exprience
  var M = 2;
  function addJobExprienceFields() {
    var containerOff = document.getElementById('dynamic-job-fields');

    var newJobRow = document.createElement('div');
    newJobRow.className = 'row mt-2';
    newJobRow.style.background = '#fffdfa';
    newJobRow.style.border = '1px solid lightgray';
    newJobRow.style.borderRadius = '15px';
    newJobRow.style.padding = '15px';


    newJobRow.innerHTML = '<div class="col-sm-3 form-group">' +
      '<label for="certName">Designation Name ' + M++ +'</label>'+
      '<input type="text" name="job_designation_name[]" class="form-control" placeholder="Designation Name">' +
      '</div>' +
      '<div class="col-sm-3 form-group">' +
      '<label for="certName">Organization Name</label>' +
      '<input type="text" name="job_org_name[]" class="form-control" placeholder="Organization Name">' +
      '</div>' +

      '<div class="col-sm-3 form-group">' +
      '<label for="certDate">Start Date</label>' +
      '<input type="date" name="job_start_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">' +
      '</div>' +

      '<div class="col-sm-3 form-group">' +
      '<label for="certDate">End Date</label>' +
      '<input type="date" name="job_end_date[]" value="{{ now()->format('Y-m-d') }}" class="form-control">' +
      '</div>' +

      '<div class="col-12 mb-2">' +
      '<button type="button" class="btn btn-danger" onclick="removeJobFields(this)">Remove</button>' +
      '</div>';

      containerOff.appendChild(newJobRow);
  }

  function removeJobFields(button) {
    var JobRowToRemove = button.parentNode.parentNode;
    JobRowToRemove.parentNode.removeChild(JobRowToRemove);
  }
// Job Exprience 
</script>
    </div>
  <!-- Professional Certificate end -->

    <!-- Medical History Form -->
  <div id="medicalForm" class="col-12 hidden">
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
        <h4><i class="fa-solid fa-suitcase-medical"></i> Medical History</h4> <hr>
        <div class="card p-2"> 
        <label><input type="checkbox" name="medical_history[]" value="High Blood Pressure"> High Blood Pressure</label>
        <label><input type="checkbox" name="medical_history[]" value="Diabetes"> Diabetes</label>
        <label><input type="checkbox" name="medical_history[]" value="Asthma"> Asthma</label>
        <label><input type="checkbox" name="medical_history[]" value="Heart Disease"> Heart Disease</label>
        <label><input type="checkbox" name="medical_history[]" value="Cancer"> Cancer</label>
        <label><input type="checkbox" name="medical_history[]" value="Stroke"> Stroke</label>
        <label><input type="checkbox" name="medical_history[]" value="Depression"> Depression</label>
        <label><input type="checkbox" name="medical_history[]" value="Anxiety"> Anxiety</label>
        <label><input type="checkbox" name="medical_history[]" value="Obesity"> Obesity</label>
        <label><input type="checkbox" name="medical_history[]" value="Chronic Kidney Disease"> Chronic Kidney Disease</label>
        <label><input type="checkbox" name="medical_history[]" value="Chronic Obstructive Pulmonary Disease (COPD)"> Chronic Obstructive Pulmonary Disease (COPD)</label>
        <label><input type="checkbox" name="medical_history[]" value="Rheumatoid Arthritis"> Rheumatoid Arthritis</label>
        <label><input type="checkbox" name="medical_history[]" value="Osteoporosis"> Osteoporosis</label>
        <label><input type="checkbox" name="medical_history[]" value="Anemia"> Anemia</label>
        <label><input type="checkbox" name="medical_history[]" value="Thyroid Disorders"> Thyroid Disorders</label>
        <label><input type="checkbox" name="medical_history[]" value="Gastrointestinal Disorders"> Gastrointestinal Disorders</label>
        <textarea class="form-control" name="medical_history_others" placeholder="Other Medical History All Details Input Here"></textarea>
        
        </div></div>
    </div>





    <div id="HobbiesInterestCheckForm" class="col-12 hidden">
    <div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
        <h4><i class="fa-solid fa-suitcase-medical"></i> Hobbies and interests</h4> <hr>
        <div class="card p-2"> 
        <label><input type="checkbox" name="hobbies[]" value="Reading"> Reading</label>
        <label><input type="checkbox" name="hobbies[]" value="Writing"> Writing</label>
        <label><input type="checkbox" name="hobbies[]" value="Painting"> Painting</label>
        <label><input type="checkbox" name="hobbies[]" value="Drawing"> Drawing</label>
        <label><input type="checkbox" name="hobbies[]" value="Playing Musical Instruments"> Playing Musical Instruments</label>
        <label><input type="checkbox" name="hobbies[]" value="Singing"> Singing</label>
        <label><input type="checkbox" name="hobbies[]" value="Dancing"> Dancing</label>
        <label><input type="checkbox" name="hobbies[]" value="Photography"> Photography</label>
        <label><input type="checkbox" name="hobbies[]" value="Cooking"> Cooking</label>
        <label><input type="checkbox" name="hobbies[]" value="Gardening"> Gardening</label>
        <label><input type="checkbox" name="hobbies[]" value="Traveling"> Traveling</label>
        <label><input type="checkbox" name="hobbies[]" value="Sports"> Sports</label>
        <label><input type="checkbox" name="hobbies[]" value="Gaming"> Gaming</label>
        <label><input type="checkbox" name="hobbies[]" value="Crafting"> Crafting</label>
        <label><input type="checkbox" name="hobbies[]" value="Yoga"> Yoga</label>

        <textarea class="form-control" name="hobbies_and_interest" placeholder="Other Hobbies and interests"></textarea>
      
      </div></div>
    </div>

    


<!-- Professional Certificate Form -->
<div id="socialForm" class="col-12 hidden">
<div class="container mt-2" style="background: #fffdfa;padding: 15px;border-radius: 15px;border: 1px solid lightgray;">
    <h4><i class="fa-solid fa-share-from-square"></i> Social Media Links</h4> <hr>
  
  <div class="container">

  <label for="facebook_link" class="mt-1"><i class="fa-brands fa-facebook"></i> Facebook Link</label><input type="text" name="facebook_link" class="form-control" placeholder="Facebook Link">

  <label for="twitter_link" class="mt-2"><i class="fa-brands fa-twitter"></i> Twitter Link</label><input type="text" name="twitter_link" class="form-control" placeholder="Twitter Link">

  <label for="instagram_link" class="mt-2"><i class="fa-brands fa-instagram"></i> Instagram Link</label><input type="text" name="instagram_link" class="form-control" placeholder="Instagram Link">

  <label for="linkedin_link" class="mt-2"><i class="fa-brands fa-linkedin"></i> Linkedin Link</label><input type="text" name="linkedin_link" class="form-control" placeholder="Linkedin Link">

  <label for="tiktok_link" class="mt-2"><i class="fa-brands fa-tiktok"></i> Tiktok Link</label><input type="text" name="tiktok_link" class="form-control" placeholder="Tiktok Link">

  <label for="youtube_link" class="mt-2"><i class="fa-brands fa-youtube"></i> YouTube Link</label><input type="text" name="youtube_link" class="form-control" placeholder="YouTube Link">
</div></div>
</div>


<!-- checkbox start -->
    <div class="col-sm-12 "><input type="checkbox" id="childCheckbox" class="form-check d-inline"> Child Information</div>
    <div class="col-sm-12"><input type="checkbox" id="certificateCheckbox" class="form-check d-inline"> Professional Certificate</div>
    <div class="col-sm-12"><input type="checkbox" id="jobexprienceCheckbox" class="form-check d-inline"> Job Exprience</div>
    <div class="col-sm-12"><input type="checkbox" id="medicalCheckbox" class="form-check d-inline"> Medical History Form</div>
    <div class="col-sm-12"><input type="checkbox" id="HobbiesInterestCheckbox" class="form-check d-inline"> Hobbies and interests</div>
    <div class="col-sm-12"><input type="checkbox" id="socialMediaCheckbox" class="form-check d-inline"> Social Media Link</div>

    
    <div class="col-sm-12">
        <input type="checkbox" class="form-check d-inline" id="chb" required>
        <label for="chb" class="form-check-label">&nbsp;I accept all terms and conditions.</label>
     </div>


    <script>
        function toggleFormVisibility(checkboxId, formId) {
            var checkbox = document.getElementById(checkboxId);
            var form = document.getElementById(formId);
            checkbox.addEventListener('change', function() {
                form.classList.toggle('hidden', !checkbox.checked);
            });
        }
        toggleFormVisibility('childCheckbox', 'childForm');
        toggleFormVisibility('certificateCheckbox', 'certificateForm');
        toggleFormVisibility('jobexprienceCheckbox', 'jobexprienceForm');
        toggleFormVisibility('medicalCheckbox', 'medicalForm');
        toggleFormVisibility('HobbiesInterestCheckbox', 'HobbiesInterestCheckForm');
        toggleFormVisibility('socialMediaCheckbox', 'socialForm');
        
    </script>


   <div class="col-sm-12 form-group mb-0">
        <input type="submit" value="Submit" class="btn btn-primary float-right"></input>
    </div>

    </div>
  </form>

  
</div>
<!-- form code end -->

     
</div>
</section>




<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('create_users_form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(form);

        fetch('{{ route("admin-users-store") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                // Handle validation error response
                if (response.status === 422) {
                    return response.json().then(data => {
                        throw { validationErrors: data.error };
                    });
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                // Display the success message from the response
                var successMessage = data.message; // Assuming 'message' key contains success message
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(successMessage);
                
                // Optionally, redirect to a different page after a delay
                setTimeout(function () {
                window.location.href = "{{ route('users_home') }}";
                }, 5000);

            }
        })
        .catch(error => {
            if (error.validationErrors) {
                // Display validation errors
                for (var field in error.validationErrors) {
                    if (error.validationErrors.hasOwnProperty(field)) {
                        var errorMessage = error.validationErrors[field][0];
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error(`${field}: ${errorMessage}`);
                    }
                }
            } else {
                console.error('Error:', error);
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Something went wrong! Please try again later.');
            }
        });
    });
});

</script>


<!-- include the script -->
<script src="{{ url('/dist/alertify.min.js') }}"></script>

@endsection