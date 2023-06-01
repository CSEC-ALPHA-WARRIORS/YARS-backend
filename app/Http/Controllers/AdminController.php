<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Students;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Courses;

class AdminController extends Controller
{

    function addCourse(Request $request) {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'program' => 'required',
            'credit_hours' => 'required'
        ]);
        return Courses::create($request->all());
    }

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
