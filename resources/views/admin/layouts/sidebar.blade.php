	<!-- BEGIN: Aside Menu -->
	<div 
		id="m_ver_menu" 
		class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " 
		data-menu-vertical="true"
		 data-menu-scrollable="false" data-menu-dropdown-timeout="500"  
		>
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
				
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									{{__('admin.Components')}}
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>
                            	<li class="m-menu__item  m-menu__item--submenu   @if(\Request::route()->getName() == 'admin.sliders') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.sliders')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.sliders')}}
									</span>
								
								</a>
								
							</li>
                            	<li class="m-menu__item  m-menu__item--submenu   @if(\Request::route()->getName() == 'admin.banners') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.banners')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.banners')}}
									</span>
								
								</a>
								
							</li>
							<li class="m-menu__item  m-menu__item--submenu   @if(\Request::route()->getName() == 'admin.get_chat_history') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.get_chat_history')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.messages.history')}}
									</span>
								
								</a>
								
							</li>
							<li class="m-menu__item  m-menu__item--submenu  @if(\Request::route()->getName() == 'users') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.users')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item  m-menu__item--active " aria-haspopup="true" >
											<a  href="{{route('users')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.users')}}
												</span>
											</a>
										</li>
                                      
								
									</ul>
								</div>
							</li>
							<li class="m-menu__item  m-menu__item--submenu  @if(\Request::route()->getName() == 'monitors') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.monitors')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.monitors')}}
									</span>
									
								</a>
							
							</li>
                            		<li class="m-menu__item  m-menu__item--submenu   @if(\Request::route()->getName() == 'plans') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.plans')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item   @if(\Request::route()->getName() == 'plans') m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('plans')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.plans')}}
												</span>
											</a>
										</li>
                                      
								
									</ul>
								</div>
							</li>
                            		<li class="m-menu__item  m-menu__item--submenu  @if(\Request::route()->getName() == 'bad.words') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.badwords')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item  @if(\Request::route()->getName() == 'bad.words')  m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('bad.words')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.badwords')}}
												</span>
											</a>
										</li>
                                      
								
									</ul>
								</div>
							</li>
							<li class="m-menu__item  m-menu__item--submenu  @if(\Request::route()->getName() == 'admin.getMusicChannels') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.getMusicChannels')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.music_channels')}}
									</span>
									
								</a>
								
							</li>
							<li class="m-menu__item  m-menu__item--submenu  @if(\Request::route()->getName() == 'admin.terms') m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{route('admin.terms')}}" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.terms_conditions')}}
									</span>
									
								</a>
								
							</li>
                        	
			</ul>
					</div>
					<!-- END: Aside Menu -->