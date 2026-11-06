<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::query()
            ->orderBy('name')
            ->paginate(5);

        return view('country.index', compact('countries'));
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(CountryRequest $request)
    {
        Country::create($request->validated());

        return redirect()->route('country.index');
    }

    public function show(Country $country)
    {
        return view('country.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        return redirect()->route('country.index');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('country.index');
    }
}
