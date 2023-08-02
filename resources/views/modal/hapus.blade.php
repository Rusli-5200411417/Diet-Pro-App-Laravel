<!-- Modal -->
<div class="modal fade" id="modal-hapus{{$makanan->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda ingin Mmenghapus data {{$makanan->Nama_Bahan}}</p>
            </div>
            <div class="modal-footer right-content-between">
                <form action="{{route('makanan.hapus', ['id'=>$makanan->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



