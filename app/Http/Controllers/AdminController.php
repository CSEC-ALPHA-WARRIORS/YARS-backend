<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Payment;
use App\Models\Registration;

class AdminController extends Controller
{
    function addAdmin(Request $request) {

    }

    function getStudents() {
        return Students::all();
    }

    function getRegistrations() {
        return Registration::all();
    }

    function getPayments() {
        return Payment::all();
    }

    function addPayment(Request $request) {

    }

    function verifyRegistration(string $id) {

    }
}
