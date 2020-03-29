<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Diary;

class DiaryController extends Controller
{
    
    public function index()
    {
        return response()->json(Diary::all());
    }

   
    public function store(Request $request)
    {
        $data = json_decode($request->input('data'),true);
        if(!empty($data)){
            $diary = new Diary();
            $diary['title'] = $data['title'];
            $diary['description'] = $data['description'];
            $diary['tag'] = $data['tag'];
            $diary['site'] = $data['site'];
            $diary['date'] = $data['date'];
            $diary->save();
            if($diary->save()){
                return response()->json(true);
            }
        }
        $data = collect([
            'status'=>'error',
            'code'=>500,
            'message'=>'No se ha creado la agenda'
        ]);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $diary = Diary::find($id);
        $data = json_decode($request->input('data'),true);
        if(!empty($diary) && !empty($data)){
            $diary->title = $data['title'];
            $diary->description = $data['description'];
            $diary->tag = $data['tag'];
            $diary->site = $data['site'];
            $diary->date = $data['date'];
            $diary->save();
            if($diary->save()){
                return response()->json(true);
            }
        }else{
            $data = collect([
                'status'=>'error',
                'code'=>500,
                'message'=>'No se ha actualizado la agenda'
            ]);
            return response()->json($data);
        }
    }

    public function destroy($id)
    {
        Diary::find($id)->delete();
        return response()->json(true);
    }
}
