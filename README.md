Create a simple subscription platform(only RESTful APIs with MySQL) in which users can subscribe to a website (there can be multiple websites in the system). Whenever a new post is published on a particular website, all it's subscribers shall receive an email with the post title and description in it. (no authentication of any kind is required)

MUST:-
- Use PHP 7.* or 8.* 
- Write migrations for the required tables.
- Endpoint to create a "post" for a "particular website".
- Endpoint to make a user subscribe to a "particular website" with all the tiny validations included in it.
- Use of command to send email to the subscribers (command must check all websites and send all new posts to subscribers which haven't been sent yet).
- Use of queues to schedule sending in background.
- No duplicate stories should get sent to subscribers.
- Deploy the code on a public github repository.

OPTIONAL:-
- Seeded data of the websites.
- Open API documentation (or) Postman collection demonstrating available APIs & their usage.
- Use of contracts & services.
- Use of caching wherever applicable.
- Use of events/listeners.


** POSTMAN URL COLLECTION **
https://red-crater-868887.postman.co/workspace/My-Workspace~59c872c6-3a90-4b42-81b4-b149874d8962/collection/16273481-2e3efa9c-6b7b-47f5-bdca-8d3fb296186a?action=share&creator=16273481

**COMMAND TO SEND EMAIL NOTIFICATION **
- To send email notifications to subscribers about new posts, run the following Artisan command:
RUN:  **php artisan posts:send-new**
This command:
- Checks all websites for new posts that haven't been sent to subscribers yet.
- Dispatches queued jobs to send emails with the post title and description.
- Prevents duplicate emails from being sent.

NB!
- Make sure to run the queue worker in the background to process the email jobs:
 **php artisan queue:work**
