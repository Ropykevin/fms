# UYOMA Farm Management System

A comprehensive web-based farm management system designed to streamline and automate farm operations, livestock management, and employee administration.

## 🌟 Features

### 1. Employee Management
- Add new employees with detailed information
- View complete employee list
- Delete employees with confirmation
- Employee search functionality
- Employee statistics and salary management

### 2. Livestock Management
- Add new livestock records
- Track animal details (ID, species, breed, gender, etc.)
- View complete livestock inventory
- Manage animal health records
- Track animal feeding schedules
- Monitor produce collection

### 3. Reporting System
- **Medical Reports**
  - Record animal health issues
  - Track treatments and medications
  - Monitor medical costs
  - View medical history

- **Feeding Reports**
  - Record feeding schedules
  - Track feed types and quantities
  - Monitor feeding costs
  - View feeding history

- **Produce Reports**
  - Record animal produce (milk, eggs, wool, etc.)
  - Track quantities and types
  - Monitor production statistics
  - View production history

### 4. Dashboard
- Real-time statistics
- Quick access to all modules
- Overview of farm operations
- Employee and livestock counts
- Report summaries

### Report Generation and Mailing System

The system includes an automated report generation and mailing system that can generate both weekly and monthly reports. These reports include:

#### Weekly Reports
- Feeding statistics (total reports, feed quantity)
- Medical records (total reports, medical costs)
- Produce data (total reports, produce quantity)

#### Monthly Reports
- Livestock overview (total livestock, species count)
- Feeding statistics (total reports, feed quantity, animals fed)
- Medical records (total reports, medical costs, animals treated)
- Produce data (total reports, produce quantity, animals producing)

#### Report Generation Process
1. Reports can be generated from the admin dashboard
2. Reports are automatically formatted in HTML
3. Reports are sent via email to the admin email address
4. The system uses PHPMailer for reliable email delivery

#### Email Configuration
The system uses PHPMailer with the following default settings:
- SMTP Host: localhost
- SMTP Port: 25
- Authentication: Disabled (for local Mercury Mail Server)
- TLS: Disabled (for local development)

To configure email settings:
1. Ensure Mercury Mail Server is running (for local development)
2. Admin email is retrieved from the `contact` table where name = 'Admin'
3. If no admin email is found, defaults to 'admin@farm.com'

#### Error Handling and Logging
- All report generation attempts are logged
- Email sending status is tracked
- Errors are logged to:
  - `logs/error.log`
  - `logs/php_errors.log`
  - `C:\xampp\php\logs\php_error.log`

#### Requirements
- PHP 7.4 or higher
- MySQL/MariaDB
- PHPMailer (installed via Composer)
- Mercury Mail Server (for local development)
- XAMPP (recommended for local development)

#### Installation
1. Clone the repository
2. Import the database schema from `fms.sql`
3. Install dependencies:
   ```bash
   composer install
   ```
4. Configure your web server (Apache recommended)
5. Ensure the `logs` directory is writable
6. Start Mercury Mail Server (for local development)

#### Troubleshooting
If reports are not being sent:
1. Check if Mercury Mail Server is running
2. Verify admin email in the `contact` table
3. Check error logs for specific issues
4. Ensure PHP has permission to send mail
5. Verify database connection settings

## 🛠️ Technical Stack

- **Frontend**
  - HTML5
  - CSS3 (Bootstrap 5.3.6)
  - JavaScript (jQuery 3.6.0)
  - Font Awesome 6.4.0
  - Google Fonts (IBM Plex Sans)

- **Backend**
  - PHP
  - MySQL Database
  - XAMPP Server

## 📋 Prerequisites

- XAMPP Server (Apache + MySQL)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

## 🚀 Installation

1. Clone the repository to your XAMPP htdocs directory:
   ```bash
   git clone https://github.com/yourusername/Farm-Management-System.git
   ```

2. Start XAMPP Server:
   - Start Apache
   - Start MySQL

3. Create Database:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named "fms"
   - Import the database schema (if provided)

4. Configure Database Connection:
   - Open database connection files
   - Update credentials if needed (default: localhost, root, "")

