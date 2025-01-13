<?php

namespace App\Http\Controllers;

use App\Models\UserAdharCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                    $cards = UserAdharCard::where('user_id', auth()->id())->get();

                    foreach ($cards as $card) {
                        if (Hash::check($pureAadharNumber, $card->aadhar_number)) {
                            $fail('The Aadhar number already exists.');
                            return;
                        }
                    }
                },
            ],
        ]);

        $pureAadharNumber = str_replace('-', '', $request->aadhar_number);
        $hashedAadharNumber = Hash::make($pureAadharNumber);
        $maskedAadharNumber = 'XXXX-XXXX-' . substr($pureAadharNumber, -4);

        UserAdharCard::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'aadhar_number' => $hashedAadharNumber,
            'masked_aadhar_number' => $maskedAadharNumber,
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
                    $cards = UserAdharCard::where('user_id', auth()->id())->where('id', '!=', $id)->get();

                    foreach ($cards as $card) {
                        if (Hash::check($pureAadharNumber, $card->aadhar_number)) {
                            $fail('The Aadhar number already exists.');
                            return;
                        }
                    }
                },
            ],
        ]);

        $card = UserAdharCard::findOrFail($id);

        $pureAadharNumber = str_replace('-', '', $request->aadhar_number);
        $hashedAadharNumber = Hash::make($pureAadharNumber);
        $maskedAadharNumber = 'XXXX-XXXX-' . substr($pureAadharNumber, -4);
        // $encodedAadharNumber = base64_encode($pureAadharNumber);

        $card->update([
            'name' => $request->name,
            'aadhar_number' => $hashedAadharNumber,
            'masked_aadhar_number' => $maskedAadharNumber,
        ]);

        session()->flash('success', 'Aadhar card details updated successfully.');

        return redirect()->route('adhar.list');
    }
}
