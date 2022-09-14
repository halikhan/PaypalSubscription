<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Paypalpayment;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('Package');
        $getCMS = Package::all();
        return view('Package.index',get_defined_vars());

    }
    public function paypal($id)
    {
        // dd($id);
        session()->put('package_id', $id);
        $getPackage = Package::find($id);
        return view('Package.paypal',get_defined_vars());

    }
    public function store_payment(Request $request)
    {
        // dd($request->all());

        $get_package = Package::find(session()->get('package_id'));
        Paypalpayment::create([
            // 'response'=> $request->response,
            'user_id' => Auth::user()->id,
            'package_id' => $get_package->id,
            'name' =>  Auth::user()->name,
            'package_amount' => $get_package->amount,
            'package_response' => json_encode($request->all()),
        ]);

        session()->forget('package_id');
        return response()->json([
            'status' => 200
        ]);
    }

    public function plans()
    {
        // dd('Package');
        $getCMS = Package::all();
        return view('Package.plan',get_defined_vars());

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('Package.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'details' => "required|max:255",
            'amount' => "required|max:255",
            'type' => "required|max:255",
            // 'title' => "required|unique:packages",
        ]);

        $cms = new Package();
        $cms->amount = $request->amount;
        $cms->type = $request->type;
        $cms->details = $request->details;
        $cms->save();
        $notification = array('message' =>'Your data Inserted Successfully ' , 'alert-type'=>'success' );
        return redirect()->route('Package')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_data = Package::where('id',$id)->first();
        return view('Package.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'details' => "required|max:255",
            'amount' => "required|max:255",
            'type' => "required|max:255",
        ]);

        $cms = Package::findOrFail($id);
        $cms->amount = $request->amount;
        $cms->type = $request->type;
        $cms->details = $request->details;
        $cms->save();

        $notification = array('message' =>'Your data updateed Successfully ' , 'alert-type'=>'success' );
        return redirect()->route('Package')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // dd($id);
        $cms = Package::where('id',$id)->first();
        $cms->delete();
        return redirect()->route('Package');
    }


}
