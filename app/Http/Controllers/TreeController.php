<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TreeVariety;
use App\Models\Tree;
use App\Models\Coords;
use Str;

class TreeController extends Controller
{
    //
    protected $treeVariety;
    protected $tree;
    protected $coords;
    public function __construct(TreeVariety $treeVariety, Tree $tree, Coords $position)
    {
        if (setting('email_verification')) {
            $this->middleware(['verified']);
        }
        $this->middleware(['auth','web','2fa']);

        $this->varieties = $treeVariety;
        $this->tree = $tree;
        $this->coords = $position;
    }

    public function index()
    {
        $user_id = Auth::id();
        $result = [];
        $coords = $this->coords->where('user_id', $user_id)->get();
        
        foreach($coords as $pos){
            $tree = $this->tree->where('coords', $pos->id)->get();
            $variety = $this->varieties->where('slug', '=', $pos->variety_slug)->get();
            $pos['trees'] = $tree;
            $pos['variety'] = $pos->variety_slug;
            foreach ($variety as $v) {
                $pos['variety'] = isset($v->name) ? $v->name : $pos->variety_slug;
            }
            $result[] = $pos;
        }
        return view('trees.index', [
            'trees' => $result
        ]);
    }

    public function add()
    {
        $varieties = $this->varieties->all();
        
        return view('trees.add', [
            'categories' => $varieties
        ]);
    }

    public function addMore($coordId)
    {
        $coord = $this->coords->find($coordId);
        $tree = $this->tree->where('coords', $coord->id)->get();
            
        $variety = $this->varieties->where('slug', '=', $coord->variety_slug)->get();

        $coord['trees'] = $tree;
        $variety_name = $coord->variety_slug;
        
        foreach ($variety as $v) {
            $variety_name = isset($v->name) ? $v->name : $coord->variety_slug;
        }
        return view('trees.addMore', [
            'info' => $coord,
            'variety_name' => $variety_name
        ]);
    }

    public function updateShareStatus(Request $request){
        $coord = $this->coords->find($request->id);
        $coord->share_status = $request->status;
        $coord->save();
        return $request->id;
    }

    public function create(Request $request){
        $uploaded_file = '';
        $file_type = ['mp4', 'ogg', 'webm'];
        
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
        } else {
            if($files = $request->file('uploadFile')){ 
                $name = $files->getClientOriginalName(); 
                $extension = $files->getClientOriginalExtension();
                $name = str_random(30);
                // dd($extension);
    
                $files->move('uploads/tree/', $name); 
                $uploaded_file = $name;
            }
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $coords_id = $this->coords->insertGetId([
            'latitude' => (float)$request->latitude,
            'longitude' => (float)$request->longitude,
            'user_id' => (int)Auth::id(),
            'variety_slug' => $request->variety,
            'quantity' => (int)$request->quantity,
            'share_status' => $request->share_status,
            'created_at' => $timestamp,
        ]);
        $media_type = in_array($extension, $file_type) ? 'video' : 'image';
        
        $post_data = [
            'caption' => $request->caption,
            'coords' => (int)$coords_id,
            'media_type' => $media_type,
            
        ];
        if(!empty($uploaded_file)){
            $post_data['media'] = $uploaded_file;
        }
        
        $tree = $this->tree->create($post_data);


        if($tree){
            return redirect()->back()->with('success', 'Tree created successfully');
        } else {
            return redirect()->back()->with('error', 'Ops! an error occured');
        }

    }

    public function add_more(Request $request){
        $uploaded_file = '';
        $file_type = ['mp4', 'ogg', 'webm'];
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
        } else {
            if($files = $request->file('uploadFile')){ 
                $name = $files->getClientOriginalName(); 
                $extension = $files->getClientOriginalExtension();
                $name = str_random(30);
                // dd($extension);
    
                $files->move('uploads/tree/', $name); 
                $uploaded_file = $name;
            }
        }
        $timestamp = date('Y-m-d H:i:s');
        $coord = $this->coords->find($request->coord_id);
        $coord->share_status = $request->share;
        $coord->save();
        
        $media_type = in_array($extension, $file_type) ? 'video' : 'image';
        
        $post_data = [
            'caption' => $request->caption,
            'coords' => (int)$request->coord_id,
            'media_type' => $media_type,
            
        ];
        if(!empty($uploaded_file)){
            $post_data['media'] = $uploaded_file;
        }
        
        $tree = $this->tree->create($post_data);
        if($tree){
            return redirect()->back()->with('success', 'Tree created successfully');
        } else {
            return redirect()->back()->with('error', 'Ops! an error occured');
        }

    }
    public function getPlantedTree() {
        return response()->json(
            ['status'=>true]
        );
    }
}