5. Access the Application:
   - Open your browser
   - Navigate to: http://localhost/Farm-Management-System

## 📁 Project Structure

```
Farm-Management-System/
├── admin-panel1.php      # Main admin interface
├── add_livestock.php     # Livestock management
├── add_medical.php       # Medical report handling
├── add_produce.php       # Produce report handling
├── add_feeding.php       # Feeding report handling
├── css/                  # Stylesheets
├── js/                   # JavaScript files
├── plugins/             # Third-party plugins
└── README.md            # Project documentation
```

## 🔒 Security Features

- Input validation and sanitization
- SQL injection prevention
- XSS protection
- Secure password handling
- Session management
- Access control

## 💻 Usage

### Admin Panel
1. Login to the admin panel
2. Navigate through the sidebar menu
3. Access different modules:
   - Dashboard
   - Employee Management
   - Livestock Management
   - Reports
   - Queries

### Adding Records
1. Click the respective "Add New" button
2. Fill in the required information
3. Submit the form
4. View confirmation message

### Managing Records
1. View records in respective tables
2. Use action buttons for:
   - Viewing details
   - Editing records
   - Deleting records

## 📊 Database Schema

### Main Tables
- `emptb` - Employee information
- `livestock` - Livestock records
- `medical_report` - Medical reports
- `feeding_report` - Feeding records
- `produce_report` - Produce records

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👥 Authors

- Ropy Kevin - Software  Developer

## 🙏 Acknowledgments

- XAMPP Development Team
- Bootstrap Team
- Font Awesome Team
- All contributors and supporters

## 📞 Support

For support, please contact:
- Email: ropykevin@gmail.com
- Issue Tracker: GitHub Issues

---

Made with ❤️ for Farm Management

## Prerequisites
1. Install XAMPP web server
2. Any Editor (Preferably VS Code or Sublime Text)
3. Any web browser with latest version

## Languages and Technologies used
1. HTML5/CSS3
2. JavaScript (to create dynamically updating content)
3. Bootstrap (An HTML, CSS, and JS library)
4. XAMPP (A web server by Apache Friends)
5. Php
6. MySQL (An RDBMS that uses SQL)
7. TCPDF (to generate PDFs)

## Steps to run the project in your machine
1. Download and install XAMPP in your machine
2. Clone or download the repository
3. Extract all the files and move it to the 'htdocs' folder of your XAMPP directory.
4. Start the Apache and Mysql in your XAMPP control panel.
5. Open your web browser and type 'localhost/phpmyadmin'
6. In phpmyadmin page, create a new database from the left panel and name it as 'fms'
7. Import the file 'fms.sql' inside your newly created database and click ok.
8. Open a new tab and type 'localhost/foldername' in the url of your browser
9. Hurray! That's it!
    
### SOFTWARES USED
  - XAMPP was installed on the Ubuntu 19.04 machine and APACHE2 Server and MySQL were initialized. And, files were built inside opt/lampp/htdocs/fms
  - Sublime Text 3.2 was used as a text editor.
  - Google Chrome Version 77.0.3865.90 was used to run the project (localhost/fms was used as the url).
  

### Starting Apache And MySQL in XAMPP:
  The XAMPP Control Panel allows you to manually start and stop Apache and MySQL. To start Apache or MySQL manually, click the 'Start' button under 'Actions'.

## GETTING INTO THE PROJECT:
Farm Management System in php and mysql. This system has a 'Home' page from where the user, employee & administrator can login into their accounts by toggling the tabs accordingly. Fig 1.1 shows the 'Home' page of our project.

