<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Http\Requests;

// use Storage;
// use File;

use App\Http\Controllers\Controller;
use App\Fileentry;
use Illuminate\Http\Request;
// use Request;
 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileEntryController extends Controller
{
	public function adddd(Request $request)
	{

		// $file = Request::file('filefield');
		// $extension = $file->getClientOriginalExtension();
		// Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		// $entry = new Fileentry();
		// $entry->mime = $file->getClientMimeType();
		// $entry->original_filename = $file->getClientOriginalName();
		// $entry->filename = $file->getFilename().'.'.$extension;

		// $entry->save();

		// return redirect('fileentry');

/////////////////////////////
		// $file = Input::file('attachment1');
		// if (is_array($file) && isset($file['error']) && $file['error'] == 0) {
		// Input::upload('attachment1',path('storage').'attachments/'.$name);
		// }
///////////////////////////////
		$file = $request->file('filefield');
        $extension = $file->getClientOriginalExtension();
        
        $fileName = $file->getFilename().'.'.$extension;
        $filename_path = 'storage/images'.$fileName;
        
//        Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
        // ($request->file('avatar')->getRealPath()
        // Storage::disk('local')->put('/images'.$fileName, file_get_contents($fileName));
        Storage::disk('local')->put('/images'.$fileName, file_get_contents($request->file('filefield')->getRealPath()));


      	$request->session()->flash('login_status', $filename_path);
      	return redirect('/upload-form');

        // return response()->json($filename_path);
	
	}

	public function add(Request $request)
    {

        // $this->validate($request, [

        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        // ]);
        
        

        $image = $request->file('filefield');

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/uploads');

        $image->move($destinationPath, $input['imagename']);


//        $this->postImage->add($input);
        
        $filename_path = $destinationPath.$input['imagename'];
        // return response()->json($filename_path);


      	$request->session()->flash('login_status', $filename_path);
      	return redirect('/upload-form');
    }
}
