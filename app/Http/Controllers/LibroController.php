<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

/**
 * Class LibroController
 * @package App\Http\Controllers
 */
class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
      //CODIGO ORIGINAL SIN ERRORES
      public function index(Request $request)
    {
        $libros = Libro::paginate();
        $texto =trim($request->get('texto'));
        return view('libro.index', compact('libros'))
            ->with('i', (request()->input('page', 1) - 1) * $libros->perPage());
    }

   

     /**
      * 
         public function index(Request $request)
    {
        $texto =trim($request->get('texto'));

        $libros = Libro::paginate();
        $libros=DB::table('libros')->select('id','id_categoria','nombre')->where('nombre','LIKE','%'.$texto.'%')->orderBy('nombre','asc');
        return view('libro.index', compact('libros'));
        //->with('i', (request()->input('page', 1) - 1) * $libros->perPage());
    }

      */
    

    public function pdf()
    {
        $libros = Libro::paginate();
        
        /** Esta parte se añadio cualquier cosa borrar */
        $pdf = pdf::loadView('libro.pdf',['libros'=>$libros]);
        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->stream();
        
        return $pdf->download('___libros.pdf');
       
       
       
        //return view('libro.pdf',compact('libros'));

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $libro = new Libro();
        $categorias = Categoria::pluck('nombre','id');
        /** metodo pluck : dar la conuslta en el orden nombre- id
         * devuelve las categorias dando el nombre y el id 
        */

        return view('libro.create', compact('libro','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Libro::$rules);

        $libro = Libro::create($request->all());

        return redirect()->route('libros.index')
            ->with('success', 'Libro created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $libro = Libro::find($id);

        return view('libro.show', compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $libro = Libro::find($id);
        $categorias = Categoria::pluck('nombre','id');
        return view('libro.edit', compact('libro','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Libro $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        request()->validate(Libro::$rules);

        $libro->update($request->all());

        return redirect()->route('libros.index')
            ->with('success', 'Libro updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $libro = Libro::find($id)->delete();

        return redirect()->route('libros.index')
            ->with('success', 'Libro deleted successfully');
    }
}
