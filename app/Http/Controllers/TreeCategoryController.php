<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreeVariety;
use Str;

class TreeCategoryController extends Controller
{

    protected $treeVariety;
    public function __construct(TreeVariety $treeVariety)
    {
        if (setting('email_verification')) {
            $this->middleware(['verified']);
        }
        $this->middleware(['auth','web','role:admin','2fa']);

        $this->varieties = $treeVariety;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $varieties = $this->varieties->all();
        return view('trees.category.index', [
            'categories' => $varieties
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
        $varieties = $this->varieties->all();
        return view('trees.category.create', [
            'categories' => $varieties
        ]);
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
        
        $this->validate($request, [
            'name' => 'required|min:2|regex:/^[A-Za-z0-9_.,() ]+$/'
          ],[
            'name.regex' => 'Invalid Entry! The name only letter and numbers are allowed'
          ]);
        $slug = Str::slug(strtolower($request->name), '-');
        $varietyFlag = $this->varieties->whereSlug($slug)->first();
        if (!$varietyFlag) {
            $uploaded_file = '';
            if($files = $request->file('uploadFile')){ 
                $files->move('uploads/tree/', $slug); 
                $uploaded_file = $slug; 
            }

            $variety = $this->varieties->create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'media' => $uploaded_file,
                'carbon_absorption' => $request->carbon_absorption,
                'oxygen_production' => $request->oxygen_production,
                'nitrogen_fixing' => $request->nitrogen_fixing == 'yes' ? true : false,
                'zone' => $request->zone
            ]);
            if($variety){
                return redirect()->back()->with('success', 'Variety created successfully');
            } else {
                return redirect()->back()->with('error', 'Ops! an error occured');
            }
        } else {
            return redirect()->back()->with('warning', 'Ops! There was already Same Name');
        }
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
    public function edit($slug)
    {
        //
        $variety = $this->varieties->whereSlug($slug)->first();
        return view('trees.category.edit', [
        'category' => $variety,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        $this->validate($request, [
            'name' => 'required|regex:/^[A-Za-z0-9_.,() ]+$/',
          ],[
            'name.regex' => 'Invalid Entry! The name only letter and numbers are allowed',
          ]);
        //   dd($slug);
          $category = $this->varieties->whereSlug($slug)->update([
          'name' => $request->name,
          'description' => $request->description,
          'carbon_absorption' => $request->carbon_absorption,
            'oxygen_production' => $request->oxygen_production,
            'nitrogen_fixing' => $request->nitrogen_fixing == 'yes' ? true : false,
            'zone' => $request->zone
        ]);

          if ($category) {
              return redirect()->back()->with('success', 'Variety updated successfully');
          } else {
              return redirect()->back()->with('error', 'Ops! an error occured try again');
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        // dd($slug);
        $varietyFlag = $this->varieties->whereSlug($slug)->first();
        $varietyFlag->delete();
        return redirect()->back()->with('success', 'Variety deleted Successfully');
    }
}
