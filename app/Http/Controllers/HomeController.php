<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\company_share_mappings;
use App\Models\company_share_data;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\CompanyShareDataExport;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function userlist()
    {
        $users = User::where('user_type', '<>', 'a')->get();
        return view('users_list', compact('users'));
    }

    public function getStockYears(Request $request)
    {
        $company_id = $request->input('company_id');
        $stockYears = company_share_data::where('CompanyId', $company_id)->distinct()->pluck('StockYear')->toArray();
        
        return response()->json(['stockYears' => $stockYears]);
    }

    public function search(Request $request)
    {
        $companyId = $request->input('company_id');
        $stockYear = $request->input('span_year');

        $companyShareData = company_share_data::where('CompanyId', $companyId)
            ->where('StockYear', $stockYear)
            ->get();

        return response()->json(['companyShareData' => $companyShareData]);
    }



    public function fetchData(Request $request)
    {
        $selectedYears = $request->input('span_year');
        $selectedCompany = $request->input('company_id');

        $data = company_share_data::whereIn('span_year', $selectedYears)
            ->where('company_id', $selectedCompany)
            ->select('sharedcompanyname', 'percentage')
            ->get();

            

        return response()->json($data);
    }
    
    

    public function approve(User $user)
    {
        $user->update(['user_status' => 'a']);

        return redirect()->back();
    }


    public function reject(User $user)
    {
        $user->update(['user_status' => 'r']);
        $user->delete();
        return redirect()->back();
    }


    public function mapping()
    {
        $users = User::where('user_status', 'a')->get();
        return view('mapping', compact('users'));
    }
    public function map_company($companyid)
    {
        # code...

        $companies = User::where('user_status', 'a')
        ->where('user_type','u')
        ->whereNotIn('id', [$companyid])
        ->get();
        return view('map_company',compact('companies'));
    }

    public function mapCompanyDetails(Request $request)
    {
       
        $exist_comapny = company_share_mappings::where('company_id', $request->id)->delete();
        //dd($exist_comapny);

        if (count($request->comapnies_id) > 0 && $request->comapnies_id != null) {
            for ($i = 0; $i < count($request->comapnies_id); $i++) {

                $comapny_share = new company_share_mappings();
                $comapny_share->shared_companies_id = $request->comapnies_id[$i];
                $comapny_share->company_id = $request->id;
                $comapny_share->save();

            }

        }
        return redirect()->back()->with('success', 'Companies mapped');
    }


    public function registerModel()
    {
        # code...
        return view('registerModel');
    }

    // public function download($companyId)
    // {
    //     $fileName = 'company_share_data.xlsx';

    //     $export = new CompanyShareDataExport($companyId);

    //     return Response::streamDownload(function () use ($export) {
    //         $export->store('public');
    //     }, $fileName);
    // }

    // public function download($companyId)
    // {
    //     $fileName = 'company_share_data.xlsx';

    //     return (new CompanyShareDataExport($companyId))->download($fileName);
    // }


}
