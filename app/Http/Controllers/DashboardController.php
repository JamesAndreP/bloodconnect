<?php

namespace App\Http\Controllers;


use App\Models\Hospital;
use App\Models\User;
use App\Models\DonationRequest;
use App\Models\BloodRequest;
use App\Services\BloodRequestService;
use App\Services\DashboardService;
use App\Services\DonationRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    protected $service;
    protected $donationRequestService;
    protected $bloodRequestService;

    public function __construct(
        DashboardService $service,
        DonationRequestService $donationRequestService,
        BloodRequestService $bloodRequestService,
    ) {
        $this->service = $service;
        $this->donationRequestService = $donationRequestService;
        $this->bloodRequestService = $bloodRequestService;
    }
    public function index()
    {
        switch (Auth::User()->role->value) {
            case 'donor':
                $latestActive = $this->service->findLatestActiveDonation();
                $latest = $this->service->findLatestDonationRequest();
                $all = $this->service->findAllByDonor();
                $allScheduled = $this->service->findAllScheduledByDonor();
                return view('donor-dashboard')->with([
                    'latest' => $latest,
                    'latest_active' => $latestActive,
                    'all_count' => $all->count(),
                    'all_scheduled_count' => $allScheduled->count(),
                ]);
                break;
            case 'hospital':
                $donationRequests = $this->donationRequestService->getAllByHospital();
                $rescheduleRequests = $this->donationRequestService->getAllRescheduleByHospital();
                $allBloodRequests = $this->bloodRequestService->getAll();
                $bloodRequests = $this->bloodRequestService->getAllByHospital();
                return view('hospital-dashboard')->with([
                    'pending_count' => $donationRequests->count(),
                    'reschedule_count' => $rescheduleRequests->count(),
                    'blood_request_count' => $bloodRequests->count(),
                    'all_blood_request_count' => $allBloodRequests->count(),
                ]);
                break;
            default:
                $allBloodRequests = $this->bloodRequestService->getAll();
                $donationRequests = $this->donationRequestService->getAll();
                $users = User::get();
                $hospitals = Hospital::get();
                return view('dashboard')->with([
                    'blood_request_count' => $allBloodRequests->count(),
                    'donation_request_count' => $donationRequests->count(),
                    'user_count' => $users->count(),
                    'hospital_count' => $hospitals->count(),
                ]);
                break;
        }
    }

    public function hospitalData()
    {
        $data = $this->donationRequestService->getMonthlyDataThisYearByHospital();
        $accepted_data = $this->donationRequestService->getMonthlyAcceptedDataThisYearByHospital();
        $mapped_data = $data->map(function ($item) {
            $item['month_name'] = \Carbon\Carbon::create()->month($item['month'])->format('M');
            return $item;
        });
        $accepted_mapped_data = $accepted_data->map(function ($item) {
            $item['month_name'] = \Carbon\Carbon::create()->month($item['month'])->format('M');
            return $item;
        });
        return (object) [
            'total_requests' => $mapped_data,
            'total_accepted_requests' => $accepted_mapped_data
        ];
    }

    public function exportDonationRequests()
    {
        $donationRequests = $this->donationRequestService->getAllWithRelationWithDeleted();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ✅ Define headings
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Birth Date');
        $sheet->setCellValue('E1', 'Hospital');
        $sheet->setCellValue('F1', 'Request Date');

        // ✅ Fill data (starting row 2)
        $row = 2;
        foreach ($donationRequests as $request) {
            $sheet->setCellValue("A{$row}", $request->id);
            $sheet->setCellValue("B{$row}", $request?->user->name);
            $sheet->setCellValue("C{$row}", $request?->user->email);
            $sheet->setCellValue("D{$row}", $request?->user->birth_date);
            $sheet->setCellValue("E{$row}", $request?->hospital->name);
            $sheet->setCellValue("F{$row}", $request->created_at->format('Y-m-d H:i'));
            $row++;
        }

        // ✅ Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ✅ Stream the file to browser
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="donation_requests.xlsx"',
        ]);
    }

    public function exportBloodRequests()
    {
        $bloodRequests = $this->bloodRequestService->getAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ✅ Define headings
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Requester');
        $sheet->setCellValue('C1', 'Blood Type');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Urgency Level');
        $sheet->setCellValue('F1', 'Request Date');

        // ✅ Fill data (starting row 2)
        $row = 2;
        foreach ($bloodRequests as $request) {
            $sheet->setCellValue("A{$row}", $request->id);
            $sheet->setCellValue("B{$row}", $request->hospital->name);
            $sheet->setCellValue("C{$row}", $request->blood_type);
            $sheet->setCellValue("D{$row}", $request->quantity);
            $sheet->setCellValue("E{$row}", $request->urgency_lvl);
            $sheet->setCellValue("F{$row}", $request->request_date->format('Y-m-d H:i'));
            $row++;
        }

        // ✅ Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ✅ Stream the file to browser
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="blood_requests.xlsx"',
        ]);
    }

    public function exportHospitals()
    {
        $hospitals = Hospital::with(['user'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ✅ Define headings
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Admin Name');
        $sheet->setCellValue('D1', 'Location');
        $sheet->setCellValue('E1', 'Latitude');
        $sheet->setCellValue('F1', 'Longitude');

        // ✅ Fill data (starting row 2)
        $row = 2;
        foreach ($hospitals as $hospital) {
            $sheet->setCellValue("A{$row}", $hospital->id);
            $sheet->setCellValue("B{$row}", $hospital->name);
            $sheet->setCellValue("C{$row}", $hospital->user->name);
            $sheet->setCellValue("D{$row}", explode('|', $hospital->location)[0]);
            $sheet->setCellValue("E{$row}", explode('|', $hospital->location)[1]);
            $sheet->setCellValue("F{$row}", explode('|', $hospital->location)[2]);
            $row++;
        }

        // ✅ Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ✅ Stream the file to browser
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="hospitals.xlsx"',
        ]);
    }

    public function exportUsers()
    {
        $users = User::get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ✅ Define headings
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Role');
        $sheet->setCellValue('E1', 'Birth Date');
        $sheet->setCellValue('F1', 'Gender');
        $sheet->setCellValue('G1', 'Phone Number');
        $sheet->setCellValue('H1', 'Status');

        // ✅ Fill data (starting row 2)
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue("A{$row}", $user->id);
            $sheet->setCellValue("B{$row}", $user->name);
            $sheet->setCellValue("C{$row}", $user->email);
            $sheet->setCellValue("D{$row}", $user->role->value);
            $sheet->setCellValue("E{$row}", $user->birth_date);
            $sheet->setCellValue("F{$row}", $user->gender);
            $sheet->setCellValue("G{$row}", $user->phone);
            $sheet->setCellValue("H{$row}", $user->status);
            $row++;
        }

        // ✅ Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ✅ Stream the file to browser
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="users.xlsx"',
        ]);
        
    }
    public function exportUsersPdf()
{
    $users = User::get();

    $pdf = Pdf::loadView('reports.users-pdf', compact('users'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('users-report.pdf');
}
public function exportHospitalsPdf()
{
    $hospitals = Hospital::with(['user'])->get();

    $pdf = Pdf::loadView('reports.hospitals-pdf', compact('hospitals'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('hospitals-report.pdf');
}
public function exportDonationRequestsPdf()
{
    $donationRequests = $this->donationRequestService->getAllWithRelationWithDeleted();

    $pdf = Pdf::loadView('reports.donation-requests', compact('donationRequests'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('donation-requests-report.pdf');
}
public function exportBloodRequestsPdf()
{
    $bloodRequests = $this->bloodRequestService->getAll();

    $pdf = Pdf::loadView('reports.blood-requests-pdf', compact('bloodRequests'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('blood-requests-report.pdf');
}
public function exportFilteredPdf(Request $request)
{
    $from = $request->from;
    $to = $request->to;
    $report = $request->report;

    if ($report === 'users') {
        $users = User::when($from, function ($query) use ($from) {
                return $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                return $query->whereDate('created_at', '<=', $to);
            })
            ->get();

        $pdf = Pdf::loadView('reports.users-pdf', compact('users', 'from', 'to'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('users-report.pdf');
    }

    if ($report === 'hospitals') {
        $hospitals = Hospital::when($from, function ($query) use ($from) {
                return $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                return $query->whereDate('created_at', '<=', $to);
            })
            ->get();

        $pdf = Pdf::loadView('reports.hospitals-pdf', compact('hospitals', 'from', 'to'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('hospitals-report.pdf');
    }

    if ($report === 'donation') {
        $donationRequests = \App\Models\DonationRequest::when($from, function ($query) use ($from) {
                return $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                return $query->whereDate('created_at', '<=', $to);
            })
            ->get();

        $pdf = Pdf::loadView('reports.donation-requests', compact('donationRequests', 'from', 'to'))
    ->setPaper('a4', 'landscape');
            

        return $pdf->download('donation-requests-report.pdf');
    }

    if ($report === 'blood') {
        $bloodRequests = \App\Models\BloodRequest::when($from, function ($query) use ($from) {
                return $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                return $query->whereDate('created_at', '<=', $to);
            })
            ->get();

        $pdf = Pdf::loadView('reports.blood-requests-pdf', compact('bloodRequests', 'from', 'to'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('blood-requests-report.pdf');
    }

    return back()->with('error', 'Invalid report type selected.');
}
}
