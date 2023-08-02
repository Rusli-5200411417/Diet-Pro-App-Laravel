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
    <tbody>
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
                    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-hapus{{$makanan->id}}">Hapus</button>
                </div>                
            </td>
            @include('modal.edit')
            @include('modal.hapus')
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination justify-content-center mt-4">
    {{ $makanans->appends(['keyword' => request('keyword')])->links('pagination::bootstrap-5') }}
</div>

    
                    
                              
