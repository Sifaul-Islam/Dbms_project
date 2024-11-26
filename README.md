# Know Your Grass

## Project Overview

**Know Your Grass** is a web-based application designed to provide full traceability for agricultural products throughout the supply chain. This project enables stakeholders to monitor and manage products at every stage, ensuring quality and safety standards are met consistently.

### Key Features:

1. **Detailed Product Records (Agricultural Officer)**
   - Record detailed information for each product, including origin, variety, harvest date, and relevant certifications (e.g., organic).

2. **Supply Chain Tracking (All Stakeholders)**
   - Track every stage in the supply chain with timestamps and location data, including processing, storage, distribution, and retail points.

3. **Unique Identifiers for Tracking (Warehouse Manager, Distributor)**
   - Assign unique identifiers (e.g., lot numbers, barcodes) to individual batches or items to ensure precise tracking.

4. **Temperature and Humidity Monitoring (Warehouse Manager, Distributor)**
   - Maintain and record temperature and humidity data to monitor storage and transportation conditions.

5. **Quality Control Checks (Food Safety Officer)**
   - Record quality control checks and inspection results at every stage of the product journey, including post-production, cold storage, distribution, and marketplace.

6. **Incident Management System (Agricultural Officer, Warehouse Manager, Distributor)**
   - Implement a system to manage affected products efficiently by identifying affected batches and their distribution points.

## Technologies Used

- **Frontend**: Bootstrap for responsive UI and user experience.
- **Backend**:  PHP for server-side scripting and logic implementation.
- **Database**: MySQL for storing product, supply chain, and quality control data.



## Setup Instructions

1. **Prerequisites**:
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Apache HTTP Server

2. **Installation**:
   - Clone the repository:
     ```sh
     git clone https://github.com/Sifaul-Islam/Dbms_project.git
     ```
   - Navigate to the project directory and configure the database:
     - Import the `know_your_grass.sql` file into your MySQL server.
   - Update database credentials in `config.php`.

3. **Running the Application**:
   - Start Apache and MySQL servers.
   - Open the application in your browser at `http://localhost/know-your-grass`.