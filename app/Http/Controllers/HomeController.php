<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use helpers;
use App\Models\User;
use App\Models\Permutation;
use DB;
use Validator;
use Session;
use Redirect;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }



    public function getCombination(Request $request)
    {
        $req = explode(",", $request->value);
        $get = helpers::permutations($req, 2);
        $result = iterator_to_array($get);
        $getSets = [];
        foreach ($result as $row) {
            $getSets[] = implode("", $row);
        }
        return $getSets;
    }

    public function store(Request $request)
    {
        // print_r($request->all());
        // exit;

        $count=$request->count;
        $getamount=$request->getamount;
        if($count>0)
        {   
            for($i=0; $i<$count; $i++)
            {
                $numb = $request->input('numb'.$i);
                $totalamount = $request->input('totalamount'.$i);

                $permutations = new Permutation;
                $permutations->number = $numb;
                $permutations->totalamount = $totalamount;
                $permutations->amount = $getamount;
                $permutations->save();
            }
            if(!empty($permutations))
            {
                Session::flash('message', "Added Successfully");
                return Redirect('/home');
            }
        }
        else
        {
            Session::flash('messages', "Something Went Wrong Please Try Again Later");
            return Redirect('/home');
        }
    }

}
