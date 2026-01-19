<?php

namespace App\Http\Controllers;

use App\Models\WeddingOrder;
use App\Models\BirthdayOrder;
use App\Models\MetatahOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // --- Store Methods (Public) ---

    public function storeWedding(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string',
            'no_hp' => 'required|string',
            'isi_foto' => 'required|boolean',
            'link_template' => 'required|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
            'catatan' => 'nullable|string',
            'bukti_tranfer' => 'required|image|max:2048',

            // Wedding Specific
            'nama_lengkap_pria' => 'required|string',
            'nama_panggilan_pria' => 'required|string',
            'nama_ortu_pria' => 'required|string',
            'ig_pria' => 'nullable|string',

            'nama_lengkap_wanita' => 'required|string',
            'nama_panggilan_wanita' => 'required|string',
            'nama_ortu_wanita' => 'required|string',
            'ig_wanita' => 'nullable|string',

            'tanggal_pernikahan' => 'required|date',
            'waktu_pernikahan' => 'required|string',
            'alamat_pernikahan' => 'required|string',
            'link_lokasi_pernikahan' => 'required|url',

            'tanggal_resepsi' => 'nullable|date',
            'waktu_resepsi' => 'nullable|string',
            'alamat_resepsi' => 'nullable|string',
            'link_lokasi_resepsi' => 'nullable|url',
        ]);

        if ($request->hasFile('bukti_tranfer')) {
            $path = $request->file('bukti_tranfer')->store('uploads/payment_proofs', 'public');
            $validated['bukti_tranfer'] = $path;
        }

        $order = WeddingOrder::create($validated);
        return response()->json(['message' => 'Order submitted successfully', 'order' => $order], 201);
    }

    public function storeBirthday(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string',
            'no_hp' => 'required|string',
            'isi_foto' => 'required|boolean',
            'link_template' => 'required|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
            'catatan' => 'nullable|string',
            'bukti_tranfer' => 'required|image|max:2048',

            // Birthday Specific
            'nama_yang_ulang_tahun' => 'required|string',
            'ultah_ke' => 'required|integer',
            'tanggal_acara' => 'required|date',
            'waktu_acara' => 'required|string',
            'alamat_acara' => 'required|string',
            'link_lokasi_acara' => 'required|url',
        ]);

        if ($request->hasFile('bukti_tranfer')) {
            $path = $request->file('bukti_tranfer')->store('uploads/payment_proofs', 'public');
            $validated['bukti_tranfer'] = $path;
        }

        $order = BirthdayOrder::create($validated);
        return response()->json(['message' => 'Order submitted successfully', 'order' => $order], 201);
    }

    public function storeMetatah(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string',
            'no_hp' => 'nullable|string',
            'isi_foto' => 'required|boolean',
            'link_template' => 'required|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
            'catatan' => 'nullable|string',
            'bukti_tranfer' => 'required|image|max:2048',

            // Metatah Specific
            'detail_nama_ortu' => 'required|string',
            'jumlah_peserta' => 'required|integer',
            
            // Allow array input for participant data
            'data_peserta' => 'required|string', // JSON string from frontend

            'tanggal_acara' => 'required|date',
            'waktu_acara' => 'required|string',
            'alamat_acara' => 'required|string',
            'link_lokasi_acara' => 'required|url',

            'tanggal_resepsi' => 'nullable|date',
            'waktu_resepsi' => 'nullable|string',
            'alamat_resepsi' => 'nullable|string',
            'link_lokasi_resepsi' => 'nullable|url',
        ]);

        if ($request->hasFile('bukti_tranfer')) {
            $path = $request->file('bukti_tranfer')->store('uploads/payment_proofs', 'public');
            $validated['bukti_tranfer'] = $path;
        }

        // Decode JSON data_peserta if sent as string from FormData
        $validated['data_peserta'] = json_decode($validated['data_peserta'], true);

        $order = MetatahOrder::create($validated);
        return response()->json(['message' => 'Order submitted successfully', 'order' => $order], 201);
    }

    // --- Admin Methods ---

    public function index()
    {
        $wedding = WeddingOrder::orderBy('created_at', 'desc')->get();
        $birthday = BirthdayOrder::orderBy('created_at', 'desc')->get();
        $metatah = MetatahOrder::orderBy('created_at', 'desc')->get();

        return response()->json([
            'wedding' => $wedding,
            'birthday' => $birthday,
            'metatah' => $metatah,
        ]);
    }

    public function updateStatus(Request $request, $type, $id)
    {
        $request->validate(['status' => 'required|in:pending,processed,completed']);

        $modelMap = [
            'wedding' => WeddingOrder::class,
            'birthday' => BirthdayOrder::class,
            'metatah' => MetatahOrder::class,
        ];

        if (!isset($modelMap[$type])) {
            return response()->json(['error' => 'Invalid order type'], 400);
        }

        $order = $modelMap[$type]::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated', 'order' => $order]);
    }
}
