@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.addPlan')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('plans.insert')}}">
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
                                            <div class="row addNewRowContainer">
											<div class="col-lg-12">
												<label for="name">
													{{__('admin.plan name')}}
												</label>
												<input type="text" class="form-control m-input" id="name" name="name">
											
											</div>
                                            	<div class="col-lg-12">
												<label for="mobile">
													{{__('admin.plan price')}}
												</label>
												<input type="number" class="form-control m-input" id="price" step=".01" name="price">
											</div>
                                            	<div class="col-lg-12">
												<label for="mobile">
													{{__('admin.plan join number')}}
												</label>
												<input type="number" class="form-control m-input" id="joinnumber" name="joinnumber">
											</div>
                                            <div class="col-lg-12">
                                            	<label for="birth">
													{{__('admin.plan block days')}}
												</label>
                                            </div>
                                            <div class="col-lg-12">
											
												<input type="number" class="form-control m-input" id="block" name="blockdays[]" >
											</div>
                                                </div>
                                            <div>
                                           <button type="button" id="newRow" class="btn m-btn--pill    btn-primary" style="float:left;margin: 15px 0px;">
															{{__('admin.addNewRow')}}
														</button>
                                                <div style="clear:both"></div>
                                            </div>
                                           
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">
													{{__('admin.save')}}
												</button>
												<button type="reset" class="btn btn-secondary">
													{{__('admin.cancel')}}
												</button>
											</div>
										</div>
									</form>
							</div>
						</div>
					</div>
@endsection
@section('footer')
<script>
$('#newRow').click(function (){
   $('.addNewRowContainer').append(' <div class="col-lg-12"><input type="number" class="form-control m-input" id="block" name="blockdays[]" ></div>'); 
});
</script>
@endsection