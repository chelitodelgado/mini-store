<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\Category;
use App\Provider;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categorys = Category::orderBY('id','ASC')->get();
        $providers = Provider::orderBY('id','ASC')->get();

        $dataTable = Product::query('products')
            ->join('categorys', 'products.category_id', '=', 'categorys.id')
            ->join('providers', 'products.provider_id', '=', 'providers.id')
            ->select('products.*', 'categorys.nameCategory', 'providers.nameProvider')
            ->get();

        // Resource de categorias
        if ( request()->ajax() ) {
            return datatables()->of( $dataTable )
                ->addColumn( 'action', function ($data) {
                    $button  = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns( ['action'] )
                ->make( true );
        }
        return view('layouts.product',[
            'categorys'  => $categorys,
            'providers' => $providers
        ]);
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
        /* $rules = array(
            'nameProduct' => 'required|string|max:100',
            'cost'        => 'required|string|max:100',
            'stock'       => 'required|string|max:100',
            'category_id' => 'required|integer',
            'provider_id' => 'required|integer'

        );

        $error = Validator::make($request->all(), $rules);

        if ( $error->fails() ) {
            return response()->json( ['errors' => $error->errors()->all()] );
        }  */

        $formData =  array(
            'nameProduct'   => $request->name,
            'cost'          => $request->cost,
            'stock'         => $request->stock,
            'provider_id'   => $request->provider_id,
            'category_id'   => $request->category_id
        );

        Product::create( $formData );

        return response()->json( ['success' => 'Product add.'] );
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
            return response()->json( ['data' => Product::findOrFail($id) ] );
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
        /* $rules = array(
            'nameProduct' => 'required|string|max:100',
            'cost'        => 'required|string|max:100',
            'stock'       => 'required|string|max:100',
            'category_id' => 'required|integer',
            'provider_id' => 'required|integer'

        );

        $error = Validator::make($request->all(), $rules);

        if ( $error->fails() ) {
            return response()->json( ['errors' => $error->errors()->all()] );
        }  */

        $formData =  array(
            'nameProduct'   => $request->nameProduct,
            'cost'          => $request->cost,
            'stock'         => $request->stock,
            'provider_id'   => $request->provider_id,
            'category_id'   => $request->category_id
        );

        Product::whereId( $request->hidden_id )->update( $formData );

        return response()->json( ['success' => 'Product add.'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['errors' => 'Category delete.'] );
    }
}
