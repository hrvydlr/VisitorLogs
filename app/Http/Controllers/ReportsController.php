<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{ 
    public function index()
    {
        $visitors = Visitor::with('visitorType')->get();
        $visitorTypes = VisitorType::all();
        return view('reports.index', compact('visitors', 'visitorTypes'));
    }
    
    public function delete(Request $request)
    {
        $visitor = Visitor::find($request->id);
        if (!$visitor) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $details = $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name;
        $visitor->update(['deleted_by' => auth()->id()]);
        $visitor->delete();

        return response()->json(['You have successfully deleted ' . $details]);
    }

    public function show($id)
    {
        $visitor = Visitor::with(['visitorType', 'creator', 'updater'])->find($id);

        if (!$visitor) {
            return redirect()->route('reports.index')->with('error', 'Visitor not found.');
        }

        return view('reports.show', compact('visitor'));
    }

    public function list(Request $request)
    {
        $keywords      = $request->input('search.value');
        $limit         = $request->input('length');
        $start         = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDir      = $request->input('order.0.dir');

        $columns = ['id', 'first_name', 'middle_name', 'last_name', 'number', 'address', 'visitor_type_', 'id_number', 'status', 'deleted_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDirection = in_array(strtolower($orderDir), ['asc', 'desc']) ? $orderDir : 'asc';

        $baseQuery = Visitor::with(['visitorType', 'creator', 'updater'])
            ->when(!empty($keywords), function ($query) use ($keywords) {
                $query->where(function ($q) use ($keywords) {
                    $q->where('first_name', 'like', "%{$keywords}%")
                        ->orWhere('middle_name', 'like', "%{$keywords}%")
                        ->orWhere('last_name', 'like', "%{$keywords}%")
                        ->orWhere('id_number', 'like', "%{$keywords}%")
                        ->orWhere('number', 'like', "%{$keywords}%")
                        ->orWhere('address', 'like', "%{$keywords}%");
                });
            })
            ->when($request->filled('visitor_type'), function ($query) use ($request) {
                $query->whereHas('visitorType', function ($q) use ($request) {
                    $q->where('name', $request->visitor_type);
                });
            })
            ->when($request->filled('visit_date'), function ($query) use ($request) {
                $query->whereDate('visit_date', $request->visit_date);
            });

        $totalRecords = $baseQuery->count();

        $visitors = $baseQuery->orderBy($orderColumn, $orderDirection)
            ->skip($start)
            ->take($limit)
            ->get();

        $data = [];
        foreach ($visitors as $visitor) {
            $name = "{$visitor->first_name} {$visitor->middle_name} {$visitor->last_name}";

            $action = "
            <div class='dropdown'>
                <button class='btn btn-sm border-0 bg-transparent text-dark' type='button' id='actionDropdown{$visitor->id}' data-bs-toggle='dropdown' aria-expanded='false'>
                    &#8942;
                </button>
                <ul class='dropdown-menu' aria-labelledby='actionDropdown{$visitor->id}'>
                    <li>
                        <a class='dropdown-item btn-view' href='" . route('visitor.show', $visitor->id) . "' data-id='{$visitor->id}'>View</a>
                    </li>
                    <li>
                        <button class='dropdown-item btn-delete' data-id='{$visitor->id}' data-details='{$name}'>Delete</button>
                    </li>
                </ul>
            </div>";

            $data[] = [
                'id'            => $visitor->id,
                'fullname'      => $name,
                'number'        => $visitor->number,
                'address'       => $visitor->address,
                'visitor_type'  => $visitor->visitorType ? $visitor->visitorType->name : 'N/A',
                'id_number'     => $visitor->id_number,
                'visit_date'    => $visitor->visit_date,
                'time_in'       => $visitor->time_in,
                'time_out'      => $visitor->time_out,
                'created_by'    => $visitor->creator ? $visitor->creator->username : 'N/A',
                'updated_by'    => $visitor->updater ? $visitor->updater->username : 'N/A',
                'status'        => $visitor->time_out ? 'Timed Out' : 'Active',
                'action'        => $action,
            ];
        }

        return response()->json([
            'draw'              => intval($request->input('draw')),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $totalRecords,
            'data'              => $data,
        ]);
    }
}