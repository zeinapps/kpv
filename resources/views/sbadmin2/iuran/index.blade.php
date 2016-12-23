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
            <a href="/iuran/create" class="btn btn-primary">Buat iuran</a><br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Iuran
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
                                    <th>Bulan</th>
                                    <th>Komponen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $Bulan[$item['bulan']].' '.$item['tahun'] }}</td>
                                    <td>
                                        <?php $komponen = $item['komponen'];?>
                                        @foreach ( $komponen as $ite)
                                        <div class="alert alert-info" style="padding: 5px; margin-bottom: 5px">{{ $ite['nama_iuran'].' : '. $ite['jumlah'] }}</div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="/iuran/edit/{{ $item['id'] }}" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="/iuran/delete/{{ $item['id'] }}" class="btn btn-warning btn-xs">Delete</a>
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