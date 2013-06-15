1520-project1
=============

CS 1520 Programming Languages for Web Applications
Assignment 1
 
Online: Tuesday, May 28, 2013
 
What is due: All of your .php files stored in your Unixs csweb/assig1 directory (with permissions set as indicated in acl-perms.html). You must also submit a .zip file containing all of your .php and data files plus an index.html file to the CS 1520 Submission site (see submit.html for details), with the following requirements:
-    All pertinent grading information for the TA is on the index.html page – i.e. it is an Assignment Information Sheet for the project containing file, execution and extra credit information. Make sure to include in this sheet the AFS Path to all of your files.
-    Your index.html file must also contain a link (url) to your program start page (at your csweb/assig1 directory), clearly labeled.
The idea is the following:
-    To grade your project your TA will go to the submission directory for the assignment, and in the directory for your id he will find your .zip file.
-    He will unzip your file, find the index.html file and open it in his browser.
-    He will then read your pertinent submission information, and then click on the http link to your actual program, which is located in your AFS csweb/php directory.
-    He will then test your program to make sure it runs correctly
-    To look at your code, he will look at your submitted .php files, but he may also go to your csweb/assig1 directory directly, so make sure the permissions are set properly and make sure you provide the complete AFS path to your files.
 
When it is due: Tuesday, June 11, 2013, by 11:59PM.
Late Due Date: Thursday, June 13, 2013 by 11:59PM
Important Note: NO PROGRAM FILES in your csweb/assig1 directory should be modified after the submission deadlines! If you need to use those files for something (ex: a subsequent assignment), COPY THEM INTO A DIFFERENT DIRECTORY.
 
 
Goal: To utilize the PHP language in an interesting and useful way and to use PHP in conjunction with flat files, forms and sessions.
 
General Idea:
You will implement a simple web-based Computer Science advising program. Your program will have the following features:
1)    Any user must log into the site in order to use it (see details about the login process below). Authorized users will be pre-established and stored in a text file called "users.txt". See below for details of the file format.
2)    When a student (i.e. advisee) logs into the site he/she will be all shown the following:
a)     A list of all courses he / she has taken, with grades, shown term by term
b)     A list of all courses he / she has taken, with grades, shown in alphabetical order by department and in numerical order within a department. For example, if the student has taken MATH 0230, MATH 0220, CS 0445, CS 1501, CS 0401, CHEM 0120 and BIOSC 0160, the resulting order should be:
BIOSC 0160, CHEM 0120, CS 0401, CS 0445, CS 1501, MATH 0220, MATH 0230
c)     A list of all of the CS graduation requirements with one of two indicators for each requirement:
i)      N – requirement is Not satisfied
ii)    S [Course] [Term] [Grade] – requirements is Satisftied by the indicated course in the indicated term with the indicated grade. Note that all requirements must be satisfied with a grade of C or better. Any grades of C- or lower cannot satisfy any requirements. See below for details on the CS graduation requirements.
Note that a student may repeat a course so a given course may appear more than once on a student's record. In this case the most recent occurrence should be counted. All a student can do in the system is view this main page so after showing it the only option shown to him / her should be to logout of the system.
3)    When an advisor logs into the site he/she will initially be shown a page in which he / she can look up an individual advisee. The look up can be done in one of two ways: 1) Peoplesoft ID number, 2) Last Name and First Name. (Note: For now you may assume that there are no students who have identical last and first names. However, in a real system this could occur and must be handled).
 
Once a student has been found, the advisor should see the same information shown to the student in 2) above. Below it he / she should also see the following options:
i)      Log advising session – this option will add a timestamp entry to a file indicating the date and time of this student's current advising session. See below for file format details.
ii)    Show advising sessions – this option will show a list of previous advising sessions for this student, ordered from most recent to least recent.
iii)   Add advising notes – this option will allow the advisor to enter text comments about the advising session that can be retrieved at a later time for review. See below for file format details.
iv)   Review advising notes – this option will show a list of advising note timestamps, ordered from most recent to least recent. Also shown will be a radiobutton for each timestamp, so that the advisor may select one of them. When a timestamp is selected and submitted, the advisor will see the comments associated with that timestamp.
4)    All pages on the site should be shown in a nicely formatted, easily navigable fashion. The exact formatting is up to you but part of your grade will be based on the presentation of your site. You do not have to use CSS for this assignment – more important than the specific fonts and colors is the layout and logical structure of the site. This includes issues like getting from one page to another, presenting information in a clear, readable fashion and easily getting back to a previous page or the home page for the user.
5)    A logout button is required for the site. Once a user logs out (or closes his browser), he/she must log in again before being granted access to any of the pages of the site. If a user tries to access any part of the site without logging in, he/she should be directed to the login page.
 
