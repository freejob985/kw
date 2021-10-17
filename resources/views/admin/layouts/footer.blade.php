<!-- begin::Footer -->
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright" style="text-align:center;display: block;">
								2020 &copy; kuwait965.com
							</span>
						</div>
						
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
		</div>
		<!-- end:: Page -->    
	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- begin::Quick Nav -->	
    	<!--begin::Base Scripts -->
		<script src="{{asset('admin_assets/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('admin_assets/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
		<script src="{{asset('admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
		<!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
		<script src="{{asset('admin_assets/assets/demo/default/custom/components/datatables/base/html-table.js')}}" type="text/javascript"></script>
		<script type="text/javascript">
	//== Class definition

var SummernoteDemo = function () {    
    //== Private functions
    var demos = function () {
        $('.summernote').summernote({
            height: 150, 
        });
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

//== Initialization
jQuery(document).ready(function() {
    SummernoteDemo.init();
});
	</script>


       <script>
            $('#event_date').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
                autoclose: true,
                format: 'dd-mm-yyyy',
                startDate : '+1d'
        });
           $('.summernote').summernote({
            height: 150, 
               fontNames: ['Cairo']
        });
     
     
            $('#start_event_time, #end_event_time').timepicker().val('');
            $('#start_event_time_edit, #end_event_time_edit').timepicker();
               $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
           
</script>
		<!--end::Page Snippets -->
@yield('footer')
	</body>
	<!-- end::Body -->
</html>
