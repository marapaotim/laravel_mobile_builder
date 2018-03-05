@extends('layouts.app')
    <link rel="stylesheet" href="{{ url('css/custom-dashboard.css') }}">
    <style type="text/css">
    </style> 
    <link rel="stylesheet" type="text/css" href="{{ url('converter/lib/codemirror.css') }}" /> 

@section('content') 
<div class="container-fluid basic-header" style="padding-top:5px;"> 
    <div class="row">
        <div class="col-md-2 text-left file-explorer">
            <div class="row">
                <h5>File Explorer</h5> 
            </div>
        </div>
        <div class="col-md-10 text-left display-url">
            <ul class="list-inline editor-inline">  
                <li><a href="#" id="basic-save-file" title="Save selected file"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i> Save </a></li>
                <li><a href="#" id="basic-save-file-all" title="Save all edited files"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i> Save All </a></li>
                <li>
                     <a href="#" id="download-basic-files" title="Download Project"><i class="fa fa-download" aria-hidden="true"></i> Download </a></li>
                <li><select id="device-list" name="device-list"></select> <a href="#" id="deploy-basic-files" title="Deploy Project"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Deploy </a></li>  
                <li><a href="#" id="log"> <i class="fa fa-mobile" aria-hidden="true"></i> Logs</a></li>      
                <li><h5>Editor</h5></li> 
            </ul> 
        </div> 
    </div>
</div>
<div class="container-fluid">  
    <div class="row">   
        <div class="col-md-2"> 
            <div class="basic-option-list row">
                <input type="file" value="upload" id="basic-uploadFile" style="display: none"/>  <!--accept=".rar,.zip"-->
                <ul style="list-style-type:none;padding-left:0px"> <?php basic_builder($files, $path); ?> 

                <ul class='custom-menu'>
                  <li data-action = "import">Import</li>
                  <li data-action = "add">Add</li> 
                  <li data-action = "remove">Remove</li>  
                  <li data-action = "rename">Rename</li> 
                </ul>   

                </ul> 
            </div>
            <div class="row basic-builder-tool"><h5>Components</h5>
                <table>
                    <!-- <tr>
                        <td><img src="/basic-icons/text-width.png"> Textbox</a></td>
                    </tr>
                     <tr>
                        <td><img src="/basic-icons/options-button.png"> Button</a></td>
                    </tr>
                     <tr>
                        <td><img src="/basic-icons/radio-on-button.png"> Radiobutton</a></td>
                    </tr>
                    <tr>
                        <td><img src="/basic-icons/check.png"> Checkbox</a></td>
                    </tr>
                    <tr>
                        <td><img src="/basic-icons/font-symbol-of-letter-a.png"> Label</a></td>
                    </tr> -->
                </table> 
            </div>  
        </div>
        <div class="col-md-10" id="basiceditor">
            	<ul class="nav nav-tabs marginBottom" id="myTab">      
    			</ul>  
                    <textarea></textarea>   
        <!--<span class="context-menu-one btn btn-neutral">right click me</span>-->
        </div>      
    </div> 
    
</div> 

@endsection  

<?php
 
    function basic_builder($files,  $folder_path = '' ){   
            foreach ($files as $key => $value) {
                if ( is_numeric( $key ) ) { 
                    if(isset($value['path'])){ 
                        $ext = pathinfo($value['name'], PATHINFO_EXTENSION);

                        switch (strtolower($ext)) {
                            case 'png': 
                            case 'gif':
                            case 'bmp':
                            case 'jpeg': 
                            case 'jpg':
                            $path_data = str_replace("/var/www/html/SerinoMobileAppBuilder","",$value['path']);
                            $path_data = str_replace("app/public/","",$path_data); 
                                echo '<li class="basic-files"><a href="#" onclick="retrieveImage(this); return false" data-path="'.$value['path'].'" data-image="'.$path_data.'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '.$value['name'].'</a></li>'; 
                            break; 
                            default:  
                                echo '<li class="basic-file"><a href="#" onclick="retrieveXML(this); return false" data-path="'.$value['path'].'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '.$value['name'].'</a></li>';  
                            break;
                        } 
                    }   
                    else
                    {
                        $value['path']  = '';
                    }
                } 
                if ( ! is_numeric($key) ) {  
                    if($key == 'folder_path'){  
                       $folder_path = $value;
                    }  
                    else{  
                        echo '<li><a class="basic-folder" href="#" data-folder-path="'.$value['folder_path'].'"> <i class="fa fa-folder" aria-hidden="true"></i> '.$key.'</a>';
                        echo '<ul class="options" style="list-style-type:none;padding-left:20px">';
                            basic_builder($value, $folder_path);
                        echo '</ul>';
                        echo '</li>'; 

                    }     
                }
            }  
    }  
?>