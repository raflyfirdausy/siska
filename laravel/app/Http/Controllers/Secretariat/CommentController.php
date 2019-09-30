<?php

namespace App\Http\Controllers\Secretariat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Secretariat\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comment = Comment::with('resident');

        if ($request->has('q')) {
            $q = $request->input('q');
            $comment = $comment->whereHas('resident', function($query) use ($q) {
                return $query->where('nik', 'LIKE', '%'.$q.'%')
                    ->orWhere('name', 'LIKE', '%'.$q.'%');
            })
            ->orWhere('comment', 'LIKE', "%$q%");
        }

        $comment = $comment->get();
        return view('pelayanan.laporan.index', compact('comment'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sudah,belum',
        ]);

        Comment::where('id', $id)
            ->update([
                'proceeded' => $request->status,
            ]);
        
        return ['success' => true];
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect('laporan-masuk')->with('success', 'Penghapusan laporan berhasil dilakukan!');
    }
















    public function getUsers(){
        // Call getuserData() method of Page Model
        $userData['data'] = Comment::getuserData();

        echo json_encode($userData);
        exit;
    }

    public function updateUser(Request $request){
        $status = 'Sudah';
        $editid = $request->input('editid');

        $data = array('status'=>$status);

        Comment::updateData($editid, $data);

    }
}
