
    <script src="https://unpkg.com/html5-qrcode"></script>

        <main class="main-content bg-grey">
            <div class="container">
                <div class="content">
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
                                          <h2 class="step-title">Open Camera</h2>
                                          <p class="step-description">Click on scan link to open the camera.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">02</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <circle cx="11" cy="11" r="8"></circle>
                                              <path d="m21 21-4.3-4.3"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Scan Product</h2>
                                          <p class="step-description">Locate your product using the serial number, model name, or purchase details.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">03</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Unable to Scan ?</h2>
                                          <p class="step-description">Fill the form details to proceed.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">04</div>
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
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="card-s">
                            <div class="auth-container" id="scanPage">
                                <div class="auth-header">
                                    <h1 class="scan-title">Scan Product</h1>
                                    <h1 class="product-title">Product Details</h1>
                                </div>
                                <div id="scanForm" class="scan-form">
                                  <h1>PDF417 Barcode Scanner</h1>     
                                  <div id="reader"></div>
                                  <div class="status" id="status"></div>
                              </div>
                              <div id="result">
                                  <!-- <h3>Scan Result:</h3> -->
                                  <pre id="resultText"></pre>
                              </div>
                              <div class="controls">
                                  <button id="startButton" class="btn btn-primary">Start Camera</button>
                                  <!-- <button id="stopButton" class="btn btn-primary" disabled>Stop Camera</button> -->
                                  <button id="uploadButton" class="btn btn-primary">Upload Image</button>
                                  <input type="file" id="fileInput" class="file-input" accept="image/*">
                              </div>
                                <!-- <form id="scanForm" class="scan-form">
                                    <div class="form-group">
                                        <div class="upload-area">
                                            Click to Scan
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                      <button type="submit" class="btn btn-primary submit-button">Scan</button>
                                      <button type="submit" class="btn btn-primary submit-button">Upload</button>
                                    </div>                                  
                                </form> -->
                                <form id="productForm" class="product-form">                                  
                                  <div class="form-group">
                                      <label for="">Model Number* </label>
                                      <div class="custom-select-container" id="select1">
                                          <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                          <div class="dropdown-arrow"></div>
                                          <div class="custom-select-dropdown">
                                              <input type="text" class="search-box" placeholder="Type to search...">
                                              <div class="options-container"></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Machine Serial No.*</label>
                                      <input type="text" required>
                                  </div>
                                  <div class="btn-group">
                                    <button type="submit" class="btn btn-primary submit-button">Submit</button>
                                  </div>                                  
                              </form>
                                <div class="auth-links">
                                    <a href="javascript:;" class="form-link">Unable to scan? Click here</a>
                                    <a href="javascript:;" class="scan-link">Want to scan? Click here</a>
                                </div>
                                <div class="contact-info">
                                  <p>Need help? Contact us at:</p>
                                  <div class="contact-details">
                                      <p><span>📍 Reach us at</span> :  Bangalore, India</p>
                                      <p><span>📞 Call us at</span> :  +91-80-2205-8200</p>
                                      <p><span>✉️ Contact us at</span> : <a href="mailto:sales@makita.in">sales@makita.in</a></p>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add audio element for beep sound -->
        <audio id="beepSound" preload="auto">
          <source src="data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU" type="audio/wav">
      </audio>
        </main>
        
    <script>
      $(document).ready(function() {
          if ($('#scanPage').length > 0) {
              $(".steps-grid .step-card").hide();
              $(".steps-grid .step-card:nth-child(2)").addClass("active-card")
              $(".steps-grid .step-card:nth-child(-n+2)").show();   
              
              $(".product-form, .scan-link, .product-title").hide();
        
              $(".form-link").on('click', () => {
                  $(".scan-form, .form-link, .scan-title, .controls").hide();
                  $(".product-form, .scan-link, .product-title").show();
                  $(".steps-grid .step-card:nth-child(2)").removeClass("active-card")
                  $(".steps-grid .step-card:nth-child(3),.steps-grid .step-card:nth-child(4)").addClass("active-card").show()
              });

              $(".scan-link").on('click', () => {
                  $(".product-form, .scan-link, .product-title").hide();
                  $(".scan-form, .form-link, .scan-title").show();
                  $(".steps-grid .step-card:nth-child(3),.steps-grid .step-card:nth-child(4) ").removeClass("active-card").hide();
                  $(".steps-grid .step-card:nth-child(2)").addClass("active-card")
              $(".steps-grid .step-card:nth-child(-n+2)").show();  
              });
              
              $("#productForm .btn").click(function(e){
                  e.preventDefault();
                  window.location.href = 'product-details.html';
              });
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
                const currentTime = Date.now();
                
                // Check if this is a new code or if enough time has passed since last scan
                if (decodedText !== lastScannedCode || (currentTime - lastScanTime) > scanCooldown) {
                    // $("#resultText").text(decodedText);
                    $("#status").text("Successfully scanned!");
                    playBeep();
                    var scandata = decodedText;
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
                    // document.getElementById("slno").value = resultString;
                    let modelNumber=modelDetails(model);
                    // $('#resultText').val( model + '' + resultString)
                    sessionStorage.setItem('model', model);
                    sessionStorage.setItem('serialNo', resultString);
                    window.location.href = 'product-details.html';
                    
                    lastScannedCode = decodedText;
                    lastScanTime = currentTime;
                }
            }
            function modelDetails(modelNumber){
                let modell=JSON.parse('[{"id":1,"model_number":"PDC1200","warranty_period":6},{"id":2,"model_number":"PDC01","warranty_period":6},{"id":3,"model_number":"DF001G","warranty_period":12},{"id":4,"model_number":"DF002G","warranty_period":12},{"id":5,"model_number":"DDF489","warranty_period":12},{"id":6,"model_number":"DDF487","warranty_period":12},{"id":7,"model_number":"HP001G","warranty_period":12},{"id":8,"model_number":"HP002G","warranty_period":12},{"id":9,"model_number":"DHP489","warranty_period":12},{"id":10,"model_number":"DHP487","warranty_period":12},{"id":11,"model_number":"DDF486","warranty_period":12},{"id":12,"model_number":"DDF485","warranty_period":12},{"id":13,"model_number":"DDF484","warranty_period":12},{"id":14,"model_number":"DDF483","warranty_period":12},{"id":15,"model_number":"DHP486","warranty_period":12},{"id":16,"model_number":"DHP485","warranty_period":12},{"id":17,"model_number":"DHP484\u00a0","warranty_period":12},{"id":18,"model_number":"DHP483\u00a0","warranty_period":12},{"id":19,"model_number":"DDF482\u00a0","warranty_period":12},{"id":20,"model_number":"DDF458\u00a0","warranty_period":12},{"id":21,"model_number":"DDF453\u00a0","warranty_period":12},{"id":22,"model_number":"DDF083\u00a0","warranty_period":12},{"id":23,"model_number":"DHP482\u00a0","warranty_period":12},{"id":24,"model_number":"DHP458\u00a0","warranty_period":12},{"id":25,"model_number":"DHP453\u00a0","warranty_period":12},{"id":26,"model_number":"DF333D","warranty_period":12},{"id":27,"model_number":"DF332D","warranty_period":12},{"id":28,"model_number":"DF331D\u00a0","warranty_period":12},{"id":29,"model_number":"DF032D\u00a0","warranty_period":12},{"id":30,"model_number":"HP331D\u00a0","warranty_period":12},{"id":31,"model_number":"HP333D\u00a0","warranty_period":12},{"id":32,"model_number":"HP332D\u00a0","warranty_period":12},{"id":33,"model_number":"DF488D\u00a0","warranty_period":12},{"id":34,"model_number":"DF457D\u00a0","warranty_period":12},{"id":35,"model_number":"DF012D\u00a0","warranty_period":12},{"id":36,"model_number":"DF001D\u00a0","warranty_period":12},{"id":37,"model_number":"HP457D\u00a0","warranty_period":12},{"id":38,"model_number":"HP0300\u00a0","warranty_period":12},{"id":39,"model_number":"DF0300\u00a0","warranty_period":12},{"id":40,"model_number":"TD001G","warranty_period":12},{"id":41,"model_number":"DTD171\u00a0","warranty_period":12},{"id":42,"model_number":"TD003G\u00a0","warranty_period":12},{"id":43,"model_number":"DTD172\u00a0","warranty_period":12},{"id":44,"model_number":"TD002G","warranty_period":12},{"id":45,"model_number":"DTD155","warranty_period":12},{"id":46,"model_number":"DTD157","warranty_period":12},{"id":47,"model_number":"DTD156","warranty_period":12},{"id":48,"model_number":"TD111D","warranty_period":12},{"id":49,"model_number":"DTD154","warranty_period":12},{"id":50,"model_number":"DTD152","warranty_period":12},{"id":51,"model_number":"TD110D","warranty_period":12},{"id":52,"model_number":"TD022D","warranty_period":12},{"id":53,"model_number":"TD127D","warranty_period":12},{"id":54,"model_number":"TL064D","warranty_period":12},{"id":55,"model_number":"6412","warranty_period":6},{"id":56,"model_number":"DA001G","warranty_period":12},{"id":57,"model_number":"TD0101","warranty_period":6},{"id":58,"model_number":"DP2010","warranty_period":6},{"id":59,"model_number":"DP4010","warranty_period":6},{"id":60,"model_number":"DDA460","warranty_period":12},{"id":61,"model_number":"DDA450","warranty_period":12},{"id":62,"model_number":"DA333D","warranty_period":12},{"id":63,"model_number":"HB350","warranty_period":6},{"id":64,"model_number":"TW007G","warranty_period":12},{"id":65,"model_number":"DA332D","warranty_period":12},{"id":66,"model_number":"HB500","warranty_period":6},{"id":67,"model_number":"TW001G","warranty_period":12},{"id":68,"model_number":"TW004G","warranty_period":12},{"id":69,"model_number":"DTW1001","warranty_period":12},{"id":70,"model_number":"DTW700","warranty_period":12},{"id":71,"model_number":"DTW181","warranty_period":12},{"id":72,"model_number":"DTW285","warranty_period":12},{"id":73,"model_number":"DTW1002","warranty_period":12},{"id":74,"model_number":"DTW300","warranty_period":12},{"id":75,"model_number":"DTW450","warranty_period":12},{"id":76,"model_number":"DTW251","warranty_period":12},{"id":77,"model_number":"DTW190","warranty_period":12},{"id":78,"model_number":"TW160D","warranty_period":12},{"id":79,"model_number":"TW100D","warranty_period":12},{"id":80,"model_number":"TW1000","warranty_period":6},{"id":81,"model_number":"TW161D","warranty_period":12},{"id":82,"model_number":"TW140D","warranty_period":12},{"id":83,"model_number":"TW0350","warranty_period":6},{"id":84,"model_number":"TW0200","warranty_period":6},{"id":85,"model_number":"TW202D","warranty_period":12},{"id":86,"model_number":"WR100D","warranty_period":12},{"id":87,"model_number":"DWT310","warranty_period":12},{"id":88,"model_number":"DTL063","warranty_period":12},{"id":89,"model_number":"TL065D","warranty_period":12},{"id":90,"model_number":"6906","warranty_period":6},{"id":91,"model_number":"DWR180","warranty_period":12},{"id":92,"model_number":"DBM230","warranty_period":6},{"id":93,"model_number":"DBM131","warranty_period":6},{"id":94,"model_number":"6924N","warranty_period":6},{"id":95,"model_number":"DFS250","warranty_period":12},{"id":96,"model_number":"DFS251","warranty_period":12},{"id":97,"model_number":"DDG460","warranty_period":12},{"id":98,"model_number":"TB131","warranty_period":6},{"id":99,"model_number":"FS2700","warranty_period":6},{"id":100,"model_number":"DG001G","warranty_period":12},{"id":101,"model_number":"DG002G","warranty_period":12},{"id":102,"model_number":"DDG461","warranty_period":12},{"id":103,"model_number":"VR001G","warranty_period":12},{"id":104,"model_number":"VR001C","warranty_period":12},{"id":105,"model_number":"VR002C","warranty_period":12},{"id":106,"model_number":"VR004C","warranty_period":12},{"id":107,"model_number":"VR003C","warranty_period":12},{"id":108,"model_number":"UT001G","warranty_period":12},{"id":109,"model_number":"HR006G","warranty_period":12},{"id":110,"model_number":"HR001G","warranty_period":12},{"id":111,"model_number":"HR003G","warranty_period":12},{"id":112,"model_number":"HR007G","warranty_period":12},{"id":113,"model_number":"HR008G","warranty_period":12},{"id":114,"model_number":"HR010G","warranty_period":12},{"id":115,"model_number":"DHR282","warranty_period":12},{"id":116,"model_number":"DHR280","warranty_period":12},{"id":117,"model_number":"DHR202","warranty_period":12},{"id":118,"model_number":"DHR241","warranty_period":12},{"id":119,"model_number":"HR2470T","warranty_period":12},{"id":120,"model_number":"HR2630","warranty_period":12},{"id":121,"model_number":"HR3011FC","warranty_period":12},{"id":122,"model_number":"HR2810","warranty_period":12},{"id":123,"model_number":"HR3001C","warranty_period":12},{"id":124,"model_number":"HR2653","warranty_period":12},{"id":125,"model_number":"HR005G","warranty_period":12},{"id":126,"model_number":"DHR165","warranty_period":12},{"id":127,"model_number":"HR2652","warranty_period":12},{"id":128,"model_number":"DHR183","warranty_period":12},{"id":129,"model_number":"DHR171","warranty_period":12},{"id":130,"model_number":"HR166D","warranty_period":12},{"id":131,"model_number":"HR140D","warranty_period":12},{"id":132,"model_number":"HR4013C","warranty_period":12},{"id":133,"model_number":"HR4002","warranty_period":12},{"id":134,"model_number":"HR2020","warranty_period":12},{"id":135,"model_number":"HR2230","warranty_period":12},{"id":136,"model_number":"HR4003C","warranty_period":12},{"id":137,"model_number":"HR5202C","warranty_period":12},{"id":138,"model_number":"HM002G","warranty_period":12},{"id":139,"model_number":"HM0870C","warranty_period":12},{"id":140,"model_number":"HM001G","warranty_period":12},{"id":141,"model_number":"HM1213C","warranty_period":12},{"id":142,"model_number":"HM1205C","warranty_period":12},{"id":143,"model_number":"HM1511","warranty_period":12},{"id":144,"model_number":"DHK180","warranty_period":12},{"id":145,"model_number":"HP2070","warranty_period":6},{"id":146,"model_number":"HM1306","warranty_period":12},{"id":147,"model_number":"HM1812","warranty_period":12},{"id":148,"model_number":"HK1820","warranty_period":12},{"id":149,"model_number":"HP1630","warranty_period":6},{"id":150,"model_number":"GA003G","warranty_period":12},{"id":151,"model_number":"GA005G","warranty_period":12},{"id":152,"model_number":"GA011G","warranty_period":12},{"id":153,"model_number":"GA013G","warranty_period":12},{"id":154,"model_number":"GA021G","warranty_period":12},{"id":155,"model_number":"GA023G","warranty_period":12},{"id":156,"model_number":"GA027G","warranty_period":12},{"id":157,"model_number":"GA029G","warranty_period":12},{"id":158,"model_number":"GA045G","warranty_period":12},{"id":159,"model_number":"GA047G","warranty_period":12},{"id":160,"model_number":"GA048G","warranty_period":12},{"id":161,"model_number":"GA050G","warranty_period":12},{"id":162,"model_number":"GA051G","warranty_period":12},{"id":163,"model_number":"GA037G","warranty_period":12},{"id":164,"model_number":"GA038G","warranty_period":12},{"id":165,"model_number":"GA035G","warranty_period":12},{"id":166,"model_number":"GA036G","warranty_period":12},{"id":167,"model_number":"DGA700","warranty_period":12},{"id":168,"model_number":"DGA701","warranty_period":12},{"id":169,"model_number":"DGA901","warranty_period":12},{"id":170,"model_number":"DGA413","warranty_period":12},{"id":171,"model_number":"DGA513","warranty_period":12},{"id":172,"model_number":"DGA411","warranty_period":12},{"id":173,"model_number":"DGA511","warranty_period":12},{"id":174,"model_number":"DGA417","warranty_period":12},{"id":175,"model_number":"DGA517","warranty_period":12},{"id":176,"model_number":"DGA419","warranty_period":12},{"id":177,"model_number":"DGA519","warranty_period":12},{"id":178,"model_number":"GA5090","warranty_period":12},{"id":179,"model_number":"GA5091","warranty_period":12},{"id":180,"model_number":"GA5092","warranty_period":12},{"id":181,"model_number":"GA5093","warranty_period":12},{"id":182,"model_number":"GA5095","warranty_period":12},{"id":183,"model_number":"9565CR","warranty_period":12},{"id":184,"model_number":"GA4050R","warranty_period":12},{"id":185,"model_number":"GA4040","warranty_period":12},{"id":186,"model_number":"GA5010","warranty_period":12},{"id":187,"model_number":"GA5080R","warranty_period":12},{"id":188,"model_number":"9556HB","warranty_period":6},{"id":189,"model_number":"9558HN","warranty_period":6},{"id":190,"model_number":"9553NB","warranty_period":6},{"id":191,"model_number":"9553B","warranty_period":6},{"id":192,"model_number":"GA4032","warranty_period":12},{"id":193,"model_number":"GA7070","warranty_period":12},{"id":194,"model_number":"GA9070","warranty_period":12},{"id":195,"model_number":"GA7080","warranty_period":12},{"id":196,"model_number":"GA9080","warranty_period":12},{"id":197,"model_number":"GA7081","warranty_period":12},{"id":198,"model_number":"GA9081","warranty_period":12},{"id":199,"model_number":"GA7082","warranty_period":12},{"id":200,"model_number":"GA9082","warranty_period":12},{"id":201,"model_number":"GA9040S","warranty_period":12},{"id":202,"model_number":"GA7061R","warranty_period":12},{"id":203,"model_number":"GA9061R","warranty_period":12},{"id":204,"model_number":"GA7061","warranty_period":12},{"id":205,"model_number":"GA9061","warranty_period":12},{"id":206,"model_number":"GA7060\u00a0","warranty_period":12},{"id":207,"model_number":"GA7020\u00a0","warranty_period":6},{"id":208,"model_number":"GA9020\u00a0","warranty_period":6},{"id":209,"model_number":"GA7050R\u00a0","warranty_period":6},{"id":210,"model_number":"GA7050\u00a0","warranty_period":6},{"id":211,"model_number":"PV001G","warranty_period":12},{"id":212,"model_number":"9237C","warranty_period":6},{"id":213,"model_number":"DPV300","warranty_period":12},{"id":214,"model_number":"PV301D","warranty_period":12},{"id":215,"model_number":"SA7000C","warranty_period":6},{"id":216,"model_number":"GD0603","warranty_period":6},{"id":217,"model_number":"GD0801C","warranty_period":6},{"id":218,"model_number":"GD0601","warranty_period":6},{"id":219,"model_number":"GS6000","warranty_period":6},{"id":220,"model_number":"GS5000","warranty_period":6},{"id":221,"model_number":"GB801","warranty_period":6},{"id":222,"model_number":"GB602","warranty_period":6},{"id":223,"model_number":"PO5000C","warranty_period":6},{"id":224,"model_number":"BO6030","warranty_period":6},{"id":225,"model_number":"BO5031","warranty_period":6},{"id":226,"model_number":"DPO500","warranty_period":12},{"id":227,"model_number":"DBO480","warranty_period":12},{"id":228,"model_number":"DBO380","warranty_period":12},{"id":229,"model_number":"DBO482","warranty_period":12},{"id":230,"model_number":"DBO381","warranty_period":12},{"id":231,"model_number":"BO4556","warranty_period":6},{"id":232,"model_number":"DSL801","warranty_period":12},{"id":233,"model_number":"DBS180","warranty_period":12},{"id":234,"model_number":"9031","warranty_period":6},{"id":235,"model_number":"BO3710","warranty_period":6},{"id":236,"model_number":"9032","warranty_period":6},{"id":237,"model_number":"9741","warranty_period":6},{"id":238,"model_number":"CE002G","warranty_period":12},{"id":239,"model_number":"CE001G","warranty_period":12},{"id":240,"model_number":"DCE090","warranty_period":12},{"id":241,"model_number":"LW1401","warranty_period":6},{"id":242,"model_number":"4131","warranty_period":6},{"id":243,"model_number":"LC1230","warranty_period":6},{"id":244,"model_number":"DLW140","warranty_period":12},{"id":245,"model_number":"LW1400","warranty_period":6},{"id":246,"model_number":"4114S","warranty_period":6},{"id":247,"model_number":"4112HS","warranty_period":6},{"id":248,"model_number":"DCC500","warranty_period":12},{"id":249,"model_number":"CC301D","warranty_period":12},{"id":250,"model_number":"CS002G","warranty_period":12},{"id":251,"model_number":"SG1251J","warranty_period":6},{"id":252,"model_number":"DCC501","warranty_period":12},{"id":253,"model_number":"4100KB","warranty_period":6},{"id":254,"model_number":"DCS551","warranty_period":12},{"id":255,"model_number":"DSC191","warranty_period":12},{"id":256,"model_number":"DSC102","warranty_period":12},{"id":257,"model_number":"DMC300","warranty_period":12},{"id":258,"model_number":"PB002G","warranty_period":12},{"id":259,"model_number":"DPB183","warranty_period":12},{"id":260,"model_number":"DSC251","warranty_period":12},{"id":261,"model_number":"SC103D","warranty_period":12},{"id":262,"model_number":"CP100D","warranty_period":12},{"id":263,"model_number":"DPB182","warranty_period":12},{"id":264,"model_number":"DJS161","warranty_period":12},{"id":265,"model_number":"JS1602","warranty_period":6},{"id":266,"model_number":"JS3201","warranty_period":6},{"id":267,"model_number":"DPP200","warranty_period":12},{"id":268,"model_number":"JN3201","warranty_period":6},{"id":269,"model_number":"JN1601","warranty_period":6},{"id":270,"model_number":"2107FK","warranty_period":6},{"id":271,"model_number":"LS002G","warranty_period":12},{"id":272,"model_number":"LS004G","warranty_period":12},{"id":273,"model_number":"LS1219L","warranty_period":6},{"id":274,"model_number":"LS0816F","warranty_period":6},{"id":275,"model_number":"LS003G","warranty_period":12},{"id":276,"model_number":"DLS714","warranty_period":12},{"id":277,"model_number":"LS1019L","warranty_period":6},{"id":278,"model_number":"DLS600","warranty_period":12},{"id":279,"model_number":"LS1221","warranty_period":6},{"id":280,"model_number":"LS1040","warranty_period":12},{"id":281,"model_number":"MLT100","warranty_period":6},{"id":282,"model_number":"HS011G","warranty_period":12},{"id":283,"model_number":"LS1045","warranty_period":6},{"id":284,"model_number":"2712","warranty_period":6},{"id":285,"model_number":"HS009G","warranty_period":12},{"id":286,"model_number":"HS003G","warranty_period":12},{"id":287,"model_number":"RS001G","warranty_period":12},{"id":288,"model_number":"DHS900","warranty_period":12},{"id":289,"model_number":"DHS475","warranty_period":12},{"id":290,"model_number":"RS002G","warranty_period":12},{"id":291,"model_number":"HS012G","warranty_period":12},{"id":292,"model_number":"DHS783","warranty_period":12},{"id":293,"model_number":"HS7010","warranty_period":6},{"id":294,"model_number":"HS0600","warranty_period":6},{"id":295,"model_number":"5402NA","warranty_period":6},{"id":296,"model_number":"DSP600","warranty_period":12},{"id":297,"model_number":"HS7600","warranty_period":6},{"id":298,"model_number":"N5900B","warranty_period":6},{"id":299,"model_number":"SP001G","warranty_period":12},{"id":300,"model_number":"SP6000","warranty_period":6},{"id":301,"model_number":"LB1200F","warranty_period":6},{"id":302,"model_number":"DJV184","warranty_period":12},{"id":303,"model_number":"JV0600K","warranty_period":6},{"id":304,"model_number":"4350CT","warranty_period":6},{"id":305,"model_number":"JV001G","warranty_period":12},{"id":306,"model_number":"DJV181","warranty_period":12},{"id":307,"model_number":"DJV185","warranty_period":12},{"id":308,"model_number":"4327","warranty_period":6},{"id":309,"model_number":"JR002G","warranty_period":12},{"id":310,"model_number":"DJR189","warranty_period":12},{"id":311,"model_number":"JR001G","warranty_period":12},{"id":312,"model_number":"DJR188","warranty_period":12},{"id":313,"model_number":"DJR186","warranty_period":12},{"id":314,"model_number":"JR103D","warranty_period":12},{"id":315,"model_number":"SJ401","warranty_period":6},{"id":316,"model_number":"JR3070CT","warranty_period":6},{"id":317,"model_number":"JR3051T","warranty_period":12},{"id":318,"model_number":"DTM52","warranty_period":12},{"id":319,"model_number":"TM30D","warranty_period":12},{"id":320,"model_number":"DTM51","warranty_period":12},{"id":321,"model_number":"TM3000C","warranty_period":6},{"id":322,"model_number":"RT001G","warranty_period":12},{"id":323,"model_number":"KP001G","warranty_period":12},{"id":324,"model_number":"DRT50","warranty_period":12},{"id":325,"model_number":"3709","warranty_period":6},{"id":326,"model_number":"RP1111C","warranty_period":6},{"id":327,"model_number":"RP2301FC","warranty_period":6},{"id":328,"model_number":"RT0702C","warranty_period":6},{"id":329,"model_number":"RT0700C","warranty_period":6},{"id":330,"model_number":"RP2303FC","warranty_period":6},{"id":331,"model_number":"RP1802F","warranty_period":6},{"id":332,"model_number":"RP1800","warranty_period":6},{"id":333,"model_number":"PJ7000","warranty_period":6},{"id":334,"model_number":"2012NB","warranty_period":6},{"id":335,"model_number":"PC5010C","warranty_period":6},{"id":336,"model_number":"DKP181","warranty_period":12},{"id":337,"model_number":"1911B","warranty_period":6},{"id":338,"model_number":"PC5000C","warranty_period":6},{"id":339,"model_number":"DCO181","warranty_period":12},{"id":340,"model_number":"PT001G","warranty_period":12},{"id":341,"model_number":"DRV250","warranty_period":12},{"id":342,"model_number":"DTR180","warranty_period":12},{"id":343,"model_number":"FN001G","warranty_period":12},{"id":344,"model_number":"AF506","warranty_period":6},{"id":345,"model_number":"DRV150","warranty_period":12},{"id":346,"model_number":"DTR181","warranty_period":12},{"id":347,"model_number":"PT354D","warranty_period":12},{"id":348,"model_number":"VC006GM","warranty_period":12},{"id":349,"model_number":"VC004GL","warranty_period":12},{"id":350,"model_number":"VC002GL","warranty_period":12},{"id":351,"model_number":"DVC150L","warranty_period":12},{"id":352,"model_number":"VC005GL","warranty_period":12},{"id":353,"model_number":"VC003GL","warranty_period":12},{"id":354,"model_number":"VC001GL","warranty_period":12},{"id":355,"model_number":"DVC151L","warranty_period":12},{"id":356,"model_number":"DVC155L","warranty_period":12},{"id":357,"model_number":"DVC862L","warranty_period":12},{"id":358,"model_number":"DVC750L","warranty_period":12},{"id":359,"model_number":"VC3210L","warranty_period":6},{"id":360,"model_number":"DVC864L","warranty_period":12},{"id":361,"model_number":"DVC865L","warranty_period":12},{"id":362,"model_number":"VC2510L","warranty_period":6},{"id":363,"model_number":"VC2000L","warranty_period":6},{"id":364,"model_number":"VC008G","warranty_period":12},{"id":365,"model_number":"DVC660","warranty_period":12},{"id":366,"model_number":"DVC665","warranty_period":12},{"id":367,"model_number":"DVC261","warranty_period":12},{"id":368,"model_number":"DVC560","warranty_period":12},{"id":369,"model_number":"DCL184","warranty_period":12},{"id":370,"model_number":"DRC300","warranty_period":12},{"id":371,"model_number":"CL001G","warranty_period":12},{"id":372,"model_number":"CL002G","warranty_period":12},{"id":373,"model_number":"CL003G","warranty_period":12},{"id":374,"model_number":"DCL180","warranty_period":12},{"id":375,"model_number":"DCL284F","warranty_period":12},{"id":376,"model_number":"CL106FD","warranty_period":12},{"id":377,"model_number":"CL107FD","warranty_period":12},{"id":378,"model_number":"CL183D","warranty_period":12},{"id":379,"model_number":"PM001G","warranty_period":12},{"id":380,"model_number":"UB002C","warranty_period":12},{"id":381,"model_number":"UB001C","warranty_period":6},{"id":382,"model_number":"DUB363","warranty_period":12},{"id":383,"model_number":"DUB361","warranty_period":12},{"id":384,"model_number":"DUB184","warranty_period":12},{"id":385,"model_number":"UB001G","warranty_period":12},{"id":386,"model_number":"DUB362","warranty_period":12},{"id":387,"model_number":"DUB187","warranty_period":12},{"id":388,"model_number":"DUB183","warranty_period":12},{"id":389,"model_number":"DUB186","warranty_period":12},{"id":390,"model_number":"UB1102","warranty_period":6},{"id":391,"model_number":"AS001G","warranty_period":12},{"id":392,"model_number":"DAS180","warranty_period":12},{"id":393,"model_number":"DHW080","warranty_period":12},{"id":394,"model_number":"HW101","warranty_period":6},{"id":395,"model_number":"HW1200","warranty_period":6},{"id":396,"model_number":"HW102","warranty_period":6},{"id":397,"model_number":"HW1300","warranty_period":6},{"id":398,"model_number":"HW001G","warranty_period":12},{"id":399,"model_number":"UR101C","warranty_period":12},{"id":400,"model_number":"UR012G","warranty_period":12},{"id":401,"model_number":"UR016G","warranty_period":12},{"id":402,"model_number":"UR006G","warranty_period":12},{"id":403,"model_number":"UR201C","warranty_period":12},{"id":404,"model_number":"UR013G","warranty_period":12},{"id":405,"model_number":"UR007G","warranty_period":12},{"id":406,"model_number":"UR002G","warranty_period":12},{"id":407,"model_number":"DUR369A","warranty_period":12},{"id":408,"model_number":"DUR190L","warranty_period":12},{"id":409,"model_number":"DUR194","warranty_period":12},{"id":410,"model_number":"DUR187L","warranty_period":12},{"id":411,"model_number":"DUR368A","warranty_period":12},{"id":412,"model_number":"DUR190U","warranty_period":12},{"id":413,"model_number":"DUR193","warranty_period":12},{"id":414,"model_number":"UR3501","warranty_period":6},{"id":415,"model_number":"UX01G","warranty_period":12},{"id":416,"model_number":"DUX18","warranty_period":12},{"id":417,"model_number":"DUX60","warranty_period":12},{"id":418,"model_number":"UV001G","warranty_period":12},{"id":419,"model_number":"LM001C","warranty_period":12},{"id":420,"model_number":"LM002J","warranty_period":12},{"id":421,"model_number":"LM001J","warranty_period":12},{"id":422,"model_number":"LM004J","warranty_period":12},{"id":423,"model_number":"LM003J","warranty_period":12},{"id":424,"model_number":"LM002G","warranty_period":12},{"id":425,"model_number":"LM001G","warranty_period":12},{"id":426,"model_number":"LM003G","warranty_period":12},{"id":427,"model_number":"LM004G","warranty_period":12},{"id":428,"model_number":"DLM533","warranty_period":12},{"id":429,"model_number":"DLM532","warranty_period":12},{"id":430,"model_number":"DLM530","warranty_period":12},{"id":431,"model_number":"DLM539","warranty_period":12},{"id":432,"model_number":"DLM538","warranty_period":12},{"id":433,"model_number":"DLM481","warranty_period":12},{"id":434,"model_number":"DLM480","warranty_period":12},{"id":435,"model_number":"DLM462","warranty_period":12},{"id":436,"model_number":"DLM460","warranty_period":12},{"id":437,"model_number":"DLM432","warranty_period":12},{"id":438,"model_number":"DLM382","warranty_period":12},{"id":439,"model_number":"DLM330","warranty_period":12},{"id":440,"model_number":"DLM230","warranty_period":12},{"id":441,"model_number":"ELM4621","warranty_period":6},{"id":442,"model_number":"ELM4121","warranty_period":6},{"id":443,"model_number":"ELM3720","warranty_period":6},{"id":444,"model_number":"UC004G","warranty_period":12},{"id":445,"model_number":"UC003G","warranty_period":12},{"id":446,"model_number":"UC002G","warranty_period":12},{"id":447,"model_number":"UC006G","warranty_period":12},{"id":448,"model_number":"UC016G","warranty_period":12},{"id":449,"model_number":"DUC356","warranty_period":12},{"id":450,"model_number":"DUC353","warranty_period":12},{"id":451,"model_number":"DUC355","warranty_period":12},{"id":452,"model_number":"DUC357","warranty_period":12},{"id":453,"model_number":"DUC254","warranty_period":12},{"id":454,"model_number":"UC4550A","warranty_period":6},{"id":455,"model_number":"UC4041A","warranty_period":6},{"id":456,"model_number":"DUC150","warranty_period":12},{"id":457,"model_number":"DUC101","warranty_period":12},{"id":458,"model_number":"UC100D","warranty_period":12},{"id":459,"model_number":"UA004G","warranty_period":12},{"id":460,"model_number":"UA003G","warranty_period":12},{"id":461,"model_number":"DUA301","warranty_period":12},{"id":462,"model_number":"DUA300","warranty_period":12},{"id":463,"model_number":"UH006G","warranty_period":12},{"id":464,"model_number":"UH007G","warranty_period":12},{"id":465,"model_number":"DUH651","warranty_period":12},{"id":466,"model_number":"DUH502","warranty_period":12},{"id":467,"model_number":"DUH602","warranty_period":12},{"id":468,"model_number":"DUH506","warranty_period":12},{"id":469,"model_number":"DUH606","warranty_period":12},{"id":470,"model_number":"DUH507","warranty_period":12},{"id":471,"model_number":"DUH607","warranty_period":12},{"id":472,"model_number":"UH013G","warranty_period":12},{"id":473,"model_number":"UH014G","warranty_period":12},{"id":474,"model_number":"DUH604S","warranty_period":12},{"id":475,"model_number":"DUH754S","warranty_period":12},{"id":476,"model_number":"UH5261","warranty_period":6},{"id":477,"model_number":"DUN461W","warranty_period":12},{"id":478,"model_number":"DUP361","warranty_period":12},{"id":479,"model_number":"UP100D","warranty_period":12},{"id":480,"model_number":"UH6570","warranty_period":6},{"id":481,"model_number":"UH4261","warranty_period":6},{"id":482,"model_number":"DUP362","warranty_period":12},{"id":483,"model_number":"DUS158","warranty_period":12},{"id":484,"model_number":"DVF104","warranty_period":12},{"id":485,"model_number":"DUS054","warranty_period":12},{"id":486,"model_number":"DUS108","warranty_period":12},{"id":487,"model_number":"DVF154","warranty_period":12},{"id":488,"model_number":"US053D","warranty_period":12},{"id":489,"model_number":"DCU603","warranty_period":12},{"id":490,"model_number":"DCU605","warranty_period":12},{"id":491,"model_number":"DCU604","warranty_period":12},{"id":492,"model_number":"DCU180","warranty_period":12},{"id":493,"model_number":"SK700GD","warranty_period":6},{"id":494,"model_number":"SK312GD","warranty_period":0},{"id":495,"model_number":"SK40GD","warranty_period":6},{"id":496,"model_number":"SK10GD","warranty_period":6},{"id":497,"model_number":"SK700D","warranty_period":6},{"id":498,"model_number":"SK209GD","warranty_period":0},{"id":499,"model_number":"SK20GD","warranty_period":6},{"id":500,"model_number":"SK106GD","warranty_period":0},{"id":501,"model_number":"SK105GD","warranty_period":0},{"id":502,"model_number":"SK106D","warranty_period":0},{"id":503,"model_number":"SK105D","warranty_period":0},{"id":504,"model_number":"LD030P","warranty_period":6},{"id":505,"model_number":"LD080P","warranty_period":6},{"id":506,"model_number":"LD050P","warranty_period":6},{"id":507,"model_number":"DML805","warranty_period":0},{"id":508,"model_number":"DML815","warranty_period":0},{"id":509,"model_number":"DML800","warranty_period":0},{"id":510,"model_number":"CF002G","warranty_period":12},{"id":511,"model_number":"DCF301","warranty_period":12},{"id":512,"model_number":"DCF102","warranty_period":12},{"id":513,"model_number":"CF101D","warranty_period":12},{"id":514,"model_number":"DCF201","warranty_period":12},{"id":515,"model_number":"DFJ210","warranty_period":12},{"id":516,"model_number":"DFJ211","warranty_period":12},{"id":517,"model_number":"DFV210A","warranty_period":12},{"id":518,"model_number":"DFJ212A","warranty_period":12},{"id":519,"model_number":"DFJ213A","warranty_period":12},{"id":520,"model_number":"DCJ205","warranty_period":12},{"id":521,"model_number":"DCJ206","warranty_period":12},{"id":522,"model_number":"DFJ214A","warranty_period":12},{"id":523,"model_number":"DCV202","warranty_period":12},{"id":524,"model_number":"DCX201","warranty_period":12},{"id":525,"model_number":"MP001G","warranty_period":12},{"id":526,"model_number":"DMP181","warranty_period":12},{"id":527,"model_number":"DMP180","warranty_period":12},{"id":528,"model_number":"MP100D","warranty_period":12},{"id":529,"model_number":"DCB200","warranty_period":12},{"id":530,"model_number":"CB100D","warranty_period":12},{"id":531,"model_number":"CW001G","warranty_period":12},{"id":532,"model_number":"DCW180","warranty_period":12},{"id":533,"model_number":"CW003G","warranty_period":12},{"id":534,"model_number":"DGP180","warranty_period":12},{"id":535,"model_number":"DVP181","warranty_period":12},{"id":536,"model_number":"DVP180","warranty_period":12},{"id":537,"model_number":"DCG180","warranty_period":12},{"id":538,"model_number":"DHG180","warranty_period":6},{"id":539,"model_number":"HG6530V","warranty_period":6},{"id":540,"model_number":"HG6030","warranty_period":6},{"id":541,"model_number":"CG100D","warranty_period":6},{"id":542,"model_number":"DHG181","warranty_period":6},{"id":543,"model_number":"HG5030","warranty_period":6},{"id":544,"model_number":"M0600B","warranty_period":6},{"id":545,"model_number":"M6501B","warranty_period":6},{"id":546,"model_number":"M6600B","warranty_period":6},{"id":547,"model_number":"M8700B","warranty_period":6},{"id":548,"model_number":"M8701B","warranty_period":6},{"id":549,"model_number":"M6200B","warranty_period":6},{"id":550,"model_number":"M0801B","warranty_period":6},{"id":551,"model_number":"M8600B","warranty_period":6},{"id":552,"model_number":"M2401B","warranty_period":6},{"id":553,"model_number":"M2402B","warranty_period":6},{"id":554,"model_number":"M2403B","warranty_period":6},{"id":555,"model_number":"M4100B","warranty_period":6},{"id":556,"model_number":"M4101B","warranty_period":6},{"id":557,"model_number":"M0401B","warranty_period":6},{"id":558,"model_number":"M0900B","warranty_period":6},{"id":559,"model_number":"M0910B","warranty_period":6},{"id":560,"model_number":"M9512B","warranty_period":6},{"id":561,"model_number":"M9506B","warranty_period":6},{"id":562,"model_number":"M9509B","warranty_period":6},{"id":563,"model_number":"M9513B","warranty_period":6},{"id":564,"model_number":"M9002B","warranty_period":6},{"id":565,"model_number":"M0921B","warranty_period":6},{"id":566,"model_number":"M0920B","warranty_period":6},{"id":567,"model_number":"M9511B","warranty_period":6},{"id":568,"model_number":"M9100B","warranty_period":6},{"id":569,"model_number":"M9200B","warranty_period":6},{"id":570,"model_number":"M9201B","warranty_period":6},{"id":571,"model_number":"M9202B","warranty_period":6},{"id":572,"model_number":"M9400B","warranty_period":6},{"id":573,"model_number":"M5801B","warranty_period":6},{"id":574,"model_number":"M4302B","warranty_period":6},{"id":575,"model_number":"M4301B","warranty_period":6},{"id":576,"model_number":"M4500KB","warranty_period":6},{"id":577,"model_number":"M1902B","warranty_period":6},{"id":578,"model_number":"M3601B","warranty_period":6},{"id":579,"model_number":"M3602B","warranty_period":6},{"id":580,"model_number":"M3700B","warranty_period":6},{"id":581,"model_number":"M3600B","warranty_period":6},{"id":582,"model_number":"M4000B","warranty_period":6},{"id":583,"model_number":"MT410","warranty_period":6},{"id":584,"model_number":"RBC411U","warranty_period":6},{"id":585,"model_number":"EM3400U","warranty_period":6},{"id":586,"model_number":"EA4301F45B","warranty_period":6},{"id":587,"model_number":"HM0810TA","warranty_period":6},{"id":588,"model_number":"PLM4620N2","warranty_period":6},{"id":589,"model_number":"DRC200Z","warranty_period":12},{"id":590,"model_number":"DCS232T","warranty_period":6},{"id":591,"model_number":"EK7651H","warranty_period":6},{"id":592,"model_number":"RBC412U","warranty_period":6},{"id":593,"model_number":"EA3502S40B","warranty_period":6},{"id":594,"model_number":"EK7301","warranty_period":6},{"id":595,"model_number":"DPT353Z","warranty_period":6},{"id":596,"model_number":"DCS7301","warranty_period":6},{"id":597,"model_number":"EK8100","warranty_period":6},{"id":598,"model_number":"AT1216AZ","warranty_period":6},{"id":599,"model_number":"DVR850Z","warranty_period":6},{"id":600,"model_number":"HR2470\/B","warranty_period":6},{"id":601,"model_number":"GA5010\/B","warranty_period":6},{"id":602,"model_number":"RBC411","warranty_period":6},{"id":603,"model_number":"EA7900P45E","warranty_period":6},{"id":604,"model_number":"EH5000W","warranty_period":6},{"id":605,"model_number":"AN560","warranty_period":6},{"id":606,"model_number":"EA3110T25B","warranty_period":6},{"id":607,"model_number":"AF505N","warranty_period":6},{"id":608,"model_number":"PLM4625NP","warranty_period":6},{"id":609,"model_number":"EH6000W","warranty_period":6},{"id":610,"model_number":"JV002GZ","warranty_period":12},{"id":611,"model_number":"BHX2500","warranty_period":6},{"id":612,"model_number":"UB001GZ","warranty_period":12},{"id":613,"model_number":"TW140DZ","warranty_period":12},{"id":614,"model_number":"EM2500U","warranty_period":6},{"id":615,"model_number":"M9506B\/B","warranty_period":6},{"id":616,"model_number":"BTS130Z","warranty_period":12},{"id":617,"model_number":"DPC8132","warranty_period":6},{"id":618,"model_number":"PLM4620N","warranty_period":6},{"id":619,"model_number":"JR3050T","warranty_period":6},{"id":620,"model_number":"ELM4110","warranty_period":6},{"id":621,"model_number":"ELM4613","warranty_period":6},{"id":622,"model_number":"M1901B","warranty_period":6},{"id":623,"model_number":"DTD148Z","warranty_period":6},{"id":624,"model_number":"RBC2510","warranty_period":6},{"id":625,"model_number":"HW112","warranty_period":6},{"id":626,"model_number":"BTD064Z","warranty_period":12},{"id":627,"model_number":"HW151","warranty_period":6},{"id":628,"model_number":"HW132","warranty_period":6},{"id":629,"model_number":"DTWA190Z","warranty_period":12},{"id":630,"model_number":"DCS430","warranty_period":6}]');
                var item = modell.find(item => item.model_number === modelNumber);
                var modelId=item.id;
                return modelId;
            }

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
        });
    </script>
    @push('scripts')
    @endpush
    @endsection