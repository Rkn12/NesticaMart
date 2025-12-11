@extends('layouts.app')

@section('title', 'Detail Penjual')
@section('page-title', 'Detail Penjual')

@section('content')
    <div class="card">
        <a href="{{ route('admin.sellers.index') }}" class="btn btn-primary" style="width: fit-content; margin-bottom: 20px; padding: 12px 24px; font-size: 16px;">← Kembali</a>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div>
                <h3 style="margin-bottom: 20px; color: #667eea;">📦 Informasi Toko</h3>
                <div style="display:flex; gap:20px; margin-bottom:20px; align-items:center;">
                    @if($seller->foto_ktp_pic)
                        <div style="text-align:center;">
                            <div style="font-weight:600; margin-bottom:8px;">Foto KTP</div>
                            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($seller->foto_ktp_pic))
                                <img src="{{ Storage::url($seller->foto_ktp_pic) }}" alt="Foto KTP" style="max-width:220px; max-height:160px; object-fit:cover; border-radius:8px; border:1px solid #e6e6e6;" />
                            @else
                                <div style="padding:12px; border:1px solid #f0ad4e; border-radius:6px; background:#fff7e6; color:#8a6d3b;">Foto tidak ditemukan di storage.</div>
                            @endif
                        </div>
                    @endif

                    @if($seller->file_ktp_pic)
                        <div style="text-align:center;">
                            <div style="font-weight:600; margin-bottom:8px;">File KTP</div>
                            @php $ext = strtolower(pathinfo($seller->file_ktp_pic, PATHINFO_EXTENSION)); @endphp
                            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($seller->file_ktp_pic))
                                @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                    <img src="{{ Storage::url($seller->file_ktp_pic) }}" alt="File KTP" style="max-width:220px; max-height:160px; object-fit:cover; border-radius:8px; border:1px solid #e6e6e6;" />
                                @else
                                    <a href="{{ Storage::url($seller->file_ktp_pic) }}" target="_blank" class="btn btn-primary btn-sm">Lihat / Unduh File KTP</a>
                                @endif
                            @else
                                <div style="padding:12px; border:1px solid #f0ad4e; border-radius:6px; background:#fff7e6; color:#8a6d3b;">File tidak ditemukan di storage.</div>
                            @endif
                        </div>
                    @endif
                </div>
                <table style="width: 100%; border-spacing: 0 10px;">
                    <tr>
                        <td style="padding: 8px 0; width: 40%;"><strong>Nama Toko:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->store_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Deskripsi:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->store_description ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Status:</strong></td>
                        <td style="padding: 8px 0;">
                            @if($seller->status == 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif($seller->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Catatan Verifikasi:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->verification_note ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Tanggal Daftar:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            
            <div>
                <h3 style="margin-bottom: 20px; color: #667eea;">👤 Data Pemilik</h3>
                <table style="width: 100%; border-spacing: 0 10px;">
                    <tr>
                        <td style="padding: 8px 0; width: 40%;"><strong>Nama:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->owner_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>NIK:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->nik }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Email:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Telepon:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->phone }}</td>
                    </tr>
                </table>
                
                <h3 style="margin: 30px 0 20px; color: #667eea;">📍 Alamat</h3>
                <table style="width: 100%; border-spacing: 0 10px;">
                    <tr>
                        <td style="padding: 8px 0; width: 40%;"><strong>Provinsi:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->province }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Kota:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->city }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Kecamatan:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->subdistrict }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Kelurahan:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->kelurahan }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>RT/RW:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->rt }}/{{ $seller->rw }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Alamat:</strong></td>
                        <td style="padding: 8px 0;">{{ $seller->address }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($seller->status == 'pending')
            <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h3 style="margin-bottom: 15px;">Verifikasi Penjual</h3>
                <form id="verify-form" method="POST" action="/api/sellers/{{ $seller->id }}/verify" style="display: flex; gap: 15px; align-items: flex-end;">
                    @csrf
                    <input type="hidden" name="status" id="status-input" value="">
                    <div style="flex: 1;">
                        <label><strong>Catatan Verifikasi:</strong></label>
                        <textarea name="verification_note" id="verification_note" class="form-control" rows="3" placeholder="Masukkan catatan verifikasi..."></textarea>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" onclick="submitVerify('approved')" class="btn btn-success">✓ Approve</button>
                        <button type="button" onclick="submitVerify('rejected')" class="btn btn-danger">✗ Reject</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection

@section('extra-scripts')
<script>
    function showToast(message, success = true) {
        let toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.right = '20px';
        toast.style.top = '20px';
        toast.style.padding = '12px 18px';
        toast.style.background = success ? '#27ae60' : '#e74c3c';
        toast.style.color = 'white';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        toast.style.zIndex = 9999;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(()=>toast.remove(), 300); }, 3000);
    }

    async function submitVerify(status) {
        const form = document.getElementById('verify-form');
        if (!form) return;
        const tokenInput = form.querySelector('input[name="_token"]');
        const token = tokenInput ? tokenInput.value : '';
        const note = document.getElementById('verification_note').value;

        const payload = new URLSearchParams();
        payload.append('status', status);
        payload.append('verification_note', note);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: payload.toString()
            });

            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Email Approval Berhasil terkirim', true);
                // reload to reflect updated status
                setTimeout(()=> location.reload(), 900);
            } else {
                const msg = (data && data.message) ? data.message : 'Terjadi error saat mengirim';
                showToast(msg, false);
            }
        } catch (err) {
            showToast('Gagal menghubungi server', false);
            console.error(err);
        }
    }
</script>
@endsection
