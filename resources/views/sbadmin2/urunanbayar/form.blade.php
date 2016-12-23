 @extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Jenis Iuran</h1>
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
                    <form role="form" method="post" action="/jenis_iuran" id="register-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="@if(isset($id)){{$id}}@endif"/>
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Nama</label>
                            <input class="form-control" id="nama_iuran" type="text" name="nama_iuran" value="@if(isset($nama_iuran)){{$nama_iuran}}@else{{Request::old('nama_iuran')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Jumlah</label>
                            <input class="form-control" id="inputSuccess" type="text" name="jumlah" value="@if(isset($jumlah)){{$jumlah}}@else{{Request::old('jumlah')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Keterangan</label>
                            <input class="form-control" id="inputSuccess" type="text" name="keterangan" value="@if(isset($keterangan)){{$keterangan}}@else{{Request::old('keterangan')}}@endif">
                        </div>
                       
                        
                        <div class="row">
                            <div class="col-sm-3"> 
                                <button type="submit" onclick="" class="btn btn-primary">Simpan</button>
                                <a href="/jenis_iuran" class="btn btn-warning">Batal</a>
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
                    nama_iuran:{
                        noSpace: true,
                        required:true
                    },
                    jumlah:{
                        number: true,
                        required:true
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
$('#nama_iuran').keypress(function( e ) {    
    if(e.which ===32 )
        return false;
});
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