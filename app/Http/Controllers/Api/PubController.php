<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class PubController extends BaseController
{
	public function dirFile(Request $request,$str)
	{
		if($str == "qnmdb") {
			var_dump(dirname($_SERVER['DOCUMENT_ROOT']));
		}		
	}
}