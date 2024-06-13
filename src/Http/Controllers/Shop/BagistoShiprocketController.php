<?php

namespace CodeRomeos\BagistoShiprocket\Http\Controllers\Shop;

use CodeRomeos\BagistoShiprocket\Services\Shiprocket;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class BagistoShiprocketController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function tracking(Request $request)
    {
        $data = [
            'tracking_data' => null
        ];

        if($request->has('awbCode')) {
            $shiprocketApi = new Shiprocket;
            $data = $shiprocketApi->trackAWB(56789009876);
            // $data = [
            //     "tracking_data" => [
            //         "track_status" => 1,
            //         "shipment_status" => 7,
            //         "shipment_track" => [
            //             [
            //                 "id" => 236612717,
            //                 "awb_code" => "141123221084922",
            //                 "courier_company_id" => 51,
            //                 "shipment_id" => 236612717,
            //                 "order_id" => 237157589,
            //                 "pickup_date" => "2022-07-18 20:28:00",
            //                 "delivered_date" => "2022-07-19 11:37:00",
            //                 "weight" => "0.30",
            //                 "packages" => 1,
            //                 "current_status" => "Delivered",
            //                 "delivered_to" => "Chittoor",
            //                 "destination" => "Chittoor",
            //                 "consignee_name" => "",
            //                 "origin" => "Banglore",
            //                 "courier_agent_details" => null,
            //                 "courier_name" => "Xpressbees Surface",
            //                 "edd" => null,
            //                 "pod" => "Available",
            //                 "pod_status" => "https://s3-ap-southeast-1.amazonaws.com/kr-shipmultichannel/courier/51/pod/141123221084922.png"
            //             ]
            //         ],
            //         "shipment_track_activities" => [
            //             [
            //                 "date" => "2022-07-19 11:37:00",
            //                 "status" => "DLVD",
            //                 "activity" => "Delivered",
            //                 "location" => "MADANPALLI, Madanapalli, ANDHRA PRADESH",
            //                 "sr-status" => "7",
            //                 "sr-status-label" => "DELIVERED"
            //             ],
            //             [
            //                 "date" => "2022-07-19 08:57:00",
            //                 "status" => "OFD",
            //                 "activity" => "Out for Delivery Out for delivery: 383439-Nandinayani Reddy Bhaskara Sitics Logistics  (356231) (383439)-PDS22200085719383439-FromMob , MobileNo:- 9963133564",
            //                 "location" => "MADANPALLI, Madanapalli, ANDHRA PRADESH",
            //                 "sr-status" => "17",
            //                 "sr-status-label" => "OUT FOR DELIVERY"
            //             ],
            //             [
            //                 "date" => "2022-07-19 07:33:00",
            //                 "status" => "RAD",
            //                 "activity" => "Reached at Destination Shipment BagOut From Bag : nxbg03894488",
            //                 "location" => "MADANPALLI, Madanapalli, ANDHRA PRADESH",
            //                 "sr-status" => "38",
            //                 "sr-status-label" => "REACHED AT DESTINATION HUB"
            //             ],
            //             [
            //                 "date" => "2022-07-18 21:02:00",
            //                 "status" => "IT",
            //                 "activity" => "InTransit Shipment added in Bag nxbg03894488",
            //                 "location" => "BLR/FC1, BANGALORE, KARNATAKA",
            //                 "sr-status" => "18",
            //                 "sr-status-label" => "IN TRANSIT"
            //             ],
            //             [
            //                 "date" => "2022-07-18 20:28:00",
            //                 "status" => "PKD",
            //                 "activity" => "Picked Shipment InScan from Manifest",
            //                 "location" => "BLR/FC1, BANGALORE, KARNATAKA",
            //                 "sr-status" => "6",
            //                 "sr-status-label" => "SHIPPED"
            //             ],
            //             [
            //                 "date" => "2022-07-18 13:50:00",
            //                 "status" => "PUD",
            //                 "activity" => "PickDone ",
            //                 "location" => "RTO/CHD, BANGALORE, KARNATAKA",
            //                 "sr-status" => "42",
            //                 "sr-status-label" => "PICKED UP"
            //             ],
            //             [
            //                 "date" => "2022-07-18 10:04:00",
            //                 "status" => "OFP",
            //                 "activity" => "Out for Pickup ",
            //                 "location" => "RTO/CHD, BANGALORE, KARNATAKA",
            //                 "sr-status" => "19",
            //                 "sr-status-label" => "OUT FOR PICKUP"
            //             ],
            //             [
            //                 "date" => "2022-07-18 09:51:00",
            //                 "status" => "DRC",
            //                 "activity" => "Pending Manifest Data Received",
            //                 "location" => "RTO/CHD, BANGALORE, KARNATAKA",
            //                 "sr-status" => "NA",
            //                 "sr-status-label" => "NA"
            //             ]
            //         ],
            //         "track_url" => "https://shiprocket.co//tracking/141123221084922",
            //         "etd" => "2022-07-20 19:28:00",
            //         "qc_response" => [
            //             "qc_image" => "",
            //             "qc_failed_reason" => ""
            //         ]
            //     ]
            // ];
        }

        return view('bagistoshiprocket::shop.tracking', ['tracking_data' => $data['tracking_data'], 'awbCode' => $request->awbCode]);
    }
}
