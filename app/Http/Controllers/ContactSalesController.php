<?php

namespace App\Http\Controllers;

use App\Models\SalesLead;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;

class ContactSalesController extends Controller
{
    public function create()
    {
        return view('contact-sales');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'role'         => ['nullable', 'string', 'max:100'],
            'team_size'    => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'message'      => ['nullable', 'string', 'max:2000'],
        ]);

        $lead = SalesLead::create($validated);

        // OPTIONAL: email notification to your sales inbox
        // Mail::to('support@phishdefend.ai')->send(new \App\Mail\SalesLeadSubmitted($lead));

        return redirect()->route('contact.sales.thanks');
    }

    public function thanks()
    {
        return view('contact-sales-thanks');
    }
}
