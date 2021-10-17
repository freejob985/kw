<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'ar') dir="rtl" @else dir="ltr"  @endif>
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
        @php
        $title = 'kuwait965.com';
        @endphp
		<title>{{$title}}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet"> 
		<!--end::Web font -->
        <!--begin::Base Styles -->  
        <!--begin::Page Vendors -->
		<link href="{{asset('admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->
		<link href="{{asset('admin_assets/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('admin_assets/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('admin_assets/custom.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="{{asset('admin_assets/assets/demo/default/media/img/logo/favicon.ico')}}" />
        <style type="text/css">
          #map{ width:700px; height: 500px; }
        </style>
	</head>
	<!-- end::Head -->