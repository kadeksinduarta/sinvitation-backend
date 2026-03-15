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
            'detail_nama_ortu' => 'nullable|string',
            'data_ortu' => 'required|string', // JSON string from frontend
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
        if (isset($validated['data_ortu'])) {
            $validated['data_ortu'] = json_decode($validated['data_ortu'], true);
        }

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

    // Individual order type endpoints for admin
    public function weddingOrders()
    {
        return response()->json(WeddingOrder::orderBy('created_at', 'desc')->get());
    }

    public function birthdayOrders()
    {
        return response()->json(BirthdayOrder::orderBy('created_at', 'desc')->get());
    }

    public function metatahOrders()
    {
        return response()->json(MetatahOrder::orderBy('created_at', 'desc')->get());
    }

    // Admin store methods (no bukti_tranfer required)
    public function storeWeddingAdmin(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'isi_foto' => 'boolean',
            'nama_pemesan' => 'required|string',
            'link_template' => 'nullable|string',
            'susunan_nama_mempelai' => 'nullable|string',
            'agama' => 'nullable|string',
            'nama_panggilan_wanita' => 'nullable|string',
            'nama_lengkap_wanita' => 'nullable|string',
            'nama_ortu_wanita' => 'nullable|string',
            'ig_wanita' => 'nullable|string',
            'nama_panggilan_pria' => 'nullable|string',
            'nama_lengkap_pria' => 'nullable|string',
            'nama_ortu_pria' => 'nullable|string',
            'ig_pria' => 'nullable|string',
            'tanggal_pernikahan' => 'nullable|date',
            'waktu_pernikahan' => 'nullable|string',
            'alamat_pernikahan' => 'nullable|string',
            'link_lokasi_pernikahan' => 'nullable|string',
            'tanggal_resepsi' => 'nullable|date',
            'waktu_resepsi' => 'nullable|string',
            'alamat_resepsi' => 'nullable|string',
            'link_lokasi_resepsi' => 'nullable|string',
            'amplop_digital' => 'boolean',
            'no_rek' => 'nullable|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
        ]);

        $order = WeddingOrder::create($validated);
        return response()->json(['message' => 'Data wedding berhasil disimpan', 'order' => $order], 201);
    }

    public function storeBirthdayAdmin(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'isi_foto' => 'boolean',
            'nama_pemesan' => 'required|string',
            'link_template' => 'nullable|string',
            'nama_yang_ulang_tahun' => 'nullable|string',
            'ultah_ke' => 'nullable|string',
            'tanggal_acara' => 'nullable|date',
            'waktu_acara' => 'nullable|string',
            'alamat_acara' => 'nullable|string',
            'link_lokasi_acara' => 'nullable|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
        ]);

        $order = BirthdayOrder::create($validated);
        return response()->json(['message' => 'Data birthday berhasil disimpan', 'order' => $order], 201);
    }

    public function storeMetatahAdmin(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string',
            'no_hp' => 'nullable|string',
            'isi_foto' => 'boolean',
            'link_template' => 'nullable|string',
            'link_drive_foto' => 'nullable|string',
            'lagu' => 'nullable|string',
            'catatan' => 'nullable|string',
            'detail_nama_ortu' => 'nullable|string',
            'data_ortu' => 'nullable',
            'jumlah_peserta' => 'nullable|integer',
            'data_peserta' => 'nullable',
            'tanggal_acara' => 'nullable|date',
            'waktu_acara' => 'nullable|string',
            'alamat_acara' => 'nullable|string',
            'link_lokasi_acara' => 'nullable|string',
            'tanggal_resepsi' => 'nullable|date',
            'waktu_resepsi' => 'nullable|string',
            'alamat_resepsi' => 'nullable|string',
            'link_lokasi_resepsi' => 'nullable|string',
        ]);

        // Handle data_peserta
        if (isset($validated['data_peserta']) && is_string($validated['data_peserta'])) {
            $validated['data_peserta'] = json_decode($validated['data_peserta'], true);
        }
        if (isset($validated['data_ortu']) && is_string($validated['data_ortu'])) {
            $validated['data_ortu'] = json_decode($validated['data_ortu'], true);
        }

        $order = MetatahOrder::create($validated);
        return response()->json(['message' => 'Data metatah berhasil disimpan', 'order' => $order], 201);
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
