<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;

class ProductController extends Controller
{
    /**
     * Create a middleware auth.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $products = Product::select("*")
                        ->orderByDesc("id")
                        ->get();
        $array = [];

        foreach($products as $product){
            $data['uuid'] = $product->uuid;
            $data['name'] = $product->name;
            $data['description'] = $product->description;
            if(is_null($product->cogs)) {
                $data['cogs'] = '-';
            } else {
                $data['cogs'] = 'Rp. ' . number_format($product->cogs);
            }
            
            $data['price'] = 'Rp. ' . number_format($product->price);

            array_push($array, $data);
        }

        

        return DataTables::of($array)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-primary btn-sm btn-edit">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = [];
  
        if($request->filled('q')){
            $products = Product::select("name", "id")
                        ->where('name', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
            foreach($products as $product){
                $product['id'] = $product->id;
                $product['name'] = $product->name;

                array_push($data, $product);
            }  

            

        } else {
            $products = Product::all();

            foreach($products as $product){
                $product['id'] = $product->id;
                $product['name'] = $product->name;

                array_push($data, $product);
            }  
        }
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'cogs' => 'nullable|string',
            'price' => 'required|string',          
        ]);

        $product = Product::create($request->all());

        // $customerId = $customer->id;

        // if($request->ajax()){
        //     return response()->json([
        //         'success' => true,
        //         'id' => $customerId
        //     ]);
        // }      

        return redirect('/products')->with('success', 'Produk berhasil ditambah');
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
    public function edit($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        return view('product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'cogs' => 'nullable|string',
            'price' => 'required|string',          
        ]);

        Product::where('uuid', $uuid)
            ->update([
                'name' => $request->name, 
                'description' => $request->description, 
                'cogs' => $request->cogs, 
                'price' => $request->price, 
                // 'customer_address' => $request->customer_address, 
                // 'customer_city' => $request->customer_city, 
                // 'customer_note' => $request->customer_note, 
            ]);

        return redirect('/products')->with('success', 'Produk berhasil diubah');
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
