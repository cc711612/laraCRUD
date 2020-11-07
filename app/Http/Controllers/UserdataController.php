<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use Illuminate\Http\Request;

class UserdataController extends Controller
{
    /**
     * Display a datasing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ADD

        $datas=new Userdata;
        $request->validate([
            'account'=>'required',
            'name'=>'required',
            'sex'=>'required',
            'birthday'=>'required',
            'email'=>'required',
        ]);
        $datas->account=strtolower(request('account'));
        $datas->name=request('name');
        $datas->sex=request('sex');
        $datas->birthday=request('birthday');
        $datas->email=strtolower(request('email'));
        $remark=request('remark');
        if(empty(request('remark'))){
            $remark='';
        }
        $datas->remark=$remark;
        if($datas->save()){
            return redirect()->to('/');
        }
        die('<script>alert("error");history.back();</script>');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Userdata  $userdata
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //api
        $data['status']=false;
        if(empty($request->id)){
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $userdb= Userdata::find($request->id);
        if(empty($userdb)){
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $data=[];
        $data['status']=true;
        $data['id']=$userdb->id;
        $data['account']=$userdb->account;
        $data['name']=$userdb->name;
        $data['sex']=$userdb->sex;
        $data['email']=$userdb->email;
        $data['birthday']=$userdb->birthday;
        $data['remark']=$userdb->remark;
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Userdata  $userdata
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Userdata $userdata)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Userdata  $userdata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        
        $request->validate([
            'account'=>'required',
            'name'=>'required',
            'sex'=>'required',
            'birthday'=>'required',
            'email'=>'required',
            'id'=>'required',
        ]);
        $userdata=Userdata::find($request->id);
        // dd($userdata);
        $userdata->account=strtolower(request('account'));
        $userdata->name=request('name');
        $userdata->sex=request('sex');
        $userdata->birthday=request('birthday');
        $userdata->email=strtolower(request('email'));
        $userdata->remark=request('remark');

        if($userdata->save()){
            return redirect()->to('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Userdata  $userdata
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete
        $userdata=Userdata::find($id);
        // if($userdata->softDeletes()){
        //     return redirect()->to('/');
        // }
        if($userdata->delete()){
            return redirect()->to('/');
        }
    }
    public function export()
    {
        $datas=Userdata::orderBy('created_at','desc')->get();
        $now=date("Y-m-d");
        $table = "<table border='1' wudth='100%' sytle=\"font-family:\"標楷體\"; th {mso-number-format:\@;} td {mso-number-format:\@;}\">
                    <thead>
                        <tr>
                            <th>下載時間</th><td>$now</td>
                        </tr>
                        <tr>
                            <th>編號</th>
                            <th>帳號</th>
                            <th>姓名</th>
                            <th>性別</th>
                            <th>生日</th>
                            <th>信箱</th>
                            <th>備註</th>
                        </tr>
                    </thead><tbody>";
        foreach ($datas as $k => $v) {
            $datas[$k]['sex']=$v['sex']==1?'男':'女';
            $datas[$k]['birthday']=date("Y",strtotime($v['birthday'])).'年'.date("m",strtotime($v['birthday'])).'月'.date("d",strtotime($v['birthday'])).'日';
            $table .= "<tr>
                            <th align='left'>" . $datas["$k"]['id'] . "</th>
                            <th align='left'>" . $datas["$k"]['account'] . "</th>
                            <th align='left'>" . $datas["$k"]['name'] . "</th>
                            <th align='left'>" . $datas["$k"]['sex'] . "</th>
                            <th align='left'>" . $datas["$k"]['birthday'] . "</th>
                            <th align='left'>" . $datas["$k"]['email'] . "</th>
                            <th align='left'>" . $datas["$k"]['remark'] . "</th>
                            <th align='left'>" . $datas["$k"]['confirmed'] . "</th>
                            <th align='left'>" . $datas["$k"]['createTime'] . "</th>
                            <th align='left'>" . $datas["$k"]['lastLoginTime'] . "</th>
                            <th align='left'>" . $datas["$k"]['IP'] . "</th>
                        </tr>";
        }
        $table .= "</tbody></table>";
        //變更網頁型態－>變成EXCEL下載
        header("Content-type: application/vnd.ms-excel charset=big5\r\n");
        header('Content-Disposition: attachment; filename='.$now.'-member.xls');
        die($table);
    }
}
