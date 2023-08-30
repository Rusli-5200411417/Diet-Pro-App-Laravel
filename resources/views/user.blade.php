@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

      
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="card-body">
                <table  class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>usia</th>
                    <th>Kebutuhan Kalori</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $d)
                  <tr>
                    <td>{{$d->nama}}</td>
                    <td>{{$d->email}}</td>
                    <td>{{$d->username}}</td>
                    <td>{{$d->usia}}</td>
                    <td>{{$d->kebutuhan_kalori}}</td>
                    {{-- <td>
                      <div class="button">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal-hapus{{$d->id}}">Hapus</button>
                      </div>
                    </td> --}}
                  </tr>
                  {{-- @include('modal.hapus-user') --}}
                  
                  @endforeach
                </table>
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
@endsection