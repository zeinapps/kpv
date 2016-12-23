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
            <a href="/jenis_iuran/create" class="btn btn-primary">Buat jenis iuran</a><br><br>
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
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item['nama_iuran'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                    
                                    <td>
                                        <a href="/jenis_iuran/edit/{{ $item['id'] }}" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="/jenis_iuran/delete/{{ $item['id'] }}" class="btn btn-warning btn-xs">Delete</a>
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