<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form action="-" id="form-import" method="POST" data-parsley-validate>
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-title">-</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Panduan Import Excel</h4>
            </div>
            <div class="col-md-12">
              <p>Unduh berkas excel untuk format import terlebih dahulu <a id="import-download-link" href="-">disini</a>, lalu isi tiap baris pada berkas tersebut dengan aturan yang ada di bawah ini.
                Lalu berkas tersebut bisa di unggah dengan menekan tombol di bawah.
              </p>
            </div>
            <div class="col-md-12">
              <h4>Aturan :</h4>
              <div id="import-guide">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12">
                  <input type="file" class="form-control" name="import">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Import</button>
        </div>
      </div>
    </form>
  </div>
</div>
  {{-- 
    @component('components.import-modal') 
    @endcomponent
    setImportTitle('Test Title');
    setImportSubmitLink('{{ url("/-/import") }}');
    setImportFormatLink('{{ url("format-import/") }}');
    setImportGuide([
      {col: 'NO', content: 'Nomor baris'},
      {col: 'TANGGAL LAHIR', content: 'Harus dalam format tanggal-bulan-tahun (d-m-Y)'},
      {col: 'HUBUNGAN KELUARGA', content: 'Harus diantara nilai berikut (kepala, suami, istri, anak, lainnya) menggunakan huruf kecil'},
    ]);
  --}}
<script>
  function setImportTitle(title) {
    $('#modal-import-title').text(title);
  }

  function setImportSubmitLink(link) {
    $('#form-import').attr('action', link);
  }

  function setImportFormatLink(link) {
    $('#import-download-link').attr('href', link);
  }

  function setImportGuide(guides) {
    let guideTable = $('#import-guide');
    let table = '<table class="table table-striped"><tbody>';
    for (let i = 0; i < guides.length; i++) {
      table = table + `
        <tr>
          <td><strong>${guides[i].col}</strong></td>
          <td>${guides[i].content}</td>
        </tr>
      `;
    }
    table = table + '</tbody></table>';
    guideTable.append(table);
  }
</script>