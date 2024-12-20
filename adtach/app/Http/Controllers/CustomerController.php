<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\user;
use App\Models\customerNumber;
use App\Models\customerResponse;
use App\Models\oldCustomer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function storeCustomerDetail(Request $req){
    //   return now();
        $req->validate([
            'customer_name' => 'required|string',
            'customer_number' => 'required|numeric|unique:customers,customer_number',
            'customer_email' => 'unique:customers,customer_email',
            'price' => 'required|numeric',
            'remarks' => 'required',
            'status' => 'required', 
            'date' => 'required'
            
        ]);
        
        $email = $req->customer_email ?: 'No Email'; 
        
        $customer = customer::create([
            'customer_name' => $req->customer_name,
            'customer_email' => $email,
            'customer_number' => $req->customer_number,
            'price' => $req->price,
            'remarks' => $req->remarks,
            'status' => $req->status,  
            'a_name' => Auth::id(), 
            'regitr_date' => $req->date
        ]);
        $customer->created_at = now();
        $customer->updated_at = now();
         $customer->regitr_date = $req->date;
        $customer->save();

        $customer->user_name = Auth::user()->name;
        $customer->save();
        
        return back()->with(['success' => 'Customer Created Successfully']);
    }

    public function customerStatus(Request $req,string $id){
       
        $customer = customer::find($id);
        $customer->update([
            'status' => $req->status
        ]);

        return back()->with(['update' => 'Update Customer Status Successfuly']);
    }

    public function customerSalesTable(){
        $oldcustomers = Customer::with('user')->where('a_name', Auth::id())
                              ->where('status', 'sale')
                              ->orderBy('regitr_date','desc')
                              ->get();

        $newCustomer = oldCustomer::with('user')->where('agent', Auth::id())
                                 ->where('status', 'sale')
                                 ->orderBy('regitr_date','desc')
                                 ->get();
          
         $customers = $oldcustomers->merge($newCustomer);
        return view('front.customer_sale',compact(['customers']));
    }

    public function customerLeadTable(){

             $customers = Customer::where('a_name', Auth::id())
                                   ->where('status', 'lead')
                                   ->orderByRaw('MONTH(regitr_date) desc')
                                   ->get();
        // $customers = Customer::where('a_name', Auth::id())->where('status','lead')->get();
        $user = user::where('id', Auth::id())->first();
        return view('front.customer_lead',compact(['user','customers']));
    }

    

    public function customerTrialTable(){
        
           $customers = Customer::where('a_name', Auth::id())
                                   ->where('status', 'trial')
                                   ->orderByRaw('MONTH(regitr_date) desc')
                                   ->get();

        // $customers = Customer::where('a_name',Auth::id())->where('status','trial')->get();
        $user = user::where('id',Auth::id())->first();
        return view('front.customer_trial',compact(['user','customers']));
    }

    public function viewCunstomerNumberTable(){
        $customerNumbers = CustomerNumber::with('user')
                          ->whereDate('date', '<>', today())  // Exclude today's date
                          ->where('agent', Auth::id())
                          ->orderByRaw("CASE 
                            WHEN status = 'pending' THEN 0 
                            WHEN status = 'VM' THEN 1
                            WHEN status = 'not int' THEN 2
                            WHEN status = 'hung up' THEN 3
                            WHEN status = 'not ava' THEN 4
                            WHEN status = 'not in service' THEN 5
                            WHEN status = 'trial' THEN 6
                            ELSE 7 
                        END")
                        ->orderBy('status', 'desc')  // Sort other statuses in descending order
                       ->get();
         return view('front.customer_number',compact('customerNumbers')); 
    }
    
    public function storeCustomerNumbersDetails(Request $req,string $id){
        $req->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'remarks' => 'required',
        ]);
        $customer = CustomerNumber::find($id);

        $customer->customer_name = $req->customer_name;
        $customer->status = $req->status;
        $customer->remarks = $req->remarks;
        $customer->save();

        return redirect()->route('viewCunstomerNumberTable')->with(['success' => 'Add Customer Information Successfuly']);
    }
  
    public function viewCustomerNumberEditForm(string $id){
        $customer = CustomerNumber::find($id);
        return view('front.edit_customer_number',compact('customer'));
    }

      public function storeCustomerNumberEditDetails(Request $req, string $id){
        $req->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'remarks' => 'required',
        ]);

        $customer = CustomerNumber::find($id);

        $customer->customer_name = $req->customer_name;
        $customer->status = $req->status;
        $customer->remarks = $req->remarks;
        $customer->save();

        return redirect()->route('viewCunstomerNumberTable')->with(['success' => 'Update Customer Information Successfuly']);

      }


    public function viewEditCustomerSaleDetailForm(Request $req, string $id){
       $customer = customer::where('a_name',Auth::id())->find($id);

       return view('front.edit_customer_sale',compact('customer'));
    }

    public function storeEditCustomerSaleDetails(request $req,string $id){
         $req->validate([
            'price' => 'required',
            'remarks' => 'required',
         ]);
         $customer = customer::find($id);

         $customer->price = $req->price;
         $customer->remarks = $req->remarks;
         $customer->save();

         return redirect()->route('customerSalesTable')->with(['success' => 'Update Sale Detail Successfuly']);
    }


    public function  viewOldCustomerNewPKG(string $id){
        $oldCustomerData = customer::find($id);
        return view('front.add_old_customer_sale',compact('oldCustomerData'));
    }
    
    public function storeOldCustomerNewPKGData(Request $req,string $id){
        $req->validate([
            'price' => 'required',
            'date' => 'required',
            'remarks' => 'required',
        ]);
        // return $req;
        $oldCustomerData = customer::find($id);
       $NewCustomer = oldCustomer::create([
            'customer_name' => $oldCustomerData->customer_name,
            'customer_number' => $oldCustomerData->customer_number,
            'customer_email' => 'No Email',
            'price' => $req->price,
            'status' => 'sale',
            'remarks' => $req->remarks,
        ]);
        $NewCustomer->regitr_date = $req->date;
        $NewCustomer->agent = Auth::id();
        $NewCustomer->save();
        return redirect()->route('customerSalesTable')->with(['success' => 'Add New Customer Successfully']);
    }
}
