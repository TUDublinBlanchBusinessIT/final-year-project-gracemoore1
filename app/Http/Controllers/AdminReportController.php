<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class AdminReportController extends Controller
{
    private function adminGuard()
    {
        if (!(session('role') === 'admin' || session('admin_id'))) abort(403);
    }

    private function tableForRole($role)
    {
        return match($role) {
            'student' => 'student',
            'landlord' => 'landlord',
            'serviceprovider' => 'serviceproviderpartnership',
        };
    }

    private function fullName($role, $id)
    {
        $row = DB::table($this->tableForRole($role))->where('id', $id)->first();
        if (!$row) return "{$role} #{$id}";
        return trim(($row->firstname ?? '').' '.($row->surname ?? '')) ?: "{$role} #{$id}";
    }

    private function emailFor($role, $id)
    {
        $table = $this->tableForRole($role);
        foreach (['email','schoolemail','schoolEmail','personalEmail'] as $col) {
            if (Schema::hasColumn($table, $col)) {
                $val = DB::table($table)->where('id', $id)->value($col);
                if ($val) return $val;
            }
        }
        return null;
    }

    // Extract SUBJECT: line from description
    private function extractSubject($description)
    {
        if (!$description) return 'No subject';
        if (preg_match('/SUBJECT:\s*(.*)/', $description, $m)) {
            return trim($m[1]) ?: 'No subject';
        }
        return 'No subject';
    }

    // Extract evidence paths from description
    private function extractEvidence($description)
    {
        if (!$description) return [];
        $lines = preg_split("/\r\n|\n|\r/", $description);
        $paths = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '- ')) {
                $paths[] = trim(substr($line, 2));
            }
        }
        return $paths;
    }

    public function index()
    {
        $this->adminGuard();

        $reports = DB::table('complaint')->orderByDesc('created_at')->get();

        // Add extracted subject to each report (for preview)
        foreach ($reports as $r) {
            $r->subject_preview = $this->extractSubject($r->description);
        }

        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $this->adminGuard();

        $report = DB::table('complaint')->where('id', $id)->first();
        abort_if(!$report, 404);

        $reporterName = $this->fullName($report->reporter_role, $report->reporter_id);
        $reportedName = $this->fullName($report->reported_user_role, $report->reported_user_id);

        $subject = $this->extractSubject($report->description);
        $evidencePaths = $this->extractEvidence($report->description);

        return view('admin.reports.show', compact('report','reporterName','reportedName','subject','evidencePaths'));
    }

    public function noAction($id)
    {
        $this->adminGuard();

        $report = DB::table('complaint')->where('id', $id)->first();
        abort_if(!$report, 404);

        DB::table('complaint')->where('id', $id)->update([
            'administratorid' => session('admin_id'),
            'updated_at' => now(),
        ]);

        $reportedName  = $this->fullName($report->reported_user_role, $report->reported_user_id);
        $reporterEmail = $this->emailFor($report->reporter_role, $report->reporter_id);

        if ($reporterEmail) {
            Mail::raw(
                "RentConnect reviewed your report against {$reportedName} and decided: No action needed.",
                fn($m) => $m->to($reporterEmail)->subject("RentConnect report outcome")
            );
        }

        return redirect()->route('admin.reports')->with('success','No action selected.');
    }

    public function toBeHandled()
    {
        $reports = DB::table('complaint')
            ->whereNull('administratorid')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.reports.index', [
            'reports' => $reports,
            'activeTab' => 'pending'
        ]);
    }

    public function actionRequired()
    {
        $reports = DB::table('complaint')
            ->whereNotNull('administratorid')
            ->get()
            ->filter(function ($r) {
                return DB::table($this->tableForRole($r->reported_user_role))
                    ->where('id', $r->reported_user_id)
                    ->where('status', 'suspended')
                    ->exists();
            });

        return view('admin.reports.index', [
            'reports' => $reports,
            'activeTab' => 'action'
        ]);
    }

    public function noActionList()
    {
        $reports = DB::table('complaint')
            ->whereNotNull('administratorid')
            ->get()
            ->filter(function ($r) {
                return !DB::table($this->tableForRole($r->reported_user_role))
                    ->where('id', $r->reported_user_id)
                    ->where('status', 'suspended')
                    ->exists();
            });

        return view('admin.reports.index', [
            'reports' => $reports,
            'activeTab' => 'noaction'
        ]);
    }
    public function suspend($id)
    {
        $this->adminGuard();

        $report = DB::table('complaint')->where('id', $id)->first();
        abort_if(!$report, 404);

        DB::table('complaint')->where('id', $id)->update([
            'administratorid' => session('admin_id'),
            'updated_at' => now(),
        ]);

        // Suspend the reported user (based on role)
        DB::table($this->tableForRole($report->reported_user_role))
            ->where('id', $report->reported_user_id)
            ->update(['status' => 'suspended']);

        $reportedName = $this->fullName($report->reported_user_role, $report->reported_user_id);

        $reporterEmail = $this->emailFor($report->reporter_role, $report->reporter_id);
        $reportedEmail = $this->emailFor($report->reported_user_role, $report->reported_user_id);

        // Email reporter about outcome
        if ($reporterEmail) {
            Mail::raw(
                "RentConnect reviewed your report against {$reportedName} and decided: Account suspended.",
                fn($m) => $m->to($reporterEmail)->subject("RentConnect report outcome")
            );
        }

        // Email reported user if suspended
        if ($reportedEmail) {
            Mail::raw(
                "Your RentConnect account has been suspended following a review.",
                fn($m) => $m->to($reportedEmail)->subject("Your account is suspended")
            );
        }

        return redirect()->route('admin.reports')->with('success','Account suspended.');
    }
}