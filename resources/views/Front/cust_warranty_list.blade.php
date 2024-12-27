@extends('Front/cust_layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
        <main class="main-content bg-grey">
            <div class="container">
                    <header class="dashboard-header">
                        <h1 class="dashboard-title">Warranty List Dashboard</h1>
                        <!-- <button class="btn btn-primary" data-click="modal" data-target="#serviceModal">                            
                            + New Service Request
                        </button> -->
                    </header>
            
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-title">Active Requests</div>
                            <div class="stat-value">12</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-title">Under Warranty</div>
                            <div class="stat-value">8</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-title">Pending Diagnosis</div>
                            <div class="stat-value">3</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-title">Completed This Month</div>
                            <div class="stat-value">24</div>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Warranty List</h2>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Serial No.	</th>
                                        <th class="mobile-hide">Period</th>
                                        <th class="mobile-hide">Purchase Date</th>
                                        <th class="mobile-hide">Warranty End</th>
                                        <th class="mobile-hide">Status</th>
                                        <th>Service</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-row">
                                        <td>#532027529</td>
                                        <td>DF001G</td>
                                        <td class="mobile-hide">SL125AWAA</td>
                                        <td class="mobile-hide">27 Nov 2024</td>
                                        <td class="mobile-hide">HQ Service Center</td>
                                        <td><span class="status-badge status-warranty">Solved</span></td>
                                        <td><a href="javascript:;" class="raise" data-value="SL125AWAA">Raise Concern</a></td>
                                    </tr>
                                    <tr class="table-row">
                                        <td>#532027529</td>
                                        <td>DF001G</td>
                                        <td class="mobile-hide">SL125AWAA</td>
                                        <td class="mobile-hide">27 Nov 2024</td>
                                        <td class="mobile-hide">HQ Service Center</td>
                                        <td><span class="status-badge status-diagnosing">Yet to Review</span></td>
                                        <td><a href="javascript:;" class="raise" data-value="SL125AW2">Raise Concern</a></td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Warranty Information</h2>
                        </div>
                        <div class="warranty-tabs">
                            <button class="warranty-tab active">Under Warranty</button>
                            <button class="warranty-tab">Not Covered</button>
                            <button class="warranty-tab">Power Tools</button>
                        </div>
                        <div class="warranty-content">
                            <ul class="examples-list">
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    Warranty on Armature can be considered since the segments of the commutator are lifted
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    Warranty on Armature can be considered due to burning of single coil of windings
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    Warranty on Armature can be considered due to burning of windings
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    Warranty on Armature can be considered since the commutator segments are burned
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </main>

    <div class="modal-overlay" id="serviceModal">
        <div class="modal">
            <div class="modal-header">
                <div class="dashboard-title">
                    Warranty Form
                </div>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-content">
                <form action="post" class="service-form">
                    <div class="form-group">
                        <label for="">Model Number* </label>
                        <div class="custom-select-container" id="select2">
                            <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                            <div class="dropdown-arrow"></div>
                            <div class="custom-select-dropdown">
                                <input type="text" class="search-box" placeholder="Type to search..." required>
                                <div class="options-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Dealer/Customer Name*</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="">Contact Number*</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="">Model Number* </label>
                        <div class="custom-select-container" id="select1">
                            <input type="text" class="custom-select-input" readonly placeholder="Select an option..." required>
                            <div class="dropdown-arrow"></div>
                            <div class="custom-select-dropdown">
                                <input type="text" class="search-box" placeholder="Type to search...">
                                <div class="options-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tool Serial No.*</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Issue*</label>
                        <textarea placeholder="Enter your comment here" name="comment" required></textarea>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary submit-button">Submit</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    @endpush
    @endsection
