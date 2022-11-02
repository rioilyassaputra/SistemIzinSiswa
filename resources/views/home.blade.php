@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >
                    <center>
                    <h2>{{ __('Dashboard Sistem Izin Siswa') }}</h2>
                    </center>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <div class="float-center">
                        <a href="{{ route('izins.index') }}" class="btn btn-md btn-success mb-3">DATA IZIN SISWA</a>
                        </div>
                    </div>
                    
                    
                </div>
        </div>
    </div>

</div>
@endsection
