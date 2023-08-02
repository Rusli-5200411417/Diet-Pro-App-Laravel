@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Makanan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('import') }}" method="post" enctype="multipart/form-data" id="csvForm">
                    @csrf
                    <div class="tambah_button mb-4">
                        <div class="btn-group w-25">
                            <label class="btn btn-success col fileinput-button">
                                <i class="fas fa-plus"></i>
                                <span>Import file</span>
                                <input type="file" name="csv_file" accept=".csv" style="display:none;">
                            </label>
                        </div>
                    </div>
                </form>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" id="searchInput" class="form-control"
                                                    placeholder="Cari Nama Bahan...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="searchButton"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-md-6 text-right">
                                            <button type="button " class="btn btn-warning " data-toggle="modal" data-target="#modal-tambah">
                                                + Tambah Data
                                            </button>
                                        </div>
                                    </div>
                                    @include('table') <!-- Include the 'table' blade file -->
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        @include('modal.tambah')
        <!-- /.content-wrapper -->
@endsection
