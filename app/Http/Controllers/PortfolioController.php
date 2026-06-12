<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\LeadAutoReply;
use App\Mail\LeadNotification;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('portfolio');
    }

    public function leadSample()
    {
        $csvPath = storage_path('app/leads_data.csv');
        $leads = [];
        if (file_exists($csvPath)) {
            $data = array_map('str_getcsv', file($csvPath));
            // Remove header row
            array_shift($data);
            foreach ($data as $row) {
                if (count($row) >= 10) {
                    $leads[] = [
                        'identifier' => $row[0],
                        'sector'     => $row[1],
                        'niche'      => $row[2],
                        'company'    => $row[3],
                        'lead'       => $row[4],
                        'role'       => $row[5],
                        'email'      => $row[6],
                        'phone'      => $row[7],
                        'website'    => $row[8],
                        'location'   => $row[9],
                    ];
                }
            }
        }
        return view('sample-lead', compact('leads'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'description' => 'required|string',
        ]);

        $lead = Lead::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            // Send beautiful auto-reply to the client
            Mail::to($lead->email)->send(new LeadAutoReply($lead));

            // Notify admin with CC
            Mail::to('hello@dimarz.com')
                ->cc('mr.samiur@gmail.com')
                ->send(new LeadNotification($lead));
        } catch (\Exception $e) {
            Log::error('Failed to send lead emails: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Request submitted successfully',
            'lead_id' => $lead->id
        ]);
    }
}
