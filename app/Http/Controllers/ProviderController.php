<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Provider;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Resource de categorias
        if ( request()->ajax() ) {
            return datatables()->of( Provider::latest()->get() )
                ->addColumn( 'action', function ($data) {
                    $button  = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns( ['action'] )
                ->make( true );
        }
        return view('layouts.provaider');
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
        $rules = array(
            'name'    => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'tel'     => 'required|string|max:11'

        );

        $error = Validator::make($request->all(), $rules);

        if ( $error->fails() ) {
            return response()->json( ['errors' => $error->errors()->all()] );
        } 

        $formData =  array(
            'nameProvider' => $request->name,
            'contact'      => $request->contact,
            'tel'          => $request->tel
        );

        Provider::create( $formData );

        return response()->json( ['success' => 'Provider add.'] );
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
    public function edit($id)
    {
        
        if( request()->ajax() ) 
            return response()->json( ['data' => Provider::findOrFail($id) ] );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $rules = array(
            'name'    => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'tel'     => 'required|string|max:11'

        );

        $error = Validator::make($request->all(), $rules);

        if ( $error->fails() ) {
            return response()->json( ['errors' => $error->errors()->all()] );
        } 

        $formData =  array(
            'nameProvider' => $request->name,
            'contact'      => $request->contact,
            'tel'          => $request->tel
        );

        Provider::whereId( $request->hidden_id )->update( $formData );

        return response()->json( ['success' => 'Provider update.'] );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Provider::findOrFail($id)->delete();
        return response()->json(['errors' => 'Category delete.'] );
    }
}
