<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD LARAVEL 12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: lightcoral">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                <div>
                    <h3 class="text-center my-4">DATA MOBIL</h3>
                    <hr>
                </div>

                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">

                        <a href="{{ route('mobil.create') }}" class="btn btn-success mb-3">
                            Tambah Data
                        </a>

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>GAMBAR</th>
                                    <th>NAMA</th>
                                    <th>HARGA</th>
                                    <th>STOK</th>
                                    <th style="width: 20%">AKSI</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($mobil as $item)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/mobil/' . $item->gambar) }}"
                                                class="rounded"
                                                style="width:150px; height:100px; object-fit:cover;"
                                                onerror="this.src='https://via.placeholder.com/150x100?text=No+Image'">
                                        </td>

                                        <td>{{ $item->nama }}</td>

                                        <td>
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </td>

                                        <td>{{ $item->stok }}</td>

                                        <td class="text-center">
                                            <form action="{{ route('mobil.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda Yakin ?');">

                                                <a href="{{ route('mobil.show', $item->id) }}"
                                                    class="btn btn-sm btn-dark mb-1">
                                                    SHOW
                                                </a>

                                                <a href="{{ route('mobil.edit', $item->id) }}"
                                                    class="btn btn-sm btn-primary mb-1">
                                                    EDIT
                                                </a>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn btn-sm btn-danger mb-1">
                                                    HAPUS
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="alert alert-danger text-center m-0">
                                                Data mobil belum ada.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $mobil->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'GAGAL',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>

</body>
</html>