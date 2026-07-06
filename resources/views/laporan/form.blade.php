@if (optional($laporan)->status === 'revisi' && optional($laporan)->catatan_verifikator)
    <div class="alert alert-warning full" style="margin-bottom: 18px;">
        <strong>⚠️ Catatan Revisi dari Verifikator:</strong><br>
        {{ $laporan->catatan_verifikator }}
    </div>
@endif

<div class="form-grid">
    <div class="full">
        <label>Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', optional($laporan)->nama_kegiatan) }}" placeholder="Masukkan nama kegiatan" required>
    </div>
    <div>
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', optional($laporan)->tanggal ?? now()->toDateString()) }}" required>
    </div>
    <div>
        <label>Jam</label>
        <input type="time" name="jam" value="{{ old('jam', optional($laporan)->jam) }}" required>
    </div>
    <div class="full">
        <label>Tempat</label>
        <input type="text" name="tempat" value="{{ old('tempat', optional($laporan)->tempat) }}" placeholder="Masukkan tempat kegiatan" required>
    </div>
    <div class="full">
        <label>Upload Dokumen / Gambar / Video</label>
        <input type="file" name="dokumen[]" multiple accept=".png,.jpg,.jpeg,.pdf,.mp4">
        @if ($laporan && $laporan->files->count())
            <div class="current-files-grid" id="currentFilesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 14px; margin-top: 14px;">
                @foreach ($laporan->files as $file)
                    @php
                        $ext = strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                        $previewUrl = route('files.preview', ['file' => $file->nama_file]);
                        $assetUrl = asset('uploads/' . $file->nama_file);
                    @endphp
                    <div class="file-grid-item" id="file-wrapper-{{ $file->id }}" style="position: relative; width: 100%; aspect-ratio: 1; border-radius: 12px; border: 1px solid var(--line); background: var(--input-bg); box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                        <a href="{{ $previewUrl }}" target="_blank" style="width: 100%; height: 100%; display: flex; flex-direction: column; text-decoration: none; overflow: hidden; border-radius: 12px;" title="{{ $file->nama_file }}">
                            @if($isImage)
                                <img src="{{ $assetUrl }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: rgba(15,118,110,.05); font-size: 32px;">
                                    @if($ext == 'pdf') 📄 @elseif($ext == 'mp4') 🎬 @else 📁 @endif
                                </div>
                                <div style="padding: 6px 8px; background: var(--card); border-top: 1px solid var(--line); font-size: 11px; font-weight: bold; color: var(--ink); text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ strtoupper($ext) }}
                                </div>
                            @endif
                        </a>
                        <button type="button" class="btn-remove-file" onclick="removeFile({{ $file->id }})" title="Hapus file ini" style="position: absolute; top: -6px; right: -6px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10; padding: 0;">&times;</button>
                    </div>
                @endforeach
            </div>
            <script>
                function removeFile(fileId) {
                    if(confirm('Hapus file ini? File akan benar-benar terhapus setelah Anda menyimpan laporan.')) {
                        document.getElementById('file-wrapper-' + fileId).style.display = 'none';
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'delete_files[]';
                        input.value = fileId;
                        document.getElementById('currentFilesContainer').appendChild(input);
                    }
                }
            </script>
        @endif
        <small class="field-help">
            Format file: PNG, JPG, PDF, dan MP4. Ukuran tiap file maksimal 500 MB dan bisa upload beberapa file sekaligus.
            @if ($laporan)
                <br><em>File baru yang diupload akan ditambahkan ke daftar file Anda. Klik tanda silang (x) pada file lama jika ingin menghapusnya.</em>
            @endif
        </small>
    </div>
</div>
