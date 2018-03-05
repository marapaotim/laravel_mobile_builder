<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php /*<link rel="shortcut icon" href="img/favicon.png"> */ ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Serino Mobile Application Builder') }}</title>

    <!-- Icons -->
    <link href="{{ url('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/simple-line-icons.css') }}" rel="stylesheet">
    @if(Request::segment(1) != 'basicbuilder') 
        <link href="{{ url('assets/bower_components/notify-master/css/prettify.css') }}" rel="stylesheet">
    @endif

    @if(Request::segment(1) == 'basicbuilder') 
    <link rel="stylesheet" type="text/css" href="{{ url('/converter/addon/dialog/dialog.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/bower_components/jquery-ui/jquery-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/basicbuilder.css') }}" /> 
    @endif 
    <link href="{{ url('assets/bower_components/notify-master/css/notify.css') }}" rel="stylesheet">
    <link href="{{ url('assets/bower_components/animate/animate.css') }}" rel="stylesheet">
	
	<link href="{{ url('assets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">

    @yield('styles')

</head>

<body class="app header-fixed sidebar-fixed-hidden aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
        <a class="navbar-brand" href="{{ url('/app') }}"></a>

		<!--
        @if(Request::segment(1) == 'builder') 
            <ul class="nav navbar-nav hidden-md-down">
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ url('/app') }}"><i class="icon-screen-tablet"></i> My Apps</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="#" id="preview-screen"><i class="icon-eye"></i> Preview</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="#"><i class="icon-settings"></i> Settings</a>
                </li>
            </ul>
        @endif
		-->

        <ul class="nav navbar-nav ml-auto">
			<!--
            @if(Request::segment(1) == 'builder') 
                 <li class="nav-item hidden-md-down">
                    <a class="nav-link" id="btn-import" href="#" rel="tooltip" title="Import" data-appId="{{Request::segment(2)}}"><i class="icon-cloud-upload"></i></a>
                </li>
                <li class="nav-item hidden-md-down">
                    <a class="nav-link" id="btn-export" href="#" rel="tooltip" title="Export" data-appId="{{Request::segment(2)}}"><i class="icon-cloud-download"></i></a>
                </li>
                <li class="nav-item hidden-md-down">
                    <a class="nav-link btn-save-app" href="#" rel="tooltip" title="Save"><i class="fa fa-floppy-o"></i></a>
                </li>
                <li class="nav-item hidden-md-down">
                    &nbsp;
                </li>
            @endif
			-->


            @if(Request::segment(1) == 'basicbuilder')
            <div id="myModal" class="basic-builder-modal" >
                <div class="basic-modal-content">
                    <span class="close">×</span>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 basic-image-title"> 
                                <h4></h4>  
                                <small class="image-url"></small>
                                <div class="basic-image-modal">
                                    <div class="basic-image-modal-2"></div>
                                </div> 
                            </div>
                            <div class="col-md-4 basic-builder-gallery"> 
                                <h4>Gallery <i class="fa fa-spinner fa-spin"></i></h4>
                                <div class="slider">
                                   <!--  <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div> 
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>
                                    <div><img src="http://placehold.it/350x150" class="img-responsive"></div>  -->
                                </div> 
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
            @endif
            @if(Request::segment(1) == 'builder' || Request::segment(1) == 'basicbuilder') 
                <!--<li class="nav-item">
                    <a class="nav-link mab-text-color" id="btn-import" href="#" rel="tooltip" title="Import" data-appId="{{Request::segment(2)}}"><i class="icon-cloud-upload"></i></a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link mab-text-color" id="btn-export" href="#" rel="tooltip" title="Export" data-appId="{{Request::segment(2)}}"><i class="icon-cloud-download"></i></a>
                </li>-->
                <li class="nav-item px-2">
                    <a class="nav-link mab-text-color btn-save-app" href="#" rel="tooltip" title="Save"><i class="fa fa-floppy-o fa-fw"></i> Save</a>
                </li>
				
				<li class="nav-item px-2">
                    <a class="nav-link mab-text-color btn-storyboard" href="#" rel="tooltip" title="Storyboard"><i class="fa fa-th fa-fw"></i> Storyboard</a>
                </li>
                
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="hidden-md-down mab-text-color"><i class="fa fa-wrench fa-fw"></i> Tools</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">

                        
                        <a id="btn-import" data-appId="{{Request::segment(2)}}" class="dropdown-item" href="Javascript:;" >
                             <i class="icon-cloud-upload"></i> Import
                        </a>
                        <a id="btn-export" data-appId="{{Request::segment(2)}}" class="dropdown-item" href="Javascript:;" >
                             <i class="icon-cloud-download"></i> Export
                        </a>
						<a id="btn-devices" data-appId="{{Request::segment(2)}}" class="dropdown-item" href="Javascript:;" >
                             <i class="icon-screen-smartphone"></i> My Devices
                        </a>
                    </div>
                </li>
            @endif

			<li class="nav-item px-2">
				<a class="nav-link mab-text-color" href="{{ url('/app') }}"><i class="fa fa-sliders fa-fw"></i> Dashboard</a>
			</li>
            
            @if(Request::segment(1) == 'builder' || Request::segment(1) == 'basicbuilder') 
			<li class="nav-item">
				<a class="nav-link mab-text-color" href="javascript:;" data-toggle="modal" data-target="#app-settings-modal"><i class="fa fa-cog fa-fw"></i> Settings</a>
			</li>
            @else
            <li class="nav-item">
                <a class="nav-link mab-text-color" href="javascript:;" data-toggle="modal" data-target="#settings-modal"><i class="fa fa-cog fa-fw"></i> Settings</a>
            </li>
            @endif

            <li class="nav-item px-2 dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="hidden-md-down mab-text-color">{{ Session::get('sub') }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <a class="dropdown-item" href="Javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>

            <!-- <li class="nav-item hidden-md-down">
                <span href="">&nbsp;</span>
            </li> -->
        </ul>
    </header>

    <div class="app-body">
        <!-- Main content -->
        <main class="main">

            @yield('content')

        </main>
    </div>

    <footer class="app-footer">
        Copyright &copy; <?= date('Y'); ?> Mobile App Builder
        <span class="float-right">Powered by <a href="#" target="_blank">Serino</a>
        </span>
    </footer>

    <div class="builder-init-loader @if(Request::segment(1) !== 'builder') hidden-xs-up @endif">
        <div class="loader-content">
            <h4 class="loader-heading mab-text-color">Loading</h4>
            <progress class="loader-progress progress progress progress-success" value="0" max="100"></progress>
            <p class="loader-status text-muted">Initializing UI</p>
        </div> 
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="{{ url('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('assets/bower_components/axios/axios.min.js') }}"></script>
    <script src="{{ url('assets/bower_components/tether/dist/js/tether.min.js') }}"></script>
    <script src="{{ url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/bower_components/pace/pace.min.js') }}"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>
    <script src="{{ url('assets/bower_components/notify-master/js/prettify.js') }}"></script>
    <script src="{{ url('assets/bower_components/notify-master/js/notify.js') }}"></script>
    <script src="{{ url('assets/bower_components/bootbox/bootbox.min.js') }}"></script>
	<script src="{{ url('assets/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>
	<script src="{{ url('assets/bower_components/blockUI/jquery.blockUI.js') }}"></script>
	<script src="{{ url('assets/bower_components/isotope/dist/isotope.pkgd.min.js') }}"></script>

    @if(Request::segment(1) == 'basicbuilder')   
        <script type="text/javascript" src="{{ url('converter/lib/codemirror.js') }}"></script> 
        <script type="text/javascript" src="{{ url('converter/mode/xml/xml.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/edit/matchbrackets.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/fold/xml-fold.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/edit/matchtags.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/edit/matchtags.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/edit/matchtags.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/search/search.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/search/searchcursor.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/search/jump-to-line.js') }}"></script>
        <script type="text/javascript" src="{{ url('converter/addon/dialog/dialog.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>  
        <script type="text/javascript" src="http://192.168.1.124:3000/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="{{ url('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('assets/bower_components/jquery-ui/jquery-ui-droppable-iframe.js') }}"></script>
        
        <script>
        window.io || document.write('<script type="text/javascript" src="http://192.168.1.124/js/plugins/socket.io.js"><\/script>');
        </script>
 
        <script type="text/javascript">
             
        </script>
    @endif 
    <script type="text/javascript">
        bootbox.setDefaults({
            closeButton: false,
            animate: true
        });     
        window.notify = $.notify;
    </script>

    <script type="text/javascript">
        window.appConfig = {
			env: '{{ env("APP_ENV") }}',
            baseUrl: '{{ url("/") }}',
            idmsBaseUrl: '{{ env("IDMS_BASE_URL") }}',
            idmsAccessToken: '{{ Session::get("access_token") }}',
            idmsContext: '{{ Session::get("context") }}',
            userId: '{{ Session::get("sub") }}'
        }
    </script> 

     @if(Request::segment(1) == 'basicbuilder')  
     <script type="text/javascript" src="{{ url('/js/basicbuilder.js') }}"></script> 
     <!-- Basic Builder Page --> 
     @endif 
    
    <script src="{{ url('js/app.js') }}"></script> 

    @yield('scripts')

</body>

</html>