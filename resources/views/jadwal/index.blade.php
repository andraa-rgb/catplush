<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jadwal Dosen</title>
</head>
<body>
    <h1>Daftar Jadwal Dosen</h1>
    <a href="{{ route('jadwal.create') }}">+ Tambah Jadwal</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama Dosen</th>
            <th>Hari</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        @foreach($jadwals as $jadwal)
        <tr>
            <td>{{ $jadwal->id }}</td>
            <td>{{ $jadwal->nama_dosen }}</td>
            <td>{{ $jadwal->hari }}</td>
            <td>{{ $jadwal->jam_mulai }}</td>
            <td>{{ $jadwal->jam_selesai }}</td>
            <td>{{ $jadwal->keterangan }}</td>
            <td>
                <a href="{{ route('jadwal.edit', $jadwal->id) }}">Edit</a>
                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>