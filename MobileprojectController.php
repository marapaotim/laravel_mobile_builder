<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request; 

use App\MobileApplication;

class MobileprojectController extends Controller
{
	public function __construct() {
		$this->middleware('idms.auth');
	}

	public function index( $id ){ 

		 $mobileapp = MobileApplication::find($id);

		 $path = storage_path('app/public/'."app-assets/".$mobileapp->user_id."/".$mobileapp->id."/");

		 $files = $this->basic_builder( $path ); 
		//return view( 'basic.basicbuilder' );
		return view( 'basic.basicbuilder', compact('files', 'path') );

	}

	public function get_tree_files( Request $request ){ 

			$id = $request->input('id');

	    	$mobileapp = MobileApplication::find($id);

			$path = storage_path('app/public/'."app-assets/".$mobileapp->user_id."/".$mobileapp->id."/");

			$files = $this->basic_builder( $path );  

	    	return response()->json($files); 

	}

	function basic_builder($dir = '',$result = array()){ 
		$files = scandir($dir);  
		foreach ($files as $key => $value) { 
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);  
			$filename = explode('/', $path); 
			if(!is_dir( $path )) { 
				$ext = pathinfo(last($filename), PATHINFO_EXTENSION);
				switch (strtolower($ext)) {
					case 'css':
	        		case 'html':
	        		case 'php':
	        		case 'txt':
	        		case 'xml': 
	        		case 'js': 
	        		case 'tpl': 
						$result[] = array( 
							'name'	=> last($filename), 
							'path'	=> $path 
						); 
					break; 
					default: 
						break;
				}
			}
			else if ($value != '.' && $value != '..') { 
				$result[last($filename)] = array(); 
				$result[last($filename)]['folder_path'] = array();
				$result[last($filename)] =  $this->basic_builder($path, $result[last($filename)]);
				$result[last($filename)]['folder_path'] = $path; 
			} 
		} 
		return $result;
	} 

	public function file_content(Request $request){

		if(request()->ajax()){

	    	$file = file_get_contents($request->input('path'));  

	    	return response()->json($file);

    	}
	}

	public function upload_file_project(Request $request){ 

			$file_info = array(

				'file' => $request->input('file'), 
				'filename' => $request->input('filename'), 
				'path_folder' => $request->input('path_folder')

			);

			file_put_contents($file_info['path_folder'].'/'.$file_info['filename'], base64_decode(explode(',',$file_info['file'])[1]));

			return response()->json($file_info);

	}

}