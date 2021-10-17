@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.sliders')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
										<div class="m-portlet__body">
		                                   {{csrf_field()}}
		                 @if($errors->any())
    <div class="alert alert-danger danger-errors">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
            @endforeach
    </div>
    @endif
    @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
											<div class="row" id="gallerybox">
                                                @foreach($sliders as $image)
                                            <div class="col-lg-4 col-md-9 col-sm-12" style="margin: 10px 0;">
											<div class="gallery" style="background-image:url({{asset('uploads/sliders/'.$image->image)}});background-position: center top;background-size: cover;">
											<div class="remove_overlay" action="{{route('sliders_image_remove',['id' => $image->id])}}">
                                                <div class="removeBtn_box">
                                                   <i class="fa fa-times-circle"></i>
                                                    <p>{{__('admin.deleteImage')}}</p>
                                                    </div>
                                                </div>
                                                </div>
										</div>
                                            @endforeach 
                                                     <div class="col-lg-4 col-md-9 col-sm-12 image_uploader_option" style="margin: 10px 0;">
                                                          <input hidden="hidden" class="uploaded_image" id="gallery_image" type="file">
											<div class="dropzone_gallery" >
												<div class="addimagebutton_on_gallery">
                                                   
                                                    <i class="fa fa-plus"></i>
                                                    <p>{{__('admin.addImage')}}</p>
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
$(".dropzone_gallery").click(function(){
    $(".uploaded_image").click();
});
    
    $('.uploaded_image').change(function (){
         var imageFile = document.getElementById('gallery_image');
         var reader = new FileReader();
         var time = new Date().getTime();
    reader.onload = function(e) {
        $('.image_uploader_option').before('<div class="col-lg-4 col-md-9 col-sm-12" style="margin: 10px 0;"><div class="gallery '+time+'" style="background-image:url('+e.target.result+');background-position: center top;background-size: cover;"> <div class="upload_overlay"><span class="progress_upload_gallery">0 %</span></div></div></div>');
    }
    
        reader.readAsDataURL(imageFile.files[0]);
        var fd=new FormData();
        fd.append("image",imageFile.files[0]);
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $.ajax({
                    type: 'POST',
                    url: "{!! route('sliders_upload') !!}",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data:fd,
                    success: function(e) {
                        if(e.status == 'success'){
                           var deleted = '<div class="remove_overlay" action="'+'{!! url("/sliders/remove") !!}' +'/'+e.image+'"><div class="removeBtn_box"><i class="fa fa-times-circle"></i><p>'+'{!! __('admin.deleteImage') !!}'+'</p></div></div>';
                           $('.'+time+' .upload_overlay').remove();
                            $('.'+time).html(deleted);
                        }
                        if(e.status == 'error'){
                       
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    },
                    progress: function(e) {
                        if(e.lengthComputable) {
                            var pct = (e.loaded / e.total) * 100;
                            $('.'+time+' .upload_overlay .progress_upload_gallery').html(pct + ' %');
                           
                        } else {
                            console.warn('Content Length not reported!');
                        }
                    }
                });
    });
        $('.remove_overlay').on('click',function(){
            var action = $(this).attr('action');
            var thisme = $(this);
                   $.ajax({
                    type: 'POST',
                    url: action,
                    dataType: 'json',
                    success: function(e) {
                        if(e.status == 'success'){
                          $(thisme).parent().parent().remove();
                        }
                        if(e.status == 'error'){
                       
                        }
                    },
                    error: function(e) {
                        console.log(e);
        }
                });
    });
</script>
@endsection