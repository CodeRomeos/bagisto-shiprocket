<x-shop::layouts>
    @push('styles')
        <style>
            .tracking-item {
                padding: 20px;
                border-left: 1px solid #DDD;
                position: relative;
            }

            .two-col {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                /* align-items: center; */
            }

            .expected-delivery>div {
                font-size: 16px;
                /* font-weight: bold; */
                border-radius: 8px;
                padding: 12px;
                text-align: center;
            }

            .expected-delivery .success {
                background-color: #d4edda;
                color: #155724
            }

            .expected-delivery .error {
                background-color: #f8d7da;
                color: #721c24
            }

            .expected-delivery .pending {
                background-color: #fbf5e2;
                color: #5e4200;
                border: 1px solid #ffe38e;
            }

            .btn-container {
                display: block;
            }

            @media screen and (max-width: 600px) {
                .two-col {
                    grid-template-columns: 1fr;
                }

                .btn-container {
                    display: flex;
                    justify-content: flex-end;
                }
            }
        </style>
    @endPush
    <!-- Title of the page -->
    <x-slot:title>
        Shiprocket Tracking | {{ config('app.name') }}
    </x-slot>

    <div class="main">
        <div class="container mt-[30px] px-[60px] max-lg:px-[30px]">
            <div class="two-col">
                <div>
                    <h1 style="font-size: 24px; margin-bottom: 20px">Track Your Order</h1>
                    <p>Enter your <strong>AWB Number</strong></p>
                    <form class="two-col" method="GET">
                        <div class="form-group">
                            {{-- <label for="awbCode">Tracking number</label> --}}
                            <input type="text"
                                class="block w-full px-[14px] py-[14px] bg-[#F5F5F5] rounded-lg text-gray-900 text-lg font-medium transition-all border border-transparent hover:border-gray-400 focus:border-gray-400"
                                name="awbCode" id="awbCode" class="form-control" value="{{ $awbCode }}">
                        </div>
                        <div class="btn-container">
                            <button type="submit" class="primary-button ">Track</button>
                        </div>
                    </form>
                </div>
                <div class="expected-delivery">
                    @if (isset($tracking_data['track_status']) && $tracking_data['track_status'] == 1)
                        @php
                            $current_status =
                                isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0])
                                    ? $tracking_data['shipment_track'][0]['current_status']
                                    : false;
                            $has_delivered = $current_status == 'Delivered';
                            $has_delivered = false;
                            $etd =
                                isset($tracking_data['etd']) && !empty($tracking_data['etd'])
                                    ? $tracking_data['etd']
                                    : false;
                            $courier_name =
                                isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0])
                                    ? $tracking_data['shipment_track'][0]['courier_name']
                                    : false;
                            $origin =
                                isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0])
                                    ? $tracking_data['shipment_track'][0]['origin']
                                    : false;
                            $destination =
                                isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0])
                                    ? $tracking_data['shipment_track'][0]['destination']
                                    : false;
                            $delivered_date =
                                isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0])
                                    ? $tracking_data['shipment_track'][0]['delivered_date']
                                    : false;

                        @endphp
                        <div class="{{ $has_delivered ? 'success' : 'pending' }}">
                            @if (!$has_delivered && $etd)
                                <div class="expected-delivery-date">
                                    Estimated Delivery Time
                                </div>
                                <time style="font-size: 1.5rem">{{ $tracking_data['etd'] }}</time><br />
                            @endif
                            <p>
                                Current Status - <strong>{{ $current_status }}</strong>
                                <br />
                                Courier Name - <strong>{{ $courier_name }}</strong>
                                <br />
                                {{ $has_delivered ? 'Delivered on ' . $delivered_date : '' }}
                            </p>
                            @if ($origin && $destination)
                                <br />
                                <hr />
                                <div class="flex items-center" style="justify-content: space-around">
                                    <span>
                                        From
                                        <br>
                                        <strong>{{ $origin }}</strong>
                                    </span>
                                    <span style="font-size: 48px">></span>
                                    <span>
                                        To
                                        <br>
                                        <strong>{{ $destination }}</strong>
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if (isset($tracking_data) && !empty($tracking_data))
                        @if ($tracking_data['track_status'] == 0 && isset($tracking_data['error']) && !empty($tracking_data['error']))
                            <div class="error">
                                {{ $tracking_data['error'] }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div>

                @if (isset($tracking_data) && !empty($tracking_data))
                    @if ($tracking_data['track_status'] == 1)
                        {{-- @if (isset($tracking_data['shipment_track']) && isset($tracking_data['shipment_track'][0]) && $tracking_data['shipment_track'][0]['current_status'])
                            <div>
                                Current Status - {{ $tracking_data['shipment_track'][0]['current_status'] }}
                            </div>
                        @endif --}}
                        <br />
                        <hr>
                        <br />

                        <ol class="relative border-s border-gray-200 dark:border-gray-700">
                            @foreach ($tracking_data['shipment_track_activities'] as $key => $activity)
                                <li class="tracking-item">
                                    <div class="absolute" style="left: -7px; top: 0">

                                        <time class="mb-1 text-sm font-normal leading-none dark:text-gray-500 px-2 py-1"
                                            style="background-color: rgb(219 234 254)">
                                            <span
                                                class="text-sm icon-calendar inline-block text-[24px] cursor-pointer"></span>
                                            {{ $activity['date'] }}
                                        </time>
                                    </div>
                                    <div style="margin-bottom: 28px; margin-top: 18px">
                                        <h3 class="text-lg mb-2 text-gray-900 dark:text-white">
                                            {{ $activity['activity'] }}</h3>
                                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Location -
                                            {{ $activity['location'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                    @dump($tracking_data)
                @endif
            </div>
        </div>
    </div>
</x-shop::layouts>
