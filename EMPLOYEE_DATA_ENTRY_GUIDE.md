# EMPLOYEE DATA ENTRY GUIDE - UYOMA FARM MANAGEMENT SYSTEM

## Overview
This guide explains how to add various types of data to the Farm Management System from the employee panel.

## Login
1. Go to the main login page
2. Select the "Employee" tab
3. Enter your credentials:
   - Username: `employee1`
   - Password: `emp123`

## Available Data Entry Functions

### 1. Adding New Livestock
**Location:** Click on "Add Livestock" in the left sidebar

**Required Fields:**
- **Species:** Select from dropdown (Cow, Goat, Sheep, Pig, Chicken, Duck, Turkey, Other)
- **Breed:** Enter the specific breed (e.g., Holstein, Nubian, etc.)
- **Gender:** Select Male or Female
- **Date of Birth:** Select the birth date
- **Weight (kg):** Enter current weight (must be positive)
- **Ear Tag:** Enter unique identification tag (auto-generated if left empty)
- **Notes:** Optional additional information

**Tips:**
- Ear tags are automatically generated if left empty
- Weight must be a positive number
- All fields are required except Notes

### 2. Adding Feeding Records
**Location:** Click on "Add Feeding Record" in the left sidebar

**Required Fields:**
- **Animal:** Select from dropdown (shows species, breed, ID, and ear tag)
- **Feeding Date:** Select the date of feeding
- **Feed Type:** Enter the type of feed (e.g., Hay, Grain, Pellets)
- **Quantity:** Enter amount fed (must be positive)
- **Remarks:** Optional notes about the feeding

**Tips:**
- Only animals already in the system will appear in the dropdown
- Quantity must be a positive number
- Date defaults to today if not changed

### 3. Adding Medical Reports
**Location:** Click on "Add Medical Report" in the left sidebar

**Required Fields:**
- **Animal:** Select from dropdown
- **Report Date:** Select the date of medical examination
- **Diagnosis:** Enter the medical condition diagnosed
- **Treatment:** Enter the treatment given
- **Medicine:** Enter medications prescribed
- **Cost:** Enter treatment cost (must be non-negative)
- **Vet Name:** Enter veterinarian's name
- **Remarks:** Optional additional notes

**Tips:**
- Cost can be zero but cannot be negative
- All medical information should be accurate and detailed

### 4. Adding Produce Records
**Location:** Click on "Add Produce Record" in the left sidebar

**Required Fields:**
- **Animal:** Select from dropdown
- **Report Date:** Select the date of production
- **Produce Type:** Enter type of produce (e.g., Milk, Eggs, Wool)
- **Quantity:** Enter amount produced (must be positive)
- **Remarks:** Optional notes about production

**Tips:**
- Quantity must be a positive number
- Common produce types: Milk, Eggs, Wool, Meat, Honey

### 5. Deleting Livestock
**Location:** Click on "Delete Livestock" in the left sidebar

**Required Fields:**
- **Ear Tag:** Enter the ear tag of the animal to delete

**Warning:** This action cannot be undone. Make sure you have the correct ear tag.

## Viewing Data

### Viewing Livestock List
- Click on "Livestock" in the left sidebar
- View all animals in the system with their details

### Viewing Feeding Records
- Click on "Feeding Records" in the left sidebar
- View all feeding history

### Viewing Medical Reports
- Click on "Medical Reports" in the left sidebar
- View all medical history

### Viewing Produce Reports
- Click on "Produce Reports" in the left sidebar
- View all production history

## Form Validation Features

### Automatic Validation
- **Weight:** Must be positive
- **Quantity:** Must be positive
- **Cost:** Must be non-negative
- **Dates:** Default to today if not specified
- **Ear Tags:** Auto-generated if left empty

### Visual Feedback
- Invalid fields are highlighted in red
- Error messages appear below invalid fields
- Success messages appear after successful submissions

## Best Practices

### Data Entry
1. **Accuracy:** Double-check all information before submitting
2. **Completeness:** Fill in all required fields
3. **Consistency:** Use consistent naming conventions
4. **Timeliness:** Enter data as soon as possible after events

### Livestock Management
1. **Unique Ear Tags:** Ensure each animal has a unique ear tag
2. **Regular Updates:** Update weight and health information regularly
3. **Detailed Notes:** Include relevant details in notes fields

### Record Keeping
1. **Daily Records:** Enter feeding and produce records daily
2. **Medical Tracking:** Record all medical events immediately
3. **Documentation:** Keep detailed notes for future reference

## Troubleshooting

### Common Issues
1. **Form won't submit:** Check that all required fields are filled
2. **Invalid data errors:** Ensure numbers are positive where required
3. **Animal not in dropdown:** Animal must be added to livestock first
4. **Date issues:** Use the date picker for consistent formatting

### Getting Help
- Contact your system administrator for technical issues
- Refer to this guide for common procedures
- Check the dashboard for system status

## Security Notes
- Always log out when finished
- Don't share your login credentials
- Report any suspicious activity to your supervisor 