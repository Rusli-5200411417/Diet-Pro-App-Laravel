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
                                            <form action="{{ route('search') }}" method="get" class="mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="searchInput" class="form-control" name="keyword" placeholder="Cari Nama Bahan..." value="{{ $keyword }}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class = "col-md-6 text-right">
                                            @if ($keyword !=null )
                                                <a href="{{ route('makanan') }}" class="btn btn-success">
                                                    Tampilkan semua data
                                                </a>
                                            @else
                                                
                                            @endif
                                            <button type="button " class="btn btn-warning " data-toggle="modal" data-target="#modal-tambah">
                                                + Tambah Data
                                            </button>
                                            @if ($makanans->count())
                                                <button type="button " class="btn btn-danger " data-toggle="modal" data-target="#modal-hapusSemua">
                                                    Hapus semua data
                                                </button>                                                
                                            @endif
                                        </div>                                        
                                    </div>
                                    <table id="makanan" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Bahan</th>
                                                <th>Ukuran Porsi</th>
                                                <th>Takaran</th>
                                                <th>Energi (kkal)</th>
                                                <th>Protein (g)</th>
                                                <th>Lemak (g)</th>
                                                <th>Karbohidrat (g)</th>
                                                <th>Serat Total (g)</th>
                                                <th>Natrium (mg)</th>
                                                <th>Kalium (mg)</th>
                                                <th>Gula Total (g)</th>
                                                <th>Jenis</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($makanans as $makanan)
                                            <tr>
                                                <td>{{ $makanan->Nama_Bahan }}</td>
                                                <td>{{ $makanan->Ukuran_Porsi }}</td>
                                                <td>{{ $makanan->Takaran }}</td>
                                                <td>{{ $makanan->Energi_kkal }}</td>
                                                <td>{{ $makanan->Protein_g }}</td>
                                                <td>{{ $makanan->Lemak_g }}</td>
                                                <td>{{ $makanan->KH_g }}</td>
                                                <td>{{ $makanan->Serat_Total_g }}</td>
                                                <td>{{ $makanan->Natrium_mg }}</td>
                                                <td>{{ $makanan->Kalium_mg }}</td>
                                                <td>{{ $makanan->Gula_Total_g }}</td>
                                                <td>{{ $makanan->Jenis }}</td>
                                                <td> 
                                                    <div class = "button">
                                                        <button class="btn btn-primary m-2" data-toggle="modal" data-target="#modal-edit{{$makanan->id}}">Edit</button>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal-hapusSemua">Hapus</button>
                                                    </div>                
                                                </td>
                                                @include('modal.edit')
                                                @include('modal.hapus')
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination justify-content-center mt-4">
                                        @if($makanans->count() > 0)
                                            {{ $makanans->links('pagination::bootstrap-5') }}
                                        @endif
                                    </div> <!-- Include the 'table' blade file -->
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
        @include('modal.hapusSemua')
        <!-- /.content-wrapper -->
@endsection
