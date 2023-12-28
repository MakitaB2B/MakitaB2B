@extends('Front/layout')
@section('page_title', 'Makita Warranty | Warranty Card')
@section('warrantycard_select', 'active')
@section('container')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        @push('styles')
            <!-- Select2 -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
        @endpush
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
            }

            #my-qr-reader {
                border: 1.5px solid #b2b2b2 !important;
                border-radius: 2px;
            }

            #my-qr-reader img[alt="Info icon"] {
                display: none;
            }

            #my-qr-reader img[alt="Camera based scan"] {
                width: 100px !important;
                height: 100px !important;
            }
            button {
                padding: 10px 20px;
                border: 1px solid #b2b2b2;
                outline: none;
                border-radius: 0.15em;
                color: white;
                font-size: 15px;
                cursor: pointer;
                margin-top: 15px;
                margin-bottom: 10px;
                background-color: #008000ad;
                transition: 0.3s background-color;
            }

            button:hover {
                background-color: #008000;
            }

            #html5-qrcode-anchor-scan-type-change {
                text-decoration: none !important;
                color: #1d9bf0;
            }

            video {
                width: 100% !important;
                border: 1px solid #b2b2b2 !important;
                border-radius: 0.25em;
            }
            .scbtn{
                padding: 5px 10px;
                margin-top: 0px;
            }
            .inputreq{
                color: #e40000;
                font-size: 9px;
                font-weight: bold;
            }
            .dpnone{
                display: none;
            }
        </style>
        <div class="row">
            <x-reachus />
            <div class="col-md-4">
                <div id="my-qr-reader">
                </div>
            </div>
            <div class="col-md-4">
               <p>Not able to scan? please input manually<p>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="model">Model Number<span class="required">*</span></label>
                            <select id="modelNo"  class="form-control select2" name="model_number" style="width: 100%;" required>
                                <option value="">Select Model</option>
                                @foreach ($models as $modelList)
                                    <option value="{{ $modelList->id }}">{{ ucfirst(trans($modelList->model_number)) }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="inputreq dpnone mis" >Model No. can`t be empty</p>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="msn">Machine Serial No.<span class="required">*</span></label>
                            <input class="form-control" id="slno" name="machine_serial_number"
                                placeholder="Machine Serial Number" type="text" required style="height:27px">
                                <p class="inputreq dpnone snis" ></p>
                        </div>
                        <div class="col-md-12 form-group">
                            <button class="scbtn" type="button" id="submit">Submit</button>
                        </div>
                    </div>
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
    @push('scripts')
    <script src="{{ asset('front_assets/js/html5_qrcode.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2()
        });
        $("#slno").on('keyup',function(){
            $(".snis").hide();
        });

        function modelDetails(modelNumber){
            let modell=JSON.parse('<?php echo json_encode($models); ?>');
            var item = modell.find(item => item.model_number === modelNumber);
            var modelId=item.id;
            return modelId;
        }

        $("#modelNo").on('change',function(){
            let modelID = $.trim($("#modelNo").val());
            if(modelID!=''){
                $(".mis").hide();
            }
        });

        $("#submit").on('click',function(){
            let modelID = $.trim($("#modelNo").val());
            let serialNo = $.trim($("#slno").val());
            if(modelID==''){
                $(".mis").show();
            }
            if(serialNo==''){
                $(".snis").show();
            }
            if(modelID!='' && serialNo!=''){
                $.ajax({
                    url: '/check-serialnumber-existence',
                    type: 'post',
                    data: 'slno=' + serialNo +
                        '&_token={{ csrf_token() }}',
                    success: function(data) {
                        console.log(data);
                        if(data==1){
                            $(".snis").show().text('This Serial No. Alredy Registered');
                        }
                        if(data==0){
                            window.location.href = "/warranty-registration/"+btoa(modelID)+"/"+btoa(serialNo);
                        }
                    }
                });
            }
        });

        function domReady(fn) {
            if (
                document.readyState === "complete" ||
                document.readyState === "interactive"
            ) {
                setTimeout(fn, 1000);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }
        domReady(function() {
            // If found you qr code
            function onScanSuccess(decodeText, decodeResult) {
                var scandata = decodeText;
                const splitData = scandata.trim().split(' ');
                const model = splitData[0];
                var numOfSpaces = scandata.split(" ").length - 1;
                var secondstr = splitData[numOfSpaces];
                var resultArray = splitStringByAlphabet(secondstr);
                var strlen = JSON.stringify(resultArray[0]);
                var strcount = strlen.replace(/[_\W]+/g, "").length;
                const [first, second] = split(strlen.replace(/[_\W]+/g, ""), strcount / 2);
                var dynamicCount = countLeadingZeros(second);
                var resultString = second.replace(new RegExp('^0{' + dynamicCount + ',}'), '');
                document.getElementById("slno").value = resultString;
                let modelNumber=modelDetails(model);
                $('#modelNo').val(modelNumber).trigger('change');
            }
            let htmlscanner = new Html5QrcodeScanner(
                "my-qr-reader", {
                    fps: 30,
                    qrbos: 250
                }
            );
            htmlscanner.render(onScanSuccess);
        });
        function splitStringByAlphabet(inputString) {
            // Convert the input string to lowercase for case-insensitive comparison
            inputString = inputString.toLowerCase();
            // Use regular expression to split the string by alphabet characters
            var regex = /[a-z]/g;
            var resultArray = inputString.split(regex).filter(Boolean);
            return resultArray;
        }
        function countLeadingZeros(str) {
            // Use a regular expression to match consecutive '0' characters at the beginning
            var match = str.match(/^0+/);
            // If there is a match, return the length of the matched substring, otherwise return 0
            return match ? match[0].length : 0;
        }
        function split(str, index) {
            const result = [str.slice(0, index), str.slice(index)];
            return result;
        }
    </script>
    @endpush
@endsection
