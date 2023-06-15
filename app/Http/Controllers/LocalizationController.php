<?php
namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale($request->locale);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $request->locale);
        // return redirect()->back();
        return response()->json(['status' => 'successfuly']);
    }
}
