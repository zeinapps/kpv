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
            <a href="/urunan/create" class="btn btn-primary">Buat urunan</a><br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Urunan
                </div>
                <!-- /.panel-heading -->
                
                <div class="panel-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-exclamation-triangle"></i>
                                @if(strpos($error,'belum dibuat')){{$error}} <a href="/jenis_iuran/create" class="btn btn-primary">Buat jenis iuran?</a>@else{{ $error }}@endif
                            </div>
                        @endforeach
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Wajib</th>
                                    <th>per KK</th>
                                    <th>jumlah</th>
                                    <th>keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item['judul'] }}</td>
                                    <td>{{ $item['is_wajib'] }}</td>
                                    <td>{{ $item['is_per_kk'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                    <td>
                                        <a href="/urunan/edit/{{ $item['id'] }}" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="/urunan/delete/{{ $item['id'] }}" class="btn btn-warning btn-xs">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            {!! $pagination->render() !!}
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
@endsection