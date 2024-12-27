@extends('Front/cust_layout')
@section('page_title', 'Product Details | MAKITA')
@section('module_select', 'active')
@section('container')
        @push('styles')
            <script src="https://unpkg.com/html5-qrcode"></script>
        @endpush
        <main class="main-content bg-grey">
            <div class="container">
                <div class="content content-horizonatal">
                  <div class="left-side">
                    <!-- <div class="carousel-container">
                        <div class="carousel">
                            <div class="carousel-slide">
                                <img src="./img/hero-.jpg" alt="Slide 1">
                            </div>
                            <div class="carousel-slide">
                                <img src="./img/hero-.jpg" alt="Slide 2">
                            </div>
                            <div class="carousel-slide">
                                <img src="./img/hero-.jpg" alt="Slide 3">
                            </div>
                        </div>
                        
                        <button class="carousel-btn prev-btn">❮</button>
                        <button class="carousel-btn next-btn">❯</button>
                        
                        <div class="carousel-indicators"></div>
                    </div> -->
                <div class="content-info">                            
                    <div class="card-container">
                            <!-- <h1 class="title">WARRANTY SERVICE STEPS</h1> -->
                            <div class="steps-grid">
                              <div class="step-card">
                                <div class="step-number">01</div>
                                <div class="step-content">
                                  <div class="step-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                      <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                  </div>
                                  <h2 class="step-title">Product Details Form</h2>
                                  <p class="step-description">Enter the Product details to register for warranty service.</p>
                                </div>
                              </div>
                              <div class="step-card">
                                <div class="step-number">02</div>
                                <div class="step-content">
                                  <div class="step-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M20 6L9 17l-5-5"></path>
                                    </svg>
                                  </div>
                                  <h2 class="step-title">Review & Submit</h2>
                                  <p class="step-description">Verify all information and submit your request for processing.</p>
                                </div>
                              </div>
                        
                              <div class="step-card">
                                <div class="step-number">01</div>
                                <div class="step-content">
                                  <div class="step-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <circle cx="11" cy="11" r="8"></circle>
                                      <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                  </div>
                                  <h2 class="step-title">Add Product Data</h2>
                                  <p class="step-description">Add more product data by clicking on Add more or scan more. Click submit data to subit all the data. </p>
                                </div>
                              </div>
                            </div>
                    </div>
                </div>
            </div>
                    <div class="right-side">
                        <div class="btn-groups addmore-btn-groups" style="display: none;">
                            <a href="javascript:;" class="btn btn-primary btn-link open-add-modal" data-target="#product-modal">Add More</a>
                            <a href="javascript:;" class="btn btn-primary  btn-link" data-click="modal" data-target="#scanModal">Scan More </a>
                        </div>
                        <div class="card card-s submited-products">
                          <div class="card-header">
                              <h2 class="card-title">Added Product List</h2>
                          </div>
                          <div class="table-container">
                              <table>
                                  <thead>
                                      <tr>
                                          <th>Seller</th>
                                          <th>Invoice No.</th>
                                          <th class="mobile-hide">Serial No.</th>
                                          <th class="mobile-hide">Model no.</th>
                                          <th class="mobile-hide">Purchase Date</th>
                                          <th class="mobile-hide">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody></tbody>
                              </table>
                          </div>
                      </div>
                        <div class="card-s" id="productForm">
                            <div class="auth-container" id="productDataPage">
                                <div class="auth-header">
                                    <h1 class="scan-title">Product Details Form</h1>
                                </div>
                                <form id="purchaseForm">
                                    <div class="form-group">
                                    <label class="required">Mode of Purchase</label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                        <input type="radio" name="purchaseMode" value="online" checked>
                                        <span class="radio-checkmark"></span>
                                        <span>Online</span>
                                        </label>
                                        <label class="radio-label">
                                        <input type="radio" name="purchaseMode" value="offline">
                                        <span class="radio-checkmark"></span>
                                        <span>Offline</span>
                                        </label>
                                    </div>
                                    </div>
                            
                                    <div class="form-row">
                                    <div class="form-col">
                                        <label class="required">Purchase From</label>
                                        <input type="text" placeholder="Seller Name" name="purchaseFrom">
                                    </div>
                                    <div class="form-col">
                                        <label class="required">Place Of Purchase</label>
                                        <input type="text" placeholder="Place Of Purchase" name="placeOfPurchase">
                                    </div>
                                    </div>
                            
                                    <div class="form-row">
                                    <div class="form-col">
                                        <label class="required">Date of Purchase</label>
                                        <input type="date" name="purchaseDate">
                                    </div>
                                    <div class="form-col">
                                        <label class="required">Model Number</label>
                                        <input type="text" value="PDC01" name="modelNumber">
                                    </div>
                                    </div>
                            
                                    <div class="form-row">
                                    <div class="form-col">
                                        <label class="required">Invoice Number</label>
                                        <input type="text" placeholder="Invoice Number" name="invoiceNumber">
                                    </div>
                                    <div class="form-col">
                                        <label class="required">Machine Serial Number</label>
                                        <input type="text" placeholder="Serial Number" name="serialNumber">
                                    </div>
                                    </div>
                            
                                    <div class="form-row">
                                    <div class="form-col">
                                        <label>Invoice Copy</label>
                                        <input type="file" id="invoiceFile" class="file-input">
                                        <label for="invoiceFile" class="file-label">Choose File</label>
                                        <span class="file-name">No file chosen</span>
                                    </div>
                                    <div class="form-col">
                                        <label class="required">Machine Photo with SL no.</label>
                                        <input type="file" id="machineFile" class="file-input">
                                        <label for="machineFile" class="file-label">Choose File</label>
                                        <span class="file-name">No file chosen</span>
                                    </div>
                                    </div>
                            
                                    <div class="form-group">
                                    <label>Comment</label>
                                    <textarea placeholder="Enter your comment here" name="comment"></textarea>
                                    </div>
                            
                                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                              </form>
                            </div>
                        </div>
                        <!-- <div class="add-more-data">
                            <div class="add-more-dd">
                                <a href=""> <span class="plus-iocn"><i class="fa fa-plus"></i></span> <span class="icon-text">add Product</span></a>
                                <div class="popup">
                                    <a class="popup-item"> Add Product Details </a>
                                    <a class="popup-item"> Scan Product</a>
                                </div>
                            </div>
                        </div> -->
                        <div class="btn-groups addmore-btn-groups j-center" style="display: none;">
                            <a href="javascript:;" class="btn btn-primary  btn-link save-product-data">Submit Data </a>
                      </div>
                    </div>
                </div>
            </div>
        </main>

    <div class="modal-overlay" id="scanModal">
      <div class="modal">
        <button class="modal-close">&times;</button>
          <div id="scanForm" class="scan-form">
              <h1>PDF417 Barcode Scanner</h1>     
              <div id="reader"></div>
              <div class="status" id="status"></div>
          </div>
          <div class="controls">
            <button id="startButton" class="btn btn-primary">Start Camera</button>
            <!-- <button id="stopButton" class="btn btn-primary" disabled>Stop Camera</button> -->
            <button id="uploadButton" class="btn btn-primary">Upload Image</button>
            <input type="file" id="fileInput" class="file-input" accept="image/*">
        </div>
      </div>
    </div>
    <div class="modal-overlay" id="product-modal">
        <div class="modal">
          <button class="modal-close">&times;</button>
          <form id="purchaseForm">
            <div class="form-group">
            <label class="required">Mode of Purchase</label>
            <div class="radio-group">
                <label class="radio-label">
                <input type="radio" name="purchaseMode" value="online" checked>
                <span class="radio-checkmark"></span>
                <span>Online</span>
                </label>
                <label class="radio-label">
                <input type="radio" name="purchaseMode" value="offline">
                <span class="radio-checkmark"></span>
                <span>Offline</span>
                </label>
            </div>
            </div>
    
            <div class="form-row">
            <div class="form-col">
                <label class="required">Purchase From</label>
                <input type="text" placeholder="Seller Name" name="purchaseFrom">
            </div>
            <div class="form-col">
                <label class="required">Place Of Purchase</label>
                <input type="text" placeholder="Place Of Purchase" name="placeOfPurchase">
            </div>
            </div>
    
            <div class="form-row">
            <div class="form-col">
                <label class="required">Date of Purchase</label>
                <input type="date" name="purchaseDate">
            </div>
            <div class="form-col">
                <label class="required">Model Number</label>
                <input type="text" value="PDC01" name="modelNumber">
            </div>
            </div>
    
            <div class="form-row">
            <div class="form-col">
                <label class="required">Invoice Number</label>
                <input type="text" placeholder="Invoice Number" name="invoiceNumber">
            </div>
            <div class="form-col">
                <label class="required">Machine Serial Number</label>
                <input type="text" placeholder="Serial Number" name="serialNumber">
            </div>
            </div>
    
            <div class="form-row">
            <div class="form-col">
                <label>Invoice Copy</label>
                <input type="file" id="invoiceFile" class="file-input">
                <label for="invoiceFile" class="file-label">Choose File</label>
                <span class="file-name">No file chosen</span>
            </div>
            <div class="form-col">
                <label class="required">Machine Photo with SL no.</label>
                <input type="file" id="machineFile" class="file-input">
                <label for="machineFile" class="file-label">Choose File</label>
                <span class="file-name">No file chosen</span>
            </div>
            </div>
    
            <div class="form-group">
            <label>Comment</label>
            <textarea placeholder="Enter your comment here" name="comment"></textarea>
            </div>
    
            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
      </form>
        </div>
      </div>
    @push('scripts')
    <script src="js/product-details.js"></script>
    <script>

      $(document).ready(function() {
          if ($('#productDataPage').length > 0) {
              $(".steps-grid .step-card").hide();
              $(".steps-grid .step-card:nth-child(1), .steps-grid .step-card:nth-child(2)").addClass("active-card").show();
              if (localStorage.getItem('purchaseFormData') !==null && localStorage.getItem('purchaseFormData') !== '[]') {
                $(".steps-grid .step-card").hide();
                $(".steps-grid .step-card:nth-child(3)").addClass('active-card').show();
              }
          }
         
      });
      $(document).ready(function() {
            let html5QrCode = null;
            let lastScannedCode = null;
            let lastScanTime = 0;
            const scanCooldown = 2000; // 2 seconds cooldown between scans

            // Create beep sound using Web Audio API
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            function createBeepSound() {
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.type = 'square';
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                gainNode.gain.setValueAtTime(0.5, audioContext.currentTime);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.1);
            }

            function playBeep() {
                createBeepSound();
            }

            const config = {
                formatsToSupport: [ Html5QrcodeSupportedFormats.PDF_417 ],
                fps: 10,
                qrbox: { width: 250, height: 150 }
            };

            // Initialize scanner
            function initScanner() {
                html5QrCode = new Html5Qrcode("reader");
            }

            // Handle successful scan
            function handleSuccessfulScan(decodedText) {
              // $("#scanModal .modal-close").click();
                const currentTime = Date.now();
                
                // Check if this is a new code or if enough time has passed since last scan
                if (decodedText !== lastScannedCode || (currentTime - lastScanTime) > scanCooldown) {
                  $("#resultText").text(decodedText);
                    var resultData = $("#resultText").text();
                    $("#status").text("Successfully scanned!");
                    // $(".open-add-modal").click();
                    playBeep();
                    // window.location.href = 'product-details.html?serialCode=' + resultData;
                    // $("#scanModal .modal-close").click();
                    if(decodedText != null){                      
                      $(".open-add-modal").click();
                      $('input[name="serialNumber"]').val(decodedText);
                      $('input[name="invoiceNumber"]').val("MAK00124");
                      $('input[name="modelNumber"]').val("PDC002394");
                    }
                    lastScannedCode = decodedText;
                    lastScanTime = currentTime;
                }
            }

            // Start camera scanning
            $("#startButton").click(function() {
                if (!html5QrCode) initScanner();
                
                html5QrCode.start(
                    { facingMode: "environment" },
                    config,
                    handleSuccessfulScan,
                    (errorMessage) => {
                        console.log(errorMessage);
                    }
                ).then(() => {
                    $("#startButton").prop('disabled', true);
                    $("#stopButton").prop('disabled', false);
                    // $("#status").text("Scanner started successfully");
                    $(".scan-form h1").hide();
                });
            });

            // Stop camera scanning
            $("#stopButton").click(function() {
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        $("#startButton").prop('disabled', false);
                        $("#stopButton").prop('disabled', true);
                        $("#status").text("Scanner stopped");
                    });
                }
            });

            // Handle file upload
            $("#uploadButton").click(function() {
                $("#fileInput").click();
            });

            $("#fileInput").change(function(e) {
                if (!html5QrCode) initScanner();
                
                if (e.target.files.length === 0) {
                    return;
                }

                const imageFile = e.target.files[0];
                
                html5QrCode.scanFile(imageFile, true)
                    .then(decodedText => {
                        handleSuccessfulScan(decodedText);
                    })
                    .catch(err => {
                        $("#status").text("Error scanning file: " + err);
                    });
            });


            var model = sessionStorage.getItem('model');
            var serialNo = sessionStorage.getItem('serialNo');
            $('#productDataPage input[name="modelNumber"]').val(model).attr('readonly', true);;
            $('#productDataPage input[name="serialNumber"]').val(serialNo).attr('readonly', true);;
        });
        $(".save-product-data").on('click', () => {
          event.preventDefault();
          var userConfirmed = confirm('Are you sure you want to submit the form?');
          if (userConfirmed) {
            localStorage.removeItem('purchaseFormData');
            // this.submit();
            window.location.href='product-details.html'
          }
          
        })
        </script>
@endpush
@endsection