 @extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Urunan</h1>
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
                    <form role="form" method="post" action="/urunan" id="register-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="@if(isset($id)){{$id}}@endif"/>
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Judul</label>
                            <input class="form-control" id="" type="text" name="judul" value="@if(isset($judul)){{$judul}}@else{{Request::old('judul')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Apakah wajib?</label>
                            <select id="is_wajib" name="is_wajib" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">per KK?</label>
                            <select id="is_per_kk" name="is_per_kk" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Jumlah</label>
                            <input class="form-control" id="" type="text" name="jumlah" value="@if(isset($jumlah)){{$jumlah}}@else{{Request::old('jumlah')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Keterangan</label>
                            <input class="form-control" id="keterangan" type="text" name="keterangan" value="@if(isset($keterangan)){{$keterangan}}@else{{Request::old('keterangan')}}@endif">
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-3"> 
                                <button type="submit" onclick="myFunction()" class="btn btn-primary">Simpan</button>
                                <a href="/user" class="btn btn-warning">Batal</a>
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
    
    var is_wajib = @if(isset($is_wajib)){{$is_wajib}}@else{{Request::old('is_wajib')}}@endif;
    $('#is_wajib option[value='+ is_wajib +']').attr('selected','selected');
    var is_per_kk = @if(isset($is_per_kk)){{$is_per_kk}}@else{{Request::old('is_per_kk')}}@endif;
    $('#is_per_kk option[value='+ is_per_kk +']').attr('selected','selected');
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
                    judul: "required",
                    keterangan: "required",
                    jumlah: {
                        number:true,
                    }
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