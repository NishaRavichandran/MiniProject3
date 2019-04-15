# Final Project

# Laravel FAQ

A Question and Answers web-app built using Laravel.
Check out the live-demo at: 
http://is601mp3.herokuapp.com/


## Setup
1.	Clone the code from github using https://github.com/NishaRavichandran/MiniProject3.git 
2.	Install Composer
3.	Rename the .env file 
4.	Setup the database with sqlite
5.	Copy path of sqlite and change .env file for the database
6.	Run php artisan key:generate to generate the key
7.	Run php artisan migrate:refresh to setup the database
8.	Done!

## Epic 1
The feature allows only the authorized users should be able to edit/delete questions and answers.


## User Story
1. As a user, only I should be able to edit my questions, so that other users will not be able to edit.
2. As a user, only I should be able to delete my questions, so that other users will not be able to delete.
3. As a user, only I should be able to edit my answers, so that other users will not be able to edit.
4. As a user, only I should be able to delete my answers, so that other users will not be able to delete.

## Epic 2
A voting feature is added for questions/answers.

## User Story
1.	As a User, I should be able to Upvote for questions, so that I can judge whether the question was good/meaningful.
2.	As a User, I should be able to Downvote for questions, so that I can judge/understand whether the question was helpful.
3.	As a User, I should be able to Upvote for answers, so that I can judge whether the answer was helpful/good/meaningful/relevant.
4.	As a User, I should be able to Upvote for answers, so that I can judge whether the answer was irrelevant.
5.	As a User, I should be able to sort the questions, so that I can view the top-rated questions first.

## Features
1.	Asking questions
2.	Posting answers
3.	Very basic user registration and login

## New Features Added
1.	All questions and answers added by users of the web-app can be viewed by everyone.
2.	Questions sorted based on the recently posted
3.	Added created by option for questions/answers which displays name/mailId of user
4.	Voting up/down for questions
5.	Voting up/down for answers
6.	Questions sorted based on votes(upvote-downvote=results)
7.	Able to edit only the question added by the user
8.	Able to edit only the answer added by the user
9.	Not able to edit the question added by other users
10.	Not able to edit the answers added by other users
