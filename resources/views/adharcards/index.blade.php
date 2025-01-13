@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>List of Aadhar Cards</h2>
        @include('layouts.message')
        <a href="{{ route('adhar.form') }}" class="btn btn-primary">Create New Record</a></br></br>

        @if($adharCards->isEmpty())
            <div class="alert alert-warning">No Aadhar card records found.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Aadhar Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adharCards as $card)
                        <tr>
                            <td>{{ $card->name }}</td>
                            <td>
                                <?php
                                    // $aadharNumber = base64_decode($card->aadhar_number);
                                    // $maskedAadharNumber = 'XXXX-XXXX-' . substr($aadharNumber, -4);
                                ?>
                                {{ $card->masked_aadhar_number }}
                            </td>
                            
                            <td>
                                <a href="{{ route('adharcards.edit', [$card->id]) }}" class="btn btn-info btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection