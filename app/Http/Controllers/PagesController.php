<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Hello From PagesController!';
        // Method ONE to pass a variable
        // return view('pages.index',compact('title'));

        // Method TWO to pass a variable
        return view('pages.index')->with('title',$title);

         
    }    

    public function about(){
         
         $title = 'About us!';
       
        return view('pages.about')->with('title',$title);
    }

    public function services(){
        $data = array(
            'title'=>'Services',
            'services'=>['WEB Design','Programming','SEO']

        );
        return view('pages.services')->with($data);
    }
}
