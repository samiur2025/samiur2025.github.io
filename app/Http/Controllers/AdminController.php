<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => Lead::count(),
            'new_today' => Lead::whereDate('created_at', today())->count(),
            'unread' => Lead::unread()->count(),
            'conversion' => Lead::whereIn('status', ['qualified', 'proposal', 'closed'])->count(),
        ];

        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'closed', 'archived'];

        return view('admin.dashboard', compact('stats', 'statuses'));
    }

    public function leads(Request $request)
    {
        $query = Lead::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json($leads);
    }

    public function show(Lead $lead)
    {
        $lead->markAsRead();
        return response()->json($lead);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['status' => 'required|in:new,contacted,qualified,proposal,closed,archived']);
        $lead->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'lead' => $lead->fresh()
        ]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['success' => true, 'message' => 'Lead deleted']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Lead::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true, 'message' => 'Selected leads deleted']);
    }

    public function export()
    {
        $filename = 'leads-' . now()->format('Y-m-d-His') . '.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Description', 'Status', 'IP Address', 'Created At']);

            Lead::chunk(100, function ($leads) use ($handle) {
                foreach ($leads as $lead) {
                    fputcsv($handle, [
                        $lead->id,
                        $lead->name,
                        $lead->email,
                        $lead->description,
                        $lead->status,
                        $lead->ip_address,
                        $lead->created_at->format('Y-m-d H:i:s')
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
