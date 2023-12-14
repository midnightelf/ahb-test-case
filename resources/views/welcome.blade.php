<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- PLAY CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>AHB</title>
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

    <style>
        /*Overrides for Tailwind CSS */

        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568;
            /*text-gray-700*/
            padding-left: 1rem;
            /*pl-4*/
            padding-right: 1rem;
            /*pl-4*/
            padding-top: .5rem;
            /*pl-2*/
            padding-bottom: .5rem;
            /*pl-2*/
            line-height: 1.25;
            /*leading-tight*/
            border-width: 2px;
            /*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7;
            /*border-gray-200*/
            background-color: #edf2f7;
            /*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;
            /*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;
            /*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important;
            /*bg-indigo-500*/
        }
    </style>
</head>

<body>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px] bg-white">
            @if ($errors->any())
                <div class="max-w-4xl mx-auto">
                    <div class="bg-red-50 border-l-8 border-red-900">
                        <div class="flex items-center">
                            <div class="p-2">
                                <div class="flex items-center">
                                    <div class="ml-2">
                                        <svg class="h-8 w-8 text-red-900 mr-2 cursor-pointer"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="px-6 py-4 text-red-900 font-semibold text-lg">Please fix the
                                        following
                                        errors.</p>
                                </div>
                                <div class="px-16 mb-4">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-md font-bold text-red-500 text-sm">{{ $error }}</li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif()

            <form class="py-6 px-9" action="{{ route('record.bulk-store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-6 pt-4">
                    <input onchange="showUploaded(event)" type="file" name="file" id="file"
                        class="sr-only" />
                    <label
                        class="w-fit cursor-pointer rounded py-2 px-7 border border-[#e0e0e0] mb-5 block text-xl font-semibold text-[#07074D]"
                        for="file">
                        Upload File
                        <span id="uploaded-filename"></span>
                    </label>
                </div>
                <div>
                    <button
                        class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Send File
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">

        <!--Card-->
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        @foreach (\App\Models\Record::CSV_HEADERS as $header)
                            <th data-priority="1">{{ __("records.$header") }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record['code'] }}</td>
                            <td>{{ $record['name'] }}</td>
                            <td>{{ $record['level1'] }}</td>
                            <td>{{ $record['level2'] }}</td>
                            <td>{{ $record['level3'] }}</td>
                            <td>{{ $record['price'] }}</td>
                            <td>{{ $record['price_sp'] }}</td>
                            <td>{{ $record->additional['count'] }}</td>
                            <td>{{ $record->additional['properties'] }}</td>
                            <td>{{ $record->additional['can_joint_purchases'] === true ? __('records.values.can_joint_purchases') : __('records.values.cant_joint_purchases') }}</td>
                            <td>{{ $record->additional['unit'] }}</td>
                            <td>{{ $record->additional['image'] }}</td>
                            <td>{{ $record->additional['can_display_on_main']  === true ? __('records.values.can_display_on_main') : __('records.values.cant_display_on_main') }}</td>
                            <td>{{ $record->additional['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>


        </div>
        <!--/Card-->


    </div>
    <!--/container-->





    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>

    <script>
        function showUploaded(event) {
            document.getElementById('uploaded-filename').innerText = `- ${event.target.files[0].name}`
        }
    </script>
</body>

</html>
