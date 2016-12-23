 @extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Warga</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">{{Auth::user()->role}}
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-exclamation-triangle"></i>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <form role="form" method="post" action="/user" id="register-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="@if(isset($id)){{$id}}@endif"/>
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Nama</label>
                            <input class="form-control" id="" type="text" name="nama" value="@if(isset($nama)){{$nama}}@else{{Request::old('nama')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Username</label>
                            <input class="form-control" id="" type="text" name="username" value="@if(isset($username)){{$username }}@else{{Request::old('usernam')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">RT</label>
                            @if(Auth::user()->is('administrator')) 
                                <select id="rt_id" name="rt" class="form-control">
                                    <option value="1">RT 1</option>
                                    <option value="2">RT 2</option>
                                    <option value="3">RT 3</option>
                                    <option value="4">RT 4</option>
                                    <option value="5">RT 5</option>
                                </select>
                            @else 
                                <input class="form-control" id="rt_id_input" type="text" disabled="" value="@if(isset($rt)){{$rt}}@endif">
                            @endif
                            
                            
                        </div>
                        @if($password_required)
                        <div class="form-group">
                            <label class="control-label" for="inputError">Password</label>
                            <input class="form-control" id="password" type="password" name="password" value="{{Request::old('password')}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Konfirmasi Password</label>
                            <input class="form-control" id="" type="password" name="password_confirmation"  value="{{Request::old('password')}}">
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Email</label>
                            <input class="form-control" id="" type="email" name="email" value="@if(isset($email)){{$email}}@else{{Request::old('email')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Blok</label>
                            <input class="form-control" id="" type="text" name="blok" value="@if(isset($blok)){{$blok}}@else{{Request::old('blok')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Tempat Lahir</label>
                            <input class="form-control" id="" type="text" name="tempat_lahir" value="@if(isset($tempat_lahir)){{$tempat_lahir}}@else{{Request::old('tempat_lahir')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Tanggal Lahir</label>
                            <div class="form-control">
                            <select id="tgl">
                            </select>
                            <select id="bln">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <input class="" type="text" placeholder="Tahun" id="thn" name="thn"/>
                            <input class="form-control" id="tanggal_lahir" type="hidden" name="tanggal_lahir" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Nomor KTP</label>
                            <input class="form-control" id="" type="text" name="ktp" value="@if(isset($ktp)){{$ktp}}@else{{Request::old('ktp')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Nomor HP GSM/WhatsApp</label>
                            <input class="form-control" id="" type="text" name="hp" value="@if(isset($hp)){{$hp}}@else{{Request::old('hp')}}@endif">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Anggota keluarga dari</label>
                            <select id="keluarga_dari" name="keluarga_dari">
                                <option value="0">Tidak Ada</option>
                                @foreach ($kepalakeluarga as $item)
                                    <option value="{{$item->id}}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputError">Tinggal Menetap</label>
                            <select id="is_menetap" name="is_menetap" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="inputError">Status Keluarga</label>
                            <select id="status_keluarga" name="status_keluarga" class="form-control">
                                <option value="1">Kepala Keluarga</option>
                                <option value="2">Istri / Suami</option>
                                <option value="3">Anak</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="inputError">Agama</label>
                            <select id="agama" name="agama" class="form-control">
                                <option value="1">Islam</option>
                                <option value="2">Kristen</option>
                                <option value="3">Katolik</option>
                                <option value="4">Hindu</option>
                                <option value="5">Budha</option>
                                <option value="6">Konghuchu</option>
                                <option value="99">Aliran Kepercayaan</option>
                            </select>
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
    
$("#bln").change(function(){
    $( "#tanggal_lahir" ).val( $('#thn').val() +'-'+$( "#bln" ).val()+ '-'+$( "#tgl" ).val()); 
});

$("#tgl").change(function(){
    $( "#tanggal_lahir" ).val( $('#thn').val() +'-'+$( "#bln" ).val()+ '-'+$( "#tgl" ).val()); 
});

$('#thn').on("input", function() {
    $( "#tanggal_lahir" ).val(this.value+'-'+$( "#bln" ).val()+ '-'+$( "#tgl" ).val());
});



$(function () {
    var max_tgl = 31;
    for(var i=1; i<=max_tgl; i++){
        var tgl = i;
        if(tgl<10){
            tgl = '0'+i;
        }
        $("#tgl").append('<option value="'+tgl+'">'+i+'</option>');
    }
    var d = new Date("@if(isset($tanggal_lahir)){{$tanggal_lahir}}@else{{Request::old('tanggal_lahir')}}@endif");
    var day = d.getDate()-1;
    var month = d.getMonth();
    var year = parseInt(d.getFullYear()) || 1900;
    
    $('#thn').val(year);
    
    $('#bln option').eq(month).prop('selected', true);
    $('#tgl option').eq(day).prop('selected', true);
    
   $( "#tanggal_lahir" ).val( $('#thn').val() +'-'+$( "#bln" ).val()+ '-'+$( "#tgl" ).val()); 
   
   var rt_id = @if(isset($rt)){{$rt}}@else{{Request::old('rt')}}@endif;
   var keluarga_dari = @if(isset($keluarga_dari)){{$keluarga_dari}}@else{{Request::old('keluarga_dari')}}@endif;
   var is_menetap = @if(isset($is_menetap)){{$is_menetap}}@else{{Request::old('is_menetap')}}@endif;
   var status_keluarga = @if(isset($status_keluarga)){{$status_keluarga}}@else{{Request::old('status_keluarga')}}@endif;
   var agama = @if(isset($agama)){{$agama}}@else{{Request::old('agama')}}@endif;
   $('#rt_id option[value='+ rt_id +']').attr('selected','selected');
   $('#keluarga_dari option[value='+ keluarga_dari +']').attr('selected','selected');
   $('#is_menetap option[value='+ is_menetap +']').attr('selected','selected');
   $('#status_keluarga option[value='+ status_keluarga +']').attr('selected','selected');
   $('#agama option[value='+ agama +']').attr('selected','selected');
//   $('#keluarga_dari option').eq(keluarga_dari).prop('selected', true);
//   $('#is_menetap option').eq(is_menetap).prop('selected', true);
//   $('#status_keluarga option').eq(status_keluarga).prop('selected', true);
//   $('#agama option').eq(agama).prop('selected', true);
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
                    nama: "required",
                    username : "required",
                    password : "@if($password_required){{$password_required}}@endif",
                    email: {
                        email: true
                    },
                    password_confirmation: { 
                        equalTo: "#password",
                    },
                    thn:{
                        minlength: 4,
                        maxlength: 4,
                        number: true
                    },
                    hp: {
                        number:true,
                        minlength:10, 
                        maxlength:12
                    }
                    
                },
                highlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
                }, 
                unhighlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").removeClass('has-error').addClass('has-success'); 
                },
                messages: {
                    nama: {
                        required: "Nama Wajib diisi"
                    },
                    username: {
                        required: "Username Wajib diisi"
                    },
                    password: {
                        required: "Password Wajib diisi"
                    },
                    password_confirmation: {
                        equalTo: "Ulangi password yang sama"
                    },
                    email: {
                        email: "Email Tidak Valid"
                    },
                    hp: {
                        number:"Masukksn angka contoh 088123456789",
                        minlength:"Nomer HP GSM minimal 10 angka", 
                        maxlength:"Nomer HP GSM maximal 12 angka"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
                
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