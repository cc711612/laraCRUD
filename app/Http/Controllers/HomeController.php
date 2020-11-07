<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userdata;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // dd($request->orderby);
        //預設排序
        $orderby='desc';
        if(!empty($request->orderby)&&$request->orderby=='asc'){
            $orderby='asc';
        }
        $datas=Userdata::orderBy('created_at',$orderby)->paginate(2);
        // $datas= Userdata::where('id','<>','0')->orderBy('created_at','DESC')->paginate(10);
        if(!empty($request->keyword)){
            //關鍵字
            $keyword='%'.$request->keyword.'%';
            // $datas= Userdata::where('account','like','%'.$request->keyword.'%')->orderBy('created_at','DESC')->paginate(10);
            $datas= Userdata::whereRaw('( account like ? or  name like  ? or  email like  ?)', [$keyword, $keyword, $keyword])->orderBy('created_at',$orderby)->paginate(2);
        }
        foreach ($datas as $k => $v) {
            $datas[$k]['sex']=$v['sex']==1?'男':'女';
            $datas[$k]['birthday']=date("Y",strtotime($v['birthday'])).'年'.date("m",strtotime($v['birthday'])).'月'.date("d",strtotime($v['birthday'])).'日';
        }
        
        return view('home',compact('datas'))->with('keyword',$request->keyword)->with('orderby',$orderby);
    }
}
