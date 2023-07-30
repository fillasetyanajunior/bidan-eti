@extends('Layouts/Main')
@section('tittle', $tittle)

@section('container')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="row mt-2">
                <div class="col-md-3">
                    <form action="{{ route('pasien.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukan nama" name="search"
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="card-tools col-auto ms-auto">
                    <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                        data-bs-target="#modal-report"> tambah data
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" /></svg>
                    </a>
                    <a href="{{ route('pasien.export') }}" class="btn btn-primary d-sm-inline-block"> cetak data
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2">
                            </path>
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pasien.create') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label required">Nama</label>
                                <input type="text" id="name" class="form-control" name="name">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="umur" class="form-label required">Umur</label>
                                        <div class="input-group input-group-flat">
                                            <input type="number" name="umur" id="nik" class="form-control ps-0">
                                        </div>
                                        @error('umur')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="no-telp" class="form-label">Nama suami</label>
                                        <input type="text" class="form-control" id="notelp" name="nm_suami">
                                        <small class="form-hint">jika tidak ada beri tanda -</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="tgl-pemeriksaan" class="form-label">Tgl awal datang</label>
                                    <input type="date" id="tgl_pemeriksaan" name="tgl_awal" class="form-control">
                                    @error('tgl_awal')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="keterangan" class="form-label">Metode</label>
                                    <select class="form-select" name="metode">
                                        <option value="suntik">Suntik</option>
                                        <option value="pil">Pil</option>
                                        <option value="IUD">IUD</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            Simpan data
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Nama suami</th>
                        <th>Tanggal awal datang</th>
                        <th>Metode</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasiens as $pasien)
                    <tr>
                        <td>{{ $pasien->name }}</td>
                        <td>{{ $pasien->umur }}</td>
                        <td>{{ $pasien->nama_suami }}</td>
                        <td>{{ $pasien->tgl_awal }}</td>
                        <td>{{ $pasien->metode }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('pasien.edit', ['pasien' => $pasien->id]) }}"
                                    class="btn btn-primary">edit</a>
                                <a href="{{ route('personals', ['pasien' => $pasien->id]) }}" class="btn btn-info">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-file-plus" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                        </path>
                                        <path d="M12 11l0 6"></path>
                                        <path d="M9 14l6 0"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('personals.show', ['id' => $pasien->id]) }}" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $pasiens->links() }}
        </div>
    </div>
</div>
@endsection
