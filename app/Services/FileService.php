<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;

class FileService{

    public static function createFromBase64($fileString,$folder=null) {
		$exploded = explode(',', $fileString);
		if (count($exploded) < 2) 
			return $fileString;
		$decoded = base64_decode($exploded[1]);
        $extension = "";
		if(str_contains($exploded[0],'jpeg')){
			$extension = 'jpg';
		}
		elseif(str_contains($exploded[0],'png')){
			$extension = 'png';
		}
		elseif(str_contains($exploded[0],'pdf')){
			$extension = 'pdf';
		}
		elseif(str_contains($exploded[0],'msword')){
			$extension = 'doc';
		}
		elseif(str_contains($exploded[0],'vnd.openxmlformats-officedocument.wordprocessingml.document')){
			$extension = 'docx';
		}
        $allowed_extensions = ['jpg','png','pdf','doc','docx'];
        if(!in_array($extension,$allowed_extensions)){
            throw new HttpResponseException(
                response()->json([
                    'status' => 'error',
                    'code'    => 422,
                    'errors'   => [
                        'file' => [
                            "The file must be type of jpg, png, pdf, doc, docx"
                        ]
                    ],
                    'message' => "Validation error",
                ])->setStatusCode(422)
            );
        }
		$fileName = Str::random().'.'.$extension;
        $filePath = ($folder) ? $folder."/".$fileName : $fileName;
		Storage::put('/public/'.$filePath,$decoded);
		return config('app.url').'/storage/'.$filePath;
	}

}