@extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Bayar Iuran</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Jenis Iuran
                </div>
                <!-- /.panel-heading -->
                
                <div class="panel-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-exclamation-triangle"></i>
                                @if(strpos($error,'belum dibuat')){{$error}} <a href="/iuran/create" class="btn btn-primary">Buat iuran?</a>@else{{ $error }}@endif
                            </div>
                        @endforeach
                    @endif
                    <div class="panel-body">
                        <form id="cari-form" method="GET" action="/bayar_iuran" >
                        <div class="col-xs-3">
                        <select id="is_bayar" name="is_bayar" class="form-control">
                            <option value="1">Semua</option>
                            <option value="2">Sudah Bayar</option>
                            <option value="3">Belum Bayar</option>
                        </select>
                        </div> 
                        <div class="col-xs-3">
                        <select id="bln" name="bulan" class="form-control">
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
                        </div> 
                        <div class="col-xs-2">
                        <input class="form-control" type="text" placeholder="Tahun" id="thn" name="tahun" value="{{$tahun}}"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                        </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Bulan</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $Bulan .' '.$tahun }}</td>
                                    <td><div class="@if($item['jumlah']) {{ 'alert alert-success' }} @else {{ 'alert alert-danger' }} @endif" style="padding: 5px; margin-bottom: 5px">{{ $item['jumlah'] ? 'Sudah' : 'Belum' }}</div></td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    
                                    <td>
                                        @if($item['jumlah'] == 0)
                                        <a href="/bayar_iuran/create/{{ $item['id'] }}/{{ $iuran_id }}" class="btn btn-info btn-xs">Bayar</a>
                                         @else
                                        <a href="/bayar_iuran/delete/{{ $item['id'] }}/{{ $iuran_id }}" class="btn btn-danger btn-xs">Hapus</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            @if($data)
                                {!! $pagination->render() !!}
                            @endif
                        </div> 
                        <div class="col-md-4">
                    
                </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
</div>

<script src="/js/jquery.validate.min.js"></script>
<script>
    
$(function () {
    
    var month = @if(isset($bulan)){{$bulan}}@else{{Request::old('bulan')}}@endif;
    $('#bln option[value='+ month +']').attr('selected','selected');
});

$(function () {
    var is_bayar = @if(isset($is_bayar)){{$is_bayar}}@else{{Request::old('is_bayar')}}@endif;
    $('#is_bayar option').eq(is_bayar-1).prop('selected', true);
});

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
           
            //form validation rules
            $("#cari-form").validate({
                rules: {
                    tahun:{
                        minlength: 4,
                        maxlength: 4,
                        number: true
                    }
                },
                highlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
                }, 
                unhighlight: function (element, errorClass, validClass) { 
                    $(element).parents("div.form-group").removeClass('has-error').addClass('has-success'); 
                },
                messages: {
                },
                submitHandler: function(form) {
                    form.submit();
                },
                success: function() {
//                    $("#tanggal_lahir").prop('disabled', true);
                }
                
                
            });
           
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);


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