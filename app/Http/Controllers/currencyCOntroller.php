<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class currencyCOntroller extends Controller
{
    public function index()
    {
        $response = Http::get('http://tu-dominio/currencies');
        $currencies = $response->json();
        return view('currencies.index', compact('currencies'));
    }}
