<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticuloController extends Controller
{
    //
    public function index(Request $request)
    {
        // Solo permite realizar peticiones Ajax, si se ingresa la URL redirecciona a la ruta Raiz
        if (!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id','desc')->paginate(3);
        }
        else
        {
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio , 'like', '%' . $buscar . '%')
            ->orderBy('articulos.id','desc')->paginate(3);
            
        }

        return [
            'pagination' => [
                'total'  => $articulos->total(),
                'current_page'  => $articulos->currentPage(),
                'per_page'  => $articulos->perPage(),
                'last_page'  => $articulos->lastPage(),
                'from'  => $articulos->firstItem(),
                'to'  => $articulos->lastItem(),
                
            ],
            'articulos' => $articulos
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        
        $articulo = new Articulo();
        $articulo->idcategoria = $request->input('idcategoria');
        $articulo->codigo = $request->input('codigo');
        $articulo->nombre = $request->input('nombre');
        $articulo->precio_venta = $request->input('precio_venta');
        $articulo->stock = $request->input('stock');
        $articulo->descripcion = $request->input('descripcion');
        $articulo->condicion = '1';
        $articulo->save();
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
        
        if (!$request->ajax()) return redirect('/');
       
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->input('idcategoria');
        $articulo->codigo = $request->input('codigo');
        $articulo->nombre = $request->input('nombre');
        $articulo->precio_venta = $request->input('precio_venta');
        $articulo->stock = $request->input('stock');
        $articulo->descripcion = $request->input('descripcion');
        $articulo->condicion = '1';
        $articulo->save();
        
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

        /**
     * desactived the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactivar(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activar(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        
        $articulo = Categoria::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

}
