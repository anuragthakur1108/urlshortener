<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function home() {
        $urls = DB::table('urlshortner')->get();
        return view('welcome', ['urls' => $urls]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // get previous data.
        $previous_urls = DB::table('urlshortner')->where('user_id', Auth::id())->get();
        return view('home', ['previous_urls' => $previous_urls]);
    }

    public function saveData(Request $request) {
        if ($request->isMethod('post')) {
            $urlinput = $request->input('web_url');
            $id = rand(10000, 99999);
            $shorturl = base_convert($id, 20, 36);
            DB::table('urlshortner')->insert(
                    ['web_url' => $urlinput,
                        'shorten_url' => $shorturl,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'view_count' => "0",
                        'user_id' => Auth::id()
            ]);
//            \Session::flash('success', 'Record successfully added.'); //<--FLASH MESSAGE
            return redirect()->back()->with('success', 'Record successfully added.');
        }
        return redirect()->back()->with('error', 'Something went wrong! Try Later.');
    }

    public function delete_url(Request $request) {
        $url_id = $request->input('url_id');
        $matchThese = ["url_id" => $url_id, 'user_id' => Auth::id()];
        if (DB::table('urlshortner')->where($matchThese)->delete()) {
            return redirect()->back()->with('success', 'Record deleted');
        }
        return redirect()->back()->with('error', 'Something went wrong! Try Later.');
    }

    public function redirectPage($param) {
        $web_url = array();
        $web_url = DB::table('urlshortner')->select('web_url')->where('shorten_url', $param)->get();
        if (!empty($web_url)) {
            if (DB::Table('urlshortner')->where('shorten_url', $param)->Increment('view_count')) {
                return Redirect::to($web_url[0]->web_url)->header('Cache-Control', 'no-store, no-cache, must-revalidate');;
            }
        } else {
            return redirect('/')->with('error', 'Url Does not exist.');
        }
    }

}
