@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Edit Aadhar Card</h2>

        @include('layouts.message')

        <form action="{{ route('adharcards.update', $card->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $card->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="aadhar_number" class="form-label">Aadhar Number</label>
                <input type="text" name="aadhar_number" id="aadhar_number" class="form-control" placeholder="Enter your Aadhar number" value="{{ $card->masked_aadhar_number }}" required>
                @error('aadhar_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('adhar.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    @push('custom-scripts')
        <script>
             $(document).ready(function () {
                $('#aadhar_number').on('input', function() {
                    $('#aadhar_number').mask('0000-0000-0000', {
                        placeholder: "____-____-____"
                    });
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
