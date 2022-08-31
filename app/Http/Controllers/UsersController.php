<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\ExpType;
use App\Models\BillsType;
use App\Models\ExpenditureModel;

class UsersController extends Controller
{
    function __construct(){
        session_start();
    }
    public function login(Request $req)
    {
        $req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $email = $req->email;
        $password = $req->password;
        $confirm_email = UserModel::where('email', '=', $email)->count();
        if($confirm_email > 0)
        {
            $hashedPassword = UserModel::where('email', '=', $email)->get('password');
            if(Hash::check($password, $hashedPassword[0]->password))
            {
                $get_user_data = UserModel::where('email', '=', $email)->get(['id','name','image']);
                $req->session()->put('USER_ID', $get_user_data[0]->id);
                $req->session()->put('USER_NAME', $get_user_data[0]->name);
                $req->session()->put('USER_IMAGE', $get_user_data[0]->image);
                $req->session()->put('EMAIL', $email);
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('login_status', 'Failed to Login');
                return redirect('/');
            }
        }
        else
        {
            $req->session()->flash('login_status', 'Failed to Login');
            return redirect('/');
        }
    }
    public function logout(Request $req)
    {
        $req->session()->flush();
        return redirect('/');
    }
    public function dashboard(Request $req){
        $getexp = ExpenditureModel::orderBy('date', 'desc')->get();
        $getexp_type = ExpType::get();
        $getbill_type = BillsType::get();
        return view('dashboard', ['getexp'=> $getexp, 'getexp_type'=>$getexp_type, 'getbill_type'=>$getbill_type]);
    }
    public function expNBills(Request $req)
    {
        $getexp_type = ExpType::orderBy('id', 'desc')->get();
        $getbills_type = BillsType::orderBy('id', 'desc')->get();
        return view('expNBills',['getexp_type'=>$getexp_type, 'getbills_type'=>$getbills_type]);
    }
    public function addExpType(Request $req)
    {
        $data = new ExpType();
        $data->exp_type = $req->expenditure_type;
        $confirm_save = $data->save();
        if($confirm_save)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Type Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Add Expenditure Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }    
    }
    public function addBillType(Request $req)
    {
        $data = new BillsType();
        $data->bills_type = $req->bills_type;
        $confirm_save = $data->save();
        if($confirm_save)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Bill Type Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Add Bill Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }    
    }
    public function editExpType(Request $req)
    {
        $update_exp_type = ExpType::find($req->edit_exp_id);
        $update_exp_type->exp_type = $req->edit_expenditure_type;
        $confirm_update = $update_exp_type->save();
        if($confirm_update)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Type Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Update Expenditure Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
    }
    public function editBillType(Request $req)
    {
        $update_bill_type = BillsType::find($req->edit_bill_id);
        $update_bill_type->bills_type = $req->edit_bill_type;
        $confirm_update = $update_bill_type->save();
        if($confirm_update)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Bill Type Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Update Bill Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
    }
    public function delete_exp_type(Request $req)
    {
        $delete_exp_type = ExpType::find($req->id);
        $confirm_delete = $delete_exp_type->delete();
        if($confirm_delete)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Type Deleted Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Delete Expenditure Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
    }
    public function delete_bill_type(Request $req)
    {
        $delete_bill_type = BillsType::find($req->id);
        $confirm_delete = $delete_bill_type->delete();
        if($confirm_delete)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Type Deleted Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Delete Expenditure Type</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('expNBills');
        }
    }
    public function addExp(Request $req)
    {
        if($req->bill == "")
        {
            $expenditure_data = explode(',', $req->expenditure);
            $expdata = new ExpenditureModel();
            $expdata->exp_type_id = $expenditure_data[0];
            $expdata->exp = $expenditure_data[1];
            $expdata->amount = $req->amount;
            $expdata->desc = $req->description;
            $expdata->added_by = session()->get('USER_ID');
            $expdata->date = $req->date;
            $confirm_save = $expdata->save();
            if($confirm_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Failed to Add Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
        }
        else
        {
            $expenditure_data = explode(',', $req->expenditure);
            $bill_data = explode(',', $req->bill);
            $expdata = new ExpenditureModel();
            $expdata->exp_type_id = $expenditure_data[0];
            $expdata->exp = $expenditure_data[1];
            $expdata->bill_type_id = $bill_data[0];
            $expdata->bills = $bill_data[1];
            $expdata->amount = $req->amount;
            $expdata->desc = $req->description;
            $expdata->added_by = session()->get('USER_ID');
            $expdata->date = $req->date;
            $confirm_save = $expdata->save();
            if($confirm_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Failed to Add Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
        }
    }
    public function editExp(Request $req)
    {
        // return $req;
        if($req->bill_type_id == "")
        {
            //Normal -> Normal
            // Bill -> Normal
            $expdata = ExpenditureModel::find($req->edit_id);
            $expenditure_data = explode(',', $req->edit_expenditure);
            $expdata->exp_type_id = $expenditure_data[0];
            $expdata->exp = $expenditure_data[1];
            $expdata->bill_type_id = NULL;
            $expdata->bills = NULL;
            $expdata->amount = $req->edit_amount;
            $expdata->desc = $req->edit_description;
            $expdata->date = $req->edit_date;
            $confirm_save = $expdata->save();
            if($confirm_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Failed to Update Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
        }
        else if($req->bill_type_id == 'yes')
        {
            //Normal->Bill
            $expdata = ExpenditureModel::find($req->edit_id);
            $expenditure_data = explode(',', $req->edit_expenditure);
            $expdata->exp_type_id = $expenditure_data[0];
            $expdata->exp = $expenditure_data[1];
            $bill_data = explode(',', $req->edit_bill);
            $expdata->bill_type_id = $bill_data[0];
            $expdata->bills = $bill_data[1];
            $expdata->amount = $req->edit_amount;
            $expdata->desc = $req->edit_description;
            $expdata->date = $req->edit_date;
            $confirm_save = $expdata->save();
            if($confirm_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Failed to Update Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
        }
        else
        {
            //Bill->Bill
            $expdata = ExpenditureModel::find($req->edit_id);
            $expenditure_data = explode(',', $req->edit_expenditure);
            $bill_data = explode(',', $req->edit_bill);
            $expdata->exp_type_id = $req->exp_type_id;
            $expdata->bill_type_id = $req->bill_type_id;
            $expdata->exp = $expenditure_data[1];
            $expdata->bills = $bill_data[1];
            $expdata->amount = $req->edit_amount;
            $expdata->desc = $req->edit_description;
            $expdata->date = $req->edit_date;
            $confirm_save = $expdata->save();
            if($confirm_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Failed to Update Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('dashboard');
            }
        }
    }
    public function delete_exp(Request $req)
    {
        $data = ExpenditureModel::find($req->id);
        $confirm_delete = $data->delete();
        if($confirm_delete)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Expenditure Deleted successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Delete Expenditure</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
}
