<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'sometimes|exists:locations,id',
            'type' => 'sometimes|in:credit,debit',
            'date' => 'sometimes|date',
        ]);

        $transactions = (new Transaction())->where('user_id', $request->user_id)->latest();

        if ($request->date) {
            $transactions = $transactions->whereDate('created_at', $request->date);
        }

        if ($request->type) {
            $transactions = $transactions->where('type', $request->type);
        }

        if ($request->location_id) {
            $transactions = $transactions->where('created_at', $request->location_id);
        }

        return response()->json(
            $transactions->paginate(10)
        );
    }
}
