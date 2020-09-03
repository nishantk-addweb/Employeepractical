<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employees;
use DataTables;

class employeecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = employees::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="'.route('edit').'?eid='.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editemployee">Edit</a>';
   
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('employeedetail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $files = $request->file('image');
        $imageName = rand() . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('/empimages'),$imageName);
        // $data['image']->move(base_path() . '/public/empimages/', $imageName
        // );

        employees::Create(['id' => $request->employee_id],
                ['empname' =>$request->empname, 
                'email' => $request->email, 
                'contact'=>$request->contact,
                'image'=>$imageName]);

           // echo $request->empname;

        
   
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        //
        $id = $req->eid;
        $employee = employees::find($id);
        return response()->json(['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
