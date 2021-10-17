@extends('admin.index')
@section('content')
  <div class="m-content">
						<!--begin:: Widgets/Stats-->
						<div class="m-portlet ">
							<div class="m-portlet__body  m-portlet__body--no-padding">
								<div class="row m-row--no-padding m-row--col-separator-xl">
									<div class="col-md-12 col-lg-6 col-xl-3">
										<!--begin::Total Profit-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
												
												</h4>
												<br>
				
												<span class="m-widget24__stats m--font-brand">
													هذا النص وهمي
												</span>
												<div class="m--space-10"></div>
                                               
												<div class="progress m-progress--sm">
													<div class="progress-bar m--bg-brand" role="progressbar" style="width: %;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												
												<span class="m-widget24__number">
													%
												</span>
											</div>
										</div>
										<!--end::Total Profit-->
									</div>
									<div class="col-md-12 col-lg-6 col-xl-3">
										<!--begin::New Feedbacks-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
													هذا النص وهمي
												</h4>
												<br>
											
												<span class="m-widget24__stats m--font-info">
													rr
												</span>
												<div class="m--space-10"></div>
												<div class="progress m-progress--sm">
													<div class="progress-bar m--bg-info" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<span class="m-widget24__change">
													Change
												</span>
												<span class="m-widget24__number">
													84%
												</span>
											</div>
										</div>
										<!--end::New Feedbacks-->
									</div>
									<div class="col-md-12 col-lg-6 col-xl-3">
										<!--begin::New Orders-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
													هذا النص وهمي
												</h4>
												<br>
												<span class="m-widget24__stats m--font-danger">
													هذا النص وهمي
												</span>
												<div class="m--space-10"></div>
                                            
												<div class="progress m-progress--sm">
													<div class="progress-bar m--bg-danger" role="progressbar" style="width: %;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<span class="m-widget24__number">
													%
												</span>
											</div>
										</div>
										<!--end::New Orders-->
									</div>
									<div class="col-md-12 col-lg-6 col-xl-3">
										<!--begin::New Users-->
										<div class="m-widget24">
											<div class="m-widget24__item">
												<h4 class="m-widget24__title">
												هذا النص وهمي
												</h4>
												<br>
                                              
												<div class="m--space-10"></div>
												<span class="m-widget24__stats m--font-success">
													هذا النص وهمي
												</span>
												<div class="m--space-10"></div>
													<div class="progress m-progress--sm">
													<div class="progress-bar m--bg-danger" role="progressbar" style="width: %;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<span class="m-widget24__number">
													%
												</span>
											</div>
										</div>
										<!--end::New Users-->
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Stats--> 
<!--Begin::Main Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__body m-portlet__body--no-padding">
								<div class="row m-row--no-padding m-row--col-separator-xl">
									<div class="col-md-12 col-lg-12 col-xl-4">
										<!--begin:: Widgets/Stats2-1 -->
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Member Profit
														</h3>
														<span class="m-widget1__desc">
															Awerage Weekly Profit
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-brand">
															+$17,800
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Orders
														</h3>
														<span class="m-widget1__desc">
															Weekly Customer Orders
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-danger">
															+1,800
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Issue Reports
														</h3>
														<span class="m-widget1__desc">
															System bugs and issues
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-success">
															-27,49%
														</span>
													</div>
												</div>
											</div>
										</div>
										<!--end:: Widgets/Stats2-1 -->
									</div>
									<div class="col-md-12 col-lg-12 col-xl-4">
										<!--begin:: Widgets/Stats2-2 -->
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															IPO Margin
														</h3>
														<span class="m-widget1__desc">
															Awerage IPO Margin
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-accent">
															+24%
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Payments
														</h3>
														<span class="m-widget1__desc">
															Yearly Expenses
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-info">
															+$560,800
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Logistics
														</h3>
														<span class="m-widget1__desc">
															Overall Regional Logistics
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-warning">
															-10%
														</span>
													</div>
												</div>
											</div>
										</div>
										<!--begin:: Widgets/Stats2-2 -->
									</div>
									<div class="col-md-12 col-lg-12 col-xl-4">
										<!--begin:: Widgets/Stats2-3 -->
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Orders
														</h3>
														<span class="m-widget1__desc">
															Awerage Weekly Orders
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-success">
															+15%
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Transactions
														</h3>
														<span class="m-widget1__desc">
															Daily Transaction Increase
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-danger">
															+80%
														</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">
															Revenue
														</h3>
														<span class="m-widget1__desc">
															Overall Revenue Increase
														</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-primary">
															+60%
														</span>
													</div>
												</div>
											</div>
										</div>
										<!--begin:: Widgets/Stats2-3 -->
									</div>
								</div>
							</div>
						</div>
						<!--End::Main Portlet-->


					</div>
@endsection