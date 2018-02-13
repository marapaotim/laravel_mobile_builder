@extends('layouts.app')
 
    <link rel="stylesheet" href="{{ url('css/custom-dashboard.css') }}">
    <style type="text/css">
    </style> 
    <link rel="stylesheet" type="text/css" href="{{ url('converter/lib/codemirror.css') }}" /> 

@section('content') 
<div class="container-fluid basic-header" style="padding-top:5px;"> 
    <div class="row">
        <div class="col-md-2 text-left">
            <div class="row">
                <h5>File Explorer</h5> 
            </div>
        </div>
        <div class="col-md-10 text-left display-url">
            <h5>Editor</h5> 
        </div> 
    </div>
</div>
<div class="container-fluid">  
    <div class="row">  
        <div class="col-md-2 basic-option-list"> 
            <input type="file" value="upload" id="basic-uploadFile" style="display: none"/>  <!--accept=".rar,.zip"-->
            <ul style="list-style-type:none;padding-left:0px"> <?php basic_builder($files, $path); ?> 

            <ul class='custom-menu'>
              <li data-action = "import">Import File</li>
              <li data-action = "add">Add File</li>   
            </ul>  

             </ul>   
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
                    echo '<li class="basic-file"><a href="#" onclick="retrieveXML(this); return false" data-path="'.$value['path'].'"> <i class="fa fa-file-code-o" aria-hidden="true"></i> '.$value['name'].'</a></li>';
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