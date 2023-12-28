@extends('Front/layout')
@section('page_title', 'Makita Warranty | Warranty Card')
@section('warrantycard_select', 'active')
@section('container')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <div class="col-md-4">
                <p>Warranty? Reach Us at.</p>
                <p><span class="glyphicon glyphicon-map-marker"></span>Bangalore, India</p>
                <p><span class="glyphicon glyphicon-phone"></span>Phone: +91-80-2205-8200</p>
                <p><span class="glyphicon glyphicon-envelope"></span>Email: sales@makita.in</p>
            </div>
            <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <h1 style="color: green;">Thanks! for registaring with Us</h1>
                        </div>
                    </div>
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
@endsection
