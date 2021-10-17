<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/assets/intl-tel-input-17.0.0/build/css/intlTelInput.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/css.css')}}">
</head>
<body style="font-family: cairo">

	<main class="container-fluid rtl text-right">
		
		<div class="row mb-5">
			<div class="col-12 px-0">
				<!-- Slider -->
				<div id="carouselExampleControls" class="carousel slide w-100 mb-5" data-ride="carousel">
				  <div class="carousel-inner">
				   @php
                      $sliders = \App\sliders::all();
                      @endphp
                      @foreach($sliders as $slider)
                      @if($loop->first)
                              <div class="carousel-item active">
                              <img class="d-block w-100 mw-100" src="{{asset('/uploads/sliders/'.$slider->image)}}">
                            </div>
                      @else
                       <div class="carousel-item">
                              <img class="d-block w-100 mw-100" src="{{asset('/uploads/sliders/'.$slider->image)}}">
                            </div>
                      @endif
                      @endforeach
				
				  </div>
	
				</div>
			</div>
		</div>
		<div class="container h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-10 d-flex flex-column justify-content-center align-items-center">
					<!-- Forms -->
					<div id="customForm" class="customForm w-100 row mx-0 px-5 pt-5 py-4 mb-5">
<div class="tab-content col-md-7">
     <div class="tab-pane active" id="form1" role="tabpanel" aria-labelledby="settings-tab">
     <form class="p-4" id="user_guest_form"  action="{{route('register.guest')}}"  method="post">
                @if ($errors->guestsignup != null && count($errors->guestsignup) > 0)
        <div class="alert alert-danger" style="margin-top: 20px;">
            <ul>
                @foreach ($errors->guestsignup->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{csrf_field()}}
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">الاسم</label>
								<div class="col-lg-8 px-0">
									<input type="text" class="w-100" name="name">
								</div>
							</div>
         	<div class="form-group row mx-0">
								<label class="col-lg-4 px-0"> النوع</label>
								<div class="col-lg-8 px-0">
									<select class="w-100" name="gender">
										<option value="1">ذكر</option>
                                        <option value="2">انثى</option>
										
									</select>
								</div>
							</div>
              <div class="form-group mb-6">
                        <a data-toggle="modal" href="#" data-target="#terms_conditions">الشروط والقوانين</a>
                        <br>
                        <label><input id="TermsCB" type="checkbox" class="checkbox-inline" name="terms"> قرأت وأوافق على الشروط والقوانين</label>
                                 
                </div>
							<div class="form-group row mx-0">
								<input type="submit" class="" value=" دخول كزائر" name="">
							</div>
						</form>
    </div>
  <div class="tab-pane" id="form2" role="tabpanel" aria-labelledby="home-tab">
    <form class="p-4"   action="{{route('login')}}"  method="post">
               @if ($errors->login != null && count($errors->login) > 0)
        <div class="alert alert-danger" style="margin-top: 20px;">
            <ul>
                @foreach ($errors->login->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 {{csrf_field()}}
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">رقم الهاتف</label>
								<div class="col-lg-8 px-0">
									<input type="text" class="w-100" name="email">
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">كلمة المرور</label>
								<div class="col-lg-8 px-0">
									<input type="password" class="w-100" name="password">
								</div>
							</div>
							<div class="form-group row mx-0 align-items-center">
								<span class="mx-1"></span>
								<a href="">نسيت كلمة المرور ؟</a>
							</div>
							<div class="form-group row mx-0">
								<input type="submit" class="" value=" دخول " name="">
							</div>
						</form>
    </div>
    <div class="tab-pane" id="form3" role="tabpanel" aria-labelledby="home-tab">
      <form class="p-4" action="{{route('register')}}"  method="post">
          @if ($errors->signup != null && count($errors->signup) > 0)
        <div class="alert alert-danger" style="margin-top: 20px;">
            <ul>
                @foreach ($errors->signup->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  {{csrf_field()}}
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">الاسم</label>
								<div class="col-lg-8 px-0">
									<input type="text" class="w-100" name="name">
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">رقم الهاتف</label>	
								<div class="col-lg-8 px-0" dir="ltr">
									<div class="">
										<input type="tel" class="w-100" name="phone" id="phone">
									</div>
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">البريد الالكتروني</label>
								<div class="col-lg-8 px-0">
									<input type="email" class="w-100" name="email">
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">كلمة المرور</label>
								<div class="col-lg-8 px-0">
									<input type="password" class="w-100" name="password">
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0">تأكيد كلمة المرور</label>
								<div class="col-lg-8 px-0">
									<input type="password" class="w-100" name="verify_password">
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0"> النوع</label>
								<div class="col-lg-8 px-0">
									<select class="w-100" name="gender">
										<option value="1">ذكر</option>
                                        <option value="2">انثى</option>
										
									</select>
								</div>
							</div>
							<div class="form-group row mx-0">
								<label class="col-lg-4 px-0"> تاريخ الميلاد</label>
								<div class="col-lg-12 row mx-0 px-0">
									<div class="form-group col-lg-4">
										 <select  class="form-control" name="day" required>
                        <option  >اليوم</option>
                      @for($i=1;$i<=31;$i++)
                                             <option  value="{{$i}}">{{$i}}</option>
                                           @endfor
                    </select>
									</div>
									<div class="form-group col-lg-4">
										 <select  required class="form-control" name="month">
                             <option  >الشهر</option>
                      @for($i=1;$i<=12;$i++)
                                             <option  value="{{$i}}">{{$i}}</option>
                                           @endfor                   </select>
									</div>
									<div class="form-group col-lg-4">
										<select required  class="form-control" name="year">
                    
                            <option  >السنة</option>
                      @for($i=\Carbon\Carbon::now()->year - 12;$i>=1900;$i--)
                                             <option  value="{{$i}}">{{$i}}</option>
                                           @endfor                   </select>
									</div>
								</div>
							</div>
              <div class="form-group mb-6">
                        <a data-toggle="modal" href="#" data-target="#terms_conditions">الشروط والقوانين</a>
                        <br>
                        <label><input id="TermsCB" type="checkbox" class="checkbox-inline" name="terms"> قرأت وأوافق على الشروط والقوانين</label>
                                 
                </div>
							<div class="form-group row mx-0">
								<input type="submit" class="" value=" تسجيل عضو " name="">
							</div>
						</form>
    </div>
</div>
                        
           
                        
       		<ul class="nav nav-tabs col-md-5 d-flex flex-column" id="myTab" role="tablist">
  <li class="nav-item form-group">
    <a class="nav-link active custom-btn" data-toggle="tab" href="#form1" role="tab" aria-controls="home" aria-selected="true">دخول  الزائر</a>
  </li>
  <li class="nav-item form-group">
    <a class="nav-link custom-btn" data-toggle="tab" href="#form2" role="tab" aria-controls="profile" aria-selected="false">دخول الأعضاء</a>
  </li>
  <li class="nav-item form-group">
    <a class="nav-link custom-btn" data-toggle="tab" href="#form3" role="tab" aria-controls="messages" aria-selected="false">مستخدم جديد</a>
  </li>
</ul>                 



					
					</div>

					<!-- Eshtrakat -->
					<div class="w-100 px-1 d-flex justify-content-center">
						<a href="#" class="btn custom-btn" data-toggle="modal" data-target="#subscribtions">الاشتراكات</a>
						<div class="modal" id="subscribtions" tabindex="-1" role="dialog" aria-labelledby="subscribtions" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="flex-direction: row-reverse;">
        <h5 class="modal-title" id="exampleModalLongTitle">الأشتراكات</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       
      <div class="modal-body" style="">
       
            <div style="width:50%;float:left;text-align:center">
            <a class="btn btn-danger" style="width:50%;margin-bottom:10px;color:white" >الاحمر</a>
            <h5>
                امكانية طرد مؤقت لمده يوم كامل
             </h5>
             <h5>
                امكانيه انشاء غرفه واحده عامه أو مغلقه
             </h5>
            </div>
            <div style="width:50%;float:left;text-align:center">
            <a  class="btn btn-primary" style="width:50%;margin-bottom:10px;color:white">الازرق</a>
            <h5>
         امكانية طرد مؤقت لمده يوم  أو أسبوع
             </h5>
             <h5>
                امكانيه انشاء غرفتين  عامتين أو مغلقتين مع امكانيه الاسماء او الارقام السريه
             </h5>
            </div>

            <div style="text-align:center">
                <img src="{{asset('images/mastercard.png')}}" style="width:20%;">
                <img src="{{asset('images/visa.png')}}" style="width:20%;">
                <img src="{{asset('images/express.png')}}" style="width:20%;">
            </div>
      </div>
       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
					</div>
				</div>
			</div>
		</div>
	</main>
  <div class="modal" id="terms_conditions" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{__('admin.terms_conditions')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 300px;overflow-y: scroll;">
      {!! \App\main_settings::find(1)->terms !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{asset('login_page/assets/intl-tel-input-17.0.0/build/js/intlTelInput.js')}}"></script>

	   <script>
     var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
       geoIpLookup: function(callback) {
         $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
           var countryCode = (resp && resp.country) ? resp.country : "";
           callback(countryCode);
         });
       },
       hiddenInput: "full_number",
       initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
       nationalMode: true,
       onlyCountries: ['kw','bh','qa','sa','ae','om','eg'],
      // placeholderNumberType: "MOBILE",
      // preferredCountries: ['cn', 'jp'],
       //separateDialCode: false,
      utilsScript: "build/js/utils.js",
    });
        
    </script>
 @if($errors->signup != null && count($errors->signup) >0)
                <script>
                 $('a').removeClass('active');
                 $('.tab-pane').removeClass('active');
                 $('a[href="#form3"]').addClass('active');
                 $('.tab-pane#form3').addClass('active');
                </script>
                @endif
 @if($errors->login != null && count($errors->login) >0)
                <script>
                 $('a').removeClass('active');
                 $('.tab-pane').removeClass('active');
                 $('a[href="#form2"]').addClass('active');
                 $('.tab-pane#form2').addClass('active');
                </script>
                @endif
 @if($errors->guestsignup != null && count($errors->guestsignup) >0)
                <script>
                 $('a').removeClass('active');
                 $('.tab-pane').removeClass('active');
                 $('a[href="#form1"]').addClass('active');
                 $('.tab-pane#form1').addClass('active');
                </script>
                @endif

</body>
</html>