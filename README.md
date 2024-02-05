# Yet Another Registration System (YARS)

Backend app for Yet Another Registration System made by using laravel. 

## Group Members

| ID | Name |
|:----|------|
| UGR/22574/13 | Abel Wendemu |
| UGR/22505/13 | Besufikad Micheal |
| UGR/22779/13 | Eden Birhan |
| UGR/22512/13 | Ephrem Getachew |
| UGR/22527/13 | Naol Chala |
| UGR/22734/13 | Samuel Teklemariam |


## Installation

1. Clonning the repo
   
   ```bash
    git clone https://github.com/CSEC-ALPHA-WARRIORS/YARS-backend.git
   ```

2. Installing packages
   
   ```bash
    cd YARS-backend && php composer.phar update
    ```
3. Connecting database
   
   ```.env
   // storing DB config in .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=YARS
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Running
    ```bash 
    php artisan serve
    ```

## Usage

 -  base-url : http://localhost:8000/api

  ### Endpoints

| Endpoint         | Request Type | Headers                              | Body/ Param                                                                                | Response                                                                                  | URL                  |
|------------------|--------------|--------------------------------------|--------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------|----------------------|
| Register         | POST         |                                      | Body : { <a href="#student">student</a>, <a href="#address">address</a>, <a href="#econtact">emergency_contact</a>,      <a href="#ebackground">educational_background</a>, <a href="#registration">registration</a> } | { <a href="#student">student</a>, <a href="#address">address</a>, <a href="#econtact">emergency_contact</a>,      <a href="#ebackground">educational_background</a>, <a href="#registration">registration</a>, token } | /register            |
| Login            | POST         |                                      | Body: { email, password }                                                                  | { <a href="#student">student</a>, token }                                                                        | /login               |
| GetRegistration  | GET          | { Authorization: `Bearer ${token}` } | Param: { student_id }                                                                      | [ <a href="#registration">registration</a> ]                                                                          | /registrations/{id}  |
| PayWithChapa     | POST         | { Authorization: `Bearer ${token}` } | Body: { <a href="#payment">payment</a> }                                                                          | { callback_url, <a href="#payment">payment</a> }                                                                               | /pay                 |
| PayManually      | POST         | { Authorization: `Bearer ${token}` } | Body: { <a href="#payment">payment</a> }                                                                          | { <a href="#payment">payment</a> }                                                                               | /pay                 |
| Admin Login      | POST         |                                      | Body: { email, password }                                                                  | { <a href="#admin">admin</a>, token }                                                                          | /admin/login         |
| AddAdmin         | POST         | { Authorization: `Bearer ${token}` } | Body: { <a href="#admin">admin</a> }                                                                            | { <a href="#admin">admin</a> }                                                                                 | /admin/add           |
| GetAdmins          | GET          | { Authorization: `Bearer ${token}` } | Param: { take, skip }                                                                      | [ <a href="#admin">Admin</a> ]                                                                                 | /admins                   |
| AddCourse        | POST         | { Authorization: `Bearer ${token}` } | Body: { <a href="#course">course</a> }                                                                           | { <a href="#course">course</a> }                                                                                | /course/add          |
| GetCourses         | GET          | { Authorization: `Bearer ${token}` } | Param: { take, skip }                                                                      | [ <a href="#course">Course ]                                                                                | /courses                  |
| RemoveCourse       | Delete       | { Authorization: `Bearer ${token}` } | Body: { id }                                                                               | { integer (1 success) }                                                                   | /course/remove/{id}       |
| GetAdmins          | GET          | { Authorization: `Bearer ${token}` } | Param: { take, skip }                                                                      | [ <a href="#admin">Admin</a> ]                                                                                 | /admins                   |
| GetStudents      | GET          | { Authorization: `Bearer ${token}` } | Param: { take, skip }                                                                        | [ <a href="#student">student</a> ]                                                                               | /students            |
| GetStudentById   | GET          | { Authorization: `Bearer ${token}` } | Param: { id }                                                                              | { <a href="#student">student</a> }                                                                               | /student/{id}        |
| GetRegistrations | GET          | { Authorization: `Bearer ${token}` } |  Param: { take, skip }                                                                                           | [ <a href="#registration">registrations</a> ]                                                                         | /registrations       |
| VerifyRegistration | PUT          | { Authorization: `Bearer ${token}` } | Param: { id }                                                                              | { <a href="#registration">registration</a> }                                                                          | /registration/verify/{id} |
| GetPayments      | GET          | { Authorization: `Bearer ${token}` } |  Param: { take, skip }                                                                                          | [ <a href="#payment">payment</a> ]                                                                              | /payments            |
| VerifyPayment    | PUT          | { Authorization: `Bearer ${token}` } | Param: { id }                                                                              | { <a href="#payment">payment</a> }                                                                               | /payment/verify/{id} |
| RemoveAdmin      | DELETE       | { Authorization: `Bearer ${token}` } | Param: { id }                                                                              | { integer (1 success) }                                                                   | /admin/remove/{id}   |

## Models

<h3 id="student">Student</h3>

```json
    {
        "fname": "first name",
        "mname": "middle name",
        "lname": "last name",
        "profile_picture_url": "profile picture url",
        "email": "email",
        "phonenumber": "phone number",
        "password": "password",
        "type": "Regular or Extension",
    }
```

<h3 id="admin">Admin</h3>

```json
    {
        "fname": "first name",
        "mname": "middle name",
        "lname": "last name",
        "email": "email",
        "phonenumber": "phone number",
        "password": "password",
        "role": "registrar_head or registrar_employee",
    }
```

<h3 id="address">Address</h3>

```json
    {
        "city": "city",
        "woreda": "woreda",
        "kebele": "kebele",
        "house_no": "house number"
    }
```
<h3 id="econtact">Emergency contact</h3>

```json
   {
        "fname": "first name",
        "mname": "middle name",
        "lname": "last name",
        "relationship": "parential relationship (mother, father or legal guardian)", 
        "phonenumber": "phone number"
   }
```

<h3 id="ebackground">Educational background</h3>

```json
   {
       "school_name": "school name",
       "start_date": "start date",
       "end_date": "end date",
       "gpa": "gpa in form of float"
   }
```

<h3 id="registration">Registration</h3>

```json
   {
        "year": "year (1st - 5th)",
        "semester": "semester (1st or 2nd)",
        "program": "program or department",
        "level": "BSC, Masters or Diploma",
        "status": "pending or verified",
        "registered_at": "registration date"
    }
```

<h3 id="payment">Payment</h3>

```json
   {
        "id": "id of the payment",
        "registration_id": "registration id",
        "amount": "amount",
        "paid_at": "paid date",
        "type": "manual or chapa",
        "status": "pending or verified",
        "receipt_url": "receipt url",
        "created_at": "created at",
        "updated_at": "updated at" 
   }
```

<h3 id="course">Course</h3>

```json
   {
        "title": "course title",
        "code": "course code",
        "year": "year (1st - 5th)",
        "semester": "semester (1st or 2nd)",
        "program": "program or department",
        "credit_hours": "credit hours in terms of integer"
   }
```
