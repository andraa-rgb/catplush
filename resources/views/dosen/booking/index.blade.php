<x-app-layout>
    @section('title', 'Booking Konsultasi')

    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">
                💬 Booking Konsultasi
            </h1>
            <p class="text-lg text-gray-600">
                Kelola booking konsultasi dari mahasiswa
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="card-modern">
                <div class="text-3xl mb-2">📋</div>
                <p class="text-sm text-gray-600">Total Booking</p>
                <p class="text-2xl font-black text-primary-700">{{ $bookings->total() }}</p>
            </div>
            <div class="card-modern">
                <div class="text-3xl mb-2">⏳</div>
                <p class="text-sm text-gray-600">Menunggu</p>
                <p class="text-2xl font-black text-yellow-600">
                    {{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="card-modern">
                <div class="text-3xl mb-2">✓</div>
                <p class="text-sm text-gray-600">Disetujui</p>
                <p class="text-2xl font-black text-green-600">
                    {{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'approved')->count() }}
                </p>
            </div>
            <div class="card-modern">
                <div class="text-3xl mb-2">✗</div>
                <p class="text-sm text-gray-600">Ditolak</p>
                <p class="text-2xl font-black text-red-600">
                    {{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'rejected')->count() }}
                </p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-8 overflow-x-auto pb-2">
            <a href="{{ route('dosen.booking.index') }}" 
                class="px-6 py-3 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 {{ request()->query('status') === null ? 'btn-primary' : 'btn-outline' }}">
                📋 Semua
            </a>
            <a href="{{ route('dosen.booking.index', ['status' => 'pending']) }}" 
                class="px-6 py-3 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 {{ request()->query('status') === 'pending' ? 'bg-yellow-500 text-white' : 'btn-outline' }}">
                ⏳ Menunggu
            </a>
            <a href="{{ route('dosen.booking.index', ['status' => 'approved']) }}" 
                class="px-6 py-3 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 {{ request()->query('status') === 'approved' ? 'bg-green-500 text-white' : 'btn-outline' }}">
                ✓ Disetujui
            </a>
            <a href="{{ route('dosen.booking.index', ['status' => 'rejected']) }}" 
                class="px-6 py-3 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 {{ request()->query('status') === 'rejected' ? 'bg-red-500 text-white' : 'btn-outline' }}">
                ✗ Ditolak
            </a>
        </div>

        @if($bookings->count() > 0)
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="card-modern hover-lift group relative overflow-hidden">
                        <!-- Status Indicator -->
                        <div class="absolute top-0 right-0 h-1 w-32 bg-gradient-to-r
                            @if($booking->status === 'pending')
                                from-yellow-400 to-yellow-600
                            @elseif($booking->status === 'approved')
                                from-green-400 to-green-600
                            @else
                                from-red-400 to-red-600
                            @endif"></div>

                        <!-- Header Section -->
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-6 gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        {{ $booking->nama_mahasiswa }}
                                    </h3>
                                    @if($booking->nim_mahasiswa)
                                        <span class="badge-purple">{{ $booking->nim_mahasiswa }}</span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">📧 {{ $booking->email_mahasiswa }}</span>
                                    <span class="flex items-center gap-1">📅 {{ $booking->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <span class="px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap
                                @if($booking->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'approved')
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800
                                @endif">
                                @if($booking->status === 'pending')
                                    ⏳ Menunggu Konfirmasi
                                @elseif($booking->status === 'approved')
                                    ✓ Disetujui
                                @else
                                    ✗ Ditolak
                                @endif
                            </span>
                        </div>

                        <!-- Schedule Info -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 p-4 bg-gradient-light rounded-lg border border-purple-200">
                            <div>
                                <p class="text-xs font-bold text-primary-700 uppercase tracking-wider">📅 Tanggal</p>
                                <p class="text-lg font-bold text-gray-900 mt-1">
                                    {{ $booking->tanggal_booking->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-primary-700 uppercase tracking-wider">⏰ Waktu</p>
                                <p class="text-lg font-bold text-gray-900 mt-1">
                                    {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-primary-700 uppercase tracking-wider">⏱️ Durasi</p>
                                <p class="text-lg font-bold text-gray-900 mt-1">
                                    @php
                                        try {
                                            $jamMulai = (string)$booking->jam_mulai;
                                            $jamSelesai = (string)$booking->jam_selesai;
                                            
                                            // Parse times more safely
                                            $start = \DateTime::createFromFormat('H:i:s', $jamMulai) ?: \DateTime::createFromFormat('H:i', $jamMulai);
                                            $end = \DateTime::createFromFormat('H:i:s', $jamSelesai) ?: \DateTime::createFromFormat('H:i', $jamSelesai);
                                            
                                            if ($start && $end) {
                                                $diff = $end->diff($start);
                                                $duration = ($diff->h * 60) + $diff->i;
                                                echo $duration . ' menit';
                                            } else {
                                                echo '-';
                                            }
                                        } catch (\Exception $e) {
                                            echo '-';
                                        }
                                    @endphp
                                </p>
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-6">
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">📝 Topik Konsultasi</p>
                            <p class="text-gray-800 leading-relaxed p-3 bg-gray-50 rounded-lg border border-gray-200">
                                {{ $booking->keperluan }}
                            </p>
                        </div>

                        <!-- Actions -->
                        @if($booking->status === 'pending')
                            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-purple-100">
                                <button type="button" 
                                    class="flex-1 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg transition-all duration-300 active:scale-95 flex items-center justify-center gap-2"
                                    onclick="openApproveModal({{ $booking->id }})">
                                    <span>✓</span>
                                    <span>Setujui Booking</span>
                                </button>
                                <button type="button" 
                                    class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all duration-300 active:scale-95 flex items-center justify-center gap-2"
                                    onclick="openRejectModal({{ $booking->id }})">
                                    <span>✗</span>
                                    <span>Tolak Booking</span>
                                </button>
                            </div>
                        @elseif($booking->status === 'rejected' && $booking->alasan_reject)
                            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                                <p class="text-sm font-bold text-red-900 mb-2">📌 Alasan Penolakan:</p>
                                <p class="text-red-800 leading-relaxed">{{ $booking->alasan_reject }}</p>
                            </div>
                        @elseif($booking->status === 'approved')
                            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                                <p class="text-sm font-bold text-green-900 mb-3">✓ Booking telah dikonfirmasi</p>
                                @if($booking->catatan_dosen)
                                    <div class="mt-3 p-3 bg-white rounded border border-green-200">
                                        <p class="text-xs font-bold text-green-800 uppercase tracking-wider mb-1">📌 Catatan Anda:</p>
                                        <p class="text-sm text-green-700 leading-relaxed">{{ $booking->catatan_dosen }}</p>
                                    </div>
                                @endif
                                <p class="text-xs text-green-700 mt-3">Mahasiswa sudah menerima email notifikasi persetujuan</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 card-modern">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-xl text-gray-600 mb-4">Tidak ada booking konsultasi</p>
                <p class="text-sm text-gray-500">
                    Booking dari mahasiswa akan muncul di sini dan menunggu konfirmasi Anda
                </p>
            </div>
        @endif
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 animate-fade-in">
        <div class="card-modern max-w-md w-full animate-slide-down">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">✓ Setujui Booking</h3>
            <p class="text-gray-600 mb-6">Tambahkan catatan khusus untuk mahasiswa (opsional)</p>
            
            <form id="approveForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan untuk Mahasiswa</label>
                    <textarea name="catatan_dosen" 
                        rows="4"
                        class="input-modern resize-none"
                        placeholder="Contoh: Silakan datang 10 menit lebih awal. Lokasi konsultasi di ruang Lab B301."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Catatan ini akan dikirim dalam email ke mahasiswa</p>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition">
                        Setujui Booking
                    </button>
                    <button type="button" 
                        onclick="closeApproveModal()" 
                        class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 animate-fade-in">
        <div class="card-modern max-w-md w-full animate-slide-down">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">✗ Tolak Booking</h3>
            <p class="text-gray-600 mb-6">Berikan alasan penolakan booking ini kepada mahasiswa</p>
            
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="form-label">Alasan Penolakan</label>
                    <textarea name="alasan_reject" 
                        required 
                        rows="5"
                        class="input-modern resize-none"
                        placeholder="Contoh: Sudah ada jadwal mengajar pada waktu yang sama. Mohon memilih waktu lain."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition">
                        Tolak Booking
                    </button>
                    <button type="button" 
                        onclick="closeRejectModal()" 
                        class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openApproveModal(bookingId) {
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveForm').action = "{{ route('dosen.booking.approve', ':id') }}".replace(':id', bookingId);
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('approveForm').reset();
    }

    function openRejectModal(bookingId) {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectForm').action = "{{ route('dosen.booking.reject', ':id') }}".replace(':id', bookingId);
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectForm').reset();
    }

    // Close modals when clicking outside
    document.getElementById('approveModal').addEventListener('click', function(e) {
        if (e.target === this) closeApproveModal();
    });

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
    </script>
</x-app-layout>
