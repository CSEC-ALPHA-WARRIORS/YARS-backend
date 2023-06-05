<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\EducationalBackground;
use App\Models\EmergencyContact;
use App\Models\Registration;
use App\Models\Students;
use App\Models\Courses;
use App\Models\Payment;

use Chapa\Chapa;
use Chapa\Exception\InvalidPostDataException;
use Chapa\Model\PostData;
use Chapa\Util;

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

        $token = $new_student->createToken("mytoken")->plainTextToken;
       
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
            'token' => $token,
            'student' => $new_student,
            'address' => $new_address,
            'educational_background' => $new_educational_background,
            'emergency_contact' => $new_emergency_contact,
            'registration' => $new_registration,
            'courses' => $courses
        ];

        return response($response, 201);
    }

    public function login(Request $request) 
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $student = Students::where('email', $fields['email'])->first();

        if(!$student || !Hash::check($fields['password'], $student->password)) {
            return response([
                'message' => 'Invalid credentials!!'
            ], 401);
        }

        $token = $student->createToken("mytoken")->plainTextToken;

        $response = [
            'student' => $student,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function pay(Request $request) {
        $request->validate([
            'registration_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
        ]); 
        
        if($request['type'] == "chapa"){
            $chapa = new Chapa('CHASECK_TEST-WcI7TGQPUKD6WOTvaqqOG3y4G653y6dP');
            $transactionRef = Util::generateToken();
            $postData = new PostData();
            $postData->amount('100')
                ->currency('ETB')
                ->email('abebe@bikila.com')
                ->firstname('test')
                ->lastname('user')
                ->transactionRef($transactionRef)
                ->callbackUrl('https://chapa.co')
                ->customizations(
                    array(
                        'customization[title]' => 'YARS',
                        'customization[description]' => 'It is time to pay'
                    )
                );
    
            $response1 = $chapa->initialize($postData);
            print_r($response1->getMessage());
            print_r($response1->getStatus());
            print_r($response1->getData());
            // echo $response1->getRawJson();
            
            $response2 = $chapa->verify($transactionRef);
            if($response2->getStatusCode() == 200){
                echo 'Payment not verified because ' . $response2->getMessage()['message'];
            }
        }

        $mytime = Carbon::now();

        $data = [
            'registration_id' => $request['registration_id'],
            'amount' => $request['amount'],
            'paid_at' => $mytime->toDateTimeString(),
            'type' => $request['type'],
            'status' => 'pending',
            'receipt_url' => isset($request['receipt_url']) ? isset($request['receipt_url']) : ''
        ];

        return Payment::create($data);
    }

    public function getRegistration(string $id) {
        return Registration::where([['student_id', $id]])->get();
    }

}
