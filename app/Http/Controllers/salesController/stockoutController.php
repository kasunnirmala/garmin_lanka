<?php

namespace App\Http\Controllers\salesController;

use App\Customer;
use App\Http\Controllers\Controller;
use App\item;
use App\Product;
use Illuminate\Http\Request;

class stockoutController extends Controller
{
    public function index()
    {
//        $item = item::create(['itemCode' => 'qweqwe', 'itemDsc' => 'qqqqqq', 'product_id' => 1, 'in_stock' => true, 'customer' => null, 'customer_name' => null, 'stock_out_date' => null]);
//        item::where('itemCode', '=', 'asdasd')->first()->update(array('in_stock' => false, 'customer' => 1, 'customer_name' => 'Nimal', 'stock_out_date' => new \DateTime(),));
        $customers = Customer::all();
        return view('sales.stockout', [
            'customers' => $customers
        ]);
    }


    public function addCustomer(Request $request)
    {
        $data = $request->input();
        Customer::create($data);
        return redirect('/sales/view');
    }


    public function getItem(Request $request)
    {
        $data = $request->input();
        $item = item::where('itemCode', '=', $data['code'])->first();
        return $item;
    }


    public function stockOut(Request $request)
    {
        $data = $request->input();

        $customer_id = $data['data']['customer_id'];

        $customer = Customer::where('id', '=', $customer_id)->first();

        $itemList = $data['data']['itemList'];
//        return $customer->id;

        foreach ($itemList as $item) {
            if ($item['serial_code']) {
                item::where('itemCode', '=', $item['serial_code'])->first()->update(array('in_stock' => false, 'customer' => $customer->id, 'customer_name' => $customer->customer_name, 'stock_out_date' => new \DateTime(),));
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);

    }
}
