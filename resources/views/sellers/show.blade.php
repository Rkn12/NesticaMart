@extends('layouts.app')

@section('title', 'Detail Penjual')
@section('page-title', 'Detail Penjual')

@section('content')
    <div class="card">
        <a href="/sellers" class="btn btn-primary" style="width: fit-content; margin-bottom: 20px; padding: 12px 24px; font-size: 16px;">← Kembali</a>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div>
                <h3 style="margin-bottom: 20px; color: #667eea;">📦 Informasi Toko</h3>
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
                <form method="POST" action="/api/sellers/{{ $seller->id }}/verify" style="display: flex; gap: 15px; align-items: flex-end;">
                    @csrf
                    <div style="flex: 1;">
                        <label><strong>Catatan Verifikasi:</strong></label>
                        <textarea name="verification_note" class="form-control" rows="3" placeholder="Masukkan catatan verifikasi..."></textarea>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" name="status" value="approved" class="btn btn-success">✓ Approve</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger">✗ Reject</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
