@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Adharcard Form</h2>
                <form action="{{ route('adhar.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="aadhar_number" class="form-label">Aadhar Number</label>
                        <input type="text" name="aadhar_number" id="aadhar_number" class="form-control" 
                               placeholder="Enter your Aadhar number" required>
                        <div class="invalid-feedback">Please enter a valid Aadhar number (16 digits).</div>
                        @error('aadhar_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('adhar.list') }}" class="btn btn-danger">Back to listing</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script>
            $(document).ready(function () {
                $('#aadhar_number').mask('0000-0000-0000', {
                    placeholder: "____-____-____"
                });
            
                $('form').on('submit', function (e) {
                    var aadharNumber = $('#aadhar_number').val();
                    if (!/^\d{4}-\d{4}-\d{4}$/.test(aadharNumber)) {
                        $('#aadhar_number').addClass('is-invalid');
                        e.preventDefault();
                    } else {
                        $('#aadhar_number').removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endpush
@endsection
