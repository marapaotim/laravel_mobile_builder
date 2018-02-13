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
      <style type="text/css">
          .custom-menu {
                display: none;
                z-index: 1000;
                position: absolute;
                overflow: hidden;
                border: 1px solid #CCC;
                white-space: nowrap;
                font-family: sans-serif;
                background: #FFF;
                color: #333;
                border-radius: 5px;
                list-style-type:none;
                padding-left: 0px;
            }

            .custom-menu li {
                padding: 8px 12px;
                cursor: pointer;
            }

            .custom-menu li:hover {
                background-color: #DEF;
            }
            .selected-folder,
            .selected-folder:active,
            .selected-folder:hover{
               color: orange;
            }

            .selected-tab,
            .selected-tab:active,
            .selected-tab:hover{
               color: orange !important; 
            } 
            .main .container-fluid{
                padding: 0 20px !important;
            } 



        .basic-option-list{
            border:1px solid #cfcfcf;
            padding:10px;
            height: 240px;
            overflow: scroll; 
            background:#fff
        }
        .basic-header{
            border-bottom:1px solid #cfcfcf;
            border-top:1px solid #cfcfcf;
            background:#fff; 
        }  

        .nav-tabs > li {
            position:relative;
            padding: 10px 10px;
            background-color: #fff;
            border-top: 1px solid #cfcfcf;
            border-left: 1px solid #cfcfcf;
            border-right: 1px solid #cfcfcf;
            color: #000;
            font-weight: bold;
            /*margin-left: 2px;*/
            /*border-radius: 8px;*/
        }
        .nav-tabs > li > a {
            display: inline-block;
        }
        .nav-tabs > li > span {
            display:none;
            cursor:pointer;
            position:absolute;
            right: 6px;
            top: 8px;
            color: red;
        }
        .nav-tabs > li:hover > span {
            display: inline-block;
        }
        button.close{
            padding-left: 10px !important;
        }
        .display-url h5{
            color: orange !important;
            font-size: 15px;
            padding-top: 5px;
        }
        .CodeMirror-gutters{
            background: #cfcfcf;
        }
        .CodeMirror{
            border-bottom: 1px solid #cfcfcf;
            border-right: 1px solid #cfcfcf;
        }
      </style>
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


    <script type="text/javascript" src="{{ url('converter/lib/codemirror.js') }}"></script> 
    <script type="text/javascript" src="{{ url('converter/mode/xml/xml.js') }}"></script>
    <script type="text/javascript" src="{{ url('converter/addon/edit/matchbrackets.js') }}"></script>
    <script type="text/javascript" src="{{ url('converter/addon/fold/xml-fold.js') }}"></script>
    <script type="text/javascript" src="{{ url('converter/addon/edit/matchtags.js') }}"></script>
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
        <script type="text/javascript"> 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id;

            var $contextMenu = $(".basic-option-list .custom-menu");

            var path_folder = '';

            var selected_folder = '';

            $(document).on("contextmenu", ".basic-option-list li a.basic-folder", contextClick);

            function contextClick(event){

                event.preventDefault(); 

                selected_folder = $('> ul', $(event.target).parent()); 

                //console.log(1, selected_folder)
                path_folder = $(this).attr("data-folder-path");  

               // console.log(path_folder);

                $contextMenu.css({
                  display: "block",
                  left: event.pageX,
                  top: event.pageY - 80
                });

            }
 

            $(document).bind("mousedown", function (e) {

                if (!$(e.target).parents(".custom-menu").length > 0) {

                    $(".custom-menu").hide(100);
                }
            });

            $(".custom-menu li").click(function(){

                switch($(this).attr("data-action")) { 

                    case "import": 
                        $('#basic-uploadFile').trigger('click');
                    break;
                    case "add":
                        add_files();
                    break;
                } 

                $(".custom-menu").hide(100);

            });

            function add_files(){
                selected_folder.append('<input type="text" id="add_file">');
                $('#add_file').val('.xml');
                $('#add_file').focus();
            }

            $('#basic-uploadFile').change( function(event) { 

                getBase64(event.target.files[0]); 

            }); 

            function getBase64(file) { 

               var reader = new FileReader();
               reader.readAsDataURL(file);
               reader.onload = function () {
                 ajax_import( reader.result, file.name );
               };
               reader.onerror = function (error) {
                 console.log('Error: ', error);
               };

            }

            function ajax_import(file, filename){

                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/upload_file',
                    data:{
                        file: file, 
                        filename: filename,
                        path_folder: path_folder
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                    console.log(result); 
                    selected_folder.append('<li class="basic-file"> <a href="#" onclick="retrieveXML(this); return false" data-path="'+ result.path_folder + '/' + result.filename + '"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '+ result.filename +'</a></li>');
                });  
            }  

        $(document).ready(function(e) {  

            id = window.location.toString().substring(window.location.toString().lastIndexOf('/') + 1); 
            console.log(id);  
           // display_tree_files();   

        });    

            $(".basic-option-list li ul").hide(); 

            $('.basic-option-list li a').mousedown(function(event) {
                event.preventDefault();  
                switch (event.which) {
                    case 1:
                            $(this).next('ul').toggle();
                            $(this).find('i').toggleClass('fa-folder fa-folder-open');
                        break;
                    case 2:
                        //alert('Middle Mouse button pressed.');
                        break;
                    case 3:  

                            if($( this ).find('i').hasClass( "fa-folder-open" )){  
                                
                                //$(this).find('i').toggleClass('fa-folder fa-folder-open');

                            }
                            else{ 

                                $(this).next('ul').toggle();

                            }
                        break;
                    default:
                        alert('You have a strange Mouse!');
                } 

                //$('.basic-option-list li a').removeClass('selected-folder');
                
                //if($( this ).hasClass( "selected-folder" )){ 

                    $('.basic-option-list li a').removeClass('selected-folder');

                // }
                // else{

                    $(this).addClass('selected-folder'); 

                //}

                //$('.basic-option-list li a').removeClass('selected-folder');

            }); 

            $('.basic-option-list li.basic-file a').click(function(e) {
                e.preventDefault();  
                $(this).find('i').removeClass('fa fa-file-code-o'); 
                $(this).find('i').addClass('fa fa-spinner fa-spin');  
            }); 

        var editor = CodeMirror.fromTextArea($("#basiceditor textarea")[0], {
                    mode: "application/xml",
                    styleActiveLine: true,
                    lineNumbers: true,
                    lineWrapping: true,
                    matchTags: {bothTags: true},
                    extraKeys: {
                        'Ctrl-J': 'toMatchingTag',
                        'Ctrl-Q': function(cm) { cm.foldCode(cm.getCursor()); },
                        'Ctrl-S': function () { $('a.btn-save-app').click(); }
                    },
                });


        function retrieveXML(data){ 

            path = data.getAttribute("data-path");
            var fileNameIndex = path.lastIndexOf("/") + 1;
            var filename = path.substr(fileNameIndex);

            $.ajax({
                dataType: 'json',
                type:'POST',
                url: '/get_file',
                data:{
                    path: data.getAttribute("data-path"), 
                }, 
                _token: '{{ csrf_token() }}'
            }).done(function(result){ 
                editor.setValue(result); 
                var tab_exists = true;

                if($('#myTab li a').length == 0){

                    $('#myTab').append('<li><a data-toggle="tab"  onclick="tab_xml(this); return false" href="#" data-path="'+ path +'"> '+ filename +'</a> <button class="close closeTab" type="button" >×</button></li>'); 

                }
                else{
                    $("#myTab li a").each(function( index ){
                        //alert(path + ' ' + $(this).attr("data-path"));
                        if(path == $(this).attr("data-path"))//filename == $(this).text().substring(1).toString())
                        {
                            tab_exists = true; 
                            return false;
                        } 
                        else{
                            tab_exists = false; 
                        }
                    })
                }

                if(tab_exists == false)
                {

                    $('#myTab').append('<li><a data-toggle="tab"  onclick="tab_xml(this); return false" href="#" data-path="'+ path +'"> '+ filename +'</a> <button class="close closeTab" type="button" >×</button></li>'); 

                }

                var res = path.split('/'); 

                res.forEach(function(entry) {
                    if($.isNumeric(entry)){
                       // console.log(entry);
                       res = path.split(entry); 
                    }
                }); 

                $('.display-url h5').html(res[1].substr(1));

                $('.basic-option-list li.basic-file a').find('i').removeClass('fa fa-spinner fa-spin');

                $('.basic-option-list li.basic-file a').find('i').addClass('fa fa-file-code-o');

                $('.close').on('click', function(e) { 

                    $(this).parent('li').remove();  

                });
                
                $('#myTab li a').on('click', function(e) { 

                    $('#myTab li a').removeClass('selected-tab');

                    $(this).addClass('selected-tab');  

                });
            });  

        }

        function tab_xml(data){

            path = data.getAttribute("data-path");
            var fileNameIndex = path.lastIndexOf("/") + 1;
            var filename = path.substr(fileNameIndex);

            $.ajax({
                dataType: 'json',
                type:'POST',
                url: '/get_file',
                data:{
                    path: data.getAttribute("data-path"), 
                }, 
                _token: '{{ csrf_token() }}'
            }).done(function(result){ 
                editor.setValue(result);  

                var res = path.split('/'); 

                res.forEach(function(entry) {
                    if($.isNumeric(entry)){
                        //console.log(entry);
                       res = path.split(entry); 
                    }
                }); 

                $('.display-url h5').html(res[1].substr(1));
            }); 

        }  


    </script>
     <!-- Basic Builder Page --> 
     @endif 
    
    <script src="{{ url('js/app.js') }}"></script> 

    @yield('scripts')

</body>

</html>