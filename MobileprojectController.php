<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request; 

use App\MobileApplication; 

use Zipper;

class MobileprojectController extends Controller
{
	public function __construct() {

		$this->middleware('idms.auth.builder');
	}

	public function index( $id ){ 

		 $mobileapp = MobileApplication::find($id);

		 $path = storage_path('app/public/'."app-assets/".$mobileapp->user_id."/".$mobileapp->id."/");

		 $files = $this->basic_builder( $path ); 
		//return view( 'basic.basicbuilder' );
		return view( 'basic.basicbuilder', compact('files', 'path') );

	}

	public function index_log_controller(){  

		return view('basic.logs'); 

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
				$result[] = array( 
							'name'	=> last($filename), 
							'path'	=> $path 
						); 
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

				'file' 			=> $request->input('file'), 
				'filename' 		=> $request->input('filename'), 
				'path_folder' 	=> $request->input('path_folder'),
				'is_folder' 	=> $request->input('folder')

			); 
			if ($file_info['is_folder'] == "false") {
				$file_name = explode('/', $file_info['path_folder']);
				$file_info['path_folder'] = str_replace("/".last($file_name),"", $file_info['path_folder']);
			} 
			$files = scandir($file_info['path_folder'].'/'); 

			foreach ($files as $key => $value) { 
				$path = realpath($file_info['path_folder'].'/'.DIRECTORY_SEPARATOR.$value); 
				$filename = explode('/', $path); 
				if(!is_dir( $path )) { 
					if (last($filename) == $file_info['filename']) {
						return response()->json(
							[
								'filename' => 'Duplicate', 
								'path'	=> $path
							]
						); 
					}
				} 
			} 
			file_put_contents($file_info['path_folder'].'/'.$file_info['filename'], base64_decode(explode(',',$file_info['file'])[1])); 
			return response()->json($file_info);

	}

	public function override_file_controller(Request $request){

		$file_info = array(
			'path' 	=> $request->input('path'),
			'file'	=> $request->input('file')
		);  

		file_put_contents($file_info['path'], base64_decode(explode(',',$file_info['file'])[1]));

		return response()->json($file_info);

	}

	public function create_file_controller(Request $request){

		$file_info = array(

			'filename'		=>	$request->input('filename'), 
			'path_folder'	=> 	$request->input('path_folder'),
			'is_folder' 	=> 	$request->input('folder')
		);

		if ($file_info['is_folder'] == "false") {
				$file_name = explode('/', $file_info['path_folder']);
				$file_info['path_folder'] = str_replace("/".last($file_name),"", $file_info['path_folder']);
		}

		$files = scandir($file_info['path_folder'].'/'); 

		foreach ($files as $key => $value) { 
			$path = realpath($file_info['path_folder'].'/'.DIRECTORY_SEPARATOR.$value); 
			$filename = explode('/', $path); 
			if(!is_dir( $path )) { 
				if (last($filename) == $file_info['filename']) {
					return response()->json(['filename' => 'Duplicate']); 
				}
			}
	   	}  

		$my_file = $file_info['path_folder'] . '/' . $file_info['filename'];

		if (strtolower($file_info['filename']) == '.xml') {

			return response()->json(['filename' => 'Error']);

		}

		fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

		return response()->json($file_info);
	}

	public function save_file_controller(Request $request){

		$file_info = array(
			'path' 		=> $request->input('path'),
			'content' 	=> $request->input('content')
		);

		$file = fopen($file_info['path'], "w"); 
		$pieces = str_split($file_info['content'], 1024 * 4);
		foreach ($pieces as $piece) {
		    fwrite($file, $piece, strlen($piece));
		} 
		fclose($file); 

		return response()->json($file_info);
	}

	public function delete_file_controller(Request $request){ 
		$file_info = array( 
			'path_folder'	=> $request->input('path_folder'), 
		);
		unlink($file_info['path_folder']);

		return response()->json($file_info); 
	}

	public function content_change_controller(Request $request){

		$file_info = array( 
			'path'	=> $request->input('path'), 
		); 

		$file = file_get_contents($file_info['path']);

		return response()->json(['contents'	=> $file]); 

	} 

	public function download_project_controller(Request $request){

		$id = $request->input('id'); 
	    $mobileapp = MobileApplication::find($id);

		$path = storage_path('app/public/'."app-assets/".$mobileapp->user_id."/".$mobileapp->id);

		$path_two = storage_path('app/public/basic-app-deploy/kvsfggva@sharklasers.com/'); 

		$project_path = array(
			'project_path' 	=> $path, 
			'deploy_path'	=> '/var/www/html/SerinoMobileAppBuilder/public/'
		);


		$project_name = explode("/", $project_path['project_path']);

		if (file_exists($project_path['deploy_path'].last($project_name).'.zip')) {

    		unlink($project_path['deploy_path'].last($project_name).'.zip'); 
		}   

		Zipper::make($project_path['deploy_path'].$mobileapp->name.'_'.last($project_name).'.zip')->add($project_path['project_path'])->close();

		return response()->json(['project'	=> 'http://uiserver/'.$mobileapp->name.'_'.last($project_name).'.zip']); 
	}

	public function rename_file_controller(Request $request){

		$file_info = array(

			'path' 		=> 	$request->input('path'),
			'filename'	=>	'/var/www/html/SerinoMobileAppBuilder/storage/app/public/app-assets/kvsfggva@sharklasers.com/7/XML_Template(Single view)/'.$request->input('filename')

		);
		rename($file_info['path'], $file_info['filename']); 

        return response()->json($file_info);

	}

	public function get_all_image_controller(Request $request){
		
		$mobileapp = MobileApplication::find($request->input('id'));

		$path = storage_path('app/public/'."app-assets/".$mobileapp->user_id."/".$mobileapp->id."/");

		$array  =$this->basic_builder_images($path);

		$result = array_flatten($array);
		
		return response()->json($result); 
	}

	function basic_builder_images($dir = '',$result = array()){ 
		$files = scandir($dir);  
		foreach ($files as $key => $value) { 
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);  
			$filename = explode('/', $path); 
			if(!is_dir( $path )) { 
				$path_data = str_replace("/var/www/html/SerinoMobileAppBuilder","",$path);
                $path_data = str_replace("app/public/","",$path_data); 
				$ext = pathinfo(last($filename), PATHINFO_EXTENSION);
				switch (strtolower($ext)) {
					case 'png':
					case 'bmp':
					case 'gif':
					case 'jpg':
					case 'jpeg':
						$result[] = array( 'path'	=> $path_data );	
					break; 
					default:
					break;
				} 
			}
			else if ($value != '.' && $value != '..') { 
				$result[last($filename)] = array(); 
				$result[last($filename)]['folder_path'] = array();
				$result[last($filename)] =  $this->basic_builder_images($path, $result[last($filename)]); 
			} 
		} 
		return $result;
	}

	function array_flatten($array) {

	   $return = array();
	   foreach ($array as $key => $value) {
	       if (is_array($value)){ $return = array_merge($return, $this->array_flatten($value));}
	       else {$return[$key] = $value;}
	   }
	   return $return;

	} 

	public function component_list_controller($dir = '/var/www/html/SerinoMobileAppBuilder/public/basic-components/'){

		$files = scandir($dir); 
		$results = array();
		$results_two = array();  

		foreach ($files as $key => $value) {  
			if ($value != '.' && $value != '..') {
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value); 
				$results[] = $path;    
			} 
		} 

		foreach ($results as $key => $value) { 
			$files_two = scandir($value);
			foreach ($files_two as $key2 => $value2) {
				if ($value2 != '.' && $value2 != '..') {
					$value_sub = str_replace("/var/www/html/SerinoMobileAppBuilder/public","",$value);
					$results_two[$value][] = $this->get_component_description($value_sub.'/'.$value2);  
				}  	
			}  
		}  

		return response()->json($results_two);
	}
	function get_component_description($value){
		$desc = explode('/', $value);

		if(strtolower(last($desc)) == 'defs.json') { 

			$defs_list = file_get_contents('http://uiserver'.$value);

			return json_decode($defs_list)->description . ' || ' . json_decode($defs_list)->code; 
		}

		return $value; 
	}

}