<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\item;
use App\Product;
use App\Vendor;
use Illuminate\Http\Request;

class viewController extends Controller
{

    public function index()
    {

        $products = Product::all();
        $dataSet = [];
        foreach ($products as $product) {
            $vendor = Vendor::where('id', '=', $product->vendor_id)->first();
            $data = new \stdClass();
            $data->productID = $product->id;
            $data->vendorName = $vendor->vendor_name;
            $data->garminId = $product->productCode;
            $data->productDesc = $product->productDsc;
            $data->qty = $product->qty;
            $data->unit_price = $product->unit_price;
            $data->lastUpdated = $product->updated_at;
            array_push($dataSet, $data);
        }
//        foreach ($items as $item) {
//            $product = Product::where('id', '=', $item->product_id)->first();
//
//            if (!isset($dataSet[$product->vendor_id])) {
//                $vendor = Vendor::where('id', '=', $product->vendor_id)->first();
//                $dataSet[$product->vendor_id]['vendor'] = $vendor;
//            }
//            $dataSet[$product->vendor_id]['products'][$item->product_id]['product'] = $product;
//
//
//            $dataSet[$product->vendor_id]['products'][$item->product_id]['items'][$item->id] = $item;
//        }
//
//        foreach ($dataSet as $data) {
//            $count = 0;
//            foreach ($data['products'] as $product) {
//                $count += count($product['items']);
//            }
//            $dataSet[$data['vendor']->id]['vendor-count'] = $count == 0 ? 1 : $count;
//        }
//        dump($products);
//        exit();
        return view('admin.view_products', [
            'data' => $dataSet
        ]);
    }


    public function index_OLD()
    {
        $dataSet = [];
        $items = item::all();
        foreach ($items as $item) {
            $product = Product::where('id', '=', $item->product_id)->first();

            if (!isset($dataSet[$product->vendor_id])) {
                $vendor = Vendor::where('id', '=', $product->vendor_id)->first();
                $dataSet[$product->vendor_id]['vendor'] = $vendor;
            }
            $dataSet[$product->vendor_id]['products'][$item->product_id]['product'] = $product;


            $dataSet[$product->vendor_id]['products'][$item->product_id]['items'][$item->id] = $item;
        }

        foreach ($dataSet as $data) {
            $count = 0;
            foreach ($data['products'] as $product) {
                $count += count($product['items']);
            }
            $dataSet[$data['vendor']->id]['vendor-count'] = $count == 0 ? 1 : $count;
        }
//        dump($dataSet);
//        exit();
        return view('admin.view', [
            'data' => $dataSet
        ]);
    }


    function rgb_to_hex(string $rgba): string
    {
        if (strpos($rgba, '#') === 0) {
            return $rgba;
        }

        preg_match('/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i', $rgba, $by_color);

        return sprintf('#%02x%02x%02x', $by_color[1], $by_color[2], $by_color[3]);
    }


}
