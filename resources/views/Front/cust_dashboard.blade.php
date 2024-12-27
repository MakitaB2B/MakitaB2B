@extends('Front/cust_layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
        <main class="main-content bg-grey">
            <div class="container">
                <div class="dashboard">
                    <div class="header">
                        <h1>Management Dashboard</h1>
                    </div>
                    <div class="cards-container">
                        <div class="card" onclick="location.href='warranty-service.html'">
                            <i class="fas fa-clipboard-check card-icon" style="transform: scale(1);"></i>
                            <h2 class="card-title">Register Warranty</h2>
                            <p class="card-description">Register your product warranty for extended coverage and support.</p>
                            <a href="register-warranty.html" class="card-link">Register Now →</a>
                        </div>
            
                        <div class="card" onclick="location.href='warranty-list.html'">
                            <i class="fas fa-list-alt card-icon" style="transform: scale(1);"></i>
                            <h2 class="card-title">Warranty List</h2>
                            <p class="card-description">View and manage all your registered product warranties.</p>
                            <a href="warranty-list.html" class="card-link">View List →</a>
                        </div>
            
                        <div class="card" onclick="location.href='tool-service.html'">
                            <i class="fas fa-tools card-icon" style="transform: scale(1);"></i>
                            <h2 class="card-title">Tools Repair List</h2>
                            <p class="card-description">Track and manage your tool repair requests and status.</p>
                            <a href="repair-list.html" class="card-link">View Repairs →</a>
                        </div>            
                    </div>
                </div>
            </div>
        </main>
@endsection 