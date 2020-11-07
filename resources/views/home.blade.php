@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <label>目前排序:</label>
            <a class="btn btn-info orderby">{{$orderby}}</a>
            <label>匯出內容:</label>
            <a class="btn btn-success" href="{{url("/datas/export")}}">匯出</a>
            <div class="card">
                @foreach($datas as $data)
                    <div class="card-header">
                        #{{$data->id}}.{{$data->name}}({{$data->account}})
                        <div class="text-right">
                            <a name="edit{{$data->id}}" data-id="{{$data->id}}"   class=" btn btn-primary pull-right">Edit</a>
                            <a href="{{url("/datas/delete/")}}/{{$data->id}}" onclick="return confirm('確定要刪除?');"   class=" btn btn-danger pull-right">Delete</a>
                        </div>
                    </div>

                    <div class="card-body">
                            <!-- <div class="alert alert-success" role="alert">
                            </div> -->
                        <label>Birthday:</label>
                        {{$data->birthday}}
                        <br>
                        <label>Email:</label>
                        {{$data->email}}
                        <br>
                        <label>Sex:</label>
                        {{$data->sex}}
                        <br>
                        <label>Remark:</label>
                        {{$data->remark}}
                        <br>
                    </div>
                @endforeach
            </div>
            <div id="pull_right">
                <!--分頁寫法-->
                <div class="pull-right">
                    {!! $datas->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- edit跳窗 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EDIT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action = "{{ url("/datas/edit") }}" method="POST" onsubmit="return checkeditFrm()">
        @csrf
          <div class="modal-body">
            <div class="form-group">
                <label>帳號</label>
                <input type="text" class="edit-account" required="required" name="account">
            </div>
            <div class="form-group">
                <label>姓名</label>
                <input type="text" class="edit-name"required="required" name="name">
            </div>
            <div class="form-group">
                <label>性別</label>
                <input type="radio" class="sex1" id="sex1" required="required" name="sex" value="1">
                <span>男性</span>
                <input type="radio" class="sex0" id="sex0" required="required" name="sex" value="0">
                <span>女性</span>
            </div>
            <div class="form-group">
                <label>生日</label>
                <input type="date" class="edit-birthday" required="required" name="birthday">
            </div>
            <div class="form-group">
                <label>信箱</label>
                <input type="email" class="edit-email" required="required" name="email">
            </div>
            <div class="form-group">
                <label>備註</label>
                <textarea class="form-control edit-remark" name="remark" rows="5"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id" id="id">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function(){
        $("[name*=edit]").click(function(){
            var id= $(this).attr('data-id');
            if(id!=''&&id!=undefined){
                $.ajax({
                  type: 'POST',
                  url: '{{url("/datas/api")}}',
                  data: {
                    id: id,
                    _token:'{{csrf_token()}}',
                  },
                  dataType: 'JSON',
                  success: function(msg) {
                    console.log(msg)
                    if(msg.status){
                        $(".edit-account").val(msg.account);
                        $(".edit-name").val(msg.name);
                        $(".edit-birthday").val(msg.birthday);
                        $(".edit-email").val(msg.email);
                        $(".edit-remark").html(msg.remark);
                        $("#sex"+msg.sex).prop('checked',true);
                        $("#id").val(msg.id);
                        $('#editModal').modal('show');
                    }
                  }
                });
            }
        });
        $(".orderby").click(function(){
            var tmp='';
            var orderby='';
            if($("#keyword").val()!=""){
                tmp='&keyword='+$("#keyword").val();
            }
            if('{{$orderby}}'=='desc'){
                orderby='orderby=asc';
            }else{
                orderby='orderby=desc';
            }
            location.href=orderby+tmp;
        })
    })
    function checkaddFrm()
    {
        var regExp = /^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/;
        var account=$(".add-account").val();
        if(!regExp.test(account)){
            alert("帳號需英數混合");
            return false;
        }
        if(!confirm('以上資料是否正確')){
            return false;
        }
        return true;
    }
    //檢查editfrm
    function checkeditFrm()
    {
        var regExp = /^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/;
        var account=$(".edit-account").val();
        if(!regExp.test(account)){
            alert("帳號需英數混合");
            return false;
        }
        if(!confirm('以上資料是否正確')){
            return false;
        }
        return true;
    }

</script>
@endsection
