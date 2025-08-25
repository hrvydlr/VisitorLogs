<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorApiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('term');
        $visitors = Visitor::where('name', 'LIKE', "%$search%")->get();

        return response()->json($visitors);
    }
}
