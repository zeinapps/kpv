 @extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Iuran</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-exclamation-triangle"></i>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <form role="form" method="post" action="/iuran" id="register-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="@if(isset($id)){{$id}}@endif"/>
                        
                        <div class="form-group">
                            <label class="control-label" for="inputError">Bulan</label>
                           
                            <select id="bulan" name="bulan">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <input class="" type="text" placeholder="Tahun" id="thn" name="tahun" value="@if(isset($tahun)){{$tahun}}@else{{Request::old('tahun')}}@endif"/>
                           
                        </div>
                        @foreach ($komponen as $item)
                        <div class="form-group">
                            <input class="" id="inputSuccess" type="checkbox" name="{{$item->nama_iuran}}" checked>
                            <input class="" id="inputSuccess" type="input" name="{{$item->nama_iuran}}_jumlah" value="{{$item->jumlah}}">
                            <label class="" for="inputSuccess">{{$item->nama_iuran .' ==> '.$item->keterangan}}</label>
                        </div>
                        @endforeach
                        
                        <div class="row">
                            <div class="col-sm-3"> 
                                <button type="submit" onclick="" class="btn btn-primary">Simpan</button>
                                <a href="/iuran" class="btn btn-warning">Batal</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<script src="/js/jquery.validate.min.js"></script>
<script>

$(function () {
    var bulan = @if(isset($bulan)){{$bulan}}@else{{Request::old('bulan')}}@endif;
    $('#bulan option').eq(bulan-1).prop('selected', true);
});

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
           
            //form validation rules
            $("#register-form").validate({
                rules: {
                    tahun:{
                        minlength: 4,
                        maxlength: 4,
                        number: true
                    },
                },
                highlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
                }, 
                unhighlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").removeClass('has-error').addClass('has-success'); 
                },
                submitHandler: function(form) {
                    form.submit();
                },
                
                
            });
           
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);

//function myFunction(){
//    $('#tanggal_lahir').removeAttr("disabled");
//}
</script>
<style>
    
    #register-form .form-group label.error {
    color: #FB3A3A;
    display: inline-block;
    margin: 4px 0 5px 0px;
    padding: 0;
    text-align: left;
    width: 100%;
}
</style>
@endsection