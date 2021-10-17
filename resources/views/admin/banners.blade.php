@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.banners')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
										<div class="m-portlet__body">
                                            
											<div class="row" id="gallerybox">
                                            @php
                                                $right_banner = \App\banners::find(1);
                                                $left_banner = \App\banners::find(2);
                                                @endphp
                                            <div class="col-lg-4 col-md-9 col-sm-12" style="margin: 10px 0;">
											<div class="gallery right_banner_image" style="@if($right_banner) background-image:url({{asset('uploads/banners/'.$right_banner->image)}}); @endif background-position: center top;background-size: cover;">
                                                <div class="upload_overlay progress_right_banner" style="display:none"><span class="progress_upload_gallery">0 %</span></div>
											<div class="remove_overlay">
                                                <input type="file" id="right_banner" hidden="hidden">
                                                <div class="removeBtn_box uploaded_image_right">
                                                   <i class="fa fa-times-circle"></i>
                                                    <p>{{__('admin.editImage')}}</p>
                                                    </div>
                                                </div>
                                                </div>
										</div>
                                                    <div class="col-lg-4 col-md-9 col-sm-12" style="margin: 10px 0;">
											<div class="gallery" style="@if($left_banner) background-image:url({{asset('uploads/banners/'.$left_banner->image)}}); @endif background-position: center top;background-size: cover;">
                                                 <div class="upload_overlay progress_left_banner" style="display:none"><span class="progress_upload_gallery">0 %</span></div>
											<div class="remove_overlay ">
                                                 <input type="file" id="left_banner" hidden="hidden">
                                                <div class="removeBtn_box uploaded_image_left">
                                                   <i class="fa fa-times-circle"></i>
                                                    <p>{{__('admin.editImage')}}</p>
                                                    </div>
                                                </div>
                                                </div>
										</div>
                                            
                                            </div>
							
										</div>

									
							</div>
						</div>
					</div>
@endsection
@section('footer')
 <script src="{{asset('/js/jquery.ajax-progress.js')}}" type="text/javascript"></script>
<script>
$(".uploaded_image_right").click(function(){
    $("#right_banner").click();
});
    $(".uploaded_image_left").click(function(){
    $("#left_banner").click();
});
    
    $('#right_banner').change(function (){
         var imageFile = document.getElementById('right_banner');
         var reader = new FileReader();
         var time = new Date().getTime();
    reader.onload = function(e) {
      $('.right_banner_image').css('background-image','url('+e.target.result+')');
    }
    
        reader.readAsDataURL(imageFile.files[0]);
        var fd=new FormData();
        fd.append("image",imageFile.files[0]);
        fd.append("banner",1);
        $('.progress_right_banner').show();
        $('.uploaded_image_right').hide();
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $.ajax({
                    type: 'POST',
                    url: "{!! route('banner_upload') !!}",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data:fd,
                    success: function(e) {
                        if(e.status == 'success'){
                           $('.progress_right_banner').hide();
                            $('.uploaded_image_right').show();
                        }
                        if(e.status == 'error'){
                       
                        }
                    },
                    error: function(e) {
                        console.log(e);
                        $('.uploaded_image_right').show();
                    },
                    progress: function(e) {
                        if(e.lengthComputable) {
                            var pct = (e.loaded / e.total) * 100;
                            $('.progress_right_banner .progress_upload_gallery').html(pct + ' %');
                           
                           
                        } else {
                            console.warn('Content Length not reported!');
                        }
                    }
                });
    });
        $('#left_banner').change(function (){
         var imageFile = document.getElementById('left_banner');
         var reader = new FileReader();
         var time = new Date().getTime();
    reader.onload = function(e) {
      $('.left_banner_image').css('background-image','url('+e.target.result+')');
    }
    
        reader.readAsDataURL(imageFile.files[0]);
        var fd=new FormData();
        fd.append("image",imageFile.files[0]);
        fd.append("banner",2);
        $('.progress_left_banner').show();
        $('.uploaded_image_left').hide();
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $.ajax({
                    type: 'POST',
                    url: "{!! route('banner_upload') !!}",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data:fd,
                    success: function(e) {
                        if(e.status == 'success'){
                           $('.progress_left_banner').hide();
                           $('.uploaded_image_left').show();
                        }
                        if(e.status == 'error'){
                       $('.uploaded_image_left').show();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                        $('.uploaded_image_left').show();
                    },
                    progress: function(e) {
                        if(e.lengthComputable) {
                            var pct = (e.loaded / e.total) * 100;
                            $('.progress_left_banner .progress_upload_gallery').html(pct + ' %');
                           
                           
                        } else {
                            console.warn('Content Length not reported!');
                        }
                    }
                });
    });
</script>
@endsection