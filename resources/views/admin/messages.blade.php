@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.messages.history')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<!--begin: Search Form -->
								<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
									<div class="row align-items-center">
										<div class="col-xl-8 order-2 order-xl-1">
											<div class="form-group m-form__group row align-items-center">
												
												<div class="col-md-4">
													<div class="m-input-icon m-input-icon--left">
														<input type="text" class="form-control m-input m-input--solid" placeholder="{{__('admin.searchTxt')}}" id="generalSearch">
														<span class="m-input-icon__icon m-input-icon__icon--left">
															<span>
																<i class="la la-search"></i>
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								<!--end: Search Form -->
		<!--begin: Datatable -->
										<table class="m-datatable" id="html_table" width="100%">
									<thead>
										<tr>
											<th title="Field #1">
												#
											</th>
											<th title="Field #2">
												{{__('admin.messages.message')}}
											</th>
											<th title="Field #3">
												{{__('admin.messages.room')}}
											</th>
                                            	<th title="Field #4">
												{{__('admin.messages.user')}}
											</th>
												<th title="Field #4">
												ip
											</th>
											<th title="Field #4">
											{{__('admin.messages.datetime')}}
											</th>
											
										</tr>
									</thead>
									<tbody>
                                        @foreach($messages as $message)
										<tr>
											<td>
								                {{$message->id}}
											</td>
											<td>
								                {{$message->body}}
											</td>
											<td>
								                {{$message->room->name}}
											</td>
											<td>
								                {{$message->user->name}}
											</td>
												<td>
								                {{$message->ip}}
											</td>
											<td>
								                {{\Carbon\Carbon::parse($message->created_at)->format('Y-m-d h:i a')}}
											</td>
											
										</tr>
									@endforeach

									</tbody>
								</table>
								<!--end: Datatable -->
							</div>
						</div>
					</div>
@endsection