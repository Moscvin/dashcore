<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="{{ asset('js/core/libraries/jQuery.min.js') }}" ></script>
<script src="{{ asset('js/core/libraries/jQuery.slimscroll.min.js') }}" ></script>
<script src="{{ asset('js/core/libraries/adminlte.min.js') }}" ></script>
<!-- <script src="{{ asset('js/core/libraries/popper.min.js') }}"></script> -->
<!-- <script src="{{ asset('js/core/libraries/bootstrap.min.js') }}" ></script> -->
<script src="{{ asset('js/core/libraries/bootstrap.bundle.min.js') }}" ></script>
<script src="{{ asset('js/core/libraries/datatables.min.js') }}" ></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="/js/core/libraries/select2.min.js"></script>
<script src="/js/core/libraries/select2.language.js"></script>

<script>
    $(function() {
        let url = window.location.pathname;
        let url1 = url.replace('_add','').replace('_view','').split( '/' );
        let url2 = url1[1];
        $("ul.sidebar-menu li a[href*='"+url2+"']").parents().addClass('active');
        $(".sidebar a").on("click", function(){
            document.location.href = this.href;
        });
        $(".drop_flex-user").on("click", function(){
            var mouse_is_inside = null;
            $(".dropdown-menu").addClass("block");
            $(this).hover(function(){
                mouse_is_inside=true;
            }, function(){
                mouse_is_inside=false;
            });

            $("body").mouseup(function(){
                if(! mouse_is_inside) $('.dropdown-menu').removeClass('block');
            });
        });
    });
</script>