File Formats:
You will be using 5 specifically named text files with your program. Each is explained below:
users.txt: All authorized users will be stored in this file. The file will have one line per authorized user, formatted as follows:
UserID:Password:PSID:Email:LastName:FirstName:Access_Level
where Access_Level will be either 0 or 1. Advisees will have Access_Level 0 and advisors will have Access_Level 1. This file cannot be altered by the program – it is read-only. The idea is that the system administrator must be the one to update this file (more on that in Assignment 2). The UserID is the login id for the user (ex: your Pitt Network ID) and the PSID is the Peoplesoft ID. Note that due to the somewhat primitive way we are storing this information, no field may have the colon character in it. We may eliminate this restriction in a future assignment.
 
courses.txt: This file will have one line per instance of a course being taken by a student. The format will be as follows:
Dept:Number:Term:PSID:Grade
Where Dept is the department offering the course, Number is the course number, Term is the academic term in which the course was taken, PSID is the Peoplesoft ID of the student who took the course, and Grade is the grade earned for the course. Note that any of the fields above can appear any number of times in the file (since many students can take a course and a student can take many courses).
 
reqs.txt: This file will have one line per CS major graduation requirement. The format will be as follows:
Req:Dept1,Number1|Dept2,Number2|...|DeptN,NumberN
where each comma separated pair is a course that satisfies the requirement.
 
notes.txt: This file will keep track of the notes files for students generated during given advising sessions. It will be formatted as follows:
PSID:DateTime
where PSID is a student's Peoplesoft ID and DateTime is a string form of the date and time on which the notes where taken. Each entry in the notes.txt file will correspond to a file within the subdirectory notes stored on the server. For example, if notes.txt contains the following two entries:
1234567:2013-05-23-14-25-32
7654321:2013-04-29-10-46-15
it indicates that a notes file for ID 1234567 generated on May 23, 2013 at 2:25:32PM will be stored in the notes directory under file name 1234567:2013-05-23-14-25-32.txt and similarly a notes file for ID 76543321 generated on April 29, 2013 at 10:46:15AM will be stored in the notes directory under file name 7654321:2013-04-29-10-46-15.txt.
 
sessions.txt: This file will keep track of the session logs for students generated by advisors advising sessions. It will be formatted as follows:
PSID:DateTime
where PSID is a student's Peoplesoft ID and DateTime is a string form of the date and time on which the log was generated. Note that this is the same format as the notes.txt file. However, in this case, the timestamp stands on its own – it is not used to access any other file.
Your program should work with arbitrary data files, given that they are formatted correctly. However, I have supplied some test files for you to use. See Assignment 1 on the CS 1520 Web site.
 
Logging In:
On the Login Page you should initially show the user a form with a text field for the user id and a password field for the password. You should also include a checkbox or hyperlink with a "Forgot Password" option. The logic of logging in should be as follows:
1)    For normal login, the user enters his/her user id and password and submits. The users.txt file is then searched. If the user id cannot be found or was not entered, return the login page with a note to that effect [unknown user]. If the user id is found but the password is not, return the login page with a note to that effect [incorrect password]. If the user id and password both match, check the access and return the appropriate page (either student or advisor).
2)    If the user selects the "Forgot Password" checkbox, look up the user id in the "users.txt" file. If the user id is not found, return the login page with a note to that effect. If the user id is found, send an email to the email address associated with that user containing the listed password, and return the login page with a note such as "Please check your email for the password and then try again". Note that if the user id is not found there is nothing you can do to help the user, since the program does not have the ability to add new users to the "users.txt" file.
 
Details, Requirements and Hints:
Your program must be implemented using one or more PHP scripts. State must be kept using sessions and using the files described above. Note that we are not doing heavy security here – secure communication is not used. For this assignment I am more concerned with your learning PHP and how forms and session tracking can be implemented with it. For help with PHP see the course notes, Sebesta text and php.net web site (including the manual). You may also need some help with HTML, especially with the forms and various input fields. Besides your Sebesta text, you may also want to look at the W3.org HTML site:
http://www.w3.org/TR/html51/
and, in particular, the page on forms:
http://www.w3.org/TR/html51/forms.html#forms
Also of help may be the w3schools site:
http://www.w3schools.com/html/html5_intro.asp
 
Extra Credit Ideas:
-    If you have any ideas for extra credit, run them by me and I'll let you know if they will count or not. The most possible points allowed for extra credit is 10 points, but any single item will not guarantee the full 10 points. Below are two possibilities:
1)  Use cookies to recognize repeat users (and expedite the login process). Store a given user's id in a cookie so that for future logins the user will only have to enter his/her password (up to 5 points)
2)  Use CSS and / or other formatting to improve the appearance of your pages (up to 5 points)
