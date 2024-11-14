@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Travel Management - LTC Claim</h2>

    <!-- Form Starts -->
    <form method="POST" action="" enctype="multipart/form-data">
{{-- 
        {{ route('submitLTCClaim') }} --}}
        @csrf
        
        <!-- Mode of Transport Section -->
        <div class="card">
            <div class="card-header">
                <h3>Mode of Transport</h3>
            </div>
            <div class="card-body">
                <!-- Company Vehicle -->
                <div class="form-group">
                    <label for="company_vehicle_no">Vehicle No</label>
                    <select class="form-control" name="company_vehicle_no" id="company_vehicle_no">
                        <option value="">Select Vehicle</option>
                        <!-- Add vehicle options dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="fuel_amount">Claim Amount (Fuel)</label>
                    <input type="number" class="form-control" name="fuel_amount" id="fuel_amount" required>
                </div>

                <!-- Personal Vehicle -->
                <div class="form-group">
                    <label for="opening_meter">Opening Meter</label>
                    <input type="number" class="form-control" name="opening_meter" id="opening_meter">
                </div>
                <div class="form-group">
                    <label for="closing_meter">Closing Meter</label>
                    <input type="number" class="form-control" name="closing_meter" id="closing_meter">
                </div>
                <div class="form-group">
                    <label for="total_km">Total Km</label>
                    <input type="number" class="form-control" name="total_km" id="total_km" readonly>
                </div>
                <div class="form-group">
                    <label for="fuel_claim">Claim Amount (Fuel)</label>
                    <input type="number" class="form-control" name="fuel_claim" id="fuel_claim" readonly>
                </div>

                <!-- Attachments -->
                <div class="form-group">
                    <label for="vehicle_attachment">Attach Documents</label>
                    <input type="file" class="form-control" name="vehicle_attachment[]" multiple>
                </div>
            </div>
        </div>

        <!-- Food Exp Section -->
        <div class="card mt-3">
            <div class="card-header">
                <h3>Food Expenses</h3>
            </div>
            <div class="card-body">
                <!-- Time Inputs -->
                <div class="form-group">
                    <label for="in_time">In Time</label>
                    <input type="time" class="form-control" name="in_time" id="in_time" required>
                </div>
                <div class="form-group">
                    <label for="out_time">Out Time</label>
                    <input type="time" class="form-control" name="out_time" id="out_time" required>
                </div>

                <!-- Meal Exp -->
                <div class="form-group">
                    <label for="meal_exp">Claimable Meal Expense</label>
                    <select class="form-control" name="meal_exp" id="meal_exp" required>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Miscellaneous Exp Section -->
        <div class="card mt-3">
            <div class="card-header">
                <h3>Miscellaneous Expenses</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="miscellaneous_label">Label</label>
                    <select class="form-control" name="miscellaneous_label" id="miscellaneous_label">
                        <option value="general">General</option>
                        <option value="special">Special</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="miscellaneous_amount">Amount</label>
                    <input type="number" class="form-control" name="miscellaneous_amount" id="miscellaneous_amount" required>
                </div>
                <div class="form-group">
                    <label for="miscellaneous_attachment">Attach Bill</label>
                    <input type="file" class="form-control" name="miscellaneous_attachment[]" multiple>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Submit Claim</button>
    </form>
</div>
@endsection
