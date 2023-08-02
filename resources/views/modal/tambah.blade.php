<form action="{{ route('makanan.tambah') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="">Nama Bahan</label>
                  <input type="text" class="form-control" id="Nama_Bahan" placeholder="Nama Bahan" name="Nama_Bahan" >
                </div>
                <div class="form-group">
                  <label for="Ukuran_Porsi">Ukuran Porsi</label>
                  <input type="Ukuran_Porsi" class="form-control" id="Ukuran_Porsi" name="Ukuran_Porsi">
                </div>
                <div class="form-group">
                  <label for="Takaran">Takaran</label>
                  <input type="Takaran" class="form-control" id="Takaran"  name="Takaran">
                </div>
                <div class="form-group">
                  <label for="Energi_kkal">Energi(kkal)</label>
                  <input type="Energi_kkal" class="form-control" id="Energi_kkal"  name="Energi_kkal">
                </div>
                <div class="form-group">
                  <label for="Protein_g">Protein(g)</label>
                  <input type="Protein_g" class="form-control" id="Protein_g"  name="Protein_g">
                </div>
                <div class="form-group">
                    <label for="Lemak_g">Lemak(g)</label>
                    <input type="Lemak_g" class="form-control" id="Lemak_g"  name="Lemak_g">
                </div>
                <div class="form-group">
                    <label for="KH_g">KH(g)</label>
                    <input type="KH_g" class="form-control" id="KH_g" name="KH_g">
                </div>
                <div class="form-group">
                  <label for="Serat_Total_g">Serat Total(g)</label>
                  <input type="Serat_Total_g" class="form-control" id="Serat_Total_g"  name="Serat_Total_g>
              </div>
              <div class="form-group">
                <label for="Natrium_mg">Natrium(mg)</label>
                <input type="Natrium_mg" class="form-control" id="Natrium_mg"  name="Natrium_mg">
              </div>
              <div class="form-group">
                <label for="Kalium_mg">Kaliut(mg)</label>
                <input type="Kalium_mg" class="form-control" id="Kalium_mg"  name="Kalium_mg">
              </div>
              <div class="form-group">
                <label for="Gula_Total_g">Gula Total(g)</label>
                <input type="Gula_Total_g" class="form-control" id="Gula_Total_g"  name="Gula_Total_g">
              </div>
              <div class="form-group">
                <label for="Jenis">Jenis</label>
                <input type="Jenis" class="form-control" id="Jenis"  name="Jenis">
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
      </div>
          </div>
          </div>
        </div>
    </div>
  </form>