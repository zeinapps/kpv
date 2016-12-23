@extends('sbadmin2.master')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Role {{ $nama }}</h1>
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
                    <form role="form" method="post" action="/user/update/{{ $id }}/role">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label" for="inputSuccess">Adminstrator</label>
                            <input class="form-control" id="inputSuccess" type="checkbox" name="administrator" @if( $administrator ) {{ 'checked' }} @endif>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Ketua RT</label>
                            <input class="form-control" id="inputWarning" type="checkbox" name="ketua_rt" @if( $ketua_rt ) {{ 'checked' }} @endif>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Sekretaris RT</label>
                            <input class="form-control" id="inputWarning" type="checkbox" name="sekretaris_rt" @if( $sekretaris_rt ) {{ 'checked' }} @endif>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Bendahara RT</label>
                            <input class="form-control" id="inputWarning" type="checkbox" name="bendahara_rt" @if( $bendahara_rt ) {{ 'checked' }} @endif>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="inputWarning">Warga RT</label>
                            <input class="form-control" id="inputWarning" type="checkbox" name="warga_rt" @if( $warga_rt ) {{ 'checked' }} @endif>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"> 
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
@endsection