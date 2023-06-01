<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Address;
use App\Models\EducationalBackground;
use App\Models\EmergencyContact;
use App\Models\Registration;
use App\Models\Students;
use App\Models\Courses;

class StudentController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'profile_picture_url' => 'required',
            'email' => 'required',
            'phonenumber' => 'required',
            'password' => 'required',
            'type' => 'required',
            'address' => 'required',
            'educational_background' => 'required',
            'emergency_contact' => 'required',
            'registration' => 'required' 
        ]);

        $basic_data = [
            'fname' => $request->all()['fname'],
            'mname' => $request->all()['mname'],
            'lname' => $request->all()['lname'],
            'profile_picture_url' => $request->all()['profile_picture_url'],
            'email' => $request->all()['email'],
            'phonenumber' => $request->all()['phonenumber'],
            'password' => password_hash($request->all()['password'], PASSWORD_DEFAULT),
            'type' => $request->all()['type']
        ];

        $new_student = Students::create($basic_data);

        $address = [
            'city' => $request->all()['address']['city'],
            'kebele' => $request->all()['address']['kebele'],
            'woreda' => $request->all()['address']['woreda'],
            'house_no' => $request->all()['address']['house_no'],
            'student_id' => $new_student['id'] 
        ];

       
        $new_address = Address::create($address);

        $educational_background = [
            'school_name' => $request->all()['educational_background']['school_name'],
            'start_date' =>  date('Y-m-d', strtotime($request->all()['educational_background']['start_date'])),
            'end_date' =>  date('Y-m-d', strtotime($request->all()['educational_background']['end_date'])),
            'gpa' => $request->all()['educational_background']['gpa'],
            'student_id' => $new_student['id']
        ];

        $new_educational_background = EducationalBackground::create($educational_background);


        $emergency_contact = [
            'fname' => $request->all()['emergency_contact']['fname'],
            'mname' => $request->all()['emergency_contact']['mname'],
            'lname' => $request->all()['emergency_contact']['lname'], 
            'relationship'  => $request->all()['emergency_contact']['relationship'], 
            'phonenumber'  => $request->all()['emergency_contact']['phonenumber'],
            'student_id' =>  $new_student['id']
        ];

        $new_emergency_contact = EmergencyContact::create($emergency_contact);

        $registration = [
            'year' => $request->all()['registration']['year'],
            'semester' => $request->all()['registration']['semester'],
            'program' => $request->all()['registration']['program'],
            'level' => $request->all()['registration']['level'],
            'registered_at' => date('Y-m-d', strtotime($request->all()['registration']['registered_at'])),
            'student_id' => $new_student['id']
        ];

        $new_registration = Registration::create($registration);

        $courses = Courses::where(
            [
                ['year', $new_registration['year']],
                ['semester', $new_registration['semester']],
                ['program', $new_registration['program']]
           ]
        )->get();

        $response = [
            'student' => $new_student,
            'address' => $new_address,
            'educational_background' => $new_educational_background,
            'emergency_contact' => $new_emergency_contact,
            'registration' => $new_registration,
            'courses' => $courses
        ];

        return response($response, 201);
    }

    public function update(Request $request, string $id) {
        
    }
}
