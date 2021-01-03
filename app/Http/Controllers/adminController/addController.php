<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\item;
use App\Product;
use App\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class addController extends Controller
{
    public function index()
    {


        $vendors = Vendor::all();
        return view('admin.add_product', [
            'vendors' => $vendors
        ]);
    }


    public function addVendor(Request $request)
    {
        $data = $request->input();
        Vendor::create($data);
        return redirect('/admin/add');
    }

    public function getProduct(Request $request)
    {
        $data = $request->input();
        $product = Product::where('productCode', '=', $data['code'])->first();
        return $product;
    }


    public function addItems(Request $request)
    {
        $data = $request->input();
        $product_code = $data['data']['product']['productCode'];
        $product_desc = $data['data']['product']['productDesc'];
        $vendor_id = $data['data']['vendor_id'];
        $product = Product::where('productCode', '=', $product_code)->first();
        if (!isset($product)) {
            $product = Product::create(['productCode' => $product_code, 'productDsc' => $product_desc, 'vendor_id' => $vendor_id]);
        }
        $itemList = $data['data']['itemList'];
        foreach ($itemList as $item) {
            $item = item::create(['itemCode' => $item['serial_code'], 'itemDsc' => $item['serial_description'], 'product_id' => $product->id, 'in_stock' => true, 'customer' => null, 'customer_name' => null, 'stock_out_date' => null]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);

    }


    public function addProducts(Request $request)
    {
        $data = $request->input();
        $vendor_id = $data['data']['vendor_id'];
        if ($vendor_id) {
            $productList = $data['data']['productList'];
            foreach ($productList as $product) {

                if (isset($product['product_code'])) {
                    $thisproduct = Product::where('productCode', '=', $product['product_code'])->first();
                    if (!isset($thisproduct)) {
                        Product::create([
                            'productCode' => $product['product_code'],
                            'productDsc' => $product['product_desc'],
                            'vendor_id' => $vendor_id,
                            'qty' => $product['qty'],
                            'unit_price' => $product['unit_price'],
                        ]);
                    } else {
                        $thisproduct->update(array('qty' => $thisproduct->qty + $product['qty'], 'unit_price' => $product['unit_price']));
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        }

        return response()->json([
            'status' => 202,
            'message' => 'No Real Vendor'
        ]);
    }


    public function updateProductAmount(Request $request)
    {
        $data = $request->input();
        $product_id = $data['data']['product_id'];
        $amount = $data['data']['amount'];
        if ($product_id) {
            $thisproduct = Product::find(intval($product_id));
//            return response()->json([
//                'status' => 205,
//                'message' => $product_id
//            ]);

            if (isset($thisproduct)) {
                $thisproduct->update(array('qty' => $thisproduct->qty + $amount));
            }

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        }

        return response()->json([
            'status' => 202,
            'message' => "ERROR"
        ]);
    }


}
