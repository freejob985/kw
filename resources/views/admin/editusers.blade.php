@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.editUser')}} - {{$user->name}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('users.update',$user->id)}}">
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
											<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.user name')}}
												</label>
												<input type="text" class="form-control m-input" id="name" name="name" value="{{$user->name}}">
											
											</div>
                                            	<div class="form-group m-form__group">
												<label for="mobile">
													{{__('admin.user email')}}
												</label>
												<input type="email" class="form-control m-input" id="email" name="email" value="{{$user->email}}">
											</div>
                                            	<div class="form-group m-form__group">
												<label for="mobile">
													{{__('admin.user mobile')}}
												</label>
												<input type="text" class="form-control m-input" id="mobile" name="mobile" value="{{$user->mobile}}">
											</div>
                                            <div class="form-group m-form__group">
												<label for="birth">
													{{__('admin.user birth')}}
												</label>
												<input type="date" class="form-control m-input" id="birth" name="birth" value="{{$user->birth}}">
											</div>
                                              <div class="form-group m-form__group">
												<label for="birth">
													{{__('admin.user gender')}}
												</label>
                                                  <select class="form-control m-input" id="gender" name="gender">
                                                  <option value="1" @if($user->gender == 1) selected @endif>{{__('admin.boy')}}</option>
                                                  <option value="2" @if($user->gender == 2) selected @endif>{{__('admin.girl')}}</option>
                                                  </select>
											</div>
											<div class="form-group m-form__group">
												<label for="password">
													{{__('admin.user password update')}}
												</label>
												<input type="password" class="form-control m-input" id="password" name="password">
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