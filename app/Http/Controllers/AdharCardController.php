<?php

namespace App\Http\Controllers;

use App\Models\UserAdharCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdharCardController extends Controller
{

    public function index()
    {
        $data = [];
        $data['adharCards'] = UserAdharCard::where('user_id', auth()->id())->get();
        return view('adharcards.index', $data);
    }

    public function showAdharForm()
    {
        return view('adhar_card_form');
    }

    public function adharStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'aadhar_number' => [
                'required',
                'regex:/^\d{4}-\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) {
                    $pureAadharNumber = str_replace('-', '', $value);
                    $existingCard = UserAdharCard::where('aadhar_number', base64_encode($pureAadharNumber))->first();

                    if ($existingCard) {
                        $fail('The Aadhar number has already been taken.');
                    }
                },
            ],
        ]);

        $pureAadharNumber = str_replace('-', '', $request->aadhar_number);

        $encodedAadharNumber = base64_encode($pureAadharNumber);

        UserAdharCard::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'aadhar_number' => $encodedAadharNumber,
        ]);

        return redirect()->route('adhar.list')->with(['success' => 'Aadhar card details saved successfully']);
    }

    public function edit($id)
    {
        $card = UserAdharCard::findOrFail($id);
        return view('adharcards.edit', compact('card'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'aadhar_number' => [
                'required',
                'regex:/^\d{4}-\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($id) {
                    $pureAadharNumber = str_replace('-', '', $value);
                    $existingCard = UserAdharCard::where('aadhar_number', base64_encode($pureAadharNumber))
                        ->where('id', '!=', $id)
                        ->first();

                    if ($existingCard) {
                        $fail('The Aadhar number has already been taken.');
                    }
                },
            ],
        ]);

        $card = UserAdharCard::findOrFail($id);

        $pureAadharNumber = str_replace('-', '', $request->aadhar_number);

        $encodedAadharNumber = base64_encode($pureAadharNumber);

        $card->update([
            'name' => $request->name,
            'aadhar_number' => $encodedAadharNumber,
        ]);

        session()->flash('success', 'Aadhar card details updated successfully.');

        return redirect()->route('adhar.list');
    }
}
