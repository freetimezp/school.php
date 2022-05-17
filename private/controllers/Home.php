<?php

class Home extends Controller
{
    function index()
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $this->view('home');
    }
}

/*
 School
php - js - css - html
bootstrap - font awesome - mpdf
Login \ Logout
Registration
Validation
Error notification

Rank(permission) system (from super_admin to student)
Design - on my own
Use MVC

Schools
Create, edit, delete school
Switch between schools

Staff \ main users of site
Users for each school (lecturer, student, reception etc.)
Create, edit, delete user
Search users
Profile user

Students
have no permission for schools
have no permission for staff
Create, edit, delete student
Search students
Student see classes they belong

Search tests
Student see new test notification
Student can take the test and gave answers
When give answers - you can see percentage of all answered questions and can save you answers,
after you must click submit button for lecturer see you test
Student can not save test for second time (only view his answers)

Lecturer see notification if students submitted test
Lecturer can open student test
Lecturer can unsubmit student test back to student if number of answered question is very low..
Lecturer can use automark button for all test (to mark most of questions)
Lecturer can add marks for test (correct answers or not)
Lecturer see percentage of answered and marked questions
Lecturer can set test as marked - than student can see his mark in own profile
Lecturer can save marked test as pdf file


Classes
Class you can add for each school
Create, edit, delete class
Search classes
In class you can add lecturer to each class or remove
In class you can add students to each class or remove
In class you can add tests to each class or remove

Tests
Create, edit, delete tests
Enabled or disabled test (publish)
In view of test you can see score of students submitted test
You can also add questions to test (multiple, objective, subjective) with image or not, add correct answer for future
marking

Questions
Create, edit, delete

Years
You choose earlier year for display old content

 */


