<!-- Modal Import Excel -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <form action="{{ route('alumni.import_ajax') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportLabel">Import Data Alumni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    

                    <div class="form-group mb-3">
                        <label>Download Template</label><br>
                        <a href="{{ asset('template_alumni.xlsx') }}" class="btn btn-info btn-sm" download>
                            <i class="fa fa-file-excel"></i> Download
                        </a>
                    </div>

                    <div class="form-group">
                        <label>Pilih File</label>
                        <input type="file" name="file_alumni" id="file_alumni" class="form-control @error('file_alumni') is-invalid @enderror" required>
                        @error('file_alumni')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </form>
</div>
