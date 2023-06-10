<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\Students;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Courses;
use App\Models\EducationalBackground;
use App\Models\EmergencyContact;

class AdminController extends Controller
{

    public function login(Request $request) 
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $fields['email'])->first();

        if(!$admin || !Hash::check($fields['password'], $admin->password)) {
            return response([
                'message' => 'Invalid credentials!!'
            ], 401);
        }

        $token = $admin->createToken("mytoken")->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token
        ];

        return response($response, 201);
    }

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

    function getCourses(Request $request) {
        $limit = $request->query('limit');
        $offset = $request->query('offset');

        return DB::table('courses')->skip($offset)->take($limit)->get();
    }

    function addAdmin(Request $request) {

        $token = $request->bearerToken();

        // TODO: check admin role

        $request->validate([
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required', 
            'email' => 'required', 
            'phonenumber' => 'required',
            'role' => 'required'
        ]);

        $data = [
            'fname' => $request['fname'],
            'mname' => $request['mname'],
            'lname' => $request['lname'], 
            'email' => $request['email'], 
            'phonenumber' => $request['phonenumber'],
            'password' => password_hash($request['fname'].$request['lname'], PASSWORD_DEFAULT),
            'role' => $request['role']
        ];

        return Admin::create($data);
    }

    function removeAdmin(string $id) {
        return Admin::destroy($id);
    }

    function getStudents() {
        return Students::all();
    }

    function getStudentById(string $id) {
        $student = Students::find($id);
        $address = Address::where([['student_id', $id]])->get();
        $emergency_contact = EmergencyContact::where([['student_id', $id]])->get();
        $educational_background = EducationalBackground::where([['student_id', $id]])->get();
        $registrations = Registration::where([['student_id', $id]])->get();
        $payments = [];

        foreach($registrations as $reg){
            $payment = Payment::where([['registration_id', $reg['id']]])->get();
            array_push($payments, $payment);
        }

        $response = [
            'basic_info' => $student,
            'address' => $address,
            'emergency_contact' => $emergency_contact,
            'educational_background' => $educational_background,
            'registrations' => $registrations,
            'payments' => $payments
        ];

        return response($response);
    }

    function getRegistrations() {
        return Registration::all();
    }

    function getPayments() {
        return Payment::all();
    }

    function verifyPayment(string $id) {
        $payment = Payment::find($id);
        $payment->update(array('status' => 'verified'));
        return $payment;
    }
}
