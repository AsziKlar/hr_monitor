<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index() {
        $auditLogs = AuditLog::all();

        return view('admin.audit-logs', compact('auditLogs'));
    }
}
