<?php

namespace App\Http\Controllers\Secretariat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Secretariat\Mail;

class OutboxController extends Controller
{
    public function index(Request $request)
    {
        $mails = Mail::latest('id')->where('type', 'out');
        if ($request->has('q')) {
            $q = $request->input('q');

            $mails = $mails->where('target', 'LIKE', "%$q%")
                ->orWhere('number', 'LIKE', "%$q%")
                ->orWhere('note', 'LIKE', "%$q%")
                ->orWhere('summary', 'LIKE', "%$q%");
        }
        $mails = $mails->paginate(50);
        $type = 'keluar';

        return view('kesekretariatan.surat.index', compact('mails', 'type'));
    }

    public function create()
    {
        return view('kesekretariatan.surat.tambah', ['type' => 'keluar']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'target' => 'required',
            'number' => 'required',
            'summary' => 'required',
            'note' => 'nullable',
            'photo' => 'nullable|file',
            'recommendation' => 'required|in:kepala_desa,sekretaris,bpd,kaur_pemerintah,kaur_pembanguna,kaur_kesejahteraan rakyat,kaur_keuangan, kaur_umum',
        ]);

        DB::transaction(function () use ($request) {
            $photo = '';
            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $photo = $request->photo->storeAs('uploaded/images', $photoName, 'public');
            }

            Mail::create([
                'date' => $request->date,
                'target' => $request->target,
                'number' => $request->number,
                'summary' => $request->summary,
                'note' => $request->note,
                'type' => 'out',
                'photo' => $photo,
                'recommendation' => $request->recommendation,
            ]);
        });

        return redirect('/surat-keluar')->with('success', 'Penambahan surat keluar baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $mail = Mail::where('id', $id)->where('type', 'out')->firstOrFail();
        $type = 'keluar';

        return view('kesekretariatan.surat.ubah', compact('type', 'mail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'target' => 'required',
            'number' => 'required',
            'summary' => 'required',
            'note' => 'nullable',
            'photo' => 'nullable|file',
            'recommendation' => 'required|in:kepala_desa,sekretaris,bpd,kaur_pemerintah,kaur_pembanguna,kaur_kesejahteraan rakyat,kaur_keuangan, kaur_umum',
        ]);

        $mail = Mail::where('id', $id)->where('type', 'out')->firstOrFail();

        DB::transaction(function () use ($request, $mail) {
            $photo = null;
            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $photo = $request->photo->storeAs('uploaded/images', $photoName, 'public');
            }

            $mail->update([
                'date' => $request->date,
                'target' => $request->target,
                'number' => $request->number,
                'summary' => $request->summary,
                'note' => $request->note,
                'photo' => $photo ? $photo : $mail->photo,
                'recommendation' => $request->recommendation,
            ]);
        });

        return redirect('/surat-keluar')->with('success', 'Pengubahan surat keluar berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $mail = Mail::where('id', $id)->where('type', 'out')->firstOrFail();

        $mail->delete();

        return redirect('/surat-keluar')->with('success', 'Penghapusan surat keluar berhasil dilakukan!');
    }
}
