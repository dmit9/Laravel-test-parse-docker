
Brief description of the service:

"The price parsing service is designed to process data from external resources. The user initiates parsing by clicking a button on the web page. 
The Laravel controller passes the request to the ParseService service, which processes the data via HTTP requests to external URLs. 
The processed data is saved in the database and returned to the user's page for display. The service supports queuing tasks to improve performance."


1. Price parsing service
   Description of work:

The user clicks the "Get Price" button.
The browser sends a request to the controller via Laravel routing.
The controller calls the ParseService service, which:
Receives a list of users.
For each user, parses data from external links.
Saves updated data to the database.
After parsing is complete, the data is returned to the user and displayed on the page.

2.1 Data flow diagram:
   [User]
   ↓
   HTTP request (button click)
   ↓
   [Laravel controller]
   ↓
   [ParseService]
   ↓
   [Parsing external data via Guzzle/Curl]
   ↓
   [Database (saving results)]
   ↓
   [Controller sends response]
   ↓
   [User sees updates on page]

2.2 Architecture diagram
System components:

Frontend (HTML/JS): Sends requests via Ajax.
Backend (Laravel):
Controllers process requests.
ParseService parses and processes data.
Database: Stores information about users and parsing results.
Architecture example:

css
Copy code
[Frontend]
↓
HTTP request
↓
[Controller (Laravel)]
↓
[Service (ParseService)]
↓
[Database]

3. Sequence diagram
   Example (when clicking the "Get Price" button):

The user clicks the button.
The controller calls the ParseService service.
ParseService parses data from external URLs.
The data is saved in the database.
The controller returns a response with updated data.
