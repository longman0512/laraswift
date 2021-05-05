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
        $varieties = $this->varieties->all();
        $user_id = Auth::id();
        // dd($varieties);
        $result = [];
        $coords = $this->coords->where('user_id', $user_id)->get();
        
        foreach($coords as $pos){
            $tree = $this->tree->where('coords', $pos->id)->get();
            $pos['trees'] = $tree;
            // print_r($pos);
            $result[] = $pos;
        }
        // print_r($result[0]['trees']);
        // exit;
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

        return view('trees.addMore', [
            'info' => $coord
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
        if($files = $request->file('uploadFile')){ 
            $name = $files->getClientOriginalName(); 
            $extension = $files->getClientOriginalExtension();
            $name = str_random(30);
            // dd($extension);

            $files->move('uploads/tree/', $name); 
            $uploaded_file = $name; 
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
        if($files = $request->file('uploadFile')){ 
            $name = $files->getClientOriginalName(); 
            $extension = $files->getClientOriginalExtension();
            $name = str_random(30);
            // dd($extension);

            $files->move('uploads/tree/', $name); 
            $uploaded_file = $name; 
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
}
