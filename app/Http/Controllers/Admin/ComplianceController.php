<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompliancePolicy;
use App\Models\DataRequest;
use App\Models\DataRetentionRule;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    public function index()
    {
        $policies = CompliancePolicy::all();
        $dataRequests = DataRequest::orderBy('created_at', 'desc')->limit(10)->get();
        $retentionRules = DataRetentionRule::all();
        
        $stats = [
            'pending_requests' => DataRequest::getPendingCount(),
            'total_requests' => DataRequest::count(),
            'active_policies' => $policies->where('active', true)->count(),
            'retention_rules' => $retentionRules->where('active', true)->count(),
        ];

        return view('admin.compliance.index', compact('policies', 'dataRequests', 'retentionRules', 'stats'));
    }

    public function policies()
    {
        $policies = CompliancePolicy::orderBy('policy_type')->get();
        return view('admin.compliance.policies', compact('policies'));
    }

    public function editPolicy(CompliancePolicy $policy)
    {
        return view('admin.compliance.edit-policy', compact('policy'));
    }

    public function updatePolicy(Request $request, CompliancePolicy $policy)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');
        $validated['updated_by'] = auth()->guard('admin')->id();

        $policy->update($validated);

        return redirect()->route('admin.compliance.policies')
            ->with('success', 'Policy updated successfully.');
    }

    public function createPolicy()
    {
        $policyTypes = [
            'privacy_policy' => 'Privacy Policy',
            'terms_of_service' => 'Terms of Service',
            'cookie_policy' => 'Cookie Policy',
            'data_retention' => 'Data Retention Policy',
            'gdpr' => 'GDPR Compliance',
        ];

        $existingTypes = CompliancePolicy::pluck('policy_type')->toArray();
        $availableTypes = array_diff_key($policyTypes, array_flip($existingTypes));

        return view('admin.compliance.create-policy', compact('availableTypes'));
    }

    public function storePolicy(Request $request)
    {
        $validated = $request->validate([
            'policy_type' => 'required|string|unique:compliance_policies,policy_type',
            'content' => 'required|string',
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');
        $validated['updated_by'] = auth()->guard('admin')->id();

        CompliancePolicy::create($validated);

        return redirect()->route('admin.compliance.policies')
            ->with('success', 'Policy created successfully.');
    }

    public function dataRequests(Request $request)
    {
        $query = DataRequest::query();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('request_type', $request->type);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.compliance.data-requests', compact('requests'));
    }

    public function showDataRequest(DataRequest $dataRequest)
    {
        return view('admin.compliance.show-data-request', compact('dataRequest'));
    }

    public function processDataRequest(Request $request, DataRequest $dataRequest)
    {
        $validated = $request->validate([
            'action' => 'required|in:process,complete,reject',
            'notes' => 'nullable|string',
        ]);

        $adminId = auth()->guard('admin')->id();

        switch ($validated['action']) {
            case 'process':
                $dataRequest->markAsProcessing($adminId);
                $message = 'Request marked as processing.';
                break;
            case 'complete':
                $dataRequest->markAsCompleted($adminId);
                $message = 'Request marked as completed.';
                break;
            case 'reject':
                $dataRequest->markAsRejected($validated['notes'] ?? 'Rejected by admin', $adminId);
                $message = 'Request rejected.';
                break;
        }

        return redirect()->route('admin.compliance.data-requests')
            ->with('success', $message);
    }

    public function retentionRules()
    {
        $rules = DataRetentionRule::all();
        return view('admin.compliance.retention-rules', compact('rules'));
    }

    public function storeRetentionRule(Request $request)
    {
        $validated = $request->validate([
            'data_type' => 'required|string|unique:data_retention_rules,data_type',
            'retention_days' => 'required|integer|min:1',
            'auto_delete' => 'boolean',
            'active' => 'boolean',
        ]);

        $validated['auto_delete'] = $request->has('auto_delete');
        $validated['active'] = $request->has('active');

        DataRetentionRule::create($validated);

        return redirect()->route('admin.compliance.retention-rules')
            ->with('success', 'Retention rule created successfully.');
    }

    public function updateRetentionRule(Request $request, DataRetentionRule $rule)
    {
        $validated = $request->validate([
            'retention_days' => 'required|integer|min:1',
            'auto_delete' => 'boolean',
            'active' => 'boolean',
        ]);

        $validated['auto_delete'] = $request->has('auto_delete');
        $validated['active'] = $request->has('active');

        $rule->update($validated);

        return redirect()->route('admin.compliance.retention-rules')
            ->with('success', 'Retention rule updated successfully.');
    }
}
