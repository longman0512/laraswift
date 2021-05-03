<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function add()
    {
        $varieties = $this->varieties->all();
        // dd($varieties);
        return view('trees.add', [
            'categories' => $varieties
        ]);
    }

    public function create(Request $request){
        // dd($this->tree);
        $coords_id = $this->coords->insertGetId([
            'latitude' => (float)$request->latitude,
            'longitude' => (float)$request->longitude
        ]);
            // dd($coords_id);
        
        $tree = $this->tree->create([
            'caption' => $request->caption,
            'variety_slug' => $request->variety,
            'quantity' => (int)$request->quantity,
            'share_status' => $request->share_status,
            'coords' => (int)$coords_id,
            'media' => "v"
        ]);

        if($tree){
            return redirect()->back()->with('success', 'Tree created successfully');
        } else {
            return redirect()->back()->with('error', 'Ops! an error occured');
        }

    }
}
