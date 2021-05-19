<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreeVariety;
use App\Models\Tree;
use App\Models\Coords;
use DB;
class APIcontroller extends Controller
{
    //
    public function getplantedtree() {
        
        $coords = DB::select("SELECT *FROM coords WHERE share_status = 'public' ORDER BY RAND() LIMIT 1;");
        if(count($coords)){
            $variety = DB::select("SELECT * FROM tree_varieties WHERE slug = '".$coords[0]->variety_slug."'");
            $user = DB::select("SELECT * FROM users WHERE id = ".$coords[0]->user_id);
            $trees = DB::select("SELECT * FROM trees WHERE coords = '".$coords[0]->id."' AND media_type='image' ORDER BY RAND() LIMIT 1;");
            if(count($trees)){
                return response()->json(
                    [
                        'flag'=>true,
                        'coords'=>$coords[0],
                        'variety'=>$variety[0]->name,
                        'tree'=>$trees[0],
                        'userName'=>$user[0]->fullname
                    ]
                );
            } else {
                return response()->json(
                    ['flag'=>false]
                );
            }
            
            
        } else {
            return response()->json(
                ['flag'=>false]
            );
        }
        
    }
}
