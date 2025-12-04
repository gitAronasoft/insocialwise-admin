<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\UserPost;
use App\Models\Subscription;
use App\Models\SocialUserPage;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'metrics' => 'required|array|min:1',
            'metrics.*' => 'string',
            'group_by' => 'required|in:daily,weekly,monthly',
        ]);

        $dateFrom = Carbon::parse($validated['date_from'])->startOfDay();
        $dateTo = Carbon::parse($validated['date_to'])->endOfDay();
        $groupBy = $validated['group_by'];
        $metrics = $validated['metrics'];

        $labels = $this->generateLabels($dateFrom, $dateTo, $groupBy);
        $datasets = [];

        foreach ($metrics as $metric) {
            $data = $this->getMetricData($metric, $dateFrom, $dateTo, $groupBy, $labels);
            $datasets[$metric] = [
                'label' => $this->getMetricLabel($metric),
                'data' => $data,
                'total' => array_sum($data),
            ];
        }

        return response()->json([
            'success' => true,
            'labels' => array_values($labels),
            'datasets' => $datasets,
        ]);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'metrics' => 'required|array|min:1',
            'group_by' => 'required|in:daily,weekly,monthly',
            'format' => 'required|in:csv,json',
        ]);

        $dateFrom = Carbon::parse($validated['date_from'])->startOfDay();
        $dateTo = Carbon::parse($validated['date_to'])->endOfDay();
        $groupBy = $validated['group_by'];
        $metrics = $validated['metrics'];

        $labels = $this->generateLabels($dateFrom, $dateTo, $groupBy);
        $data = [];

        foreach ($labels as $label) {
            $row = ['period' => $label];
            foreach ($metrics as $metric) {
                $row[$metric] = 0;
            }
            $data[] = $row;
        }

        foreach ($metrics as $metric) {
            $metricData = $this->getMetricData($metric, $dateFrom, $dateTo, $groupBy, $labels);
            foreach ($metricData as $index => $value) {
                $data[$index][$metric] = $value;
            }
        }

        if ($validated['format'] === 'csv') {
            $csv = $this->generateCsv($data, $metrics);
            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="report_' . date('Y-m-d') . '.csv"',
            ]);
        }

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="report_' . date('Y-m-d') . '.json"',
        ]);
    }

    private function generateLabels(Carbon $dateFrom, Carbon $dateTo, string $groupBy): array
    {
        $labels = [];
        $current = $dateFrom->copy();

        while ($current <= $dateTo) {
            switch ($groupBy) {
                case 'daily':
                    $labels[$current->format('Y-m-d')] = $current->format('M d, Y');
                    $current->addDay();
                    break;
                case 'weekly':
                    $labels[$current->format('Y-W')] = 'Week ' . $current->weekOfYear . ', ' . $current->year;
                    $current->addWeek();
                    break;
                case 'monthly':
                    $labels[$current->format('Y-m')] = $current->format('M Y');
                    $current->addMonth();
                    break;
            }
        }

        return $labels;
    }

    private function getMetricData(string $metric, Carbon $dateFrom, Carbon $dateTo, string $groupBy, array $labels): array
    {
        $data = array_fill(0, count($labels), 0);
        $labelKeys = array_keys($labels);

        switch ($metric) {
            case 'customers':
                $results = Customer::where('role', 'User')
                    ->whereBetween('createdAt', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'createdAt') . ' as period'), DB::raw('COUNT(*) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            case 'revenue':
                $results = Transaction::where('status', 'succeeded')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'created_at') . ' as period'), DB::raw('SUM(amount) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            case 'posts':
                $results = UserPost::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'created_at') . ' as period'), DB::raw('COUNT(*) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            case 'subscriptions':
                $results = Subscription::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'created_at') . ' as period'), DB::raw('COUNT(*) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            case 'pages':
                $results = SocialUserPage::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'created_at') . ' as period'), DB::raw('COUNT(*) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            case 'campaigns':
                $results = Campaign::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->select(DB::raw($this->getGroupByExpression($groupBy, 'created_at') . ' as period'), DB::raw('COUNT(*) as count'))
                    ->groupBy('period')
                    ->get();
                break;

            default:
                return $data;
        }

        foreach ($results as $result) {
            $index = array_search($result->period, $labelKeys);
            if ($index !== false) {
                $data[$index] = (float) $result->count;
            }
        }

        return $data;
    }

    private function getGroupByExpression(string $groupBy, string $column): string
    {
        return match ($groupBy) {
            'daily' => "DATE_FORMAT({$column}, '%Y-%m-%d')",
            'weekly' => "DATE_FORMAT({$column}, '%Y-%v')",
            'monthly' => "DATE_FORMAT({$column}, '%Y-%m')",
            default => "DATE_FORMAT({$column}, '%Y-%m-%d')",
        };
    }

    private function getMetricLabel(string $metric): string
    {
        return match ($metric) {
            'customers' => 'New Customers',
            'revenue' => 'Revenue ($)',
            'posts' => 'Posts Created',
            'subscriptions' => 'New Subscriptions',
            'pages' => 'Pages Connected',
            'campaigns' => 'Campaigns Created',
            default => ucfirst($metric),
        };
    }

    private function generateCsv(array $data, array $metrics): string
    {
        $headers = ['Period'];
        foreach ($metrics as $metric) {
            $headers[] = $this->getMetricLabel($metric);
        }

        $csv = implode(',', $headers) . "\n";

        foreach ($data as $row) {
            $values = [$row['period']];
            foreach ($metrics as $metric) {
                $values[] = $row[$metric] ?? 0;
            }
            $csv .= implode(',', $values) . "\n";
        }

        return $csv;
    }
}
