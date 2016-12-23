@extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Bayar Urunan</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Bayar Urunan
                </div>
                <!-- /.panel-heading -->
                
                <div class="panel-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-exclamation-triangle"></i>
                                @if(strpos($error,'yang dibuat')){{$error}} <a href="/urunan/create" class="btn btn-primary">Buat urunan?</a>@else{{ $error }}@endif
                            </div>
                        @endforeach
                    @endif
                    <div class="panel-body">
                        <form id="cari-form" method="GET" action="/urunan_bayar" >
                            <div class="col-xs-3">
                            <select id="is_bayar" name="is_bayar" class="form-control">
                                <option value="1">Semua</option>
                                <option value="2">Sudah Bayar</option>
                                <option value="3">Belum Bayar</option>
                            </select>
                            </div> 
                            
                            <label for="tags">Judul: </label>
                            <input class="" id="judul" type="text" name="judul" value="@if(isset($judul)){{$judul}}@else{{Request::old('judul')}}@endif">
                          
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="well">
                                <h4>{{ $judul.' =>Rp'.$jumlah }}</h4>
                                <p>{{ $keterangan }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
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
                                    <td><div class="@if($item['jumlah']) {{ 'alert alert-success' }} @else {{ 'alert alert-danger' }} @endif" style="padding: 5px; margin-bottom: 5px">{{ $item['jumlah'] ? 'Sudah' : 'Belum' }}</div></td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    
                                    <td>
                                        @if($item['jumlah'] == 0)
                                        <a href="/urunan_bayar/create/{{ $item['id'] }}/{{ $urunan_id }}" class="btn btn-info btn-xs">Bayar</a>
                                         @else
                                        <a href="/urunan_bayar/delete/{{ $item['id'] }}/{{ $urunan_id }}" class="btn btn-danger btn-xs">Hapus</a>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<script>
    
$(function () {
    var is_bayar = @if(isset($is_bayar)){{$is_bayar}}@else{{Request::old('is_bayar')}}@endif;
    $('#is_bayar option').eq(is_bayar-1).prop('selected', true);
    
    var strjson = '{{$juduls}}';
    var availableJuduls = JSON.parse(strjson.replace(/&quot;/g,'"'));  
    
    $( "#judul" ).autocomplete({
      source: availableJuduls
    });
    
});

var root = '{{url("/")}}';

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