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
            if($request->cropedImage){
                $image_file = $request->cropedImage;
                list($type, $image_file) = explode(';', $image_file);
                list(, $image_file)      = explode(',', $image_file);
                $image_file = base64_decode($image_file);
                $name= time().'_'.rand(100,999).'.png';
                $path = public_path('uploads/tree/'.$name);
                $extension = 'png';
                file_put_contents($path, $image_file);
                $uploaded_file = $name; 
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

        $uploaded_file = '';
        // dd($request->cropedImage);
        if($request->cropedImage){
            $image_file = $request->cropedImage;
            list($type, $image_file) = explode(';', $image_file);
            list(, $image_file)      = explode(',', $image_file);
            $image_file = base64_decode($image_file);
            $name= time().'_'.rand(100,999).'.png';
            $path = public_path('uploads/tree/'.$name);
            $extension = 'png';
            file_put_contents($path, $image_file);
            $uploaded_file = $name; 
            $category = $this->varieties->whereSlug($slug)->update([
                'name' => $request->name,
                'description' => $request->description,
                'media' => $uploaded_file,
                'carbon_absorption' => $request->carbon_absorption,
                  'oxygen_production' => $request->oxygen_production,
                  'nitrogen_fixing' => $request->nitrogen_fixing == 'yes' ? true : false,
                  'zone' => $request->zone
              ]);
        } else {
            $category = $this->varieties->whereSlug($slug)->update([
                'name' => $request->name,
                'description' => $request->description,
                'carbon_absorption' => $request->carbon_absorption,
                  'oxygen_production' => $request->oxygen_production,
                  'nitrogen_fixing' => $request->nitrogen_fixing == 'yes' ? true : false,
                  'zone' => $request->zone
              ]);
        }

        
          

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
