<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create($validated);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil dihapus!');
    }
}