![home](https://user-images.githubusercontent.com/117649821/218290821-80ff14eb-afe4-4f07-8102-44e2e272a558.png)

'About Us' page (Fig 1.2)  allows us to get some more information about the quality and the services of the hospital.

![about](https://user-images.githubusercontent.com/117649821/218290889-45d32ed4-a1b7-4d22-8a97-3896ca2fdddb.png)

'Contact' page allows users to provide feedback or queries about the services of the hospital. Fig 1.3 shows the 'Contact' page.

![contact](https://user-images.githubusercontent.com/117649821/218290928-44fa0bd3-ef06-48b6-8d3b-c1ff696baa9f.png)

The 'Home' page consists of 3 modules:
1. User Module
2. Employee Module
3. Admin Module

### User Module:

  &nbsp; &nbsp; &nbsp; This module allows Users to create their account and to see details about plant, medicines & method.
  The registration page(in the home page itself) asks users to enter their First Name, Last Name, Email ID, Contact Number, Password and radio buttons to select their gender.(Fig 1.4).
  
![userpage](https://user-images.githubusercontent.com/117649821/218290959-33758287-8349-4393-ba22-7f49fc176713.png)

Once the user has created his/her own account after clicking the 'Register' button, then he will be redirected to his/her Dashboard(Fig 1.5).
![userhome](https://user-images.githubusercontent.com/117649821/218290967-db82a7ab-7112-47d5-a6ce-31b6a08341de.png)

The Dashboard page allows users to perform three operations:

**1. View users' Plant details:**

  &nbsp; &nbsp; &nbsp; Here, the user can see the plant details.(See Fig 1.6).

![userp](https://user-images.githubusercontent.com/117649821/218290984-66301794-da08-4571-89e6-476de84ac552.png)

**2. View users' Medicine details:**

  &nbsp; &nbsp; &nbsp; Here, the user can see the medicine details.(See Fig 1.7).
  ![usermd](https://user-images.githubusercontent.com/117649821/218291029-81b4ef33-8fa3-4b3e-b697-61e11904edc7.png)

  
**3. View users' Methods details:**

  &nbsp; &nbsp; &nbsp; Here, the user can see the method details.(See Fig 1.8).
  ![usermt](https://user-images.githubusercontent.com/117649821/218291042-d1fc4427-c0c6-4010-8467-02eea1bc7266.png)


Once the user has logged out of his account, if he wants to go into his account again, he can login his account, instead of register his account again. Fig 1.9 shows the login page.
Clicking on 'Login' button will redirect the user to his dashboard page which we have seen earlier (Fig 1.5)

![userlogin](https://user-images.githubusercontent.com/117649821/218290997-f3720b87-fe39-4952-b60c-344d529947e9.png)

This is how the user module works. On the whole, this module allows users to register their account or login their account(if he/she has one) and to view plant , medicines & methods details.

### Employee Module:

  &nbsp; &nbsp; &nbsp; The employee can login into their account which can be done by toggling the tab from 'User' to 'Employee'. Fig 1.10 shows the login form for a employee. Registration of a employee account can be done only by admin. We will discuss more about this in Admin Module.
  
![emplogin](https://user-images.githubusercontent.com/117649821/218291054-0dccc55b-839d-4078-82df-de71464ec61f.png)

Once the employee clicking the 'Login' button, they will be redirected to their own dashboard which is shown in Fig 1.11

![emphome](https://user-images.githubusercontent.com/117649821/218291056-d6db4245-cb97-4097-8025-4c89797ac4b0.png)

In this page, employee can able to add details about plant, medicines and methods and to can view those details. 
**1. Add Plants:**

  &nbsp; &nbsp; &nbsp; Employee alone can add a new plant. This form asks plant id, name, soil type.(See Fig 1.12)
  ![empap](https://user-images.githubusercontent.com/117649821/218301179-e29e6aed-7973-4afc-ad57-25901563718f.png)

**2. Add Medicines:**

  &nbsp; &nbsp; &nbsp; Employee can add a new medicine. This form asks medicine id, name, type and cost.(See Fig 1.13)
![empamd](https://user-images.githubusercontent.com/117649821/218301192-1783edb9-33f2-49e7-b8dc-37fca8833fe2.png)

**3. Add Method:**

  &nbsp; &nbsp; &nbsp; Employee alone can add a new Method. This form asks method id, name, type.(See Fig 1.14)
![empamt](https://user-images.githubusercontent.com/117649821/218301206-409bb8cf-c85d-4dba-a642-ec0031bf5428.png)

&nbsp; &nbsp; &nbsp; Once everything is done, the employee can logout of their account. Thus, in general, a employee can login into his/her account, add details about plants, medicines and methods and to view them. This is all about Employee Module.


### Admin Module:
   
   &nbsp; &nbsp; &nbsp; This module is the heart of our project where an admin can see the list of all patients.Employee, Pants, Medicines, Methods and the feedback/queries received from the 'Contact' page. Also admin can add employee too. 
  &nbsp; &nbsp; &nbsp; Login into admin account can be done by toggling into admin tab of the Home page. Fig 1.15 shows the login page for admin.
  &nbsp; &nbsp; &nbsp; `username`: admin, `password`: admin123

![adminlogin](https://user-images.githubusercontent.com/117649821/218291068-6ef400db-2593-4e1a-8354-23ba0410036f.png)

On clicking the 'Login' button, the admin will be redirected to his/her dashboard as shown in 
Fig 1.16.

![adminhome](https://user-images.githubusercontent.com/117649821/218291077-911aaf8b-087a-4585-ac4f-7406ead2a803.png)


This module allows admin to perform five major operations:

**1. View the list of all users registered:**

  &nbsp; &nbsp; &nbsp; Admin can able to view all the users registered. This includes the users' First Name, Last Name, Email ID, Contact Number and Password. (See Fig 1.17).As like in employee module, admin can also search for a user by their contact number in the search box.
![adminud](https://user-images.githubusercontent.com/117649821/218291093-53aa5c7b-138b-4d9b-b810-b63060ff8673.png)

**2. View the list of all employees registered:**

  &nbsp; &nbsp; &nbsp; Details of the doctors can also be viewed by the admin. This details include the Name of the employee, Password, Email and Consultancy fees, shown in Fig 1.18. Searching for a employee can be done by using the employee's Email ID in the search box.
![admined](https://user-images.githubusercontent.com/117649821/218291104-968e2a6d-5762-49a9-b744-e3003710da33.png)

**3. View the Plant lists:**

  &nbsp; &nbsp; &nbsp; Admin can also able to see the entire details of the plants. This includes the Plant id, name, soil type. (See Fig 1.19). 

  ![adminp](https://user-images.githubusercontent.com/117649821/218291116-e8a4a485-3d89-49c0-a2d4-54cb6bc5cb27.png)
  
**4. View the Medicine lists:**

  &nbsp; &nbsp; &nbsp; Admin can also able to see the entire details of the medicines(See Fig 1.20). 
  ![adminmd](https://user-images.githubusercontent.com/117649821/218291176-3bf4e453-ce7a-4a7f-936e-80e9e124f608.png)

**5. View the Method lists:**

  &nbsp; &nbsp; &nbsp; Admin can also able to see the entire details of the methods(See Fig 1.21). 
![adminmt](https://user-images.githubusercontent.com/117649821/218291184-b954e999-bf47-4270-91a6-8f0133575d3d.png)

**6. Add Employee:**

  &nbsp; &nbsp; &nbsp; Admin alone can add a new employee since anyone can register as a employee if we put this section on the home page. This form asks employee's Name, Email ID, Password and his/her salary.(See Fig 1.22)
  ![adminae](https://user-images.githubusercontent.com/117649821/218291192-27bd1303-a2e4-4781-bfef-481f442b4ffa.png)
  
**7. Remove Employee by Admin

&nbsp; &nbsp; &nbsp; Admin can also delete the employees from the system. This let admin to have more control over the system.(See Fig 1.23)
![adminde](https://user-images.githubusercontent.com/117649821/218291202-087a1d1f-1cdb-42fe-9ffe-c5bc7e059bcd.png)

**8. View User's feedback/Queries:**

  &nbsp; &nbsp; &nbsp; Admin is allowed to view the feedback/Query that has been given by the user in the 'Contact' page (Refer Fig 1.3). This includes User's Name, Email Id, Contact Number and the message(Feedback/ Query) as shown in the Fig 1.24.
  
![adminq](https://user-images.githubusercontent.com/117649821/218291206-9680943d-3bf7-487d-b1a7-6704b83c2511.png)

  &nbsp; &nbsp; &nbsp; Taking everything into consideration, admin can able to view the details of users and employees, plant, medicines, method details, Feedback by the user and can add a new employee. Once everything is done, the admin can logout from his account.


