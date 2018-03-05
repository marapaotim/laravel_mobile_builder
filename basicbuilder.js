
            /*------------------------------
            Ajax Token for Laravel
            ------------------------------*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 


             
            var SOCKET_IO = '192.168.1.124:3000';  
            var window_open = '';
            /*-------------------------------
            Public variables
            -------------------------------*/
            var id; 
            var $contextMenu = $(".basic-option-list .custom-menu");  
            var path_folder = ''; 
            var selected_folder = '';
            var remove_file = ''; 
            var is_folder = "true";
            var drag_xml_file = ''; 
            var def_description = '';
            var path = '';

            /*------------------------------
            Context Menu for files
            ------------------------------*/
            $(document).on("contextmenu", ".basic-option-list li a", contextClick);  
            function contextClick(event){

                event.preventDefault(); 

                selected_folder = $('> ul', $(event.target).parent()); 

                path_folder = $(this).attr("data-folder-path"); 

                remove_file = $(event.target).parent();

                if (!$( this ).hasClass( "basic-folder" )) 
                {

                    is_folder   = "false";
                    path_folder = $(this).attr("data-path");
                    selected_folder = $(event.target).parent();
                }  

                //console.log(path_folder);

                $contextMenu.css({
                  display: "block",
                  left: event.pageX,
                  top: event.pageY - 80
                });

            } 
 

            /*------------------------------------
                Hide context menu when focus out
            -------------------------------------*/
            $(document).bind("mousedown", function (e) {

                if (!$(e.target).parents(".custom-menu").length > 0) {
                    $(".custom-menu").hide(100);
                } 
            });


            /*-------------------------------------------
            Context Menu condition for file action
            --------------------------------------------*/
            $(".custom-menu li").click(function(){ 
                switch($(this).attr("data-action")) {  
                    case "import": 
                        $('#basic-uploadFile').trigger('click');
                    break;
                    case "add":
                        add_files();
                    break;
                    case "remove":
                        ajax_remove_file();
                    break;
                    case "rename":
                        rename_file();
                    break;
                }  
                $(".custom-menu").hide(100); 
            });


            /*-----------------------------------------
            Rename file actions
            ------------------------------------------*/
            function rename_file(){ 
                remove_file.replaceWith('<input type="text" value="'+remove_file.text().trim()+'" id="rename_file">');
                $('#rename_file').focus();

                $("#rename_file").bind('focusout keyup',function(e) { 
                    if(e.keyCode === 13){ ajax_rename_file(); } 
                    if (e.type === 'focusout'){ ajax_rename_file(); }  
                }); 
            }

            function ajax_rename_file(){
                //console.log(path_folder);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/rename_file',
                    data:{  
                        path: path_folder,
                        filename: $('#rename_file').val() 
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){ 
                   //  console.log(result);  
                    var filename = $('#rename_file').val();
                    var extension = filename.substr( (filename.lastIndexOf('.') +1) );
                    switch(extension.toLowerCase()) {
                        case 'png': 
                        case 'gif':
                        case 'bmp':
                        case 'jpeg': 
                        case 'jpg':
                        var data_image_path = result.filename;
                        data_image_path = data_image_path.replace('/var/www/html/SerinoMobileAppBuilder','');
                        data_image_path = data_image_path.replace('app/public/','');
                            $('#rename_file').replaceWith('<li class="basic-files"><a href="#" onclick="retrieveImage(this); return false" data-path="'+result.filename+'" data-image="'+data_image_path+'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '+ filename +'</a></li>');
                        break;
                        default: 
                            $('#rename_file').replaceWith('<li class="basic-file"> <a href="#" onclick="retrieveXML(this); return false" data-path="'+result.filename+'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '+ filename +'</a></li>'); 
                       break;
                    } 
                }); 
            }


            /*-----------------------------------------
            Ajax Save File Contents
            ------------------------------------------*/
             $("a#basic-save-file").click(function(){

                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/save_file',
                    data:{  
                        path: path,
                        content: editor.getValue()
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){ 

                    //console.log(result); 
                    alert('Successfully Save!');

                }); 

             });


            /*-----------------------------------------
            Ajax Save all File Contents
            ------------------------------------------*/ 
            $("a#basic-save-file-all").click(function(){  

                var retrievedObject = localStorage.getItem('new_cache_obj'); 

                $(this).find('i').removeClass('fa-floppy-o fa-fw');

                $.each(JSON.parse(retrievedObject), function (key, value) {   
                    $(this).find('i').addClass('fa-spinner fa-spin'); 
                    ajax_save_all(key, value);
                }, "json");  

                alert('Successfully Saved');
                $(this).find('i').removeClass('fa-spinner fa-spin');
                $(this).find('i').addClass('fa-floppy-o fa-fw');

             });

             function ajax_save_all(file_path, file_value){
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/save_file_all',
                    data:{  
                        path: file_path,
                        content: file_value
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                   // console.log(result);  
                }); 
             }


            /*-----------------------------------------
            Set Cursor location function
            ------------------------------------------*/
            $.fn.setCursorPosition = function(pos) {
              this.each(function(index, elem) {
                if (elem.setSelectionRange) {
                  elem.setSelectionRange(pos, pos);
                } else if (elem.createTextRange) {
                  var range = elem.createTextRange();
                  range.collapse(true);
                  range.moveEnd('character', pos);
                  range.moveStart('character', pos);
                  range.select();
                }
              });
              return this;
            };


            /*-----------------------------------------
            add/remove textbox input for add file
            ------------------------------------------*/
            function add_files(){

                selected_folder.append('<input type="text" id="add_file">');

                $('#add_file').val('.xml');

                $('#add_file').focus();

                $('#add_file').setCursorPosition(0); 

                $("#add_file").bind('focusout keyup',function(e) { 
                    if(e.keyCode === 13)
                    {
                        if($('#add_file').val() == '')
                        {
                            $('#add_file').remove();
                            return false;
                        }
                        $(this).attr("disabled", "disabled"); 
                    } 
                    if (e.type === 'focusout')
                    {
                        if($('#add_file').val() == '')
                        {
                            $('#add_file').remove();
                            return false;
                        }
                        ajax_create_file(path_folder, $('#add_file').val());
                        $("#add_file").removeAttr("disabled"); 
                    }  
                }); 

            }

            /*--------------------------------------------
            Ajax add/remove textbox input for add file
            ----------------------------------------------*/
            function ajax_create_file(path_folder, filename){
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/create_file',
                    data:{  
                        filename: filename,
                        path_folder: path_folder,
                        folder: is_folder
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){ 

                    if(result.filename == 'Duplicate'){
                       // console.log(result.filename);
                        alert('Error: File already exists');  
                        $('body').trigger('click'); 
                        //$("#add_file").focusout();

                    }
                    else if (result.filename == 'Error') {

                       $('#add_file').replaceWith($('<li class="basic-file"> <a href="#"> <i class="fa fa-file-code-o" aria-hidden="true"></i> ' + 'Error File' + '</a> </li>')); 

                    } 
                    else
                    {

                        $('#add_file').replaceWith($('<li class="basic-file"> <a href="#"  onclick="retrieveXML(this); return false" data-path= "'+ result.path_folder + '/' + result.filename + '"> <i class="fa fa-file-code-o" aria-hidden="true"></i> ' + result.filename + '</a> </li>'));

                    } 

                }); 
            }

            /*-----------------------------------------
            Browse Files
            ------------------------------------------*/
            var event_file = '';
            $('#basic-uploadFile').change( function(event) { 

                getBase64(event.target.files[0]); 

                event_file = event.target.value;

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

            /*-----------------------------------------
            Ajax function when upload a file
            ------------------------------------------*/
            function ajax_import(file, filename){

                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/upload_file',
                    data:{
                        file: file, 
                        filename: filename,
                        path_folder: path_folder,
                        folder: is_folder
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                    //console.log(result); 
                    if(result.filename == 'Duplicate'){

                    	ajax_override_file(result.path, file);

                    }
                    else{

                        var filename = result.filename;
                        var extension = filename.substr( (filename.lastIndexOf('.') +1) );
                        switch(extension.toLowerCase()) {
                        case 'png': 
                        case 'gif':
                        case 'bmp':
                        case 'jpeg': 
                        case 'jpg':
                            var data_image_path = result.path_folder + '/' + result.filename;
                            data_image_path = data_image_path.replace('/var/www/html/SerinoMobileAppBuilder','');
                            data_image_path = data_image_path.replace('app/public/','');
                            selected_folder.append('<li class="basic-files"><a href="#" onclick="retrieveImage(this); return false" data-path="'+ result.path_folder + '/' + result.filename +'" data-image="'+data_image_path+'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '+ filename +'</a></li>');
                        break;
                        default: 
                            selected_folder.append('<li class="basic-file"> <a href="#" onclick="retrieveXML(this); return false" data-path="'+ result.path_folder + '/' + result.filename + '"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '+ result.filename +'</a></li>');
                            event_file = '';
                        break;
                        }

                    }
                });  
            }


            //Ajax override the file
            function ajax_override_file(path, file){

                if(confirm("This file already exist. Do you want to override?")){ 
                    $.ajax({
                        dataType: 'json',
                        type:'POST',
                        url: '/override_file',
                        data:{ 
                            path: path,
                            file: file
                        }, 
                        _token: '{{ csrf_token() }}'
                    }).done(function(result){  
                        //console.log(result);   
                        event_file = '';
                    }); 
                }
                else{ 
                    event_file = '';
                }

            } 

        /*-----------------------------------------
        Ajax function when remove a file
        ------------------------------------------*/
        function ajax_remove_file(){
            if(confirm("Are you sure you want to remove?") == true){ 
            $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/delete_file',
                    data:{ 
                        path_folder: path_folder 
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                   // console.log(result); 
                    remove_file.remove(); 
                });  
            } 
        } 

        /*-----------------------------------------
        Get the current id of project
        ------------------------------------------*/
        
        var modal = '';
        var bxslider_image;
        (function(){

            id = window.location.toString().substring(window.location.toString().lastIndexOf('/') + 1); 
            //console.log(id);     

            //localStorage.setItem("new_cache_obj", JSON.stringify(""));
            localStorage.removeItem('new_cache_obj');

            get_devices(); 

            modal = document.getElementById('myModal'); //$('#myModal');//

            bxslider_image = $('.slider').bxSlider({
                slideWidth: 300,
                pause: 3000,
                minSlides: 5,
                maxSlides: 6,
                moveSlides: 1,
                slideMargin: 10,
                infiniteLoop: true,
                pager: false,
                auto: false,
                mode: 'vertical', 
            });

            $('.basic-builder-gallery h4 i').hide();   

            initDroppable($("#basiceditor")); 

            ajax_get_component_list();
            
        })();  

        function initDroppable($elements) {
                $elements.droppable({ 
                    accept: ":not(.ui-sortable-helper)",
                    over: function () {

                            window.isOverEditor = true;
                        },
                    out: function () {
                        
                            window.isOverEditor = false;
                        },
                    drop: function(event, ui) { 
                        ajax_get_xml_component(drag_xml_file); 
                    }
                });
            } 

        $("a#log").click(function(){ 
            window_open = window.open('/logs','GoogleWindow', 'width=800, height=600'); 
            setTimeout(function(){ window_open.document.title = $('#device-list option:selected').text() + '(Logs)'; }, 1000);


            window_open.onbeforeunload = function(){
                
                socket.emit('leave', $('select[name=device-list]').val());
                    
                socket.off('log');

            }
        });


        /*--------------------------------
        Ajax for download project
        ---------------------------------*/
        $("a#download-basic-files").click(function(){ 
          
           $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/download_project',
                    data:{
                        id: id 
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                    location.href = result.project;
                    //console.log(result.project);  
                });   
        });

            /*-----------------------------------------
            Code for treeview files action
            ------------------------------------------*/   
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

                            if($( this ).find('i').hasClass( "fa-folder-open" )){ }
                            else{ 

                                $(this).next('ul').toggle();
                                $(this).find('i').removeClass('fa-folder');
                                $(this).find('i').addClass('fa-folder-open');

                            }
                        break;
                    default:
                        alert('You have a strange Mouse!');
                }  

                    $('.basic-option-list li a').removeClass('selected-folder');  
                    $(this).addClass('selected-folder');  

            }); 

            $('.basic-option-list li.basic-file a').click(function(e) {
                e.preventDefault();  
                $(this).find('i').removeClass('fa fa-file-code-o'); 
                $(this).find('i').addClass('fa fa-spinner fa-spin');  
            });


        /*-----------------------------------------
        Code for Codemirror
        ------------------------------------------*/ 
        var editor = CodeMirror.fromTextArea($("#basiceditor textarea")[0], {
                    mode: "application/xml",
                    styleActiveLine: true,
                    lineNumbers: true,
                    lineWrapping: true,
                    matchTags: {bothTags: true},
                    dragDrop: true,
                    extraKeys: {
                        'Ctrl-J': 'toMatchingTag',
                        'Ctrl-Q': function(cm) { cm.foldCode(cm.getCursor()); },
                        'Ctrl-S': function () { $('a.btn-save-app').click(); },
                        'Alt-F': "findPersistent"
                    } 
                });

        /*-----------------------------------------
        Store changes files in local storage
        ------------------------------------------*/ 
        var new_cache_obj = {}; 

        editor.on("keyup", function(e) {
            //delete new_cache_obj[path]; 
            //alert('asdasd'); 
            new_cache_obj[path] = editor.getValue();
            localStorage.setItem('new_cache_obj', JSON.stringify(new_cache_obj)); 
            if (e.keyCode == 17) {
              //  if (e.keyCode == 65 || e.keyCode == 97) { // 'A' or 'a'
                    alert("Control pressed"); 
                    return false;
               // }
            }
        });
        

        /*---------------------------------------------------
        Retrieve function to display at codemirror textarea
        ----------------------------------------------------*/ 
        var _data_tab;
        function retrieveXML(data){ 

            path = data.getAttribute("data-path"); 

            var retrievedObject = localStorage.getItem('new_cache_obj'); 

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
             //; 


                if(retrievedObject == null){ editor.setValue(result); }
                else{

                    if(Object.keys(retrievedObject).length <= 2){ editor.setValue(result); }
                    else{

                        $.each(JSON.parse(retrievedObject), function (key, value) {   
                            if(path == key){  
                                
                                editor.setValue(value); 
                                return false; 

                            }else{ 

                                editor.setValue(result);  
                            } 
                        }, "json");

                    } 

                }
 
                var tab_exists = true;

                if($('#myTab li a').length == 0){

                    $('#myTab').append('<li><a data-toggle="tab"  onclick="tab_xml(this); return false" href="#" data-path="'+ path +'">  <i class="fa fa-file-code-o"></i> '+ filename +'</a> <button class="close closeTab" data-path-close="'+ path +'" onclick="close_file_tab(this); return false" type="button" >×</button></li>'); 

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

                    $('#myTab').append('<li><a data-toggle="tab"  onclick="tab_xml(this); return false" href="#" data-path="'+ path +'"> <i class="fa fa-file-code-o"></i> '+ filename +'</a> <button class="close closeTab" data-path-close="'+ path +'" onclick="close_file_tab(this); return false" type="button" >×</button></li>'); 

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

                    // $('#myTab button.close').on('click', function(e) {   

                           

                    // });
                
                $('#myTab li a').on('click', function(e) { 
                    _data_tab = $(this);
                    $('#myTab li a').removeClass('selected-tab');

                    $(this).addClass('selected-tab');  

                    _data_tab.find('i').removeClass('fa fa-file-code-o'); 
                    _data_tab.find('i').addClass('fa fa-spinner fa-spin');

                });
            });  

        }  
        function retrieveImage(data){   
            var imgSrc = data.getAttribute("data-image"); 

            $('.basic-image-modal-2').attr('style', 'background-image: url("' + imgSrc +'")');

            modal.style.display = 'block';
            //modal = $('#myModal');

            ajax_images_file(); 

            var res = imgSrc.split("/");

            var img = new Image();

            img.onload = function() {
               $('.basic-image-title h4').html(res.slice(-1)[0] + '<small> (' + this.width + ' x ' + this.height + ') </small>');
            }
            img.src = imgSrc;

            var res_two = imgSrc.split('/'); 

            res_two.forEach(function(entry) {
                if($.isNumeric(entry)){ 
                    res_two = imgSrc.split(entry); 
                }
            }); 

            $('small.image-url').html(res_two[1].substr(1));
        }

        function ajax_images_file(){
            $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/get_all_image',
                    data:{ 
                        id: id, 
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                    var row = '';
                    $('.basic-builder-gallery h4 i').show(); 
                    $.each(result, function (key, value) { 
                        row += '<div> <img src = "'+value+'" data-path-image="'+ value +'" onclick="gallery_image_display(this); return false" class="img-responsive"/></div>';
                    }, "json"); 
                    $('.slider').html(row); 
                    bxslider_image.reloadSlider(); 
                    $('.basic-builder-gallery h4 i').hide();
                }); 
        }

        function gallery_image_display(data){

           var imgSrc = data.getAttribute("data-path-image");

           $('.basic-image-modal-2').attr('style', 'background-image: url("' + imgSrc +'")');

            var res = imgSrc.split("/");

            var img = new Image();

            img.onload = function() {
               $('.basic-image-title h4').html(res.slice(-1)[0] + '<small> (' + this.width + ' x ' + this.height + ') </small>');
            }

            img.src = imgSrc;

            var res_two = imgSrc.split('/'); 

            res_two.forEach(function(entry) {
                if($.isNumeric(entry)){ 
                    res_two = imgSrc.split(entry); 
                }
            }); 

            $('small.image-url').html(res_two[1].substr(1));
        }

        $('span.close').on('click', function(e) {  
              modal.style.display = 'none';
        }); 

        window.onclick = function(event) { 
            //console.log(event.target);
            //console.log(modal);
            if (event.target == modal) {
                //modal.hide();// 
                modal.style.display == "none";
            }
        } 


        /*---------------------------------------------------
        Close function at tab file close
        ----------------------------------------------------*/ 
        function close_file_tab(data){ 
            var tab_path = data.getAttribute("data-path-close");
            //console.log(tab_path);
            var retrievedObject = [], retrieveObject_two = [];
            retrievedObject = localStorage.getItem('new_cache_obj'); 
            retrieveObject_two = $.parseJSON(retrievedObject);
            var no_changes = true;
            //console.log(retrieveObject_two);
            //console.log(new_cache_obj);
            var close_parent_tab = data.parentNode;
            //alert(Object.keys(new_cache_obj).length); 
                $.ajax({
                            dataType: 'json',
                            type:'POST',
                            url: '/content_change',
                            data:{
                                path: tab_path, 
                            }, 
                            _token: '{{ csrf_token() }}'
                        }).done(function(result){ 
                           // console.log(result.contents);
                            //Object.keys(retrieveObject_two).length
                            if(retrieveObject_two != null)
                            {
                                if (Object.keys(retrieveObject_two).length > 0)
                                { 
                                    $.each(retrieveObject_two, function (key, value) {  
                                        //console.log(result.contents);
                                            if (tab_path == key)
                                            {
                                                if (value != result.contents)
                                                {
                                                    if(confirm('Changes you made may not be saved. Are you sure you want to close?')){ 
                                                        delete new_cache_obj[tab_path];
                                                        //new_cache_obj[tab_path] = result.contents; 
                                                        //localStorage.setItem("new_cache_obj", JSON.stringify("")); 
                                                        localStorage.setItem("new_cache_obj", JSON.stringify(new_cache_obj)); 
                                                        no_changes = false;
                                                        close_parent_tab.remove();
                                                        return false;
                                                    } 
                                                    else
                                                    {
                                                        no_changes = false;
                                                        return false;
                                                    } 
                                                }
                                                else
                                                {
                                                    no_changes = false;
                                                    delete new_cache_obj[tab_path];
                                                    //new_cache_obj[tab_path] = result.contents; 
                                                        //localStorage.setItem("new_cache_obj", JSON.stringify("")); 
                                                    localStorage.setItem("new_cache_obj", JSON.stringify(new_cache_obj));
                                                    close_parent_tab.remove();
                                                    return false;
                                                } 
                                            }
                                            else
                                            {
                                                no_changes = true;
                                            } 

                                    }, "json");

                                    if(no_changes)
                                    {
                                        close_parent_tab.remove();
                                    } 
                                }
                                else
                                {

                                }

                                if(no_changes)
                                {
                                    close_parent_tab.remove();
                                } 

                            } 
                            else
                            {
                                close_parent_tab.remove(); 
                            }

                            if(no_changes)
                            {
                                close_parent_tab.remove();
                            }     
                        });                 

        }

        /*---------------------------------------------------
        Tab display function
        ----------------------------------------------------*/ 
        function tab_xml(data){

            path = data.getAttribute("data-path");
            
            // fa-spinner fa-spin
            // <i class="fa-file-code-o fa"></i>

            var fileNameIndex = path.lastIndexOf("/") + 1;
            var filename = path.substr(fileNameIndex);

            var retrievedObject = localStorage.getItem('new_cache_obj');

            $.ajax({
                dataType: 'json',
                type:'POST',
                url: '/get_file',
                data:{
                    path: data.getAttribute("data-path"), 
                }, 
                _token: '{{ csrf_token() }}'
            }).done(function(result){ 

                //editor.setValue(result);  
                if(retrievedObject == null){ editor.setValue(result); }
                else{ 
                if(Object.keys(retrievedObject).length <= 2){ editor.setValue(result); }
                else{
                        $.each(JSON.parse(retrievedObject), function (key, value) {   
                            if(path == key){  
                                
                                editor.setValue(value); 
                                return false; 

                            }else{ 

                                editor.setValue(result);  
                            } 
                        }, "json");
                    }
                } 

                var res = path.split('/'); 

                res.forEach(function(entry) {
                    if($.isNumeric(entry)){
                        //console.log(entry);
                       res = path.split(entry); 
                    }
                }); 

                $('.display-url h5').html(res[1].substr(1)); 

                _data_tab.find('i').removeClass('fa fa-spinner fa-spin');  
                _data_tab.find('i').addClass('fa fa-file-code-o');  
            }); 

        }

        $(document).on("click","a#deploy-basic-files",function(){ 

             $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/api/app/file/prepDeploy',
                    data:{
                        data: {
                            appId: id,
                            devices:[$('select[name=device-list]').val()]
                        }
                    }, 
                    _token: '{{ csrf_token() }}'
                }).done(function(result){    
                   // console.log(result);
                    alert('Successfully Deployed!');  
                });  

        });

        function get_devices(){
              $.ajax({
                    dataType: 'json',
                    type:'GET',
                    url: '/api/devices?uid=kvsfggva%40sharklasers.com',  
                    _token: '{{ csrf_token() }}'
                }).done(function(result){ 
                    var device_list = '';
                    $.each(result, function (key, value) { 
                        device_list += '<option value="'+value.deviceToken+'">' + value.name + '</option>';  
                    }, "json");
                    $('select#device-list').append(device_list);  
                });  
        }

        function log_device(){

            var socket = io.connect((appConfig.env == 'prod' ? 'https://' : '') + SOCKET_IO);

            socket.on('log', function(data){
               // window_open.$(data.type + ' : ' + data.logMessage);
                window_open.window_open_log_device(data.type, data.logMessage);
              //$('.basic-builder-logs ul').append($('<li>').text(data.type + ' : ' + data.logMessage + ' = ' + d.getHours() + ' : ' + d.getMinutes()));
            });

            socket.emit('join', $('select[name=device-list]').val()); 
            //'5B5F29E2-2A49-41D0-A869-66EE4AAA08AF'

        }

        window.onbeforeunload = function() {
            return "Bye now!";
        };



        // function tool_description(defs_json){
        //     $.ajax({
        //             dataType: 'json',
        //             type:'GET',
        //             url: defs_json, 
        //             async:false,
        //             _token: '{{ csrf_token() }}'
        //         }).done(function(result){  
        //              result.description; 
        //    });
        // }

        function ajax_get_component_list(){
             $.ajax({
                    dataType: 'json',
                    type:'GET',
                    url: '/component_list',  
                    _token: '{{ csrf_token() }}'
                }).done(function(result){  
                    var row = '';
                    var icon = '';
                    var xml = '';
                    //console.log(result);
                    $.each(result, function (key, value) {
                        $.each(value, function (key2, value2) {
                            var filename = value2;  
                            var filename2 = filename.split("/");
                            if(filename2[filename2.length-1].toLowerCase() == 'icon.png')
                            {
                                icon = filename;
                            }
                            else if(filename2[filename2.length-1].toLowerCase() == 'assets.xml')
                            {
                                xml = key + '/assets.xml';
                            }
                            else
                            { 
                                def_description = value2;                                //console.log(tool_description(value2));
                            } 
                        }, "json");

                        var key_tool = key.split("/");

                        row += '<tr  data-xml-file="'+ xml +'">';
                        row += '<td data-xml-file="'+ xml +'" title="'+ def_description +'">';
                        row += '<img src="'+ icon.toLowerCase() +'"> '+ key_tool[key_tool.length-1].charAt(0).toUpperCase() + key_tool[key_tool.length-1].slice(1).toLowerCase() +'</td>';
                        row += '</td>';
                        row += '</tr>'; 

                    }, "json");
                    $('.basic-builder-tool table').append(row); 

                    $(".basic-builder-tool table tr").draggable({
                        appendTo: "body",
                        helper: function (e) {
                                drag_xml_file = $(this).attr('data-xml-file'); 
                                var img = $('img', this),
                                    _w = img.width(),
                                    w = _w * 2,
                                    _h = img.height(),
                                    h = _h * 2;
                                
                                $(e.currentTarget).draggable('option', {
                                    cursorAt: {
                                            left: _w,
                                            top: _h
                                        },
                                    drag: function (e, ui) {
                                            
                                            if(window.isOverEditor) {
                                                
                                                window.editor.focus();
                                                
                                                window.editor.setCursor(window.editor.coordsChar({ left: ui.offset.left + _w, top: ui.offset.top + _h }));
                                            }
                                        }
                                });

                                return img.clone().removeAttr('id').css({ width: w + 'px', height: h + 'px', zIndex: 2 });
                            },
                        cursor: "select",
                        revert: "invalid"
                    }); 

                });  
        }

        function ajax_get_xml_component(link_asset_file){

            $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: '/get_file',
                    data:{
                        path: link_asset_file
                    },   
                    _token: '{{ csrf_token() }}'
            }).done(function(result){ 
                editor.replaceSelection(result);  
                new_cache_obj[path] = editor.getValue();
                localStorage.setItem('new_cache_obj', JSON.stringify(new_cache_obj));
            });  

        }

        $(document).on("dblclick",".basic-builder-tool td",function(){ 
            ajax_get_xml_component($(this).attr('data-xml-file')); 
        });